<template>
    <div>


    <!--====== PAGE BANNER PART START ======-->
    
    <section id="page-banner" class="pt-105 pb-130 bg_cover" data-overlay="8" style="background-image: url(images/page-banner-4.jpg)">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="page-banner-cont">
                        <h2>Blog</h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Blog</li>
                            </ol>
                        </nav>
                    </div>  <!-- page banner cont -->
                </div>
            </div> <!-- row -->
        </div> <!-- container -->
    </section>
    
    <!--====== PAGE BANNER PART ENDS ======-->
   
    <!--====== BLOG PART START ======-->
    
    <section id="blog-page" class="pt-90 pb-120 gray-bg">
        <div class="container">
           <div class="row">
               <div class="col-lg-8">
                   <div class="singel-blog mt-30">
                       <div class="blog-thum">
                           <img :src="`${baseUrl}/images/blog/b-1.jpg`" alt="Blog">
                       </div>
                       <div class="blog-cont">
                           <a href="blog-singel.html"><h3>Few tips for get better results in examination</h3></a>
                           <ul>
                               <li><a href="#"><i class="fa fa-calendar"></i>25 Dec 2018</a></li>
                               <li><a href="#"><i class="fa fa-user"></i>Mark anthem</a></li>
                               <li><a href="#"><i class="fa fa-tags"></i>Education</a></li>
                           </ul>
                           <p>Lorem ipsum gravida nibh vel velit auctor aliquetn sollicitudirem quibibendum auci elit cons equat ipsutis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet mauris. Morbi accumsan ipsum velit. Nam nec tellus .</p>
                       </div>
                   </div> <!-- singel blog -->
                   <div class="singel-blog mt-30">
                       <div class="blog-thum">
                           <img :src="`${baseUrl}/images/blog/b-2.jpg`" alt="Blog">
                       </div>
                       <div class="blog-cont">
                           <a href="blog-singel.html"><h3>Few tips for get better results in examination</h3></a>
                           <ul>
                               <li><a href="#"><i class="fa fa-calendar"></i>25 Dec 2018</a></li>
                               <li><a href="#"><i class="fa fa-user"></i>Mark anthem</a></li>
                               <li><a href="#"><i class="fa fa-tags"></i>Education</a></li>
                           </ul>
                           <p>Lorem ipsum gravida nibh vel velit auctor aliquetn sollicitudirem quibibendum auci elit cons equat ipsutis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet mauris. Morbi accumsan ipsum velit. Nam nec tellus .</p>
                       </div>
                   </div> <!-- singel blog -->
                   <nav class="courses-pagination mt-50">
                        <ul class="pagination justify-content-lg-end justify-content-center">
                            <li class="page-item">
                                <a href="#" aria-label="Previous">
                                    <i class="fa fa-angle-left"></i>
                                </a>
                            </li>
                            <li class="page-item"><a class="active" href="#">1</a></li>
                            <li class="page-item"><a href="#">2</a></li>
                            <li class="page-item"><a href="#">3</a></li>
                            <li class="page-item">
                                <a href="#" aria-label="Next">
                                    <i class="fa fa-angle-right"></i>
                                </a>
                            </li>
                        </ul>
                    </nav>  <!-- courses pagination -->
               </div>
               <div class="col-lg-4">
                   <div class="saidbar">
                       <div class="row">
                           <div class="col-lg-12 col-md-6">
                               <div class="saidbar-search mt-30">
                                   <form action="#">
                                       <input type="text" placeholder="Search">
                                       <button type="button"><i class="fa fa-search"></i></button>
                                   </form>
                               </div> <!-- saidbar search -->
                               <div class="categories mt-30">
                                   <h4>Categories</h4>
                                   <ul>
                                       <li><a href="#">Fronted</a></li>
                                       <li><a href="#">Backend</a></li>
                                       <li><a href="#">Photography</a></li>
                                       <li><a href="#">Teachnology</a></li>
                                       <li><a href="#">GMET</a></li>
                                       <li><a href="#">Language</a></li>
                                       <li><a href="#">Science</a></li>
                                       <li><a href="#">Accounting</a></li>
                                   </ul>
                               </div>
                           </div> <!-- categories -->
                           <div class="col-lg-12 col-md-6">
                               <div class="saidbar-post mt-30">
                                   <h4>Popular Posts</h4>
                                   <ul>
                                       <li>
                                            <a href="#">
                                                <div class="singel-post">
                                                   <div class="thum">
                                                       <img :src="`${baseUrl}/images/blog/blog-post/bp-1.jpg`" alt="Blog">
                                                   </div>
                                                   <div class="cont">
                                                       <h6>Introduction to languages</h6>
                                                       <span>20 Dec 2018</span>
                                                   </div>
                                               </div> <!-- singel post -->
                                            </a>
                                       </li>
                                       <li>
                                            <a href="#">
                                                <div class="singel-post">
                                                   <div class="thum">
                                                       <img :src="`${baseUrl}/images/blog/blog-post/bp-2.jpg`" alt="Blog">
                                                   </div>
                                                   <div class="cont">
                                                       <h6>How to build a game with java</h6>
                                                       <span>10 Dec 2018</span>
                                                   </div>
                                               </div> <!-- singel post -->
                                            </a>
                                       </li>
                                       <li>
                                            <a href="#">
                                                <div class="singel-post">
                                                   <div class="thum">
                                                       <img :src="`${baseUrl}/images/blog/blog-post/bp-1.jpg`" alt="Blog">
                                                   </div>
                                                   <div class="cont">
                                                       <h6>Basic accounting from primary</h6>
                                                       <span>07 Dec 2018</span>
                                                   </div>
                                               </div> <!-- singel post -->
                                            </a>
                                       </li>
                                   </ul>
                               </div> <!-- saidbar post -->
                           </div>
                       </div> <!-- row -->
                   </div> <!-- saidbar -->
               </div>
           </div> <!-- row -->
        </div> <!-- container -->
    </section>
    
    <!--====== BLOG PART ENDS ======-->

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
