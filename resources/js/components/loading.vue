<template>
  <v-layout class="row justify-center">
    <v-dialog
      v-model="loading"
      persistent
      fullscreen
      content-class="loading-dialog"
    >
      <v-container fill-height>
        <v-layout class="row justify-center align-center flex-column">
          <h1 class="color-loading">Carregando...</h1>
          <v-progress-circular
            indeterminate
            :size="70"
            :width="7"
            color="success"
          ></v-progress-circular>
        </v-layout>
      </v-container>
    </v-dialog>
  </v-layout>
</template>
<script>
export default {
  name: "Loading",
  props: {
    loading: Boolean,
  },
};
</script>
<style lang="scss">
.color-loading {
  color: #ffffff;
  stop-opacity: inherit;
}
.loading-dialog {
  background-color: rgba(0, 0, 0, 0.8);
}
td.img-table {
  cursor: pointer;
  user-select: none;
}
.progress {
  font-size: 20px;
  margin-top: -30px;
}
</style>