<template>
    <div>
        <!-- Carousel section -->
        <carousel :items="homeData.banners"/>
        <!-- Hero Section -->
        <section class="hero is-about is-bold">
            <div class="hero-body">
                <div class="container">
                    <div>
                        <h1 class="title has-text-centered">Japan Alumni Of Laos</h1>
                        <h2 class="subtitle">
                            <p>ສະມາຄົມອະດີດນັກສຶກສາລາວ ຈາກປະເທດຍີ່ປຸ່ນ ແມ່ນເປັນສະມາຊິກລວມໝູ່ ຂອງສະມາຄົມມິດຕະພາບ
                                ລາວ-ຍີ່ປຸ່ນສູນກາງ ທີ່ມີກອງເລຂາປະຈຳຢູ່ພະແນກມິດຕະພາບ ກົມພົວພັນມະຫາຊົນ ຄະນະພົວພັນການ
                                ຕ່າງປະເທດສູນກາງພັກ. ໂດຍມີໃບແຈ້ງການ ເຫັນດີໃຫ້ຈັດຕັ້ງເປັນສະມາຊິກລວມໝູ່ ລົງວັນທີ່
                                11/05/2001 ...</p>
                        </h2>
                    </div>
                </div>
                <div class="learnmore flex has-text-centered">
                    <router-link :to="{name:'about'}"><span>Learn more about Japan Alumni Of Laos <i
                        class="material-icons">keyboard_arrow_right</i></span></router-link>
                </div>
            </div>
        </section>
        <!-- End Hero Section -->
        <div class="section-news">
            <!-- News section -->
            <section class="section">
                <div class="container">
                    <div class="title section-heading">
                        <div class="entry-title">Latest News</div>
                    </div>
                    <div class="columns is-multiple">
                        <div class="column is-4" v-for="(news, index) in homeData.latest_news" :key="index">
                            <div class="card card-jaol">
                                <div class="card-image image is-5by3" @click="getDetail('news', news)">
                                    <img :src="news.image" alt="Placeholder image">
                                </div>
                                <div class="card-content">
                                    <div class="scholarship">
                                        <a class="blog-title content-hide" @click="getDetail('news', news)">
                                            <p class="f-title">{{news.title}}</p>
                                        </a>
                                        <div class="media-left">
                                            <h4 class="month">{{news.formatted_updated_at}}</h4>
                                        </div>
                                    </div>
                                    <div class="sub-content">
                                        <p v-html="$utils.sub($utils.strip(news.description), 100)"></p>
                                    </div>
                                    <div class="view_more">
                                        <div
                                            class="button is-link is-rounded is-small"
                                            @click="getDetail('news', news)">Read more
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="view_more is-break">
                        <div class="button is-link is-rounded is-large" @click="getPosts('news')">View More News</div>
                    </div>
                </div>
            </section>
            <!-- End section News -->
            <!-- Scholarship Section -->
            <section class="section is-dark" v-if="homeData.latest_scholarship.length > 0">
                <div class="container">
                    <div class="columns is-multiple">
                        <div class="column is-8">
                            <div class="title section-heading">
                                <div class="entry-title">Latest Scholarship</div>
                            </div>
                            <div class="scholarship">
                                <div class="columns is-multiline"
                                     v-for="(scholarship,index) in homeData.latest_scholarship"
                                     :key="index">
                                    <div class="column is-4">
                                        <div class="card-image" @click="getDetail('scholarship', scholarship)">
                                            <figure class="image is-3by2">
                                                <img :src="scholarship.image" alt="Placeholder image">
                                            </figure>
                                        </div>
                                    </div>
                                    <div class="column is-8 scholarship">
                                        <a @click="getDetail('scholarship', scholarship)">
                                            <h1 class="s-title">{{scholarship.title}}</h1>
                                        </a>
                                        <div class="deadline">
                                            <p class="month">
                                                <strong>Deadline: </strong>
                                                {{scholarship.formatted_deadline}}
                                            </p>
                                            <p class="place-content">
                                                <i class="fas fa-map-marker-alt"></i><strong>{{scholarship.place}}</strong>
                                            </p>
                                        </div>
                                        <div class="sub-content"
                                             v-html="$utils.sub($utils.strip(scholarship.description), 100)"></div>
                                        <div class="readmore">
                                            <a @click="getDetail('scholarship', scholarship)" class="readmore">Read
                                                More</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Fueture Scholarship -->
                        <!-- .col -->
                        <div
                            class="column is-4"
                            v-if="!$utils.isEmptyObject(homeData.mostViewScholarship) && !$utils.isEmptyVar(homeData.mostViewScholarship)">
                            <div class="title section-heading">
                                <div class="entry-title">Most Viewed Scholarship</div>
                            </div>
                            <div class="card card-jaol">
                                <div class="card-image"
                                     @click="getDetail('scholarship', homeData.mostViewScholarship)">
                                    <figure class="image">
                                        <img class="author-borderRadius4"
                                             :src="`${baseUrl}${homeData.mostViewScholarship.image}`"
                                             alt="Scholarship image">
                                    </figure>
                                </div>
                                <div class="card-content">
                                    <div class="scholarship">
                                        <a class="blog-title"
                                           @click="getDetail('scholarship', homeData.mostViewScholarship)">
                                            <p class="f-title">{{homeData.mostViewScholarship.title}}</p>
                                        </a>
                                    </div>
                                    <div class="deadline">
                                        <p><strong>Deadline: </strong>
                                            {{homeData.mostViewScholarship.formatted_deadline}}
                                        </p>
                                    </div>
                                    <p class="place-content">
                                        <i class="fas fa-map-marker-alt"></i><strong>{{homeData.mostViewScholarship.place}}</strong>
                                    </p>
                                    <div class="sub-content"
                                         v-html="$utils.sub($utils.strip(homeData.mostViewScholarship.description), 100)"></div>
                                    <div class="readmore">
                                        <a @click="getDetail('scholarship', homeData.mostViewScholarship)"
                                           class="readmore">Read
                                            More</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="view_more is-break">
                        <div
                            class="button is-link is-rounded is-large"
                            @click="getPosts('scholarships')">View More Scholarships
                        </div>
                    </div>
                </div>
            </section>
            <!-- End Scholarship Section -->
            <!-- Event Section -->
            <section class="section" v-if="homeData.latest_event.length > 0">
                <div class="container">
                    <div class="title section-heading">
                        <div class="entry-title">Latest Events</div>
                    </div>
                    <div class="event columns is-multiline">
                        <div class="column is-3-desktop is-4-tablet is-12-mobile"
                             v-for="(event,index) in homeData.latest_event" :key="index">
                            <div class="card card-jaol card-fixed">
                                <div class="card-image image event-card-image">
                                    <img class="event-image" @click="getDetail('event', event)" :src="event.image"
                                         :alt="event.image">
                                    <div class="date">
                                        <span
                                            class="day">{{event.formatted_start_date}} - {{event.formatted_end_date}}</span>
                                        <br>
                                        <span>{{event.formatted_start_time}} - {{event.formatted_end_time}}</span>
                                    </div>
                                </div>
                                <div class="card-content">
                                    <a @click="getDetail('event', event)" class="medium-title">{{$utils.sub(event.title,
                                        75)}}</a>
                                    <p class="event-content"
                                       v-html="$utils.sub($utils.strip(event.description), 100)"></p>
                                    <p class="hosted-by">
                                        <strong>Hosted by - {{$utils.sub(event.hosted_by, 60)}}</strong>
                                    </p>
                                </div>
                                <footer class="card-footer">
                                    <div class="card-content">
                                        <p class="place-content">
                                            <i class="fas fa-map-marker-alt"></i>
                                            <strong>{{$utils.sub(event.place, 60)}}</strong>
                                        </p>
                                        <div class="view_more">
                                            <div class="button is-link is-rounded is-small"
                                                 @click="getDetail('event', event)">Read
                                                more
                                            </div>
                                        </div>
                                    </div>
                                </footer>
                            </div>
                        </div>
                    </div>
                    <span class="break"></span>
                </div>
            </section>
            <!-- End of Event Section -->
            <!-- Start Activity Section -->
            <section class="section ">
                <div class="container">
                    <div class="title section-heading">
                        <div class="entry-title">What We Did</div>
                    </div>
                    <div class="page-blog">
                        <div class="ho-event ho-event-mob-bot-sp">
                            <div class="columns is-multiple">
                                <div class="column is-6"
                                     v-for="(activityRow, r) in $utils.chunkArray(homeData.latest_activity)" :key="r">
                                    <div class="columns ismultiline">
                                        <div class="column is-12">
                                            <ul>
                                                <li v-for="(activity, index) in activityRow" :key="index">
                                                    <div class="ho-ev-img" @click="getDetail('activity', activity)">
                                                        <div class="image is-5by3">
                                                            <img :src="activity.image">
                                                        </div>
                                                    </div>
                                                    <div class="ho-ev-link">
                                                        <a @click="getDetail('activity', activity)">
                                                            <p class="s-title">{{activity.title}}</p>
                                                        </a>
                                                        <div class="sub-content">
                                                            <p v-html="$utils.sub($utils.strip(activity.description), 50)"></p>
                                                            <p>
                                                                <span>By {{activity.author}}</span>
                                                                <span>{{activity.formatted_updated_at}}</span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <sponsor/>
            <!-- End Activity Section -->
            <!-- Section Contact us  -->
            <section class="contact">
                <div class="container">
                    <div class="title section-heading">
                        <div class="entry-title">Contact us</div>
                    </div>
                    <div class="columns is-multiline">
                        <div class="column is-6-desktop is-12-mobile is-6-tablet">
                            <div class="map">
                                <iframe
                                    style="height: 568px;"
                                    src="https://maps.google.com/maps?width=100%&amp;height=600&amp;hl=en&amp;q=Laos%2C%20Dongdork+(My%20Business%20Name)&amp;ie=UTF8&amp;t=&amp;z=13&amp;iwloc=B&amp;output=embed"
                                >
                                    <a href="https://www.maps.ie/map-my-route/">Map a route</a>
                                </iframe>
                            </div>
                        </div>
                        <div class="column is-6-desktop is-12-mobile is-6-tablet">
                            <ContactForm/>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</template>

<style>
</style>
<script>
    import Carousel from "@com/General/Partial/Carousel.vue";
    import Sponsor from "@com/General/Default/Sponsor.vue";
    import ContactForm from '@com/General/ContactForm.vue'
    import Base from "@com/Bases/GeneralBase.js";
    import {mapActions} from 'vuex'

    export default Base.extend({
        name: "Home",
        data: () => ({
            contactInfo: {header_title: 'Contact Us Now'}//for contact form
        }),
        components: {
            Carousel,
            ContactForm,
            Sponsor
        },
        methods: {
            ...mapActions(['postSendContact']),
            sendContact() {
                let c = this.contactInfo;
                if (this.validated().loading_send_contact) {
                    c.header_title = 'Sending Information...';
                    return;
                }
                this.postSendContact(c)
                    .then(res => {
                        if (res.success) {
                            this.contactInfo = {header_title: 'Sent the information!'};
                            setTimeout(() => {
                                this.contactInfo = {header_title: 'Contact Us Now'}
                            }, 3500);
                        }
                    })
                    .catch(err => {
                        if (err && !err.errors) {
                            c.header_title = 'Failed to send the information!';
                        }
                    });
            }
        },
        created() {
            this.setPageTitle(`Home`);
        }
    });
</script>
<style lang="scss" scoped>
</style> 