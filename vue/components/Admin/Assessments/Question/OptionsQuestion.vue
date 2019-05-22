<template>

    <div class="q-item" v-if="allows.includes(type)">

        <draggable
            :list="mOptions"
            group="options"
            :handle="'.drap-area'"
            :move="onMove"
            @start="dragging=true"
            @end="dragging=false">

            <div class="q-radio" v-for="(item, i) in mOptions" :key="i">

                <div class="drap-area">
                    <i class="iconfont icon-menu-drag-head"></i>
                </div>

                <div class="icon-radio"
                     v-if="type === 'dropdown_list' || type === 'priority'">
                    {{i + 1}}.
                </div>
                <div v-else class="icon-radio"
                     :class="{'icon-cirle': type === 'multiple_choice', 'icon-square': type === 'checkboxes'}"></div>
                <input class="radio-input text-data"
                       :data-schema="`${JSON.stringify({sectionIndex, question_index: question_idx, content_index: answer_schema_index, option_index: i})}`"
                       :id="IdSchema(i)"
                       v-model="item.description">
                <i class="el-icon-close" v-if="isItemFocus(question_idx)"
                   @click="deleteRadioFn(i)"></i>
            </div>

        </draggable>


        <div class="q-radio" v-if="isItemFocus(question_idx)">
            <div class="drap-area area-temp">
                <i class="iconfont icon-menu-drag-head"></i>
            </div>
            <div class="icon-radio" v-if="type === 'dropdown_list' || type === 'priority'">
                {{options.length + 1}}.
            </div>
            <div v-else class="icon-radio"
                 :class="{'icon-cirle': type === 'multiple_choice', 'icon-square': type === 'checkboxes'}"></div>
            <input class="radio-add" v-model="addRadio"
                   @focus="addRadioFn()">
        </div>
    </div>

</template>

<script>
    import draggable from 'vuedraggable';

    export default {
        name: "OptionsQuestion",
        components: {
            draggable,
        },
        props: {
            type: {
                default: 'multiple_choice',
            },
            options: {
                default: function () {
                    return [];
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
            mOptions: [],
            allows: [
                'multiple_choice',
                'checkboxes',
                'dropdown_list',
                'priority'
            ],
            addRadio: 'Add option'
        }),
        watch: {
            options: function (n) {
                this.mOptions = n;
                this.$nextTick(() => {
                    this.registerTextData();
                })
            }
        },
        methods: {

            preIdSchema() {
                return `section-${this.sectionIndex}-question-${this.question_idx}-aws-${this.answer_schema_index}-op-`;
            },
            /**
             * @return {string}
             */
            IdSchema(i) {
                return `section-${this.sectionIndex}-question-${this.question_idx}-aws-${this.answer_schema_index}-op-${i}`;
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
                    length: this.options.length
                })
            },
            addRadioFn() {
                this.$emit('onAddOptionAnswerClick', {
                    question_idx: this.question_idx,
                    answer_schema_index: this.answer_schema_index,
                    new_id_idx: this.IdSchema(this.options.length),
                    id_schema: this.preIdSchema(),
                    length: this.options.length
                })
            },
            onMove({relatedContext, draggedContext}) {
                let relatedIndex = relatedContext.index;
                relatedContext.element.answer_id = draggedContext.index;
                draggedContext.element.answer_id = relatedIndex;
                return true;
            },
            registerTextData() {
                let classSchema = `.radio-input.text-data`,
                    els = this.jq(classSchema);
                els.each((idx, item) => {
                    item.removeEventListener('input', this.assignSchemaTextData, true);
                    item.addEventListener('input', this.assignSchemaTextData, true);
                });
            },
            assignSchemaTextData(o) {
                this.setTextValueChanged(o.target, 'description', o.target.value, o.target.getAttribute('data-schema'));
            },
            setTextValueChanged(el, key, value, schema) {
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
        mounted() {
            this.registerTextData();
        },
        created() {
            this.mOptions = this.$utils.clone(this.options);
            this.setTextValueChanged = this.debounce(this.setTextValueChanged, 200);
        }
    }
</script>

<style scoped>

</style>
