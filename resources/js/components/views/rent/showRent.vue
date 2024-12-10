<template>
    <div class="h-screen w-full bg-gradient-to-b from-gray-100 to-gray-300 dark:from-slate-900 dark:to-slate-800">
      <Navbar />
  
      <div class="p-6 flex flex-col items-center w-full">
        <div
          v-if="rent"
          class="max-w-4xl w-full bg-white dark:bg-slate-800 rounded-lg shadow-lg overflow-hidden"
        >
          <div class="relative">
            <img
              :src="getPhotoUrl(rent.photo_path)"
              alt="Bike Image"
              class="w-full h-96 object-cover"
            />
            <div
              class="absolute top-4 left-4 bg-black/60 text-white px-3 py-1 rounded"
            >
              {{ rent.bike.type_bike.name }}
            </div>
          </div>
  
          <div class="p-6">
            <h2 class="text-3xl font-bold text-gray-800 dark:text-gray-200">
              {{ rent.bike.name }}
            </h2>
            <p class="text-gray-600 dark:text-gray-400 mt-2">
              Year: {{ rent.bike.year }}
            </p>
            <p class="text-gray-600 dark:text-gray-400 mt-2">
              Color: <span class="capitalize">{{ rent.color }}</span>
            </p>
  
            <div
              class="flex justify-between items-center mt-6 text-gray-800 dark:text-gray-200"
            >
              <p class="text-xl font-semibold">Price: ${{ rent.price }}</p>
              <button
                class="bg-blue-600 text-white py-2 px-6 rounded-lg shadow-md hover:bg-blue-700 transition duration-300"
                @click="goBack"
              >
                Go Back
              </button>
            </div>
  
            <div class="mt-8">
              <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">
                Contact Information
              </h3>
              <p class="text-gray-600 dark:text-gray-400">
                Email: {{ rent.user.email }}
              </p>
            </div>
          </div>
        </div>
  
        <div
          v-else-if="loading"
          class="text-gray-700 dark:text-gray-300 text-lg font-semibold"
        >
          Loading...
        </div>
  
        <div v-else class="text-red-500 text-lg font-semibold">
          Failed to load rent details. Please try again.
        </div>
      </div>
    </div>
  </template>
  
  
  <script>
  import axios from "axios";
  import Navbar from "../../navbar/navbar.vue"; 
  
  export default {
    name: "showRent",
    components: {
      Navbar,
    },
    data() {
      return {
        rent: null,
        loading: true,
      };
    },
    methods: {
      async fetchRentDetails() {
        const rentId = this.$route.params.id;
        try {
          const response = await axios.get(`/api/rents/${rentId}`);
          this.rent = response.data;
          console.log(this.rent);
        } catch (error) {
          console.error("Error fetching rent details:", error);
          this.rent = null;
        } finally {
          this.loading = false;
        }
      },
      getPhotoUrl(photoPath) {
        return photoPath
          ? `http://127.0.0.1:8000/storage/${photoPath}`
          : "placeholder.jpg";
      },
      goBack() {
        this.$router.push({ path: "/" });
      },
    },
    mounted() {
      this.fetchRentDetails();
    },
  };
  </script>
  
  <style scoped>
  </style>
  