<template>
  <div>
    <!--====== CONTACT PART START ======-->
    <section id="contact-page" class="pt-40 pb-60 gray-bg">
      <div class="container">
        <div class="row">
          <div class="col-lg-7">
            <ContactForm :isFullWidth="true"/>
            <!--  contact from -->
          </div>
          <div class="col-lg-5">
            <div class="contact-address">
              <ul v-if="!$utils.isEmptyVar( s )">
                <li>
                  <div class="singel-address">
                    <div class="icon">
                      <i class="fa fa-home"></i>
                    </div>
                    <div class="cont">
                      <p>{{s.address}}</p>
                    </div>
                  </div>
                  <!-- singel address -->
                </li>
                <li>
                  <div class="singel-address">
                    <div class="icon">
                      <i class="fa fa-phone"></i>
                    </div>
                    <div class="cont">
                      <p>{{s.phone}}</p>
                    </div>
                  </div>
                  <!-- singel address -->
                </li>
                <li>
                  <div class="singel-address">
                    <div class="icon">
                      <i class="fas fa-envelope"></i>
                    </div>
                    <div class="cont">
                      <p>{{s.email}}</p>
                    </div>
                  </div>
                  <!-- singel address -->
                </li>
              </ul>
            </div>
            <!-- contact address -->
            <!-- <div id="contact-map"></div> -->
            <div class="gmap mt-10">
              <iframe
                src="https://maps.google.com/maps?width=100%&amp;height=450&amp;hl=en&amp;q=ກະຊວງສຶກສາເຈົ້າອານຸ&amp;ie=UTF8&amp;t=&amp;z=13&amp;iwloc=B&amp;output=embed"
                frameborder="0"
                scrolling="no"
                marginheight="0"
                marginwidth="0"
                style="width: 100%;
                   height: 250px;"
              ></iframe>
            </div>

            <!-- map -->
          </div>
        </div>
        <!-- row -->
      </div>
      <!-- container -->
    </section>
    <!--====== CONTACT PART ENDS ======-->
  </div>
</template>
<script>
import Base from "@com/Bases/GeneralBase.js";
import ContactForm from "@com/General/ContactForm.vue";

export default Base.extend({
  components: {
    ContactForm
  },
  created() {
    this.setPageTitle(`Contact Us`);
  }
});
</script>
<style lang="less" scoped>
.gmap {
  padding: 6px 6px 0;
  -webkit-border-radius: 8px;
  border-radius: 8px;
  border: 1px solid #dadce0;
  background-color: #ffffff;
}
</style>


