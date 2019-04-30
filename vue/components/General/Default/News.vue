<template>
    <div>
       <!--====== BLOG PART START ======-->
        <section id="blog-page" class="pt-20 pb-120 gray-bg">
        <div class="container">
            <div class="fire-spinner" v-if="shouldLoading(type)"></div>
           <div class="row">
               <div class="col-lg-8">
                   <div class="singel-blog mt-30" v-for="(news, idx) in postsData.news.posts.data" :key="idx">
                       <div class="blog-thum" @click="getDetail('news', news)">
                           <img :src="`${baseUrl}${news.image}`" :alt="news.image">
                       </div>
                       <div class="blog-cont">
                           <a @click="getDetail('news', news)">
                               <h3>{{news.title}}</h3>
                               </a>
                           <ul>
                            <li class="updated-date" :datetime="news.updated_at"><i class="fa fa-calendar"></i> {{news.post_updated}}</li>
                             <li><i class="fa fa-user"></i> {{news.author}}</li>
                           </ul>
                           <p v-html="$utils.sub($utils.strip(news.description), 180)"></p>
                       </div>
                   </div> <!-- singel blog -->
                   <nav class="courses-pagination mt-50">
                        <ul class="pagination justify-content-lg-end justify-content-center">
                            <li class="page-item">
                                <a :disabled="paginate.current_page===1" @click="prevPage(paginate.current_page - 1)"
                                    aria-label="Previous" class="active">
                                    <i class="fa fa-angle-left"></i>
                                </a>
                            </li>
                            <!-- <li class="page-item"><a class="active" href="#">1</a></li>
                            <li class="page-item"><a href="#">2</a></li>
                            <li class="page-item"><a href="#">3</a></li> -->
                            <li class="page-item">
                                <a :disabled="paginate.current_page===paginate.last_page"
                                @click="nextPage(paginate.current_page + 1)"
                                 aria-label="Next">
                                    <i class="fa fa-angle-right"></i>
                                </a>
                            </li>
                        </ul>
                    </nav>
               </div>
               <div class="col-lg-8" v-if="isNotFound()">
                                    <div class="devsite-article">
                                        <h1 class="devsite-page-title">
                                            Search results for <span class="devsite-search-term"><span
                                            class="devsite-search-term">{{ query }}</span></span>
                                        </h1>
                                    </div>
                                    <div class="result-snippet">No Results</div>
                                </div>
               <div class="col-lg-4">
                   <div class="saidbar">
                       <div class="row">
                           <div class="col-lg-12 col-md-6">
                                <PostsSearchForm v-model="query" @onSearchEnter="getItems('click')"/>
                           </div> <!-- categories -->
                           <div class="col-lg-12 col-md-6">
                               <div class="saidbar-post mt-30 ">
                                   <h4>Popular Posts</h4>
                                   <ul>
                                       <li v-for="(news, idx) in postsData.news.mostViews" :key="idx">
                                            <a @click="getDetail('news', news)">
                                                <div class="singel-post">
                                                   <div class="thum">
                                                       <img :src="`${baseUrl}${news.image}`" :alt="news.image">
                                                   </div>
                                                   <div class="cont" @click="getDetail('news', news)" >
                                                       <p v-html="$utils.sub($utils.strip(news.title), 35)"></p>
                                                       <span> {{news.post_updated}}</span>
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

    </div>
</template>
<style scoped>
.saidbar .saidbar-post ul li a .singel-post .thum img{
    width: 92px;
    height: 62px;
}
</style>

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
