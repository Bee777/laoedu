<template>
    <div>
        <section class="section dictionary-section">
            <div class="container">
                <div class="page-blog fire-spinner-covered">
                    <div class="fire-spinner" v-if="shouldLoadingSingle(type)"></div>
                    <div class="dictionary-container">
                        <div class="dictionary-header">
                            <div class="back-button" @click="onBackButtonClick()">
                                <i class="material-icons">
                                    arrow_back
                                </i>
                            </div>
                            <div class="lang-lao">
                                <div class="lao-inner-btn lang-btn"><a class="selector-btn">Japanese</a></div>
                            </div>
                            <div class="lang-splitter">
                                <i class="material-icons">
                                    unfold_more
                                </i>
                            </div>
                            <div class="lang-jp">
                                <div class="jp-inner-btn lang-btn"><a class="selector-btn">Lao</a></div>
                            </div>
                        </div>
                        <div class="single-dictionary-main-card-container">
                            <div class="header-container">
                                <div class="header-text-container">
                                    <div>Translation of
                                        <span>{{ singlePostsData.dictionaries.data.japanese }}</span>
                                    </div>
                                </div>
                                <div class="content-float-right"></div>
                            </div>
                            <div class="translation-lists">
                                <div class="text-translation-info">
                                    <div class="text-translation-info-inner">
                                        <div class="text-lao">
                                            <b>{{ singlePostsData.dictionaries.data.lao }}</b>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="translation-description">
                                <div class="translation-description-title">Description</div>
                                <div class="translation-description-text">
                                    <div class="inner">
                                        <div class="row-text">
                                            {{ singlePostsData.dictionaries.data.description }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--Dictionary comments-->
                        <DictionaryComments :dictionary_id="singleId"/>
                        <!--Dictionary comments-->
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
    import Base from '@com/Bases/GeneralBase.js'
    import DictionaryComments from '@com/General/Pages/Single/DictionaryComment/DictionaryComments.vue'

    export default Base.extend({
        name: "SingleDictionary",
        components: {
            DictionaryComments
        },
        data: () => ({
            type: 'dictionaries',
        }),
        watch: {
            '$route.params': function (n, o) {
                this.$utils.scrollToY('html,body', 10);
                this.singleId = n.id;
                this.fetchSinglePostsData({type: this.type, id: this.singleId});
            }
        },
        methods: {
            setItem(data) {
                this.setPageTitle(`Dictionary translation of ${data.data.japanese} - ${data.data.lao}`)
            },
            onBackButtonClick() {
                this.Route({name: 'dictionary', params: {setQueryFilters: true}});
            },
        },
        created() {
            this.registerWatches();
            this.setPageTitle('The Dictionary');
            this.singleId = this.$route.params.id;
            this.fetchSinglePostsData({type: this.type, id: this.singleId});
        }
    });
</script>

<style scoped>

    .back-button {
        position: relative;
        margin-left: 14px;
        background-color: transparent;
        vertical-align: top;
        display: inline-block;
        width: 26px;
        height: 46px;
        line-height: 48px;
        cursor: pointer;
        -moz-user-select: none;
        -ms-user-select: none;
        -webkit-user-select: none;
    }

    .back-button i {
        opacity: .55;
        position: absolute;
        top: 10px;
        font-size: 26px;
    }

    .page-blog {
        padding-top: 26px;
        min-height: 480px;
    }

    .dictionary-header {
        background-color: #fff;
        box-sizing: border-box;
        height: 48px;
        -webkit-border-radius: 8px 8px 0 0;
        -moz-border-radius: 8px 8px 0 0;
        -ms-border-radius: 8px 8px 0 0;
        border-radius: 8px 8px 0 0;
        -webkit-box-shadow: 0 1px 4px 0 rgba(0, 0, 0, 0.37);
        -moz-box-shadow: 0 1px 4px 0 rgba(0, 0, 0, 0.37);;
        box-shadow: 0 1px 4px 0 rgba(0, 0, 0, 0.37);
    }

    .lang-lao, .lang-jp {
        display: inline-block;
        width: 45%;
        margin: 0;
        word-break: normal;
    }

    .lang-splitter {
        position: relative;
        background-color: #fff;
        display: inline-block;
        margin: 0 -25px;
        vertical-align: top;
        width: 26px;
        height: 46px;
        line-height: 48px;
    }

    .lang-splitter i {
        opacity: .55;
        position: absolute;
        top: 10px;
        -moz-transform: rotate(90deg);
        -webkit-transform: rotate(90deg);
        -mz-transform: rotate(90deg);
        transform: rotate(90deg);
        font-size: 26px;
    }

    .lang-btn {
        font-size: 14px;
        height: 46px;
        position: relative;
    }

    .lao-inner-btn {
        margin-right: 25px;
    }

    .jp-inner-btn {
        margin-left: 25px;
    }

    .selector-btn {
        font-weight: 500;
        overflow-x: hidden;
        overflow-y: hidden;
        text-align: center;
        text-overflow: ellipsis;
        text-transform: uppercase;
        white-space: pre;
        -moz-user-select: none;
        -ms-user-select: none;
        -webkit-user-select: none;
        cursor: default;
        -moz-appearance: none;
        -webkit-appearance: none;
        background-color: transparent;
        border: none;
        box-sizing: border-box;
        color: #3A3E4A;
        font-family: inherit;
        font-size: 16px;
        height: 47px;
        line-height: 45px;
        outline: none;
        padding-left: 16px;
        padding-right: 30px;
        position: absolute;
        width: 100%;
    }

    .single-dictionary-main-card-container {
        background-color: #fff;
        border: 1px solid #dadce0;
        -webkit-border-radius: 0 0 8px 8px;
        -moz-border-radius: 0 0 8px 8px;
        -ms-border-radius: 0 0 8px 8px;
        border-radius: 0 0 8px 8px;
        padding-top: 16px;
        padding-bottom: 8px;
        outline-width: 0;
        position: relative;
        margin-bottom: 8px;
    }

    .header-container, .translation-lists, .translation-description {
        padding: 0 8px 8px;
    }

    .header-text-container {
        padding: 0 8px 11px;
        color: #777;
        display: inline-block;
        font-family: 'Google Sans', sans-serif;
        font-size: 16px;
    }

    .header-text-container span {
        color: #222;
        unicode-bidi: embed;
        direction: ltr;
    }

    .content-float-right {
        float: right;
    }

    .text-translation-info {
        margin: 4px 20px 12px 16px;
    }

    .text-translation-info-inner {
        padding-bottom: 2px;
    }

    .text-translation-info-inner .text-lao {
        color: rgba(0, 0, 0, 0.87);
    }

    .translation-description-title {
        color: rgba(0, 0, 0, 0.54);
        text-transform: capitalize;
        font-size: 14px;
        font-weight: 500;
        margin: 4px 0 2px 8px;
        padding-bottom: 10px;
    }

    .translation-description-text {
        margin-left: 16px;
        margin-right: 20px;
        unicode-bidi: embed;
    }

    .translation-description-text .inner {
        margin-bottom: 12px;
    }

    .translation-description-text .inner .row-text {
        color: rgba(0, 0, 0, 0.87);
        unicode-bidi: inherit;
    }


    /*@mediaScreen*/

    @media screen and (max-width: 719px) {
        .dictionary-header {
            -webkit-border-radius: 0;
            -moz-border-radius: 0;
            -ms-border-radius: 0;
            border-radius: 0;
            -webkit-box-shadow: none;
            -moz-box-shadow: none;
            box-shadow: none;
            box-shadow: unset;
        }

        .section.dictionary-section {
            padding: 0;
        }

        .page-blog {
            margin: 0;
            padding-top: 0;
        }

        .single-dictionary-main-card-container {
            margin: 4px 4px;
            margin-bottom: 8px;

            -webkit-border-radius: 8px;
            -moz-border-radius: 8px;
            -ms-border-radius: 8px;
            border-radius: 8px;
        }

        .dictionary-header {
            border-top: 1px solid rgba(0, 0, 0, 0.12);
            border-bottom: 1px solid rgba(0, 0, 0, 0.12);
        }


    }

    @media screen and (min-width: 720px) and (max-width: 1087px) {
        .dictionary-container {
            padding-left: 1rem;
            padding-right: 1rem;
        }
    }

    /*@mediaScreen*/

</style>
