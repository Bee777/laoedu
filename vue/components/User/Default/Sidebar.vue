<template>
    <div class="app-sidebar">
        <div class="nav">
            <button @click="GoToHomePage()" class="button v-md-button app-sidebar-left-top-menu flex-left">
                <div class="app-sidebar-logo-lockup">
                    <img class="app-sidebar-logo-lockup-icon"
                         :src="`${baseUrl}/assets/images/${s.website_logo}${s.fresh_version}`"
                         alt="Admin Icon Logo"
                    >
                    <img class="app-sidebar-logo-lockup-logotype logotype-white"
                         :src="`${baseUrl}/assets/images/admin-logo.svg${s.fresh_version}`"
                         alt="Admin Text Logo">
                </div>
            </button>
            <div class="app-sidebar-container-nav">
                <div class="app-sidebar-content-container-root side-group">
                    <div class="app-sidebar-overview">
                        <a class="app-sidebar-item" @click="GoToOverview"
                           :class="[{'selected-entry' : $route.name==='dashboard'}]">
                            <div class="app-sidebar-item-lockup">
                                <i class="material-icons selected-icon">home</i>
                                <span class="app-sidebar-entry-displayname">Overview</span>
                            </div>
                        </a>
                    </div>

                    <div class="app-sidebar-item-settings">
                        <button @click="GoToProfileSetting"
                                class="button v-md-button v-md-icon-button app-sidebar-item-settings-button">
                            <i class="material-icons app-sidebar-item-settings-icon">settings</i>
                            <i class="material-icons app-sidebar-item-settings-arrow-icon">arrow_drop_down</i>
                        </button>
                    </div>

                    <div class="app-sidebar-item-settings-collapsed">
                        <button @click="GoToProfileSetting" class="button v-md-button app-sidebar-item-settings-button">
                            <i class="material-icons app-sidebar-item-settings-icon">settings</i>
                            <i class="material-icons app-sidebar-item-settings-arrow-icon">arrow_drop_down</i>
                        </button>
                    </div>

                </div>
                <!--@Start Sidebar content menu-->
                <div class="sidebar-tree">
                    <SidebarItem @onItemClick="itemAction"
                                 v-for="(side, index) in sideItems"
                                 :contentHeader="side.contentHeader" :items="side.items" :key="index"/>
                </div>
                <!--@End Sidebar content menu-->
            </div>
            <!--@Start Footer Sidebar -->
            <button @click="setSidebarCollapsed" class="button v-md-button app-sidebar-item-expando">
                <i class="material-icons">chevron_left</i>
            </button>

            <button class="button v-md-button app-sidebar-item-expando is-mobile">
            </button>
            <!--@End Footer Sidebar -->
        </div>
    </div>
</template>

<script>
    import {mapMutations, mapActions, mapState} from 'vuex'
    import SidebarItem from '@com/Admin/Default/SidebarItem.vue'

    export default {
        name: "sidebar",
        data() {
            return {
                sideItems: [
                    {
                        contentHeader: {
                            expanded: true,
                            name: 'Jaol Memebers',
                            description: 'Manage, Authentication, Approval, Searching',
                            icon: 'keyboard_arrow_up',
                        }, items: [
                            {
                                name: 'My Profile Settings',//required
                                icon: 'group',//required
                                action: this.Route,//required
                                params: {name: 'user-profile-settings'},//required
                            },
                            {
                                name: 'Members Profile',
                                icon: 'account_box',//required
                                action: this.Route,//required
                                params: {name: 'members-profile'},//required
                            },
                        ]
                    },
                    {
                        contentHeader: {
                            expanded: true,
                            name: "My Jaol Posts",
                            description: "Manage My Jaol posts information",
                            icon: "keyboard_arrow_up"
                        },
                        items: [
                            {
                                name: "News", //required
                                icon: "rss_feed", //required
                                action: this.Route, //required
                                params: {name: "news"} //required
                            },
                            {
                                name: "Activity", //required
                                icon: "list_alt", //required
                                action: this.Route, //required
                                params: {name: "activity"} //required
                            },
                            {
                                name: "Event", //required
                                icon: "today", //required
                                action: this.Route, //required
                                params: {name: "event"} //required
                            },
                            {
                                name: "Scholarship", //required
                                icon: "school", //required
                                action: this.Route, //required
                                params: {name: "scholarship"} //required
                            },
                            {
                                name: "All Dictionaries", //required
                                icon: "g_translate", //required
                                action: this.Route, //required
                                params: {name: "dictionary"} //required
                            },
                        ]
                    },
                    {
                        contentHeader: {
                            expanded: true,
                            name: "Jaol Documents File",
                            description: "Jaol document information files, download document files.",
                            icon: "keyboard_arrow_up"
                        },
                        items: [
                            {
                                name: "Download File", //required
                                icon: "cloud_download", //required
                                action: this.Route, //required
                                params: {name: "download-file"} //required
                            },
                        ]
                    }
                ]
            }
        },
        components: {
            SidebarItem,
        },
        methods: {
            ...mapActions([]),
            ...mapMutations(['setSidebarCollapsed', 'setSelectedSidebarItem']),
            itemAction(i) {
                if (i.action) {
                    i.action(i.params);
                }
            },
            routeActions(data) {
                this.Route({name: data.params.name});
                this.setSelectedSidebarItem(data);
            },
            GoToOverview() {
                let i = {name: 'Dashboard', params: {name: 'dashboard'}};
                this.routeActions(i);
            },
            GoToProfileSetting() {
                let i = {name: 'My Profile Settings', params: {name: 'user-profile-settings'}};
                this.routeActions(i);
            },
            GoToHomePage() {
                this.$utils.Location('/');
            }
        }
    }
</script>

<style scoped>

</style>
