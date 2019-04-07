<template>
  <div>
    <div class="page-header">
      <section class="section">
        <div class="container">
          <div class="entry-title">
            <h2 class="header-title">Board Committee</h2>
            <span class="break white-color-header"></span>
          </div>
          <div class="chart-content" v-if="homeData.organizeChart.info">
            <p v-html="homeData.organizeChart.info.description"></p>
          </div>
        </div>
      </section>
    </div>
    <section class="section">
      <div class="container">
        <div class="member">
          <div class="fire-spinner" v-if="isLoading"></div>
          <div class="card-header flex-column">
            <div class="flex">
              <div class="card-header-title board-title">
                <i class="material-icons">bubble_chart</i>Select
                Board Committee
              </div>
            </div>
            <div class="select-option flex form-multi-select-container">
              <multiselect
                class="select-multiple"
                v-model="filterRange"
                label="name"
                track-by="id"
                placeholder="Select chart range"
                open-direction="bottom"
                :options="chartRanges"
                :show-no-results="false"
                :preserve-search="true"
                :hide-selected="false"
                @input="getItems"
              ></multiselect>
            </div>
          </div>
          <div class="card-header">
            <p class="card-header-title board-title">
              <i class="material-icons">insert_chart</i>
              Board
              Committee -
              {{ homeData.organizeChart.chart && homeData.organizeChart.chart.selectedRange ?
              homeData.organizeChart.chart.selectedRange.name : '...' }}
            </p>
          </div>
          <div class="card-content">
            <div class="columns is-multiline">
              <!-- Head of Organization -->
              <div
                class="column is-4 is-offset-4"
                v-if="homeData.organizeChart.chart && homeData.organizeChart.chart.president"
              >
                <div class="card-jaol">
                  <div class="single-team">
                    <div class="team-head image">
                      <img
                        class="member-image"
                        :src="`${baseUrl}${homeData.organizeChart.chart.president.image}`"
                        alt
                      >
                    </div>
                    <div class="team-info">
                      <div class="name">
                        <h4>
                          {{
                          String(homeData.organizeChart.chart.president.position_text).replace(/_/g,
                          ' ') }}
                        </h4>
                      </div>
                      <p class="member-name">
                        {{homeData.organizeChart.chart.president.name}}
                        {{homeData.organizeChart.chart.president.surname}}
                      </p>
                      <div class="university-text">
                        <p>
                          <i class="material-icons">school</i>
                        </p>
                        <p v-text="homeData.organizeChart.chart.president.university"></p>
                      </div>
                    </div>
                  </div>
                  <footer class="card-footer" v-if="homeData.organizeChart.chart.president.company">
                    <div class="company-content">
                      <p class="designation-title"><i class="material-icons selected-icon">business</i>
                        <i class="material-icons">account_balance</i></p>
                      <p class="designation-content author-fontBold">
                        {{
                        homeData.organizeChart.chart.president.company
                        }}
                      </p>
                    </div>
                  </footer>
                </div>
              </div>
            </div>
          </div>
          <span class="break"></span>
          <div class="card-header">
            <p class="card-header-title">Vice President</p>
          </div>
          <div class="card-content" v-if="homeData.organizeChart.chart">
            <div
              class="columns is-multiline"
              :class="[{'is-centered': homeData.organizeChart.chart.vice_president.length <= 3 }]"
            >
              <div
                class="column is-3"
                :class="[{'has-text-centered': homeData.organizeChart.chart.vice_president.length <= 3 }]"
                v-for="(item, idx) in homeData.organizeChart.chart.vice_president"
                :key="idx"
              >
                <div class="card-jaol">
                  <div class="single-team">
                    <div class="team-head image">
                      <img class="member-image" :src="`${baseUrl}${item.image}`" alt>
                    </div>
                    <div class="team-info">
                      <div class="name">
                        <h4>
                          {{
                          String(item.position_text).replace(/_/g,
                          ' ') }}
                        </h4>
                      </div>
                      <p class="member-name">
                        {{item.name}}
                        {{item.surname}}
                      </p>
                      <div class="university-text">
                        <p>
                          <i class="material-icons">school</i>
                        </p>
                        <p v-text="item.university"></p>
                      </div>
                    </div>
                  </div>
                  <footer class="card-footer">
                    <div class="company-content">
                      <p v-if="item.company" class="designation-title"><i class="material-icons selected-icon">business</i>
                        <i class="material-icons">account_balance</i></p>
                      <p v-if="item.company" class="designation-content author-fontBold">
                        {{
                        item.company
                        }}
                      </p>
                    </div>
                  </footer>
                </div>
              </div>
            </div>
          </div>
          <span class="break"></span>
          <div class="card-header">
            <p class="card-header-title">Committee</p>
          </div>
          <div class="card-content" v-if="homeData.organizeChart.chart">
            <div class="columns is-multiline">
              <div
                class="column is-3"
                v-for="(item, idx) in homeData.organizeChart.chart.data"
                :key="idx"
              >
                <div class="card-jaol">
                  <div class="single-team">
                    <div class="team-head image">
                      <img class="member-image" :src="`${baseUrl}${item.image}`" alt>
                    </div>
                    <div class="team-info">
                      <div class="name">
                        <h4>
                          {{
                          String(item.position_text).replace(/_/g,
                          ' ') }}
                        </h4>
                      </div>
                      <p class="member-name">
                        {{item.name}}
                        {{item.surname}}
                      </p>
                      <div class="university-text">
                        <p>
                          <i class="material-icons">school</i>
                        </p>
                        <p v-text="item.university"></p>
                      </div>
                    </div>
                  </div>
                  <footer class="card-footer">
                    <div class="company-content">
                      <p v-if="item.company" class="designation-title">
                        <i class="material-icons selected-icon">business</i>
                        <i class="material-icons">account_balance</i>
                      </p>
                      <p v-if="item.company" class="designation-content author-fontBold">
                        {{
                        item.company
                        }}
                      </p>
                    </div>
                  </footer>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>
<style scoped>
</style>

<script>
import Base from "@com/Bases/GeneralBase.js";
import multiselect from "vue-multiselect";
import { mapActions } from "vuex";

export default Base.extend({
  components: {
    multiselect
  },
  data: () => ({
    filterRange: {},
    chartRanges: [],
    isLoading: false
  }),
  watch: {
    "homeData.organizeChart.chart.chartRanges": function(n, o) {
      this.chartRanges = n;
      this.filterRange = this.homeData.organizeChart.chart.selectedRange;
    }
  },
  methods: {
    ...mapActions(["fetchMembersChartRange"]),
    getItems() {
      if (
        this.$utils.isEmptyVar(this.filterRange) ||
        this.$utils.isEmptyObject(this.filterRange)
      ) {
        return;
      }
      this.isLoading = true;
      this.fetchMembersChartRange(this.filterRange)
        .then(res => {
          this.isLoading = false;
        })
        .catch(err => {
          this.isLoading = false;
        });
    }
  },
  created() {
    this.fetchHomeData();
    this.setPageTitle(`Board Committee`);
  }
});
</script>
<style scoped>

</style>


