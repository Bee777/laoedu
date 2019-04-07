import Vuex from 'vuex'
import Vue from 'vue'
import $utils from '@vue/utilities.js'
import {crypter} from '@vue/encryter.js'
import debounce from 'lodash/debounce'

/*** @DataSpecific Init ***/
let encrypter = crypter(), cipter, decipher, jsEncode = encrypter.jsEncode;
let salt = "GdONzBMZ7jKO8JJ8vAr2nvVAXDO324dxnDykMyoteWEpvJ4W9ct9mPWUyn6H";//change you want
/*** @DataSpecific Init ***/

/*** @VueExport Init ***/
export function createInit() {
    Vue.use(global.default); //vue toasted
    Vue.prototype.s = settings;//get setting variable from html file
    Vue.prototype.baseUrl = baseUrl;
    Vue.prototype.$utils = $utils;
    Vue.use(Vuex);
    Vue.prototype.jq = $;
    Vue.prototype.debounce = debounce;
    //check if slot exists
    Vue.prototype.hasSlot = function (name = 'default') {
        return !!this.$slots[name] || !!this.$scopedSlots[name];
    };
    cipter = encrypter.cipher(salt);
    decipher = encrypter.decipher(salt);
    return {Vue, Vuex, $utils, debounce, initRouter, cipter, decipher, jsEncode};
}

/*** @EndVueExport Init ***/

/*** @VueEvent ***/
Vue.prototype.Event = new class {
    constructor() {
        this.vue = new Vue();
    }

    fire(name, data = null) {
        this.vue.$emit(name, data);
    }

    listen(name, callback) {
        this.vue.$on(name, callback);
    }

    listenOnce(name, callback) {
        this.vue.$once(name, callback);
    }

    offListen(name, callback) {
        this.vue.$off(name, callback);
    }

    loadingState() {
        return {
            ActiveLoading: {active: true, loading: true},
            ActiveNotLoading: {active: true, loading: false},
            NorActiveLoading: {active: false, loading: false},
        }
    }
};
/*** @EndVueEvent ***/

/*** @VueRouter Init ***/
const hasActiveApp = (r, n) => {
    return r.resolve({name: n}).resolved.matched.length > 0;
};

const initRouter = (router, store) => {
    return {
        Route(options = {}, delay = null) {
            if (delay !== null) {
                setTimeout((e) => {
                    router.push({name: options.name, path: options.path, params: options.params, query: options.query})
                }, delay)
            } else {
                router.push({name: options.name, path: options.path, params: options.params, query: options.query})
            }
        },
        StartRouteGuard() {
            router.beforeEach((to, from, next) => {
                // clear global messages.
                store.commit('setClearMsg');
                if (to.matched.some(record => record.meta.requiresAuth)) {
                    // this route requires auth, check if logged in
                    // if not, redirect to login page.
                    if (!store.getters.LoggedIn) {
                        if (hasActiveApp(router, 'login')) {
                            next({
                                name: 'login',
                            })
                        } else {
                            $utils.Location('/login');
                        }
                    } else {
                        next()
                    }
                } else if (to.matched.some(record => record.meta.requiresVisitor)) {
                    if (store.getters.LoggedIn) {
                        if (hasActiveApp(router, to.meta.redirect)) {
                            next({name: to.meta.redirect})
                        } else {
                            $utils.Location(to.meta.path);
                        }
                    } else {
                        next()
                    }
                } else {
                    next() // make sure to always call next()!
                }
            })
        }
    }
};
/*** @EndVueRouter Init ***/
/**
 * @default vuex
 */
export const defaultStates = {
    isMobile: false,
    validate_errors: {},
    validate_succeed: {},
    WindowState: '',
    windowWidth: 0,
    windowHeight: 0,
    authUserInfo: {
        image: `/assets/images/${settings.website_logo}${settings.fresh_version}`,
        thumb_image: `/assets/images/user_profiles/96x96-logo.svg${settings.fresh_version}`,
        type_user: '',
    },
};
export const defaultGetters = {
    validated(s) {
        return s.validate_errors;
    },
    succeeded(s) {
        return s.validate_succeed;
    },
    getToken() {
        let r;
        if ($utils.hasLocalStorage('_id_tn')) {
            r = jsEncode.encode($utils.getLocalStorage('_id_tn'), jsEncode.dn);
            if ($utils.hasLocalStorage(r)) {
                return decipher($utils.getLocalStorage(r));
            }
        }
        return r;
    },
    /**
     * @return {boolean}
     */
    LoggedIn(s, g) {
        return !$utils.isEmptyVar(g.getToken);
    }
};
export const defaultMutations = {
    setSucceed(state, payload) {
        state.validate_succeed = payload.succeed;
        state.validate_succeed.success = payload.succeed.success
    },
    setValidated(state, payload) {
        state.validate_errors = payload.errors;
    },
    /**
     * @description Clear all validated message form both success and failed messages
     * @param  {Object} state
     * @param {Object} p
     * @return void
     */
    setClearMsg(state, p) {
        if (p && p.delay) {
            setTimeout(() => {
                state.validate_succeed = {};
                state.validate_errors = {};
            }, p.delay);
        } else {
            state.validate_succeed = {};
            state.validate_errors = {};
        }
    },
    setClearValidate(s, p) {
        if (p) {
            Object.keys(p).forEach((k) => {
                if (s.validate_errors.hasOwnProperty(k)) {
                    s.validate_errors[k] = '';
                }
            });
        }
    },
    setClearSuccess(s, p) {
        if (p) {
            Object.keys(p).forEach((k) => {
                if (s.validate_succeed.hasOwnProperty(k)) {
                    s.validate_succeed[k] = '';
                }
            });
        }
    },
    setToken(state, payload) {
        let tn = cipter(jsEncode.encode('token', $utils.generateRandomNumber(0, 120)));
        $utils.setLocalStorage(tn, cipter(payload.token));
        $utils.setLocalStorage('_id_tn', jsEncode.encode(tn, jsEncode.dn));
    },
    setRemoveToken(s, p) {
        if ($utils.hasLocalStorage('_id_tn')) {
            let r = jsEncode.encode($utils.getLocalStorage('_id_tn'), jsEncode.dn);
            if ($utils.hasLocalStorage(r)) {
                $utils.removeLocalStorage(r)
            }
            $utils.removeLocalStorage('_id_tn');
        }
        if (p)
            $utils.Location(p.path)
    },
    setAuthUserInfo(s, p) {
        s.authUserInfo = p.auth;
    },
    setCopyStatus(s, p) {
        Vue.toasted.show(p, {
            position: 'bottom-right',
            duration: 2500,
            action: {
                text: 'Close',
                onClick: (e, t) => {
                    t.goAway(0);
                }
            }
        });
    },
    setMobile(s, p) {
        s.isMobile = p.isMobile;
        s.windowWidth = p.currentWidth;
        s.windowHeight = p.currentHeight;
    },
    setWindowState(state, p) {
        state.WindowState = p.WindowState;
    }
};
export const defaultActions = (api) => {
    return {
        HandleError(c, i) {
            c.commit('setClearMsg');
            let statusText, bool;
            if (i && i.data) {
                if (i.status === 401) {
                    statusText = i.data.token;
                    bool = (statusText === "token_absent" || statusText === "Unauthorized"
                        || statusText === "token_expired" || statusText === "token_invalid" || statusText === "unauthorized")
                    if (bool) {
                        c.commit('setValidated', {errors: {login_again: "Your session expired!"}});
                        $utils.Location('/login', 1500);
                        $utils.setSession("re-validate", true);
                        c.commit('setRemoveToken');
                    }
                } else if (i.status === 429) {
                    statusText = i.data.api;
                    bool = statusText === "tooManyAttempts";
                    if (bool) {
                        c.commit('setValidated', {errors: {unknown: "Our system received a lot of requests. Please wait a moment."}})
                    } else {
                        if (i.data.errors) {
                            c.commit('setValidated', {errors: $utils.fetchErrors(i.data.errors)})
                        }
                    }
                } else if (i.status === 404) {
                    c.commit('setValidated', {errors: {unknown: "Sorry, the page you are looking for could not be found."}});
                } else if (i.data.errors) {
                    c.commit('setValidated', {errors: $utils.fetchErrors(i.data.errors)})
                } else {
                    c.commit('setValidated', {errors: {unknown: "Sorry!, Something went wrong."}})
                }
            } else {
                c.commit('setValidated', {errors: {unknown: "Sorry!, Something went wrong."}});
            }
            //start handle unknown error
            let nk_er = c.state.validate_errors.unknown;
            if (nk_er) {
                Vue.toasted.error(nk_er, {
                    duration: 4500,
                    action: {
                        text: 'Close',
                        onClick: (e, t) => {
                            t.goAway(0);
                        }
                    }
                });
            }//end handle unknown error
        },
        fetchAuthUserInfo(c, i) {
            api.client.post(`${api.apiUrl}/users/me`, {file: '123'}, api.ajaxConfig.addHeader('CL-Token', c.getters.getToken))
                .then(res => {
                    let i = res.data;
                    if (i.success) {
                        c.commit('setAuthUserInfo', i);
                    } else {
                        if (i.no_redirect) {
                            c.commit('setRemoveToken')
                        } else {
                            c.commit('setRemoveToken', {path: '/login'})
                        }
                    }
                })
                .catch(err => {
                    if (i.no_redirect) {
                        c.commit('setRemoveToken')
                    } else {
                        c.dispatch('HandleError', err.response);
                    }
                });
        },
        Login(c, i) {
            $utils.Validate(i.userInfo, {
                'email': ['email', 'required'],
                'password': ['required', {min: 6}],
            }).then((v) => {
                c.commit('setValidated', {errors: {loading: 'yes'}});
                api.client.post(api.apiUrl + '/guest/login', i.userInfo, api.ajaxConfig.getHeaders())
                    .then(res => {
                        c.commit('setClearMsg');
                        const iRes = res.data;
                        if (iRes.access_token) {
                            c.commit('setToken', {
                                user: iRes.user,
                                token: iRes.access_token,
                                seconds: iRes.expires_in
                            });
                            const type = iRes.user.type;
                            if (type === $utils.b64EncodeUnicode('admin') || type === $utils.b64EncodeUnicode('super_admin')) {
                                $utils.Location('/admin/me')
                            } else if (type === $utils.b64EncodeUnicode('user')) {
                                $utils.Location('/users/me');
                            }
                        } else {
                            $utils.Location('/');
                        }
                    })
                    .catch(err => {
                        c.dispatch('HandleError', err.response);
                    });

            }).catch((err) => {
                c.commit('setValidated', {errors: err.errors});
            });
        },
        Logout(c, i) {
            c.commit('setValidated', {errors: {loading: 'yes'}});
            api.client.post(api.apiUrl + '/logout', {},
                api.ajaxConfig.addHeader('CL-Token', c.getters.getToken))
                .then(res => {
                    c.commit('setRemoveToken', {path: '/'})
                })
                .catch(err => {
                    c.commit('setRemoveToken', {path: '/'})
                })
        },
        copyToClipboard(c, data) {
            document.addEventListener('copy', (e) => {
                e.clipboardData.setData('text/plain', data.text);
                e.preventDefault();
            });
            let ctx = c, successful, t;
            copyTextToClipboard(data.text);

            function fallbackCopyTextToClipboard(text) {
                try {
                    successful = document.execCommand('copy');
                    if (successful) {
                        ctx.commit('setCopyStatus', ` Copied ${$utils.sub(text)}`)
                    } else {
                        ctx.commit('setCopyStatus', 'Unable to copy');
                        clearTimeout(t);
                        t = setTimeout((e) => {
                            ctx.commit('setCopyStatus', 'Please do it manually');
                        }, 1000);
                        if (!$utils.isEmptyVar(data.target)) {
                            c.target.select();
                        }
                    }
                } catch (err) {
                    console.error('Fallback: Oops, unable to copy', err);
                    ctx.commit('setCopyStatus', 'Could not copy the data.');
                }
            }

            function copyTextToClipboard(text) {
                if (!navigator.clipboard) {
                    fallbackCopyTextToClipboard(text);
                    return;
                }
                navigator.clipboard.writeText(text).then(function () {
                    ctx.commit('setCopyStatus', ` Copied ${$utils.sub(text)}`);
                }, function (err) {
                    ctx.commit('setCopyStatus', `Could not copy the data, Error: ${err}.`)
                });
            }
        }
    }
};
/**
 *@my-mapper functions for mutations
 export const specifixMutations = normalize(function (mutations) {
    let res = {};
    mutations.forEach(i => {
        if (!(i in initMutations)) {
            console.error(("[vuex initializer] unknown mutations: " + i));
            return
        }
        res[i] = initMutations[i];
    });
    return res;
});

 function normalize(fn) {
    return function (map) {
        return fn(map);
    }
}
 */
/**
 * @mapper functions
 *@example:
 *var mapGetters = normalizeNamespace(function (namespace, getters) {
  var res = {};
  normalizeMap(getters).forEach(function (ref) {
    var key = ref.key;
    var val = ref.val;

    val = namespace + val;
    res[key] = function mappedGetter () {
      if (namespace && !getModuleByNamespace(this.$store, 'mapGetters', namespace)) {
        return
      }
      if ("development" !== 'production' && !(val in this.$store.getters)) {
        console.error(("[vuex] unknown getter: " + val));
        return
      }
      return this.$store.getters[val]
    };
    // mark vuex getter for devtools
    res[key].vuex = true;
  });
  return res
});
 function normalizeMap (map) {
     return Array.isArray(map)
         ? map.map(function (key) { return ({ key: key, val: key }); })
         : Object.keys(map).map(function (key) { return ({ key: key, val: map[key] }); })
 }

 function normalizeNamespace (fn) {
     return function (namespace, map) {
         if (typeof namespace !== 'string') {
             map = namespace;
             namespace = '';
         } else if (namespace.charAt(namespace.length - 1) !== '/') {
             namespace += '/';
         }
         return fn(namespace, map)
     }
 }
 */
