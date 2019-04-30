
<template>
    <div>
                <!-- <carousel :per-page="1"
                  :mouse-drag="true"
                  :autoplay="true"
                  :autoplayHoverPause="false"
                  :autoplayTimeout="3000"
                  :paginationEnabled="false"
                  :loop="true">
            <slide v-for="(slide, index) in items" :key="index" @slideclick="openLink(slide.link)">
                <div
                    class="slider_bck"
                    :style="`background:url(${path}/${slide.image});cursor: ${hasLink(slide.link) ? 'pointer;' : ''}`">
                </div>
            </slide>
        </carousel> -->
 <section id="slider-part" class="slider-active" v-for="(slide, index) in items" :key="index" @slideclick="openLink(slide.link)">
      <div
        class="single-slider bg_cover pt-150 slider_bck"
        :style="`background:url(${path}/${slide.image});cursor: ${hasLink(slide.link) ? 'pointer;' : ''}`"
        data-overlay="4"
        style="height:400px;"
      >
        <div class="container">
          <div class="row">
            <div class="col-xl-7 col-lg-9">
              <div class="slider-cont">
                <h1
                  data-animation="bounceInLeft"
                  data-delay="1s"
                >{{slide.name}}</h1>
                <p
                  data-animation="fadeInUp"
                  data-delay="1.3s"
                >{{slide.description}}</p>
                <ul>
                  <li>
                    <a
                      data-animation="fadeInUp"
                      data-delay="1.6s"
                      class="main-btn"
                      href="#"
                    >Read More</a>
                  </li>
                  <li>
                    <a
                      data-animation="fadeInUp"
                      data-delay="1.9s"
                      class="main-btn main-btn-2"
                      href="#"
                    >Get Started</a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    </div>
</template>

<script>
    // import {Carousel, Slide} from 'vue-carousel';

    export default {
        props: ['items'],
        data() {
            return {
                path: `${this.baseUrl}${this.baseRes}/assets/images/banners/`,
            }
        },
        components: {
            // Carousel,
            // Slide
        },
        methods: {
            hasLink(d) {
                return (!this.$utils.isEmptyVar(d));
            },
            openLink(link) {
                if (this.hasLink(link)) {
                    window.open(link, '_blank');
                }
            }
        }
    }
</script>

<style>
    .slider_bck {
        height: 500px;
        background-size: cover !important;
        background-repeat: no-repeat !important;
    }

    @media only screen and (max-width: 1023px) and (min-width: 920px) {
        .slider_bck {
            height: 320px;
        }
    }

    @media only screen and (max-width: 919px) {
        .slider_bck {
            height: 240px;
        }
    }

</style>
