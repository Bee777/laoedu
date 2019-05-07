<template>
    <div class="app-sidebar">
        <div class="nav">
            <button @click="GoToHomePage()" class="button v-md-button app-sidebar-left-top-menu flex-left">
                <div class="app-sidebar-logo-lockup">
                    <img
                        class="app-sidebar-logo-lockup-icon"
                        :src="`${baseUrl}/assets/images/${s.website_logo}${s.fresh_version}`"
                        alt="Admin Icon Logo"
                    > ສປຄ
                    <!--   src="https://www.gstatic.com/mobilesdk/160503_mobilesdk/logo/2x/firebase_28dp.png"-->
                    <!-- <img
                        class="app-sidebar-logo-lockup-logotype logotype-white"
                        :src="`${baseUrl}/assets/images/admin-logo.svg${s.fresh_version}`"
                        alt="Admin Text Logo"
                    > -->
                    <!--
                    src="//www.gstatic.com/mobilesdk/160323_mobilesdk/images/firebase_logotype_white_18dp.svg"-->
                </div>
            </button>
            <div class="app-sidebar-container-nav">
                <div class="app-sidebar-content-container-root side-group">
                    <div class="app-sidebar-overview">
                        <a
                            class="app-sidebar-item"
                            @click="GoToOverview"
                            :class="[{'selected-entry' : $route.name==='dashboard'}]"
                        >
                            <div class="app-sidebar-item-lockup">
                                <i class="material-icons selected-icon">home</i>
                                <span class="app-sidebar-entry-displayname">Overview</span>
                            </div>
                        </a>
                    </div>

                    <div @click="GoToSiteSetting" class="app-sidebar-item-settings">
                        <button class="button v-md-button v-md-icon-button app-sidebar-item-settings-button">
                            <i class="material-icons app-sidebar-item-settings-icon">settings</i>
                            <i class="material-icons app-sidebar-item-settings-arrow-icon">arrow_drop_down</i>
                        </button>
                    </div>

                    <div @click="GoToSiteSetting" class="app-sidebar-item-settings-collapsed">
                        <button class="button v-md-button app-sidebar-item-settings-button">
                            <i class="material-icons app-sidebar-item-settings-icon">settings</i>
                            <i class="material-icons app-sidebar-item-settings-arrow-icon">arrow_drop_down</i>
                        </button>
                    </div>
                </div>
                <!--@Start Sidebar content menu-->
                <div class="sidebar-tree">
                    <SidebarItem
                        @onItemClick="itemAction"
                        v-for="(side, index) in sideItems"
                        :contentHeader="side.contentHeader"
                        :items="side.items"
                        :key="index"
                    />
                </div>
                <!--@End Sidebar content menu-->
            </div>
            <!--@Start Footer Sidebar -->
            <button @click="setSidebarCollapsed" class="button v-md-button app-sidebar-item-expando">
                <i class="material-icons">chevron_left</i>
            </button>

            <button class="button v-md-button app-sidebar-item-expando is-mobile"></button>
            <!--@End Footer Sidebar -->
        </div>
    </div>
</template>

<script>
    import {mapMutations, mapActions, mapState} from "vuex";
    import SidebarItem from "@com/Admin/Default/SidebarItem.vue";

    export default {
        name: "sidebar",
        data() {
            return {
                sideItems: [
                    {
                        contentHeader: {
                            expanded: true,
                            name: "ຂໍ້ມູນຜູ້ໃຊ້",
                            description: "ຈັດການຂໍ້ມູນຜູ້ໃຊ້ລະບົບ",
                            icon: "keyboard_arrow_up"
                        },
                        items: [
                            {
                                name: "ຜູ້ໃຊ້ທັງໝົດ", //required
                                icon: "group", //required
                                action: this.Route, //required
                                params: {name: "members"} //required
                            },
                            {
                                name: "User Profile",
                                icon: "account_box", //required
                                action: this.Route, //required
                                params: {name: "members-profile"} //required
                            },
                            {
                                name: "User type",
                                icon: "chrome_reader_mode",
                                action: this.Route,
                                params: {name: "department"}
                            }
                        ]
                    },
                                        {
                        contentHeader: {
                            expanded: true,
                            name: "ຂໍ້ມູນສະຖານການສຶກສາ",
                            description: "ຈັດການຂໍ້ມູນສະຖານການສຶກສາ, ປະເພດສະຖານການສຶກສາ",
                            icon: "keyboard_arrow_up"
                        },
                        items: [
                            {
                                name: "ສະຖານການສຶກສາທັງໝົດ", //required
                                icon: "business", //required
                                action: this.Route, //required
                                params: {name: "institute"} //required
                            },
                            {
                                name: "ສະຖານການສຶກສາ Profile",
                                icon: "account_circle", //required
                                action: this.Route, //required
                                params: {name: "institute-profile"} //required
                            },
                            {
                                name: "ໝວດໝູ່ສະຖານການສຶກສາ",
                                icon: "category",
                                action: this.Route,
                                params: {name: "institute-category"}
                            }
                        ]
                    },
                                                            {
                        contentHeader: {
                            expanded: true,
                            name: "ຂໍ້ມູນບົດປະເມີນ",
                            description: "ຈັດການຂໍ້ມູນບົດປະເມີນ, ບົດປະເມີນທີ່ກວດສອບແລ້ວ",
                            icon: "keyboard_arrow_up"
                        },
                        items: [
                            {
                                name: "ບົດປະເມີນທັງໝົດ", //required
                                icon: "collections_bookmark", //required
                                action: this.Route, //required
                                params: {name: "assessment"} //required
                            },
                            {
                                name: "ບົດປະເມີນທີ່ກວດສອບແລ້ວ",
                                icon: "assignment_turned_in", //required
                                action: this.Route, //required
                                params: {name: "review-assessment"} //required
                            },
                        ]
                    },

                    {
                        contentHeader: {
                            expanded: true,
                            name: "ຂໍ້ມູນຂ່າວສານ",
                            description: "ຈັດການຂໍ້ມູນຂ່າວສານ",
                            icon: "keyboard_arrow_up"
                        },
                        items: [
                            {
                                name: "ຂ່າວສານ", //required
                                icon: "rss_feed", //required
                                action: this.Route, //required
                                params: {name: "news"} //required
                            },
                                                        {
                                name: "ກິດຈະກຳ", //required
                                icon: "list_alt", //required
                                action: this.Route, //required
                                params: {name: "activity"} //required
                            },
                            {
                                name: "ທຶນການສຶກສາ", //required
                                icon: "school", //required
                                action: this.Route, //required
                                params: {name: "scholarship"} //required
                            }, ]
                    },
                    {
                        contentHeader: {
                            expanded: true,
                            name: "ຂໍ້ມູນເວບໄຊ",
                            description: "ຈັດການຂໍ້ມູນພື້ນຖານເວບໄຊ",
                            icon: "keyboard_arrow_up"
                        },
                        items: [
                                {
                                name: "Logo and Banner", //required
                                icon: "settings", //required
                                action: this.Route, //required
                                params: {name: "sitesetting"} //required
                            },
                            {
                                name: "ຂໍ້ມູນກ່ຽວກັບ", //required
                                icon: "business", //required
                                action: this.Route, //required
                                params: {name: "aboutjaol"} //required
                            },
                            {
                                name: "ຂໍ້ມູນຕິດຕໍ່", //required
                                icon: "call", //required
                                action: this.Route, //required
                                params: {name: "contactinfo"} //required
                            },
                              {
                                name: "Sponsor", //required
                                icon: "card_giftcard", //required
                                action: this.Route, //required
                                params: {name: "sponsor"} //required
                            },
                            {
                                name: "Upload File", //required
                                icon: "cloud_upload", //required
                                action: this.Route, //required
                                params: {name: "uploadfile"} //required
                            },
                        ]
                    }
                ]
            };
        },
        components: {
            SidebarItem
        },
        methods: {
            ...mapActions([]),
            ...mapMutations(["setSidebarCollapsed", "setSelectedSidebarItem"]),
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
                let i = {name: "Dashboard", params: {name: "dashboard"}};
                this.routeActions(i);
            },
            GoToSiteSetting() {
                let i = {name: 'Site Setting', params: {name: 'sitesetting'}};
                this.routeActions(i);
            },
            GoToHomePage() {
                this.$utils.Location('/');
            }
        }
    };
</script>

<style scoped>
</style>