<template>
  <div class="h-screen w-full bg-slate-200 dark:bg-slate-900 flex flex-col items-center">
    <Navbar />

    <div class="p-6 w-full flex flex-col items-center">
      <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-200 mb-6">My Bikes</h1>

      <div v-if="loading" class="text-gray-700 dark:text-gray-300 text-lg font-semibold">
        Loading...
      </div>

      <div v-else class="w-full flex justify-between items-center mb-6">
        <button
          @click="createRent"
          class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition"
        >
          Create New Bike
        </button>
      </div>

      <div v-if="rents.length === 0" class="text-red-500 text-lg font-semibold">
        You have not published any bikes yet.
      </div>

      <div v-else class="w-full overflow-x-auto">
        <table class="min-w-full bg-white dark:bg-slate-800 rounded-lg shadow-md">
          <thead>
            <tr class="bg-gray-200 dark:bg-slate-700">
              <th class="py-3 px-6 text-left text-gray-800 dark:text-gray-200">Bike Name</th>
              <th class="py-3 px-6 text-left text-gray-800 dark:text-gray-200">Year</th>
              <th class="py-3 px-6 text-left text-gray-800 dark:text-gray-200">Price</th>
              <th class="py-3 px-6 text-left text-gray-800 dark:text-gray-200">Color</th>
              <th class="py-3 px-6 text-left text-gray-800 dark:text-gray-200">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="rent in rents" :key="rent.id">
              <td class="py-3 px-6">{{ rent.bike.name }}</td>
              <td class="py-3 px-6">{{ rent.bike.year }}</td>
              <td class="py-3 px-6">${{ rent.price }}</td>
              <td class="py-3 px-6">{{ rent.color }}</td>
              <td class="py-3 px-6">
                <button
                  @click="deleteRent(rent.id)"
                  class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition"
                >
                  Delete
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import Navbar from "../../navbar/navbar.vue"; 

export default {
  name: 'myRents',
  components: {
    Navbar,
  },
  data() {
    return {
      rents: [],
      loading: true,
      userId: null,
    };
  },

  methods: {
    async fetchRents() {
      try {
        const token = localStorage.getItem('token');
        
        if (!token) {
          this.$router.push('/login');
          return;
        }

        const authResponse = await axios.get('/api/auth', {
          headers: {
            Authorization: `Bearer ${token}`
          }
        });

        this.userId = authResponse.data.id;

        const response = await axios.get(`/api/user/rents`, {
          headers: {
            Authorization: `Bearer ${token}`
          }
        });

        this.rents = response.data;
        console.log(response.data);

        this.loading = false;
      } catch (error) {
        console.error("Error fetching rents:", error);

        if (error.response && error.response.status === 401) {
          localStorage.removeItem('token');
          this.$router.push('/login');
        }

        this.loading = false;
      }
    },

    getPhotoUrl(photoPath) {
      return photoPath ? `http://127.0.0.1:8000/storage/${photoPath}` : 'placeholder.jpg';
    },

    async deleteRent(rentId) {
      try {
        const token = localStorage.getItem('token');
        if (!token) {
          this.$router.push('/login');
          return;
        }

        await axios.delete(`/api/rents/${rentId}`, {
          headers: {
            Authorization: `Bearer ${token}`
          }
        });

        this.rents = this.rents.filter(rent => rent.id !== rentId);
      } catch (error) {
        console.error("Error deleting rent:", error);
      }
    },

    createRent() {
      this.$router.push('/createRent');  
    }
  },

  mounted() {
    this.fetchRents();
  },
};
</script>

