<template>
  <div class="text-center">
    <v-dialog v-model="dialog" persistent width="500">
      <v-card>
        <v-card-title class="headline warning lighten-1">
          Exclusão
        </v-card-title>

        <v-card-text class="d-flex align-center">
          Tem certeza que deseja excluir o item atual?
        </v-card-text>

        <v-divider></v-divider>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="error" text @click="$emit('close-delete-modal', obj)"
            >Cancelar</v-btn
          >
          <v-btn color="primary" text @click="$emit('confirm-delete', obj)"
            >Confirmar</v-btn
          >
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
export default {
  name: "DeleteModal",
  props: {
    dialog: Boolean,
    obj: Object,
  },
  data: () => ({}),
  created() {},
  methods: {},
};
</script>