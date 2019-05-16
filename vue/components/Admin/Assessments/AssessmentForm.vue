<template>
    <div>
        <div class="form-header" :style="`top: ${top}px; right: ${$utils.isMobile() ? '0': right}px;`">
            <div class="navigator">
                <div class="nav-left">
                    <div>
                        <button class="v-md-button v-md-icon-button theme-blue"><i
                            class="material-icons">arrow_back</i>
                        </button>
                    </div>
                    <div>Assessments</div>
                </div>
                <div class="nav-right">
                    <div class="actions">
                        <div>
                            <button class="v-md-button v-md-icon-button theme-blue"><i
                                class="material-icons">visibility</i></button>
                        </div>
                        <div>
                            <button class="v-md-button primary"> Send</button>
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
                        <textarea class="form-title no-resize"
                                  placeholder="Assessment title"
                                  v-model="assessment.title"
                                  @focus="$autoText($event)"
                                  @input="$autoText($event)"
                                  @keypress.enter="$disableEnterNewLine"></textarea>
                        </div>
                        <div class="li main-form">
                        <textarea placeholder="Assessment description (optional)"
                                  v-model="assessment.description"
                                  @focus="$autoText($event)"
                                  @input="$autoText($event)"></textarea>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import HeaderBanner from './Includes/HeaderBanner.vue'

    export default {
        name: "AssessmentForm",
        components: {
            HeaderBanner
        },
        data: () => ({
            assessment: {},
            top: 148,
            right: 0,
        }),
        methods: {
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
            }
        },
        mounted() {
            this.Event.listen('scrolling', this.scrollHandler);
            this.checkScrollbar();
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
