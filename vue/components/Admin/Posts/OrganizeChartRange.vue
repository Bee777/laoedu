<template>
    <div>
        <Tabs :selectedTab="selectedTab" @ItemClick="(t)=>selectedTab=t" :offsetLeft="getSideBarWidthForTabs()"
              :tabs="tabs"/>
        <div class="module_content layout-column">
            <div class="module_authentication">
                <!-- Start tab id 2 -->
                <template v-if="selectedTab.id==2">
                    <div>
                        <OrganizeChartMember :chartRange="selectedChartRange" @onBackButtonClick="()=> selectedTab=tabs[0]"/>
                    </div>
                </template>
                <!-- End tab id 2 -->

                <!-- Start tab id 2 -->
                <template v-if="selectedTab.id==3">
                    <div>
                        <OrganizeInfo/>
                    </div>
                </template>
                <!-- End tab id 2 -->
                <!-- Start tab id 1 -->
                <template v-else-if="selectedTab.id==1">
                    <div class="module-canvas">
                        <div class="md-single-grid provider-list">
                            <!--Table card-->
                            <TablePaginate
                                v-model="query"
                                :searchPlaceholder="'Search by name, position order'"
                                :searchButtonText="'Add'"
                                :headers="headers"
                                :notFoundText="'Please make sure you type or spell information correctly.'"
                                :isSearch="isSearch"
                                :isLoading="validated().loading_searches"
                                :formTopState="formTopState"
                                @onItemPerPageClick="getItems"
                                @onSearchActionButton="toggleFormTop(true)"
                                @onSearchReLoadButtonClick="getItems"
                                @onSearchInputEnter="getItems"
                                @onSearchInputClose="getItems"
                                @onRemoveChipText="getItems"
                                :paginateData="paginate"
                                @paginateNavigate="paginateNavigator">
                                <!--Slot Form Top -->
                                <template slot="form-top" v-if="formTopState.show">
                                    <form class="admin-form-card user-form" @submit.prevent>
                                        <div class="user-form-title">Add new chart range</div>
                                        <div class="layout-align-space-around-start layout-row">
                                            <AdminInput
                                                v-model="models.formTop.chart_name"
                                                :focus="true"
                                                :validateText="validated().chart_name"
                                                :label="'Chart name *'"
                                                :inputType="'text'"
                                            />
                                            <AdminInput
                                                v-model="models.formTop.position_order"
                                                :validateText="validated().position_order"
                                                :label="'Position Order'"
                                                :inputType="'text'"
                                                :containerClass="'is-second-input dense'"
                                                @onInputEnter="add()"
                                            />
                                        </div>
                                        <div class="user-form-action layout-align-end-center layout-row">
                                            <button @click="toggleFormTop(false)"
                                                    class="v-md-button secondary theme-blue">
                                                Cancel
                                            </button>
                                            <button @click="add()" class="v-md-button primary theme-blue"> Create
                                            </button>
                                        </div>
                                    </form>
                                </template>
                                <!--Slot Form Top -->
                                <!--Slot Actions row -->
                                <template slot-scope="{fireEvent, position, data}" slot="action-row">
                                    <button @click="addChartMember(data.column)" class="v-md-button v-md-icon-button">
                                        <i class="material-icons">account_box</i>
                                    </button>
                                    <button
                                        @click="toggleFormRowContent(fireEvent, position, {active: true})"
                                        class="v-md-button v-md-icon-button">
                                        <i class="material-icons v-icon">edit</i>
                                    </button>
                                    <button @click="deleteItem(data.column)" class="v-md-button v-md-icon-button">
                                        <i class="material-icons v-icon">delete</i>
                                    </button>
                                </template>
                                <!--Slot Actions row-->
                                <!--Slot Row Detail Content-->
                                <template slot-scope="{fireEvent, position, rowContent}" slot="form-row-detail">
                                    <div class="layout-align-space-around-start layout-row">
                                        <AdminInput
                                            v-model="rowContent.data.name"
                                            :validateText="rowContent.validated.chart_name"
                                            :label="'Chart name *'"
                                            :inputType="'text'"
                                            @onInputEnter="edit(fireEvent, rowContent.data, position)"
                                        />
                                        <AdminInput
                                            v-model="rowContent.data.position_order"
                                            :validateText="rowContent.validated.position_order"
                                            :label="'Position Order *'"
                                            :inputType="'text'"
                                            :containerClass="'is-second-input dense'"
                                            @onInputEnter="edit(fireEvent, rowContent.data, position)"
                                        />
                                    </div>
                                    <div
                                        class="user-form-action provider-list-actions layout-align-end-center layout-row">
                                        <button
                                            @click="toggleFormRowContent(fireEvent, position, {active: false})"
                                            class="v-md-button secondary theme-blue">Cancel
                                        </button>
                                        <button
                                            @click="edit(fireEvent, rowContent.data, position)"
                                            class="v-md-button primary theme-blue">Save
                                        </button>
                                    </div>
                                </template>
                                <!--Slot Row Detail Content-->
                            </TablePaginate>
                        </div>
                    </div>
                </template>
                <!-- End tab id 1 -->
            </div>
        </div>
        <!--Modal-->
        <!--warning-->
        <AdminModal :isActive="modal.type==='warning' && modal.active" @close="modal.active=false">
            <template slot="title">{{modal.name}}</template>
            <div class="fb-dialog-body-section">
                <div class="body-message-container has-icon is-warning">
                    <div class="inner">
                        <i class="material-icons m-icon">warning</i>
                        <div class="admin-modal-message">{{ modal.message }}</div>
                    </div>
                </div>
                <div>
                    <div class="form-label">Organize Chart Range Information</div>
                    <div
                        class="form-input-static-value"
                    >{{ `Name: ${modal.data.name} ${modal.data.lastname}`}}
                    </div>
                </div>
            </div>
            <template slot="actions">
                <button @click="positiveAction()" class="v-md-button warning">{{ modal.action.text }}</button>
            </template>
        </AdminModal>
        <!--warning -->
        <!--Modal -->
    </div>
</template>
<script>
    import AdminBase from "@bases/AdminBase.js";
    import OrganizeInfo from "@com/Admin/Posts/OrganizeInfo.vue";
    import OrganizeChartMember from "@com/Admin/Posts/OrganizeChartMember.vue";
    import {mapActions} from "vuex";

    export default AdminBase.extend({
        name: "OrganizationChartRange",
        components: {
            OrganizeInfo,
            OrganizeChartMember
        },
        data: () => ({
            title: "Organization Chart Ranges",
            type: "organizeChartRanges",
            watchers: true,
            tabs: [
                {id: 1, name: "Organize Chart Ranges"},
                {id: 2, name: "Organize Members"},
                {id: 3, name: "Organize info"},
            ],
            headers: [
                {class: "th-sortable", name: "Name", width: "40%"},
                {class: "hide-xs th-sortable", name: "Position Order", width: "15%"},
                {class: "hide-xs th-sortable", name: "Created", width: "20%"},
                {class: "th-not-sortable", name: "", width: "120"}
            ],
            models: {formTop: {imageSrc: null}},//override base data
            positions: [
                {text: "Header", value: "header", selected: true},
                {text: "Secretary", value: "secretary"}
            ],
            selectedTab: {id: 1},
            editor: null,
            selectedChartRange: {},
        }),
        watch: {
            selectedTab: function (n, o) {
                if (n.id == 1) {
                    this.setPageTitle(this.title);
                }
            }
        },
        methods: {
            ...mapActions([
                "postCreateOrganizeChartRange",
                "postUpdateOrganizeChartRange",
                "postDeleteOrganizeChartRange"
            ]),
            callbackBuildItem(data) {
                return {
                    rowContent: {
                        validated: {},
                        state: {active: false, loading: false},
                        wholeEdit: true,
                        options: this.$utils.clone(data.options),
                        data: data,
                        originData: this.$utils.clone(data), //clone to separate data for object
                    },
                    rows: [
                        {data: data.name, type: "id", class: "user-email"},
                        {
                            data: data.position_order,
                            type: "text",
                            class: "hide-xs"
                        },
                        {
                            data: data.created_at,
                            type: "text",
                            class: "hide-xs"
                        },
                        {
                            data: "",
                            type: "action",
                            class: "",
                            modal: {
                                name: "Delete Leader",
                                active: false,
                                type: "warning",
                                message: `When you delete the organize chart range, the organize chart range will be permanently deleted and cannot be un-deleted.`,
                                action: {
                                    act: this.postDeleteOrganizeChartRange,
                                    text: "Delete"
                                },
                                data: data
                            }
                        }
                    ]
                }
            },
            //positive action for modal buttons
            positiveAction() {
                this.modal.active = false; //close modal on positive button clicked
                let action = this.modal.action,
                    dt = 3500, //dt is toasted show length in time
                    data = this.modal.data; //set data from modal
                if (action.act) {
                    //@important action.act must non native functions
                    action
                        .act({id: data.id})
                        .then(r => {
                            if (r.success) {
                                this.showInfoToast({msg: "The organize chart range was deleted!", dt});
                                this.getItems();
                            } else {
                                this.showErrorToast({
                                    msg: "Failed to delete the organize chart range!",
                                    dt
                                });
                            }
                        })
                        .catch(e => {
                            this.showErrorToast({
                                msg: "Failed to delete the organize chart range!",
                                dt
                            });
                        });
                }
            },
            add() {
                let ft = this.formTopState;
                ft.loading = true;
                this.postCreateOrganizeChartRange(this.models.formTop)
                    .then(r => {
                        if (r.success) {
                            this.getItems();
                            ft.show = false;
                            this.models.formTop = {imageSrc: null};
                        }
                        ft.loading = false;
                    })
                    .catch(e => {
                        ft.loading = false;
                    });
            },
            edit(fireEvent, data, position) {
                let dt = 3500,
                    v = this.paginate.items[position.row].rowContent;
                this.toggleFormRowContent(
                    fireEvent,
                    position,
                    this.Event.loadingState().ActiveLoading
                );
                data.id = v.data.id;
                data.chart_name = data.name;
                this.postUpdateOrganizeChartRange(data)
                    .then(r => {
                        if (r.success) {
                            this.showInfoToast({msg: "The organize chart range was updated!", dt});
                            this.getItems();
                        } else {
                            this.showErrorToast({
                                msg: "Failed to update the organize chart range!",
                                dt
                            });
                        }
                        this.toggleFormRowContent(
                            fireEvent,
                            position,
                            this.Event.loadingState().NorActiveLoading
                        );
                    })
                    .catch(err => {
                        v.validated = {};
                        if (err && err.errors) {
                            this.toggleFormRowContent(
                                fireEvent,
                                position,
                                this.Event.loadingState().ActiveNotLoading
                            );
                            v.validated = this.validated();
                            this.setClearMsg();//clear validated
                            this.showInvalidFormValidation();
                        } else {
                            this.showErrorToast({
                                msg: "Failed to update the organize chart range!",
                                dt
                            });
                            this.toggleFormRowContent(
                                fireEvent,
                                position,
                                this.Event.loadingState().NorActiveLoading
                            );
                        }
                    });
            },
            deleteItem(data) {
                data.modal.active = true;
                this.modal = data.modal;
            },
            addChartMember(data) {
                this.selectedChartRange = data.modal.data;
                this.selectedTab = this.tabs[1];//set select at tab 2 index 1
            }
        },
        created() {
            this.getItems = this.debounce(this.getItems, 150);
            this.getItems();
        }
    });
</script>

