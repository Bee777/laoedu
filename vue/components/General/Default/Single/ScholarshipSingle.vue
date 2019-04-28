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
                                <h1 v-else class="title single-blog-title">{{ singlePostsData.scholarships.data.title
                                    }} <span v-if="singlePostsData.scholarships.data.isClosed" class="deadline-color author-fontBold">(Closed)</span></h1>
                            </div>
                            <div class="authorScale author-fontSize17 author-marginVertical24 author-flexCenter">
                                <div class="author-flex0">
                                    <div class="author-avatar">
                                        <img v-if="shouldLoadingSingle(type)"
                                             :src="`${baseUrl}/assets/images/${s.website_logo}${s.fresh_version}`"
                                             class="avatar-image image-size50x50">
                                        <img v-else-if="singlePostsData.scholarships.data.author_image"
                                             :src="`${baseUrl}${singlePostsData.scholarships.data.author_image}`"
                                             class="avatar-image image-size50x50">
                                    </div>
                                </div>
                                <div class="author-flex1 author-paddingLeft15 author-overflowHidden">
                                    <div class="author-paddingBottom3">
                                        <div class="author-caption">{{singlePostsData.scholarships.data.author}}</div>
                                    </div>
                                    <div class="author-caption author-time-wrap">
                                        <time :datetime="singlePostsData.scholarships.data.updated_at">{{
                                            singlePostsData.scholarships.data.post_updated }}
                                        </time>
                                        <span class="middot-divider author-fontSize12"></span>
                                        <span class="agoTime"
                                              :title="singlePostsData.scholarships.data.post_updated_ago"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="spaced-flex"></div>
                        </div>
                        <div class="image single-post-image-container">
                            <div v-if="shouldLoadingSingle(type)" class="loading-image"></div>
                            <img v-if="singlePostsData.scholarships.data.image" class="single-post-image"
                                 :src="`${baseUrl}${singlePostsData.scholarships.data.image}`"
                                 :alt="singlePostsData.scholarships.data.image">
                        </div>

                        <!--Scholarship Date, Place Hosted By-->
                        <div v-if="singlePostsData.scholarships.data.formatted_deadline"
                             class="author-flex1 author-overflowHidden author-paddingTop20 author-flexInline author-flex-center-vertical">
                            <div class="date-icon-container">
                                <i class="material-icons">
                                    schedule
                                </i>
                            </div>
                            <div class="date-icon-container">
                                <div class="author-paddingBottom3">
                                    <span class=" author-fontBold">Deadline</span>
                                    <span class="middot-divider author-fontBold author-fontSize12"></span>
                                    <span class="deadline-color author-fontBold"> {{singlePostsData.scholarships.data.formatted_deadline}}</span>
                                </div>
                                <div>
                                    <span>{{ singlePostsData.scholarships.data.place }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="author-borderTopLightest author-marginTop20"></div>
                        <!--Scholarship Date, Place -->

                        <div class="blog-content author-marginTop20">
                            <div class="content" v-html="singlePostsData.scholarships.data.description"></div>
                        </div>
                        <div class="author-postActions author-paddingTop20" v-if="singlePostsData.scholarships.data.id">
                            <div class="author-flexCenter">
                                <div class="button-actions author-flex1">
                                    <a class="button button-dark author-fontBold">Sharing</a>
                                    <span class="middot-divider author-fontSize12 author-marginRight12"></span>
                                    <a target="_blank"
                                       :href="sharer('twitter', type, singlePostsData.scholarships.data, link)"
                                       class="button button-dark author-marginRight12">
                                        <i class="fab fa-twitter"></i>
                                    </a>
                                    <a target="_blank"
                                       :href="sharer('fb', type, singlePostsData.scholarships.data, link)"
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


                            <div class="column is-4" v-for="(item, idx) in singlePostsData.scholarships.others"
                                 :key="idx">
                                <div class="card fixed">
                                    <div @click="getDetail('scholarship', item)" class="card-image image event-card-image">
                                        <img class="event-image" :src="`${baseUrl}${item.image}`"
                                             :alt="item.image">
                                    </div>
                                    <div class="card-content">
                                        <a @click="getDetail('scholarship', item)">
                                            <p class="s-title">{{item.title}}</p>
                                        </a>
                                        <div class="content"
                                             v-html="$utils.sub($utils.strip(item.description), 180)"></div>
                                    </div>
                                    <footer class="card-footer scholarship-footer">
                                        <div class="card-content">
                                            <p>
                                                <i class="fas fa-map-marker-alt"></i>
                                                <strong class="f-title"
                                                        v-html="$utils.sub($utils.strip(item.place), 100)"></strong>
                                            </p>
                                            <p class="date-deadline">
                                                <i class="far fa-calendar-check"></i>
                                                <span style="color:red;">Deadline - {{ item.formatted_deadline }} {{ item.isClosed ? '(Closed)': '' }}</span>
                                            </p>
                                            <p class="bottom-date">
                                                <time class="updated-date" :datetime="item.updated_at">Updated - {{item.post_updated}}</time>
                                            </p>
                                        </div>
                                    </footer>
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
            type: 'scholarships',
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
            this.setPageTitle('Scholarship');
            this.singleId = this.$route.params.id;
            this.fetchSinglePostsData({type: this.type, id: this.singleId});
        }
    });
</script>
