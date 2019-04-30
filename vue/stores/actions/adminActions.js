import {createAxiosClient} from "../../initial/api/axios-client";

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
        fetchSearches(c, i) {
            let request = `limit=${i.limit}&page=${i.page}&q=${i.q}`;
            c.commit('setValidated', {errors: {loading_searches: true}});
            client.get(`${apiUrl}/admin/searches/${i.type}?${request}`, ajaxToken(c))
                .then(res => {
                    c.commit('setSearchesData', {type: i.type, data: res.data.data});
                    c.commit('setClearMsg');
                })
                .catch(err => {
                    c.commit('setClearMsg');
                    c.dispatch('HandleError', err.response);
                });
        },
        /***  @Users  **/
        postChangeUserStatus(c, i) {
            return new Promise((r, n) => {
                client.post(`${apiUrl}/admin/users-change-status/${i.id}`, i.data, ajaxToken(c))
                    .then(res => {
                        c.commit('setClearMsg');
                        r(res.data);
                    })
                    .catch(err => {
                        c.commit('setClearMsg');
                        c.dispatch('HandleError', err.response);
                        n(err.response);
                    })
            });
        },
        postDeleteUser(c, i) {
            return new Promise((r, n) => {
                client.post(`${apiUrl}/admin/users-delete/${i.id}`, i.data, ajaxToken(c))
                    .then(res => {
                        c.commit('setClearMsg');
                        r(res.data);
                    })
                    .catch(err => {
                        c.dispatch('HandleError', err.response);
                        n(err.response);
                    })
            });
        },
        postRegisterUser(c, user) {
            return new Promise((r, n) => {
                utils.Validate(user, {
                    'first_name': ['required'],
                    'last_name': ['required'],
                    'email': ['email', 'required'],
                    'password': ['required', 'confirm', {min: 6}]
                }).then((v) => {
                    //directly add password confirmation  for admin
                    user.password_confirmation = user.password;
                    client.post(`${apiUrl}/admin/users-register`, user, ajaxConfig)
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
        /***  @Users  **/

        /*** @Organize **/
        postCreateOrganize(c, organize) {
            return new Promise((r, n) => {
                utils.Validate(organize, {
                    'name': ['required', {max: 191}],
                    'government_organize': ['required', {max: 10}]
                }).then(v => {
                    client.post(`${apiUrl}/admin/organize/create`, organize, ajaxToken(c))
                        .then(res => {
                            c.commit('setClearMsg');
                            r(res.data)
                        })
                        .catch(err => {
                            c.dispatch('HandleError', err.response);
                            n(err)
                        })
                }).catch(e => {
                    c.commit('setValidated', {errors: e.errors});
                    n(e);
                });
            });
        },
        postUpdateOrganize(c, organize) {
            return new Promise((r, n) => {
                utils.Validate(organize, {
                    'organize_name': ['required', {max: 191}],
                    'government_organize': ['required', {max: 10}]
                }).then(v => {
                    client.post(`${apiUrl}/admin/organize/update/${organize.id}`, organize, ajaxToken(c))
                        .then(res => {
                            c.commit('setClearMsg');
                            r(res.data)
                        })
                        .catch(err => {
                            c.dispatch('HandleError', err.response);
                            n(err)
                        })
                }).catch(e => {
                    c.commit('setValidated', {errors: e.errors});
                    n(e);
                });
            });
        },
        postDeleteOrganize(c, i) {
            return new Promise((r, n) => {
                client.delete(`${apiUrl}/admin/organize/delete/${i.id}`, ajaxToken(c))
                    .then(res => {
                        c.commit('setClearMsg');
                        r(res.data)
                    })
                    .catch(err => {
                        c.dispatch('HandleError', err.response);
                        n(err)
                    })
            });
        },
        /*** @Organize **/
        /*** @Department **/
        postCreateDepartment(c, department) {
            return new Promise((r, n) => {
                utils.Validate(department, {
                    'name': ['required', {max: 191}]
                }).then(v => {
                    client.post(`${apiUrl}/admin/department/create`, department, ajaxToken(c))
                        .then(res => {
                            c.commit('setClearMsg');
                            r(res.data)
                        })
                        .catch(err => {
                            c.dispatch('HandleError', err.response);
                            n(err)
                        })
                }).catch(e => {
                    c.commit('setValidated', {errors: e.errors});
                    n(e);
                });
            });
        },
        postUpdateDepartment(c, department) {
            return new Promise((r, n) => {
                utils.Validate(department, {
                    'department_name': ['required', {max: 191}]
                }).then(v => {
                    client.post(`${apiUrl}/admin/department/update/${department.id}`, department, ajaxToken(c))
                        .then(res => {
                            c.commit('setClearMsg');
                            r(res.data)
                        })
                        .catch(err => {
                            c.dispatch('HandleError', err.response);
                            n(err)
                        })
                }).catch(e => {
                    c.commit('setValidated', {errors: e.errors});
                    n(e);
                });
            });
        },
        postDeleteDepartment(c, i) {
            return new Promise((r, n) => {
                client.delete(`${apiUrl}/admin/department/delete/${i.id}`, ajaxToken(c))
                    .then(res => {
                        c.commit('setClearMsg');
                        r(res.data)
                    })
                    .catch(err => {
                        c.dispatch('HandleError', err.response);
                        n(err)
                    })
            });
        },
        /*** @Department **/
        /*** @Dictionary **/
        postCreateDictionary(c, data) {
            return new Promise((r, n) => {
                utils.Validate(data, {
                    lao: ["required"],
                    japanese: ["required"],
                    description: ["required"]
                }).then(v => {
                    client.post(`${apiUrl}/admin/dictionary/create`, data, ajaxToken(c))
                        .then(res => {
                            c.commit('setClearMsg');
                            r(res.data)
                        })
                        .catch(err => {
                            c.dispatch('HandleError', err.response);
                            n(err)
                        })
                }).catch(e => {
                    c.commit('setValidated', {errors: e.errors});
                    n(e);
                });
            });
        },
        postUpdateDictionary(c, data) {
            return new Promise((r, n) => {
                utils.Validate(data, {
                    lao: ["required"],
                    japanese: ["required"],
                    description: ["required"]
                }).then(v => {
                    client.post(`${apiUrl}/admin/dictionary/update/${data.id}`, data, ajaxToken(c))
                        .then(res => {
                            c.commit('setClearMsg');
                            r(res.data)
                        })
                        .catch(err => {
                            c.dispatch('HandleError', err.response);
                            n(err)
                        })
                }).catch(e => {
                    c.commit('setValidated', {errors: e.errors});
                    n(e);
                });
            });
        },
        postDeleteDictionary(c, i) {
            return new Promise((r, n) => {
                client.delete(`${apiUrl}/admin/dictionary/delete/${i.id}`, ajaxToken(c))
                    .then(res => {
                        c.commit('setClearMsg');
                        r(res.data)
                    })
                    .catch(err => {
                        c.dispatch('HandleError', err.response);
                        n(err)
                    })
            });
        },
        /*** @Dictionary **/
        /*** @ContactInfo **/
        fetchContactInfo(c, i) {
            return new Promise((r, n) => {
                client.get(`${apiUrl}/admin/contactinfo`, ajaxToken(c))
                    .then(res => {
                        c.commit('setClearMsg');
                        r(res.data);
                    })
                    .catch(err => {
                        c.commit('setClearMsg');
                        c.dispatch('HandleError', err.response);
                        n(err);
                    });
            });
        },
        postMangeContactInfo(c, data) {
            return new Promise((r, n) => {
                utils.Validate(data, {
                    phone: ["required", 'phone number'],
                    email: ["required", 'email'],
                    address: ["required"]
                }).then(v => {
                    client.post(`${apiUrl}/admin/contactinfo/manage`, data, ajaxToken(c))
                        .then(res => {
                            c.commit('setClearMsg');
                            r(res.data)
                        })
                        .catch(err => {
                            c.dispatch('HandleError', err.response);
                            n(err)
                        })
                }).catch(e => {
                    c.commit('setValidated', {errors: e.errors});
                    n(e);
                });
            });
        },
        /*** @ContactInfo **/
        /*** @AboutInfo **/
        fetchAboutInfo(c, i) {
            return new Promise((r, n) => {
                client.get(`${apiUrl}/admin/aboutinfo`, ajaxToken(c))
                    .then(res => {
                        c.commit('setClearMsg');
                        r(res.data);
                    })
                    .catch(err => {
                        c.commit('setClearMsg');
                        c.dispatch('HandleError', err.response);
                        n(err);
                    });
            });
        },
        postMangeAboutInfo(c, data) {
            return new Promise((r, n) => {
                client.post(`${apiUrl}/admin/aboutinfo/manage`, data, ajaxToken(c))
                    .then(res => {
                        c.commit('setClearMsg');
                        r(res.data)
                    })
                    .catch(err => {
                        c.dispatch('HandleError', err.response);
                        n(err)
                    })
            });
        },
        /*** @AboutInfo **/
        /*** @News **/
        postCreateNews(c, data) {
            return new Promise((r, n) => {
                utils.Validate(data, {
                    title: ["required"],
                    image: ["required", {mimes: 'jpeg,jpg,png,gif'}, {max: 3000}],
                    description: ["required"]
                }).then(v => {
                    let formData = new FormData();
                    utils.addDataForm(['title', 'description'], formData, data);
                    formData.append('image', data.image.file);
                    client.post(`${apiUrl}/admin/news/create`, formData, ajaxToken(c))
                        .then(res => {
                            c.commit('setClearMsg');
                            r(res.data)
                        })
                        .catch(err => {
                            c.dispatch('HandleError', err.response);
                            n(err)
                        })
                }).catch(e => {
                    c.commit('setValidated', {errors: e.errors});
                    n(e);
                });
            });
        },
        postUpdateNews(c, data) {
            return new Promise((r, n) => {
                utils.Validate(data, {
                    title: ["required"],
                    image: [{mimes: 'jpeg,jpg,png,gif'}, {max: 3000}],
                    description: ["required"]
                }).then(v => {
                    let formData = new FormData();
                    utils.addDataForm(['title', 'description'], formData, data);
                    if (data.image && data.image.file) {//check if user change image
                        formData.append('image', data.image.file);
                    }
                    client.post(`${apiUrl}/admin/news/update/${data.id}`, formData, ajaxToken(c))
                        .then(res => {
                            c.commit('setClearMsg');
                            r(res.data)
                        })
                        .catch(err => {
                            c.dispatch('HandleError', err.response);
                            n(err)
                        })
                }).catch(e => {
                    c.commit('setValidated', {errors: e.errors});
                    n(e);
                });
            });
        },
        postDeleteNews(c, i) {
            return new Promise((r, n) => {
                client.delete(`${apiUrl}/admin/news/delete/${i.id}`, ajaxToken(c))
                    .then(res => {
                        c.commit('setClearMsg');
                        r(res.data)
                    })
                    .catch(err => {
                        c.dispatch('HandleError', err.response);
                        n(err)
                    })
            });
        },
        /*** @News **/
        /*** @Activity **/
        postCreateActivity(c, data) {
            return new Promise((r, n) => {
                utils.Validate(data, {
                    title: ["required"],
                    place: ["required"],
                    activity_date: ["required"],
                    image: ["required", {mimes: 'jpeg,jpg,png,gif'}, {max: 3000}],
                    description: ["required"]
                }).then(v => {
                    let formData = new FormData();
                    utils.addDataForm(['title', 'place', 'description', 'activity_date'], formData, data);
                    formData.append('image', data.image.file);
                    client.post(`${apiUrl}/admin/activity/create`, formData, ajaxToken(c, true))
                        .then(res => {
                            c.commit('setClearMsg');
                            r(res.data)
                        })
                        .catch(err => {
                            c.dispatch('HandleError', err.response);
                            n(err)
                        })
                }).catch(e => {
                    c.commit('setValidated', {errors: e.errors});
                    n(e);
                });
            });
        },
        postUpdateActivity(c, data) {
            return new Promise((r, n) => {
                utils.Validate(data, {
                    title: ["required"],
                    place: ["required"],
                    image: [{mimes: 'jpeg,jpg,png,gif'}, {max: 3000}],
                    activity_date: ["required"],
                    description: ["required"]
                }).then(v => {
                    let formData = new FormData();
                    utils.addDataForm(['title', 'place', 'description', 'activity_date'], formData, data);
                    if (data.image && data.image.file) {//check if user change image
                        formData.append('image', data.image.file);
                    }
                    client.post(`${apiUrl}/admin/activity/update/${data.id}`, formData, ajaxToken(c, true))
                        .then(res => {
                            c.commit('setClearMsg');
                            r(res.data)
                        })
                        .catch(err => {
                            c.dispatch('HandleError', err.response);
                            n(err)
                        })
                }).catch(e => {
                    c.commit('setValidated', {errors: e.errors});
                    n(e);
                });
            });
        },
        postDeleteActivity(c, i) {
            return new Promise((r, n) => {
                client.delete(`${apiUrl}/admin/activity/delete/${i.id}`, ajaxToken(c))
                    .then(res => {
                        c.commit('setClearMsg');
                        r(res.data)
                    })
                    .catch(err => {
                        c.dispatch('HandleError', err.response);
                        n(err)
                    })
            });
        },
        /*** @Activity **/
        /*** @Event **/
        postCreateEvent(c, data) {
            return new Promise((r, n) => {
                utils.Validate(data, {
                    title: ["required"],
                    place: ["required"],
                    start_event: ["required"],
                    end_event: ["required"],
                    hosted_by: ["required"],
                    image: ["required", {mimes: 'jpeg,jpg,png,gif'}, {max: 3000}],
                    description: ["required"]
                }).then(v => {
                    let formData = new FormData();
                    utils.addDataForm(['title', 'place', 'description', 'start_event', 'end_event', 'hosted_by'], formData, data);
                    formData.append('image', data.image.file);
                    client.post(`${apiUrl}/admin/event/create`, formData, ajaxToken(c, true))
                        .then(res => {
                            c.commit('setClearMsg');
                            r(res.data)
                        })
                        .catch(err => {
                            c.dispatch('HandleError', err.response);
                            n(err)
                        })
                }).catch(e => {
                    c.commit('setValidated', {errors: e.errors});
                    n(e);
                });
            });
        },
        postUpdateEvent(c, data) {
            return new Promise((r, n) => {
                utils.Validate(data, {
                    title: ["required"],
                    image: [{mimes: 'jpeg,jpg,png,gif'}, {max: 3000}],
                    start_event: ["required"],
                    place: ["required"],
                    end_event: ["required"],
                    hosted_by: ["required"],
                    description: ["required"]
                }).then(v => {
                    let formData = new FormData();
                    utils.addDataForm(['title', 'place', 'description', 'start_event', 'end_event', 'hosted_by'], formData, data);
                    if (data.image && data.image.file) {//check if user change image
                        formData.append('image', data.image.file);
                    }
                    client.post(`${apiUrl}/admin/event/update/${data.id}`, formData, ajaxToken(c, true))
                        .then(res => {
                            c.commit('setClearMsg');
                            r(res.data)
                        })
                        .catch(err => {
                            c.dispatch('HandleError', err.response);
                            n(err)
                        })
                }).catch(e => {
                    c.commit('setValidated', {errors: e.errors});
                    n(e);
                });
            });
        },
        postDeleteEvent(c, i) {
            return new Promise((r, n) => {
                client.delete(`${apiUrl}/admin/event/delete/${i.id}`, ajaxToken(c))
                    .then(res => {
                        c.commit('setClearMsg');
                        r(res.data)
                    })
                    .catch(err => {
                        c.dispatch('HandleError', err.response);
                        n(err)
                    })
            });
        },
        /*** @Event **/
        /*** @Scholarship **/
        postCreateScholarship(c, data) {
            return new Promise((r, n) => {
                utils.Validate(data, {
                    title: ["required"],
                    place: ["required"],
                    deadline: ["required"],
                    scholarship_type: ["required"],
                    image: ["required", {mimes: 'jpeg,jpg,png,gif'}, {max: 3000}],
                    description: ["required"]
                }).then(v => {
                    let formData = new FormData();
                    utils.addDataForm(['title', 'place', 'description', 'deadline', 'scholarship_type'], formData, data);
                    formData.append('image', data.image.file);
                    client.post(`${apiUrl}/admin/scholarship/create`, formData, ajaxToken(c, true))
                        .then(res => {
                            c.commit('setClearMsg');
                            r(res.data)
                        })
                        .catch(err => {
                            c.dispatch('HandleError', err.response);
                            n(err)
                        })
                }).catch(e => {
                    c.commit('setValidated', {errors: e.errors});
                    n(e);
                });
            });
        },
        postUpdateScholarship(c, data) {
            return new Promise((r, n) => {
                utils.Validate(data, {
                    title: ["required"],
                    image: [{mimes: 'jpeg,jpg,png,gif'}, {max: 3000}],
                    scholarship_deadline: ["required"],
                    place: ["required"],
                    scholarship_type: ["required"],
                    description: ["required"]
                }).then(v => {
                    let formData = new FormData();
                    utils.addDataForm(['title', 'place', 'description', 'scholarship_deadline', 'scholarship_type'], formData, data);
                    if (data.image && data.image.file) {//check if user change image
                        formData.append('image', data.image.file);
                    }
                    client.post(`${apiUrl}/admin/scholarship/update/${data.id}`, formData, ajaxToken(c, true))
                        .then(res => {
                            c.commit('setClearMsg');
                            r(res.data)
                        })
                        .catch(err => {
                            c.dispatch('HandleError', err.response);
                            n(err)
                        })
                }).catch(e => {
                    c.commit('setValidated', {errors: e.errors});
                    n(e);
                });
            });
        },
        postDeleteScholarship(c, i) {
            return new Promise((r, n) => {
                client.delete(`${apiUrl}/admin/scholarship/delete/${i.id}`, ajaxToken(c))
                    .then(res => {
                        c.commit('setClearMsg');
                        r(res.data)
                    })
                    .catch(err => {
                        c.dispatch('HandleError', err.response);
                        n(err)
                    })
            });
        },
        /*** @Scholarship **/
        /*** @OrganizeInfo **/
        fetchOrganizeInfo(c, i) {
            return new Promise((r, n) => {
                client.get(`${apiUrl}/admin/organizeinfo`, ajaxToken(c))
                    .then(res => {
                        c.commit('setClearMsg');
                        r(res.data);
                    })
                    .catch(err => {
                        c.commit('setClearMsg');
                        c.dispatch('HandleError', err.response);
                        n(err);
                    });
            });
        },
        postMangeOrganizeInfo(c, data) {
            return new Promise((r, n) => {
                client.post(`${apiUrl}/admin/organizeinfo/manage`, data, ajaxToken(c))
                    .then(res => {
                        c.commit('setClearMsg');
                        r(res.data)
                    })
                    .catch(err => {
                        c.dispatch('HandleError', err.response);
                        n(err)
                    })
            });
        },
        /*** @OrganizeInfo **/
        /*** @OrganizeChartChartRange **/
        postCreateOrganizeChartRange(c, data) {
            return new Promise((r, n) => {
                utils.Validate(data, {
                    chart_name: ["required"],
                    position_order: ["number"],
                }).then(v => {
                    client.post(`${apiUrl}/admin/chart-ranges/create`, data, ajaxToken(c))
                        .then(res => {
                            c.commit('setClearMsg');
                            r(res.data)
                        })
                        .catch(err => {
                            c.dispatch('HandleError', err.response);
                            n(err)
                        })
                }).catch(e => {
                    c.commit('setValidated', {errors: e.errors});
                    n(e);
                });
            });
        },
        postUpdateOrganizeChartRange(c, data) {
            return new Promise((r, n) => {
                utils.Validate(data, {
                    chart_name: ["required"],
                    position_order: ["required", "number"],
                }).then(v => {
                    client.post(`${apiUrl}/admin/chart-ranges/update/${data.id}`, data, ajaxToken(c))
                        .then(res => {
                            c.commit('setClearMsg');
                            r(res.data)
                        })
                        .catch(err => {
                            c.dispatch('HandleError', err.response);
                            n(err)
                        })
                }).catch(e => {
                    c.commit('setValidated', {errors: e.errors});
                    n(e);
                });
            });
        },
        postDeleteOrganizeChartRange(c, i) {
            return new Promise((r, n) => {
                client.delete(`${apiUrl}/admin/chart-ranges/delete/${i.id}`, ajaxToken(c))
                    .then(res => {
                        c.commit('setClearMsg');
                        r(res.data)
                    })
                    .catch(err => {
                        c.dispatch('HandleError', err.response);
                        n(err)
                    })
            });
        },
        /*** @OrganizeChartChartRange **/
        /*** @SiteInfo **/
        postManageSiteInfo(c, data) {
            return new Promise((r, n) => {
                utils.Validate(data, {
                    'site_name': ['required', {max: 191}],
                    'website_logo': [{max: 2000}, {mimes: 'png,jpg,jpeg,svg'}],
                    'favorite_icon': [{max: 2000}, {mimes: 'png,jpg,jpeg,svg'}],
                }).then(v => {
                    let formData = new FormData();
                    utils.addDataForm(['site_name'], formData, data);
                    if (data.website_logo) {
                        formData.append('website_logo', data.website_logo.file);
                    }
                    if (data.favorite_icon) {
                        formData.append('favorite_icon', data.favorite_icon.file);
                    }
                    client.post(`${apiUrl}/admin/site-info/manage`, formData, ajaxToken(c, true))
                        .then(res => {
                            c.commit('setClearMsg');
                            r(res.data)
                        })
                        .catch(err => {
                            c.dispatch('HandleError', err.response);
                            n(err)
                        })
                }).catch(e => {
                    c.commit('setValidated', {errors: e.errors});
                    n(e);
                });
            });
        },
        getSiteInfo(c, i) {
            return new Promise((r, n) => {
                client.get(`${apiUrl}/admin/site-info`, ajaxToken(c))
                    .then(res => {
                        c.commit('setClearMsg');
                        r(res.data);
                    })
                    .catch(err => {
                        c.dispatch('HandleError', err.response);
                        n(err);
                    });
            });
        },
        /*** @SiteInfo **/
        /*** @UserProfileSearch **/
        fetchSearchMembers(c, i) {
            let request = `limit=${i.limit}&page=${i.page}&q=${i.q}`,
                filters = utils.clone(i.filters);
            for (let f in filters) {
                if (filters.hasOwnProperty(f)) {
                    if (f === "year_of_graduated" && filters[f]) {
                        filters[f] = filters[f].value;
                    }
                    if (f === 'type_of_organization' && filters[f]) {
                        filters[f] = filters[f].value;
                    }
                    if (f === 'work_categories' && filters[f]) {
                        filters[f] = String(utils.arrayToText(filters[f], 'value')).replace(/\s/g, '');
                    }
                }
            }
            c.commit('setSearchQuery', {text: i.q, filters: i.filters});
            c.commit('setValidated', {errors: {loading_members_profile_search: true}});
            client.post(`${apiUrl}/users/search-members?${request}`, filters, ajaxToken(c))
                .then(res => {
                    c.commit('setSearchesData', {type: i.type, data: res.data.data});
                    c.commit('setClearMsg');
                })
                .catch(err => {
                    c.dispatch('HandleError', err.response);
                });
        },
        /*** @UserProfileSearch **/
        /*** @SingleUserProfile **/
        fetchMemberProfile(c, user_id) {
            return new Promise((r, n) => {
                client.get(`${apiUrl}/users/profile-single/${user_id}`, ajaxToken(c))
                    .then(res => {
                        c.commit('setClearMsg');
                        r(res.data);
                    })
                    .catch(err => {
                        c.dispatch('HandleError', err.response);
                        n(err);
                    });
            });
        },
        /*** @SingleUserProfile **/
        /*** @Banner **/
        postCreateBanner(c, data) {
            return new Promise((r, n) => {
                utils.Validate(data, {
                    image: ["required", {mimes: 'jpeg,jpg,png,gif'}, {max: 3000}],
                }).then(v => {
                    let formData = new FormData();
                    utils.addDataForm(['name','description', 'order', 'link'], formData, data);
                    formData.append('image', data.image.file);
                    client.post(`${apiUrl}/admin/banner/create`, formData, ajaxToken(c, true))
                        .then(res => {
                            c.commit('setClearMsg');
                            r(res.data)
                        })
                        .catch(err => {
                            c.dispatch('HandleError', err.response);
                            n(err)
                        })
                }).catch(e => {
                    c.commit('setValidated', {errors: e.errors});
                    n(e);
                });
            });
        },
        postUpdateBanner(c, data) {
            return new Promise((r, n) => {
                utils.Validate(data, {
                    image: [{mimes: 'jpeg,jpg,png,gif'}, {max: 3000}],
                }).then(v => {
                    let formData = new FormData();
                    utils.addDataForm(['name','description', 'order', 'link'], formData, data);
                    if (data.image && data.image.file) {//check if user change image
                        formData.append('image', data.image.file);
                    }
                    client.post(`${apiUrl}/admin/banner/update/${data.id}`, formData, ajaxToken(c, true))
                        .then(res => {
                            c.commit('setClearMsg');
                            r(res.data)
                        })
                        .catch(err => {
                            c.dispatch('HandleError', err.response);
                            n(err)
                        })
                }).catch(e => {
                    c.commit('setValidated', {errors: e.errors});
                    n(e);
                });
            });
        },
        postDeleteBanner(c, i) {
            return new Promise((r, n) => {
                client.delete(`${apiUrl}/admin/banner/delete/${i.id}`, ajaxToken(c))
                    .then(res => {
                        c.commit('setClearMsg');
                        r(res.data)
                    })
                    .catch(err => {
                        c.dispatch('HandleError', err.response);
                        n(err)
                    })
            });
        },
        /*** @Banner **/
        /*** @File **/
        postCreateFile(c, data) {
            return new Promise((r, n) => {
                utils.Validate(data, {
                    fileName: ["required"],
                    file: ["required", {mimes: 'pdf,doc,docx,xlsx,pptx'}, {max: 10000}],
                }).then(v => {
                    let formData = new FormData();
                    utils.addDataForm(['fileName'], formData, data);
                    formData.append('file', data.file.file);
                    client.post(`${apiUrl}/admin/file/create`, formData, ajaxToken(c, true))
                        .then(res => {
                            c.commit('setClearMsg');
                            r(res.data)
                        })
                        .catch(err => {
                            c.dispatch('HandleError', err.response);
                            n(err)
                        })
                }).catch(e => {
                    c.commit('setValidated', {errors: e.errors});
                    n(e);
                });
            });
        },
        postUpdateFile(c, data) {
            return new Promise((r, n) => {
                utils.Validate(data, {
                    fileName: ["required"],
                    file: [{mimes: 'pdf,doc,docx,xlsx,pptx'}, {max: 10000}],
                }).then(v => {
                    let formData = new FormData();
                    utils.addDataForm(['fileName'], formData, data);
                    if (data.file && data.file.file) {//check if user change file
                        formData.append('file', data.file.file);
                    }
                    client.post(`${apiUrl}/admin/file/update/${data.id}`, formData, ajaxToken(c, true))
                        .then(res => {
                            c.commit('setClearMsg');
                            r(res.data)
                        })
                        .catch(err => {
                            c.dispatch('HandleError', err.response);
                            n(err)
                        })
                }).catch(e => {
                    c.commit('setValidated', {errors: e.errors});
                    n(e);
                });
            });
        },
        postDeleteFile(c, i) {
            return new Promise((r, n) => {
                client.delete(`${apiUrl}/admin/file/delete/${i.id}`, ajaxToken(c))
                    .then(res => {
                        c.commit('setClearMsg');
                        r(res.data)
                    })
                    .catch(err => {
                        c.dispatch('HandleError', err.response);
                        n(err)
                    })
            });
        },
        /*** @File **/
        /*** @SingleUserProfile **/
        /*** @OptionDataUserProfile **/
        fetchOptionProfileData(c, data) {
            return new Promise((r, n) => {
                client.get(`${apiUrl}/users/profile-options`, ajaxToken(c))
                    .then(res => {
                        c.commit('setClearMsg');
                        r(res.data);
                    })
                    .catch(err => {
                        c.dispatch('HandleError', err.response);
                        n(err);
                    });
            });
        },
        /*** @OptionDataUserProfile **/
        /*** @DashboardData **/
        fetchDashboardData(c, d) {
            c.commit('setValidated', {errors: {loading_dashboard_data: true}});
            client.get(`${apiUrl}/users/dashboard-data`, ajaxToken(c))
                .then(res => {
                    c.commit('setClearMsg');
                    c.commit('setDashboardData', res.data.data);
                })
                .catch(err => {
                    c.dispatch('HandleError', err.response);
                });
        },
        /*** @DashboardData **/
        /*** @postSendUserResetPasswordLink **/
        postSendUserResetPasswordLink(c, i) {
            return new Promise((r, n) => {
                c.commit('setValidated', {errors: {loading_searches: true}});
                client.post(`${apiUrl}/admin/users-send-reset-password-link/${i.id}`, i.data, ajaxToken(c))
                    .then(res => {
                        c.commit('setClearMsg');
                        r(res.data);
                    })
                    .catch(err => {
                        c.dispatch('HandleError', err.response);
                        n(err.response);
                    })
            });
        },
        /*** @postSendUserResetPasswordLink **/
        /*** @postManagePostsStatus **/
        postManagePostsStatus(c, data) {
            return new Promise((r, n) => {
                utils.Validate(data, {
                    id: ["required", {max: 191}],
                    changeStatusTo: ["required", {max: 191}],
                }).then(v => {
                    client.post(`${apiUrl}/admin/posts-status/manage`, data, ajaxToken(c))
                        .then(res => {
                            c.commit('setClearMsg');
                            r(res.data)
                        })
                        .catch(err => {
                            c.dispatch('HandleError', err.response);
                            n(err)
                        })
                }).catch(e => {
                    c.commit('setValidated', {errors: e.errors});
                    n(e);
                });
            });
        },
        /*** @postManagePostsStatus **/
        /*** @FetchChartRangesAndMembersChartRange **/
        fetchChartRanges(c, i) {
            return new Promise((r, n) => {
                client.get(`${apiUrl}/admin/chart-ranges`, ajaxToken(c))
                    .then(res => {
                        c.commit('setClearMsg');
                        r(res.data)
                    })
                    .catch(err => {
                        c.dispatch('HandleError', err.response);
                        n(err)
                    });
            });
        },
        fetchMembersChartRange(c, i) {
            return new Promise((r, n) => {
                if (utils.isEmptyVar(i) || utils.isEmptyObject(i)) r({data: {}});
                client.get(`${apiUrl}/admin/chart-ranges/${i.id}?q=${i.query}`, ajaxToken(c))
                    .then(res => {
                        c.commit('setClearMsg');
                        r(res.data)
                    })
                    .catch(err => {
                        c.dispatch('HandleError', err.response);
                        n(err)
                    });
            });
        },
        postCreateMemberChart(c, data) {
            return new Promise((r, n) => {
                utils.Validate(data, {
                    image: ["required", {mimes: 'jpeg,jpg,png,gif'}, {max: 3000}],
                    name: ["required", {max: 191}],
                    last_name: ["required", {max: 191}],
                    position: ["required", {max: 191}],
                    university: ["required", {max: 191}],
                    position_order: ["number"],
                    chart_range: ['required'],
                }).then(v => {

                    let data_clone = utils.clone(data);
                    data_clone.position = data_clone.position.value;
                    let formData = new FormData();
                    utils.addDataForm(['name', 'last_name', 'company', 'university', 'position', 'other_position', 'position_order', 'chart_range'], formData, data_clone);
                    if (data_clone.image && data_clone.image.file) {//check if user change image
                        formData.append('image', data_clone.image.file);
                    }
                    client.post(`${apiUrl}/admin/chart-range-members/create`, formData, ajaxToken(c, true))
                        .then(res => {
                            c.commit('setClearMsg');
                            r(res.data)
                        })
                        .catch(err => {
                            c.dispatch('HandleError', err.response);
                            n(err)
                        })
                }).catch(e => {
                    c.commit('setValidated', {errors: e.errors});
                    n(e);
                });
            });
        },
        postUpdateMemberChart(c, data) {
            return new Promise((r, n) => {
                utils.Validate(data, {
                    image: [{mimes: 'jpeg,jpg,png,gif'}, {max: 3000}],
                    name: ["required", {max: 191}],
                    last_name: ["required", {max: 191}],
                    position: ["required", {max: 191}],
                    university: ["required", {max: 191}],
                    position_order: ["required", "number"],
                    chart_range: ['required'],
                }).then(v => {
                    let data_clone = utils.clone(data);
                    data_clone.position = data_clone.position.value;
                    let formData = new FormData();
                    utils.addDataForm(['name', 'last_name', 'company', 'university', 'position', 'other_position', 'position_order', 'chart_range'], formData, data_clone);
                    if (data_clone.image && data_clone.image.file) {//check if user change image
                        formData.append('image', data_clone.image.file);
                    }
                    client.post(`${apiUrl}/admin/chart-range-members/update/${data_clone.id}`, formData, ajaxToken(c, true))
                        .then(res => {
                            c.commit('setClearMsg');
                            r(res.data)
                        })
                        .catch(err => {
                            c.dispatch('HandleError', err.response);
                            n(err)
                        })
                }).catch(e => {
                    c.commit('setValidated', {errors: e.errors});
                    n(e);
                });
            });
        },
        postDeleteMemberChart(c, data) {
            return new Promise((r, n) => {
                client.delete(`${apiUrl}/admin/chart-range-members/delete/${data.id}`, ajaxToken(c))
                    .then(res => {
                        c.commit('setClearMsg');
                        r(res.data)
                    })
                    .catch(err => {
                        c.dispatch('HandleError', err.response);
                        n(err)
                    })
            });
        },
        /*** @FetchChartRangesAndMembersChartRange **/
         /*** @Sponsor **/
         postCreateSponsor(c, data) {
            return new Promise((r, n) => {
                utils.Validate(data, {
                    name: ["required"],
                    image: ["required", {mimes: 'jpeg,jpg,png,gif'}, {max: 3000}],
                }).then(v => {
                    let formData = new FormData();
                    utils.addDataForm(['name','link','description'], formData, data);
                    formData.append('image', data.image.file);
                    client.post(`${apiUrl}/admin/sponsor/create`, formData, ajaxToken(c))
                        .then(res => {
                            c.commit('setClearMsg');
                            r(res.data)
                        })
                        .catch(err => {
                            c.dispatch('HandleError', err.response);
                            n(err)
                        })
                }).catch(e => {
                    c.commit('setValidated', {errors: e.errors});
                    n(e);
                });
            });
    
        },
        postUpdateSponsor(c, data) {
            return new Promise((r, n) => {
                utils.Validate(data, {
                    name: ["required"],
                    image: [{mimes: 'jpeg,jpg,png,gif'}, {max: 3000}],
                }).then(v => {
                    let formData = new FormData();
                    utils.addDataForm(['name','link','description'], formData, data);
                    if (data.image && data.image.file) {//check if user change image
                        formData.append('image', data.image.file);
                    }
                    client.post(`${apiUrl}/admin/sponsor/update/${data.id}`, formData, ajaxToken(c))
                        .then(res => {
                            c.commit('setClearMsg');
                            r(res.data)
                        })
                        .catch(err => {
                            c.dispatch('HandleError', err.response);
                            n(err)
                        })
                }).catch(e => {
                    c.commit('setValidated', {errors: e.errors});
                    n(e);
                });
            });
        },
        postDeleteSponsor(c, i) {
            return new Promise((r, n) => {
                client.delete(`${apiUrl}/admin/sponsor/delete/${i.id}`, ajaxToken(c))
                    .then(res => {
                        c.commit('setClearMsg');
                        r(res.data)
                    })
                    .catch(err => {
                        c.dispatch('HandleError', err.response);
                        n(err)
                    })
            });
        },
        /*** @Sponsor **/
    }
};
