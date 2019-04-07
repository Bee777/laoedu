<template>
    <div>
        <Tabs :bgColor="theme.bgColor" :offsetLeft="getSideBarWidthForTabs()" :tabs="tabs"/>
        <div class="module_content layout-column">
            <div class="module_authentication">
                <div class="module-canvas">
                    <div class="md-single-grid provider-list">
                        <TablePaginate
                            v-model="query"
                            :showSearchButton="false"
                            :searchPlaceholder="'Search by file name'"
                            :headers="headers"
                            :notFoundText="'Please make sure you type or spell the information correctly.'"
                            :isSearch="isSearch"
                            :isLoading="validated().loading_searches"
                            :formTopState="formTopState"
                            @onItemPerPageClick="getItems"
                            @onSearchReLoadButtonClick="getItems"
                            @onSearchInputEnter="getItems"
                            @onSearchInputClose="getItems"
                            @onRemoveChipText="getItems"
                            :paginateData="paginate"
                            @paginateNavigate="paginateNavigator">
                            <!--Slot Actions row -->
                            <template slot-scope="{fireEvent, position, data}" slot="action-row">
                                <button
                                    @click="downloadFile(data.column)"
                                    class="v-md-button v-md-icon-button">
                                    <i class="material-icons v-icon">cloud_download</i>
                                </button>
                            </template>
                            <!--Slot Actions row -->
                            <!--Slot Row Detail Content-->
                            <template slot-scope="{fireEvent, position, rowContent}" slot="form-row-detail">
                                <div></div>
                            </template>
                            <!--Slot Row Detail Content-->
                        </TablePaginate>
                    </div>
                </div>
            </div>
        </div>
        <iframe id="file_download" v-show="false"></iframe>
    </div>
</template>
<script>
    import UserBase from "@bases/UserBase.js";

    export default UserBase.extend({
        name: "DownloadFile",
        data: () => ({
            title: "Download Files",
            type: "downloadFiles",
            tabs: [{name: "Download Files"}],
            watchers: true,
            headers: [
                {class: "th-sortable", name: "File name", width: "70%"},
                {class: "hide-xs th-sortable", name: "Uploaded", width: "20%"},
                {class: "th-not-sortable", name: "", width: "80"}
            ],
        }),
        methods: {
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
                        {data: data.fileName, type: "id", class: "user-email"},
                        {
                            data: data.created_at,
                            type: "text",
                            class: "hide-xs"
                        },
                        {
                            type: "action",
                            class: "",
                            modal: {
                                data: data
                            }
                        }
                    ]
                }
            },
            downloadFile(data) {
                let file = data.modal.data, url = `${this.baseUrl}${file.folderPath}${file.realfilePath}`;
                this.$utils.downloadURL(url, 'file_download');
            }
        },
        created() {
            this.getItems = this.debounce(this.getItems, 150);
            this.getItems();
        }
    });
</script>
