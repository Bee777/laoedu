<template>
    <div>
        <div class="page-header">
            <section class="section">
                <div class="container">
                    <h2 class="header-title">Interested Events</h2>
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
                                <div class="column is-6" v-for="(event, idx) in postsData.events.posts.data" :key="idx">
                                    <div class="card fixed is-small">
                                        <div class="card-image image event-card-image"
                                             @click="getDetail('event', event)">
                                            <div class="date">
                                                <span class="icon-date is-event-date">
                                                <i class="material-icons">
                                                    event
                                                </i>
                                                </span>
                                                <span class="day">{{event.formatted_start_date}} - {{event.formatted_deadline}}</span>
                                                <br>
                                                <span>{{ event.during_time }}</span>
                                                <span class="day" v-if="event.isClosed">(Closed)</span>
                                                <br>
                                            </div>
                                            <img class="event-image" :src="`${baseUrl}${event.image}`"
                                                 :alt="event.image">
                                        </div>
                                        <div class="card-content">
                                            <a>
                                                <p class="s-title" @click="getDetail('event', event)">
                                                    {{event.title}}</p>
                                            </a>
                                            <div class="content"
                                                 v-html="$utils.sub($utils.strip(event.description), 180)">
                                            </div>
                                        </div>
                                        <footer class="card-footer event-footer">
                                            <div class="card-content">
                                                <p class="place">
                                                    <i class="fas fa-map-marker-alt"></i>
                                                    <strong
                                                        v-html="$utils.sub($utils.strip(event.place), 90)"></strong>
                                                </p>
                                                <p class="bottom-date">
                                                    <time class="updated-date" :datetime="event.updated_at">Updated -
                                                        {{event.post_updated}}
                                                    </time>
                                                </p>
                                            </div>
                                        </footer>
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
                        <!-- Sidebar -->
                        <div class="column is-4 is-multiline">
                            <div class="sidebar">
                                <!-- Upcoming event -->
                                <template v-if="postsData.events.comingEvents.length > 0">
                                    <div class="card-side-bar">
                                        <h1 class="title title-sidebar">Upcoming Events</h1>
                                        <hr>
                                        <div class="ho-event ho-event-mob-bot-sp">
                                            <ul>
                                                <li v-for="(event, idx) in postsData.events.comingEvents" :key="idx">
                                                    <div class="ho-ev-date"
                                                         v-html="getCalendarDate(event.start_date)"></div>
                                                    <div class="ho-ev-link large-width">
                                                        <a @click="getDetail('event', event)">
                                                            <h4>{{ event.title }}</h4>
                                                        </a>
                                                        <p v-html="$utils.sub($utils.strip(event.description), 100)"></p>
                                                        <p>
                                                            <span>{{ event.during_time }}</span>
                                                            <span> Location: {{ event.place }}</span>
                                                        </p>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </template>
                                <!-- Upcoming event -->
                                <!-- popular posts -->
                                <div class="card-side-bar" v-if="postsData.events.mostViews.length > 0">
                                    <h1 class="title title-sidebar">Most Viewed Events</h1>
                                    <hr class="small-bottom">
                                    <div class="ho-event ho-event-mob-bot-sp">
                                        <ul>
                                            <li v-for="(event, idx) in postsData.events.mostViews" :key="idx">
                                                <div @click="getDetail('event', event)" class="ho-ev-img ">
                                                    <img :src="`${baseUrl}${event.image}`" :alt="event.image">
                                                </div>
                                                <div class="ho-ev-link">
                                                    <a @click="getDetail('event', event)">
                                                        <h4>{{event.title}}</h4>
                                                    </a>
                                                    <p v-html="$utils.sub($utils.strip(event.description), 100)"></p>
                                                    <p>
                                                        <span>by {{event.author}}</span><span> {{event.post_updated}}</span>
                                                    </p>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- popular posts -->
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
            </div>
        </section>
    </div>
</template>
<style lang="css" scoped>
</style>
<script>
    import Base from '@com/Bases/GeneralBase.js'

    export default Base.extend({
        data: () => ({
            type: 'events',
        }),
        created() {
            this.registerWatches();
            this.setPageTitle('Events');
            this.getItems();
        }
    });
</script>
