<template>
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-6 order-lg-1" id="role">
        <form action method="post" id="roleOverride">
          <table class="table table-bordered">
            <tbody>
              <tr>
                <th colspan="3">
                  <h4 class="text-center">Roles</h4>
                </th>
              </tr>
              <tr>
                <th style="width: 50%">Name</th>
                <th style="width: 50%">Role</th>
              </tr>
              <tr v-for="user in users" v-bind:key="user.id">
                <td>{{ user.name }}</td>
                <td>
                  <role-dropdown :userid="user.id" :roles="roles" :date="date" :csrf="csrf"></role-dropdown>
                </td>
              </tr>
            </tbody>
          </table>
        </form>
      </div>

      <div class="col-lg-6 order-lg-2" id="DatePicker">
        <date-picker v-model="date" color="#fec107"></date-picker>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    users: {
      required: true,
      type: Array
    },
    roles: {
      required: true,
      type: Array
    }
  },
  data() {
    return {
      date: new Date()
    };
  },
  mounted() {},
  methods: {
  }
};
</script>
