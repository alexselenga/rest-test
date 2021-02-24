<template>
  <v-app>
    <v-app-bar
      app
      color="secondary"
      dark
    >
      <div class="d-flex align-center">
        <v-img
          alt="Vuetify Logo"
          class="shrink mr-2"
          contain
          src="https://cdn.vuetifyjs.com/images/logos/vuetify-logo-dark.png"
          transition="scale-transition"
          width="40"
        />
        REST Тест
      </div>
    </v-app-bar>

    <v-main>
      <Contacts/>
    </v-main>
  </v-app>
</template>

<script>
import Contacts from './components/Contacts'

export default {
  components: {
    Contacts,
  },
}
</script>
