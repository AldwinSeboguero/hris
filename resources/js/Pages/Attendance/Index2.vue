<template>
<v-container fluid class="pl-8 pt-6 pr-8"> 
  
<div v-if="$page.props.flash.success" class="temporary-bounce animate-pulse duration-500 ease-out bg-gradient-to-r from-green-600 to-green-500 shadow-lg mx-auto max-w-full text-sm pointer-events-auto bg-clip-padding rounded-md  mb-3" id="alert_message" role="alert" aria-live="assertive" aria-atomic="true" data-mdb-autohide="false">
    <div class="bg-gradient-to-r from-green-600 to-green-500 flex justify-between items-center py-2 px-3 bg-clip-padding  rounded-t-lg rounded-b-lg">
      <span class="font-bold text-white flex items-center">
        <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="check-circle" class="w-4 h-4 mr-2 fill-current" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
          <path fill="currentColor" d="M504 256c0 136.967-111.033 248-248 248S8 392.967 8 256 119.033 8 256 8s248 111.033 248 248zM227.314 387.314l184-184c6.248-6.248 6.248-16.379 0-22.627l-22.627-22.627c-6.248-6.249-16.379-6.249-22.628 0L216 308.118l-70.059-70.059c-6.248-6.248-16.379-6.248-22.628 0l-22.627 22.627c-6.248 6.248-6.248 16.379 0 22.627l104 104c6.249 6.249 16.379 6.249 22.628.001z"></path>
        </svg>
          {{ $page.props.flash.success }}</span>
        <div class="pull-right item-center">
        <p class="text-white opacity-90 text-xs">
            <v-icon class="white--text" small @click="">mdi-close-circle</v-icon>
        </p>
      </div>
    </div>
</div>
<div class="row">
    <!-- .page title -->
    <div class="col-lg-8 col-md-5 col-sm-6 col-xs-12 bg-title-left">
        <h4 class="page-title font-semibold font-sans row pb-2"><span class="col-sm-12 col-xs-12">Employees</span>
            <!-- <span class="text-primary p-l-10 m-l-5">{{seniorCitizens}}</span> 
            <span class="font-12 text-muted m-l-5">PWD(s)</span>
            <span class="text-info b-l p-l-10 m-l-5">{{seniorCitizensMale}}</span> 
            <span class="font-12 text-muted m-l-5">Male</span>
            <span class="b-l p-l-10 m-l-5 text-pink-400">{{seniorCitizensFemale}}</span> 
            <span class="font-12 text-muted m-l-5">Female</span>
            <span class="b-l p-l-10 m-l-5 text-black-400">{{seniorCitizensUnknown}}</span> 
            <span class="font-12 text-muted m-l-5">Unknown</span> -->
        </h4>
    </div>
    <!-- /.page title -->
    <!-- .breadcrumb -->
    <div class="col-lg-4 col-sm-6 col-md-7 col-xs-12 text-right bg-title-right">
    
    <v-menu
    transition="slide-x-transition"
      bottom
      
        right
        content-class="elevation-1"
        class="mr-12"
        :offset-y="offSet"
        >
        <template v-slot:activator="{ on, attrs }">
        <v-btn
        color="blue darken-3 font-weight-light text-capitalize"
        dark
        v-bind="attrs"
        v-on="on"
        depressed
        solo-inverted
        class=""
        small
        dark
        :loading="loading"
        >
        <v-icon
            left
            dark
        >
            fa fa-download
        </v-icon>
        Export
        <v-icon
            right
            dark
        >
            mdi-chevron-down
        </v-icon>
        </v-btn>
        </template>

        <v-list width="110"> 
                <downloadexcel
                  class            = "btn"
                  :fetch           = "fetchData"
                  :fields          = "json_fields"
                  type="csv"
                  :name="excelFilename"
                  :before-generate = "startDownload"
                  :before-finish   = "finishDownload">
                <v-list-item
                link
                active-class="orange--text text--accent-4 font-weight-bold "
                >
              
                  
                <v-icon small class="mr-2 success--text">fa fa-file-excel-o</v-icon>
                <span class="font-semibold ">CSV</span>
              
                </v-list-item>
                </downloadexcel>
                <v-list-item
                link
                active-class="orange--text text--accent-4 font-weight-bold"
                @click="generatePDF"
                >
               <v-icon small class="mr-2 red--text" >fa fa-file-pdf-o</v-icon>
               <span class="font-semibold ">PDF</span>

                </v-list-item>
                </v-list>
      
        </v-menu>
        
       

    </div>
   
    <!-- /.breadcrumb -->
    </div>
    <!-- <Headers title="PWDs - Registered"/> -->
    
    <Tables :searchParent="searchParent" :dateParent="dateParent" :emptypeParent="emptypeParent" @searchUpdated="handleSearchUpdated" @dateUpdated="handleDateUpdated" @emptypeUpdated="handleEmptypeUpdated" @empDivisionUpdated="handleEmpDivisionUpdated"/>
    <!-- <h5 class="pull-right hidden-sm hidden-md hidden-xs" v-if="!filterDrawers">
        <button class="btn btn-default btn-xs btn-circle btn-outline filter-section-close" @click.stop="filterDrawers = !filterDrawers"><v-icon small>{{ !filterDrawers ? 'mdi-filter-variant' : 'mdi-chevron-right' }}</v-icon></button>
    </h5> -->
    <v-navigation-drawer
      v-model="filterDrawers"
      floating
      right
      app
      class="grey lighten-4"
      color="#686868"
    >
    <h5 class="pull-left hidden-sm hidden-md hidden-xs">
        <button class="btn btn-default btn-xs btn-circle btn-outline filter-section-show" @click.stop="filterDrawers = !filterDrawers"><v-icon small>{{ filterDrawers ? 'mdi-chevron-right' : 'mdi-chevron-right' }}</v-icon></button>
    </h5>
    
    <div class="col-xs-12 mt-12 ml-2">
    <h5 class=""><i class="fa fa-sliders"></i> Filter Results</h5>
            <div class="form-group">
                
            <h5>Barangay</h5>

                <v-autocomplete
                        v-model="barangay"
                        :items="barangays"
                        class="mt-2 text-capitalize"
                        multiple  
                        small-chips
                        item-text="name"
                        item-value="id"
                        item-key="id"
                        outlined
                        dense
                        clearable
                        flat
                        background-color="#fff"
                        
                        hide-details
                    >
                        <template v-slot:no-data>
                        <v-list-item>
                            <v-list-item-title> Filter Per Barangay </v-list-item-title>
                        </v-list-item>
                        </template>
                        <template v-slot:selection="{ attr, on, item, selected,index }">
                        <v-chip
                            v-bind="attr"
                            :input-value="selected"
                            color="blue darken-1"
                            class="white--text"
                            v-on="on"
                            

                            @click:close="removeBarangay(item)"
                            small
                            v-if="index === 0"
                        >
                            <span class="truncate">{{item.name}}</span>
                        </v-chip>
                        <span
                        v-if="index === 1"
                        class="grey--text text-caption"
                        >
                        (+{{ barangay.length - 1 }} others)
                        </span>
                        </template>
                        <template v-slot:item="{ item }">
                        <v-list-item-content>
                            <v-list-item-title v-text="item.name"></v-list-item-title>
                        </v-list-item-content>
                        </template>
                </v-autocomplete>

            </div>
            <div class="form-group">
            <h5>Sitio</h5>
            <v-autocomplete
                          v-model="sitio"
                          :items="sitios"
                          class="mt-2 text-capitalize"
                          multiple  
                          chips
                          item-text="name"
                          item-value="id"
                          item-key="id"
                          outlined
                          dense
                          clearable
                          flat
                          background-color="#fff"
                          
                          hide-details
                        >
                          <template v-slot:no-data>
                            <v-list-item>
                              <v-list-item-title> Filter Per Sitio </v-list-item-title>
                            </v-list-item>
                          </template>
                          <template v-slot:selection="{ attr, on, item, selected,index }">
                        <v-chip
                            v-bind="attr"
                            :input-value="selected"
                            color="blue darken-1"
                            class="white--text"
                            v-on="on"
                            

                            @click:close="removeBarangay(item)"
                            small
                            v-if="index === 0"
                        >
                            <span class="truncate">{{item.name}}</span>
                        </v-chip>
                        <span
                        v-if="index === 1"
                        class="grey--text text-caption"
                        >
                        (+{{ sitio.length - 1 }} others)
                        </span>
                        </template>
                          <template v-slot:item="{ item }">
                            <v-list-item-content>
                              <v-list-item-title v-text="item.name"></v-list-item-title>
                            </v-list-item-content>
                          </template>
                    </v-autocomplete>
        </div>
        <div class="form-group">
                <h5>Age</h5>
                <v-range-slider
            v-model="range"
            :max="max_age"
            :min="min_age"
            hide-details
            class="align-center"
          >
            <template v-slot:prepend>
              <v-text-field
                :value="range[0]"
                class="mt-0 pt-0"
                hide-details
                single-line
                type="number"
                style="width: 60px"
                :min="60"
                @change="$set(range, 0, $event)"
              ></v-text-field>
            </template>
            <template v-slot:append>
              <v-text-field
                :value="range[1]"
                class="mt-0 pt-0"
                hide-details
                single-line
                type="number"
                :max="max_age"
                style="width: 60px"
                @change="$set(range, 1, $event)"
              ></v-text-field>
            </template>
          </v-range-slider>
        </div>
        <div class="form-group">
                <h5>Sex</h5>
                <v-select
                v-model="sx"
                :items="sxs"
                label=""
                dense
                outlined
                background-color="#fff"
                hide-details
                
                ></v-select>
        </div>
        <div class="form-group">
                <h5>Birthday</h5>
                <v-dialog
                    ref="dialog"
                    v-model="modal"
                    :return-value.sync="birthdate"
                    persistent
                    width="290px"
                >
                    <template v-slot:activator="{ on, attrs }">
                    <v-text-field
                        v-model="dateRangeText"
                        readonly
                        outlined
                        dense
                        hide-details
                        background-color="#fff"
                        v-bind="attrs"
                        v-on="on"
                    ></v-text-field>
                    </template>
                    <v-date-picker
                    v-model="birthdate"
                    scrollable
                    range
                    >
                    <v-spacer></v-spacer>
                    <v-btn
                        text
                        color="primary"
                        @click="modal = false"
                    >
                        Cancel
                    </v-btn>
                    <v-btn
                        text
                        color="primary"
                        @click="$refs.dialog.save(birthdate)"
                    >
                        OK
                    </v-btn>
                    </v-date-picker>
                </v-dialog>
        </div>
        <div class="form-group">
                <h5>Pension</h5>
               
                <v-select
                v-model="pension"
                :items="pensions"
                label=""
                dense
                outlined
                background-color="#fff"
                hide-details
                item-text="name"
                item-value="id"
                item-key="id"
                multiple
                small-chips
                >
                <template v-slot:selection="{ attr, on, item, selected,index }">
                        <v-chip
                            v-bind="attr"
                            :input-value="selected"
                            color="blue darken-1"
                            class="white--text pa-3"
                            v-on="on"
                            

                            @click:close="removeBarangay(item)"
                            small
                            v-if="index === 0"
                        >
                        <v-avatar left>
                        <v-img  :src="item.logo"></v-img>
                        </v-avatar>
                            <span class="truncate">{{item.code}}</span>
                        </v-chip>
                        <span
                        v-if="index === 1"
                        class="grey--text text-caption"
                        >
                        (+{{ pension.length - 1 }} others)
                        </span>
                        </template>
                          <template v-slot:item="{ item }">
                            <v-list-item-content>
                              <v-list-item-title>
                                <v-avatar left  size="30" class="mr-2">
                                <v-img  :src="item.logo"></v-img>
                                </v-avatar>
                                <span >{{item.name}}</span>
                              </v-list-item-title>
                            </v-list-item-content>
                          </template>
            </v-select>
        </div>
        <div class="form-group">
                <h5>Annual Income</h5>
                <v-select
                :items="annualincomes"
                label=""
                dense
                outlined
                background-color="#fff"
                hide-details
                item-text="name"
                item-value="id"
                item-key="id"
                clearable
                small-chips
                v-model="annualincome"
                >
                <template v-slot:selection="{ attr, on, item, selected,index }">
                        <v-chip
                            v-bind="attr"
                            :input-value="selected"
                            color="blue darken-1"
                            class="white--text pa-3"
                            v-on="on"
                            

                            @click:close="removeBarangay(item)"
                            small
                            v-if="index === 0"
                        >
                      
                            <span class="truncate">{{item.name}}</span>
                        </v-chip>
                        <span
                        v-if="index === 1"
                        class="grey--text text-caption"
                        >
                        (+{{ annualincome.length - 1 }} others)
                        </span>
                        </template>
                          <template v-slot:item="{ item }">
                            <v-list-item-content>
                              <v-list-item-title v-text="item.name"></v-list-item-title>
                            </v-list-item-content>
                          </template>
            </v-select>
        </div>
    </div>

    </v-navigation-drawer>
    <div class="mt-4" v-if="loading">
    <v-progress-circular indeterminate size="20"></v-progress-circular>
             <span style="margin-left: 10px; padding-top:20px;">{{loadingStatus}}</span>
        </div>

        <div class="mt-4" v-if="loadingComplete">
              <v-icon class=" green--text">mdi-check</v-icon>
             <span style="margin-left: 10px; padding-top:20px;">{{completeStatus}}</span>
        </div>
        <div class="mt-4" v-if="loadingError">
              <v-icon class=" red--text">mdi-alert</v-icon>
             <span style="margin-left: 10px; padding-top:20px;">{{errorStatus}}</span>
        </div>
</v-container>
</template>
<style>
    .temporary-bounce {
        -webkit-animation-iteration-count: 1;
        animation-iteration-count: 1;
    }
</style>

<script>
    import AppLayout from '@/Layouts/Layout'
    import Tables from './Component/Table'
    import Breadcrumbs from '@/Esitio/Breadcrumb'
    import Headers from '@/Esitio/Header'
    import debounce from "lodash/debounce";
    import { Inertia } from "@inertiajs/inertia";

    import JSZip from 'jszip';
    import { saveAs } from 'file-saver';
    import ExportJsonExcel from 'js-export-excel';
    import PDFMerger from 'pdf-merger-js';
    import downloadexcel from "vue-json-excel";
    import { GridLoader } from 'vue-spinners-css';

    export default {
        props:{
            seniorCitizens: 0,
            seniorCitizensMale: 0,
            seniorCitizensFemale: 0,
            seniorCitizensUnknown: 0,
            barangays: Array,
            sitios: Array,
        },
        data() {
            
            return {
              con:true,
              loadingComplete:false,
              completeStatus:'',
              loadingError:false,
              errorStatus:'',

              loadingStatus:'',
              emptypeParent: '',
              empdivisionParent: '',

              searchParent:'',
              dateParent:'',
              json_fields: {
                  'HCN' : 'hcn',
                  'NAME': 'name',
                  'AGE ': 'age',
                  'SEX' : 'sex',
                  'BIRTHDAY' : 'bday',
                  'PENSIONS' : 'pensions',
                  'ADDRESS' : 'address',
                },
                excelFilename:'',
                date:'',
                excelData: [],
                birthdate:[],
                modal: false,
                offSet: true,
                pension: [],
                annualincome:'',
                min_age: 0,
                max_age: 0,
                sx:'',
                sxs:['','Male','Female'],
                range: [],
                value: [],
                sitio: [],
                barangay: [],
                pensions:[],
                loading: false,
                annualincomes:[],
                filterDrawers: false,
                searchInput: "",
             }
         },
        components: {
            AppLayout,
            Tables,
            Breadcrumbs,
            Headers,
            downloadexcel,
            GridLoader,

        },
        filters: {
          formatMonthYear: function (value) {
            if (value) {
              const date = new Date(value);
              const month = date.toLocaleString('en-US', { month: 'long' });
              const year = date.getFullYear();
              return `${month}_${year}`;
            }
          }
        },
        watch: {
            searchInput: debounce(function (val) {
                console.log(val);
            }),
            barangay:debounce(function (val) {
                if(val.is_null){
                    console.log('empty_barangay');
                }
                axios
                    .get('/getSitio', {
                    params: { 
                        'barangay': this.barangay,
                    },
                    })
                    .then((response) => {
                    this.sitios = response.data.sitios;
                    });
                
            }),
            max_age: debounce(function (val) {
                console.log(val);
            }),

        },
        created(){
            // console.log(this.seniorCitizens);
            // setTimeout(() => document.getElementById("alert_message").classList.add("hidden"), 4000);
            // axios.get('/getMaxAge')
            // .then((response)=>{
            //     this.max_age = response.data.max_age;
            //     this.range = [this.min_age,this.max_age];
            // });
            // axios.get('/getAnnualIncomes')
            // .then((response)=>{
            //     this.annualincomes = response.data.annualincomes;
            // });
            // axios.get('/getPensions')
            // .then((response)=>{
            //     this.pensions = response.data.pensions;
            // });
        },
        computed: {
            dateRangeText () {
                return this.birthdate.join(' ~ ')
            },
        },
        layout: AppLayout,
        methods:{
          formatMonthYear: function (value) {
            if (value) {
              const date = new Date(value);
              const month = date.toLocaleString('en-US', { month: 'long' });
              const year = date.getFullYear();
              return `${month}_${year}`;
            }
          },
          handleDateUpdated(dtrDate) {
            this.dtrDateParent = dtrDate;
            console.log('Parent: '+this.dtrDateParent);
          },
          handleSearchUpdated(searchs) {
            this.searchParent = searchs;
            console.log('Parent: '+this.searchParent);

          },
          handleEmptypeUpdated(emptype) {
            this.emptypeParent = emptype;
            console.log('Parent: '+this.emptypeParent);

          },
          handleEmpDivisionUpdated(empDivision) {
            this.empdivisionParent = empDivision;
            console.log('Parent: '+this.empdivisionParent);

          },
          
          clean($val) {
          if($val){$val = $val.replace(/ +(?= )/g, "");
          $val = $val.replace(/[&\/\\#,+()$~%.'":*?<>{}]/g, " "); // Replaces all spaces with hyphens.
          $val = $val.replace(/ +(?= )/g, "");
          
          return $val;
          }
          // Removes special chars.
        },
          async generatePDF(){
              this.loading = true;
              this.loadingComplete=false;
              this.loadingError=false;


              this.completeStatus='';
              this.errorStatus='';

              console.log(this.emptypeParent)
              var zip = new JSZip();
              var merger = new PDFMerger();
              var option = {};
              
              var count = 1;
              var countData = 0;
              var totalData = 0;
              do {
                await axios
                .get(`/employees/show?page=` + count, {
                  params: { 
                    'per_page': 300,
                    'search': this.clean(this.searchParent),
                    'emptype' : this.clean(this.emptypeParent),
                    'empdivision' : this.empdivisionParent,

                    'dtrDate' : this.dateParent,
                  },
                })
                .then( async (response) => {
                  // console.log(pageNumber);
                  // this.filtersSitio = response.data.filtersSitio;
                  // this.constituents = response.data.employees.data;
                  // this.current_page= response.data.employees.current_page;
                  // this.total_pages= response.data.employees.total_pages;
                  totalData = response.data.employees.total;

                  if (response.data.employees.current_page <= response.data.employees.total_pages) {
                    var i;

                    for(i of response.data.employees.data){
                        var fileURL ='' ;
                        this.loadingStatus = "Genearating PDF Page "+response.data.employees.current_page+' ( '+countData+' out of '+ response.data.employees.total+" )";
                        this.downloadStatus20 = 'Downloading '+i.name+'....';
                        console.log(i.id);
                         await axios.get('/employees/generate',{responseType: 'blob',
                          timeout: 0,
                          params: {data: i.id, dtrDate: this.dtrDateParent}
                          }).then(async (response) => {

                                    fileURL  =  new Blob([response.data], {type: 'application/pdf'});
                                   countData++;
                                    
                        });
                        
                                    zip.file(i.lastname+'_'+i.firstname+'_'+i.employeeno+'_'+(this.dtrDateParent? this.formatMonthYear(this.dtrDateParent) : this.formatMonthYear(Date.now()))+'_'+".pdf", fileURL);
                                    
                        }
                        
                    this.con=true;
                    count++;
                  } else {
                    this.con=false;
                    count=1;
                    // this.loading = false;
                    if (totalData!=0) {
                      this.loadingComplete=true;
                      this.completeStatus="Download Complete!!!"+' ( '+countData+' out of '+ totalData+" )";
                    }
                   

                  }

                });
            } while (this.con);
            this.loading = false;

            var label = this.emptypeParent && this.empdivisionParent ? (this.emptypeParent +'_'+this.empdivisionParent) : (this.emptypeParent ? this.emptypeParent : this.empdivisionParent) ;
            var month = (this.dtrDateParent? this.formatMonthYear(this.dtrDateParent) : this.formatMonthYear(Date.now()));
            
            if (totalData != 0) {
              zip.generateAsync({type:"blob"})
                                    .then(function(content) {
                                        // see FileSaver.js
                                        saveAs(content, "DTR"+'_'+(label ? label+'_': '')+(month ? month+'_': '')+((Math.floor(Date.now() / 1)))+".zip");
                        });
            }
            else{
              this.loadingError=true;
              this.errorStatus="No Data Available";
            }
           
            
          },
        },
    }
</script>
<style scoped>

.v-text-field--outlined >>> fieldset {
  border-color: #e4e7ea;
}

.form-control{
    height: 36px;
}
</style>
<style>
    [type='text']:focus, [type='email']:focus, [type='url']:focus, [type='password']:focus, [type='number']:focus, [type='date']:focus, [type='datetime-local']:focus, [type='month']:focus, [type='search']:focus, [type='tel']:focus, [type='time']:focus, [type='week']:focus, [multiple]:focus, textarea:focus, select:focus{
    /*! outline: 2px solid transparent; */
    /*! outline-offset: 2px; */
    --tw-ring-inset: var(--tw-empty,/*!*/ /*!*/);
    --tw-ring-offset-width: 0px;
    --tw-ring-offset-color: #fff;
    --tw-ring-color: none;
    --tw-ring-offset-shadow: var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color);
    --tw-ring-shadow: var(--tw-ring-inset) 0 0 0 calc(1px + var(--tw-ring-offset-width)) var(--tw-ring-color);
    box-shadow: var(--tw-ring-offset-shadow), var(--tw-ring-shadow), var(--tw-shadow, 0 0 #0000);
    border-color: #2563eb;
    }
</style>
