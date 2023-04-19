<template>

  <div class="min-h-screen flex flex-col sm:justify-center items-center pt-8 sm:pt-0 bg-gray-100">
    <div
      class="
        min-h-screen
        flex flex-col
        sm:justify-center
        items-center
      
        bg-gray-100
      "
    >
      <div>
        <slot name="logo" />
      </div>

      <div
        class="
          w-full
          mt-6
          px-6
          py-4
          bg-white
          shadow-md
          overflow-hidden
          sm:rounded-lg
        "
      >
        <slot />
      </div>
      <v-row class="mt-2 d-flex justify-center">
        <v-col cols="12">
          <v-card class="d-flex justify-center transparent mb-2" flat tile>
            <!-- <v-avatar class="ma-2">
              <v-img src="images/lgu_goa_logo.png" alt="e-SITIO Logo" />
            </v-avatar> -->

            <!-- <v-avatar class="ma-2">
              <v-img src="images/psu_logo.png" alt="e-SITIO Logo" />
            </v-avatar> -->
            <!-- <v-avatar class="ma-2">
              <v-img src="images/ictmo_logo.png" alt="e-SITIO Logo" />
            </v-avatar> -->
          </v-card>
          <p class="text-center grey--text">
            {{ new Date().getFullYear() }} &copy; <strong>ICTMO</strong><br />
            <span>Partido State University</span>
          </p>
        </v-col>
      </v-row>
    </div>
  </div>
</template>
