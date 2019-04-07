<template>
    <div>
        <Navbar v-if="!$route.meta.hideNavFooter"/>
        <div id="general-main-container" :class="[(isMobile && $route.meta.navFixed)]">
            <router-view></router-view>
        </div>
        <Footer v-if="!$route.meta.hideNavFooter"/>
       <a href="#" class="back-to-top"><i class="fa fa-angle-up"></i></a>
        <Sidebar/>
        <!--Tooltip-->
        <!--<ToolTip :id="'identifierShowPassword'"/>-->
        <!--Tooltip-->
     
    </div>
</template>
<script>
    import {mapState, mapGetters, mapActions, mapMutations} from 'vuex'
    import Navbar from '@com/General/Partial/Navbar.vue';
    import Sidebar from '@com/General/Partial/Sidebar.vue';
    import Footer from '@com/General/Partial/Footer.vue';

    export default {
        name: 'app-general',
        components: {
            Footer,
            Navbar,
            Sidebar
        },

        data() {
            return {
                breakPoint: 0,
                windowHeight: 0,
                limitBreakPoint: 1023,
            }
        },
        computed: {
            ...mapState(['isMobile']),
        },
        methods: {
            ...mapMutations(['setMobile']),
            ...mapActions(['fetchHomeData', 'fetchAuthUserInfo']),
            getClient: (e, context) => {
                context.breakPoint = e.currentTarget.innerWidth;
                context.windowHeight = e.currentTarget.innerHeight;
                context.isBreak(context.limitBreakPoint);
            },
            isBreak(break_point) {
                if (this.breakPoint <= break_point) {
                    this.setMobile({isMobile: true, currentWidth: this.breakPoint, currentHeight: this.windowHeight});
                } else {
                    this.setMobile({isMobile: false, currentWidth: this.breakPoint, currentHeight: this.windowHeight});
                }
            },
        },
        mounted() {
            this.breakPoint = this.$el.clientWidth;
            this.windowHeight = this.$el.clientHeight;
            window.addEventListener('resize', (e) => {
                this.getClient(e, this);
            });
            this.isBreak(this.limitBreakPoint);
        },
        created() {
            this.fetchHomeData();
            this.fetchAuthUserInfo({no_redirect: true});//get first user data
        },
        beforeDestroy() {
            if (window.removeEventListener) {
                window.removeEventListener('resize', (e) => {
                    this.getClient(e, this)
                })
            }
        }
    }
</script>
<style scoped>
</style>
