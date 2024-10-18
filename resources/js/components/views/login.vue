<template>
    <div class="w-screen h-screen bg-slate-200 dark:bg-slate-900 flex flex-col justify-center items-center">
        <div class="w-[35%] max-w-lg h-auto bg-white dark:bg-slate-800 rounded-lg shadow-lg p-8">
            <h1 class="text-5xl font-semibold text-blue-600 dark:text-slate-300 mb-4">Login</h1>
            <p class="text-sm text-gray-600 dark:text-slate-300 mb-8">Please fill in your credentials to continue.</p>
            <form @submit.prevent="login" class="space-y-6">
                <inputText label="Email" placeholder="Enter your email" v-model="email"
                    errorMessage="This field is required" icon="fi fi-rr-envelope" size="w-full"
                    :error="errors.email" />

                <inputText label="Password" placeholder="Enter your password" v-model="password"
                    errorMessage="This field is required" icon="fi fi-rr-key" size="w-full"
                    :error="errors.password" />
                
                <div class="flex justify-between items-center text-sm pt-2">
                    <a href="#" class="text-blue-600 dark:text-slate-200 hover:underline">Forgot password?</a>
                    <a href="/signUp" class="text-blue-600 dark:text-slate-200 hover:underline">Create account</a>
                </div>

                <submitButton buttonClass="w-full mt-6 bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-lg" />
            </form>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import inputText from '../inputs/inputText.vue';
import submitButton from '../buttons/submitButton.vue';

export default {
    name: 'Login',
    components: {
        inputText,
        submitButton,
    },
    data() {
        return {
            email: '',
            password: '',
            errors: {},
        };
    },
    methods: {
        async login() {
            try {
                this.errors = {};

                console.log('Attempting login with:', this.email, this.password);

                const response = await axios.post('http://127.0.0.1:8000/api/login', {
                    email: this.email,
                    password: this.password
                });
                
                console.log('Login successful:', response.data);
                localStorage.setItem('token', response.data.token);
                this.$router.push({ path: '/home' });
            } catch (error) {
                console.error('Error during login:', error.response ? error.response.data : error);
                if (error.response && error.response.data.errors) {
                    this.errors = error.response.data.errors;
                }
            }
        }
    }
}
</script>
