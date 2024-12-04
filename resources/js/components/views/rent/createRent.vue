<template>

    <div class="h-screen w-full bg-slate-200 dark:bg-slate-900 flex flex-col items-center">
      <Navbar />
      <div class="sm:w-[90%] mt-[7%] md:w-[90%] lg:w-[35%] max-w-lg h-auto bg-white dark:bg-slate-800 rounded-lg shadow-lg p-8 ">
        <h1 class="text-5xl font-semibold text-blue-600 dark:text-slate-300 mb-4">Create Rent</h1>
        <p class="text-sm text-gray-600 dark:text-slate-300 mb-8">Fill in the details below to create a rent record.</p>

        <form @submit.prevent="createRent" class="space-y-6">
          <select 
            v-model="rentData.bike_id" 
            class="w-full p-3 rounded-md border border-gray-300 dark:bg-slate-700 dark:text-white"
            :class="{'border-red-600': errors.bike_id.length > 0}"
          >
            <option value="" disabled>Select Bike</option>
            <option v-for="bike in bikes" :key="bike.id" :value="bike.id">
              {{ bike.name }}
            </option>
          </select>
          <p v-if="errors.bike_id" class="text-red-600 text-sm mt-1">{{ errors.bike_id[0] }}</p>

          <inputText
            label="Price"
            v-model="rentData.price"
            :error="errors.price"
            placeholder="Enter price"
            errorMessage="This field is required"
            icon="fi fi-rr-money"
            size="w-full"
          />

          <select 
            v-model="rentData.color" 
            class="w-full p-3 rounded-md border border-gray-300 dark:bg-slate-700 dark:text-white"
            :class="{'border-red-600': errors.color.length > 0}"
          >
            <option disabled value="">Select Color</option>
            <option value="Red">Red</option>
            <option value="Blue">Blue</option>
            <option value="Green">Green</option>
            <option value="Black">Black</option>
            <option value="White">White</option>
            <option value="Yellow">Yellow</option>
          </select>
          <p v-if="errors.color" class="text-red-600 text-sm mt-1">{{ errors.color[0] }}</p>

          <input type="file" @change="handlePhotoUpload" class="w-full p-3 rounded-md border border-gray-300 dark:bg-slate-700 dark:text-white" />
          <p v-if="errors.photo" class="text-red-600 text-sm mt-1">{{ errors.photo[0] }}</p>

          <submitButton
            buttonClass="w-full mt-6 bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-lg"
          />
        </form>
      </div>

      <Alert :message="alertMessage" />
    </div>
</template>

<script>
import axios from 'axios';
import { ref } from 'vue';
import Navbar from '../../navbar/navbar.vue'; 
import inputText from '../../inputs/inputText.vue';
import submitButton from '../../buttons/submitButton.vue';
import Alert from '../../alert/alert.vue';

export default {
  name: 'CreateRent',
  components: {
    Navbar,
    inputText,
    submitButton,
    Alert,
  },
  data() {
    return {
      rentData: {
        bike_id: '',
        price: '',
        color: '',
        photo: null, 
      },
      bikes: [],
      errors: {
        bike_id: [],
        price: [],
        color: [],
        photo: [],
      },
      alertMessage: '',
    };
  },
  created() {
    this.fetchBikes();
  },
  methods: {
    async fetchBikes() {
   const token = localStorage.getItem('token');
   if (!token) {
     this.$router.push('/login');
     return;
   }

   try {
     const response = await axios.get('http://127.0.0.1:8000/api/bikes', {
       headers: { Authorization: `Bearer ${token}` }
     });
     this.bikes = response.data;
     console.log(this.bikes);  // Check the fetched data
   } catch (error) {
     console.error('Error fetching bikes:', error.response?.data || error.message);
   }
 },


    handlePhotoUpload(event) {
      const file = event.target.files[0];
      this.rentData.photo = file;
    },

    async createRent() {
      const token = localStorage.getItem('token');
      if (!token) {
        this.$router.push('/login');
        return;
      }

      const formData = new FormData();
      formData.append('bike_id', this.rentData.bike_id);
      formData.append('price', this.rentData.price);
      formData.append('color', this.rentData.color);
      if (this.rentData.photo) {
        formData.append('photo', this.rentData.photo);
      }

      try {
        const response = await axios.post('http://127.0.0.1:8000/api/rents', formData, {
          headers: {
            Authorization: `Bearer ${token}`,
            'Content-Type': 'multipart/form-data',
          },
        });

        this.alertMessage = 'Rent created successfully';
        this.$router.push('/rents');
      } catch (error) {
        console.error('Error creating rent:', error.response?.data || error.message);
        this.errors = error.response?.data.errors || {};
      }
    },
  },
};
</script>

<style scoped>
/* Add custom styles for the page if needed */
</style>
