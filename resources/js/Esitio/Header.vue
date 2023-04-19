<template>
    <div class="flex items-center divide-y divide-y-reverse divide-rose-400">
        <h1 class="mb-1 text-3xl font-sans">{{title}}</h1>
    </div>
    
</template>
<script>
     export default {
        props:{
            title: '',
        },
        data () {
            return {}
        }
    }
</script>