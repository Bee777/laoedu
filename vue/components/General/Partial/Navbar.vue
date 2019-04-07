<template>
  <div>
    <!--====== HEADER PART START ======-->
    <header id="header-part">
      <div class="header-top d-none d-lg-block">
        <div class="container">
          <div class="row">
            <div class="col-lg-6">
              <div class="header-contact text-lg-left text-center">
                <ul>
                  <li>
                    <img :src="`${baseUrl}/images/all-icon/map.png`" alt="icon">
                    <span>127/5 Mark street, New york</span>
                  </li>
                  <li>
                    <img :src="`${baseUrl}/images/all-icon/email.png`" alt="icon">
                    <span>info@yourmail.com</span>
                  </li>
                </ul>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="header-opening-time text-lg-right text-center">
                <p>Opening Hours : Monday to Saturay - 8 Am to 5 Pm</p>
              </div>
            </div>
          </div>
          <!-- row -->
        </div>
        <!-- container -->
      </div>
      <!-- header top -->

      <div class="header-logo-support pt-30 pb-30">
        <div class="container">
          <div class="row">
            <div class="col-lg-4 col-md-4">
              <div class="logo">
                <router-link class="logo" to="/">
                  <img
                    class="logoImage"
                    :src="`${baseUrl}/images/${s.website_logo}${s.fresh_version}`"
                  >
                </router-link>
              </div>
            </div>
            <div class="col-lg-8 col-md-8">
              <div class="support-button float-right d-none d-md-block">
                <div class="support float-left">
                  <div class="icon">
                    <img :src="`${baseUrl}/images/all-icon/support.png`" alt="icon">
                  </div>
                  <div class="cont">
                    <p>Need Help? call us free</p>
                    <span>321 325 5678</span>
                  </div>
                </div>
                <div class="btn float-left">
                  <a href="#" class="main-btn">Apply Now</a>
                </div>
              </div>
            </div>
          </div>
          <!-- row -->
        </div>
        <!-- container -->
      </div>
      <!-- header logo support -->
      <div class="navigation">
        <div class="container">
          <div class="row">
            <div class="col-lg-10 col-md-10 col-sm-9 col-8">
              <nav class="navbar navbar-expand-lg">
                <!-- Mobile menu -->
                <a v-if="isMobile" class="navbar-burger burger" @click="showMobileNav()">
                  <span></span>
                  <span></span>
                  <span></span>
                </a>
                <!-- Navbar menu -->
                <div class="collapse navbar-collapse sub-menu-bar" id="navbarSupportedContent">
                  <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                      <router-link to="/" active-class="active" exact>ໜ້າຫຼັກ</router-link>
                    </li>
                    <li class="nav-item">
                      <a href="#">ຫຼັກສູດ</a>
                      <ul class="sub-menu">
                        <li>
                          <a href="courses.html">ຫຼັກສູດ</a>
                        </li>
                        <li>
                          <a href="courses-singel.html">Course Singel</a>
                        </li>
                      </ul>
                    </li>
                    <li class="nav-item">
                      <router-link :to="{name: 'events'}" active-class="active" exact>ສະຖາບັນ</router-link>
                    </li>
                    <li class="nav-item">
                      <router-link :to="{name: 'news'}" active-class="active" exact>ຂ່່າວ</router-link>
                    </li>
                    <li class="nav-item">
                      <router-link
                        :to="{name: 'activities'}"
                        active-class="is-active"
                        exact
                      >ກິດຈະກຳ</router-link>
                    </li>
                    <li class="nav-item">
                      <router-link
                        to="/about"
                        active-class="active"
                        exact
                      >ກ່ຽວກັບສູນ</router-link>
                    </li>
                    <li class="nav-item">
                      <router-link to="/contact" active-class="active" exact>ຕິດຕໍ່ພວກເຮົາ</router-link>
                    </li>
                  </ul>
                </div>
              </nav>
              <!-- nav -->
            </div>
            <div class="col-lg-2 col-md-2 col-sm-3 col-4">
              <div class="right-icon text-right">
                <ul>
                  <li>
                    <a href="#" id="search">
                      <i class="fa fa-search"></i>
                    </a>
                  </li>
                </ul>
              </div>
              <!-- right icon -->
            </div>
          </div>
          <!-- row -->
        </div>
        <!-- container -->
      </div>
    </header>

    <!--====== SEARCH BOX PART START ======-->

    <div class="search-box">
      <div class="serach-form">
        <div class="closebtn">
          <span></span>
          <span></span>
        </div>
        <form action="#">
          <input type="text" placeholder="Search by keyword">
          <button>
            <i class="fa fa-search"></i>
          </button>
        </form>
      </div>
      <!-- serach form -->
    </div>

    <!--====== SEARCH BOX PART ENDS ======-->
  </div>
  <!--====== HEADER PART ENDS ======-->
</template>

<script>
import { mapActions, mapGetters, mapState, mapMutations } from "vuex";
import Base from "@com/Bases/GeneralBase.js";

export default Base.extend({
  data() {
    return {
      ...mapGetters(["LoggedIn", "validated"]),
      isActive: ""
    };
  },
  watch: {
    isSidebar: function(n, o) {
      this.isActive = n === "left-side" ? "" : "is-active";
    }
  },
  computed: {
    ...mapState(["isMobile", "isSidebar"])
  },
  methods: {
    ...mapMutations(["setSidebar"]),
    ...mapActions(["Logout"]),
    showMobileNav() {
      this.isActive = this.isActive === "is-active" ? "" : "is-active";
      this.setSidebar({ isSidebar: this.isActive });
    }
  }
});
</script>

<style scoped>
</style>

