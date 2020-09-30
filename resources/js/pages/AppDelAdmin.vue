<template>
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-6 order-lg-1" id="role">
        <form action method="post" id="roleOverride">
          <table class="table table-bordered">
            <tbody>
              <tr>
                <th colspan="3">
                  <h4 class="text-center">App Del</h4>
                </th>
              </tr>
              <tr>
                <th style="width: 80%">Name</th>
                <th style="width: 20%">On Support</th>
              </tr>
              <tr v-for="appdel in appdels" v-bind:key="appdel.id">
                <td style="width: 80%">{{ appdel.name}} </td>
                <td style="width: 20%">
                  <app-del-support
                    :userid="appdel.id" 
                    :date="date" 
                    :csrf="csrf">
                  </app-del-support>
                </td>
              </tr>
            </tbody>
          </table>
        </form>
      </div>

      <div class="col-lg-6 order-lg-2" id="DatePicker">
        <date-picker v-model="date"></date-picker>
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
