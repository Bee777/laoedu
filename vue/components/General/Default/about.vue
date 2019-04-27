<template>
  <div>
    <section
      id="page-banner"
      class="pt-105 pb-110 bg_cover"
      data-overlay="8"
      style="background-image: url(images/page-banner-1.jpg)"
    >
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <div class="page-banner-cont">
              <h2>About Us</h2>
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item">
                    <a href="#">Home</a>
                  </li>
                  <li class="breadcrumb-item active" aria-current="page">About Us</li>
                </ol>
              </nav>
            </div>
            <!-- page banner cont -->
          </div>
        </div>
        <!-- row -->
      </div>
      <!-- container -->
    </section>

    <!--====== PAGE BANNER PART ENDS ======-->

    <!--====== ABOUT PART START ======-->

    <section id="about-page" class="pt-70 pb-110">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <div class="section-title mt-50">
              <h5>About us</h5>
              <h2>Welcome to Edubin</h2>
            </div>
            <!-- section title -->   
               <div class="about-cont" v-if="!$utils.isEmptyVar(homeData.AboutJaol)">
                <p v-html="homeData.AboutJaol.description"></p>
            </div>
          </div>

        </div>
        <!-- row -->
        <div class="about-items pt-60">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 col-sm-10">
              <div class="about-singel-items mt-30">
                <span>01</span>
                <h4>Why Choose us</h4>
                <p>Lorem ipsum gravida nibh vel velit auctor aliquetn sollicitudirem quibibendum auci elit sollicitudirem quibibendum auci</p>
              </div>
              <!-- about singel -->
            </div>
            <div class="col-lg-4 col-md-6 col-sm-10">
              <div class="about-singel-items mt-30">
                <span>02</span>
                <h4>Our Mission</h4>
                <p>Lorem ipsum gravida nibh vel velit auctor aliquetn sollicitudirem quibibendum auci elit sollicitudirem quibibendum auci</p>
              </div>
              <!-- about singel -->
            </div>
            <div class="col-lg-4 col-md-6 col-sm-10">
              <div class="about-singel-items mt-30">
                <span>03</span>
                <h4>Our vission</h4>
                <p>Lorem ipsum gravida nibh vel velit auctor aliquetn sollicitudirem quibibendum auci elit sollicitudirem quibibendum auci</p>
              </div>
              <!-- about singel -->
            </div>
          </div>
          <!-- row -->
        </div>
        <!-- about items -->
      </div>
      <!-- container -->
    </section>
    <!--====== PATNAR LOGO PART START ======-->

    <div id="patnar-logo" class="pt-40 pb-80 gray-bg">
      <div class="container">
               <div class="row patnar-slied">
          <div class="col-lg-12">
            <div class="singel-patnar text-center mt-40">
              <img :src="`${baseUrl}${baseRes}/assets/images/patnar-logo/p-1.png`" alt="Logo">
            </div>
          </div>
          <div class="col-lg-12">
            <div class="singel-patnar text-center mt-40">
              <img :src="`${baseUrl}${baseRes}/assets/images/patnar-logo/p-2.png`" alt="Logo">
            </div>
          </div>
          <div class="col-lg-12">
            <div class="singel-patnar text-center mt-40">
              <img :src="`${baseUrl}${baseRes}/assets/images/patnar-logo/p-3.png`" alt="Logo">
            </div>
          </div>
          <div class="col-lg-12">
            <div class="singel-patnar text-center mt-40">
              <img :src="`${baseUrl}${baseRes}/assets/images/patnar-logo/p-4.png`" alt="Logo">
            </div>
          </div>
          <div class="col-lg-12">
            <div class="singel-patnar text-center mt-40">
              <img :src="`${baseUrl}${baseRes}/assets/images/patnar-logo/p-2.png`" alt="Logo">
            </div>
          </div>
          <div class="col-lg-12">
            <div class="singel-patnar text-center mt-40">
              <img :src="`${baseUrl}${baseRes}/assets/images/patnar-logo/p-3.png`" alt="Logo">
            </div>
          </div>
        </div>
        <!-- row -->
      </div>
      <!-- container -->
    </div>

    <!--====== PATNAR LOGO PART ENDS ======-->
  </div>
</template>
<script>
import Base from "@com/Bases/GeneralBase.js";
export default Base.extend({
  created() {
    this.fetchHomeData();
    this.setPageTitle(`About us`);
  }
});
</script>
