<template>
    <!--Education Info -->
    <div class="admin-settings-cameo template-brand-settings admin-spinner-covered">
        <SpinnerLoading v-if="isLoading"/>
        <button v-if="isEdit" @click="addCareer"
                class="v-md-button v-md-icon-button edit-button add-career "><i
            class="material-icons">add_circle</i></button>

        <div class="settings-container no-border-left no-margin-top"
             border-bottom>

            <div class="cameo-header">
                <i class="material-icons cameo-header-icon">work</i>
                <span> Career Information</span>
            </div>
            <div class="cameo-content" v-if="careers.length <=0">
                <div class="layout-align-center-start layout-row "
                     style="margin-bottom: 16px;">
                    <span class="template-tip">{{ emptyText }}</span>
                </div>
            </div>

            <div class="cameo-content" :class="[{'careers-splitter' : idx+1 < careers.length}]"
                 v-for="(item, idx) in careers"
                 :key="idx">
                <div
                    class="layout-align-center-start cameo-header splitter layout-row"><span>{{idx+1}}. Career year {{ item.start_year.text }} - {{ item.end_year.text }} {{ idx === 0 ? '(Current Career)': ''}} </span>
                    <button v-if="isEdit" @click="removeCareer(idx)"
                            class="v-md-button remove-button v-md-icon-button"><i
                        class="material-icons">remove_circle</i></button>
                </div>
                <div class="layout-align-space-around-start layout-row">
                    <AdminInput :label="'Member of State'"
                                :containerClass="'dense'"
                                v-model="item.member_of_state"
                                :validateText="item.validate.member_of_state"
                                :inputType="'checkbox'">
                        <p class="template-tip"
                           v-if="getMemberState(item)">
                            {{ item.member_of_state ? "Yes" : "No"}}</p>
                        <p class="template-tip"
                           v-else>{{ emptyText }}</p>
                    </AdminInput>
                </div>

                <div v-if="item.member_of_state"
                     class="layout-align-space-around-start layout-row">
                    <AdminInput
                        :containerClass="'dense'"
                        v-model="item.government_agency"
                        :validateText="item.validate.government_agency"
                        :customClass="'is-input-height-same-multiple'"
                        :label="'Government Agency'"
                        :inputType="'text'">
                        <p class="template-tip">{{
                            item.government_agency ||
                            emptyText }}</p></AdminInput>
                </div>

                <div class="layout-align-space-around-start layout-row">
                    <div class="form-multi-select-container flex dense" full>
                        <label>Organization</label>
                        <multiselect v-if="!isDisplay" class="select-multiple"
                                     v-model="item.type_of_organize"
                                     label="label" track-by="value"
                                     placeholder="Select type of Organization"
                                     open-direction="bottom"
                                     :options="options.organization"
                                     :show-no-results="false"
                                     :preserve-search="true"
                                     :hide-selected="false">
                        </multiselect>
                        <p class="template-tip">{{ (item.type_of_organize && item.type_of_organize.label) || emptyText
                            }}</p>
                        <template v-if="item.validate.type_of_organize">
                            <div class="form-input-container">
                                <input v-show="false"/>
                                <div admin-messages>
                                    <div admin-message
                                         class="message-required ">
                                        {{ item.validate.type_of_organize }}
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

                <div class="layout-align-space-around-start layout-row">
                    <div class="form-multi-select-container flex dense" full>
                        <label>Work Categories</label>
                        <multiselect v-if="!isDisplay" class="select-multiple"
                                     v-model="item.work_categories"
                                     label="label" track-by="value"
                                     placeholder="Select work categories"
                                     open-direction="bottom"
                                     :limit="10"
                                     :limit-text="limitText"
                                     :options="options.workCategories"
                                     :multiple="true"
                                     :clear-on-select="false"
                                     :close-on-select="false"
                                     :preserve-search="true"
                                     :hide-selected="true">
                        </multiselect>
                        <p class="template-tip"
                           v-if="item.work_categories && item.work_categories.length > 0">
                            {{$utils.arrayToText(item.work_categories,
                            'label') }}</p>
                        <p class="template-tip" v-else>{{ emptyText }}</p>

                        <template v-if="item.validate.work_categories">
                            <div class="form-input-container">
                                <input v-show="false"/>
                                <div admin-messages>
                                    <div admin-message
                                         class="message-required ">
                                        {{ item.validate.work_categories }}
                                    </div>
                                </div>
                            </div>
                        </template>

                    </div>
                </div>
                <div class="layout-align-space-around-start layout-row">
                    <div
                        class="form-multi-select-container flex dense"
                        full>

                        <label>Start Year</label>
                        <multiselect v-if="!isDisplay" class="select-multiple"
                                     v-model="item.start_year"
                                     label="text" track-by="value"
                                     placeholder="Select year"
                                     open-direction="bottom"
                                     :options="yearsOptions"
                                     :show-no-results="false"
                                     :preserve-search="true"
                                     :hide-selected="false">
                        </multiselect>
                        <p class="template-tip">{{
                            (item.start_year && item.start_year.text) || emptyText}}</p>
                        <template v-if="item.validate.start_year">
                            <div class="form-input-container">
                                <input v-show="false"/>
                                <div admin-messages>
                                    <div admin-message
                                         class="message-required ">
                                        {{ item.validate.start_year }}
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                    <div
                        class="form-multi-select-container flex dense is-second-input"
                        full>
                        <label>End Year</label>
                        <multiselect v-if="!isDisplay" class="select-multiple"
                                     v-model="item.end_year"
                                     label="text" track-by="value"
                                     placeholder="Select year"
                                     open-direction="bottom"
                                     :options="yearsOptions"
                                     :show-no-results="false"
                                     :preserve-search="true"
                                     :hide-selected="false">
                        </multiselect>
                        <p class="template-tip">{{
                            (item.end_year && item.end_year.text) || emptyText}}</p>
                        <template v-if="item.validate.end_year">
                            <div class="form-input-container">
                                <input v-show="false"/>
                                <div admin-messages>
                                    <div admin-message
                                         class="message-required ">
                                        {{ item.validate.end_year }}
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
        name: "CareerProfile",
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
            member_careers: {
                type: Array,
                default: function () {
                    return [];
                }
            },
            yearsOptions: {
                default: function () {
                    return [];
                }
            },
        },
        data: () => ({
            careers: [],
            isLoading: false,
        }),
        watch: {
            'member_careers': function (n, o) {
                this.careers = this.$utils.clone(n);
            }
        },
        methods: {
            ...mapActions(['showErrorToast', 'showInfoToast', 'postManageMemberCareers']),
            getMemberState(item) {
                let mbs = item.member_of_state;
                return mbs === true || mbs === false || mbs === 'true';
            },
            addCareer() {
                let now = new Date();
                this.careers.unshift({
                    validate: {},
                    member_of_state: false,
                    government_agency: '',
                    type_of_organize: {label: '', value: null},
                    work_categories: [],
                    start_year: {text: String(now.getFullYear() - 1), value: now.getFullYear() - 1},
                    end_year: {text: String(now.getFullYear()), value: now.getFullYear()},
                });
            },
            removeCareer(idx) {
                this.careers.splice(idx, 1)
            },
            limitText(count) {
                return `and ${count} more.`
            },
            validateData() {
                return new Promise((rs, rj) => {
                    let data = [], invalid = [];
                    if (this.careers.length <= 0) {
                        rs([]);
                    }
                    this.careers.forEach(cr => {
                        let check = this.$utils.clone(cr);
                        check.type_of_organize = (check.type_of_organize && check.type_of_organize.value) || null;
                        check.start_year = (check.start_year && check.start_year.value) || null;
                        check.end_year = (check.end_year && check.end_year.value) || null;
                        this.$utils.Validate(check, {
                            'member_of_state': [{max: 10}],
                            'start_year': ['required', {max: 191}],
                            'end_year': ['required', {max: 191}],
                            'work_categories': ['array', 'required'],
                            'type_of_organize': ['required'],
                            'government_agency': [{'required': {when: 'member_of_state', equals: true}}, {max: 191}]
                        }).then(res => {
                            cr.validate = {};//clear
                            data.push(res.validated);
                            if (data.length === this.careers.length) {
                                rs(data);
                            }
                        }).catch(err => {
                            if (err && err.errors) {
                                cr.validate = err.errors;
                                invalid.push(cr.validate);
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
                    this.postManageMemberCareers(res)
                        .then(r => {
                            this.isLoading = false;
                            if (r.success) {
                                this.$emit('onSaved', r.data);
                                this.showInfoToast({msg: 'Your careers was successfully saved!.', dt});
                            } else {
                                this.showErrorToast({msg: 'Failed to save your careers!.', dt});
                            }
                        }).catch(e => {
                        this.showErrorToast({msg: 'Failed to save your careers!', dt});
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
    .admin-template-form button.edit-button.add-career {
        top: 4px;
        right: 2px;
    }

    .careers-splitter {
        margin-bottom: 14px;
        border-bottom: 1px solid rgba(0, 0, 0, .1);
    }

    .admin-master-card-template .actions {
        padding-top: 0;
        padding-bottom: 14px;
    }
</style>
