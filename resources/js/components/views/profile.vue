<template>
  <div class="h-screen w-full bg-slate-200 dark:bg-slate-900 flex flex-col justify-center items-center">
    <div class="sm:w-[90%] md:w-[90%] lg:w-[35%] max-w-lg h-auto bg-white dark:bg-slate-800 rounded-lg shadow-lg p-8">
      
      <div class="absolute top-4 left-4">
        <button @click="goBack" class="text-blue-600 dark:text-slate-300 hover:text-blue-700">
          <i class="fi fi-rr-arrow-left text-lg"></i> Back
        </button>
      </div>

      <h1 class="text-5xl font-semibold text-blue-600 dark:text-slate-300 mb-4">Profile</h1>
      <p class="text-sm text-gray-600 dark:text-slate-300 mb-8">Update your profile information below.</p>
      
      <form @submit.prevent="updateProfile" class="space-y-6">
        <inputText
          label="Name"
          v-model="userData.name"
          :error="errors.name"
          placeholder="Enter your full name"
          errorMessage="This field is required"
          icon="fi fi-rr-user"
          size="w-full"
        />

        <inputPassword
          label="Password"
          v-model="userData.password"
          :error="errors.password"
          placeholder="Enter new password"
          errorMessage="This field is required"
          icon="fi fi-rr-key"
          size="w-full"
        />

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
import Navbar from '../navbar/navbar.vue';
import inputText from '../inputs/inputText.vue';
import inputPassword from '../inputs/inputPassword.vue';
import inputDate from '../inputs/inputDate.vue';
import submitButton from '../buttons/submitButton.vue';
import Alert from '../alert/alert.vue';

export default {
  name: 'Profile',
  components: {
    Navbar,
    inputText,
    inputPassword,
    inputDate,
    submitButton,
    Alert 
  },
  data() {
    return {
      userData: {
        name: '',
        password: '',
      },
      errors: {
        name: [],
        password: [],
      },
      alertMessage: '', 
    };
  },
  created() {
    this.fetchUserProfile();
  },
  methods: {
    async fetchUserProfile() {
      const token = localStorage.getItem('token');
      if (!token) {
        this.$router.push('/login');
        return;
      }

      try {
        const response = await axios.get('http://127.0.0.1:8000/api/user', {
          headers: { Authorization: `Bearer ${token}` }
        });
        this.userData = response.data;
        console.log(this.userData);
      } catch (error) {
        console.error('Error fetching user profile:', error.response?.data || error.message);
      }
    },

    formatDate(date) {
      const d = new Date(date);
      return d.toISOString().split('T')[0]; 
    },

    async updateProfile() {
      const token = localStorage.getItem('token');
      if (!token) {
        this.$router.push('/login');
        return;
      }

      try {
        const response = await axios.put('http://127.0.0.1:8000/api/user', this.userData, {
          headers: { Authorization: `Bearer ${token}` }
        });

        this.alertMessage = 'Profile updated successfully';
        this.$router.go(-1);
      } catch (error) {
        console.error('Error updating profile:', error.response?.data || error.message);
        this.errors = error.response?.data.errors || {};
      }
    },

    goBack() {
      this.$router.go(-1);
    }
  }
};
</script>
