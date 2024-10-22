<template>
  <button 
    type="submit"
    :disabled="loading || disabled"
    :class="[
      'inline-flex items-center justify-center px-4 py-2 border text-base font-medium rounded-md',
      'bg-blue-500 hover:bg-blue-600 transition duration-150 text-white',
      'focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50',
      buttonClass,
      loading ? 'cursor-not-allowed opacity-50' : ''
    ]"
  >
    <span v-if="loading" class="spinner"></span>
    <span v-else>{{ text }}</span>
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
};
</script>

<style scoped>
.spinner {
  border: 2px solid rgba(255, 255, 255, 0.3);
  border-left-color: white;
  border-radius: 50%;
  width: 20px;
  height: 20px;
  animation: spin 1s linear infinite;
}

@keyframes spin {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}
</style>
