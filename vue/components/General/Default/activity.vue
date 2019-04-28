<template>
  <div>
    <div class="page-header">
      <div class="container">
        <h2 class="header-title">What We did</h2>
        <PostsSearchForm v-model="query" @onSearchEnter="getItems('click')"/>
      </div>
    </div>
    <section class="section">
      <div class="container">
        <div class="page-blog fire-spinner-covered">
          <div class="fire-spinner" v-if="shouldLoading(type)"></div>
          <div class="columns is-multiline">
            <div class="column is-8">
              <div class="columns is-multiline">
                <div
                  class="column is-6"
                  v-for="(activity, idx) in postsData.activities.posts.data"
                  :key="idx"
                >
                  <div class="card card-jaol">
                    <div class="card-image" @click="getDetail('activity', activity)">
                      <figure class="image is-4by3">
                        <img :src="`${baseUrl}${activity.image}`" :alt="activity.image">
                      </figure>
                    </div>
                    <div class="card-content">
                      <div class="media">
                        <div class="media-left user-icon">
                          <figure class="image is-32x32">
                            <img :src="`${baseUrl}${activity.author_image}`" :alt="activity.author">
                          </figure>
                        </div>
                        <div class="media-content">
                          <p class="s-title is-6 is-small">{{activity.author}}</p>
                        </div>
                      </div>
                      <a @click="getDetail('activity', activity)">
                        <p class="s-title is-12">{{activity.title}}</p>
                      </a>
                      <div class="content description">
                        <div v-html="$utils.sub($utils.strip(activity.description), 180)"></div>
                        <br>
                        <time class="updated-date" :datetime="activity.updated_at">
                          Updated -
                          {{activity.formatted_start_date}}
                        </time>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="column is-8" v-if="isNotFound()">
                  <div class="devsite-article">
                    <h1 class="devsite-page-title">
                      Search results for
                      <span class="devsite-search-term">
                        <span class="devsite-search-term">{{ query }}</span>
                      </span>
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
                <h1 class="title title-sidebar">Most Viewed Activities</h1>
                <hr>
                <div class="ho-event ho-event-mob-bot-sp">
                  <ul>
                    <li v-for="(activity, idx) in postsData.activities.mostViews" :key="idx">
                      <div @click="getDetail('activity', activity)" class="ho-ev-img">
                        <img :src="`${baseUrl}${activity.image}`" :alt="activity.image">
                      </div>
                      <div class="ho-ev-link">
                        <a @click="getDetail('activity', activity)">
                          <h4>{{activity.title}}</h4>
                        </a>
                        <p v-html="$utils.sub($utils.strip(activity.description), 100)"></p>
                        <p>
                          <span>by {{activity.author}}</span>
                          <span>{{activity.post_updated}}</span>
                        </p>
                      </div>
                    </li>
                  </ul>
                </div>
                <!-- popular posts -->
                <!-- Upcoming events -->
                <template v-if="postsData.news.comingEvents.length > 0">
                  <h1 class="title title-sidebar">Upcoming Events</h1>
                  <hr>
                  <div class="ho-event ho-event-mob-bot-sp">
                    <ul>
                      <li v-for="(event, idx) in postsData.activities.comingEvents" :key="idx">
                        <div class="ho-ev-date" v-html="getCalendarDate(event.start_date)"></div>
                        <div class="ho-ev-link large-width">
                          <a @click="getDetail('event', event)">
                            <h4>{{ event.title }}</h4>
                          </a>
                          <p v-html="$utils.sub($utils.strip(event.description), 100)"></p>
                          <p>
                            <span>{{ event.during_time }}</span>
                            <span>Location: {{ event.place }}</span>
                          </p>
                        </div>
                      </li>
                    </ul>
                  </div>
                </template>
                <!-- Upcoming events -->
              </div>
            </div>
          </div>
          <nav class="pagination" role="navigation" aria-label="pagination">
            <a
              :disabled="paginate.current_page===1"
              @click="prevPage(paginate.current_page - 1)"
              class="pagination-previous"
            >Previous</a>
            <a
              :disabled="paginate.current_page===paginate.last_page"
              @click="nextPage(paginate.current_page + 1)"
              class="pagination-next"
            >Next page</a>
          </nav>
        </div>
      </div>
    </section>
  </div>
</template>
<script>
import Base from "@com/Bases/GeneralBase.js";

export default Base.extend({
  data: () => ({
    type: "activities"
  }),
  created() {
    this.registerWatches();
    this.setPageTitle("Activities");
    this.getItems();
  }
});
</script>
<style scoped>
.search-box.search {
  position: relative;
  display: block;
  background: none;
}
.search input:focus {
  outline: none;
  box-shadow: 0 1rem 2rem rgba(0, 0, 0, 0.1);
  border: 1px solid #ffc600;
}
</style>

