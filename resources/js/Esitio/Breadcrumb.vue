<template>
<v-breadcrumbs :items="breads" class="pl-0 pt-0 pb-2"> 
      <template v-slot:divider>
        <v-icon>mdi-chevron-right</v-icon>
      </template>
    </v-breadcrumbs>
</template>

<script>
  
    export default {
        
        data () {
      return {
        breads: [
            {
            text: 'Dashboard',
            disabled: false,
            href: 'breadcrumbs_dashboard',
            },
            {
            text: 'Link 1',
            disabled: false,
            href: 'breadcrumbs_link_1',
            },
            {
            text: 'Link 2',
            disabled: true,
            href: 'breadcrumbs_link_2',
            },
        ],
      }
    },
    }
</script>
<style>
    .v-breadcrumbs  a {
    color: orange;
    }
</style>
