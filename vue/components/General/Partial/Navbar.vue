<template>
  <div>
    <!--====== HEADER PART START ======-->
    <header id="header-part">
      <!-- <div class="header-top d-none d-lg-block">
        <div class="container">
          <div class="row">
            <div class="col-lg-6">
              <div class="header-contact text-lg-left text-center">
                <ul>
                  <li>
                    <img :src="`${baseUrl}${baseRes}/assets/images/all-icon/map.png`" alt="icon">
                    <span>127/5 Mark street, New york</span>
                  </li>
                  <li>
                    <img :src="`${baseUrl}${baseRes}/assets/images/all-icon/email.png`" alt="icon">
                    <span>info@yourmail.com</span>
                  </li>
                </ul>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="header-opening-time text-lg-right text-center">
                
                <p><i class="far fa-clock"></i> Monday to Saturay - 8 Am to 5 Pm</p>
              </div>
            </div>
          </div>
        </div>
      </div> -->
      <!-- header top -->

      <div class="header-logo-support pt-30 pb-30">
        <div class="container">
          <div class="row">
            <div class="col-lg-6 col-md-6">
              <div class="logo">
                <router-link class="logo" to="/">
                  <img
                    class="logoImage"
                    :src="`${baseUrl}/assets/images/${s.website_logo}${s.fresh_version}`"
                  >
                </router-link>
                <span class="site-title">ສູນປະກັນຄຸນນະພາບການສຶກສາ ສປປ ລາວ</span>
              </div>
            </div>
            <div class="col-lg-6 col-md-6">
              <div class="support-button float-right d-none d-md-block">
                <div class="support float-left">
                  <div class="icon">
                    <img
                      :src="`${baseUrl}${baseRes}assets/images/all-icon/support.png`"
                      alt="icon"
                    >
                  </div>
                  <div class="cont" v-if="!$utils.isEmptyVar( s.phone )">
                    <p>Need Help? call us free</p>
                    <span>{{s.phone}}</span>
                  </div>
                </div>
                <div class="button float-left">
                  <template v-if="!LoggedIn()">
                    <!--<a @click="Route({name: 'register'})" data-target="modal-signup" class="btn">-->
                    <!--<strong>Sign up</strong>-->
                    <!--</a>-->
                    <a @click="Route({name: 'login'})" class="main-btn">
                      <strong>ເຂົ້າໃຊ້ລະບົບ</strong>
                    </a>
                  </template>
                  <template v-else>
                    <a @click="$utils.Location('/admin/me')" class="main-btn">
                      <strong>Dashboard</strong>
                    </a>

                    <a
                      @click="Logout()"
                      class="main-btn"
                      :class="[ validated().loading ? 'is-loading' : '']">
                      <strong>Sign out</strong>
                    </a>
                  </template>
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
                  <i class="menu material-icons">menu</i>
                </a>

                <!-- Navbar menu -->
                <div class="collapse navbar-collapse sub-menu-bar" id="navbarSupportedContent">
                  <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                      <router-link to="/" active-class="active" exact>ໜ້າຫຼັກ</router-link>
                    </li>
                   <!--  <li class="nav-item">
                      <router-link :to="{name:'course'}">ຫຼັກສູດ</router-link>
                      <ul class="sub-menu">
                        <li>
                          <router-link :to="{name:'course-single'}">Course Singel</router-link>
                        </li>
                      </ul>
                    </li> -->
                    <li class="nav-item">
                      <router-link :to="{name: 'institute'}" active-class="active">ສະຖານການສຶກສາ</router-link>
                      <!--<ul class="sub-menu">-->
                        <!--<li>-->
                          <!--<router-link to="/posts/institute/single/:id">Institute Single</router-link>-->
                        <!--</li>-->
                      <!--</ul>-->
                    </li>
                    <li class="nav-item">
                      <router-link :to="{name: 'news'}" active-class="active" exact>ຂ່າວສານ</router-link>
                    </li>
                    <li class="nav-item">
                          <router-link :to="{name: 'scholarships'}" active-class="active" exact>
                        ທຶນການສຶກສາ
                    </router-link>
                    </li>
                    <li class="nav-item">
                      <router-link :to="{name: 'activities'}" active-class="active" exact>ກິດຈະກຳ</router-link>
                    </li>
                    <li class="nav-item">
                      <router-link to="/about" active-class="active" exact>ກ່ຽວກັບສູນ</router-link>
                    </li>
                    <li class="nav-item">
                      <router-link to="/contact" active-class="active" exact>ຕິດຕໍ່ພວກເຮົາ</router-link>
                    </li>
                  </ul>
                </div>
              </nav>
              <!-- nav -->
            </div>
            <!-- search -->
            <!-- <div class="col-lg-2 col-md-2 col-sm-3 col-4">
              <div class="right-icon text-right">
                <ul>
                  <li>
                    <a href="#" id="search">
                      <i class="fa fa-search"></i>
                    </a>
                  </li>
                </ul>
              </div>      
            </div> -->
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

