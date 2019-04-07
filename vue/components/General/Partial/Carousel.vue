<template>
    <div>
        <carousel :per-page="1"
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
        </carousel>
    </div>
</template>

<script>
    import {Carousel, Slide} from 'vue-carousel';

    export default {
        props: ['items'],
        data() {
            return {
                path: `${this.baseUrl}/assets/images/banners/`,
            }
        },
        components: {
            Carousel,
            Slide
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
