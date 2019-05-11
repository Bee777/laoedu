<template>
  <div>
  <carousel :items="homeData.banners"/>
    <!--====== SLIDER PART ENDS ======-->

    <!--====== CATEGORY PART START ======-->

    <section id="category-part">
      <div class="container">
        <div class="category pt-20 pb-40">
          <div class="row">
            <div class="col-lg-4">
              <div class="category-text pt-40">
                <h2>ທ່ານກຳລັງຊອກຫາຫຼັກສູດການສຶກສາ</h2>
              </div>
            </div>
            <div
              class="col-lg-6 offset-lg-1 col-md-8 offset-md-2 col-sm-8 offset-sm-2 col-8 offset-2"
            >
              <div class="row category-slied mt-40">
                <div class="col-lg-4">
                  <a href="#">
                    <span class="singel-category text-center color-1">
                      <span class="icon">
                        <img
                          :src="`${baseUrl}${baseRes}/assets/images/all-icon/ctg-1.png`"
                          alt="Icon"
                        >
                      </span>
                      <span class="cont">
                        <span>ປະລິນຍາໂທ</span>
                      </span>
                    </span>
                    <!-- singel category -->
                  </a>
                </div>
                <div class="col-lg-4">
                  <a href="#">
                    <span class="singel-category text-center color-2">
                      <span class="icon">
                        <img
                          :src="`${baseUrl}${baseRes}/assets/images/all-icon/ctg-2.png`"
                          alt="Icon"
                        >
                      </span>
                      <span class="cont">
                        <span>ປະລິນຍາຕີ</span>
                      </span>
                    </span>
                    <!-- singel category -->
                  </a>
                </div>
                <div class="col-lg-4">
                  <a href="#">
                    <span class="singel-category text-center color-3">
                      <span class="icon">
                        <img
                          :src="`${baseUrl}${baseRes}/assets/images/all-icon/ctg-3.png`"
                          alt="Icon"
                        >
                      </span>
                      <span class="cont">
                        <span>ອະນຸປະລິນຍາ</span>
                      </span>
                    </span>
                    <!-- singel category -->
                  </a>
                </div>
                <div class="col-lg-4">
                  <a href="#">
                    <span class="singel-category text-center color-1">
                      <span class="icon">
                        <img
                          :src="`${baseUrl}${baseRes}/assets/images/all-icon/ctg-1.png`"
                          alt="Icon"
                        >
                      </span>
                      <span class="cont">
                        <span>ຊັ້ນກາງ</span>
                      </span>
                    </span>
                    <!-- singel category -->
                  </a>
                </div>
                <div class="col-lg-4">
                  <a href="#">
                    <span class="singel-category text-center color-2">
                      <span class="icon">
                        <img
                          :src="`${baseUrl}${baseRes}/assets/images/all-icon/ctg-2.png`"
                          alt="Icon"
                        >
                      </span>
                      <span class="cont">
                        <span>ວິຊາຊີບ</span>
                      </span>
                    </span>
                    <!-- singel category -->
                  </a>
                </div>
                <div class="col-lg-4">
                  <a href="#">
                    <span class="singel-category text-center color-3">
                      <span class="icon">
                        <img
                          :src="`${baseUrl}${baseRes}/assets/images/all-icon/ctg-3.png`"
                          alt="Icon"
                        >
                      </span>
                      <span class="cont">
                        <span>ສາຍສາມັນ</span>
                      </span>
                    </span>
                    <!-- singel category -->
                  </a>
                </div>
              </div>
              <!-- category slied -->
            </div>
          </div>
          <!-- row -->
        </div>
        <!-- category -->
      </div>
      <!-- container -->
    </section>

    <!--====== CATEGORY PART ENDS ======-->

    <!--====== ABOUT PART START ======-->

    <section id="about-part" class="pt-15">
      <div class="container">
        <div class="row">
          <div class="col-lg-5">
            <div class="section-title mt-50">
              <h2>ກ່ຽວກັບສູນ</h2>
              <h5>ຍິນດີຕ້ອນຮັບສູ່ ສປຄ</h5>
            </div>
            <!-- section title -->
            <div class="about-cont">
                 <div class="about-cont" v-if="!$utils.isEmptyVar(homeData.About)">
                <p v-html="$utils.sub($utils.strip(homeData.About.description),800)"></p>
            </div>
              <router-link :to="{name: 'news'}"  class="main-btn mt-55">Learn More</router-link>
            </div>
          </div>
          <!-- about cont -->
          <div class="col-lg-6 offset-lg-1" v-if="homeData.latest_scholarship.length > 0">
            <div class="about-event mt-50">
              <div class="event-title">
                <h3>ທຶນການສຶກສາ</h3>
              </div>
              <!-- event title -->
              <ul>
                <li v-for="(scholarship,index) in homeData.latest_scholarship"
                                     :key="index">
                  <div class="singel-event">
                    <span>
                      <i class="fa fa-calendar"></i> {{scholarship.formatted_updated_at}}
                    </span>
                    <a @click="getDetail('scholarship', scholarship)">
                      <h4 v-html="$utils.sub($utils.strip(scholarship.title), 100)"></h4>
                    </a>
                    <span>
                      <i class="fa fa-clock-o"></i><strong>Deadline: </strong>
                                                {{scholarship.formatted_deadline}}
                    </span>
                    <span>
                      <i class="fa fa-map-marker"></i> {{scholarship.place}}
                    </span>
                  </div>
                </li>
                               <li>
                  <div class="singel-event">
                 <router-link :to="{name:'scholarship'}"  class="main-btn mt-15">ອ່ານເພີ່ມ</router-link>
                  </div>
               </li>
              </ul>
                           </div>
            
            <!-- about event -->
          </div>
        </div>
        <!-- row -->
      </div>
      <!-- container -->
      <div class="about-bg">
        <img :src="`${baseUrl}${baseRes}/assets/images/about/bg-1.png`" alt="About">
      </div>
    </section>

    <!--====== ABOUT PART ENDS ======-->

    <!--====== APPLY PART START ======-->

    <section id="course-part" class="pt-65 pb-60 gray-bg">
      <div class="container">
        <div class="row">
          <div class="col-lg-6">
            <div class="section-title pb-45">
              <h3>ສະຖານການສຶກສາ</h3>
              <h5>The best institute</h5>
            </div>
            <!-- section title -->
          </div>
        </div>
        <!-- row -->
        <div class="row course-slied mt-30">
          <div class="col-lg-4">
            <div class="singel-course">
              <div class="thum">
                <div class="image">
                  <img :src="`${baseUrl}${baseRes}/assets/images/course/cu-1.jpg`" alt="Course">
                </div>
                <div class="price">
                  <span>Free</span>
                </div>
              </div>
              <div class="cont">
                <ul>
                  <li>
                    <i class="fa fa-star"></i>
                  </li>
                  <li>
                    <i class="fa fa-star"></i>
                  </li>
                  <li>
                    <i class="fa fa-star"></i>
                  </li>
                  <li>
                    <i class="fa fa-star"></i>
                  </li>
                  <li>
                    <i class="fa fa-star"></i>
                  </li>
                </ul>
                <span>(20 Reviws)</span>
                <a href="courses-singel.html">
                  <h4>Learn basis javascirpt from start for beginner</h4>
                </a>
                <div class="course-teacher">
                  <div class="thum">
                    <a href="#">
                      <img
                        :src="`${baseUrl}${baseRes}/assets/images/course/teacher/t-1.jpg`"
                        alt="teacher"
                      >
                    </a>
                  </div>
                  <div class="name">
                    <a href="#">
                      <h6>Mark anthem</h6>
                    </a>
                  </div>
                  <div class="admin">
                    <ul>
                      <li>
                        <a href="#">
                          <i class="fa fa-user"></i>
                          <span>31</span>
                        </a>
                      </li>
                      <li>
                        <a href="#">
                          <i class="fa fa-heart"></i>
                          <span>10</span>
                        </a>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
            <!-- singel course -->
          </div>
          <div class="col-lg-4">
            <div class="singel-course">
              <div class="thum">
                <div class="image">
                  <img :src="`${baseUrl}${baseRes}/assets/images/course/cu-2.jpg`" alt="Course">
                </div>
                <div class="price">
                  <span>Free</span>
                </div>
              </div>
              <div class="cont">
                <ul>
                  <li>
                    <i class="fa fa-star"></i>
                  </li>
                  <li>
                    <i class="fa fa-star"></i>
                  </li>
                  <li>
                    <i class="fa fa-star"></i>
                  </li>
                  <li>
                    <i class="fa fa-star"></i>
                  </li>
                  <li>
                    <i class="fa fa-star"></i>
                  </li>
                </ul>
                <span>(20 Reviws)</span>
                <a href="courses-singel.html">
                  <h4>Learn basis javascirpt from start for beginner</h4>
                </a>
                <div class="course-teacher">
                  <div class="thum">
                    <a href="#">
                      <img
                        :src="`${baseUrl}${baseRes}/assets/images/course/teacher/t-2.jpg`"
                        alt="teacher"
                      >
                    </a>
                  </div>
                  <div class="name">
                    <a href="#">
                      <h6>Mark anthem</h6>
                    </a>
                  </div>
                  <div class="admin">
                    <ul>
                      <li>
                        <a href="#">
                          <i class="fa fa-user"></i>
                          <span>31</span>
                        </a>
                      </li>
                      <li>
                        <a href="#">
                          <i class="fa fa-heart"></i>
                          <span>10</span>
                        </a>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
            <!-- singel course -->
          </div>
          <div class="col-lg-4">
            <div class="singel-course">
              <div class="thum">
                <div class="image">
                  <img :src="`${baseUrl}${baseRes}/assets/images/course/cu-3.jpg`" alt="Course">
                </div>
                <div class="price">
                  <span>Free</span>
                </div>
              </div>
              <div class="cont">
                <ul>
                  <li>
                    <i class="fa fa-star"></i>
                  </li>
                  <li>
                    <i class="fa fa-star"></i>
                  </li>
                  <li>
                    <i class="fa fa-star"></i>
                  </li>
                  <li>
                    <i class="fa fa-star"></i>
                  </li>
                  <li>
                    <i class="fa fa-star"></i>
                  </li>
                </ul>
                <span>(20 Reviws)</span>
                <a href="courses-singel.html">
                  <h4>Learn basis javascirpt from start for beginner</h4>
                </a>
                <div class="course-teacher">
                  <div class="thum">
                    <a href="#">
                      <img
                        :src="`${baseUrl}${baseRes}/assets/images/course/teacher/t-3.jpg`"
                        alt="teacher"
                      >
                    </a>
                  </div>
                  <div class="name">
                    <a href="#">
                      <h6>Mark anthem</h6>
                    </a>
                  </div>
                  <div class="admin">
                    <ul>
                      <li>
                        <a href="#">
                          <i class="fa fa-user"></i>
                          <span>31</span>
                        </a>
                      </li>
                      <li>
                        <a href="#">
                          <i class="fa fa-heart"></i>
                          <span>10</span>
                        </a>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
            <!-- singel course -->
          </div>
          <div class="col-lg-4">
            <div class="singel-course">
              <div class="thum">
                <div class="image">
                  <img :src="`${baseUrl}${baseRes}/assets/images/course/cu-4.jpg`" alt="Course">
                </div>
                <div class="price">
                  <span>Free</span>
                </div>
              </div>
              <div class="cont">
                <ul>
                  <li>
                    <i class="fa fa-star"></i>
                  </li>
                  <li>
                    <i class="fa fa-star"></i>
                  </li>
                  <li>
                    <i class="fa fa-star"></i>
                  </li>
                  <li>
                    <i class="fa fa-star"></i>
                  </li>
                  <li>
                    <i class="fa fa-star"></i>
                  </li>
                </ul>
                <span>(20 Reviws)</span>
                <a href="courses-singel.html">
                  <h4>Learn basis javascirpt from start for beginner</h4>
                </a>
                <div class="course-teacher">
                  <div class="thum">
                    <a href="#">
                      <img
                        :src="`${baseUrl}${baseRes}/assets/images/course/teacher/t-4.jpg`"
                        alt="teacher"
                      >
                    </a>
                  </div>
                  <div class="name">
                    <a href="#">
                      <h6>Mark anthem</h6>
                    </a>
                  </div>
                  <div class="admin">
                    <ul>
                      <li>
                        <a href="#">
                          <i class="fa fa-user"></i>
                          <span>31</span>
                        </a>
                      </li>
                      <li>
                        <a href="#">
                          <i class="fa fa-heart"></i>
                          <span>10</span>
                        </a>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
            <!-- singel course -->
          </div>
          <div class="col-lg-4">
            <div class="singel-course">
              <div class="thum">
                <div class="image">
                  <img :src="`${baseUrl}${baseRes}/assets/images/course/cu-5.jpg`" alt="Course">
                </div>
                <div class="price">
                  <span>Free</span>
                </div>
              </div>
              <div class="cont">
                <ul>
                  <li>
                    <i class="fa fa-star"></i>
                  </li>
                  <li>
                    <i class="fa fa-star"></i>
                  </li>
                  <li>
                    <i class="fa fa-star"></i>
                  </li>
                  <li>
                    <i class="fa fa-star"></i>
                  </li>
                  <li>
                    <i class="fa fa-star"></i>
                  </li>
                </ul>
                <span>(20 Reviws)</span>
                <a href="courses-singel.html">
                  <h4>Learn basis javascirpt from start for beginner</h4>
                </a>
                <div class="course-teacher">
                  <div class="thum">
                    <a href="#">
                      <img
                        :src="`${baseUrl}${baseRes}/assets/images/course/teacher/t-5.jpg`"
                        alt="teacher"
                      >
                    </a>
                  </div>
                  <div class="name">
                    <a href="#">
                      <h6>Mark anthem</h6>
                    </a>
                  </div>
                  <div class="admin">
                    <ul>
                      <li>
                        <a href="#">
                          <i class="fa fa-user"></i>
                          <span>31</span>
                        </a>
                      </li>
                      <li>
                        <a href="#">
                          <i class="fa fa-heart"></i>
                          <span>10</span>
                        </a>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
            <!-- singel course -->
          </div>
        </div>
        <!-- course slied -->
      </div>
      <!-- container -->
    </section>

    <!--====== NEWS PART START ======-->
    <section id="news-part" class="pt-50 pb-50" v-if="homeData.latest_news.length > 0">
      <div class="container">
        <div class="row align-items-end">
          <div class="col-lg-6 col-md-8 col-sm-7">
            <div class="section-title pb-30">
              <h3>ຂ່າວໃໝ່</h3>
              <h5>From the news</h5>
            </div>
            <!-- section title -->
          </div>
          <div class="col-lg-6 col-md-4 col-sm-5">
            <div class="products-btn text-right pb-60">
              <router-link :to="{name: 'news'}" class="main-btn">ຂ່າວທັງໝົດ</router-link>
            </div>
            <!-- products btn -->
          </div>
        </div>
        <!-- row -->
        <div class="row" v-if="homeData.latest_news.length > 0">
          <div class="col-lg-6">
            <div class="singel-news mt-30">
              <div class="news-thum pb-25" @click="getDetail('news', homeData.latest_news[0])">
                <img :src="homeData.latest_news[0].image" alt="News">
              </div>
              <div class="news-cont">
                <ul>
                  <li>
                      <i class="fa fa-calendar"></i> {{homeData.latest_news[0].formatted_updated_at}}
                  </li>
                  <li>
                      <span>By</span> {{homeData.latest_news[0].author}}
                  </li>
                </ul>
                <a @click="getDetail('news', homeData.latest_news[0])">
                  <h3 v-html="$utils.sub($utils.strip(homeData.latest_news[0].title), 55)"></h3>
                </a>
               <p v-html="$utils.sub($utils.strip(homeData.latest_news[0].description), 150)"></p>
                
              </div>
            </div>
            <!-- singel news -->
          </div>
          <div class="col-lg-6">
            <template  v-for="(news, idx) in homeData.latest_news">
            <div class="singel-news news-list singel-course" :key="idx" v-if="idx!==0">
              <div class="row">
                <div class="col-sm-4">
                  <div class="news-thum mt-30">
                    <div class="image img-card" @click="getDetail('news', news)">
                      <img :src="news.image" :alt="news.image">
                    </div>
                  </div>
                </div>
                <div class="col-sm-8">
                  <div class="news-cont mt-30">
                    <ul>
                      <li>
                        <i class="fa fa-calendar"></i> 
                        {{news.formatted_updated_at}}
                      </li>
                      <li>
                        <span>By</span>
                        {{news.author}}
                      </li>
                    </ul>
                    <a @click="getDetail('news', news)">
                      <h3 v-html="$utils.sub($utils.strip(news.title), 45)"></h3>
                    </a>
                    <p v-html="$utils.sub($utils.strip(news.description), 80)"></p>
                  </div>
                </div>
              </div>
              <!-- row -->
            </div>
            </template>
          </div>
        </div>
        <!-- row -->
      </div>
      <!-- container -->
    </section>

    <!--====== NEWS PART ENDS ======-->
      <!--====== ACTIVITY PART START ======-->
    <section id="publication-part" class="pt-45 pb-50 gray-bg" v-if="homeData.latest_activity.length > 0">
      <div class="container">
        <div class="row align-items-end">
          <div class="col-lg-6 col-md-8 col-sm-7">
            <div class="section-title pb-60">
              <h3>ກິດຈະກຳ</h3>
              <h5>ວຽກງານນອກຫຼັກສູດ</h5>
            </div>
            <!-- section title -->
          </div>
          <div class="col-lg-6 col-md-4 col-sm-5">
            <div class="products-btn text-right pb-60">
              <a href="#" class="main-btn">ກິດຈະກຳທັງໝົດ</a>
            </div>
            <!-- products btn -->
          </div>
        </div>
        <!-- row -->
        <div class="row justify-content-center">
          <div class="col-lg-3 col-md-6 col-sm-8"  v-for="(activity,index) in (homeData.latest_activity)" :key="index">
            <div class="singel-publication mt-30">
              <div class="image" @click="getDetail('activity', activity)">
                <img
                  :src="activity.image"
                  :alt="activity.image"
                >
              </div>
              <div class="cont"> 
                  <a @click="getDetail('activity', activity)">
                    <h6 v-html="$utils.sub($utils.strip(activity.title), 45)"></h6>
                  </a>
                 
              </div>
               <div>
                    <span>By {{activity.author}}</span>
                <span>{{activity.formatted_updated_at}}</span>
                  </div>
            </div>
            <!-- singel publication -->
          </div>
        </div>
        <!-- row -->
      </div>
      <!-- container -->
    </section>
  </div>
</template>
<script>
import Carousel from "@com/General/Partial/Carousel.vue";
import Sponsor from "@com/General/Default/Sponsor.vue";
import ContactForm from "@com/General/ContactForm.vue";
import Base from "@com/Bases/GeneralBase.js";
import { mapActions } from "vuex";

export default Base.extend({
  name: "Home",
  data: () => ({
    contactInfo: { header_title: "Contact Us Now" } //for contact form
  }),
  components: {
    Carousel,
    ContactForm,
    Sponsor
  },
  created() {
    this.setPageTitle(`Home`);
  }
});
</script>