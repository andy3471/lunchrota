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
                    App Del
                  </h4>
                </th>
              </tr>
              <tr>
                <th style="width: 80%">
                  Name
                </th>
                <th style="width: 20%">
                  On Support
                </th>
              </tr>
              <tr
                v-for="appdel in appdels"
                :key="appdel.id"
              >
                <td style="width: 80%">
                  {{ appdel.name }}
                </td>
                <td style="width: 20%">
                  <app-del-support
                    :userid="appdel.id" 
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
        <date-picker v-model="date" />
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    appdels: {
      required: true,
      type: Array
    }
  },
  data() {
    return {
      date: new Date(),
      newAppDel: ''
    };
  },
  mounted() {},
  methods: {
  }
};
</script>
