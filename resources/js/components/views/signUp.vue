<template>
    <div class="w-screen h-screen bg-slate-200 dark:bg-slate-900 flex flex-col justify-center items-center">
        <div class="w-3/6 h-[90%] bg-white dark:bg-slate-800 rounded-md flex flex-col justify-center items-center">
            <h1 class="text-5xl text-blue-600 dark:text-slate-300">Sign Up</h1>
            <p class="pt-1 dark:text-slate-300">Fill all to sign in</p>
            <form @submit.prevent="register">
                <inputText
                    label="Name"
                    placeholder="Enter your name"
                    v-model="name"
                    errorMessage="This field is required"
                    icon="fi fi-rr-user"
                    size="w-96 pt-4"
                    :error="errors.name"
                /> 

                <inputText
                    label="Email"
                    placeholder="Enter your email"
                    v-model="email"
                    errorMessage="This field is required"
                    icon="fi fi-rr-envelope"
                    size="w-96 pt-4"
                    :error="errors.email"
                /> 

                <inputText
                    label="CPF"
                    placeholder="Enter your CPF"
                    v-model="cpf"
                    inputName="cpf"
                    errorMessage="This field is required"
                    icon="fi fi-rr-id-badge"
                    size="w-96 pt-4"
                    @input="applyCPFMask"
                    :error="errors.cpf"
                /> 

                <inputDate
                    label="Birthday"
                    v-model="born_date"
                    errorMessage="This field is required"
                    icon="fi fi-rs-calendar"
                    size="w-96 pt-4"
                    :error="errors.born_date"
                /> 

                <inputText
                    label="Password"
                    placeholder="Enter your password"
                    v-model="password"
                    errorMessage="This field is required"
                    icon="fi fi-rr-key"
                    size="w-96 pt-4"
                    :error="errors.password"
                /> 

                <submitButton
                    buttonClass="w-96 mt-8"
                />
            </form>
        </div>
    </div>
</template>


<script>
    import inputText from '../inputs/inputText.vue';
    import inputDate from '../inputs/inputDate.vue';
    import submitButton from '../buttons/submitButton.vue';
    import axios from 'axios';
    export default {
    name: 'signUp',
    components: {
        inputText,
        inputDate,
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

                console.log(response.data); 
                this.$router.push({ path: '/home' });

            } catch (error) {
                if (error.response && error.response.data.errors) {
                    this.errors = error.response.data.errors;
                } else {
                    console.error(error);
                }
            }
        }
    }
};
</script>