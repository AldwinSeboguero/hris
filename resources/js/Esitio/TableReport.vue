<template>
    <v-data-table
        :headers="headers"
        :items="reports"
        :items-per-page="10"
        class="elevation-1 mt-4 font-weight-light text-uppercase"
    >
        <template
        v-slot:top
        >   
        <div class="light-green darken-4 white--text pt-2 pb-2">
            <v-container>
                <v-row>
                    <v-col
                        cols="12"
                        lg="4"
                        class="mb-0 pb-0 mt-0 pt-0"
                        > 
                        <v-text-field 
                        v-model="search"
                        append-icon="mdi-magnify"
                        label="Search (Report Name)"
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
    </template> 
    <template v-slot:item.actions="{ item }">
        <template>
            <v-btn class="ma-2 pr-5 pl-4 text-center white--text" color="red" depressed small  @click="editItem(item)">
                <v-icon
                dark
                x-small
                class="pr-1"
                >
                mdi-file-pdf-box
                </v-icon>PDF
            </v-btn> 
        </template> 
        <template>
            <v-btn class="ma-2" color="success" depressed small @click="$inertia.visit(route('tables.view'))">
                <v-icon
                dark
                x-small
                class="pr-1"
                >
                mdi-file-excel
                </v-icon>CSV
            </v-btn> 
        </template> 
      </template> 
    </v-data-table>
</template>


<script>
  
  import { Inertia } from "@inertiajs/inertia";
  import debounce from "lodash/debounce";
    export default {
      watch: {
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
            .get(`/senior_citizens/registered/show?page=` + pageNumber, {
              params: { 
                'per_page': itemsPerPage,
                'barangay': this.barangay,
                'sitio': this.sitio,
                'search': this.clean(val),
              },
            })
            .then((response) => {
              console.log(pageNumber);
              this.options.page = 0;
              this.barangays = response.data.barangays;
              this.sitios = response.data.sitios;
              this.filtersBarangay = response.data.filtersBarangay;
              this.filtersSitio = response.data.filtersSitio;
              this.constituents = response.data.constituents.data;
              this.current_page= response.data.constituents.current_page;
              this.total_pages= response.data.constituents.total_pages;
              this.total= response.data.constituents.total;
            });
        }, 300),
        barangay: debounce(function (val) {
          const { page, itemsPerPage } = this.options;
          let pageNumber = page;
          axios
            .get(`/senior_citizens/registered/show?page=` + pageNumber, {
              params: { 
                'per_page': itemsPerPage,
                'barangay': val,
                'sitio': this.sitio,
                'search': this.clean(this.search),
              },
            })
            .then((response) => {
              console.log(pageNumber);
              this.options.page = 0;
              this.barangays = response.data.barangays;
              this.sitios = response.data.sitios;
              this.filtersBarangay = response.data.filtersBarangay;
              this.filtersSitio = response.data.filtersSitio;
              this.constituents = response.data.constituents.data;
              this.current_page= response.data.constituents.current_page;
              this.total_pages= response.data.constituents.total_pages;
              this.total= response.data.constituents.total;
            });
        }, 300),
        sitio: debounce(function (val) {
          const { page, itemsPerPage } = this.options;
          let pageNumber = page;
          axios
            .get(`/senior_citizens/registered/show?page=` + pageNumber, {
              params: { 
                'per_page': itemsPerPage,
                'barangay': this.barangay,
                'sitio': val,
                'search': this.clean(this.search),
              },
            })
            .then((response) => {
              console.log(pageNumber);
              this.options.page = 0;
              this.barangays = response.data.barangays;
              this.sitios = response.data.sitios;
              this.filtersBarangay = response.data.filtersBarangay;
              this.filtersSitio = response.data.filtersSitio;
              this.constituents = response.data.constituents.data;
              this.current_page= response.data.constituents.current_page;
              this.total_pages= response.data.constituents.total_pages;
              this.total= response.data.constituents.total;
            });
        }, 300),
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
        nextPage() {
          const { page, itemsPerPage } = this.options;
          let pageNumber = page;
          axios
            .get(`/senior_citizens/registered/show?page=` + pageNumber, {
              params: { 
                'per_page': itemsPerPage,
                'barangay': this.barangay,
                'sitio': this.sitio,
                'search': this.clean(this.search),
              },
            })
            .then((response) => {
              console.log(pageNumber);
              this.barangays = response.data.barangays;
              this.sitios = response.data.sitios;
              this.filtersBarangay = response.data.filtersBarangay;
              this.filtersSitio = response.data.filtersSitio;
              this.constituents = response.data.constituents.data;
              this.current_page= response.data.constituents.current_page;
              this.total_pages= response.data.constituents.total_pages;
              this.total= response.data.constituents.total;

            });
        },
      },

      data () {
      return {
        options: {},
        search: '',
        barangay: '',
        sitio: '',
        reports: Array,
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
            text: '#',
            align: 'start',
            sortable: false,
            value: 'id',
            class: 'blue     darken-4 white--text',
          },
          {
            text: 'Name',
            align: 'start',
            sortable: false,
            value: 'name',
            class: 'blue     darken-4 white--text',
          },
          { text: 'Actions', 
          sortable: false,
          value: 'actions',class: 'light-green darken-4 white--text', },
          { text: 'Status', 
          sortable: false,
          value: 'status',class: 'light-green darken-4 white--text', },
        ],

        reports: [
          {
            id: '1',
            name: 'PWD Indicators',
            status: '', 
          },
          {
            id: '2',
            name: 'PWD (Registered)',
            status: '', 
          },
          {
            id: '3',
            name: 'PWD (Not Registered)',
            status: '', 
          },
          {
            id: '4',
            name: 'Constituents Aged 59 and Above',
            status: '', 
          },
          {
            id: '5',
            name: 'Pensioners (SSS/GSIS)',
            status: '', 
          },
          {
            id: '6',
            name: 'Pensioners (DSWD)',
            status: '', 
          },
          {
            id: '7',
            name: 'Pensioners (Local Government)',
            status: '', 
          },
          
        ],
      }
    },
    }
</script>
<style>
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
    
</style>
