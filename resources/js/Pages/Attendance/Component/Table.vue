<template>
  <div>
  <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12 text-right bg-title-right">
  <div id="clients-table_filter" class="dataTables_filter">
    <label>Date: <input @input="emitDate" type="date" v-model="dtrDate" class="input-sm border-gray-600 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 border-solid mr-4" placeholder="" aria-controls="clients-table"></label>

    <label>Search: <input @input="emitSearch" type="search" v-model="search" class="input-sm border-gray-600 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 border-solid mr-4" placeholder="" aria-controls="clients-table"></label>
    <label>Type: 
    <select @change="emitEmptype" class="input-sm border-gray-600 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 border-solid mr-0" v-model="emptype" width="400">
          <option value="COS">COS</option>
          <option value="Job Order">Job Order</option>
          <option value="Casual">Casual</option>
          <option value="Temporary">Temporary</option>
          <option value="Permanent">Permanent</option>

        </select>
    </label>
  
  </div>
  </div>
    <v-data-table
        :headers="headers"
        :items="constituents"
        :items-per-page="10"
        :page="current_page"
        :pageCount="total_pages"
        :server-items-length="total"
        :options.sync="options"
        dense
        
        class="elevation-0 mt-0  font-light pa-0 font-sans text-uppercase"
    >
        <!-- <template
        v-slot:top
        >   
        <div class="orange darken-4 white--text pt-2 pb-2">
            <v-container>
                <v-row>
                    <v-col
                        class="mb-0 pb-0 mt-0 pt-0 mr-16"
                        cols="12"
                        lg="1">
                        <v-menu
                        bottom
                        content-class="elevation-1"
                        class="mr-12"
                        >
                        <template v-slot:activator="{ on, attrs }">
                        <v-btn
                        color="orange darken-3 font-weight-light text-capitalize"
                        dark
                        v-bind="attrs"
                        v-on="on"
                        depressed
                        solo-inverted
                        class="mt-2"
                        dark
                        >
                        <v-icon
                            left
                            dark
                        >
                            mdi-download
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

                        <v-list>
                        <v-list-item
                        link
                        active-class="orange--text text--accent-4 font-weight-bold"
                        >
                        <v-list-item-title>Excel</v-list-item-title>
                        </v-list-item>
                        <v-list-item
                        link
                        active-class="orange--text text--accent-4 font-weight-bold"
                        >
                        <v-list-item-title>PDF</v-list-item-title>
                        </v-list-item>
                        </v-list>
                        </v-menu>

                    </v-col>
                    <v-divider vertical dark class="mt-2 hidde-md-and-down"></v-divider>
                    <v-col
                    class="mb-0 pb-0 mt-0 pt-0"
                    cols="12"
                    lg="2">
                      <v-autocomplete
                          v-model="barangay"
                          :items="barangays"
                          class="mt-2 text-capitalize"
                          multiple  
                          allow-overflow
                          chips
                          item-text="name"
                          item-value="id"
                          item-key="id"
                          label="Barangay"
                          persistent-hint
                          solo-inverted
                          dense
                          clearable
                          flat
                          dark
                          hide-details
                        >
                          <template v-slot:no-data>
                            <v-list-item>
                              <v-list-item-title> Filter Per Barangay </v-list-item-title>
                            </v-list-item>
                          </template>
                          <template v-slot:selection="{ attr, on, item, selected }">
                            <v-chip
                              v-bind="attr"
                              :input-value="selected"
                              color="orange darken-1"
                              class="white--text "
                              v-on="on"
                              close
                              @click:close="removeBarangay(item)"
                              small
                            >
                              <span class="truncate">{{item.name}}</span>
                            </v-chip>
                          </template>
                          <template v-slot:item="{ item }">
                            <v-list-item-content>
                              <v-list-item-title v-text="item.name"></v-list-item-title>
                            </v-list-item-content>
                          </template>
                    </v-autocomplete>

                    </v-col>

                    <v-col
                        class="mb-0 pb-0 mt-0 pt-0"
                        cols="12"
                        lg="2">
                        <v-autocomplete
                          v-model="sitio"
                          :items="sitios"
                          class="mt-2 text-capitalize"
                          chips
                          solo-inverted
                          flat
                          dark
                          dense
                          hide-details
                          clearable
                          multiple
                          item-text="name"
                          item-value="id"
                          item-key="id"
                          label="Sitio"
                        >
                          <template v-slot:no-data>
                            <v-list-item>
                              <v-list-item-title> Search Sitio </v-list-item-title>
                            </v-list-item>
                          </template>
                          <template v-slot:selection="{ attr, on, item, selected }">
                            <v-chip
                              v-bind="attr"
                              :input-value="selected"
                              color="orange darken-1"
                              class="white--text"
                              v-on="on"
                              close
                              @click:close="removeSitio(item)"
                              small
                            >
                              <span class="truncate">{{item.name}}</span>
                            </v-chip>
                          </template>
                          <template v-slot:item="{ item }">
                            <v-list-item-content>
                              <v-list-item-title
                                >{{ item.name }}</v-list-item-title
                              >
                            </v-list-item-content>
                          </template>
                        </v-autocomplete>
                        
                    </v-col>

                    <v-col
                        class="mb-0 pb-0 mt-0 pt-0"
                        cols="12"
                        lg="2">
                        <v-select 
                        label="Select Status"
                        class="mb-0 pb-0 mt-2 pt-0 font-weight-light text-capitalize"
                        item-value="id"
                        item-text="name" 
                        solo-inverted
                        flat
                        dark
                        dense
                        hide-details
                        ></v-select>
                        
                    </v-col>

                    <v-col
                        cols="12"
                        lg="4"
                        class="mb-0 pb-0 mt-0 pt-0"
                        > 
                        <v-text-field 
                        v-model="search"
                        append-icon="mdi-magnify"
                        label="Search (HCN or Name)"
                        class="mb-0 pb-0 mt-2 pt-0 font-weight-light text-capitalize"
                        solo-inverted
                        flat
                        dark
                        dense
                        hide-details
                        ></v-text-field>
                    </v-col>
                </v-row>
            </v-container>
        </div>
    </template>  -->
    <template v-slot:item.status="{ item }">
      <template v-if="item.status == true">
      <v-chip
        color="success"
        x-small
        dark
      >Active</v-chip>
      </template>
    </template>
    <template v-slot:item.createdby="{ item }">
      <span class="">{{item.createdby}}</span>
    </template>
    <template v-slot:item.pensions="{ item }">
      <template  v-for="(pension, i) in item.pensions"
          >
          <v-tooltip
      
          color="light-green darken-4"
          bottom
        >
          <template v-slot:activator="{ on, attrs }">
            <v-btn
              icon
              v-bind="attrs"
              v-on="on"
              class="ma-1"
              x-small
            >
                <v-avatar
                  size="20px"
                  class="ma-0 pa-0"
                >
                  <img
                    :src="pension.logo"
                  >
                </v-avatar>
            </v-btn>
          </template>
          <span class="text-xs">{{pension.name}}</span>
        </v-tooltip>
          
      </template>
    </template>
    <template v-slot:item.actions="{ item }">
       
       <template>
           <!-- <v-btn class="ma-2" depressed small @click="$inertia.visit(route('tables.view'))">
               <v-icon
               x-small
               >
               fa fa-gears
               </v-icon>
           </v-btn>  -->
           <v-btn
               link
               @click="generate(item.id)"
               active-class="orange--text text--accent-4 font-weight-bold"
               icon
               >
               <v-icon small class="red--text">mdi-file-pdf</v-icon>
               </v-btn>
           <!-- <v-menu
           transition="slide-y-transition"
           
           
             left
           content-class="elevation-1 subtitle-2 text-xs"
           class="mr-12"
           :offset-y="offSet"
           >
               <template v-slot:activator="{ on, attrs }">
               <v-btn
               class="text--black darken-3 font-weight-light"
               
               v-bind="attrs"
               v-on="on"
               depressed
               icon
               >
               <v-icon
               x-small
               >
               fa fa-gears
               </v-icon>
               </v-btn>
               </template>

               <v-list width="180"> 
               <v-list-item
               link
               @click="generate(item.id)"
               active-class="orange--text text--accent-4 font-weight-bold"
               >
               <v-icon small class="mr-2 red--text">mdi-file-pdf</v-icon>Generate
               </v-list-item>
               
               </v-list>
           </v-menu> -->
       </template> 
     </template> 
    </v-data-table>
</div>
</template>


<script>
  
  import { Inertia } from "@inertiajs/inertia";
  import debounce from "lodash/debounce";

import JSZip from 'jszip';
import { saveAs } from 'file-saver';
import ExportJsonExcel from 'js-export-excel';
import PDFMerger from 'pdf-merger-js';
    export default {
      props:{
        barangay: Array,
        sitio:Array,
        min_age: 0,
        max_age: 0,
        sx: String,
        birthday:Array,
        pension:Array,
        annualincome: 0,
        emptypeParent:'',
        dateParent:'',
        searchParent:'',
      },
      watch: {
        barangayy: function (newValue, oldValue) {
          console.log("newValue: %s, previousValue: %s", newValue, oldValue);
        },
        options: {
          handler() {
            this.nextPage();
          },
          deep: true,
        },
        search: debounce(function (val) {
          const { page, itemsPerPage } = this.options;
          let pageNumber = page;
          axios
            .get(`/attendances/show?page=` + pageNumber, {
              params: { 
                'per_page': itemsPerPage,
                'search': this.clean(this.search),
                'emptype': this.emptype,
              },
            })
            .then((response) => {
              console.log(pageNumber);
              this.barangays = response.data.barangays;
              this.sitios = response.data.sitios;
              this.filtersBarangay = response.data.filtersBarangay;
              this.filtersSitio = response.data.filtersSitio;
              this.constituents = response.data.employees.data;
              this.current_page= 1;
              this.total_pages= response.data.employees.total_pages;
              this.total= response.data.employees.total;

            });
        }, 300),
        emptype: debounce(function (val) {
          const { page, itemsPerPage } = this.options;
          let pageNumber = page;
          axios
            .get(`/attendances/show?page=` + pageNumber, {
              params: { 
                'per_page': itemsPerPage,
                'emptype': val,
                'search' : this.clean(this.search),
              },
            })
            .then((response) => {
              console.log(pageNumber);
              this.barangays = response.data.barangays;
              this.sitios = response.data.sitios;
              this.filtersBarangay = response.data.filtersBarangay;
              this.filtersSitio = response.data.filtersSitio;
              this.constituents = response.data.employees.data;
              this.current_page= 1;
              this.total_pages= response.data.employees.total_pages;
              this.total= response.data.employees.total;

            });
        }, 300),
       
        
      },
      methods: {
        async emitDate() {
          await this.$emit('dateUpdated', this.dtrDate);
        },  
        async emitSearch() {
          await this.$emit('searchUpdated', this.search);

        },  
        async emitEmptype() {
          await this.$emit('emptypeUpdated', this.emptype);
        },       
        view($val){
          // console.log($item);
          Inertia.get(
            "/senior_citizens/view",
            { senior: $val },
            {
              preserveState: true,
              preserveScroll: true,
              replace: true,
            }
          );
        },

        async generate($val){

              // this.loadingG12 = true;
              // var zip = new JSZip();
              var merger = new PDFMerger();
              var option = {};
              var i;

                var fileURL ='' ;
                var count = 0;
              await axios.get('/attendances/generate',{responseType: 'blob',
                      timeout: 0,
                      params: {data: $val, dtrDate: this.dtrDate}
                    

                      }).then((response) => {

                        
                      var fileURL = window.URL.createObjectURL(new Blob([response.data], {type: 'application/pdf'}));
                      var fileLink = document.createElement('a');
                      // fileLink.setAttribute('target', '_blank');
                      fileLink.href = fileURL;
                      fileLink.setAttribute('download', 'download'+'.pdf');
                      document.body.appendChild(fileLink);
                      window.open(fileLink.href,'_blank');
                      // this.loadingG12 = false;

                  });
            //   this.loadingCA019 = false;
            //   this.downloadStatusG12 = 'Download Complete!!';

            //   console.log('finish download');      
            // this.g12Data = [];

            },
        // generate($val){
        //   // console.log($item);
        //   Inertia.get(
        //     "/attendance/generate",
        //     { id: $val },
        //     {
        //       preserveState: true,
        //       preserveScroll: true,
        //       replace: true,
        //     }
        //   );
        // },
        clean($val) {
          if($val){$val = $val.replace(/ +(?= )/g, "");
          $val = $val.replace(/[&\/\\#,+()$~%.'":*?<>{}]/g, " "); // Replaces all spaces with hyphens.
          $val = $val.replace(/ +(?= )/g, "");
          
          return $val;
          }
          // Removes special chars.
        },
        nextPage() {
          console.log(this.max);
          const { page, itemsPerPage } = this.options;
          let pageNumber = page;
          axios
            .get(`/attendances/show?page=` + pageNumber, {
              params: { 
                'per_page': itemsPerPage,
                'search': this.clean(this.search),
                'emptype' : this.clean(this.emptype),
                'dtrDate' : this.dtrDate,
              },
            })
            .then((response) => {
              console.log(pageNumber);
              this.barangays = response.data.barangays;
              this.sitios = response.data.sitios;
              this.filtersBarangay = response.data.filtersBarangay;
              this.filtersSitio = response.data.filtersSitio;
              this.constituents = response.data.employees.data;
              this.current_page= response.data.employees.current_page;
              this.total_pages= response.data.employees.total_pages;
              this.total= response.data.employees.total;

            });
        },
      },

      data () {
      return {
        options: {},
        search: '',
        emptype:'',
        dtrDate:'',
        // barangay: this.barangay,
        offSet: true,
        constituents: Array,
        barangays: [],
        sitios: [],
        filtersBarangay: Array,
        filtersSitio: Array,
        current_page: 0,
        total_pages: 0,
        total: 0,
        exportList: [
            { title: 'Excel' },
            { title: 'PDF' },
        ],
        
        headers: [
          {
            text: 'Employee No.',
            align: 'start',
            sortable: true,
            value: 'employeeno',
            class: 'light-green darken-4 white--text',
          },
          { text: 'Last Name', 
            sortable: false,
            value: 'lastname',class: 'light-green darken-4  white--text', },
          { text: 'First Name', 
            sortable: false,
            value: 'firstname',class: 'light-green darken-4  white--text', },
          { text: 'Middle Name', 
            sortable: false,
            value: 'middlename',class: 'light-green darken-4  white--text', },
          { text: 'Type', 
            sortable: false,
            value: 'emptype',class: 'light-green darken-4  white--text', },
          { text: 'Position', 
            sortable: false,
            value: 'cposition',class: 'light-green darken-4 white--text', },
            { text: 'Department', 
            sortable: false,
            value: 'department',class: 'light-green darken-4 white--text', },
            
            { text: '', 
            sortable: false,
            value: 'actions',class: 'light-green darken-4 white--text', },
        ],

        constituents: [
        ],
      }
    },
    }
</script>
<!-- <style>
    [type="text"], [type="email"], [type="url"], [type="password"], [type="number"], [type="date"], [type="datetime-local"], [type="month"], [type="search"], [type="tel"], [type="time"], [type="week"], [multiple], textarea, select{
        background-color: transparent;
    }
    .v-select__selections {
      overflow: scroll;
      flex-wrap: nowrap;
    }
    .v-chip {
      overflow: initial;

    }
    
</style> -->
<!-- <style>
table th + th { border-left:1px solid #dddddd; }
table td + td { border-left:1px solid #dddddd; }

</style> -->
