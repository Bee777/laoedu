<template>
    <div class="module-canvas emails-card-wrapper no-tip  no-border" ref="module-canvas">
        <MasterSingleDetailCard
            :isLoading="isLoading"
            @onBackButtonClick="onBackButtonClick"
            :header="{ title: 'Organization chart members', content: '<p> Add, Changes, Delete organize chart members.</p>'}"
            :menuItem="{ name: 'Organization chart members', icon: 'account_circle'}">
            <div class="admin-settings-cameo template-brand-settings">
                <div class="settings-container no-border-left add-padding no-margin-top" border-bottom>
                    <div class="cameo-header">
                        <i class="material-icons cameo-header-icon">insert_chart</i>
                        <span> Select A Organization Chart Range</span>
                    </div>

                    <div class="cameo-content">
                        <div class="layout-align-space-around-start layout-row">
                            <!-- Filter by Type of organization-->
                            <div class="form-multi-select-container flex dense" full>
                                <label>Organization Chart Range</label>
                                <multiselect class="select-multiple"
                                             v-model="filters.chart_range"
                                             label="name" track-by="id"
                                             placeholder="Select chart range"
                                             open-direction="bottom"
                                             :options="chartRanges"
                                             :show-no-results="false"
                                             :preserve-search="true"
                                             :hide-selected="false"
                                             @input="getItems">
                                </multiselect>
                                <template v-if="validated().chart_range">
                                    <div class="form-input-container">
                                        <input v-show="false"/>
                                        <div admin-messages>
                                            <div admin-message class="message-required ">
                                                {{ validated().chart_range }}
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="admin-settings-cameo template-brand-settings">
                <div class="settings-container no-border-left add-padding no-margin-top" border-bottom>

                    <div class="cameo-header">
                        <i class="material-icons cameo-header-icon">account_box</i>
                        <span>Add / Update Member Information</span>
                    </div>
                    <div class="cameo-content">
                        <!--Member Image -->
                        <div class="layout-align-space-around-start layout-row">
                            <div class="form-input-container dense">
                                <label class="is-center"> Profile Picture *</label>
                                <div class="user-picture-link-inner in-image-side-form is-edit"
                                     @click="chooseProfileImage">
                                    <div title="profile"
                                         class="user-picture-link-inner-title">
                                        <img style="width: 100%; height: 100%;"
                                             v-if="member.image_base64!==''"
                                             :src="`${member.image_base64}`">
                                        <img v-else
                                             :style="`${getImageStyleProfile()}`"
                                             :src="`${baseUrl}${member.image}`">
                                    </div>
                                    <span class="user-picture-link-change is-black">Change</span>
                                </div>
                                <AdminInput ref="profile-image" v-show="false"
                                            @inputImageBase64="(d)=>member.image_base64=d"
                                            @inputFile="(d)=> member.image=d"
                                            :inputType="'file'"/>

                                <div admin-messages
                                     v-if="validated().image">
                                    <div admin-message class="message-required ">
                                        {{ validated().image }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--Member Image-->
                        <div class="layout-align-space-around-start layout-row">
                            <AdminInput :label="'Name *'"
                                        v-model="member.name"
                                        :validateText="validated().name"
                                        :containerClass="'dense'"
                                        :inputType="'text'">
                            </AdminInput>
                            <AdminInput :label="' Last name *'"
                                        v-model="member.last_name"
                                        :validateText="validated().last_name"
                                        :containerClass="'is-second-input dense'"
                                        :inputType="'text'">
                            </AdminInput>
                        </div>
                        <div class="layout-align-space-around-start layout-row">

                            <div class="form-multi-select-container flex dense" full>
                                <label>Position *</label>
                                <multiselect class="select-multiple"
                                             v-model="member.position"
                                             label="name" track-by="id"
                                             placeholder="Select a position"
                                             open-direction="bottom"
                                             :options="memberPositions"
                                             :show-no-results="false"
                                             :preserve-search="true"
                                             :hide-selected="false">
                                </multiselect>
                                <template v-if="validated().position">
                                    <div class="form-input-container">
                                        <input v-show="false"/>
                                        <div admin-messages>
                                            <div admin-message class="message-required ">
                                                {{ validated().position }}
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </div>
                            <AdminInput :label="' Position Order '"
                                        v-model="member.position_order"
                                        :validateText="validated().position_order"
                                        :containerClass="'is-second-input dense'"
                                        :inputType="'text'">
                            </AdminInput>
                        </div>
                        <div class="layout-align-space-around-start layout-row"
                             v-if="member.position && member.position.value==='other'">
                            <AdminInput :label="'Name Your Position *'"
                                        v-model="member.other_position"
                                        :validateText="validated().other_position"
                                        :inputType="'text'">
                            </AdminInput>
                        </div>

                        <div class="layout-align-space-around-start layout-row">
                            <AdminInput :label="'University (Graduated Year) *'"
                                        v-model="member.university"
                                        :validateText="validated().university"
                                        :inputType="'text'">
                            </AdminInput>
                        </div>

                        <div class="layout-align-space-around-start layout-row">
                            <AdminInput :label="'Designation / Company'"
                                        v-model="member.company"
                                        rows="3"
                                        :validateText="validated().company"
                                        :inputType="'textarea'">
                            </AdminInput>
                        </div>


                        <!--Actions Member -->
                        <div class="actions ">
                            <div class="layout-align-end-center layout-row">
                                <button v-if="isEdit"
                                        class="v-md-button secondary"
                                        @click="cancelEdit">
                                    Cancel
                                </button>
                                <button @click="chartMemberMange" class="v-md-button primary">
                                    {{ isEdit ? 'Save Changes' : 'Add Member' }}
                                </button>
                            </div>
                        </div>
                        <!--Actions Member-->
                    </div>
                </div>
            </div>
            <!-- President-->
            <div class="admin-settings-cameo template-brand-settings">
                <div class="settings-container no-border-left add-padding no-margin-top" border-bottom>
                    <div class="cameo-header">
                        <i class="material-icons cameo-header-icon">face</i>
                        <span>President  Member</span>
                    </div>
                </div>
            </div>
            <div class="details is-edit no-border-top  add-border-bottom">
                <div class="represent-search">
                    <div class="is-index">
                        <div class="admin-card-list">
                            <div class="link-card-container" v-if="members.president && !$utils.isEmptyObject(members.president)">
                                <div class="link-card admin-mat-card">
                                    <div class="is-card-header">
                                        <img :alt="members.president.name" class="is-card-logo"
                                             :src="`${baseUrl}${members.president.image}`">
                                        <h1 class="is-card-logo-text">{{`${$utils.firstUpper(members.president.name)}
                                            ${$utils.firstUpper(members.president.surname)}`}}</h1>
                                    </div>
                                    <div class="is-link-card-content admin-mat-card-content">
                                        <div class="is-card-body">
                                            <div class="is-icon-description-row">
                                                <span class="is-description">
                                                    Position: {{ String(members.president.position_text).replace(/_/g, ' ') }} <br>
                                                    University (Year): {{members.president.university}} <br>
                                                    Company: {{ members.president.company || emptyText }}<br>
                                                    Order: {{members.president.position_order }}
                                                </span>
                                            </div>
                                        </div>

                                        <div class="displayFlex is-card-footer">
                                            <button @click="deleteMember(members.president)"
                                                    class="v-mat-button warning is-card-footer is-link">
                                                <span class="v-mat-button-wrapper">Delete</span>
                                            </button>
                                            <button @click="editMember(members.president)"
                                                    class="v-mat-button primary is-card-footer is-link">
                                            <span class="v-mat-button-wrapper">
                                                Edit
                                                <i class="admin-mat-icon material-icons is-arrow-icon" role="img"
                                                   aria-hidden="true">arrow_forward</i></span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--President-->
            <!--Vice President-->
            <div class="admin-settings-cameo template-brand-settings">
                <div class="settings-container no-border-left add-padding no-margin-top" border-bottom>
                    <div class="cameo-header">
                        <i class="material-icons cameo-header-icon">account_circle</i>
                        <span>Vice President Members</span>
                    </div>
                </div>
            </div>
            <div class="details is-edit no-border-top  add-border-bottom">
                <div class="represent-search">
                    <div class="is-index">
                        <div class="admin-card-list">
                            <!--User Card -->
                            <div class="link-card-container" v-for="(item, idx) in members.vice_president"
                                 :key="idx">
                                <div class="link-card admin-mat-card">
                                    <div class="is-card-header">
                                        <img :alt="item.name" class="is-card-logo"
                                             :src="`${baseUrl}${item.image}`">
                                        <h1 class="is-card-logo-text">{{`${$utils.firstUpper(item.name)}
                                            ${$utils.firstUpper(item.surname)}`}}</h1>
                                    </div>
                                    <div class="is-link-card-content admin-mat-card-content">
                                        <div class="is-card-body">
                                            <div class="is-icon-description-row">
                                                <span class="is-description">
                                                    Position: {{ String(item.position_text).replace(/_/g, ' ') }} <br>
                                                    University (Year): {{item.university}} <br>
                                                    Company: {{ item.company || emptyText }}<br>
                                                    Order: {{item.position_order }}
                                                </span>
                                            </div>
                                        </div>

                                        <div class="displayFlex is-card-footer">
                                            <button @click="deleteMember(item)"
                                                    class="v-mat-button warning is-card-footer is-link">
                                                <span class="v-mat-button-wrapper">Delete</span>
                                            </button>
                                            <button @click="editMember(item)"
                                                    class="v-mat-button primary is-card-footer is-link">
                                            <span class="v-mat-button-wrapper">
                                                Edit
                                                <i class="admin-mat-icon material-icons is-arrow-icon" role="img"
                                                   aria-hidden="true">arrow_forward</i></span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--User Card -->
                        </div>
                    </div>
                </div>
            </div>
            <!--Vice President-->

            <!--Search Input-->
            <SearchInput
                v-model="query"
                searchButtonText="Search"
                searchPlaceholder="Search by member name, surname or member position for committee and other position."
                @onSearchActionButton="getItems"
                @onSearchReLoadButtonClick="getItems"
                @onSearchInputEnter="getItems"
                @onSearchInputClose="getItems"
                @onRemoveChipText="getItems"/>
            <!--Search Input-->
            <div class="admin-settings-cameo template-brand-settings">
                <div class="settings-container no-border-left add-border-top add-padding no-margin-top" border-bottom>
                    <div class="cameo-header">
                        <i class="material-icons cameo-header-icon">group</i>
                        <span>Committee & Other Members Position</span>
                    </div>
                </div>
            </div>
            <div class="details is-edit no-border-top  add-border-bottom">
                <div class="represent-search">
                    <div class="is-index">
                        <div class="admin-card-list">
                            <!--All Members Card -->
                            <div class="link-card-container" v-for="(item, idx) in members.data" :key="idx">
                                <div class="link-card admin-mat-card">
                                    <div class="is-card-header">
                                        <img :alt="item.name" class="is-card-logo"
                                             :src="`${baseUrl}${item.image}`">
                                        <h1 class="is-card-logo-text">{{`${$utils.firstUpper(item.name)}
                                            ${$utils.firstUpper(item.surname)}`}}</h1>
                                    </div>
                                    <div class="is-link-card-content admin-mat-card-content">
                                        <div class="is-card-body">
                                            <div class="is-icon-description-row">
                                                <span class="is-description">
                                                    Position: {{ String(item.position_text).replace(/_/g, ' ') }} <br>
                                                    University (Year): {{item.university}} <br>
                                                    Company: {{ item.company || emptyText }}<br>
                                                    Order: {{item.position_order }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="displayFlex is-card-footer">
                                            <button @click="deleteMember(item)"
                                                    class="v-mat-button warning is-card-footer is-link">
                                                <span class="v-mat-button-wrapper">Delete</span>
                                            </button>
                                            <button @click="editMember(item)"
                                                    class="v-mat-button primary is-card-footer is-link">
                                            <span class="v-mat-button-wrapper">
                                                Edit
                                                <i class="admin-mat-icon material-icons is-arrow-icon" role="img"
                                                   aria-hidden="true">arrow_forward</i></span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--All Members Card -->
                        </div>
                    </div>
                </div>
            </div>

            <!--Modals -->
            <!--warning-->
            <AdminModal :scrollContainer="jq('#main-container')" :parentHeight="$refs['module-canvas']"
                        :isActive="modal.active"
                        @close="modal.active=false">
                <template slot="title"> {{modal.name}}</template>
                <div class="fb-dialog-body-section">
                    <div class="body-message-container has-icon is-warning">
                        <div class="inner">
                            <i class="material-icons m-icon">warning</i>
                            <div class="admin-modal-message">{{ modal.message }}</div>
                        </div>
                    </div>
                    <div>
                        <div class="form-label"> Member Information</div>
                        <div class="form-input-static-value">Name: {{ modal.data.name }}, Position: {{
                            String(modal.data.position_text).replace(/_/g, ' ') }}
                        </div>
                    </div>
                </div>
                <template slot="actions">
                    <button @click="positiveAction()" class="v-md-button warning"> {{ modal.action.text }}</button>
                </template>
            </AdminModal>
            <!--warning -->
            <!--Modals -->

        </MasterSingleDetailCard>
    </div>
</template>

<script>
    import AdminBase from "@bases/AdminBase.js";
    import {mapActions} from "vuex";
    import SearchInput from '@cus-com/Admin/SearchInput.vue'

    export default AdminBase.extend({
        name: "OrganizeChartMember",
        components: {
            SearchInput
        },
        props: {
            chartRange: {
                type: Object,
                default: function () {
                    return {};
                }
            }
        },
        data: () => ({
            title: "Organization Chart Members",
            member: {image_base64: '', image: `/assets/images/${settings['website_logo']}`},
            filters: {chart_range: {}},
            chartRanges: [],
            memberPositions: [],
            isEdit: false,
            isLoading: false,
            emptyText: 'Not specified',
            members: {vice_president: [], president: {}},
            defaultPosition: [
                {id: 1, name: 'President', value: 'president'},
                {id: 2, name: 'Vice President', value: 'vice_president'},
                {id: 3, name: 'Committee', value: 'committee'},
                {id: 4, name: 'Other', value: 'other'}
            ]
        }),
        methods: {
            ...mapActions(['fetchChartRanges', 'fetchMembersChartRange', 'postCreateMemberChart',
                'postUpdateMemberChart', 'postDeleteMemberChart']),
            onBackButtonClick() {
                this.$emit('onBackButtonClick');
            },
            getImageStyleProfile() {
                return `width: 100%; height: 100%`
            },
            chooseProfileImage() {
                this.$refs['profile-image'].triggerInputClick();
            },
            setPositionOptions() {
                this.memberPositions = this.$utils.clone(this.defaultPosition);
            },
            getItems() {
                this.cancelEdit();//cancel current editing
                this.isLoading = true;
                if (this.filters.chart_range) {
                    this.filters.chart_range.query = this.query;//set for user query
                }
                this.fetchMembersChartRange(this.filters.chart_range)
                    .then(res => {
                        if (res.data.success) {
                            this.setPositionOptions();
                            if (res.data.president) {
                                this.memberPositions.splice(0, 1);
                            }
                            this.members = res.data;
                        }
                        this.isLoading = false;
                    })
                    .catch(err => {
                        console.log(err);
                        this.isLoading = false;
                    })
            },
            setFilterRanges(ranges) {
                this.filters.chart_range = ranges;
                if (!this.$utils.isEmptyObject(ranges)) {
                    this.getItems();
                }
            },
            chartMemberMange() {
                let dt = 3500;
                this.isLoading = true;
                if (this.isEdit) {
                    this.member.chart_range = this.filters.chart_range ? this.filters.chart_range.id : '';
                    this.postUpdateMemberChart(this.member)
                        .then(res => {
                            this.cancelEdit();
                            this.showInfoToast({msg: "The member chart was updated!", dt});
                            this.getItems();
                        })
                        .catch(err => {
                            if (err && !err.errors) {
                                this.showErrorToast({
                                    msg: "Failed to update the member chart!",
                                    dt
                                });
                            }
                            this.isLoading = false;
                        });
                } else {
                    this.member.chart_range = this.filters.chart_range ? this.filters.chart_range.id : '';
                    this.postCreateMemberChart(this.member)
                        .then(res => {
                            this.cancelEdit();
                            this.showInfoToast({msg: "The member chart was added!", dt});
                            this.getItems();
                        })
                        .catch(err => {
                            if (err && err.errors) {
                                this.showInvalidFormValidation();
                            } else {
                                this.showErrorToast({
                                    msg: "Failed to create the member chart!",
                                    dt
                                });

                            }
                            this.isLoading = false;
                        });
                }
            },
            getOldPosition(current) {
                let p;
                p = this.defaultPosition.filter(f => {
                    return f.value === current;
                });
                if (p.length <= 0) {
                    p = this.defaultPosition.filter(f => {
                        return f.value === 'other';
                    });
                }
                return p[0];
            },
            cancelEdit() {
                this.member = {
                    image_base64: '',
                    image: `/assets/images/${this.s['website_logo']}`
                };
                this.isEdit = false;
                this.setPositionOptions();
                if (this.members.president) {
                    this.memberPositions.splice(0, 1);
                }
            },
            editMember(data) {
                //set item back
                this.isEdit = true;
                if (data.position === 'president') {//reset for president position
                    this.setPositionOptions();
                }
                this.member = this.$utils.clone(data);
                this.member.last_name = this.member.surname;
                this.member.position = this.getOldPosition(this.member.position);
                if (this.member.position.value === 'other') {//check if other position
                    this.member.other_position = data.position;
                }
                this.$utils.scrollToY('main-container', this.$utils.findPos(this.$refs['form-member']).y);
                //set item back
            },
            deleteMember(data) {
                this.modal = {
                    name: 'Delete Member Chart',
                    active: true,
                    message: `When you delete the member chart, the member chart will be permanently deleted and cannot be un-deleted.`,
                    action: {act: this.postDeleteMemberChart, text: 'Delete'},
                    data: data,
                };
            },
            positiveAction() {
                this.modal.active = false;//close modal on positive button clicked
                let action = this.modal.action, dt = 3500, //dt is toasted show length in time
                    data = {...this.modal.data, ...action.params}; //set data from modal
                if (action.act) {//@important action.act must non native functions
                    action.act({id: data.id, data})
                        .then(r => {
                            if (r.success) {
                                this.showInfoToast({msg: 'The member chart was deleted!', dt});
                                this.getItems();
                            } else {
                                this.showErrorToast({msg: 'Failed to delete the member chart!', dt});
                            }
                        })
                        .catch(e => {
                            this.showErrorToast({msg: 'Failed to delete the member chart!', dt});
                        });
                }
            },
            init() {
                this.setFilterRanges(this.chartRange);
            }
        },
        created() {
            this.fetchChartRanges()
                .then(res => {
                    this.chartRanges = res.data;
                    if (this.$utils.isEmptyObject(this.filters.chart_range)) {
                        this.setFilterRanges(this.chartRanges[0]);
                    }
                })
                .catch(err => {
                    console.log(err)
                });
            this.init();
        }
    });
</script>

<style scoped>
    .actions {
        padding-bottom: 25px;
    }
</style>
