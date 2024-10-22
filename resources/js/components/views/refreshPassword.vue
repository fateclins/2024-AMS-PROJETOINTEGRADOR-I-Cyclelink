<template>
    <div class="w-screen h-screen bg-slate-200 dark:bg-slate-900 flex flex-col justify-center items-center overflow-hidden relative">
        <div :class="{'translate-x-0': currentForm === 'emailForm', '-translate-x-full': currentForm !== 'emailForm'}"
            class="absolute transform transition-transform duration-500 ease-in-out w-full h-full flex justify-center items-center">
            <div class="w-full sm:w-[90%] md:w-[75%] lg:w-[50%] xl:w-[35%] max-w-lg h-auto bg-white dark:bg-slate-800 rounded-lg shadow-lg p-6 sm:p-8">
                <p class="text-sm text-center text-gray-600 dark:text-slate-300 mb-4 sm:mb-8">Input your email to reset password.</p>
                <form @submit.prevent="sendEmail" class="space-y-4 sm:space-y-6">
                    <inputText 
                        label="Email" 
                        placeholder="Enter your email" 
                        v-model="email"
                        errorMessage="This field is required" 
                        icon="fi fi-rr-envelope" 
                        size="w-full"
                        :error="errors.email" 
                    />
                    <submitButton
                        :loading="loading"
                        buttonClass="w-full mt-4 sm:mt-6 bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-lg" 
                    />
                </form>
            </div>
        </div>

        <div :class="{'translate-x-0': currentForm === 'codeForm', 'translate-x-full': currentForm !== 'codeForm'}"
            class="absolute transform transition-transform duration-500 ease-in-out w-full h-full flex justify-center items-center">
            <div class="w-full sm:w-[90%] md:w-[75%] lg:w-[50%] xl:w-[35%] max-w-lg h-auto bg-white dark:bg-slate-800 rounded-lg shadow-lg p-6 sm:p-8">
                <p class="text-sm text-center text-gray-600 dark:text-slate-300 mb-4 sm:mb-8">Enter the verification code and reset your password.</p>
                <form @submit.prevent="refreshPassword" class="space-y-4 sm:space-y-6">
                    <inputText 
                        label="Code" 
                        placeholder="Enter the verification code" 
                        v-model="verification_code"
                        errorMessage="This field is required" 
                        icon="fi fi-sr-password-email" 
                        size="w-full"
                        :error="errors.verification_code" 
                    />
                    <inputPassword
                        label="Password"
                        placeholder="Enter your new password"
                        v-model="password"
                        errorMessage="This field is required"
                        icon="fi fi-rr-key"
                        size="w-full"
                        :error="errors.password"
                    />
                    <inputPassword
                        label="Password Confirmation"
                        placeholder="Confirm your new password"
                        v-model="password_confirmation"
                        errorMessage="This field is required"
                        icon="fi fi-rr-key"
                        size="w-full"
                        :error="errors.password_confirmation"
                    />
                    <submitButton
                        buttonClass="w-full mt-4 sm:mt-6 bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-lg" 
                    />
                </form>
                <button @click="goBack" class="flex items-center text-gray-600 dark:text-slate-300 mt-5">
                    <i class="fi fi-rr-arrow-left mr-2"></i>
                    Back
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import inputText from '../inputs/inputText.vue';
import inputPassword from '../inputs/inputPassword.vue';
import submitButton from '../buttons/submitButton.vue';

export default {
    name: 'refreshPassword',
    components: {
        inputText,
        inputPassword,
        submitButton,
    },

    data() {
        return {
            email: '',
            verification_code: '',
            password: '',
            password_confirmation: '',
            errors: {},
            currentForm: 'emailForm', 
            loading: false,
        };
    },

    methods: {
        async sendEmail() {
            try {
                this.errors = {};
                this.loading = true;
                const response = await axios.post('http://127.0.0.1:8000/api/password/email', {
                    email: this.email,
                });
                this.currentForm = 'codeForm';
                this.loading = false;
            } catch (error) {
                if (error.response && error.response.data.errors) {
                    this.errors = error.response.data.errors;
                }
                this.loading = false;
            }
        },

        async refreshPassword() {
            try {
                this.errors = {};
                const response = await axios.post('http://127.0.0.1:8000/api/password/reset', {
                    verification_code: this.verification_code,
                    password: this.password,
                    password_confirmation: this.password_confirmation,
                });

            } catch (error) {
                if (error.response && error.response.data.errors) {
                    this.errors = error.response.data.errors;
                }

                console.log(error.response);
            }
        },

        goBack() {
            this.currentForm = 'emailForm'; 
        }
    }
}
</script>
