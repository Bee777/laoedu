<template>
  <div>
    <!--====== ABOUT PART START ======-->
    <section id="about-page" class="pt-40 pb-60">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <div class="section-title mt-50">
              <h5>About us</h5>
              <h2>Welcome to Edubin</h2>
            </div>
            <!-- section title -->   
               <div class="about-cont" v-if="!$utils.isEmptyVar(homeData.About)">
                <p v-html="homeData.About.description"></p>
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
