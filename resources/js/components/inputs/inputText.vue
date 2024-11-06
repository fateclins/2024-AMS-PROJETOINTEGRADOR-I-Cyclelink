<template>
    <div :class="['flex flex-col', size]">
        <label v-if="label" :for="inputId" class="text-base font-medium mb-2 text-gray-700 dark:text-slate-200">
            {{ label }}
        </label>
        <div class="relative">
            <i :class="[icon, 'absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-500']"></i>
            <input 
                :id="inputId" 
                :name="inputName" 
                type="text" 
                :placeholder="placeholder"
                :class="[
                    'bg-white dark:bg-white-800 border-gray-300 text-gray-900 dark:text-white focus:ring-indigo-500 focus:border-indigo-500',
                    'p-3 pl-10 border-2 block w-full sm:text-sm rounded-md',
                    inputClass,
                    { 'border-red-600': error && error.length }
                ]"
                v-model="inputValue" 
                :disabled="disabled" 
                @input="handleInput"
                />
        </div>
        <p v-if="error" class="text-red-600 text-sm mt-1">{{ error[0] }}</p>
    </div>
</template>

<script>
export default {
    name: 'inputText',
    props: {
        label: {
            type: String,
            default: '',
        },
        placeholder: {
            type: String,
            default: 'Enter text...',
        },
        inputClass: {
            type: String,
            default: '',
        },
        size: {
            type: String,
            default: '',
        },
        disabled: {
            type: Boolean,
            default: false,
        },
        error: {
            type: Array,
            default: () => [],
        },
        modelValue: {
            type: String,
            default: '',
        },
        icon: {
            type: String,
            default: '',
        },
        inputName: {
            type: String,
            default: '',
        }
    },
    data() {
        return {
            inputId: `input-${Math.random().toString(36).substring(7)}`,
            inputValue: this.modelValue,
        };
    },
    watch: {
        inputValue(newValue) {
            this.$emit('update:modelValue', newValue);
        },

        modelValue(newValue) {
            this.inputValue = newValue;
        },
    },

    methods: {
        handleInput() {
            this.clearError();
            this.$emit('update:modelValue', this.inputValue);
        },
        clearError() {
            if (this.error.length) {
                this.$emit('update:error', []);
            }
        }
    }
};
</script>
