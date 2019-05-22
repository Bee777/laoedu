<template>
    <div>
        <div class="form-header" :style="`top: ${top}px; right: ${$utils.isMobile() ? '0': right}px;`">
            <div class="navigator">
                <div class="nav-left">
                    <div>
                        <button @click="Route({name: 'assessment' })" class="v-md-button v-md-icon-button theme-blue"><i
                            class="material-icons">arrow_back</i>
                        </button>
                    </div>
                    <div>Assessments</div>
                </div>
                <div class="nav-right">
                    <div class="actions" v-if="edit">
                        <div>
                            <button class="v-md-button v-md-icon-button theme-blue"><i
                                class="material-icons">visibility</i></button>
                        </div>
                        <div>
                            <button class="v-md-button primary"> Send</button>
                        </div>
                    </div>
                    <div class="actions" v-else>
                        <div>
                            <button @click="saveAssessmentHandle" class="v-md-button primary"> {{SaveText}}</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="shadow" :style="`opacity: 1;`">

            </div>
        </div>
        <div class="form-create-wrap">
            <div class="wrap">
                <div class="content-wrap">
                    <HeaderBanner title="Assessment Info"/>
                    <div class="item title title-focus main-form">
                        <div class="li main-form">
                            <textarea class="form-title no-resize normal-element"
                                      placeholder="Assessment title"
                                      v-model="mAssessment.title"
                                      @focus="$autoText($event)"
                                      @input="$autoText($event)"
                                      @keypress.enter="$disableEnterNewLine"
                                      ref="assessment-title-text-id"
                            ></textarea>
                        </div>
                        <div class="li main-form">
                            <textarea placeholder="Assessment description (optional)"
                                      v-model="mAssessment.description"
                                      @focus="$autoText($event)"
                                      class="form-desc normal-element"
                                      @input="$autoText($event)"
                                      ref="assessment-desc-text-id"></textarea>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import HeaderBanner from './Includes/HeaderBanner.vue'
    import {mapMutations, mapState, mapActions} from 'vuex'

    export default {
        name: "AssessmentForm",
        components: {
            HeaderBanner
        },
        data: () => ({
            top: 148,
            right: 0,
            edit: false,
            SaveText: 'Save'
        }),
        computed: {
            ...mapState(['mAssessment']),
        },
        methods: {
            ...mapMutations(['setAssessmentTextValueChangeDataStack', 'setEditAssessmentStatus']),
            ...mapActions(['saveAssessment']),
            scrollHandler(e) {
                if (e >= 48) {
                    this.top = 48;
                } else {
                    this.top = 148;
                }
            },
            checkScrollbar() {
                let el = this.jq('#main-container');
                if (el.get(0).clientHeight < el.get(0).scrollHeight) {
                    this.right = 17;
                }
            },
            setTitleTextValueChanged(el, key, value) {
                this.setAssessmentTextValueChangeDataStack({
                    value,
                    key,
                    el
                });
            },
            setDescTextValueChanged(el, key, value) {
                this.setAssessmentTextValueChangeDataStack({
                    value,
                    key,
                    el
                });
            },
            registerTextData() {
                let elTitle = this.$refs['assessment-title-text-id'],
                    elDesc = this.$refs['assessment-desc-text-id'];
                elTitle.addEventListener('input', (e) => {
                    this.setTitleTextValueChanged(e.target, 'title', e.target.value);
                });
                elDesc.addEventListener('input', (e) => {
                    this.setDescTextValueChanged(e.target, 'description', e.target.value);
                });
            },
            saveAssessmentHandle() {
                this.SaveText = 'Saving...';
                this.saveAssessment().then(res => {
                    if (res.success) {
                        this.Route({name: 'create-assessment', query: {assessment_id: res.data.assessment.id}});
                        this.setEditAssessmentStatus(true);
                        this.edit = true;
                    }
                    this.SaveText = 'Saved';
                    setTimeout(() => {
                        this.SaveText = 'Save';
                    }, 1000)
                }).catch(err => {
                    console.log(err);
                    this.SaveText = 'Save';
                })
            }
        },
        beforeDestroy() {
            this.Event.offListen('scrolling', this.scrollHandler);
        },
        mounted() {
            this.Event.listen('scrolling', this.scrollHandler);
            this.checkScrollbar();
            this.registerTextData();
        },
        created() {
            this.setDescTextValueChanged = this.debounce(this.setDescTextValueChanged, 200);
            this.setTitleTextValueChanged = this.debounce(this.setTitleTextValueChanged, 200);
        }
    }
</script>

<style scoped lang="scss">
    $blue: rgba(3, 155, 229, 0.6);
    $black: rgba(0, 0, 0, 0.87);
    $white: #ffffff;
    .form-header {
        position: fixed;
        left: 0;
        right: 17px;
        z-index: 1;
        height: 60px;
        color: rgba(0, 0, 0, 0.54);
        font-weight: bold;
        background-color: #eceff1;
        border-bottom: 1px solid rgba(0, 0, 0, 0.12);

        .navigator {
            display: -webkit-box;
            display: -moz-box;
            display: -webkit-flex;
            display: -ms-flexbox;
            display: flex;
            padding-top: 6px;

            .nav-left {
                -webkit-box-align: center;
                box-align: center;
                -webkit-align-items: center;
                align-items: center;
                display: -webkit-box;
                display: -moz-box;
                display: -webkit-flex;
                display: -ms-flexbox;
                display: flex;
                -webkit-box-flex: 1;
                box-flex: 1;
                -webkit-flex-grow: 1;
                flex-grow: 1;
                padding-left: 10px;
                margin-left: 256px;
                @media screen and (max-width: 63.95em) {
                    margin-left: 0;
                    padding-left: 0;
                }
            }

            .nav-right {
                margin-right: 16px;

                .actions {
                    -webkit-box-align: center;
                    box-align: center;
                    -webkit-align-items: center;
                    align-items: center;
                    display: -webkit-box;
                    display: -moz-box;
                    display: -webkit-flex;
                    display: -ms-flexbox;
                    display: flex;
                    padding-right: 2px;
                }
            }

            i {
                color: rgba(0, 0, 0, 0.54);
            }
        }

        .shadow {
            bottom: -6px;
            height: 6px;
            background-color: transparent;
            background-image: -webkit-linear-gradient(to bottom, rgba(0, 0, 0, 0.1), transparent);
            background-image: linear-gradient(to bottom, rgba(0, 0, 0, 0.1), transparent);
            opacity: 0;
            position: absolute;
            width: 100%;
        }
    }

    .app-sidebar-collapsed {
        .form-header {
            .navigator {
                .nav-left {
                    margin-left: 68px;
                }
            }
        }
    }
</style>
