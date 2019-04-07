<template>
    <div>
        <Tabs :bgColor="theme.bgColor" :offsetLeft="getSideBarWidthForTabs()" :tabs="tabs"/>
        <div class="module_content layout-column">
            <div class="module_authentication">
                <div class="module-canvas">
                    <div class="md-single-grid provider-list">
                        <!--Table card-->
                        <TablePaginate
                            v-model="query"
                            :searchPlaceholder="'Search by Lao, Japanese'"
                            :searchButtonText="'Add Dictionary'"
                            :headers="headers"
                            :notFoundText="'Please make sure you type or spell the Lao, Japanese information correctly.'"
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
                                    <div class="user-form-title">Create new dictionary</div>
                                    <div class="layout-align-space-around-start layout-row">
                                        <AdminInput
                                            v-model="models.formTop.lao"
                                            :focus="true"
                                            :validateText="validated().lao"
                                            :label="'Lao'"
                                            :inputType="'text'"
                                        />
                                        <AdminInput
                                            v-model="models.formTop.japanese"
                                            :validateText="validated().japanese"
                                            :label="'Japanese'"
                                            :inputType="'text'"
                                            :containerClass="'is-second-input'"
                                        />
                                    </div>
                                    <div class="layout-align-space-around-start layout-row">
                                        <AdminInput
                                            v-model="models.formTop.description"
                                            :validateText="validated().description"
                                            :label="'Description'"
                                            :rows="6"
                                            :inputType="'textarea'"
                                            @onInputEnter="addDictionary"
                                        />
                                    </div>
                                    <div class="user-form-action layout-align-end-center layout-row">
                                        <button
                                            @click="toggleFormTop(false)"
                                            class="v-md-button secondary theme-blue"
                                        >Cancel
                                        </button>
                                        <button @click="addDictionary" class="v-md-button primary theme-blue">Create
                                        </button>
                                    </div>
                                </form>
                            </template>
                            <!--Slot Form Top -->
                            <!--Slot Actions row -->
                            <template slot-scope="{fireEvent, position, data}" slot="action-row">
                                <button
                                    @click="toggleFormRowContent(fireEvent, position, {active: true})"
                                    class="v-md-button v-md-icon-button"
                                >
                                    <i class="material-icons v-icon">edit</i>
                                </button>
                                <button @click="deleteDictionary(data.column)" class="v-md-button v-md-icon-button">
                                    <i class="material-icons v-icon">delete</i>
                                </button>
                            </template>
                            <!--Slot Actions row-->
                            <!--Slot Row Detail Content-->
                            <template slot-scope="{fireEvent, position, rowContent}" slot="form-row-detail">
                                <div class="layout-align-space-around-start layout-row">
                                    <AdminInput
                                        v-model="rowContent.data.lao"
                                        :validateText="rowContent.validated.lao"
                                        :label="'Lao'"
                                        :inputType="'text'"
                                        @onInputEnter="editDictionary(fireEvent, rowContent.data, position)"
                                    />

                                    <AdminInput
                                        v-model="rowContent.data.japanese"
                                        :containerClass="'is-second-input'"
                                        :validateText="rowContent.validated.japanese"
                                        :label="'Japanese'"
                                        :inputType="'text'"
                                        @onInputEnter="editDictionary(fireEvent, rowContent.data, position)"
                                    />
                                </div>

                                <div class="layout-align-space-around-start layout-row">
                                    <AdminInput
                                        v-model="rowContent.data.description"
                                        :validateText="rowContent.validated.description"
                                        :label="'Description'"
                                        :rows="6"
                                        :inputType="'textarea'"
                                        @onInputEnter="editDictionary(fireEvent, rowContent.data, position)"
                                    />
                                </div>

                                <div
                                    class="user-form-action provider-list-actions layout-align-end-center layout-row">
                                    <button
                                        @click="toggleFormRowContent(fireEvent, position, {active: false})"
                                        class="v-md-button secondary theme-blue"
                                    >Cancel
                                    </button>
                                    <button
                                        @click="editDictionary(fireEvent, rowContent.data, position)"
                                        class="v-md-button primary theme-blue"
                                    >Save
                                    </button>
                                </div>
                            </template>
                            <!--Slot Row Detail Content-->
                        </TablePaginate>
                    </div>
                </div>
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
                    <div class="form-label">Dictionary Information</div>
                    <div class="form-input-static-value">{{ `${modal.data.lao}, ${modal.data.japanese}` }}</div>
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
    import {mapActions} from "vuex";

    export default AdminBase.extend({
        name: "dictionary",
        data: () => ({
            title: "Dictionaries",
            type: "dictionaries",
            watchers: true,
            tabs: [{name: "Dictionaries"}],
            headers: [
                {class: "th-sortable", name: "Lao", width: "100"},
                {class: "th-sortable", name: "Japanese", width: "100"},
                {class: "hide-xs th-sortable", name: "Description", width: "30%"},
                {class: "th-not-sortable", name: "", width: "80"}
            ]
        }),
        methods: {
            ...mapActions([
                "postCreateDictionary",
                "postUpdateDictionary",
                "postDeleteDictionary"
            ]),
            callbackBuildItem(data) {
                return {
                    rowContent: {
                        validated: {},
                        state: {active: false, loading: false},
                        originData: this.$utils.clone(data), //clone to separate data for object
                        data: data,
                        wholeEdit: true
                    },
                    rows: [
                        {data: data.lao, type: "id", class: "user-email"},
                        {
                            data: data.japanese,
                            type: "text",
                        },
                        {
                            data: data.description,
                            type: "text",
                            class: "hide-xs"
                        },
                        {
                            data: "",
                            type: "action",
                            class: "",
                            modal: {
                                name: "Delete Dictionary",
                                active: false,
                                type: "warning",
                                message: `When you delete the dictionary, the dictionary will be permanently deleted and cannot be un-deleted.`,
                                action: {act: this.postDeleteDictionary, text: "Delete"},
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
                                this.showInfoToast({msg: "The dictionary was deleted!", dt});
                                this.getItems();
                            } else {
                                this.showErrorToast({
                                    msg: "Failed to delete the dictionary!",
                                    dt
                                });
                            }
                        })
                        .catch(e => {
                            this.showErrorToast({
                                msg: "Failed to delete the dictionary!",
                                dt
                            });
                        });
                }
            },
            addDictionary() {
                let ft = this.formTopState;
                ft.loading = true;
                this.postCreateDictionary(this.models.formTop)
                    .then(r => {
                        if (r.success) {
                            this.getItems();
                            ft.show = false;
                            this.models.formTop = {};
                        }
                        ft.loading = false;
                    })
                    .catch(e => {
                        ft.loading = false;
                    });
            },
            editDictionary(fireEvent, data, position) {
                let dt = 3500,
                    v = this.paginate.items[position.row].rowContent;
                this.toggleFormRowContent(
                    fireEvent,
                    position,
                    this.Event.loadingState().ActiveLoading
                );
                this.postUpdateDictionary(data)
                    .then(r => {
                        if (r.success) {
                            this.showInfoToast({msg: "The dictionary was updated!", dt});
                            this.getItems();
                        } else {
                            this.showErrorToast({
                                msg: "Failed to update the dictionary!",
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
                                msg: "Failed to update the dictionary!",
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
            deleteDictionary(data) {
                data.modal.active = true;
                this.modal = data.modal;
            }
        },
        created() {
            this.getItems = this.debounce(this.getItems, 150);
            this.getItems();
        }
    });
</script>
