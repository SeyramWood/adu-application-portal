<template>
  <section class="dashboard">
    <section class="dashboard__top">
      <div class="s__row">
        <div class="s__col c--4">
          <div class="dashboard__card__top">
            <div class="dashboard__card__top__left">
              <div class="dashboard__card__top__left__icon icon--info">
                <v-icon>mdi-account-group-outline</v-icon>
              </div>
              <div class="dashboard__card__top__left__content">
                <p>Total Applications</p>
                <p>{{ applicantCount.total }}</p>
              </div>
            </div>
            <div class="dashboard__card__top__right text--danger">
              <p>
                {{ percentage(applicantCount.total, applicantCount.total) }}
              </p>
            </div>
          </div>
        </div>
        <div class="s__col c--4">
          <div class="dashboard__card__top">
            <div class="dashboard__card__top__left">
              <div class="dashboard__card__top__left__icon icon--warnning">
                <v-icon>mdi-book-education-outline</v-icon>
              </div>
              <div class="dashboard__card__top__left__content">
                <p>In-progress Applications</p>
                <p>{{ applicantCount.inProgress }}</p>
              </div>
            </div>
            <div class="dashboard__card__top__right text--info">
              <p>
                {{
                  percentage(applicantCount.total, applicantCount.inProgress)
                }}
              </p>
            </div>
          </div>
        </div>
        <div class="s__col c--4">
          <div class="dashboard__card__top">
            <div class="dashboard__card__top__left">
              <div class="dashboard__card__top__left__icon icon--danger">
                <v-icon>mdi-bullseye-arrow</v-icon>
              </div>
              <div class="dashboard__card__top__left__content">
                <p>Completed Applications</p>
                <p>{{ applicantCount.completed }}</p>
              </div>
            </div>
            <div class="dashboard__card__top__right text--warnning">
              <p>
                {{ percentage(applicantCount.total, applicantCount.completed) }}
              </p>
            </div>
          </div>
        </div>
      </div>
      <div class="s__row">
        <div class="s__col c--4">
          <div class="dashboard__card__top">
            <div class="dashboard__card__top__left">
              <div class="dashboard__card__top__left__icon icon--danger">
                <v-icon>mdi-finance</v-icon>
              </div>
              <div class="dashboard__card__top__left__content">
                <p>Scholarship Applications</p>
                <p>{{ applicantCount.scholarship }}</p>
              </div>
            </div>
            <div class="dashboard__card__top__right text--warnning">
              <p>
                {{
                  percentage(applicantCount.total, applicantCount.scholarship)
                }}
              </p>
            </div>
          </div>
        </div>
        <div class="s__col c--4">
          <div class="dashboard__card__top">
            <div class="dashboard__card__top__left">
              <div class="dashboard__card__top__left__icon icon--success">
                <v-icon>mdi-file-eye-outline</v-icon>
              </div>
              <div class="dashboard__card__top__left__content">
                <p>Reviewed Applications</p>
                <p>{{ applicantCount.reviewed }}</p>
              </div>
            </div>
            <div class="dashboard__card__top__right text--danger">
              <p>
                {{ percentage(applicantCount.total, applicantCount.reviewed) }}
              </p>
            </div>
          </div>
        </div>

        <!-- <div class="s__col c--4">
          <div class="dashboard__card__top">
            <div class="dashboard__card__top__left">
              <div class="dashboard__card__top__left__icon icon--info">
                <v-icon>mdi-file-check-outline</v-icon>
              </div>
              <div class="dashboard__card__top__left__content">
                <p>Admitted Applicants</p>
                <p>34</p>
              </div>
            </div>
            <div class="dashboard__card__top__right text--success">
              <p>-10%</p>
            </div>
          </div>
        </div> -->
      </div>
    </section>
    <s-accordians :defaultIndex="0">
      <s-accordian label="Accordian">
        <template #header>
          <section class="collapse__header">
            <div class="collapse__header__left">
              <div class="icon-left">
                <div class="icon-arch"></div>
                <div class="icon-circle"></div>
              </div>
              <div class="title">
                <h4>Recent Applicants</h4>
              </div>
            </div>
            <div class="collapse__header__right">
              <!-- <div class="progress">
                <v-progress-circular
                  :value="65"
                  color="primary"
                  :size="70"
                  :width="10"
                >
                  65%
                </v-progress-circular>
              </div> -->
              <div class="fat__arrow">
                <div class="arrow"></div>
              </div>
            </div>
          </section>
        </template>
        <section class="collapse__content">
          <div
            class="collapse__content__timeline"
            v-for="app in getApplicants"
            :key="app.id"
          >
            <div class="line"></div>
            <div class="dot"></div>
            <div class="title">
              <span>{{ `${app.first_name} ${app.last_name}` }}</span>
            </div>
            <div class="user">
              <div class="sperator"></div>
              <div class="details">
                <span>{{ app.email }}</span>
              </div>
            </div>
          </div>
          <div class="collapse__content__btn">
            <Link
              href="/dashboard/applicants"
              class="
                v-btn v-btn--is-elevated v-btn--has-bg
                theme--light
                v-size--large
                secondary
              "
            >
              View applicants
            </Link>
          </div>
        </section>
      </s-accordian>
      <s-accordian label="Accordian">
        <template #header>
          <section class="collapse__header">
            <div class="collapse__header__left">
              <div class="icon-left">
                <div class="icon-arch"></div>
                <div class="icon-circle"></div>
              </div>
              <div class="title">
                <h4>Recent Reviewed Applicants</h4>
              </div>
            </div>
            <div class="collapse__header__right">
              <!-- <div class="progress">
                <v-progress-circular
                  :value="65"
                  color="primary"
                  :size="70"
                  :width="10"
                >
                  65%
                </v-progress-circular>
              </div> -->
              <div class="fat__arrow">
                <div class="arrow"></div>
              </div>
            </div>
          </section>
        </template>
        <section class="collapse__content">
          <div
            class="collapse__content__timeline"
            v-for="app in getReviewedApplicants"
            :key="app.id"
          >
            <div class="line"></div>
            <div class="dot"></div>
            <div class="title">
              <span>{{ `${app.first_name} ${app.last_name}` }}</span>
            </div>
            <div class="user">
              <div class="sperator"></div>
              <div class="details">
                <span>{{ app.email }}</span>
              </div>
            </div>
          </div>
          <div class="collapse__content__btn">
            <Link
              href="/dashboard/reviewed-applicants"
              class="
                v-btn v-btn--is-elevated v-btn--has-bg
                theme--light
                v-size--large
                secondary
              "
            >
              View reviewed applicants
            </Link>
          </div>
        </section>
      </s-accordian>
      <s-accordian label="Accordian">
        <template #header>
          <section class="collapse__header">
            <div class="collapse__header__left">
              <div class="icon-left">
                <div class="icon-arch"></div>
                <div class="icon-circle"></div>
              </div>
              <div class="title">
                <h4>Recent Sbuscribers</h4>
              </div>
            </div>
            <div class="collapse__header__right">
              <!-- <div class="progress">
                <v-progress-circular
                  :value="65"
                  color="primary"
                  :size="70"
                  :width="10"
                >
                  65%
                </v-progress-circular>
              </div> -->
              <div class="fat__arrow">
                <div class="arrow"></div>
              </div>
            </div>
          </section>
        </template>
        <section class="collapse__content">
          <div
            class="collapse__content__timeline"
            v-for="s in subscribers"
            :key="s.id"
          >
            <div class="line"></div>
            <div class="dot"></div>
            <div class="title">
              <span>{{ `${s.email}` }}</span>
            </div>
            <div class="user">
              <div class="sperator"></div>
              <div class="details">
                <span>{{ s.created_at }}</span>
              </div>
            </div>
          </div>
          <div class="collapse__content__btn">
            <Link
              href="/dashboard/subscribers"
              class="
                v-btn v-btn--is-elevated v-btn--has-bg
                theme--light
                v-size--large
                secondary
              "
            >
              View Subscribers
            </Link>
          </div>
        </section>
      </s-accordian>
    </s-accordians>
  </section>
</template>

<script>
import Layout from "../components/Layout";
import SAccordians from "../components/accordian/sAccordians";
import SAccordian from "../components/accordian/sAccordian";
import SRange from "../components/SRange";
import { Link } from "@inertiajs/inertia-vue";

export default {
  name: "Dashboard",
  components: { SAccordians, SAccordian, SRange, Link },
  layout: Layout,
  props: {
    applicantCount: {
      require: true,
      type: Object,
    },
    latestApplicants: {
      require: true,
      type: Array,
    },
    latestReviewedApplicants: {
      require: true,
      type: Array,
    },
    subscribers: {
      require: true,
      type: Array,
    },
  },
  computed: {
    getApplicants() {
      return this.latestApplicants;
    },
    getReviewedApplicants() {
      return this.latestReviewedApplicants;
    },
  },
  methods: {
    clickMe() {
      console.log("click me");
    },
    percentage(total, count) {
      const results = (count / total) * 100;
      if (Number.isInteger(results)) {
        return `${(count / total) * 100}%`;
      }
      return `${((count / total) * 100).toFixed(2)}%`;
    },
  },
};
</script>

<style lang="scss" scoped>
</style>