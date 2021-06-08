<template>
  <main-layout>
    <b-container>
      <b-card title="Bulk upload user roles">
        <b-form @submit.prevent="submit">
          Please download the export. Once edited, you can upload it to override all roles in bulk
          <a :href="$route('admin.download_csv')">Download All Current Data </a>
          <b-form-group
            description="Upload CSV."
            label="File"
          >
            <b-form-file
              v-model="form.csv"
              :state="!errors.hasOwnProperty('csv')"
              :invalid-feedback="errors.csv"
              placeholder="Choose a file or drop it here..."
              drop-placeholder="Drop file here..."
            ></b-form-file>
          </b-form-group>
          <b-button type="submit">Upload</b-button>
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
      form: this.$inertia.form({
        csv: null
      })
    }
  },
  methods: {
    submit () {
      this.form.post('/admin/upload/uploadcsv', this.form)
    }
  }
}
</script>
