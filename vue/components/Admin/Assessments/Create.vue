<template>
    <div>
        <Tabs :offsetLeft="getSideBarWidthForTabs()" :tabs="tabs"/>
        <div class="module_content layout-column">
            <div class="module_authentication">
                <div class="module-canvas emails-card-wrapper">
                    <div class="admin-master-detail-card">
                        <div class="md-single-grid">
                            <div ad-cell="12" class="theme-blue">
                                <FormTop/>
                                <div class="form-create-wrap">
                                    <div class="wrap">
                                        <div class="content-wrap">
                                            <div class="item title" @click="focusTitle($event)"
                                                 :class="{'title-focus': focusIndex === 'title'}">
                                                <div class="li">
                                                    <textarea class="form-title no-resize" placeholder="Section title"
                                                              v-model="data.display_name"
                                                              @focus="$autoText($event)"
                                                              @input="$autoText($event)"
                                                              @keypress.enter="$disableEnterNewLine"></textarea>
                                                </div>
                                                <div class="li" v-for="i in data.name">
                                                    <textarea placeholder="Section description (optional)"
                                                              v-model="i.desc"
                                                              @focus="$autoText($event)"
                                                              @input="$autoText($event)"></textarea>
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
    </div>
</template>

<script>
    import AdminBase from '@bases/AdminBase.js'
    import FormTop from '@com/Admin/Assessments/AssessmentForm.vue'
    import {mapActions} from 'vuex'

    let lineEndOptions = Array.apply(null, Array(9)).map((item, i) => {
        return i + 2
    })

    export default AdminBase.extend({
        name: "CreateAssessment",
        components: {
            FormTop
        },
        data() {
            return {
                title: 'Create New Assessment',
                type: 'users',
                watchers: true,
                tabs: [{name: 'Create Assessment'}],
                //form
                auth: false,
                loading: false,
                selectOptions: [
                    {name: 'Short answer', value: 'short_answer'},
                    {name: 'Paragraph', value: 'paragraph'},
                    {name: 'Multiple choice', value: 'multiple_choice'},
                    {name: 'Checkboxes', value: 'checkboxes'},
                    {name: 'Dropdown', value: 'dropdown'},
                    {name: 'Linear scale', value: 'linear_scale'},
                    {name: 'Matrix scale', value: 'matrix_scale'},
                    {name: 'Priority', value: 'priority'}
                ],
                addLangVisible: false,
                defaultOption: 'multiple_choice',
                addRadio: 'Add option',
                lineOptions: [0, 1],
                lineEndOptions: lineEndOptions,
                langArray: [],
                data: {
                    display_name: '',
                    name: [{
                        questionnaire_name: '',
                        desc: '',
                    }],
                    repeat_submit: false,
                    question: [{
                        question_id: 1,
                        types: 'multiple_choice',
                        is_required: false,
                        content: [
                            {
                                title: '',
                                answer: [{
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
                        ]
                    }
                    ]
                },
                editable: true,
                focusIndex: 0
                //    @end-form
            }
        },
        methods: {
            ...mapActions([]),
            focusTitle(event) {
                let classList = event.target.classList;
                if (classList.contains('add-list') || classList.contains('el-icon-plus')) return;
                this.focusIndex = 'title'
            },
        },
        created() {

        }
    });
</script>
<style lang="scss">
    @import "../Assets/reset.scss";
    @import url('../Assets/iconfont/iconfont.css');
    @import "../Assets/create-wrapper.scss";
</style>
