<template>
    <v-data-table
        :headers="headers"
        :items="constituents"
        :items-per-page="10"
        :page="current_page"
        :pageCount="total_pages"
        :server-items-length="total"
        :options.sync="options"
        class="elevation-1 mt-4 font-weight-light text-uppercase"
    >
        <template
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
    </template> 
    <template v-slot:item.actions="{ item }">
        <template>
            <v-btn class="ma-2 pr-5 pl-4 text-center" color="primary" depressed small  @click="editItem(item)">
                <v-icon
                dark
                x-small
                class="pr-1"
                >
                mdi-account-edit
                </v-icon>Edit
            </v-btn> 
        </template> 
        <template>
            <v-btn class="ma-2" color="success" depressed small @click="$inertia.visit(route('tables.view'))">
                <v-icon
                dark
                x-small
                class="pr-1"
                >
                mdi-eye
                </v-icon>View
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
            .get(`/constituents/59/show?page=` + pageNumber, {
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
            .get(`/constituents/59/show?page=` + pageNumber, {
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
            .get(`/constituents/59/show?page=` + pageNumber, {
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
            .get(`/constituents/59/show?page=` + pageNumber, {
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
            text: 'HCN',
            align: 'start',
            sortable: false,
            value: 'hcn',
            class: 'orange     darken-4 white--text',
          },
          { text: 'Name', 
            sortable: false,
            value: 'name',class: 'orange darken-4  white--text', },
          { text: 'Age', 
            sortable: false,
            value: 'age',class: 'orange darken-4  white--text', },
          { text: 'Sex', 
            sortable: false,
            value: 'sex',class: 'orange darken-4  white--text', },
          { text: 'Birthday', 
            sortable: false,
            value: 'bday',class: 'orange darken-4  white--text', },
          { text: 'Address', 
            sortable: false,
            value: 'address',class: 'orange darken-4 white--text', },
            { text: '', 
            sortable: false,
            value: 'actions',class: 'orange darken-4 white--text', },
        ],

        constituents: [
          {
            hcn: '51715101024',
            name: 'Seboguero, Aldwin R.',
            age: '98',
            sex: 'Male',
            bday: 'Aug 17, 1923',
            address: 'Matacla',
          },
          {
            hcn: '51715101024',
            name: 'Seboguero, Aldwin R.',
            age: '98',
            sex: 'Male',
            bday: 'Aug 17, 1923',
            address: 'Matacla',
          },
          {
            hcn: '51715101024',
            name: 'Seboguero, Aldwin R.',
            age: '98',
            sex: 'Male',
            bday: 'Aug 17, 1923',
            address: 'Matacla',
          },
          {
            hcn: '51715101024',
            name: 'Seboguero, Aldwin R.',
            age: '98',
            sex: 'Male',
            bday: 'Aug 17, 1923',
            address: 'Matacla',
          },
          {
            hcn: '51715101024',
            name: 'Seboguero, Aldwin R.',
            age: '98',
            sex: 'Male',
            bday: 'Aug 17, 1923',
            address: 'Matacla',
          },
          {
            hcn: '51715101024',
            name: 'Seboguero, Aldwin R.',
            age: '98',
            sex: 'Male',
            bday: 'Aug 17, 1923',
            address: 'Matacla',
          },
          {
            hcn: '51715101024',
            name: 'Seboguero, Aldwin R.',
            age: '98',
            sex: 'Male',
            bday: 'Aug 17, 1923',
            address: 'Matacla',
          },
          {
            hcn: '51715101024',
            name: 'Seboguero, Aldwin R.',
            age: '98',
            sex: 'Male',
            bday: 'Aug 17, 1923',
            address: 'Matacla',
          },
          {
            hcn: '51715101024',
            name: 'Seboguero, Aldwin R.',
            age: '98',
            sex: 'Male',
            bday: 'Aug 17, 1923',
            address: 'Matacla',
          },
          {
            hcn: '51715101024',
            name: 'Seboguero, Aldwin R.',
            age: '98',
            sex: 'Male',
            bday: 'Aug 17, 1923',
            address: 'Matacla',
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
