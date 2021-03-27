<template>
  <div class="text-center">
    <v-dialog v-model="dialog" persistent width="500">
      <v-card>
        <v-card-title class="headline grey lighten-2">
          Alterar Status da Pergunta
        </v-card-title>

        <v-card-text class="d-flex align-center">
          Você deseja alterar o status da pergunta?
        </v-card-text>

        <v-divider></v-divider>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="error" text @click="$emit('cancel-change', task)"
            >Cancelar</v-btn
          >
          <v-btn color="primary" text @click="$emit('change-dimension', task)"
            >Confirmar</v-btn
          >
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
export default {
  name: "ConfirmDimensionChangeModal",
  props: {
    dialog: Boolean,
    task: Object,
  },
  data: () => ({}),
  created() {},
  methods: {},
};
</script>