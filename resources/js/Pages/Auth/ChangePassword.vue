<template>
<main-layout>
        <b-container>
            <b-card title="Change Password">
                <b-form @submit.prevent="submit">
                    <b-form-group
                        label="Current Password"
                        :state="!errors.hasOwnProperty('currentpassword')"
                        :invalid-feedback="errors.currentpassword"
                    >
                        <b-form-input v-model="form.currentpassword" type="password" placeholder="Current Password"></b-form-input>
                    </b-form-group>
                    <b-form-group
                        label="New Password"
                        :state="!errors.hasOwnProperty('newpassword')"
                        :invalid-feedback="errors.newpassword"
                    >
                        <b-form-input v-model="form.newpassword" type="password"  placeholder="New Password"></b-form-input>
                    </b-form-group>
                    <b-form-group label="Confirm New Password">
                        <b-form-input v-model="form.newpassword_confirmation" type="password"  placeholder="Confirm Password"></b-form-input>
                    </b-form-group>
                    <b-button type="submit" variant="primary">Change Password</b-button>
                </b-form>
            </b-card>
        </b-container>
    </main-layout>
</template>
<script>
import MainLayout from '../../Layouts/MainLayout'

export default {
  components: { MainLayout },
  props: {
    errors: Object
  },
  data () {
    return {
      form: {
        currentpassword: '',
        newpassword: '',
        newpassword_confirmation: ''
      }
    }
  },
  methods: {
    submit () {
      this.$inertia.post('/changepassword', this.form)
    }
  }
}
</script>
