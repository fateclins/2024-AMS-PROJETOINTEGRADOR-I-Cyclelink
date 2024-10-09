<template>
  <button type="submit"
    :class="[
      'inline-flex items-center justify-center px-4 py-2 border text-base font-medium rounded-md',
      'bg-blue-500 hover:bg-blue-600 transition duration-150 text-white',
      'focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50',
      buttonClass
    ]"
  >
    <span>{{ text }}</span>
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
      this.isLoading = true;
      this.$emit('click'); 
    },
  },
};
</script>

<style scoped>
</style>
