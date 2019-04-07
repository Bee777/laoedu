<template>
    <!--Education Info -->
    <div class="admin-settings-cameo template-brand-settings admin-spinner-covered">
        <SpinnerLoading v-if="isLoading"/>
        <button v-if="isEdit" @click="addEducation"
                class="v-md-button v-md-icon-button edit-button add-education "><i
            class="material-icons">add_circle</i></button>

        <div class="settings-container no-border-left no-margin-top"
             border-bottom>

            <div class="cameo-header">
                <i class="material-icons cameo-header-icon">school</i>
                <span> Education Information</span>
            </div>
            <div class="cameo-content" v-if="educations.length <=0">
                <div class="layout-align-center-start layout-row "
                     style="margin-bottom: 16px;">
                    <span class="template-tip">{{ emptyText }}</span>
                </div>
            </div>

            <div class="cameo-content" :class="[{'educations-splitter' : idx+1 < educations.length}]"
                 v-for="(item, idx) in educations"
                 :key="idx">
                <div
                    class="layout-align-center-start cameo-header splitter layout-row"><span>{{idx+1}}. University {{ item.university !=='' ? item.university : ' - '  }}, Graduated at {{ (item.year_of_graduated && item.year_of_graduated.text) || ' - ' }}</span>
                    <button v-if="isEdit" @click="removeEducation(idx)"
                            class="v-md-button remove-button v-md-icon-button"><i
                        class="material-icons">remove_circle</i></button>
                </div>
                <div class="layout-align-space-around-start layout-row">
                    <AdminInput :label="' Study Field(Major) '"
                                :containerClass="'dense'"
                                v-model="item.study_field"
                                :validateText="item.validate.study_field"
                                :inputType="'text'">
                        <p class="template-tip">{{ item.study_field ||
                            emptyText }}</p></AdminInput>
                </div>
                <div class="layout-align-space-around-start layout-row">
                    <div
                        class="form-multi-select-container flex dense"
                        full>
                        <label>Degree in Education</label>
                        <multiselect v-if="!isDisplay" class="select-multiple"
                                     v-model="item.degree"
                                     label="label" track-by="value"
                                     placeholder="Select your degree"
                                     open-direction="bottom"
                                     :options="options.educationDegrees"
                                     :show-no-results="false"
                                     :preserve-search="true"
                                     :hide-selected="false">
                        </multiselect>
                        <p class="template-tip">{{ (item.degree && item.degree.label) || emptyText
                            }}</p>
                        <template v-if="item.validate.degree">
                            <div class="form-input-container">
                                <input v-show="false"/>
                                <div admin-messages>
                                    <div admin-message
                                         class="message-required ">
                                        {{ item.validate.degree }}
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
                <div class="layout-align-space-around-start layout-row">
                    <AdminInput
                        :containerClass="'dense'"
                        v-model="item.university"
                        :validateText="item.validate.university"
                        :customClass="'is-input-height-same-multiple'"
                        :label="'University of Graduation'"
                        :inputType="'text'">
                        <p class="template-tip">{{ item.university || emptyText }}</p></AdminInput>

                    <div
                        class="form-multi-select-container flex is-second-input dense"
                        full>
                        <label>Year of Graduated</label>
                        <multiselect v-if="!isDisplay" class="select-multiple"
                                     v-model="item.year_of_graduated"
                                     label="text" track-by="value"
                                     placeholder="Select year"
                                     open-direction="bottom"
                                     :options="yearsOptions"
                                     :show-no-results="false"
                                     :preserve-search="true"
                                     :hide-selected="false">
                        </multiselect>
                        <p class="template-tip">{{
                            (item.year_of_graduated && item.year_of_graduated.text) || emptyText}}</p>
                        <template v-if="item.validate.year_of_graduated">
                            <div class="form-input-container">
                                <input v-show="false"/>
                                <div admin-messages>
                                    <div admin-message
                                         class="message-required ">
                                        {{ item.validate.year_of_graduated }}
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            <div class="actions" v-if="isEdit">
                <div class="layout-align-end-center layout-row">
                    <button @click="save" class="v-md-button primary">
                        Save
                    </button>
                </div>
            </div>

        </div>
    </div>
    <!--Education Info-->
</template>

<script>
    import Multiselect from 'vue-multiselect'
    import {mapActions} from 'vuex'

    export default {
        name: "EducationProfile",
        components: {
            Multiselect,
        },
        props: {
            isDisplay: {
                type: Boolean,
                default: false,
            },
            isEdit: {
                type: Boolean,
                default: false,
            },
            options: {
                type: Object,
                default: function () {
                    return {};
                }
            },
            emptyText: {
                default: '',
            },
            yearsOptions: {
                default: function () {
                    return [];
                }
            },
            member_educations: {
                type: Array,
                default: function () {
                    return [];
                }
            }
        },
        data: () => ({
            educations: [],
            isLoading: false,
        }),
        watch: {
            'member_educations': function (n, o) {
                this.educations = this.$utils.clone(n);
            }
        },
        methods: {
            ...mapActions(['showErrorToast', 'showInfoToast', 'postManageMemberEducations']),
            addEducation() {
                let now = new Date();
                this.educations.unshift({
                    validate: {},
                    study_field: '',
                    degree: {label: '', value: null},
                    university: '',
                    year_of_graduated: {text: String(now.getFullYear()), value: now.getFullYear()},
                });
            },
            removeEducation(idx) {
                this.educations.splice(idx, 1)
            },
            validateData() {
                return new Promise((rs, rj) => {
                    let data = [], invalid = [];
                    if (this.educations.length <= 0) {
                        rs([]);
                    }
                    this.educations.forEach(edu => {
                        let check = this.$utils.clone(edu);
                        check.degree = (check.degree && check.degree.value) || null;
                        check.year_of_graduated = (check.year_of_graduated && check.year_of_graduated.value) || null;
                        this.$utils.Validate(check, {
                            'degree': ['required', {max: 191}],
                            'study_field': ['required', {max: 191}],
                            'university': ['required', {max: 191}],
                            'year_of_graduated': ['required', {max: 191}],
                        }).then(res => {
                            edu.validate = {};//clear
                            data.push(res.validated);
                            if (data.length === this.educations.length) {
                                rs(data);
                            }
                        }).catch(err => {
                            if (err && err.errors) {
                                edu.validate = err.errors;
                                invalid.push(edu.validate);
                                rj(invalid)
                            }
                        });
                    });
                })
            },
            save() {
                let dt = 3800;
                this.validateData().then(res => {
                    this.isLoading = true;
                    this.postManageMemberEducations(res)
                        .then(r => {
                            this.isLoading = false;
                            if (r.success) {
                                this.$emit('onSaved', r.data);
                                this.showInfoToast({msg: 'Your educations was successfully saved!', dt});
                            } else {
                                this.showErrorToast({msg: 'Failed to save your educations!', dt});
                            }
                        }).catch(e => {
                        this.showErrorToast({msg: 'Failed to save your educations!', dt});
                        this.isLoading = false;
                    })
                }).catch(err => {
                    this.showErrorToast({
                        msg: "The given data was invalid. Please check your form again!",
                        dt
                    });
                });
            }
        }
    }
</script>
<style scoped>
    .admin-template-form button.edit-button.add-education {
        top: 4px;
        right: 2px;
    }

    .educations-splitter {
        margin-bottom: 14px;
        border-bottom: 1px solid rgba(0, 0, 0, .1);
    }

    .admin-master-card-template .actions {
        padding-top: 0;
        padding-bottom: 14px;
    }
</style>
