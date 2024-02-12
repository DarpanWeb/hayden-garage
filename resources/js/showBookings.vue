<template>

  <div class="form-container">
    <h2>Bookings List</h2>

      <div class="form-group">
        <label for="date">Date of Booking:</label>
        <input type="date" id="date" v-model="date" @change="fetchAvailableTimeSlots" :min="minDate" />
      </div>

      <div v-if="availableTimeSlots.length > 0" class="time-slots">
      <table class="time-slots-table">
        <thead>
          <tr>
            <th>Slot ID</th>
            <th>Slot Time</th>
            <th>Booking Status</th>
            <th>Customer Name</th>
            <th>Customer Email</th>
            <th>Customer Phone</th>
            <th>Customer Vehicle Model</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(slot, index) in availableTimeSlots" :key="index">
            <td>{{ slot.slot_id }}</td>
            <td>{{ slot.slot_timing }}</td>
            <td v-if="slot.status === 0 && slot.customer_name !== null">Booked</td>
            <td v-else-if="slot.status === 0 && slot.customer_name === null">Disabled</td>
            <td v-else>Open</td>
            <td>{{ slot.customer_name }}</td>
            <td>{{ slot.email }}</td>
            <td>{{ slot.phone_number }}</td>
            <td>{{ slot.vehicle_model }}</td>
          </tr>
        </tbody>
      </table>
    </div>
      
      
  </div>
</template>

<script>
  import axios from 'axios';
  import { toast } from "vue3-toastify";
  import "vue3-toastify/dist/index.css";

  export default {
    data() {
    return {
      date: '',
      availableTimeSlots: [],
    };
  },

  created() {
        // Set minimum date to today
        const today = new Date();
        this.minDate = today.toISOString().split('T')[0];
    },

  methods: {
      fetchAvailableTimeSlots() {
          // Check if date value exists and is not changed to "cleared"
          if (this.date == null || this.date == '') {
              return;
          }

          // Get the selected date from the form data
          const selectedDate = new Date(this.date);
          
          // Get the current date
          const currentDate = new Date();

          // Get the day of the week (0 = Sunday, 1 = Monday, ..., 6 = Saturday)
          const dayOfWeek = selectedDate.getDay();

          // Check if the selected day is Monday to Friday (1 to 5)
          if (dayOfWeek === 0 || dayOfWeek === 6) {
              toast.error('Please select a date from Monday to Friday');
              
              // Clear the date input
              this.date = '';
              return;
          }

          // Call API to fetch available time slots based on selected date
          axios.get(`/get-bookings?date=${this.date}`).then(response => {
              this.availableTimeSlots = response.data.data;
          }).catch(error => {
              toast.error('Something Went Wrong');
          });
      },
  }
};

</script>  

<style>
.time-slots-table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 20px;
}

.time-slots-table th, .time-slots-table td {
  border: 1px solid #ddd;
  padding: 8px;
  text-align: left;
}

.time-slots-table th {
  background-color: #f2f2f2;
}
</style>