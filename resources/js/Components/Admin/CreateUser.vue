<template>
    <b-card title="New User">
        <b-form @submit.prevent="submit">
            <b-form-group
                label="Name"
                :state="!errors.hasOwnProperty('name')"
                :invalid-feedback="errors.name"
            >
                <b-form-input v-model="form.name" placeholder="Name"></b-form-input>
            </b-form-group>
            <b-form-group
                label=Email
                :state="!errors.hasOwnProperty('name')"
                :invalid-feedback="errors.email"
            >
                <b-form-input v-model="form.email" type="email"  placeholder="Email"></b-form-input>
            </b-form-group>
            <b-form-group
                label="Password"
                :state="!errors.hasOwnProperty('password')"
                :invalid-feedback="errors.password"
            >
                <b-form-input v-model="form.password" type="password"  placeholder="Password"></b-form-input>
            </b-form-group>
            <b-form-group label="Confirm Password">
                <b-form-input v-model="form.password_confirmation" type="password"  placeholder="Confirm Password"></b-form-input>
            </b-form-group>
            <b-button type="submit" variant="primary">Create User</b-button>
        </b-form>
    </b-card>
</template>
<script>
export default {
    props: {
        errors: Object,
    },
    data() {
        return {
            form: {
                name: '',
                email: '',
                password: '',
                password_confirmation: ''
            }
        };
    },
    methods: {
        submit() {
            this.$inertia.post('/admin/users/store', this.form)
        },
    }
}
</script>
