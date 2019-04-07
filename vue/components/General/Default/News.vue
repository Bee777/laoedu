<template>
    <div>
        <div class="page-header">
            <section class="section">
                <div class="container">
                    <h2 class="header-title">All News</h2>
                    <PostsSearchForm v-model="query" @onSearchEnter="getItems('click')"/>
                </div>
            </section>
        </div>
        <section class="section">
            <div class="container">
                <div class="page-blog fire-spinner-covered">
                    <div class="fire-spinner" v-if="shouldLoading(type)"></div>
                    <div class="columns is-multiline">
                        <div class="column is-8">
                            <div class="columns is-multiline">
                                <div class="column is-6" v-for="(news, idx) in postsData.news.posts.data" :key="idx">
                                    <div class="card card-jaol">
                                        <div class="card-image" @click="getDetail('news', news)">
                                            <figure class="image is-5by3">
                                                <img :src="`${baseUrl}${news.image}`" :alt="news.image">
                                            </figure>
                                        </div>
                                        <div class="card-content">
                                            <div class="media">
                                                <div class="media-left user-icon">
                                                    <figure class="image is-32x32">
                                                        <img :src="`${baseUrl}${news.author_image}`" :alt="news.author">
                                                    </figure>
                                                </div>
                                                <div class="media-content">
                                                    <p class="s-title is-6 is-small">{{news.author}}</p>
                                                </div>
                                            </div>
                                            <a @click="getDetail('news', news)"><p class="s-title is-12">
                                                {{news.title}}</p></a>
                                            <div class="content description">
                                                <div v-html="$utils.sub($utils.strip(news.description), 180)"></div>
                                                <br>
                                                <time class="updated-date" :datetime="news.updated_at">Updated - {{news.post_updated}}</time>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="column is-8" v-if="isNotFound()">
                                    <div class="devsite-article">
                                        <h1 class="devsite-page-title">
                                            Search results for <span class="devsite-search-term"><span
                                            class="devsite-search-term">{{ query }}</span></span>
                                        </h1>
                                    </div>
                                    <div class="result-snippet">No Results</div>
                                </div>
                            </div>
                        </div>
                        <!-- Side Bar -->
                        <div class="column is-4 is-multiline">
                            <div class="sidebar">
                                <!-- popular posts -->
                                <h1 class="title title-sidebar">Popular News</h1>
                                <hr>
                                <div class="ho-event ho-event-mob-bot-sp">
                                    <ul>
                                        <li v-for="(news, idx) in postsData.news.mostViews" :key="idx">
                                            <div @click="getDetail('news', news)" class="ho-ev-img ">
                                                <img :src="`${baseUrl}${news.image}`" :alt="news.image">
                                            </div>
                                            <div class="ho-ev-link">
                                                <a @click="getDetail('news', news)">
                                                    <h4>{{news.title}}</h4>
                                                </a>
                                                <p v-html="$utils.sub($utils.strip(news.description), 100)"></p>
                                                <p><span>by {{news.author}}</span><span> {{news.post_updated}}</span>
                                                </p>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <!-- popular posts -->
                                <!-- Upcoming events -->
                                <template v-if="postsData.news.comingEvents.length > 0">
                                    <h1 class="title title-sidebar">
                                        Upcoming Events</h1>
                                    <hr>
                                    <div class="ho-event ho-event-mob-bot-sp">
                                        <ul>
                                            <li v-for="(event, idx) in postsData.news.comingEvents" :key="idx">
                                                <div class="ho-ev-date"
                                                     v-html="getCalendarDate(event.start_date)"></div>
                                                <div class="ho-ev-link large-width">
                                                    <a @click="getDetail('event', event)">
                                                        <h4>{{ event.title }}</h4>
                                                    </a>
                                                    <p v-html="$utils.sub($utils.strip(event.description), 100)"></p>
                                                    <p><span>{{ event.during_time }}</span><span> Location: {{ event.place }}</span>
                                                    </p>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </template>
                                <!-- Upcoming events -->
                            </div>
                        </div>
                        <!-- End Sidebar -->
                    </div>
                    <nav class="pagination" role="navigation" aria-label="pagination">
                        <a :disabled="paginate.current_page===1" @click="prevPage(paginate.current_page - 1)"
                           class="pagination-previous">Previous</a>
                        <a :disabled="paginate.current_page===paginate.last_page"
                           @click="nextPage(paginate.current_page + 1)" class="pagination-next">Next page</a>
                    </nav>
                </div>
            </div>
        </section>
    </div>
</template>
<script>
    import Base from '@com/Bases/GeneralBase.js'

    export default Base.extend({
        data: () => ({
            type: 'news',
        }),
        created() {
            this.registerWatches();
            this.setPageTitle('News');
            this.getItems();
        }
    });
</script>
