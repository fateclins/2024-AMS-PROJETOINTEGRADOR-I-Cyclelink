<template>
    <div class="h-screen w-full bg-slate-200 dark:bg-slate-900 flex flex-col justify-center items-center">
        <div class="sm:w-[90%] md:w-[90%] lg:w-[35%]  max-w-lg h-auto bg-white dark:bg-slate-800 rounded-lg shadow-lg p-8">
            <h1 class="text-5xl font-semibold text-blue-600 dark:text-slate-300 mb-4">Login</h1>
            <p class="text-sm text-gray-600 dark:text-slate-300 mb-8">Please fill in your credentials to continue.</p>
            <p v-if="loginError" class="text-red-600 dark:text-red-500 text-sm mb-4">{{ loginError }}</p>
            <form @submit.prevent="login" class="space-y-6">
                <inputText label="Email" placeholder="Enter your email" v-model="email"
                    errorMessage="This field is required" icon="fi fi-rr-envelope" size="w-full"
                    :error="errors.email" />

                <inputPassword label="Password" placeholder="Enter your password" v-model="password"
                    errorMessage="This field is required" icon="fi fi-rr-key" size="w-full"
                    :error="errors.password" />
                
                <div class="flex justify-between items-center text-sm pt-2">
                    <a href="/refreshPassword" class="text-blue-600 dark:text-slate-200 hover:underline dark:hover:text-blue-300">Forgot password?</a>
                    <a href="/signUp" class="text-blue-600 dark:text-slate-200 hover:underline dark:hover:text-blue-300">Create account</a>
                </div>

                <submitButton buttonClass="w-full mt-6 bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-lg" />
            </form>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import inputText from '../../inputs/inputText.vue';
import inputPassword from '../../inputs/inputPassword.vue';
import submitButton from '../../buttons/submitButton.vue';

export default {
    name: 'Login',
    components: {
        inputText,
        submitButton,
        inputPassword,
    },
    data() {
        return {
            email: '',
            password: '',
            errors: {},
            loginError: '',
        };
    },
    methods: {
        async login() {
            try {
                this.errors = {};
                this.loginError = '';
                const response = await axios.post('http://127.0.0.1:8000/api/login', {
                    email: this.email,
                    password: this.password
                });
                
                console.log(response);
                localStorage.setItem('token', response.data.token);
                this.$router.push({ path: '/' });
            } catch (error) {
                if (error.response && error.response.data.errors) {
                    this.errors = error.response.data.errors;
                } else if (error.response && error.response.data.message === 'Invalid credentials') {
                    this.loginError = 'Invalid credentials. Please try again.';
                }
                console.log(error.response.data);
            }
        }
    }
}
</script>
