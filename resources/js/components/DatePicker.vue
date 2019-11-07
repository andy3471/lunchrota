<template>
  <table class="table datepicker">
    <tbody>
      <tr>
        <th colspan="7">
          <h4 id="date" class="text-center" dbmaindate="2019-11-27">27 November 2019</h4>
        </th>
      </tr>
      <tr>
        <th scope="col" colspan="2" class="button text-center">⟵</th>
        <th id="currYear" scope="col" colspan="3" class="text-center">2019</th>
        <th scope="col" colspan="2" class="button text-center">⟶</th>
      </tr>
      <tr>
        <th scope="col" colspan="2" class="button text-center">⟵</th>
        <th id="currMonth" scope="col" colspan="3" class="text-center">November</th>
        <th scope="col" colspan="2" class="button text-center">⟶</th>
      </tr>
      <tr>
        <th scope="col" class="day button text-center">Sun</th>
        <th scope="col" class="day button text-center">Mon</th>
        <th scope="col" class="day button text-center">Tues</th>
        <th scope="col" class="day button text-center">Wed</th>
        <th scope="col" class="day button text-center">Thur</th>
        <th scope="col" class="day button text-center">Fri</th>
        <th scope="col" class="day button text-center">Sat</th>
      </tr>
      <tr>
        <td
          id="Su1"
          class="day button text-center"
          style="color: rgb(136, 136, 136);"
          date="27-9-2019"
        >27</td>
        <td
          id="Mo1"
          class="day button text-center"
          style="color: rgb(136, 136, 136);"
          date="28-9-2019"
        >28</td>
        <td
          id="Tu1"
          class="day button text-center"
          style="color: rgb(136, 136, 136);"
          date="29-9-2019"
        >29</td>
        <td
          id="We1"
          class="day button text-center"
          style="color: rgb(136, 136, 136);"
          date="30-9-2019"
        >30</td>
        <td
          id="Th1"
          class="day button text-center"
          style="color: rgb(136, 136, 136);"
          date="31-9-2019"
        >31</td>
        <td id="Fr1" class="day button text-center" date="1-10-2019">1</td>
        <td id="Sa1" class="day button text-center" date="2-10-2019">2</td>
      </tr>
      <tr>
        <td id="Su2" class="day button text-center" date="3-10-2019">3</td>
        <td id="Mo2" class="day button text-center" date="4-10-2019">4</td>
        <td id="Tu2" class="day button text-center" date="5-10-2019">5</td>
        <td id="We2" class="day button text-center" date="6-10-2019">6</td>
        <td id="Th2" class="day button text-center" date="7-10-2019" style>7</td>
        <td id="Fr2" class="day button text-center" date="8-10-2019">8</td>
        <td id="Sa2" class="day button text-center" date="9-10-2019">9</td>
      </tr>
      <tr>
        <td id="Su3" class="day button text-center" date="10-10-2019">10</td>
        <td id="Mo3" class="day button text-center" date="11-10-2019">11</td>
        <td id="Tu3" class="day button text-center" date="12-10-2019">12</td>
        <td id="We3" class="day button text-center" date="13-10-2019">13</td>
        <td id="Th3" class="day button text-center" date="14-10-2019">14</td>
        <td id="Fr3" class="day button text-center" date="15-10-2019">15</td>
        <td id="Sa3" class="day button text-center" date="16-10-2019">16</td>
      </tr>
      <tr>
        <td id="Su4" class="day button text-center" date="17-10-2019">17</td>
        <td id="Mo4" class="day button text-center" date="18-10-2019">18</td>
        <td id="Tu4" class="day button text-center" date="19-10-2019">19</td>
        <td id="We4" class="day button text-center" date="20-10-2019">20</td>
        <td id="Th4" class="day button text-center" date="21-10-2019">21</td>
        <td id="Fr4" class="day button text-center" date="22-10-2019">22</td>
        <td id="Sa4" class="day button text-center" date="23-10-2019">23</td>
      </tr>
      <tr id="row5">
        <td id="Su5" class="day button text-center" date="24-10-2019">24</td>
        <td id="Mo5" class="day button text-center" date="25-10-2019">25</td>
        <td id="Tu5" class="day button text-center" date="26-10-2019">26</td>
        <td
          id="We5"
          class="day button text-center"
          date="27-10-2019"
          style="background-color: orange;"
        >27</td>
        <td id="Th5" class="day button text-center" date="28-10-2019">28</td>
        <td id="Fr5" class="day button text-center" date="29-10-2019">29</td>
        <td id="Sa5" class="day button text-center" date="30-10-2019">30</td>
      </tr>
      <tr id="row6" style="display: none;">
        <td id="Su6" class="day button text-center"></td>
        <td id="Mo6" class="day button text-center"></td>
        <td id="Tu6" class="day button text-center"></td>
        <td id="We6" class="day button text-center"></td>
        <td id="Th6" class="day button text-center"></td>
        <td id="Fr6" class="day button text-center"></td>
        <td id="Sa6" class="day button text-center"></td>
      </tr>
      <tr>
        <th scope="col" colspan="2" class="button text-center">Yesterday</th>
        <th scope="col" colspan="3" class="button text-center">Today</th>
        <th scope="col" colspan="2" class="button text-center" onclick="tomorrow()">Tomorrow</th>
      </tr>
    </tbody>
  </table>
</template>

<script>
</script>
