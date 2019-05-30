<template>
  <div>
    <!--====== FOOTER PART START ======-->
    <footer id="footer-part">
      <div class="footer-top pt-10 pb-40">
        <div class="container">
          <div class="row mobile-left">
            <div class="col-lg-4 col-md-6">
              <div class="footer-about mt-40">
                <div class="logo">
                  <Router-link to="/">
                    <img
                      :src="`${baseUrl}/assets/images/${s.website_logo}${s.fresh_version}`"
                      alt="Logo"
                    >
                  </Router-link>
                </div>
                <p>ສູນປະກັນຄຸນນະພາບການສຶກສາ</p>
                <ul class="mt-20">
                  <li>
                    <a :href="s.facebook" target="_blank" >
                      <i class="fab fa-facebook-f"></i>
                    </a>
                  </li>
                  <li>
                    <a v-if="!$utils.isEmptyVar(s.twitter)" :href="s.twitter" target="_blank">
                      <i class="fab fa-twitter"></i>
                    </a>
                  </li>
                </ul>
              </div>
              <!-- footer about -->
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12">
              <div class="footer-link mt-40">
                <div class="footer-title pb-20">
                  <h6>Sitemap</h6>
                </div>
                <ul>
                  <li>
                    <router-link :to="{name:'home'}">
                      <i class="fa fa-angle-right"></i>ໜ້າຫຼັກ
                    </router-link>
                  </li>
                  <!-- <li>
                   <router-link :to="{name:'home'}">
                      <i class="fa fa-angle-right"></i>ຫຼັກສູດ
                   </router-link>
                  </li> -->
                  <li>
                    <Router-link :to="{name:'institute'}">
                      <i class="fa fa-angle-right"></i>ສະຖານການສຶກສາ
                    </Router-link>
                  </li>
                  <li>
                    <router-link :to="{name:'news'}">
                      <i class="fa fa-angle-right"></i>ຂ່າວສານ
                    </router-link>
                  </li>
                     <li>
                   <router-link :to="{name:'scholarships'}">
                      <i class="fa fa-angle-right"></i>ທຶນການສຶກສາ
                   </router-link>
                  </li> <li>
                   <router-link :to="{name:'activities'}">
                      <i class="fa fa-angle-right"></i>ກິດຈະກຳ
                   </router-link>
                  </li>
                  <li>
                  <router-link :to="{name:'contact'}">
                      <i class="fa fa-angle-right"></i>ຂໍ້ມູນຕິດຕໍ່
                  </router-link>
                  </li>
                  <li>
                    <router-link :to="{name:'about'}">
                      <i class="fa fa-angle-right"></i>ກ່ຽວກັບສູນ
                    </router-link>
                  </li>
                </ul>
              </div>
              <!-- footer link -->
            </div>
            <div class="col-lg-4 col-md-6">
              <div class="footer-address mt-40">
                <div class="footer-title pb-20">
                  <h6>Contact Us</h6>
                </div>
                <ul v-if="!$utils.isEmptyVar( s )">
                  <li>
                    <div class="icon">
                      <i class="fa fa-home"></i>
                    </div>
                    <div class="cont">
                      <p>{{s.address}}</p>
                    </div>
                  </li>
                  <li>
                    <div class="icon">
                      <i class="fa fa-phone"></i>
                    </div>
                    <div class="cont">
                      <p>{{s.phone}}</p>
                    </div>
                  </li>
                  <li>
                    <div class="icon">
                      <i class="far fa-envelope"></i>
                    </div>
                    <div class="cont">
                      <p>{{s.email}}</p>
                    </div>
                  </li>
                </ul>
              </div>
              <!-- footer address -->
            </div>
          </div>
          <!-- row -->
        </div>
        <!-- container -->
      </div>
      <!-- footer top -->

      <div class="footer-copyright pt-10 pb-25">
        <div class="container">
          <div class="row">
            <div class="col-md-8">
              <div class="copyright text-center pt-15">
                <p>
                  Copyright ©
                  {{$utils.getDateTime(new Date()).years}} All rights reserved | Powered by
                  <a
                    href="https://www.mekong.digital"
                    target="_blank"
                  >Mekong Digital Works</a>
                </p>
              </div>
            </div>
            <div class="col-md-4">
              <div class="copyright text-md-right text-center pt-15"></div>
            </div>
          </div>
          <!-- row -->
        </div>
        <!-- container -->
      </div>
      <!-- footer copyright -->
    </footer>
    <!--====== BACK TO TP PART ENDS ======-->
  </div>
</template>

<style>
</style>
<script>
    import Base from "@com/Bases/GeneralBase.js";
    export default Base.extend({});
</script>
