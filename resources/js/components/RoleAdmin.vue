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
              <input type="hidden" name="date" value="2019-11-8" />
              <tr>
                <th>Person</th>
                <th>Override</th>
              </tr>
              <tr>
                <td>Bartosz Lazarewicz</td>
                <td>
                  <div class="dropdown">
                    <button
                      type="button"
                      class="btn btn-primary dropdown-toggle"
                      data-toggle="dropdown"
                      id="dropdown9"
                      changed="0"
                    >In Office</button>
                    <input type="hidden" name="roleid[]" id="9:roleid" value="1" />
                    <input type="hidden" name="changed[]" id="9:changed" value="0" />
                    <input type="hidden" name="userid[]" value="9" />
                    <div class="dropdown-menu scrollable-menu">
                      <a class="dropdown-item" href="#" id="role2">Annual Leave</a>
                      <a class="dropdown-item" href="#" id="role5">Authorised Absence</a>
                      <a class="dropdown-item" href="#" id="role20">Backlog</a>
                      <a class="dropdown-item" href="#" id="role6">Coordinator</a>
                      <a class="dropdown-item" href="#" id="role18">Coordinator/On-Call</a>
                      <a class="dropdown-item" href="#" id="role8">Early</a>
                      <a class="dropdown-item" href="#" id="role21">Early/Backlog</a>
                      <a class="dropdown-item" href="#" id="role23">Early/Backlog/On-Call</a>
                      <a class="dropdown-item" href="#" id="role11">Early/Coordinator</a>
                      <a class="dropdown-item" href="#" id="role19">Early/Coordinator/On-Call</a>
                      <a class="dropdown-item" href="#" id="role9">Early/On-Call</a>
                      <a class="dropdown-item" href="#" id="role16">Half-Day AM</a>
                      <a class="dropdown-item" href="#" id="role15">Half-Day PM</a>
                      <a class="dropdown-item" href="#" id="role1">In Office</a>
                      <a class="dropdown-item" href="#" id="role12">Maternity</a>
                      <a class="dropdown-item" href="#" id="role7">On-Call</a>
                      <a class="dropdown-item" href="#" id="role22">On-Call/Backlog</a>
                      <a class="dropdown-item" href="#" id="role13">Paternity</a>
                      <a class="dropdown-item" href="#" id="role3">Sick</a>
                      <a class="dropdown-item" href="#" id="role4">Training</a>
                      <a class="dropdown-item" href="#" id="role10">Training/On-Call</a>
                      <a class="dropdown-item" href="#" id="role25">WFH</a>
                      <a class="dropdown-item" href="#" id="role24">Workshop</a>
                    </div>
                  </div>
                </td>
              </tr>
              <tr>
                <th colspan="3">
                  <button
                    type="submit"
                    class="btn btn-primary lunchbtn"
                    style="width:100%;"
                    id="1"
                  >Submit</button>
                </th>
              </tr>
            </tbody>
          </table>
        </form>
      </div>

      <div class="col-lg-6 order-lg-2" id="DatePicker">
        <date-picker></date-picker>
      </div>
    </div>
  </div>
</template>

<script>
</script>
