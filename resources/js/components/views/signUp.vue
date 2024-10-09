<template>
    <div class="w-screen h-screen bg-slate-200 dark:bg-slate-900 flex flex-col justify-center items-center">
        <div class="w-3/6 h-5/6 bg-white dark:bg-slate-800 rounded-md flex flex-col justify-center items-center">
            <h1 class="text-5xl text-blue-600 dark:text-slate-300">Sign Up</h1>
            <p class="pt-4 dark:text-slate-300">Fill all to sign in</p>
            <form action="" method="post">
                <inputText
                    label="Name"
                    placeholder="Enter your name"
                    v-model="name"
                    errorMessage="This field is required"
                    icon="fi fi-rr-user"
                    size="w-96 pt-4"
                /> 

                <inputText
                    label="Email"
                    placeholder="Enter your email"
                    v-model="email"
                    errorMessage="This field is required"
                    icon="fi fi-rr-envelope"
                    size="w-96 pt-4"
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
                /> 

                <inputDate
                    label="Birthday"
                    v-model="born_date"
                    errorMessage="This field is required"
                    icon="fi fi-rs-calendar"
                    size="w-96 pt-4"
                /> 

                <inputText
                    label="Password"
                    placeholder="Enter your password"
                    v-model="password"
                    errorMessage="This field is required"
                    icon="fi fi-rr-key"
                    size="w-96 pt-4"
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
            password: ''
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

            // Update the v-model with the masked CPF
            this.cpf = value;
            console.log(this.cpf); // Log the masked value
        }
    }
};
</script>