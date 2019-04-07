<template>
    <div>
        <div class="module-canvas emails-card-wrapper">
            <MasterSingleDetailCard
                @onBackButtonClick="onBackButtonClick"
                :header="{ title: 'Organization chart content', content: '<p> Changes organize Jaol information.</p>'}"
                :menuItem="{ name: 'Organization chart', icon: 'account_circle'}"
            >
                <div class="details is-edit">
                    <form @submit.prevent class="admin-form admin-template-form">
                        <div class="layout-align-space-around-start layout-row">
                            <Editor
                                @editorMounted="(ed)=> editor = ed"
                                v-model="organizeInfo.description"
                                :label="'Organize information '"
                            />
                        </div>
                        <div class="actions">
                            <div class="layout-align-end-center layout-row">
                                <button @click="saveContent" class="v-md-button primary">Save Changes</button>
                            </div>
                        </div>
                    </form>
                </div>
            </MasterSingleDetailCard>
        </div>
    </div>
</template>
<script>
    import AdminBase from "@bases/AdminBase.js";
    import {mapActions} from "vuex";

    export default AdminBase.extend({
        name: "OrganizeInfo",
        data: () => ({
            title: "OrganizeInfo Jaol information",
            tabs: [{name: "Organization Info"}],
            organizeInfo: {loading: true},
            editor: null
        }),
        methods: {
            ...mapActions(["fetchOrganizeInfo", "postMangeOrganizeInfo"]),
            onBackButtonClick() {
                this.Route({name: "dashboard"});
            },
            getItems() {
                this.organizeInfo.loading = true;
                this.fetchOrganizeInfo()
                    .then(res => {
                        if (!this.$utils.isEmptyVar(res.data) && res.success) {
                            res.data.loading = false;
                            this.organizeInfo = res.data;
                            this.editor.setEditorContent(this.organizeInfo.description);
                        }
                        this.organizeInfo.loading = false;
                    })
                    .catch(err => {
                        this.organizeInfo.loading = false;
                    });
            },
            saveContent() {
                this.organizeInfo.loading = true;
                this.postMangeOrganizeInfo(this.organizeInfo)
                    .then(res => {
                        this.showInfoToast({
                            msg: "The organize information was successfully updated!",
                            dt: 3500
                        });
                        this.getItems();
                    })
                    .catch(err => {
                        this.showErrorToast({
                            msg: "Cannot update the organize information!",
                            dt: 3500
                        });
                    });
            }
        },
        created() {
            this.getItems = this.debounce(this.getItems, 150);
            this.getItems();
        }
    });
</script>
