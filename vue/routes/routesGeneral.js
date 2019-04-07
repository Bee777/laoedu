import Login from '@com/General/Login.vue'
import ResetPassword from '@com/General/ResetPassword.vue'
import Register from '@com/General/Register.vue'
import Registered from '@com/General/Registered.vue'
import FinishedResetPassword from '@com/General/FinishedResetPassword.vue'

/**
 * @Author Xone
 */
import Home from '@com/General/Default/Home.vue'
import About from '@com/General/Default/about.vue'
import News from '@com/General/Default/News.vue'
import Contact from '@com/General/Default/contact.vue'
import Activity from '@com/General/Default/activity.vue'
import Scholarship from '@com/General/Default/scholarship.vue'
import Event from '@com/General/Default/event.vue'
import OrganizeChart from '@com/General/Default/OrganizeChart.vue'
import Dictionary from '@com/General/Pages/Dictionary.vue'
import NewsSingle from '@com/General/Default/Single/NewsSingle.vue'
import ActivitySingle from '@com/General/Default/Single/ActivitySingle.vue'
import EventSingle from '@com/General/Default/Single/EventSingle.vue'
import ScholarshipSingle from '@com/General/Default/Single/ScholarshipSingle.vue'
import SingleDictionary from '@com/General/Pages/Single/SingleDictionary.vue'

/**
 * @Author Xone
 */
const metas = {
    guestMeta: {
        requiresVisitor: true,
        except: ['admin', 'super_admin'],
        redirect: 'home', //don't use any route name of requiresVisitor
        path: '/', //don't use any route path of requiresVisitor
    },
    defaultMeta: {
        navFixed: true,
        hideNavFooter: true,
    },
    authMeta: {
        requiresAuth: true
    },
    df(prm) {
        let r = Object.assign({}, this.defaultMeta);
        for (let p in prm) {
            if (prm.hasOwnProperty(p))
                r[p] = prm[p];
        }
        return r;
    }
};

export default [
    {
        path: "/login",
        component: Login,
        name: 'login',
        meta: {
            ...metas.guestMeta, ...metas.df({
                navFixed: false,
            })
        },
    },
    {
        path: "/aGlkZGVuLXJlZ2lzdGVyLXBhZ2UtQGphb2w",
        component: Register,
        name: 'register',
        meta: {
            ...metas.guestMeta, ...metas.df({
                navFixed: false,
            })
        },
    },
    {
        path: "/register-successfully",
        component: Registered,
        name: 'registered',
        meta: {
            ...metas.guestMeta, ...metas.df({
                navFixed: false,
            })
        },
    },
    {
        path: "/password/reset/:token",
        component: ResetPassword,
        name: 'reset-password',
        meta: {
            ...metas.guestMeta, ...metas.df({
                navFixed: false,
            })
        },
    },
    {
        path: "/reset-password-successfully",
        component: FinishedResetPassword,
        name: 'finished-reset-password',
        meta: {
            ...metas.guestMeta, ...metas.df({
                navFixed: false,
            })
        },
    },
    //xone router
    {
        path: '/',
        name: 'home',
        component: Home,
        meta: {
            ...metas.df({
                hideNavFooter: false,
            })
        },
    },
    {
        path: '*', component: Home, meta: {
            ...metas.df({
                hideNavFooter: false,
            })
        },
    },
    {
        path: '/about',
        name: 'about',
        component: About,
        meta: {
            ...metas.df({
                hideNavFooter: false,
            })
        },
    },
    {
        path: '/posts/news',
        name: 'news',
        component: News,
        meta: {
            ...metas.df({
                hideNavFooter: false,
            })
        },
    },
    {
        path: '/posts/news/single/:id',
        name: 'news-single',
        component: NewsSingle,
        meta: {
            ...metas.df({
                hideNavFooter: false,
            })
        },
    },
    {
        path: '/posts/activities',
        name: 'activities',
        component: Activity,
        meta: {
            ...metas.df({
                hideNavFooter: false,
            })
        },
    },
    {
        path: '/posts/activities/single/:id',
        name: 'activity-single',
        component: ActivitySingle,
        meta: {
            ...metas.df({
                hideNavFooter: false,
            })
        },
    },
    {
        path: '/posts/scholarships',
        name: 'scholarships',
        component: Scholarship,
        meta: {
            ...metas.df({
                hideNavFooter: false,
            })
        },
    },
    {
        path: '/posts/scholarships/single/:id',
        name: 'scholarship-single',
        component: ScholarshipSingle,
        meta: {
            ...metas.df({
                hideNavFooter: false,
            })
        },
    },
    {
        path: '/posts/events',
        name: 'events',
        component: Event,
        meta: {
            ...metas.df({
                hideNavFooter: false,
            })
        },
    },
    {
        path: '/posts/events/single/:id',
        name: 'event-single',
        component: EventSingle,
        meta: {
            ...metas.df({
                hideNavFooter: false,
            })
        },
    },
    {
        path: '/contact',
        name: 'contact',
        component: Contact,
        meta: {
            ...metas.df({
                hideNavFooter: false,
            })
        },
    },
    {
        path: '/organization-charts',
        name: 'organize-charts',
        component: OrganizeChart,
        meta: {
            ...metas.df({
                hideNavFooter: false,
            })
        },
    },
    {
        path: '/dictionary',
        name: 'dictionary',
        component: Dictionary,
        meta: {
            ...metas.df({
                hideNavFooter: false,
            })
        },
    },
    {
        path: '/dictionary/single/:id',
        name: 'single-dictionary',
        component: SingleDictionary,
        meta: {
            ...metas.df({
                hideNavFooter: false,
            })
        },
    },
];
