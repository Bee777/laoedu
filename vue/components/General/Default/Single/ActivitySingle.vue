<template>
    <div>
        <!--POST CONTENT -->
        <section class="section">
            <div class="container">
                <div class="fire-spinner" v-if="shouldLoadingSingle(type)"></div>
                <div class="columns">
                    <div class="column is-8 is-offset-2">
                        <div class="blog-header">
                            <div class="blog-header-title">
                                <h1 v-if="shouldLoadingSingle(type)">
                                    <div class="loading-text"></div>
                                </h1>
                                <h1 v-else class="title single-blog-title">{{ singlePostsData.activities.data.title
                                    }}</h1>
                            </div>
                            <div class="authorScale author-fontSize17 author-marginVertical24 author-flexCenter">
                                <div class="author-flex0">
                                    <div class="author-avatar">
                                        <img v-if="shouldLoadingSingle(type)"
                                             :src="`${baseUrl}/assets/images/${s.website_logo}${s.fresh_version}`"
                                             class="avatar-image image-size50x50">
                                        <img v-else-if="singlePostsData.activities.data.author_image"
                                             :src="`${baseUrl}${singlePostsData.activities.data.author_image}`"
                                             class="avatar-image image-size50x50">
                                    </div>
                                </div>
                                <div class="author-flex1 author-paddingLeft15 author-overflowHidden">
                                    <div class="author-paddingBottom3">
                                        <div class="author-caption">{{singlePostsData.activities.data.author}}</div>
                                    </div>
                                    <div class="author-caption author-time-wrap">
                                        <time :datetime="singlePostsData.activities.data.updated_at">{{
                                            singlePostsData.activities.data.post_updated }}
                                        </time>
                                        <span class="middot-divider author-fontSize12"></span>
                                        <span class="agoTime"
                                              :title="singlePostsData.activities.data.post_updated_ago"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="spaced-flex"></div>
                        </div>
                        <div class="image single-post-image-container">
                            <div v-if="shouldLoadingSingle(type)" class="loading-image"></div>
                            <img v-if="singlePostsData.activities.data.image" class="single-post-image"
                                 :src="`${baseUrl}${singlePostsData.activities.data.image}`"
                                 :alt="singlePostsData.activities.data.image">
                        </div>

                        <!--Activity Date -->
                        <div class="author-flex1 author-overflowHidden author-paddingTop20">
                            <div class="author-caption author-fontBold">
                                <span class="icon-date"> <i class="material-icons">date_range</i></span>
                                <time :datetime="singlePostsData.activities.data.start_date">Activity Date  <span class="middot-divider author-fontSize12"></span> {{
                                    singlePostsData.activities.data.formatted_start_date }}
                                </time>
                                <span class="middot-divider author-fontSize12"></span>
                                <span class="agoTime"
                                      :title="singlePostsData.activities.data.formatted_start_date_ago"></span>
                            </div>
                        </div>
                        <!--Activity Date -->

                        <div class="blog-content author-marginTop20">
                            <div class="content" v-html="singlePostsData.activities.data.description"></div>
                        </div>
                        <div class="author-postActions author-paddingTop20" v-if="singlePostsData.activities.data.id">
                            <div class="author-flexCenter">
                                <div class="button-actions author-flex1">
                                    <a class="button button-dark author-fontBold">Sharing</a>
                                    <span class="middot-divider author-fontSize12 author-marginRight12"></span>
                                    <a target="_blank"
                                       :href="sharer('twitter', type, singlePostsData.activities.data, link)"
                                       class="button button-dark author-marginRight12">
                                        <i class="fab fa-twitter"></i>
                                    </a>
                                    <a target="_blank" :href="sharer('fb', type, singlePostsData.activities.data, link)"
                                       class="button button-dark author-marginRight12">
                                        <i class="fab fa-facebook"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="author-borderTopLightest author-marginTop20 author-paddingBottom20"></div>
                        <div class="author-postActions author-paddingBottom20">
                            <div class="author-flexCenter">
                                <div class="button-actions author-flex1">
                                    <h3 class="author-fontSize20 author-scale author-fontBold">
                                        Other Interested Posts</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--POST CONTENT -->
        <!--Other posts-->
        <div class="postsFooter">
            <div class="author-backgroundGrayLightest">
                <div
                    class="author-maxWidth1032 author-paddingBottom40 author-paddingTop30 author-marginAuto">
                    <div class="section">
                        <div class="columns is-multiline">
                            <div class="column is-4" v-for="(item, idx) in singlePostsData.activities.others"
                                 :key="idx">
                                <div class="card card-jaol">
                                    <div class="card-image" @click="getDetail('activity', item)">
                                        <figure class="image is-3by2">
                                            <img class="author-borderRadius4" :src="`${baseUrl}${item.image}`"
                                                 :alt="item.image">
                                        </figure>
                                    </div>
                                    <div class="card-content">
                                        <div class="media">
                                            <div class="media-left user-icon">
                                                <figure class="image is-32x32">
                                                    <img :src="`${baseUrl}${item.author_image}`" :alt="item.author">
                                                </figure>
                                            </div>
                                            <div class="media-content">
                                                <p class="s-title is-6 is-small">{{item.author}}</p>
                                            </div>
                                        </div>
                                        <a @click="getDetail('activity', item)"><p class="s-title is-12">
                                            {{item.title}}</p></a>
                                        <div class="content description">
                                            <div v-html="$utils.sub($utils.strip(item.description), 120)"></div>
                                            <br>
                                            <time class="updated-date" :datetime="item.updated_at">Updated -
                                                {{item.post_updated}}
                                            </time>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--Other posts-->
    </div>
</template>
<script>
    import Base from '@com/Bases/GeneralBase.js'

    export default Base.extend({
        data: () => ({
            type: 'activities',
            link: '',
        }),
        watch: {
            '$route.params': function (n, o) {
                this.$utils.scrollToY('html,body', 10);
                this.singleId = n.id;
                this.link = this.baseUrl + this.$route.fullPath;
                this.fetchSinglePostsData({type: this.type, id: this.singleId});
            }
        },
        methods: {
            setItem(data) {
                this.setPageTitle(data.data.title)
            }
        },
        created() {
            this.link = this.baseUrl + this.$route.fullPath;
            this.registerWatches();
            this.setPageTitle('Activity');
            this.singleId = this.$route.params.id;
            this.fetchSinglePostsData({type: this.type, id: this.singleId});
        }
    });
</script>
