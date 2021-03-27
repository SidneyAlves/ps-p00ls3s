<template>
  <v-app id="wrapper">
    <v-container class="container">
      <v-row class="row">
        <h1>Tarefas</h1>
        <v-col class="d-flex justify-end pr-0">
          <v-btn
            depressed
            class="btns"
            @click="
              $router.push({
                name: 'Dimensions',
                params: { dimensions },
              })
            "
          >
            Dimensões</v-btn
          >
          <v-btn
            depressed
            class="btns"
            color="primary"
            @click="createModal = true"
          >
            <v-icon left>mdi-plus</v-icon> Criar pergunta</v-btn
          >
        </v-col>
      </v-row>
      <v-row class="row main">
        <v-container v-if="tasks.length">
          <v-row>
            <v-col cols="1" class="d-flex justify-center align-center"
              ><span>Filtro</span></v-col
            >
            <v-col md="2" sm="4" xs="8" class="d-flex align-center"
              ><v-select
                :items="dimensionsInTasks"
                v-model="filterDimension"
                outlined
              ></v-select
            ></v-col>
          </v-row>
          <v-row
            v-for="(task, i) in filteredTasks"
            :key="i"
            :class="isMobile ? 'border-row' : ''"
          >
            <v-col md="1" xs="6" class="d-flex align-center justify-center">
              <v-checkbox
                color="success"
                v-model="task.active"
                @click="openChangeDimensionModal(task)"
              ></v-checkbox>
            </v-col>
            <v-col
              md="2"
              sm="6"
              xs="6"
              :class="
                isMobile
                  ? 'd-flex align-center justify-center'
                  : 'd-flex align-center justify-center border-row'
              "
              >{{ task.dimension_name }}
            </v-col>
            <v-col
              md="9"
              xs="12"
              :class="
                isMobile
                  ? 'd-flex align-center'
                  : 'd-flex align-center border-row'
              "
            >
              <v-col cols="8">
                <span>{{ task.name }}</span>
              </v-col>
              <v-col
                md="4"
                sm="4"
                xs="12"
                :class="isMobile ? 'd-flex flex-column' : 'd-flex justify-end'"
              >
                <v-btn
                  depressed
                  v-if="isMobile"
                  color="primary"
                  class="border-zero"
                  @click="openEditModal(task)"
                  ><v-icon center>mdi-pencil</v-icon></v-btn
                >
                <v-btn
                  depressed
                  v-else
                  color="primary"
                  class="border-zero"
                  @click="openEditModal(task)"
                  >Editar</v-btn
                >
                <v-btn
                  depressed
                  v-if="isMobile"
                  color="error"
                  class="border-zero"
                  @click="openDeleteModal(task)"
                  ><v-icon center>mdi-delete</v-icon></v-btn
                >
                <v-btn
                  depressed
                  v-else
                  color="error"
                  @click="openDeleteModal(task)"
                  class="border-zero"
                  >Excluir</v-btn
                >
              </v-col>
            </v-col>
          </v-row>
        </v-container>
      </v-row>
    </v-container>
    <ConfirmDimensionChangeModal
      @cancel-change="cancelChange($event)"
      @change-dimension="changeDimension($event)"
      :dialog="dialog"
      :task="task"
    />
    <DeleteModal
      :obj="task"
      :dialog="deleteModal"
      @close-delete-modal="closeDeleteModal"
      @confirm-delete="deleteTask($event)"
    />
    <CreateTask
      :dialog="createModal"
      :dimensions="dimensions"
      @cancel-create="closeCreateModal"
      @create-task="createTask($event)"
    />
    <EditTask
      :dialog="editModal"
      :dimensions="dimensions"
      :task="task"
      @cancel-edit="closeEditModal"
      @edit-task="editTask($event)"
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
import ConfirmDimensionChangeModal from "../components/tasks/confirm-dimension-change-modal";
import DeleteModal from "../components/tasks/delete-task-modal";
import CreateTask from "../components/tasks/create-task-modal";
import EditTask from "../components/tasks/edit-task-modal";
import Loading from "../components/loading";
import Snackbar from "../components/snackbar";
import { unique } from "../utils/index";
import {
  getDimensions,
  getTasks,
  storeTask,
  updateTask,
  destroyTask,
} from "../services";

export default {
  name: "index",
  components: {
    ConfirmDimensionChangeModal,
    DeleteModal,
    CreateTask,
    EditTask,
    Loading,
    Snackbar,
  },
  data: () => ({
    isMobile: false,
    loading: false,
    dialog: false,
    deleteModal: false,
    createModal: false,
    editModal: false,
    openSnackbar: false,
    dimensions: [],
    filterDimension: "Todos",
    task: {},
    tasks: [],
    snackbarText: "",
    snackbarColor: "",
  }),
  async created() {
    this.createResizeListeners();
    this.dimensions = await this.getDimensions();
    this.tasks = (await this.getTasks()) || [];
  },
  computed: {
    filteredTasks() {
      let aux = [];
      this.filterDimension == "Todos"
        ? (aux = this.tasks)
        : (aux = this.tasks.filter(
            (task) => task.dimension_name == this.filterDimension
          ));
      return aux;
    },
    dimensionsInTasks() {
      let dimensions = [];
      this.tasks.forEach((task) => {
        dimensions.push(task.dimension_name);
      });
      dimensions.unshift("Todos");
      return dimensions.filter(unique);
    },
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
    async getTasks() {
      this.loading = true;
      let data = await getTasks();
      this.loading = false;
      return data;
    },
    openChangeDimensionModal(task) {
      this.task = task;
      this.dialog = true;
    },
    openEditModal(task) {
      this.task = task;
      this.editModal = true;
    },
    openDeleteModal(task) {
      this.task = task;
      this.deleteModal = true;
    },
    cancelChange(t) {
      this.dialog = false;
      this.tasks.find((task) => t.id == task.id).active = !t.active;
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
    async changeDimension(task) {
      this.loading = true;
      let { success, error } = await updateTask(task);
      if (success) this.setSnackbar(success, "success");
      if (error) this.setSnackbar(error, "error");
      this.tasks = await this.getTasks();
      this.dialog = false;
      this.loading = false;
    },
    async createTask(task) {
      this.loading = true;
      let { success, error } = await storeTask(task);
      if (success) this.setSnackbar(success, "success");
      if (error) this.setSnackbar(error, "error");
      this.tasks = await this.getTasks();
      this.createModal = false;
      this.loading = false;
    },
    async editTask(task) {
      this.loading = true;
      let { success, error } = await updateTask(task);
      if (success) this.setSnackbar(success, "success");
      if (error) this.setSnackbar(error, "error");
      this.tasks = await this.getTasks();
      this.editModal = false;
      this.loading = false;
    },
    async deleteTask(task) {
      this.loading = true;
      let { success, error } = await destroyTask(task.id);
      if (success) this.setSnackbar(success, "success");
      if (error) this.setSnackbar(error, "error");
      this.tasks = await this.getTasks();
      this.deleteModal = false;
      this.loading = false;
    },
  },
  watch: {},
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