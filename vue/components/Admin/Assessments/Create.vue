<template>
    <div>
        <Tabs :offsetLeft="getSideBarWidthForTabs()" :tabs="tabs"/>
        <div class="module_content layout-column">
            <div class="module_authentication">
                <div class="module-canvas emails-card-wrapper">
                    <div class="admin-master-detail-card">
                        <div class="md-single-grid assessment-form">
                            <div ad-cell="12" class="theme-blue absolute-parent clearfix">
                                <FormTop/>
                                <div class="ViewPagePageBreakGap">
                                    <label class="ViewPageGoToPageSelectLabel">
                                        Continue to question sections
                                    </label>
                                </div>

                                <div class="questions-section clearfix">
                                    <div class="questions">

                                        <div class="FormeditorViewFatDesktop">
                                            <div class="ViewFatPositioner" ref="ActionPositioner">
                                                <div class="ViewFatCard">
                                                    <ActionFormeditor
                                                        :disabled="disableTooltip"
                                                        @OnAddQuestion="addSectionQuestion(currentSectionIndex)"
                                                        @OnAddSection="AddSection()"/>
                                                </div>
                                            </div>
                                        </div>

                                        <QuestionsSection
                                            class="clearfix"
                                            v-for="(sItem, sIdx ) in mSectionsStack" :key="sIdx"
                                            :section="sItem"
                                            :sectionIndex="sIdx"
                                            :currentSectionIndex="currentSectionIndex"
                                            :total="mSectionsStack.length"
                                            @onSectionClick="setCurrentSectionIndex"
                                            @onDropdownClick="DropdownOptionClick"
                                            :ref="`section-${sIdx}`">

                                            <template slot="questions">

                                                <Questionnaire
                                                    :sectionIndex="sIdx"
                                                    :currentSectionIndex="currentSectionIndex"
                                                    :questions="sItem.questions"
                                                    :popFocusIndex="sItem.focusIndex"
                                                    @onFocusQuestionItemClick="(idx)=>{setPlacePositioner();sItem.focusIndex=idx}"
                                                    @onAddOptionItemClick="addRadioFn(sItem, $event)"
                                                    @onDeleteOptionItemClick="deleteRadioFn(sItem, $event)"
                                                    @onCopyQuestionClick="copyListFn(sItem, $event)"
                                                    @onDeleteQuestionClick="deleteListFn(sItem, $event)">

                                                </Questionnaire>

                                            </template>

                                        </QuestionsSection>

                                    </div>


                                    <div class="ViewFatMobile">
                                        <div class="FormeditorViewFatPositioner">
                                            <div class="FormeditorViewFatCard">
                                                <ActionFormeditor
                                                    :disabled="disableTooltip"
                                                    @OnAddQuestion="addSectionQuestion(currentSectionIndex)"
                                                    @OnAddSection="AddSection()"/>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import AdminBase from '@bases/AdminBase.js'

    import FormTop from '@com/Admin/Assessments/AssessmentForm.vue'
    import QuestionsSection from './Question/Section.vue'
    import Questionnaire from './Question/Questionnaire.vue'
    import ActionFormeditor from './Includes/ActionFormeditor.vue'

    import {mapActions, mapMutations, mapState} from 'vuex'
    import {setPlacePositioner, getSectionsScrollHeight} from '../Assets/PlaceElements.js'

    let lineEndOptions = Array.apply(null, Array(9)).map((item, i) => {
        return i + 2
    });

    export default AdminBase.extend({
        name: "CreateAssessment",
        components: {
            FormTop,
            QuestionsSection,
            Questionnaire,
            ActionFormeditor
        },
        data() {
            return {
                title: 'Create New Assessment',
                type: 'none',
                watchers: true,
                tabs: [{name: 'Create Assessment'}],
                formChanged: false,
                loading: false,
                disableTooltip: false,
                positioner: null,
                targetViewPort: null,
                currentSectionIndex: 0,
                //@form
                selectOptions: [
                    {name: 'Short answer', value: 'short_answer'},
                    {name: 'Paragraph', value: 'paragraph'},
                    {name: 'Multiple choice', value: 'multiple_choice'},
                    {name: 'Checkboxes', value: 'checkboxes'},
                    {name: 'Dropdown', value: 'dropdown_list'},
                    {name: 'Linear scale', value: 'linear_scale'},
                    {name: 'Matrix scale', value: 'matrix_scale'},
                    {name: 'Priority', value: 'priority'}
                ],
                defaultOption: 'multiple_choice',
                addRadio: 'Add option',
                lineOptions: [0, 1],
                lineEndOptions: lineEndOptions,
                //@end-form
            }
        },
        computed: {
            ...mapState(['mEditAssessment', 'mAssessment', 'mSectionsStack', 'mUndo', 'mRedo']),
        },
        watch: {
            mAssessment: {
                deep: true,
                handler: function (n) {
                    this.formChanged = true;
                }
            },
            mSectionsStack: {
                deep: true,
                handler: function (n) {
                    this.formChanged = true;
                }
            },
            'mEditAssessment': function (n) {
                this.getAssessment();
            }
        },
        methods: {
            ...mapMutations([
                'setUndoRedoHistory',
                'addSectionDataStack', 'deleteSectionDataStack',
                'addSectionQuestionDataStack', 'deleteSectionQuestionDataStack',
                'addRadioOptionQuestionDataStack', 'deleteRadioOptionQuestionDataStack',
                'setEditAssessmentStatus',
            ]),
            ...mapActions([]),
            /**@ON_REDO_UNDO*/
            onUndo({undone}) {
                if (undone.length) {
                    let lastCheckPoint = undone[undone.length - 1],
                        payload = lastCheckPoint.payload,
                        currentSection = this.mSectionsStack[payload.sectionIndex];

                    if (lastCheckPoint.type === "setAssessmentTextValueChangeDataStack") {
                        payload.el.focus();
                        this.$utils.scrollToY('main-container', payload.el.offsetTop);
                    } else if (lastCheckPoint.type === "setTextValueChangeDataStack") {
                        payload.el.focus();
                    } else if (lastCheckPoint.type === "addRadioOptionQuestionDataStack") {
                        this.$nextTick(() => {
                            this.setCurrentSectionIndex(payload.sectionIndex);
                            currentSection.focusIndex = payload.question_index;
                            let input = document.getElementById(payload.id_schema + (payload.length - 1));
                            if (input)
                                input.focus();
                        });
                    } else if (lastCheckPoint.type === "deleteRadioOptionQuestionDataStack") {
                        this.setCurrentSectionIndex(payload.sectionIndex);
                        currentSection.focusIndex = payload.question_index;
                        this.$nextTick(() => {
                            let input = document.getElementById(payload.id_schema + (payload.index));
                            if (input)
                                input.focus();
                        });
                    } else if (lastCheckPoint.type === "addSectionDataStack") {
                        this.setCurrentSectionIndex(payload.index - 1);
                    } else if (lastCheckPoint.type === "deleteSectionQuestionDataStack") {
                        this.setCurrentSectionIndex(payload.sectionIndex);
                        currentSection.focusIndex = payload.index;
                    } else if (lastCheckPoint.type === "deleteSectionDataStack") {
                        this.setCurrentSectionIndex(payload.index);
                    }
                }
            },
            onRedo({done}) {
                if (done.length) {
                    let lastCheckPoint = done[done.length - 1],
                        payload = lastCheckPoint.payload,
                        currentSection = this.mSectionsStack[payload.sectionIndex];

                    if (lastCheckPoint.type === "setAssessmentTextValueChangeDataStack") {
                        payload.el.focus();
                        this.$utils.scrollToY('main-container', payload.el.offsetTop);
                    } else if (lastCheckPoint.type === "setTextValueChangeDataStack") {
                        payload.el.focus();
                    } else if (lastCheckPoint.type === "addRadioOptionQuestionDataStack") {
                        this.setCurrentSectionIndex(payload.sectionIndex);
                        currentSection.focusIndex = payload.question_index;
                        this.$nextTick(() => {
                            let input = document.getElementById(payload.id_schema + (payload.length - 1));
                            if (input)
                                input.focus();
                        });
                    } else if (lastCheckPoint.type === "deleteRadioOptionQuestionDataStack") {
                        this.setCurrentSectionIndex(payload.sectionIndex);
                        currentSection.focusIndex = payload.question_index;
                        this.$nextTick(() => {
                            let input = document.getElementById(payload.id_schema + (payload.index - 1));
                            if (input)
                                input.focus();
                        });
                    } else if (lastCheckPoint.type === "addSectionDataStack") {
                        this.setCurrentSectionIndex(payload.index);
                    } else if (lastCheckPoint.type === "deleteSectionQuestionDataStack") {
                        this.setCurrentSectionIndex(payload.sectionIndex);
                        currentSection.focusIndex = payload.focusIndex;
                    } else if (lastCheckPoint.type === "deleteSectionDataStack") {
                        this.setCurrentSectionIndex(payload.index - 1);
                    }
                }
            },
            /**@END_ON_REDO_UNDO*/
            /**@END_SECTION QUESTIONS*/
            setCurrentSectionIndex(index) {
                this.currentSectionIndex = index;
                //set positioner position
                this.setPlacePositioner();
            },
            AddSection() {
                let index = this.currentSectionIndex,
                    schema = {
                        title: '',
                        desc: '',
                        focusIndex: -1,
                        questions: []
                    };
                this.addSectionDataStack({schema, index: index + 1});
                this.setCurrentSectionIndex(index + 1);
                //scroll to new focus section
                this.$nextTick(() => {
                    this.$utils.scrollToY('main-container', getSectionsScrollHeight(this));
                });
            },
            DropdownOptionClick(schema) {
                let index = schema.sectionIndex;
                if (schema.action === 'create') {
                    this.AddSection();
                }
                if (schema.action === 'duplicate') {
                    let data = JSON.parse(JSON.stringify(this.mSectionsStack[index]));
                    //set section stacking data
                    this.addSectionDataStack({schema: data, index});
                    this.setCurrentSectionIndex(index + 1);
                }
                if (schema.action === 'delete') {
                    this.deleteSectionDataStack({index});
                    this.setCurrentSectionIndex(index === 0 ? 0 : index - 1);
                    this.unDoToast();
                }
            },
            /**@END_SECTION QUESTIONS*/
            addSectionQuestion() {
                let section = this.mSectionsStack[this.currentSectionIndex];
                //@disable tooltip when add question positioner click
                this.disableTooltip = true;

                if (!section) {
                    return;
                }
                //content list purpose for multiple language
                let contentList = [
                    {
                        language: 'en',
                        title: '',
                        option_answers: [{
                            answer_id: 1,
                            description: 'Option 1'
                        }],
                        line_answer: {
                            line_value: 1,
                            line_end_value: 5,
                            line_tag: '',
                            line_end_tag: ''
                        },
                        text_answer: ''
                    }
                ];

                let index = section.focusIndex,
                    list = {
                        types: 'multiple_choice',
                        is_required: false,
                        content: contentList
                    };

                //set section stacking data
                this.addSectionQuestionDataStack({
                    sectionIndex: this.currentSectionIndex,
                    index: index + 1,
                    focusIndex: index + 1,
                    list
                });
                //set positioner position
                this.setPlacePositioner();
            },
            copyListFn(section, question_idx) {
                let data = JSON.parse(JSON.stringify(section.questions[question_idx]));
                this.addSectionQuestionDataStack({
                    sectionIndex: this.currentSectionIndex,
                    index: question_idx,
                    focusIndex: question_idx + 1,
                    list: data
                });
                //set positioner position
                this.setPlacePositioner();
            },
            deleteListFn(section, question_idx) {
                let focusIndex = section.questions.length - 1 <= 0 ? -1 : question_idx === 0 ? 0 : question_idx - 1;
                this.deleteSectionQuestionDataStack({
                    sectionIndex: this.currentSectionIndex,
                    index: question_idx,
                    focusIndex
                });
                setTimeout(() => {
                    section.focusIndex = focusIndex;
                    //set positioner position
                    this.setPlacePositioner();
                    this.unDoToast();
                }, 20);
            },
            /**@RADIO_QUESTION */
            addRadioFn(section, option_schema) {
                this.addRadioOptionQuestionDataStack({
                    sectionIndex: this.currentSectionIndex,
                    question_index: option_schema.question_idx,
                    option_answer_index: option_schema.answer_schema_index,
                    full_id_schema: option_schema.new_id_idx,
                    id_schema: option_schema.id_schema,
                    length: option_schema.length,
                });
                this.$nextTick(() => {
                    let input = document.getElementById(option_schema.new_id_idx);
                    if (input)
                        input.focus();
                });
            },
            deleteRadioFn(section, option_schema) {
                this.deleteRadioOptionQuestionDataStack({
                    sectionIndex: this.currentSectionIndex,
                    question_index: option_schema.question_idx,
                    option_answer_index: option_schema.answer_schema_index,
                    index: option_schema.index,
                    id_schema: option_schema.id_schema,
                    length: option_schema.length,
                });
                let focusOptionIndex = option_schema.index === 0 ? 0 : option_schema.index - 1;
                this.$nextTick(() => {
                    let input = document.getElementById(option_schema.id_schema + focusOptionIndex);
                    if (input)
                        input.focus();
                });
            },
            /**@END_RADIO_QUESTION */
            setPlacePositioner() {
                this.$nextTick(() => {
                    setPlacePositioner(this);
                    //@enable tooltip
                    this.disableTooltip = false;
                });
            },
            scrollHandler() {
                this.setPlacePositioner();
            },
            keyHandler(e) {
                const key = e.which || e.keyCode;
                let ac = document.activeElement;
                if (ac.className.indexOf('el-input__inner') !== -1) {//except for select options
                    return;
                }
                if (e.ctrlKey && key === 90) {//ctrl + z undo
                    e.preventDefault();
                    if (this.canUndo) {
                        this.undo();
                    }
                } else if (e.ctrlKey && key === 89) {//ctrl + y redo
                    e.preventDefault();
                    if (this.canRedo) {
                        this.redo();
                    }
                }
            },
            registerHandler() {
                this.$on('onRedo', this.onRedo);
                this.$on('onUndo', this.onUndo);
                this.Event.listen('scrolling', this.scrollHandler);
                window.addEventListener('keydown', this.keyHandler)
            },
            unRegisterHandler() {
                this.$off('onRedo', this.onRedo);
                this.$off('onUndo', this.onUndo);
                this.Event.offListen('scrolling', this.scrollHandler);
                window.removeEventListener('keydown', this.keyHandler);
            },
            unDoToast() {
                this.$toasted.show('Item deleted', {
                    duration: 4500,
                    action: {
                        text: 'Undo',
                        onClick: (e, t) => {
                            t.goAway(0);
                            if (this.canUndo) {
                                this.undo();
                            }
                        }
                    }
                });
            },
            beforeUnload() {
                window.addEventListener("beforeunload", (event) => {
                    if (this.formChanged) {
                        (event || window.event).returnValue = "Are you sure you want to leave?";
                    }
                });
            },
            getAssessment() {
                let id = this.$route.query.assessment_id;
                this.title = 'Edit Assessment';
                this.tabs[0].name = 'Assessment';
                this.setPageTitle(this.title);
            }
        },
        mounted() {
            this.positioner = this.$refs['ActionPositioner'];
            this.targetViewPort = this.jq('#main-container');
            this.registerHandler();
            //this.beforeUnload();
        },
        beforeRouteLeave(to, from, next) {
            if (this.formChanged) {
                this.setUndoRedoHistory({Undo: this.done, Redo: this.undone})
            }
            next();
        },
        beforeRouteEnter(to, from, next) {
            next(vm => {
                if (vm.mUndo.length) {
                    vm.done = Object.assign([], vm.mUndo);
                }
                if (vm.mRedo.length) {
                    vm.undone = Object.assign([], vm.mRedo);
                }
            });
        },
        beforeDestroy() {
            this.unRegisterHandler();
        },
        created() {
            this.setPlacePositioner = this.debounce(this.setPlacePositioner, 100);
            if (this.$route.query.assessment_id) {
                this.getAssessment();
            }
        },
    });
</script>
<style lang="scss">
    @import "../Assets/reset.scss";
    @import url('../Assets/iconfont/iconfont.css');
    @import "../Assets/create-wrapper.scss";

    .md-single-grid.assessment-form {
        min-height: 799px;
    }
</style>
