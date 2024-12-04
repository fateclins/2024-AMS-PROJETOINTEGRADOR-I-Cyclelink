<template>
    <div v-if="visible" class="fixed bottom-4 left-1/2 transform -translate-x-1/2 bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg shadow-md">
      {{ message }}
    </div>
  </template>
  
  <script>
  export default {
    name: 'Alert',
    props: {
      message: {
        type: String,
        required: true,
      },
      duration: {
        type: Number,
        default: 3000, 
      }
    },
    data() {
      return {
        visible: false,
      };
    },
    watch: {
      message(newMessage) {
        if (newMessage) {
          this.showAlert(newMessage);
        }
      }
    },
    methods: {
      showAlert(message) {
        this.visible = true;
        setTimeout(() => {
          this.visible = false;
        }, this.duration);
      }
    }
  };
  </script>
  
  <style scoped>

  .fixed {
    position: fixed;
  }
  </style>
  