<template>
  <table class="table table-bordered">
    <tbody>
      <tr>
        <th colspan="3">
          <h4 class="text-center">Lunches</h4>
        </th>
      </tr>
      <tr>
        <td colspan="3" id="WarningBox" style="display: none; text-align: center;">
          <div id="Warning"></div>
        </td>
      </tr>
      <tr>
        <td colspan="3">
          <div id="Warning"></div>
          <div class="btn-group btn-block" style="height: 46px">
            <button
              type="submit"
              disabled
              class="btn btn-primary lunchbtn"
              style="width:100%;"
              id="1"
              value="12:30"
            >12:30</button>
            <button
              type="submit"
              disabled
              class="btn btn-primary lunchbtn"
              style="width:100%;"
              id="2"
              value="13:30"
            >13:30</button>
            <button
              type="submit"
              disabled
              class="btn btn-primary lunchbtn"
              style="width:100%;"
              id="3"
              value="14:30"
            >14:30</button>
            <button
              type="submit"
              class="btn btn-primary lunchbtn"
              style="width: 20%; display: none;"
              id="X"
              disabled
            >X</button>
          </div>
          <div>
            <div id="4"></div>
          </div>
        </td>
      </tr>
      <tr>
        <th>Person</th>
        <th>Lunch Slot</th>
      </tr>
      <tr>
        <td>Phill Renyard</td>
        <td>12:30</td>
      </tr>
    </tbody>
  </table>
</template>

<script>
</script>
