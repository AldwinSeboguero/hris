<template>
<v-container fluid class="pl-12 pt-10"> 
<!-- <Headers title="Dashboard"/> -->
    <div class="flex items-center justify-between mb-3">
        <div class="flex items-center">
            <h1 class="mb-1 text-3xl font-bold font-sans">Dashboard</h1>
            <v-spacer></v-spacer>
        </div>
    </div>
    <div class=" h-full">
        <v-sheet
        color=" "
        min-height="500"
        class="pb-4 transparent"
        >
            <v-row class="">
                <v-col class="align-self-end " cols="12" sm="6" md="3">
                    <v-skeleton-loader class="ma-2" v-if="total_senior_firstLoad" :loading="total_senior_loading" type="list-item,card-heading,card-heading">

                    </v-skeleton-loader>
                    
                    <v-card v-else
                    class=" rounded-lg pa-2"
                    elevation="2"

                    >
                        <v-sheet
                        class="align-self-end
                        transparent
                        grey--text
                        text--darken-3
                        d-flex
                        flex-no-wrap
                        justify-space-between
                        "
                        >
                            <div>
                                <v-card-title class=" align-self-start">
                                    <span class=" font-semibold">PWD(s)</span>  
                                </v-card-title>    
                                <v-card-subtitle class=" mb-7">
                                    <span class="font-semibold text-3xl">{{Number(total_senior).toLocaleString()}} </span>
                                </v-card-subtitle>

                                <v-card-text class="pt-0 pb-4">
                                    <v-chip
                                    class=""
                                    small
                                    color=" accent-4"
                                    style="background-color: rgba(231, 227, 252, 0.6)"
                                    >
                                        <span
                                        color="#9155fd"
                                        class="pink--text text--accent-2 font-semibold"
                                        >
                                        Year 2022</span
                                    ></v-chip>
                                </v-card-text>
                            </div>
                            <v-spacer></v-spacer>
                            <div class="illustrator-img">
                            <!-- <v-img width="70" src="images/femalev2.png"> </v-img> -->
                            </div>
                        </v-sheet>
                    </v-card>
                </v-col>

                <v-col align-self="end" cols="12" sm="6" md="3">
                    <v-skeleton-loader class="ma-2" v-if="total_senior_registered_firstLoad" :loading="total_senior_registered_loading" type="list-item,card-heading,card-heading"></v-skeleton-loader>
                    <v-card v-else
                    class=" rounded-lg pa-2"
                    elevation="2"
                    >
                        <v-sheet
                        class="
                        transparent
                        grey--text
                        text--darken-3
                        d-flex
                        flex-no-wrap
                        justify-space-between
                        "
                        >
                            <div>
                                <v-card-title class=" align-self-start">
                                <span class=" font-semibold">Registered</span>  
                                </v-card-title>    
                                <v-card-subtitle class=" mb-7">
                                    <span class="font-semibold text-3xl">{{Number(total_senior_registered).toLocaleString()}} </span>
                                </v-card-subtitle>
                                <v-card-text class="pt-0 pb-4">
                                    <v-chip
                                    class=""
                                    small
                                    color=" accent-4"
                                    style="background-color: rgba(231, 227, 252, 0.6)"
                                    >
                                        <span
                                        color="#9155fd"
                                        class="blue--text text--accent-2 font-semibold"
                                        >
                                        Year 2022</span
                                        >
                                    </v-chip>
                                </v-card-text>
                            </div>
                            <v-spacer></v-spacer>
                            <div class="illustrator-img mb-2">
                            <!-- <v-img width="95" src="images/male.png"> </v-img> -->
                            </div>
                        </v-sheet>
                    </v-card>
                </v-col>

                <v-col class="align-self-end " cols="12" sm="6" md="3">
                     <v-skeleton-loader class="ma-2" v-if="total_senior_female_firstLoad" :loading="total_senior_female_loading" type="list-item,card-heading,card-heading"></v-skeleton-loader>

                    <v-card v-else
                    class=" rounded-lg pa-2"
                    elevation="2"

                    >
                        <v-sheet
                        class="align-self-end
                        transparent
                        grey--text
                        text--darken-3
                        d-flex
                        flex-no-wrap
                        justify-space-between
                        "
                        >
                            <div>
                                <v-card-title class=" align-self-start">
                                    <span class=" font-semibold">Female</span>  
                                </v-card-title>    
                                <v-card-subtitle class=" mb-7">
                                    <span class="font-semibold text-3xl">{{Number(total_senior_female).toLocaleString()}} </span>
                                </v-card-subtitle>

                                <v-card-text class="pt-0 pb-4">
                                    <v-chip
                                    class=""
                                    small
                                    color=" accent-4"
                                    style="background-color: rgba(231, 227, 252, 0.6)"
                                    >
                                        <span
                                        color="#9155fd"
                                        class="pink--text text--accent-2 font-semibold"
                                        >
                                        Year 2022</span
                                        >
                                    </v-chip>
                                </v-card-text>
                            </div>
                            <v-spacer></v-spacer>
                            <div class="illustrator-img">
                                <v-img width="70" src="images/femalev2.png"> </v-img>
                            </div>
                        </v-sheet>
                    </v-card>
                </v-col>

                <v-col align-self="end" cols="12" sm="6" md="3">
                <v-skeleton-loader class="ma-2" v-if="total_senior_male_firstLoad" :loading="total_senior_male_loading" type="list-item,card-heading,card-heading"></v-skeleton-loader>

                    <v-card v-else
                    class=" rounded-lg pa-2"
                    elevation="2"

                    >
                        <v-sheet
                        class="
                        transparent
                        grey--text
                        text--darken-3
                        d-flex
                        flex-no-wrap
                        justify-space-between
                        "
                        >
                            <div>
                                <v-card-title class=" align-self-start">
                                    <span class=" font-semibold">Male</span>  
                                </v-card-title>    
                                <v-card-subtitle class=" mb-7">
                                    <span class="font-semibold text-3xl">{{Number(total_senior_male).toLocaleString()}} </span>
                                </v-card-subtitle>
                                <v-card-text class="pt-0 pb-4">
                                    <v-chip
                                    class=""
                                    small
                                    color=" accent-4"
                                    style="background-color: rgba(231, 227, 252, 0.6)"
                                    >
                                        <span
                                        color="#9155fd"
                                        class="blue--text text--accent-2 font-semibold"
                                        >
                                        Year 2022</span
                                        >
                                    </v-chip>
                                </v-card-text>
                            </div>
                            <v-spacer></v-spacer>
                            <div class="illustrator-img mb-2">
                                <v-img width="95" src="images/male.png"> </v-img>
                            </div>
                        </v-sheet>
                    </v-card>
                </v-col>
            </v-row>

            <v-row class="mt-4">
               

                <v-col col="12" lg="12" xs="12" sm="12" class="">
                    
                    <v-skeleton-loader class="ma-2" v-if="senior_by_age_firstLoad" :loading="senior_by_age_loading" type="card-heading, image,image,list-item"></v-skeleton-loader>

                    <v-card class=" rounded-lg pa-2" v-else
                        elevation="2">
                        <v-card-title class="align-end pl-4 ma-1 pa-2 rounded-lg white--text elevation-2" style="max-height: 50px; background: linear-gradient(to right, #33691E, #33691E, #558B2F);">
                            <span class="font-semibold">PWD By Age</span>
                        </v-card-title>

                        <v-card-text>
                            <SeniorCitizenByAgeBar :datas_male="senior_by_age_male" :datas_female="senior_by_age_female"></SeniorCitizenByAgeBar>
                           
                        </v-card-text>
                    </v-card>
                </v-col>


            </v-row>

            <v-row class="mt-4">
              
                <v-col col="12" lg="12" class="">
                    <v-skeleton-loader class="ma-2" v-if="recently_registered_firstLoad" :loading="recently_registered_loading" type="card-heading, table"></v-skeleton-loader>

                    <v-card class=" rounded-lg pa-2" v-else
                        elevation="2">
                        <v-card-title class="align-end pl-4 ma-1 pa-2 rounded-lg white--text elevation-2" style="max-height: 50px; background: linear-gradient(to right, #33691E, #33691E, #558B2F);">
                            <span class="font-semibold">Recently Registered PWDs</span>
                        </v-card-title>

                        <v-card-text>
                            <v-simple-table>
                                <template v-slot:default>
                                <thead>
                                    <tr>
                                    <th class="text-left">
                                        HCN
                                    </th>
                                    <th class="text-left">
                                        Name
                                    </th>
                                    <th class="text-left">
                                        Sex
                                    </th>
                                    <th class="text-left">
                                        Age
                                    </th>
                                    <th class="text-left">
                                        Birthday
                                    </th>
                                    <th class="text-left">
                                        Address
                                    </th>
                                    <th class="text-left">
                                        Registration Date
                                    </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                    v-for="item in recently_registered.data"
                                    :key="item.name"
                                    >
                                    <td>{{ item.hcn }}</td>
                                    <td>{{ item.name }}</td>
                                    <td class="capitalize">{{ item.sex }}</td>
                                    <td>{{ item.age }}</td>
                                    <td>{{ item.bday }}</td>
                                    <td>{{ item.address }}</td>
                                    <td>{{ item.registration_date }}</td>
                                    </tr>
                                </tbody>
                                </template>
                            </v-simple-table>
                           
                        </v-card-text>
                    </v-card>
                </v-col>
            </v-row>
            

        </v-sheet>
    </div>
 
</v-container>
</template>

<script>
    import AppLayout from '@/Layouts/Layout'
    import Tables from '@/Esitio/Table'
    import Breadcrumbs from '@/Esitio/Breadcrumb'
    import Headers from '@/Esitio/Header'
    import SeniorCitizenByAgeBar from '../Charts/SeniorCitizenByAgeBar';



    export default {
        components: {
            AppLayout,
            Tables,
            Breadcrumbs,
            Headers,
            SeniorCitizenByAgeBar,
        },
        props:{
            

        },
        methods: {
        clean($val) {
          if($val){$val = $val.replace(/ +(?= )/g, "");
          $val = $val.replace(/[&\/\\#,+()$~%.'":*?<>{}]/g, " "); // Replaces all spaces with hyphens.
          $val = $val.replace(/ +(?= )/g, "");
          
          return $val;
          }
          // Removes special chars.
        },
        },
        data() {
            
            return {
            total_senior_male: 0,
            total_senior_female: 0,
            total_senior: 0,
            total_senior_registered:0,
            pensioners: Array,
            recently_registered: Object,
            senior_by_age_male: [],
            senior_by_age_female: [],

            //loading
            total_senior_male_loading: true,
            total_senior_female_loading: true,
            total_senior_loading: true,
            total_senior_registered_loading:true,
            pensioners_loading: true,
            recently_registered_loading: true,
            senior_by_age_male_loading: true,
            senior_by_age_female_loading: true,
            senior_by_age_loading: true,


            //firstLoad
            total_senior_male_firstLoad: true,
            total_senior_female_firstLoad: true,
            total_senior_firstLoad: true,
            total_senior_registered_firstLoad:true,
            pensioners_firstLoad: true,
            recently_registered_firstLoad: true,
            senior_by_age_male_firstLoad: true,
            senior_by_age_firstLoad: true,
            senior_by_age_female_firstLoad: true,

            selectedItem: null,
            seniors: [],
            seniorsLastPage: 0,
            loading: true,
            firstLoad: true,
            

             }
         },
        async created(){
            await axios.get(`/dashboard/getSeniorCount`, {
                params: { 
                'search': this.clean('a'),
                },
                })
                .then((response) => {
                
                this.total_senior =response.data.total_senior;
                this.total_senior_loading= false;
                this.total_senior_firstLoad=false;
            });
            await axios.get(`/dashboard/getSeniorRegisteredCount`, {
                params: { 
                'search': this.clean('a'),
                },
                })
                .then((response) => {
                
                this.total_senior_registered =response.data.total_senior_registered;
                this.total_senior_registered_loading= false;
                this.total_senior_registered_firstLoad=false;
            });
            await axios.get(`/dashboard/getSeniorMaleCount`, {
                params: { 
                'search': this.clean('a'),
                },
                })
                .then((response) => {
                
                this.total_senior_male =response.data.total_senior_male;
                this.total_senior_male_loading= false;
                this.total_senior_male_firstLoad=false;
            });
            await axios.get(`/dashboard/getSeniorFemaleCount`, {
                params: { 
                'search': this.clean('a'),
                },
                })
                .then((response) => {
                
                this.total_senior_female =response.data.total_senior_female;
                this.total_senior_female_loading= false;
                this.total_senior_female_firstLoad=false;
            });
            await axios.get(`/dashboard/getSeniorPensionerCount`, {
                params: { 
                'search': this.clean('a'),
                },
                })
                .then((response) => {
                
                this.pensioners =response.data.pensioners;
                this.pensioners_loading= false;
                this.pensioners_firstLoad=false;
            });
            await axios.get(`/dashboard/getSeniorPensionerCount`, {
                params: { 
                'search': this.clean('a'),
                },
                })
                .then((response) => {
                
                this.pensioners =response.data.pensioners;
                this.pensioners_loading= false;
                this.pensioners_firstLoad=false;
            });
            await axios.get(`/dashboard/getRecentlyRegistered`, {
                params: { 
                'search': this.clean('a'),
                },
                })
                .then((response) => {
                
                this.recently_registered =response.data.recently_registered;
                this.recently_registered_loading= false;
                this.recently_registered_firstLoad=false;
            });
            for (let index = 60; index <= 101; index++) {
                if (index==101) {
                    await axios.get(`/dashboard/getSeniorByAge`, {
                        params: { 
                        'age': index,
                        },
                        })
                        .then((response) => {
                        this.senior_by_age_male.push(response.data.male);
                        this.senior_by_age_female.push(response.data.female);
                        this.senior_by_age_loading= false;
                        this.senior_by_age_firstLoad=false;
                    });
                 }
                else{
                     await axios.get(`/dashboard/getSeniorByAge`, {
                        params: { 
                        'age': index,
                        },
                        })
                        .then((response) => {
                        this.senior_by_age_male.push(response.data.male);
                        this.senior_by_age_female.push(response.data.female);
                      
                    });
                }
            }
            console.log(this.senior_by_age_male)
            // this.senior_by_age_loading= false;
            // this.senior_by_age_firstLoad=false;
            // await axios.get(`/dashboard/getSeniorLastPage`, {
            //     params: { 
            //     'search': this.clean('a'),
            //     },
            //     })
            //     .then((response) => {
            //     console.log(response.data.last_page);
                
            //     // this.senior = response.data.senior;
            //     // this.searchLoading = false;
            //     this.seniorsLastPage =response.data.last_page;
            // });
            // for (let index = 1; index <= this.seniorsLastPage; index++) {
                    
            //         await axios.get(`/dashboard/getSenior?page=`+index, {
            //             params: { 
            //             'search': this.clean('ricafort'),
            //             },
            //             })
            //             .then((response) => {
            //             this.seniors.push(response.data.senior.data);
                      
            //         });
            // }
            // console.log(this.seniors)

            

        },
        layout: AppLayout,
    }
</script>
