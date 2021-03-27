<template>
  <v-app id="wrapper">
    <v-container class="container">
      <v-row class="row">
        <h1>Dimensões</h1>
        <v-col class="d-flex justify-end pr-0">
          <v-btn depressed class="btns" @click="$router.push({ path: '/' })">
            Tarefas</v-btn
          >
          <v-btn
            depressed
            class="btns"
            color="primary"
            @click="createModal = true"
          >
            <v-icon left>mdi-plus</v-icon> Criar dimensão</v-btn
          >
        </v-col>
      </v-row>
      <v-row class="row main">
        <v-container v-if="dimensions.length">
          <v-row
            v-for="(dimension, i) in dimensions"
            :key="i"
            :class="isMobile ? 'border-row' : ''"
          >
            <v-col
              md="2"
              sm="2"
              xs="2"
              :class="
                isMobile
                  ? 'd-flex align-center justify-center'
                  : 'd-flex align-center justify-center border-row'
              "
              >{{ dimension.id }}
            </v-col>
            <v-col
              md="10"
              sm="10"
              xs="10"
              task
              :class="
                isMobile
                  ? 'd-flex align-center'
                  : 'd-flex align-center border-row'
              "
            >
              <v-col md="8" sm="6" xs="6">
                <span>{{ dimension.name }}</span>
              </v-col>
              <v-col
                md="4"
                sm="4"
                xs="4"
                :class="isMobile ? 'd-flex flex-column' : 'd-flex justify-end'"
              >
                <v-btn
                  depressed
                  v-if="isMobile"
                  color="primary"
                  class="border-zero"
                  @click="openEditModal(dimension)"
                  ><v-icon center>mdi-pencil</v-icon></v-btn
                >
                <v-btn
                  depressed
                  v-else
                  color="primary"
                  class="border-zero"
                  @click="openEditModal(dimension)"
                  >Editar</v-btn
                >
                <v-btn
                  depressed
                  v-if="isMobile"
                  color="error"
                  class="border-zero"
                  @click="openDeleteModal(dimension)"
                  ><v-icon center>mdi-delete</v-icon></v-btn
                >
                <v-btn
                  depressed
                  v-else
                  color="error"
                  @click="openDeleteModal(dimension)"
                  class="border-zero"
                  >Excluir</v-btn
                >
              </v-col>
            </v-col>
          </v-row>
        </v-container>
      </v-row>
    </v-container>
    <DeleteModal
      :obj="dimension"
      :dialog="deleteModal"
      @close-delete-modal="closeDeleteModal"
      @confirm-delete="deleteDimension($event)"
    />
    <CreateDimension
      :dialog="createModal"
      @cancel-create="closeCreateModal"
      @create-dimension="createADimension($event)"
    />
    <EditDimension
      :dialog="editModal"
      :dimension="dimension"
      @cancel-edit="closeEditModal"
      @edit-dimension="editADimension($event)"
    />
    <Loading :loading="loading"></Loading>
    <Snackbar
      :text="snackbarText"
      :snackbar="openSnackbar"
      :color="snackbarColor"
      @close-snackbar="openSnackbar = false"
    />
  </v-app>
</template>
<script>
import Loading from "../components/loading";
import Snackbar from "../components/snackbar";
import DeleteModal from "../components/dimensions/delete-dimension-modal.vue";
import CreateDimension from "../components/dimensions/create-dimension-modal.vue";
import EditDimension from "../components/dimensions/edit-dimension-modal.vue";
import {
  getDimensions,
  storeDimension,
  updateDimension,
  destroyDimension,
} from "../services/index";
export default {
  name: "Dimensions",
  components: {
    Loading,
    Snackbar,
    DeleteModal,
    CreateDimension,
    EditDimension,
  },
  data: () => ({
    isMobile: false,
    loading: false,
    deleteModal: false,
    createModal: false,
    editModal: false,
    openSnackbar: false,
    dimension: {},
    snackbarText: "",
    snackbarColor: "",
    dimensions: [],
  }),
  async created() {
    this.createResizeListeners();
    this.dimensions = this.$route.params.dimensions
      ? this.$route.params.dimensions
      : [];
    if (!this.dimensions.length) this.dimensions = await this.getDimensions();
  },
  methods: {
    createResizeListeners() {
      window.addEventListener("resize", () => {
        if (window.innerWidth <= 960) {
          this.isMobile = true;
        } else this.isMobile = false;
      });
      if (window.innerWidth <= 960) {
        this.isMobile = true;
      } else this.isMobile = false;
    },
    async getDimensions() {
      this.loading = true;
      let data = await getDimensions();
      this.loading = false;
      return data;
    },
    openEditModal(dimension) {
      this.dimension = dimension;
      this.editModal = true;
    },
    openDeleteModal(dimension) {
      this.dimension = dimension;
      this.deleteModal = true;
    },
    closeDeleteModal() {
      this.deleteModal = false;
    },
    closeEditModal() {
      this.editModal = false;
    },
    closeCreateModal() {
      this.createModal = false;
    },
    setSnackbar(text, color) {
      this.snackbarText = text;
      this.snackbarColor = color;
      this.openSnackbar = true;
    },
    async createADimension(dimension) {
      this.loading = true;
      let { success, error } = await storeDimension(dimension);
      if (success) this.setSnackbar(success, "success");
      if (error) this.setSnackbar(error, "error");
      this.dimensions = await this.getDimensions();
      this.createModal = false;
      this.loading = false;
    },
    async editADimension(dimension) {
      this.loading = true;
      let { success, error } = await updateDimension(dimension);
      if (success) this.setSnackbar(success, "success");
      if (error) this.setSnackbar(error, "error");
      this.dimensions = await this.getDimensions();
      this.editModal = false;
      this.loading = false;
    },
    async deleteDimension(dimension) {
      this.loading = true;
      let { success, error } = await destroyDimension(dimension.id);
      if (success) this.setSnackbar(success, "success");
      if (error) this.setSnackbar(error, "error");
      this.dimensions = await this.getDimensions();
      this.deleteModal = false;
      this.loading = false;
    },
  },
};
</script>
<style scoped>
h1 {
  color: #656565;
}
#wrapper {
  background-color: #cccccc;
}
.row {
  margin: 1em 0 0 0;
}
.btns {
  margin-left: 1em;
}
.container {
  height: 100%;
}
.main {
  background-color: #ffffff;
  min-height: 85%;
  border-style: solid;
  border-width: 1px;
  border-color: #bbbbbb;
  box-shadow: 0 6px 3px -3px #aaaaaa;
}
.border-row {
  border-style: solid;
  border-width: 2px;
  border-color: #bbbbbb;
}
.border-zero {
  border-radius: 0;
}
</style>