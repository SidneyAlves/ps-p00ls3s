<template>
  <div class="text-center">
    <v-dialog v-model="dialog" persistent width="800">
      <v-card>
        <v-card-title class="headline grey lighten-2" style="color: #656565">
          Editar Pergunta
        </v-card-title>

        <v-container>
          <v-text-field
            label="Nome"
            hide-details="auto"
            v-model="task.name"
          ></v-text-field>
          <v-divider class="pb-2"></v-divider>
          <v-row>
            <v-col
              md="2"
              sm="4"
              xs="12"
              class="d-flex justify-center align-center"
            >
              <span>Dimensão</span>
            </v-col>
            <v-col md="10" sm="8" xs="12">
              <v-select
                :items="selectDimension()"
                v-model="dimensionName"
              ></v-select>
            </v-col>
          </v-row>
        </v-container>

        <v-divider></v-divider>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="error" text @click="$emit('cancel-edit')"
            >Cancelar</v-btn
          >
          <v-btn color="primary" text @click="editTask">Confirmar</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
export default {
  name: "EditTask",
  props: {
    dialog: Boolean,
    task: Object,
    dimensions: Array,
  },
  data: () => ({
    dimensionName: "",
    text: "",
  }),
  created() {},
  methods: {
    selectDimension() {
      let dimension = [];
      this.dimensions.forEach((d) => {
        dimension.push(d.name);
      });
      return dimension;
    },
    editTask() {
      this.task.dimension_id = this.dimensions.find(
        (dimension) => dimension.name == this.dimensionName
      )?.id;

      this.$emit("edit-task", this.task);
    },
  },
};
</script>