<template>
  <div class="h-screen w-full bg-slate-200 dark:bg-slate-900 flex">
    <!-- Sidebar -->
    <div class="bg-white dark:bg-slate-800 p-4 w-80 shadow-md h-full">
      <h2 class="text-xl font-bold mb-4 text-gray-800 dark:text-gray-200">Filters</h2>
      <div class="space-y-4">
        <div>
          <label for="brand" class="block text-gray-700 dark:text-gray-400">Brand</label>
          <select v-model="filters.brand_id" id="brand" class="w-full p-2 rounded border">
            <option value="">All</option>
            <option v-for="brand in brands" :key="brand.id" :value="brand.id">{{ brand.name }}</option>
          </select>
        </div>
        <div>
          <label for="type" class="block text-gray-700 dark:text-gray-400">Bike Type</label>
          <select v-model="filters.type_bike_id" id="type" class="w-full p-2 rounded border">
            <option value="">All</option>
            <option v-for="type in types" :key="type.id" :value="type.id">{{ type.name }}</option>
          </select>
        </div>
        <div>
          <label for="price_min" class="block text-gray-700 dark:text-gray-400">Min Price</label>
          <input
            type="number"
            v-model="filters.price_min"
            id="price_min"
            class="w-full p-2 rounded border"
            placeholder="Min Price"
          />
        </div>
        <div>
          <label for="price_max" class="block text-gray-700 dark:text-gray-400">Max Price</label>
          <input
            type="number"
            v-model="filters.price_max"
            id="price_max"
            class="w-full p-2 rounded border"
            placeholder="Max Price"
          />
        </div>
        <button
          class="w-full mt-4 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
          @click="applyFilters"
        >
          Apply Filters
        </button>
      </div>
    </div>

    <!-- Main Content -->
    <div class="flex-grow p-4">
      <navbar />

      <!-- Rents -->
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        <div
          v-for="rent in rents"
          :key="rent.id"
          class="bg-white dark:bg-slate-800 rounded-md shadow p-4"
        >
          <img
            :src="getPhotoUrl(rent.photo_path)"
            alt="Bike Image"
            class="w-full h-40 object-cover rounded"
          />
          <h3 class="text-lg font-semibold mt-2 text-gray-800 dark:text-gray-200">
            {{ rent.bike.name }}
          </h3>
          <p class="text-gray-600 dark:text-gray-400">Year: {{ rent.bike.year }}</p>
          <p class="text-gray-600 dark:text-gray-400">Price: ${{ rent.price }}</p>
          <p class="text-gray-600 dark:text-gray-400">Type: {{ rent.bike.type_bike.name }}</p>
          <button class="mt-2 w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">
            Rent Now
          </button>
        </div>
      </div>

      <!-- Pagination -->
      <div class="mt-4 flex justify-center items-center">
        <button
          class="px-4 py-2 bg-gray-300 text-gray-700 rounded-l disabled:opacity-50"
          :disabled="page === 1"
          @click="changePage(page - 1)"
        >
          Previous
        </button>
        <span class="px-4">{{ page }}</span>
        <button
          class="px-4 py-2 bg-gray-300 text-gray-700 rounded-r disabled:opacity-50"
          :disabled="!nextPage"
          @click="changePage(page + 1)"
        >
          Next
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import navbar from "../navbar/navbar.vue";
import axios from "axios";

export default {
  name: "Home",
  components: {
    navbar,
  },
  data() {
    return {
      rents: [],
      brands: [],
      types: [],
      filters: {
        brand_id: "",
        type_bike_id: "",
        price_min: "",
        price_max: "",
      },
      page: 1,
      nextPage: false,
    };
  },
  methods: {
    async fetchRents() {
      const params = {
        ...this.filters,
        page: this.page,
      };

      try {
        const response = await axios.get("/api/rents", { params });
        this.rents = response.data.data;
        this.page = response.data.current_page;
        this.nextPage = response.data.next_page_url !== null;
      } catch (error) {
        console.error("Error fetching rents:", error);
      }
    },
    getPhotoUrl(photoPath) {
      if (!photoPath) {
        return "placeholder.jpg"; // Fallback for missing images
      }
      return `http://127.0.0.1:8000/storage/${photoPath}`;
    },
    async fetchBrandsAndTypes() {
      try {
        const [brandsResponse, typesResponse] = await Promise.all([
          axios.get("/api/brands"),
          axios.get("/api/types"),
        ]);
        this.brands = brandsResponse.data;
        this.types = typesResponse.data;
        console.log(this.brands);
      } catch (error) {
        console.error("Failed to fetch brands or types:", error);
      }
    },
    applyFilters() {
      this.page = 1; // Reset to first page
      this.fetchRents();
    },
    changePage(newPage) {
      this.page = newPage;
      this.fetchRents();
    },
  },
  mounted() {
    this.fetchBrandsAndTypes();
    this.fetchRents();
  },
};
</script>

<style scoped>
/* Add your styles here */
</style>
