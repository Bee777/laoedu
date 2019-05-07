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
            client.get(`${apiUrl}/users/searches/${i.type}?${request}`, ajaxToken(c))
                .then(res => {
                    c.commit('setSearchesData', {type: i.type, data: res.data.data});
                    c.commit('setClearMsg');
                })
                .catch(err => {
                    c.dispatch('HandleError', err.response);
                });
        },
        /***  @UsersSettings Profile **/
        /*** @UserProfile **/
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
        postManageUserProfile(c, data) {
            return new Promise((r, n) => {
                utils.Validate(data, {
                    'first_name': ['required', {max: 191}],
                    'last_name': ['required', {max: 191}],
                    'phone_number': ['phone number', {max: 191}],
                    'profile_image': [{mimes: 'jpeg,jpg,png,gif,svg'}, {max: 3000}],
                }).then(v => {
                    let info = utils.clone(data);
                    for (let i in info) {
                        if (info.hasOwnProperty(i)) {
                            if (utils.isEmptyVar(info[i])) {
                                info[i] = '';
                            }
                            if (i === 'marital_status' && info[i]) {
                                info[i] = info[i].value;
                            }
                            // if (i === 'typeOfOrganize' && info[i]) {
                            //     info[i] = info[i].value;
                            // }
                            // if (i === 'work_categories' && info[i]) {
                            //     info[i] = String(utils.arrayToText(info[i], 'value')).replace(/\s/g, '');
                            // }
                        }
                    }
                    let formData = new FormData();
                    utils.addDataForm(['first_name', 'last_name', 'phone_number', 'dateOfBirth',
                        'marital_status', 'personalDescription', 'placeOfBirth', 'placeOfResident'], formData, info);
                    if (info.profile_image) {//check if user change image
                        formData.append('profile_image', info.profile_image.file);
                    }
                    client.post(`${apiUrl}/users/profile-manage`, formData, ajaxToken(c, true))
                        .then(res => {
                            c.commit('setClearMsg');
                            r(res.data);
                        })
                        .catch(err => {
                            c.dispatch('HandleError', err.response);
                            n(err);
                        });

                }).catch(e => {
                    c.commit('setValidated', {errors: e.errors});
                    n(e);
                });
            });
        },
        /*** @UserProfile **/
        /*** @UserCredentials **/
        postChangeCredentialsUser(c, data) {
            return new Promise((r, n) => {
                utils.Validate(data, {
                    'new_email': ['email', {max: 191}],
                    'new_password': [{min: 6}, {max: 191}],
                    'new_password_confirmation': [{min: 6}, {max: 191}],
                    'current_password': ['required', {max: 191}],
                }).then(v => {
                    client.post(`${apiUrl}/users/credentials-manage`, data, ajaxToken(c))
                        .then(res => {
                            c.commit('setClearMsg');
                            r(res.data);
                        })
                        .catch(err => {
                            c.dispatch('HandleError', err.response);
                            n(err);
                        });

                }).catch(e => {
                    c.commit('setValidated', {errors: e.errors});
                    n(e);
                });
            });
        },
        /*** @UserCredentials **/
        /***  @UsersSettings Profile **/
        /*** @UserProfileSearch **/
        fetchSearchMembers(c, i) {
            let request = `limit=${i.limit}&page=${i.page}&q=${i.q}`,
                filters = utils.clone(i.filters);
            for (let f in filters) {
                if (filters.hasOwnProperty(f)) {
                    if (f === "degree" && filters[f]) {
                        filters[f] = filters[f].value;
                    }
                    if (f === 'marital_status' && filters[f]) {
                        filters[f] = filters[f].value;
                    }
                    if (f === 'type_of_organization' && filters[f]) {
                        filters[f] = filters[f].value;
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
                    client.post(`${apiUrl}/users/news/create`, formData, ajaxToken(c))
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
                    client.post(`${apiUrl}/users/news/update/${data.id}`, formData, ajaxToken(c))
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
                client.delete(`${apiUrl}/users/news/delete/${i.id}`, ajaxToken(c))
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
                    client.post(`${apiUrl}/users/activity/create`, formData, ajaxToken(c, true))
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
                    client.post(`${apiUrl}/users/activity/update/${data.id}`, formData, ajaxToken(c, true))
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
                client.delete(`${apiUrl}/users/activity/delete/${i.id}`, ajaxToken(c))
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
                    client.post(`${apiUrl}/users/scholarship/create`, formData, ajaxToken(c, true))
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
                    client.post(`${apiUrl}/users/scholarship/update/${data.id}`, formData, ajaxToken(c, true))
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
                client.delete(`${apiUrl}/users/scholarship/delete/${i.id}`, ajaxToken(c))
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
        /*** @Dictionary **/
        postCreateDictionary(c, data) {
            return new Promise((r, n) => {
                utils.Validate(data, {
                    lao: ["required"],
                    japanese: ["required"],
                    description: ["required"]
                }).then(v => {
                    client.post(`${apiUrl}/users/dictionary/create`, data, ajaxToken(c))
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
                    client.post(`${apiUrl}/users/dictionary/update/${data.id}`, data, ajaxToken(c))
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
                client.delete(`${apiUrl}/users/dictionary/delete/${i.id}`, ajaxToken(c))
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
        /*** @postManagePostsStatus **/
        postManagePostsStatus(c, data) {
            return new Promise((r, n) => {
                utils.Validate(data, {
                    id: ["required", {max: 191}],
                    changeStatusTo: ["required", {max: 191}],
                }).then(v => {
                    client.post(`${apiUrl}/users/posts-status/manage`, data, ajaxToken(c))
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
        /*** @postMemberEducationsProfile **/
        postManageMemberEducations(c, data) {
            return new Promise((r, n) => {
                client.post(`${apiUrl}/users/member-educations/manage`, {educations: data}, ajaxToken(c))
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
        /*** @postMemberEducationsProfile **/
        /*** @postManageMemberCareers **/
        postManageMemberCareers(c, data) {
            return new Promise((r, n) => {
                client.post(`${apiUrl}/users/member-careers/manage`, {careers: data}, ajaxToken(c))
                    .then(res => {
                        c.commit('setClearMsg');
                        r(res.data)
                    })
                    .catch(err => {
                        c.dispatch('HandleError', err.response);
                        n(err)
                    })
            });
        }
        /*** @postManageMemberCareers **/
    }
};
