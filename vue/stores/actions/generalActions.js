import {createAxiosClient} from "@vue/initial/api/axios-client";

let {client, ajaxConfig, apiUrl} = createAxiosClient();
const ajaxToken = (c, formData = false) => {
    if (formData) {
        ajaxConfig.addHeader('Content-Type', 'multipart/form-data');
    } else {
        ajaxConfig.addHeader('Content-Type', 'application/json');
    }
    return ajaxConfig.addHeader('CL-Token', c.getters.getToken);
};
export const axiosClient = () => createAxiosClient();
export const createActions = (utils) => {
    return {
        register(c, user) {
            return new Promise((r, n) => {
                utils.Validate(user, {
                    'first_name': ['required'],
                    'last_name': ['required'],
                    'email': ['email', 'required'],
                    'password': ['required', 'confirm', {min: 6}],
                    'password_confirmation': ['required', {min: 6}],
                }).then((v) => {
                    c.commit('setValidated', {errors: {loading: 'yes'}});
                    client.post(`${apiUrl}/guest/aGlkZGVuLXJlZ2lzdGVyLXBhZ2UtQGphb2w-post`, user, ajaxConfig)
                        .then(res => {
                            c.commit('setClearMsg', {delay: 1000});
                            utils.setSession('registered', true);
                            r(res.data);
                        })
                        .catch(err => {
                            c.dispatch('HandleError', err.response);
                            n(err.response);
                        });
                }).catch(e => {
                    c.commit('setValidated', {errors: e.errors});
                    n(e);
                });

            })
        },
        /*** @HomeData **/
        fetchHomeData(c, i) {
            client.get(`${apiUrl}/home/index`, ajaxConfig.getHeaders())
                .then(res => {
                    c.commit('setClearMsg');
                    c.commit('setHomeData', res.data.data)
                })
                .catch(err => {
                    c.dispatch('HandleError', err.response);
                });
        },
        /*** @HomeData **/
        /*** @ResetPasswordActionsAndData **/
        initResetForm(c, token) {
            return new Promise((r, n) => {
                c.commit('setValidated', {errors: {loading_reset: true}});
                client.post(`${apiUrl}/guest/forgot-password/email/${token}`, {}, ajaxConfig)
                    .then(res => {
                        c.commit('setClearMsg');
                        r(res.data);
                    })
                    .catch(err => {
                        c.dispatch('HandleError', err.response);
                        n(err.response);
                    });
            })
        },
        resetPassword(c, user) {
            return new Promise((r, n) => {
                utils.Validate(user, {
                    'email': ['email', 'required'],
                    'password': ['required', 'confirm', {min: 6}],
                    'password_confirmation': ['required', {min: 6}],
                }).then((v) => {
                    c.commit('setValidated', {errors: {loading_reset: true}});
                    client.post(`${apiUrl}/guest/password/reset`, user, ajaxConfig)
                        .then(res => {
                            c.commit('setClearMsg', {delay: 1000});
                            utils.setSession('finished-reset-password', true);
                            r(res.data);
                        })
                        .catch(err => {
                            c.dispatch('HandleError', err.response);
                            n(err.response);
                        });
                }).catch(e => {
                    c.commit('setValidated', {errors: e.errors});
                    n(e);
                });
            })
        },
        /*** @ResetPasswordActionsAndData **/
        /*** @PostsData **/
        fetchPostsData(c, i) {
            let request = `limit=${i.limit}&page=${i.page}&q=${i.q}`;
            c.commit('setValidated', {errors: {loading_search_posts: true}});
            client.get(`${apiUrl}/home/posts/${i.type}?${request}`, ajaxConfig.getHeaders())
                .then(res => {
                    c.commit('setSearchQuery', {text: i.q, filters: i.filters});
                    c.commit('setClearMsg', {delay: 300});
                    c.commit('setPostsData', {data: res.data, type: i.type})
                })
                .catch(err => {
                    c.dispatch('HandleError', err.response);
                });
        },
        /*** @PostsData **/
        /*** @PostsData **/
        fetchSinglePostsData(c, i) {
            c.commit('setValidated', {errors: {loading_single_posts: true}});
            client.get(`${apiUrl}/home/posts/${i.type}/single/${i.id}`, ajaxConfig.getHeaders())
                .then(res => {
                    if (res.data.success !== false) {
                        c.commit('setClearMsg', {delay: 300});
                        c.commit('setSinglePostsData', {data: res.data, type: i.type})
                    } else {
                        utils.Location('/');
                    }
                })
                .catch(err => {
                    c.dispatch('HandleError', err.response);
                });
        },
        /*** @PostsData **/
        /***@SendContactInfo */
        postSendContact(c, data) {
            return new Promise((r, n) => {
                utils.Validate(data, {
                    'email': ['email', 'required'],
                    'subject': ['required', {max: 191}],
                    'name': ['required', {max: 191}],
                    'message': ['required'],
                }).then((v) => {
                    c.commit('setValidated', {errors: {loading_send_contact: true}});
                    client.post(`${apiUrl}/home/contact-info`, data, ajaxConfig)
                        .then(res => {
                            c.commit('setClearMsg');
                            r(res.data);
                        })
                        .catch(err => {
                            c.dispatch('HandleError', err.response);
                            n(err.response);
                        });
                }).catch(e => {
                    c.commit('setValidated', {errors: e.errors});
                    n(e);
                });
            })
        },
        /***@SendContactInfo */
        /***@MembersChartRange */
        fetchMembersChartRange(c, i) {
            return new Promise((r, n) => {
                client.get(`${apiUrl}/home/chart-ranges/${i.id}?q=`, ajaxConfig)
                    .then(res => {
                        c.commit('setClearMsg');
                        c.commit('setChartData', res.data.data);
                        r(res.data)
                    })
                    .catch(err => {
                        c.dispatch('HandleError', err.response);
                        n(err)
                    });
            });
        },
        /***@MembersChartRange */
        /***@manageDictionaryComments */
        postMangeDictionaryComment(c, data) {
            return new Promise((r, n) => {
                let i, actions = {edit: true, reply: true, 'edit-reply': true};
                if (data.comment.action === 'edit-reply') {
                    i = utils.clone(data.child.data);
                    if(!data.loggedIn){
                        i.id = String(i.hash_id).substring(0, 191);
                    }

                } else {
                    i = utils.clone(data);
                }
                if (actions[i.comment.action]) {
                    i.text = data.comment.poster.text;
                    i.name = data.comment.poster.name;
                    i.surname = data.comment.poster.surname;
                }
                utils.Validate(i, {
                    'name': [{'required': {when: 'loggedIn', equals: false}}, {max: 191}],
                    'surname': [{'required': {when: 'loggedIn', equals: false}}, {max: 191}],
                    'text': ['required'],
                }).then((v) => {
                    //clear old invalid validate data
                    data.validated = {};
                    if (!i.loggedIn) {
                        let localUser = utils.getLocalStorage('dictionary_comments_user');
                        if (!localUser) {//set local user if not exists
                            utils.setLocalStorage('dictionary_comments_user', JSON.stringify({
                                name: i.name,
                                surname: i.surname
                            }));
                        }
                    }
                    client.post(`${apiUrl}/home/dictionary-comments-manage`, i, ajaxToken(c))
                        .then(res => {
                            c.commit('setClearMsg');
                            r(res.data);
                            if (res.data.success && data.comment.poster) {
                                data.comment.poster.text = '';
                            }
                            if (i.comment.action === 'post') {
                                c.commit('setDictionaryComments', {data: res.data.comment, position: 'top'});
                            }
                        })
                        .catch(err => {
                            c.dispatch('HandleError', err.response);
                            n(err.response);
                        });
                }).catch(e => {
                    if (actions[i.comment.action]) {
                        data.validated = e.errors;
                    } else {
                        c.commit('setValidated', {errors: e.errors});
                    }
                    n(e);
                });
            })
        },
        /***@manageDictionaryComments */
        /***@GetDictionaryComments */
        fetchDictionaryComments(c, i) {
            return new Promise((r, n) => {
                let request = `&limit=${i.limit}&page=${i.page}`;
                client.get(`${apiUrl}/home/dictionary-comments?dictionary_id=${i.id}${request}`, ajaxToken(c))
                    .then(res => {
                        c.commit('setClearMsg');
                        if (i.firstLoad) {
                            c.commit('setDictionaryComments', {data: [], position: 'reset'});
                        }
                        c.commit('setDictionaryComments', {data: res.data.data.data, position: 'bottom'});
                        r(res.data)
                    })
                    .catch(err => {
                        c.dispatch('HandleError', err.response);
                        n(err)
                    });
            });
        },
        /***@GetDictionaryComments */
        /***@deleteDictionaryComments */
        deleteDictionaryComment(c, data) {
            return new Promise((r, n) => {
                client.delete(`${apiUrl}/home/dictionary-comments-delete?id=${data.id}&dictionary_id=${data.dictionary_id}&isReplyComment=${data.isReplyComment}`, ajaxToken(c))
                    .then(res => {
                        c.commit('setClearMsg');
                        r(res.data);
                    })
                    .catch(err => {
                        c.dispatch('HandleError', err.response);
                        n(err.response);
                    });
            });
        },
        /***@deleteDictionaryComments */
    }
};
