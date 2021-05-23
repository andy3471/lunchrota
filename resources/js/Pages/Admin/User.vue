<template>
    <main-layout>
        <b-container fluid>
            <b-row>
                <b-col>
                    <user-table :appdelenabled="appdelenabled" />
                </b-col>
                <b-col>
                    <create-user :errors="errors"></create-user>
                </b-col>
            </b-row>
        </b-container>

    </main-layout>
</template>

<script>
import MainLayout from '../../Layouts/MainLayout'
import CreateUser from '../../Components/Admin/CreateUser'
import UserTable from '../../Components/Admin/UserTable'

export default {
  components: { MainLayout, CreateUser, UserTable },
  props: {
    errors: Object,
  }
};
</script>
