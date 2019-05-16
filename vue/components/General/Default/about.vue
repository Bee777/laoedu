<template>
  <div>
    <!--====== ABOUT PART START ======-->
    <section id="about-page" class="pt-40 pb-60">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <div class="section-title mt-50">
              <h5>About us</h5>
              <h2>{{s.site_name}}</h2>
            </div>
               <div class="about-cont" v-if="!$utils.isEmptyVar(s)">
                <p v-html="s.description"></p>
            </div>
          </div>
        </div>
        <!-- row -->
        <!-- about items -->
      </div>
      <!-- container -->
    </section>
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
