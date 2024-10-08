<template>
    <button
      :disabled="loading || disabled"
      @click="handleClick"
      :class="[
        'inline-flex items-center justify-center px-4 py-2 border text-base font-medium rounded-md',
        'bg-blue-500 hover:bg-blue-600 text-white',
        'focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50',
        loading || disabled ? 'opacity-50 cursor-not-allowed' : 'opacity-100 cursor-pointer',
        buttonClass
      ]"
    >
      <!-- Loading Spinner -->
      <svg v-if="loading" class="animate-spin h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <circle cx="12" cy="12" r="10" stroke-width="4"></circle>
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M12 6v6m0 4h.01"></path>
      </svg>
  
      <!-- Button Text -->
      <span v-if="!loading">{{ text }}</span>
      <span v-else>Processing...</span>
    </button>
  </template>
  
  <script>
  export default {
    name: 'SubmitButton',
    props: {
      text: {
        type: String,
        default: 'Submit',
      },
      loading: {
        type: Boolean,
        default: false,
      },
      disabled: {
        type: Boolean,
        default: false,
      },
      buttonClass: {
        type: String,
        default: '',
      },
    },
    methods: {
      handleClick() {
        this.$emit('click');
      },
    },
  };
  </script>
  
  <style scoped>
  /* Add any custom styles for the button here */
  </style>
  