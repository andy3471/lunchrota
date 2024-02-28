<template>
  <div class="container-fluid">
    <div class="row">
      <div
        id="role"
        class="col-lg-6 order-lg-1"
      >
        <form
          id="roleOverride"
          action
          method="post"
        >
          <table class="table table-bordered">
            <tbody>
              <tr>
                <th colspan="3">
                  <h4 class="text-center">
                    Roles
                  </h4>
                </th>
              </tr>
              <tr>
                <th style="width: 50%">
                  Name
                </th>
                <th style="width: 50%">
                  Role
                </th>
              </tr>
              <tr
                v-for="user in users"
                :key="user.id"
              >
                <td>{{ user.name }}</td>
                <td>
                  <role-dropdown
                    :userid="user.id"
                    :roles="roles"
                    :date="date"
                    :csrf="csrf"
                  />
                </td>
              </tr>
            </tbody>
          </table>
        </form>
      </div>

      <div
        id="DatePicker"
        class="col-lg-6 order-lg-2"
      >
        <date-picker
          v-model="date"
          color="#fec107"
        />
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
