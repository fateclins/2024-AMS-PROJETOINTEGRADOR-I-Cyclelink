<template>
    <div class="p-6">
      <!--  <InputText
        placeholder="Enter your username"
        v-model="username"
        errorMessage="This field is required"
        label="Username"
        icon="fi fi-rr-user"
      /> -->


      <SubmitButton
      />
    </div>
  </template>
  
  <script>
import InputText from './inputs/inputText.vue';
import SubmitButton from './buttons/submitButton.vue';
  
  export default {
    name: 'App',
    components: {
      InputText,
      SubmitButton,
    },
    data() {
      return {
        username: '',
        email: '',
      };
    },
  };
  </script>
  
  <style scoped>
  /* Any additional styling */
  </style>
  