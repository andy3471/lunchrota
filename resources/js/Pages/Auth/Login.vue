<template>
<main-layout>
        <b-container>
            <b-card title="Login">
                <b-form @submit.prevent="submit">
                    <b-form-group label="Email">
                        <b-form-input v-model="form.email" placeholder="Email"></b-form-input>
                    </b-form-group>
                    <b-form-group label="Password">
                        <b-form-input v-model="form.password" type="password"  placeholder="Password"></b-form-input>
                    </b-form-group>
                    <b-button type="submit" variant="primary">Sign In</b-button>
                </b-form>
            </b-card>
        </b-container>
    </main-layout>
</template>
<script>
import MainLayout from '../../Layouts/MainLayout'

export default {
    components: { MainLayout },
    data() {
        return {
            form: {
                email: '',
                password: ''
            }
        };
    },
    methods: {
        submit() {
            this.$inertia.post('/login', this.form)
        },
    }
}
</script>
