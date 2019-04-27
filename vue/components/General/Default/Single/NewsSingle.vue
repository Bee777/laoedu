<template>
  <div>
    <!--POST CONTENT -->
    <section id="blog-singel" class="pt-20 pb-20 gray-bg">
      <div class="container">
        <div class="fire-spinner" v-if="shouldLoadingSingle(type)"></div>
        <div class="row">
          <div class="col-lg-10 mx-auto">
            <div class="blog-details">
              <div class="thum">
                <div v-if="shouldLoadingSingle(type)" class="loading-image"></div>
                <img
                  v-if="singlePostsData.news.data.image"
                  class="single-post-image"
                  :src="`${baseUrl}${singlePostsData.news.data.image}`"
                  :alt="singlePostsData.news.data.image"
                >
              </div>
              <div class="cont">
                <div class="blog-header-title">
                  <h1 v-if="shouldLoadingSingle(type)">
                    <div class="loading-text"></div>
                  </h1>
                  <h4 v-else class="title single-blog-title">{{ singlePostsData.news.data.title }}</h4>
                </div>
                <ul>
                  <li>
                    <i class="fa fa-calendar"></i>
                    <time :datetime="singlePostsData.news.data.updated_at">
                      {{
                      singlePostsData.news.data.post_updated }}
                    </time>
                    <span class="agoTime" :title="singlePostsData.news.data.post_updated_ago"></span>
                  </li>
                  <li>
                    <img
                      v-if="shouldLoadingSingle(type)"
                      :src="`${baseUrl}/assets/images/${s.website_logo}${s.fresh_version}`"
                      class="avatar-image image-size50x50"
                    >
                    <img
                      v-else-if="singlePostsData.news.data.author_image"
                      :src="`${baseUrl}${singlePostsData.news.data.author_image}`"
                      class="avatar-image image-size50x50"
                    >
                    <div class="author-caption">{{singlePostsData.news.data.author}}</div>
                  </li>
                </ul>
                <div class="blog-content">
                  <p class="content" v-html="singlePostsData.news.data.description"></p>
                </div>
                <div v-if="singlePostsData.news.data.id">
                  <ul class="share">
                    <li class="title">Share :</li>
                    <li>
                      <a
                        target="_blank"
                        :href="sharer('fb', type, singlePostsData.news.data, link)"
                      >
                        <i class="fab fa-facebook-f"></i>
                      </a>
                    </li>
                    <li>
                      <a
                        target="_blank"
                        :href="sharer('twitter', type, singlePostsData.news.data, link)"
                      >
                        <i class="fab fa-twitter"></i>
                      </a>
                    </li>
                  </ul>
                  
                </div>
                <br>
              <h4 class="text-center">ຂ່າວອື່ນໆທີ່ນ່າສົນໃຈ</h4>
                                             </div>
              <!-- cont -->
            </div>
            <!-- blog details -->
          </div>
        </div>
        <!-- Sigle blog footer -->
        <div class="row course-slied mt-30">
          <div class="col-lg-4 pb-10" v-for="(item, idx) in singlePostsData.news.others" :key="idx">
            <div class="singel-course card">
              <div class="thum">
                <div class="image img-card" @click="getDetail('news', item)">
                  <img :src="`${baseUrl}${item.image}`"
                                                 :alt="item.image">
                </div>
              </div>
              <div class="cont">
                <a @click="getDetail('news', item)">
                  <h6 class="card-title">{{item.title}}</h6>
                </a>
                <div v-html="$utils.sub($utils.strip(item.description), 120)"></div>
                <div class="course-teacher">
                  <div class="thum">
                     <img
                      :src="`${baseUrl}${singlePostsData.news.data.author_image}`"
                        >
                  </div>
                  <div class="name">
                    <div class="author-caption">{{singlePostsData.news.data.author}}</div>
                  </div>
                  <div class="admin">
                     
                         <time class="updated-date" :datetime="item.updated_at"><i class="fa fa-calendar"></i> {{item.post_updated}}</time>
                      
                  </div>
                </div>
              </div>
            </div>
            <!-- singel course -->
          </div>
        </div>
          <!-- <div class="card">
                            <a class="img-card" href="http://www.fostrap.com/2016/03/bootstrap-3-carousel-fade-effect.html">
                            <img src="https://1.bp.blogspot.com/-Bii3S69BdjQ/VtdOpIi4aoI/AAAAAAAABlk/F0z23Yr59f0/s640/cover.jpg" />
                          </a>
                            <div class="card-content">
                                <h4 class="card-title">
                                    <a href="http://www.fostrap.com/2016/03/bootstrap-3-carousel-fade-effect.html"> Bootstrap 3 Carousel FadeIn Out Effect
                                  </a>
                                </h4>
                                <p class="">
                                    Tutorial to make a carousel bootstrap by adding more wonderful effect fadein ...
                                </p>
                            </div>
                            <div class="card-read-more">
                                <a href="http://www.fostrap.com/2016/03/bootstrap-3-carousel-fade-effect.html" class="btn btn-link btn-block">
                                    Read More
                                </a>
                            </div>
                        </div>
                    </div>-->
        </div>
</section>
  </div>
</template>
<script>
import Base from "@com/Bases/GeneralBase.js";

export default Base.extend({
  data: () => ({
    type: "news",
    link: ""
  }),
  watch: {
    "$route.params": function(n, o) {
      this.$utils.scrollToY("html,body", 10);
      this.singleId = n.id;
      this.link = this.baseUrl + this.$route.fullPath;
      this.fetchSinglePostsData({ type: this.type, id: this.singleId });
    }
  },
  methods: {
    setItem(data) {
      this.setPageTitle(data.data.title);
    }
  },
  created() {
    this.link = this.baseUrl + this.$route.fullPath;
    this.registerWatches();
    this.setPageTitle("News");
    this.singleId = this.$route.params.id;
    this.fetchSinglePostsData({ type: this.type, id: this.singleId });
  }
});
</script>
<style scoped>

.blog-content p.content{
  margin-top: 8px;
  --x-height-multiplier: 0.375;
  --baseline-multiplier: 0.17;
  letter-spacing: 0.01rem;
  font-weight: 400;
  font-style: normal;
  font-size: 19px;
  line-height: 1.58;
  letter-spacing: -0.003em;
  overflow-wrap: break-word;
  word-wrap: break-word;
  -ms-word-break: break-all;
  word-break: break-all;
  word-break: break-word;
  -ms-hyphens: auto;
  -moz-hyphens: auto;
  -webkit-hyphens: auto;
  hyphens: auto;
}
img.single-post-image{
        top: 0;
    left: 0;
    width: 100%;
    height: 100%;
}

/* card-image */

.card {
  display: block; 
    margin-bottom: 20px;
    line-height: 1.42857143;
    background-color: #fff;
    border-radius: 2px;
    box-shadow: 0 2px 5px 0 rgba(0,0,0,0.16),0 2px 10px 0 rgba(0,0,0,0.12); 
    transition: box-shadow .25s; 
}

.img-card {
  width: 100%;
  height:auto;
  max-height: 1024px;
  border-top-left-radius:2px;
  border-top-right-radius:2px;
  display:block;
    overflow: hidden;
}
.img-card img{
  width: 100%;
  height:auto;
  max-height: 230px;
  object-fit:cover; 
  transition: all .25s ease;
} 
.card-title {
  margin-top: 0px;
    font-weight: 600;
    font-size: 1.4rem;
}
.card-title a {
  color: #000;
  text-decoration: none !important;
}


</style>

