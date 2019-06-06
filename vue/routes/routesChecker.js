import Dashboard from '@com/Checker/Dashboard.vue'
import CheckAssessments from '@com/Checker/CheckAssessments.vue'
import CheckAssessmentSingle from '@com/Checker/CheckAssessmentSingle.vue'
import UserProfileSettings from '@com/Checker/Detail/ProfileSettings.vue'

const prefix = '/checker/me';
let adminTypes = ['admin', 'super_admin'];
const metas = {
    authMeta: {
        requiresAuth: true,
      allows: adminTypes.concat(['checker']),
    },
    guestMeta: {
        requiresVisitor: true,
        except: adminTypes,
        redirect: 'checker/me', //don't use any route name of requiresVisitor
        path: '/checker/me', //don't use any route path of requiresVisitor
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
        name: 'profile-settings',
        path: `${prefix}/profile-settings`,
        component: UserProfileSettings,
        meta: metas.authMeta,
    },
    {
        name: 'check-assessments',
        path: `${prefix}/check-assessments`,
        component: CheckAssessments,
        meta: metas.authMeta,
    },
    {
        name: 'check-assessment-single',
        path: `${prefix}/check-assessments/:check_assessment_id`,
        component: CheckAssessmentSingle,
        meta: metas.authMeta,
    },
];
