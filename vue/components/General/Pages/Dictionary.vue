<template>
    <div>
        <div class="page-header">
            <section class="section">
                <div class="container">
                    <h2 class="header-title">All Dictionaries</h2>
                    <PostsSearchForm v-model="query" @onSearchEnter="getItems('click')"/>
                </div>
            </section>
        </div>
        <section class="section dictionary-section">
            <div class="container">
                <div class="page-blog fire-spinner-covered">
                    <div class="fire-spinner" v-if="shouldLoading(type)"></div>

                    <div class="dictionary-container">
                        <div class="dictionary-header">
                            <div class="lang-lao">
                                <div class="lao-inner-btn lang-btn"><a class="selector-btn">Japanese</a></div>
                            </div>
                            <div class="lang-splitter">
                                <i class="material-icons">
                                    unfold_more
                                </i></div>
                            <div class="lang-jp">
                                <div class="jp-inner-btn lang-btn"><a class="selector-btn">Lao</a></div>
                            </div>
                        </div>
                        <div class="dictionary-lists lists-items-container">
                            <div class="main-items">
                                <div @click="getWord(item)" class="dictionary-item"
                                     v-for="(item, idx) in postsData.dictionaries.posts.data" :key="idx">
                                    <div :class="idx===0 ? 'splitter-top' : 'splitter-top-border'"></div>
                                    <div class="top-text">{{ item.japanese }}</div>
                                    <span></span>
                                    <div class="right-icon flex"><i class="material-icons flex">
                                        arrow_forward
                                    </i></div>
                                    <div class="bottom-text">
                                        {{ item.lao }}
                                    </div>
                                </div>
                                <div class="dictionary-item"
                                     v-if="postsData.dictionaries.posts.data && postsData.dictionaries.posts.data.length <= 0">
                                    <div class="splitter-top"></div>
                                    <div class="top-text">Not found</div>
                                    <span></span>
                                    <div class="right-icon flex"><i class="material-icons flex">
                                        info
                                    </i></div>
                                    <div class="bottom-text">
                                        Not found
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <nav class="pagination" role="navigation" aria-label="pagination">
                    <a :disabled="paginate.current_page===1" @click="prevPage(paginate.current_page - 1)"
                       class="pagination-previous">Previous</a>
                    <a :disabled="paginate.current_page===paginate.last_page"
                       @click="nextPage(paginate.current_page + 1)" class="pagination-next">Next page</a>
                </nav>


            </div>
        </section>
    </div>
</template>

<script>
    import Base from '@com/Bases/GeneralBase.js'

    export default Base.extend({
        name: "Dictionary",
        data: () => ({
            type: 'dictionaries',
        }),
        methods: {
            getWord(item) {
                this.Route({name: 'single-dictionary', params: {id: item.id}})
            },
            setQueryFilters() {
                this.query = this.searchQuery.text;
                this.filters = this.searchQuery.filters;
            }
        },
        created() {
            //check if need to set old query and filters
            if (this.$route.params.setQueryFilters) {
                this.setQueryFilters();
            }
            this.paginate.per_page = 12;
            this.registerWatches();
            this.setPageTitle('Latest Dictionaries');
            this.getItems('no-scroll');
        }
    });
</script>

<style scoped>
    .page-blog {
        min-height: 480px;
    }

    .dictionary-header {
        border-top: 1px solid rgba(0, 0, 0, 0.12);
        border-bottom: 1px solid rgba(0, 0, 0, 0.12);
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
        width: 50%;
        margin: 0;
        word-break: normal;
    }

    .lang-splitter {
        background-color: #fff;
        display: inline-block;
        margin: 0 -25px;
        vertical-align: top;
        width: 26px;
        height: 46px;
        line-height: 48px;
        position: relative;
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

    .dictionary-lists {
        -webkit-border-radius: 0;
        -moz-border-radius: 0;
        border-radius: 0;
        -webkit-box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        -moz-box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        -webkit-transition: opacity .218s;
        -moz-transition: opacity .218s;
        -o-transition: opacity .218s;
        transition: opacity .218s;
        background-color: #fff;
        box-sizing: border-box;
        cursor: default;
        white-space: nowrap;
        width: 100%;
        z-index: 1;
    }

    .lists-items-container {
        background-color: white;
        border-color: #ccc;
        display: block;
        position: relative;
        margin-bottom: 0;
        margin-top: -8px;
        border-style: solid;
        border-width: 0;
        -webkit-border-radius: 0 0 2px 2px;
        -moz-border-radius: 0 0 2px 2px;
        -ms-border-radius: 0 0 2px 2px;
        border-radius: 0 0 2px 2px;
    }

    .main-items {
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        margin: 0;
    }

    .dictionary-item {
        direction: inherit;
        position: relative;
        min-height: 56px;
    }

    .dictionary-item:hover {
        background-color: #eee;
        border-color: #eee;
        border-style: dotted;
        border-width: 0;
    }

    .splitter-top {
        height: 0;
        margin-bottom: 8px;
    }

    .splitter-top-border {
        border-top: 1px solid #e6e6e6;
        height: 0;
    }

    .right-icon {
        position: absolute;
        width: 48px;
        height: 100%;
        right: 0;
    }

    .right-icon i {
        margin: auto;
        width: 42px;
        font-size: 28px;
        opacity: .54;
    }

    .main-items .top-text, .main-items .bottom-text {
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .main-items .top-text {
        font-size: 16px;
        color: rgba(0, 0, 0, 0.87);
        margin: 0 !important;
        position: absolute;
        left: 15px;
        top: 8px;
        right: 48px;
    }

    .main-items .bottom-text {
        margin: 0 !important;
        position: absolute;
        bottom: 6px;
        left: 15px;
        right: 48px;
        font-size: 14px;
        color: rgba(0, 0, 0, 0.54);
        display: block;
        padding-top: 4px;
    }
    .pagination {
        margin: 0 0 10px 0;
    }

    @media screen and (min-width: 720px) {
        .dictionary-item {
            min-height: 64px;
        }

        .main-items .top-text {
            top: 10px;
        }

        .main-items .top-text {
            font-size: 16px;
            color: rgba(0, 0, 0, 0.87);
            margin: 0 !important;
            position: absolute;
            left: 15px;
            top: 8px;
            right: 48px;
        }

        .main-items .top-text, .main-items .bottom-text {
            left: 28px;
        }

        .main-items .bottom-text {
            bottom: 10px;
        }
    }

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
        }
    }

    @media screen and (min-width: 720px) and (max-width: 1087px) {
        .dictionary-container {
            padding-left: 1rem;
            padding-right: 1rem;
        }
    }

    @media screen and (max-width: 480px) {

        .right-icon i {
            font-size: 26px;
        }
    }

</style>
