import Dashboard from '@com/Admin/Dashboard.vue'
import Members from '@com/Admin/Members/All.vue'
import SingleMemberProfile from '@com/Admin/Members/SingleMemberProfile.vue'
import Organize from '@com/Admin/Members/Organize.vue'
import Department from '@com/Admin/Members/Department.vue'
import MembersProfile from '@com/Admin/Members/MembersProfile.vue'
import SiteSetting from '../components/Admin/Default/SiteSetting.vue'
import Dictionary from '@com/Admin/Posts/Dictionary.vue'
import ContactInfo from '@com/Admin/Posts/ContactInfo.vue'
import AboutJaol from '@com/Admin/Posts/AboutJaol.vue'
import News from '@com/Admin/Posts/News.vue'
import Activity from '@com/Admin/Posts/Activity.vue'
import Event from '@com/Admin/Posts/Event.vue'
import Scholarship from '@com/Admin/Posts/Scholarship.vue'
import OrganizeChartRange from '@com/Admin/Posts/OrganizeChartRange.vue'
import UploadFile from '@com/Admin/Posts/Uploadfile.vue'
import Sponsor from '@com/Admin/Posts/Sponsor.vue'

const prefix = '/admin/me';
const metas = {
    authMeta: {
        requiresAuth: true
    },
    guestMeta: {
        requiresVisitor: true,
        except: ['admin', 'super_admin'],
        redirect: 'admin/me', //don't use any route name of requiresVisitor
        path: '/admin/me', //don't use any route path of requiresVisitor
    }
};

export default [{
    path: `${prefix}/sitesetting`,
    component: SiteSetting,
    name: 'sitesetting',
    meta: metas.authMeta,
},
    {
        path: prefix,
        component: Dashboard,
        name: 'dashboard',
        meta: metas.authMeta,
    },
    {
        name: 'members',
        path: `${prefix}/members`,
        component: Members,
        meta: metas.authMeta,
    },
    {
        name: 'organization',
        path: `${prefix}/organizations`,
        component: Organize,
        meta: metas.authMeta,
    },
    {
        name: 'department',
        path: `${prefix}/departments`,
        component: Department,
        meta: metas.authMeta,
    },
    {
        name: 'members-profile',
        path: `${prefix}/members-profile`,
        component: MembersProfile,
        meta: metas.authMeta,
    },
    {
        name: 'member-profile',
        path: `${prefix}/members-profile/:user_id`,
        component: SingleMemberProfile,
        meta: metas.authMeta,
    },
    // Xone Route
    {
        path: `${prefix}/dictionary`,
        name: 'dictionary',
        component: Dictionary,
        meta: metas.authMeta,
    },
    {
        path: `${prefix}/contactinfo`,
        name: 'contactinfo',
        component: ContactInfo,
        meta: metas.authMeta,
    }, {
        path: `${prefix}/aboutjaol`,
        name: 'aboutjaol',
        component: AboutJaol,
        meta: metas.authMeta,
    },
    {
        path: `${prefix}/news`,
        name: 'news',
        component: News,
        meta: metas.authMeta,
    },
    {
        path: `${prefix}/activity`,
        name: 'activity',
        component: Activity,
        meta: metas.authMeta,
    },
    {
        path: `${prefix}/event`,
        name: 'event',
        component: Event,
        meta: metas.authMeta,
    },
    {
        path: `${prefix}/scholarship`,
        name: 'scholarship',
        component: Scholarship,
        meta: metas.authMeta,
    },
    {
        path: `${prefix}/organize-chart-ranges`,
        name: 'organize-chart-range',
        component: OrganizeChartRange,
        meta: metas.authMeta,
    },
    {
        path: `${prefix}/upload-files`,
        name: 'uploadfile',
        component: UploadFile,
        meta: metas.authMeta,
    },
    {
        path: `${prefix}/sponsor`,
        name: 'sponsor',
        component: Sponsor,
        meta: metas.authMeta,
    },

];
