<template>
  <v-app id="inspire" class="">
    
  <v-navigation-drawer
      v-model="drawer"
      width="220px"
      
      floating
      
      app
      
    >
    
      <template v-slot:prepend>
        <v-list-item dark class="elevation-2" style="max-height: 50px; background: linear-gradient(to right, #33691E, #33691E, #558B2F);">
          <!-- <v-list-item-avatar class="text-center" style="margin:0; margin-right:10px;" >
        
                  <v-icon dark large style="margin-left: 10px; padding-right:10px" >
                    mdi-account-circle
                  </v-icon>
          </v-list-item-avatar> -->

          <!-- <v-list-item-avatar class="text-center" size="30">
                   <v-img 
                        src="https://ucarecdn.com/cfc0cb71-3586-4c62-a210-432012de02a0/logov3.png"
                      />
         </v-list-item-avatar> -->

          <v-list-item-content>
            <v-list-item-title class="title text-wrap font-weight-bold" >HRMS</v-list-item-title>
            <!-- <v-list-item-subtitle class="caption">{{role.description}}</v-list-item-subtitle> -->
          </v-list-item-content>
          
        </v-list-item>
        
      </template>
     
  <div  v-slimscroll="scrollOptions">
  <v-list nav dense class="mt-0 pt-4">
          <v-list-item-group v-model="selectedItem" class="mt-0 pt-0">
            <template v-for="(item, i) in navigationList">
              <template v-if="item.children">
                <v-list-group
                  :key="i"
                  :value="isNav() == item.nav ? true : false"
                  color="grey lighten-2"
                  class="mt-0 pt-0"
                  active-class="light-green--text text--darken-4 font-weight-bold" 
                >
                  <template v-slot:activator>
                    <v-list-item-action style="margin-right: 10px">
                      <v-icon small >{{ item.icon }}</v-icon>
                    </v-list-item-action>
                    <v-list-item-content>
                      <v-list-item-title
                        class="caption font-weight-bold"
                      >
                        {{ item.text }} {{ item.role }}
                      </v-list-item-title>
                    </v-list-item-content>
                  </template>
                  <template v-for="(child, i) in item.children">
                    <v-list-item
                      
                      :key="i"
                      @click="$inertia.visit(route(child.link))"
                      link
                      active-class="light-green--text text--darken-4 font-weight-bold"
                      :class="
                        isUrl(child.link)
                          ? 'v-list-item--active v-list-item v-list-item--link theme--dark light-green--text text--darken-4 '
                          : ''
                      "
                    >
                      <!-- <v-list-item-action
                    v-if="child.icon"
                    style="margin-right: 10px"
                  >
                    <v-icon>{{ child.icon }}</v-icon>
                  </v-list-item-action> -->
                      <v-list-item-content class="pl-8">
                        <v-list-item-title
                          class="caption font-weight-bold"
                        >
                          {{ child.text }}
                        </v-list-item-title>
                      </v-list-item-content>
                    </v-list-item>

                  </template>
                  
                </v-list-group>
              </template>
              <template v-else>
                <v-list-item 
                  v-if="item.withAccess"
                  @click="$inertia.visit(route(item.link))"
                  :key="item.text"
                  link
                  active-class="light-green--text text--darken-4 font-weight-bold"
                  :class="
                      isUrl(item.link)
                        ? 'v-list-item--active v-list-item v-list-item--link theme--dark grey--text text--lighten-2'
                        : ''
                    "
                >
                  <!-- :class="isUrl('') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" -->
                  <v-list-item-action
                    style="margin-right: 10px"
                    :name="item.text"
                  >
                    <v-icon small>{{ item.icon }}</v-icon>
                  </v-list-item-action>
                  <v-list-item-content
                  >
                    <v-list-item-title
                      class="
                        caption
                        
                        text--darken-2
                        font-weight-bold
                      "
                    >
                      {{ item.text }}
                    </v-list-item-title>
                  </v-list-item-content>
                </v-list-item>
              </template>
            </template>
                  
            <v-list-item @click="logout">
            <v-list-item-action style="margin-right: 10px">
              <v-icon small>mdi-logout-variant</v-icon>
            </v-list-item-action>
            <v-list-item-content>
              <v-list-item-title class="caption   text--darken-2 font-weight-medium">
                Logout
              </v-list-item-title>
            </v-list-item-content>
          </v-list-item>
          </v-list-item-group>
        </v-list>
        
      
  </div>
  <template v-slot:append>
        <div class="pa-2">
         <v-card
          flat
          tile
          
          width="100%"
           style="background: transparent"
          class="overline  lighten-1 text-center ">
           <v-card-text class="caption">
            {{ new Date().getFullYear() }} &copy;
            <strong>ICTMO, Partido State University</strong>
          </v-card-text>
        </v-card>
        </div>
      </template>
    </v-navigation-drawer>

    


    <v-app-bar
      app
      
      class="white elevation-2"
      height="48"
      
      flat
      style="background: linear-gradient(to left, #33691E, #33691E, #558B2F);"
    >
      <v-app-bar-nav-icon @click.stop="drawer = !drawer" class="grey--text text--lighten-3 "></v-app-bar-nav-icon>

      <v-toolbar-title
        class="
          ml-0
          pl-0
          font-weight-medium
          light-green-grey--text
          text--darken-4 text-no-wrap
        "
      >
        <v-list-item class="mb-1">
          <v-list-item-avatar class="text-center ml-1" size="30">
            <!-- <v-icon dark large style="margin-left: 10px; padding-right:10px" >
                    
                  </v-icon> -->
            <v-img
              src="images/psu_logo.png"
            />
          </v-list-item-avatar>

          <v-list-item-content>
            <v-list-item-title class="caption text-wrap  white--text font-weight-bold"
              >Partido State University</v-list-item-title
            >
            <v-list-item-subtitle class="caption white--text">Goa, Camarines Sur</v-list-item-subtitle>
          </v-list-item-content>
        </v-list-item>
      </v-toolbar-title>

      <v-spacer></v-spacer>
      <div class="ml-3 relative">
        <jet-dropdown  align="right" width="48">
          <template #trigger>
            <button
              v-if="$page.props.jetstream.managesProfilePhotos"
              class="
                flex
                text-sm
                border-2 border-transparent
                rounded-full
                focus:outline-none focus:border-gray-300
                transition
                duration-150
                ease-in-out
              "
            >
              <img
                class="h-8 w-8 rounded-full object-cover"
                :src="$page.props.user.profile_photo_url"
                :alt="$page.props.user.name"
              />
            </button>

            <span v-else class="inline-flex rounded-md">
              <button
                type="button"
                class="
                  inline-flex
                  items-center
                  px-3
                  py-2
                  border border-transparent
                  text-sm
                  leading-4
                  font-medium
                  rounded-md
                  white--text
                  bg-white
                  hover:text-white
                  focus:outline-none
                  transition
                  ease-in-out
                  duration-150
                  transparent
                "
              >
                {{ $page.props.user.name }}

                <svg
                  class="ml-2 -mr-0.5 h-4 w-4"
                  xmlns="http://www.w3.org/2000/svg"
                  viewBox="0 0 20 20"
                  fill="currentColor"
                >
                  <path
                    fill-rule="evenodd"
                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                    clip-rule="evenodd"
                  />
                </svg>
              </button>
            </span>
          </template>

          <template #content>
            <!-- Account Management -->
            <div class="block px-4 py-2 text-xs text-gray-400">
              Manage Account
            </div>

            <jet-dropdown-link  :href="route('profile.show')">
              Profile
            </jet-dropdown-link>

            <jet-dropdown-link
              :href="route('api-tokens.index')"
              v-if="$page.props.jetstream.hasApiFeatures"
            >
              API Tokens
            </jet-dropdown-link>

            <div class="border-t border-gray-100"></div>

            <!-- Authentication -->
            <form @submit.prevent="logout">
              <jet-dropdown-link as="button"> Logout </jet-dropdown-link>
            </form>
          </template>
        </jet-dropdown>

        <!-- <jet-dropdown align="right" width="48">
          <template #trigger>
            <button
              v-if="$page.props.jetstream.managesProfilePhotos"
              class="
                flex
                text-sm
                border-2 border-transparent
                rounded-full
                focus:outline-none focus:border-gray-300
                transition
                duration-150
                ease-in-out
              "
            >
              <img
                class="h-8 w-8 rounded-full object-cover"
                :src="$page.props.user.profile_photo_url"
                :alt="$page.props.user.name"
              />
            </button>

            <span v-else class="inline-flex rounded-md">
              <span
                class="
                  inline-flex
                  items-center
                  px-3
                  py-2
                  border border-transparent
                  text-sm
                  leading-4
                  font-medium
                  rounded-md
                  text-gray-500
                  bg-white
                  focus:outline-none
                  transition
                  ease-in-out
                  duration-150"
              >
                You are currently using guest access (
                  <form @submit.prevent="logout">
                    <button class="underline text-sm text-light-green-600 hover:text-gray-900"> Login </button>
                  </form>
                )
              </span>
            </span>
          </template>
        </jet-dropdown> -->
      </div>
    </v-app-bar>
    <v-main class="#ddd bg-gray-50" color="#ddd">
      <div class="ma-0">
        <slot />
      </div>
    </v-main>
    
  </v-app>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue";
import JetDropdown from "@/Jetstream/Dropdown";
import JetDropdownLink from "@/Jetstream/DropdownLink";
import JetNavLink from "@/Jetstream/NavLink";
import JetResponsiveNavLink from "@/Jetstream/ResponsiveNavLink";

export default {
  components: {
    JetDropdown,
    JetDropdownLink,
    JetNavLink,
    JetResponsiveNavLink,
  },
  data() {
    // console.log(this.$page.props.auth.user.roles[0]);
    return {
      selectedItem: null,
      selectedItemChild: 1,
      dialog: false,
      drawer: null,
      mini: true,
      scrollOptions: {
        height: "100%",
      },
      navigationList: [
        {
          icon: "mdi-home-assistant",
          text: "Employees",
          link: "Employees",
          withAccess: true,
        //   withAccess: (this.$page.props.auth.user.roles[0]=='Admin' || this.$page.props.auth.user.roles[0]=='Guest') ? true :false,
        },
        
      ],
    };
  },
  methods: {
    logout() {
      this.$inertia.post(route("logout"));
    },

    isUrl(...urls) {
      let currentUrl = this.$page.url;

      if (urls[0] === "") {
        return currentUrl === "";
      }
      //  console.log(urls.filter((url) => currentUrl.startsWith(url)).length)
      return urls.filter((url) => currentUrl.startsWith(url)).length;
    },

    isNav() {
      let currentUrl = this.$page.url;

      //  console.log(urls.filter((url) => currentUrl.startsWith(url)).length)
      return currentUrl.split("-")[1];
    },
  },
  props: {
    user: Object,
  },
};
</script>
<style>
  .v-avatar{
    border-radius: 0%;
  }
</style>
