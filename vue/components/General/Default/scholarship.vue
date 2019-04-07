<template>
    <div>
        <div class="page-header">
            <section class="section">
                <div class="container">
                    <h2 class="header-title">All Scholarships</h2>
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
                                <div class="column is-6" v-for="(scholarship, idx) in postsData.scholarships.posts.data"
                                     :key="idx">
                                    <div class="card fixed">
                                        <div @click="getDetail('scholarship', scholarship)"
                                             class="card-image image event-card-image">
                                            <img class="event-image" :src="`${baseUrl}${scholarship.image}`"
                                                 :alt="scholarship.image">
                                        </div>
                                        <div class="card-content">
                                            <a @click="getDetail('scholarship', scholarship)">
                                                <p class="s-title">{{scholarship.title}}</p>
                                            </a>
                                            <div class="content"
                                                 v-html="$utils.sub($utils.strip(scholarship.description), 180)"></div>
                                        </div>
                                        <footer class="card-footer scholarship-footer">
                                            <div class="card-content">
                                                <p>
                                                    <i class="fas fa-map-marker-alt"></i>
                                                    <strong class="f-title"
                                                            v-html="$utils.sub($utils.strip(scholarship.place), 100)"></strong>
                                                </p>
                                                <p class="date-deadline">
                                                    <i class="far fa-calendar-check"></i>
                                                    <span class="deadline-color">Deadline - {{ scholarship.formatted_deadline }}  {{ scholarship.isClosed ? '(Closed)': '' }}</span>
                                                </p>
                                                <p class="bottom-date">
                                                    <time class="updated-date" :datetime="scholarship.updated_at">
                                                        Updated - {{scholarship.post_updated}}
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
                                <!-- popular posts -->
                                <div class="card-side-bar" v-if="postsData.scholarships.mostViews.length > 0">
                                    <h1 class="title title-sidebar">Most Viewed Scholarships</h1>
                                    <hr class="small-bottom">
                                    <div class="ho-event ho-event-mob-bot-sp">
                                        <ul>
                                            <li v-for="(scholarship, idx) in postsData.scholarships.mostViews"
                                                :key="idx">
                                                <div @click="getDetail('scholarship', scholarship)" class="ho-ev-img ">
                                                    <img :src="`${baseUrl}${scholarship.image}`"
                                                         :alt="scholarship.image">
                                                </div>
                                                <div class="ho-ev-link">
                                                    <a @click="getDetail('scholarship', scholarship)">
                                                        <h4>{{scholarship.title}}</h4>
                                                    </a>
                                                    <p v-html="$utils.sub($utils.strip(scholarship.description), 100)"></p>
                                                    <p>
                                                        <span>by {{scholarship.author}}</span><span> {{scholarship.post_updated}}</span>
                                                    </p>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- popular posts -->
                                <!-- Upcoming event -->
                                <template v-if="postsData.scholarships.comingEvents.length > 0">
                                    <div class="card-side-bar">
                                        <h1 class="title title-sidebar">Upcoming Events</h1>
                                        <hr>
                                        <div class="ho-event ho-event-mob-bot-sp">
                                            <ul>
                                                <li v-for="(event, idx) in postsData.scholarships.comingEvents"
                                                    :key="idx">
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
<style lang="scss" scoped>
    .card-custom {
        box-shadow: rgba(0, 0, 0, 0.117647) 0px 1px 6px,
        rgba(0, 0, 0, 0.117647) 0px 1px 4px;
        transition: 0.6s all ease-in-out;

        &:hover {
            transform: scale(1.06);
        }
    }
</style>

<script>
    import Base from '@com/Bases/GeneralBase.js'

    export default Base.extend({
        data: () => ({
            type: 'scholarships',
        }),
        methods: {
            getCalendarEvent(date) {
                let d = this.$utils.getDateTime(date);
                return `<span class="day">${d.days}</span>
                        <span class="month">${d.months}</span>
                        <span class="year">${d.years}</span>`;
            }
        },
        created() {
            this.registerWatches();
            this.setPageTitle('Scholarships');
            this.getItems();
        }
    });
</script>
