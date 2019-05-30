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
                    'institute_name': ['required', {max: 191}],
                    'short_institute_name': ['required', {max: 191}],
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
                    utils.addDataForm(['institute_name', 'short_institute_name', 'phone_number', 'dateOfBirth',
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
