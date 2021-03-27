<template>
  <v-snackbar :color="color" v-model="snackbar">
    {{ text }}

    <template v-slot:action="{ attrs }">
      <v-btn text v-bind="attrs" @click="$emit('close-snackbar')">
        Fechar
      </v-btn>
    </template>
  </v-snackbar>
</template>
<script>
export default {
  name: "Snackbar",
  props: {
    snackbar: Boolean,
    color: String,
    text: String,
  },
};
</script>