<template>
<v-container fluid class="pl-12 pt-10"> 
    <Headers title="Tables"/>
    <Breadcrumbs/>
    <Tables/>
   
</v-container>
</template>

<script>
    import AppLayout from '@/Layouts/Layout'
    import Tables from '@/Esitio/Table'
    import Breadcrumbs from '@/Esitio/Breadcrumb'
    import Headers from '@/Esitio/Header'



    export default {
        components: {
            AppLayout,
            Tables,
            Breadcrumbs,
            Headers,
        },
        layout: AppLayout,
    }
</script>
