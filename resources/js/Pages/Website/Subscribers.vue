<template>
  <v-data-table
    :headers="headers"
    :items="subscribers"
    :sort-by="['desired_major']"
    :sort-desc="[false, true]"
    :loading="loading"
    loading-text="Loading... Please wait"
    :items-per-page="100"
    :search="search"
    class="elevation-1"
  >
    <template v-slot:top>
      <v-toolbar flat>
        <v-toolbar-title>All Subscribers</v-toolbar-title>
        <v-divider class="mx-4" inset vertical></v-divider>
        <v-spacer></v-spacer>
        <v-text-field
          v-model="search"
          append-icon="mdi-magnify"
          label="Search"
          single-line
          hide-details
        ></v-text-field>
        <v-spacer></v-spacer>
        <download-excel
          class="btn btn-default"
          :data="json_data"
          :fields="json_fields"
          worksheet="Application"
          name="application.xls"
        >
          <v-btn color="info" class="mb-2">
            <v-icon>mdi-cloud-download-outline</v-icon><span>Excel</span>
          </v-btn>
        </download-excel>
        <download-excel
          class="btn btn-default ml-1"
          :data="json_data"
          :fields="json_fields"
          worksheet="Application"
          type="csv"
          name="application.xls"
        >
          <v-btn color="info" class="mb-2">
            <v-icon>mdi-cloud-download-outline</v-icon><span>CSV</span>
          </v-btn>
        </download-excel>
      </v-toolbar>
    </template>
    <template v-slot:no-data>
      <v-icon small class="mr-2"> mdi-database-outline </v-icon>
      <span>Ooops! No contact found</span>
    </template>
  </v-data-table>
</template>

<script>
import Layout from "../../components/Layout";
export default {
  name: "Subscribers",
  layout: Layout,
  props: {
    subscribers: {
      require: true,
      type: Array,
    },
  },
  computed: {
    getSubscribers() {
      this.loading = true;
      setTimeout(() => {
        this.loading = false;
      }, 1000);
      return this.applicants.map((a) => {
        return {
          ...a,
          name: `${a.last_name} ${a.first_name}`,
        };
      });
    },
    getFilteredApplicants() {
      return this.filteredApplicants.map((a) => {
        return {
          ...a,
          name: `${a.last_name} ${a.first_name}`,
        };
      });
    },
  },
  mounted() {
    this.json_data = this.getApplicants;
  },
  data: () => ({
    search: "",
    dialog: false,
    dialogDelete: false,
    headers: [
      {
        text: "Email",
        align: "start",
        value: "email",
      },
      { text: "Submited on", value: "created_at" },
    ],
    loading: false,
    filteredApplicants: [],
    filterValue: [],
    isFiltered: false,

    json_fields: {
      Email: "email",
      "Submited on": "created_at",
    },
    json_data: [],
    json_meta: [
      [
        {
          key: "charset",
          value: "utf-8",
        },
      ],
    ],
  }),

  watch: {
    dialog(val) {
      val || this.close();
    },
    dialogDelete(val) {
      val || this.closeDelete();
    },
  },

  created() {},

  methods: {
    async fetchApplicants() {
      this.isFiltered = true;
      this.loading = true;
      if (this.filterValue.includes("Any")) {
        this.loading = false;
        this.isFiltered = false;
        this.json_data = this.getApplicants;
        return;
      }
      try {
        const { data } = await this.$axios.get(
          `/dashboard/filter-applicants/${this.filterValue}`
        );
        this.loading = false;
        this.filteredApplicants = data;
        this.json_data = this.getFilteredApplicants;
      } catch (error) {
        console.trace(error);
      }
    },

    editItem(item) {
      this.editedIndex = this.desserts.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialog = true;
    },

    deleteItem(item) {
      this.editedIndex = this.desserts.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialogDelete = true;
    },

    deleteItemConfirm() {
      this.desserts.splice(this.editedIndex, 1);
      this.closeDelete();
    },

    close() {
      this.dialog = false;
      this.$nextTick(() => {
        this.editedItem = Object.assign({}, this.defaultItem);
        this.editedIndex = -1;
      });
    },

    closeDelete() {
      this.dialogDelete = false;
      this.$nextTick(() => {
        this.editedItem = Object.assign({}, this.defaultItem);
        this.editedIndex = -1;
      });
    },

    save() {
      if (this.editedIndex > -1) {
        Object.assign(this.desserts[this.editedIndex], this.editedItem);
      } else {
        this.desserts.push(this.editedItem);
      }
      this.close();
    },
  },
};
</script>

<style lang="scss" scoped>
</style>