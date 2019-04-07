<template>
  <div>
    <section class="section">
      <div class="sponser">
        <div class="inner www-container">
          <h1 class="sub-sponsor">Sponsors</h1>
          <div class="columns is-multiline">
            <div class="column hover is-3 s-info" v-for="(sponsor,index) in homeData.sponsors" :key="index">
              <a
                :href="sponsor.link"
                target="_brank"
              >
                <img class="img-hover" :src="sponsor.image">

                  <div class="middle">
                  <div class="text">
                    {{sponsor.name}}
                    <br>
                    <span v-html="$utils.sub($utils.strip(sponsor.description), 300)" class="text-small"></span>
                  </div>
                </div>
              </a>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>
<script>
import Base from "@com/Bases/GeneralBase.js";
export default Base.extend({
  name: "Sponsor"
});
</script>
