<template>
    <div class="w-screen h-screen bg-slate-200 dark:bg-slate-900 flex flex-col justify-center items-center">
        <div class="w-[95%] max-w-xl h-auto bg-white dark:bg-slate-800 rounded-lg shadow-md flex flex-col items-center p-8">
            <h1 class="text-4xl font-bold text-blue-600 dark:text-slate-300 mb-2">Sign Up</h1>
            <p class="text-sm text-gray-600 dark:text-slate-300 mb-6">Fill all fields to create an account</p>
            
            <form @submit.prevent="register" class="w-full">
                <inputText
                    label="Name"
                    placeholder="Enter your name"
                    v-model="name"
                    errorMessage="This field is required"
                    icon="fi fi-rr-user"
                    size="w-full pt-4"
                    :error="errors.name"
                />

                <inputText
                    label="Email"
                    placeholder="Enter your email"
                    v-model="email"
                    errorMessage="This field is required"
                    icon="fi fi-rr-envelope"
                    size="w-full pt-4"
                    :error="errors.email"
                />

                <inputText
                    label="CPF"
                    placeholder="Enter your CPF"
                    v-model="cpf"
                    inputName="cpf"
                    errorMessage="This field is required"
                    icon="fi fi-rr-id-badge"
                    size="w-full pt-4"
                    @input="applyCPFMask"
                    :error="errors.cpf"
                />

                <inputDate
                    label="Birthday"
                    v-model="born_date"
                    errorMessage="This field is required"
                    icon="fi fi-rs-calendar"
                    size="w-full pt-4"
                    :error="errors.born_date"
                />

                <inputPassword
                    label="Password"
                    placeholder="Enter your password"
                    v-model="password"
                    errorMessage="This field is required"
                    icon="fi fi-rr-key"
                    size="w-full pt-4"
                    :error="errors.password"
                />

                <submitButton
                    buttonClass="w-full mt-8 bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg"
                    buttonText="Sign Up"
                />
            </form>
            <div class="pt-4">
                <p class="text-sm text-gray-600 dark:text-slate-300">
                    Already have an account? 
                    <router-link to="/login" class="text-blue-600 dark:text-blue-300 hover:underline">Login</router-link>
                </p>
            </div>
        </div>
    </div>
</template>

<script>
    import inputText from '../../inputs/inputText.vue';
    import inputDate from '../../inputs/inputDate.vue';
    import inputPassword from '../../inputs/inputPassword.vue';
    import submitButton from '../../buttons/submitButton.vue';
    import axios from 'axios';
    export default {
    name: 'signUp',
    components: {
        inputText,
        inputDate,
        inputPassword,
        submitButton,
    },
    data() {
        return {
            name: '',
            email: '',
            cpf: '',
            born_date: '',
            password: '',
            errors: {},
        };
    },
    methods: {
        applyCPFMask(event) {
            let value = event.target.value.replace(/\D/g, '');

            if (value.length > 11) {
                value = value.substring(0, 11);
            }

            if (value.length <= 11) {
                if (value.length > 9) {
                    value = value.replace(/(\d{3})(\d{3})(\d{2})/, "$1.$2.$3"); 
                    value = value.replace(/(\d{3}\.\d{3})(\d{2})/, "$1-$2"); 
                } else if (value.length > 6) {
                    value = value.replace(/(\d{3})(\d{3})/, "$1.$2"); 
                } else if (value.length > 3) {
                    value = value.replace(/(\d{3})/, "$1."); 
                }
            }
            this.cpf = value;
        },
        async register() {
            try {
                this.errors = {};

                const response = await axios.post('http://127.0.0.1:8000/api/register', {
                    name: this.name,
                    email: this.email,
                    cpf: this.cpf,
                    born_date: this.born_date,
                    password: this.password
                });

                this.$router.push({ path: '/login' });

            } catch (error) {
                if (error.response && error.response.data.errors) {
                    this.errors = error.response.data.errors;
                }
            }
        }
    }
};
</script>