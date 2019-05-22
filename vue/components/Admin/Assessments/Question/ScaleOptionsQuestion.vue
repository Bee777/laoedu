<template>

    <div>
        <div class="q-item line-wrap non-options"
             v-if="type === 'linear_scale'">
            <div class="q-item-line">
                <el-select v-model="content.line_answer.line_value">
                    <el-option
                        v-for="i in lineOptions"
                        :key="i"
                        :value="i">
                    </el-option>
                </el-select>
                <span class="line-tip">To</span>
                <el-select
                    v-model="content.line_answer.line_end_value">
                    <el-option
                        v-for="i in lineEndOptions"
                        :key="i"
                        :value="i">
                    </el-option>
                </el-select>
            </div>
            <div class="q-radio">
                <div class="icon-radio">1.</div>
                <input class="radio-input text-data scale"
                       v-model="content.line_answer.line_tag"
                       :data-schema="`${JSON.stringify({sectionIndex, question_index: question_idx, content_index: answer_schema_index , key: 'line_tag', content: content.line_answer})}`"
                       placeholder="Label (optional)">
            </div>
            <div class="q-radio">
                <div class="icon-radio">2.</div>
                <input class="radio-input text-data scale"
                       :data-schema="`${JSON.stringify({sectionIndex, question_index: question_idx, content_index: answer_schema_index , key: 'line_end_tag', content: content.line_answer})}`"
                       v-model="content.line_answer.line_end_tag"
                       placeholder="Label (optional)">
            </div>
        </div>

        <div class="q-item line-wrap square-wrap non-options"
             v-if="type === 'matrix_scale'">
            <div class="square-li">
                <h4>Row</h4>
                <div class="q-item-line">
                    <el-select
                        v-model="content.line_answer.line_value">
                        <el-option
                            v-for="i in lineOptions"
                            :key="i"
                            :value="i">
                        </el-option>
                    </el-select>
                    <span class="line-tip">To</span>
                    <el-select
                        v-model="content.line_answer.line_end_value">
                        <el-option
                            v-for="i in lineEndOptions"
                            :key="i"
                            :value="i">
                        </el-option>
                    </el-select>
                </div>
                <div class="q-radio">
                    <div class="icon-radio">1.</div>
                    <input class="radio-input text-data scale"
                           :data-schema="`${JSON.stringify({sectionIndex, question_index: question_idx, content_index: answer_schema_index , key: 'line_tag', content: content.line_answer})}`"
                           v-model="content.line_answer.line_tag"
                           placeholder="Label (optional)">
                </div>
                <div class="q-radio">
                    <div class="icon-radio">2.</div>
                    <input class="radio-input text-data scale"
                           v-model="content.line_answer.line_end_tag"
                           :data-schema="`${JSON.stringify({sectionIndex, question_index: question_idx, content_index: answer_schema_index , key: 'line_end_tag', content: content.line_answer})}`"
                           placeholder="Label (optional)">
                </div>
            </div>

            <div class="square-li square-percent-13">
                <h4 class="drag-area">Column</h4>

                <draggable

                    :list="mOptions"
                    group="options"
                    :handle="'.drap-area'"
                    :move="onMove"
                    @start="dragging=true"
                    @end="dragging=false">


                    <div class="q-radio"
                         v-for="(item, i) in mOptions" :key="i">

                        <div class="drap-area">
                            <i class="iconfont icon-menu-drag-head"></i>
                        </div>

                        <div class="icon-radio">{{i + 1}}.</div>
                        <input class="radio-input text-data"
                               :data-schema="`${JSON.stringify({sectionIndex, question_index: question_idx, content_index: answer_schema_index, option_index: i})}`"
                               :id="IdSchema(i)"
                               v-model="item.description">
                        <i class="el-icon-close"
                           v-if="isItemFocus(question_idx)"
                           @click="deleteRadioFn(i)"></i>
                    </div>

                </draggable>

                <div class="q-radio" v-if="isItemFocus(question_idx)">
                    <div class="drap-area area-temp">
                        <i class="iconfont icon-menu-drag-head"></i>
                    </div>
                    <div class="icon-radio">{{content.option_answers.length + 1}}.
                    </div>
                    <input class="radio-add" v-model="addRadio"
                           @focus="addRadioFn()">
                </div>
            </div>

        </div>
    </div>


</template>

<script>
    let lineEndOptions = Array.apply(null, Array(9)).map((item, i) => {
        return i + 2
    });

    import draggable from 'vuedraggable';

    export default {
        name: "ScaleOptionQuestion",
        components: {
            draggable,
        },
        props: {
            type: {
                default: 'multiple_choice',
            },
            content: {
                default: function () {
                    return {
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
                }
            },
            sectionIndex: {
                default: 0
            },
            currentSectionIndex: {
                default: 0
            },
            focusIndex: {
                default: 0
            },
            question_idx: {
                default: 0
            },
            answer_schema_index: {
                default: 0
            }
        },
        data: () => ({
            dragging: false,
            addRadio: 'Add option',
            lineOptions: [0, 1],
            lineEndOptions: lineEndOptions,
            mOptions: [],
        }),
        watch: {
            'content.option_answers': function (n) {
                this.mOptions = n;
                this.$nextTick(() => {
                    this.registerOptionsTextData();
                })
            },
            type: function (n) {
                this.$nextTick(() => {
                    this.registerTextData();
                })
            }
        },
        methods: {
            preIdSchema() {
                return `section-${this.sectionIndex}-question-${this.question_idx}-aws-${this.answer_schema_index}-matrix-`
            },
            /**
             * @return {string}
             */
            IdSchema(i) {
                return `section-${this.sectionIndex}-question-${this.question_idx}-aws-${this.answer_schema_index}-matrix-${i}`;
            },
            isItemFocus(idx) {
                return this.focusIndex === idx && this.currentSectionIndex === this.sectionIndex;
            },
            deleteRadioFn(i) {
                this.$emit('onDeleteOptionAnswerClick', {
                    question_idx: this.question_idx,
                    answer_schema_index: this.answer_schema_index,
                    index: i,
                    id_schema: this.preIdSchema(),
                    length: this.content.option_answers.length
                })
            },
            addRadioFn() {
                this.$emit('onAddOptionAnswerClick', {
                    question_idx: this.question_idx,
                    answer_schema_index: this.answer_schema_index,
                    new_id_idx: this.IdSchema(this.content.option_answers.length),
                    id_schema: this.preIdSchema(),
                    length: this.content.option_answers.length
                })
            },
            onMove({relatedContext, draggedContext}) {
                let relatedIndex = relatedContext.index;
                relatedContext.element.answer_id = draggedContext.index;
                draggedContext.element.answer_id = relatedIndex;
                return true;
            },
            registerOptionsTextData() {
                let classSchema = `.radio-input.text-data`,
                    els = this.jq(classSchema);
                els.each((idx, item) => {
                    item.removeEventListener('input', this.assignSchemaOptionTextData, true);
                    item.addEventListener('input', this.assignSchemaOptionTextData, true);
                });
            },
            assignSchemaOptionTextData(o) {
                this.setOptionTextValueChanged(o.target, 'description', o.target.value, o.target.getAttribute('data-schema'));
            },
            registerTextData() {
                let classSchema = `.radio-input.text-data.scale`,
                    els = this.jq(classSchema);
                els.each((idx, item) => {
                    item.removeEventListener('input', this.assignSchemaTextData, true);
                    item.addEventListener('input', this.assignSchemaTextData, true);
                });
            },
            assignSchemaTextData(o) {
                this.setTextValueChanged(o.target, 'line_answer', o.target.value, o.target.getAttribute('data-schema'));
            },
            setTextValueChanged(el, key, value, schema) {
                let parseSchema = this.$utils.parseJSON(schema);
                this.$store.commit('setTextValueChangeDataStack', {
                    sectionIndex: this.sectionIndex,
                    type: 'option_answers_linear_scale',
                    value: value,
                    key: key,
                    el: el,
                    schema: parseSchema,
                })
            },
            setOptionTextValueChanged(el, key, value, schema) {
                let parseSchema = this.$utils.parseJSON(schema);
                this.$store.commit('setTextValueChangeDataStack', {
                    sectionIndex: this.sectionIndex,
                    type: 'option_answers',
                    value: value,
                    key: key,
                    el: el,
                    schema: parseSchema,
                })
            },
        },
        mounted(){
            this.registerOptionsTextData();
        },
        created() {
            this.mOptions = this.$utils.clone(this.content.option_answers);
            this.setTextValueChanged = this.debounce(this.setTextValueChanged, 200);
            this.setOptionTextValueChanged = this.debounce(this.setOptionTextValueChanged, 200);
        }
    }
</script>

<style scoped>

</style>
