import {createActions, axiosClient} from "./actions/adminActions";
import {
    createInit,
    defaultStates,
    defaultGetters,
    defaultMutations,
    defaultActions
} from '../initial/initializer';

/**
 * @initialize
 */
let {Vue, Vuex, $utils, debounce, initRouter} = createInit();
let addedActions = createActions($utils);
let {client, ajaxConfig, apiUrl} = axiosClient();
const ajaxToken = (c, formData = false) => {
    if (formData) {
        ajaxConfig.addHeader('Content-Type', 'multipart/form-data');
    } else {
        ajaxConfig.addHeader('Content-Type', 'application/json');
    }
    return ajaxConfig.addHeader('CL-Token', c.getters.getToken);
};
//@start set vue prototype
Vue.prototype.initRouter = initRouter;
Vue.prototype.apiUrl = apiUrl;
Vue.prototype.ajaxConfig = ajaxConfig;
Vue.prototype.client = client;
//@end set vue prototype
//@Vue UNDO REDO
import VuexUndoRedo from '../plugin/vuex-undo-redo-plugin.js';

Vue.use(VuexUndoRedo, {
    watchOnly: true, watchMutations: [
        'setAssessmentTextValueChangeDataStack',
        'addSectionDataStack',
        'deleteSectionDataStack',
        'addSectionQuestionDataStack',
        'deleteSectionQuestionDataStack',
        'addRadioOptionQuestionDataStack',
        'deleteRadioOptionQuestionDataStack',
        'setTextValueChangeDataStack',
        'setOptionValueChangeDataStack',
    ]
});
//@END VUE UNDO REDO
export default new Vuex.Store({
    state: {
        ...defaultStates,
        isSidebarCollapsed: '',
        isSidebarMobileOpen: '',
        userImage: 'user.png' + settings.fresh_version,
        authInfo: {img: 'admin.png' + settings.fresh_version},
        sidebarWidth: {normal: 256, collapsed: 68},
        isSidebar: '',
        selectedSidebarItem: {},
        menuContext: {menus: []},
        menuContextItemClicked: {},
        searchQuery: {text: '', filters: {}},
        dashboardData: {
            activities_count: 0,
            latest_members_count: 0,
            news_count: 0,
            scholarships_count: {active: 0, all: 0},
        },
        searchesData: {
            institute_category: {},
            news: {},
            activity: {},
            scholarship: {},
            banner: {},
            file: {},
            users_checker: [],
            users_field_inspector: [],
            users_institute: [],
        },
        searchesAllowed: {
            institute_category: true,
            news: true,
            activity: true,
            scholarship: true,
            banner: true,
            file: true,
            users_checker: true,
            users_field_inspector: true,
            users_institute: true,
        },
        mEditAssessment: false,
        mAssessment: {title: '', description: ''},
        mSectionsStack: [
            {
                title: '',
                desc: '',
                focusIndex: -1,
                questions: []
            }
        ],
        mUndo: [],
        mRedo: [],
    },
    getters: {
        ...defaultGetters,
        getSideBarWidthForTabs(s) {
            return s.isSidebarCollapsed !== '' ? s.sidebarWidth.collapsed : s.sidebarWidth.normal;
        }
    },
    mutations: {
        ...defaultMutations,
        setSidebar(s, p) {
            s.isSidebar = p.isSidebar;
        },
        setSidebarCollapsed(s, p) {
            s.isSidebarCollapsed = s.isSidebarCollapsed === 'app-sidebar-collapsed' ? '' : 'app-sidebar-collapsed'
        },
        setSelectedSidebarItem(s, p) {
            s.selectedSidebarItem = p;
            if (s.isMobile)
                s.isSidebarMobileOpen = '';
            $utils.setWindowTitle(`${p.name} | ${settings.site_name}`);
        },
        setSidebarMobileOpen(s, p) {
            s.isSidebarMobileOpen = p.isOpen ? 'mobile-nav-open' : ''
        },
        setMenuContext(s, p) {
            if (p.el)
                p.el.stopPropagation();
            s.menuContext = p;
        },
        setOnMenuContextItemClick(s, p) {
            s.menuContextItemClicked = {};
            s.menuContextItemClicked = p;
        },
        setSearchesData(s, p) {
            if (!!s.searchesAllowed[p.type]) {
                s.searchesData[p.type] = p.data;
                s.searchesData[p.type].items = [];
            }
        },
        setSearchQuery(s, p) {
            s.searchQuery.text = p.text;
            s.searchQuery.filters = p.filters;
        },
        setDashboardData(s, p) {
            s.dashboardData = p;
        },
        //@Stack
        addSectionDataStack(s, p) {
            let schema = Object.assign({}, p.schema);//to spilt up questions section
            schema.questions = Object.assign([], schema.questions);//we need to clone array object if not they will connect each other
            s.mSectionsStack.splice(p.index, 0, schema);
        },
        deleteSectionDataStack(s, p) {
            s.mSectionsStack.splice(p.index, 1);
        },
        addSectionQuestionDataStack(s, p) {
            let mSection = s.mSectionsStack[p.sectionIndex],
                question = $utils.deepCopy(p.list);
            mSection.questions.splice(p.index, 0, question);
            mSection.focusIndex = p.focusIndex;
        },
        deleteSectionQuestionDataStack(s, p) {
            let section = s.mSectionsStack[p.sectionIndex];
            section.questions.splice(p.index, 1);
        },
        addRadioOptionQuestionDataStack(s, p) {
            let mSection = s.mSectionsStack[p.sectionIndex],
                mQuestion = mSection.questions[p.question_index],
                list = mQuestion.content[p.option_answer_index].option_answers;
            //add answer item
            let index = list.length ? parseInt((list[list.length - 1].description.match(/\d$/g) || []).join('')) + 1 : '1';
            let text = index ? 'Option ' + index : 'Option 1';
            list.push({answer_id: list.length + 1, description: text});
        },
        deleteRadioOptionQuestionDataStack(s, p) {
            let mSection = s.mSectionsStack[p.sectionIndex],
                mQuestion = mSection.questions[p.question_index],
                list = mQuestion.content[p.option_answer_index].option_answers;
            //delete answer item
            list.splice(p.index, 1);
        },
        setTextValueChangeDataStack(s, p) {
            let mSection = s.mSectionsStack[p.sectionIndex];
            if (p.type === 'section') {
                mSection[p.key] = p.value;
            } else if (p.type === 'question_title') {
                mSection.questions[p.schema.question_index].content[p.schema.content_index].title = p.value;
            } else if (p.type === 'option_answers') {
                mSection.questions[p.schema.question_index].content[p.schema.content_index].option_answers[p.schema.option_index].description = p.value;
            } else if (p.type === 'option_answers_linear_scale') {
                let scale = mSection.questions[p.schema.question_index].content[p.schema.content_index][p.key];
                scale.line_value = p.schema.content.line_value;
                scale.line_end_value = p.schema.content.line_end_value;
                scale[p.schema.key] = p.value;
            }
        },
        setOptionValueChangeDataStack(s, p) {
            let mSection = s.mSectionsStack[p.schema.sectionIndex];
            if (p.schema.key === 'types') {
                mSection.questions[p.schema.question_index].types = p.value;
            }
            if (p.schema.key === 'is_required') {
                mSection.questions[p.schema.question_index].is_required = p.value;
            }
        },
        setAssessmentTextValueChangeDataStack(s, p) {
            s.mAssessment[p.key] = p.value;
        },
        emptyState(s) {
            this.replaceState({
                ...s,
                mSectionsStack:
                    [
                        {
                            title: '',
                            desc: '',
                            focusIndex: -1,
                            questions: []
                        }
                    ],
                mAssessment: {title: '', description: ''},
            });
        },
        setUndoRedoHistory(s, p) {
            s.mUndo = Object.assign([], p.Undo);
            s.mRedo = Object.assign([], p.Redo);
        },
        //@endStack
        setEditAssessmentStatus(s, p) {
            s.mEditAssessment = p;
        }
    },
    actions: {
        ...defaultActions(axiosClient()),
        ...addedActions,
        setPageTitle(c, n) {
            if (n !== c.state.selectedSidebarItem.name)
                c.commit('setSelectedSidebarItem', {name: n});
        },
        showErrorToast(c, data) {
            Vue.toasted.error(data.msg, {
                duration: data.dt,
                action: {
                    text: 'Close',
                    onClick: (e, t) => {
                        t.goAway(0);
                    }
                }
            });
        },
        showInfoToast(c, data) {
            Vue.toasted.show(data.msg, {
                duration: data.dt,
                action: {
                    text: 'Close',
                    onClick: (e, t) => {
                        t.goAway(0);
                    }
                }
            });
        },
        /***@SAVE_ASSESSMENT**/
        saveAssessment(c) {
            return new Promise((r, n) => {
                client.post(`${apiUrl}/admin/assessment/create/`, {
                    assessment: c.state.mAssessment,
                    sections: c.state.mSectionsStack
                }, ajaxToken(c))
                    .then(res => {
                        c.commit('setClearMsg');
                        r(res.data);
                    })
                    .catch(err => {
                        c.commit('setClearMsg');
                        c.dispatch('HandleError', err.response);
                        n(err.response);
                    })
            });
        },
        /***@END_SAVE_ASSESSMENT**/
    } //end actions
});
