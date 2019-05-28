import Dashboard from '@com/Institute/Dashboard.vue'
import SingleInstituteProfile from '@com/Admin/Institutes/SingleInstituteProfile.vue'
import UserProfileSettings from '@com/Institute/Detail/ProfileSettings.vue'


const prefix = '/institute/me';
let adminTypes = ['admin', 'super_admin'];
const metas = {
    authMeta: {
        requiresAuth: true,
      allows: adminTypes.concat(['institute']),
    },
    guestMeta: {
        requiresVisitor: true,
        except: adminTypes,
        redirect: 'institute/me', //don't use any route name of requiresVisitor
        path: '/institute/me', //don't use any route path of requiresVisitor
    }
};

export default [

    {
        path: prefix,
        component: Dashboard,
        name: 'dashboard',
        meta: metas.authMeta,
    },
        {
        name: 'user-profile-settings',
        path: `${prefix}/profile-settings`,
        component: UserProfileSettings,
        meta: metas.authMeta,
    },
    // {
    //     name: 'institutes-profile',
    //     path: `${prefix}/institute-profile`,
    //     component: InstituteProfile,
    //     meta: metas.authMeta,
    // },
    // {
    //     name: 'institute-profile',
    //     path: `${prefix}/institute-profile/:user_id`,
    //     component: SingleInstituteProfile,
    //     meta: metas.authMeta,
    // },
];
