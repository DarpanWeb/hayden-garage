<template>

  <div class="form-container">
    <h2>Hayden's Garage</h2>

  <form id="bookingForm" @submit.prevent="submitBookingForm">

      <div class="form-group">
        <label for="name">Name:</label>
        <input type="text" id="name" v-model="formData.customer_name" required />
      </div>

      <div class="form-group">
        <label for="email">Email Address:</label>
        <input type="email" id="email" v-model="formData.email" required />
      </div>

      <div class="form-group">
        <label for="phone">Phone Number:</label>
        <input type="tel" id="phone" v-model="formData.phone_number" required />
      </div>

      <div class="form-group">
        <label for="vehicle">Vehicle Model:</label>
        <input type="text" id="vehicle" v-model="formData.vehicle_model" required />
      </div>

      <div class="form-group">
        <label for="date">Date of Booking:</label>
        <input type="date" id="date" v-model="formData.date" @change="fetchAvailableTimeSlots"  :min="minDate"  required />
      </div>

      <!-- Checkboxes generated based on API response -->
      <div v-if="availableTimeSlots.length > 0" class="time-slots">
          <div v-if="showLabel">
            <p>Available Time Slots: (only 1 per person)</p>

          <label v-for="(slot, index) in availableTimeSlots" :key="index" class="time-slot-label">
              <input
                :id="'slot_id_' + index" 
                type="radio" 
                v-model="selectedTimeSlot" 
                :value="slot.slot_id" 
                class="time-slot-checkbox" 
                :disabled="slot.status === 0" 
              />
              <span class="checkmark"></span> 
              {{ slot.slot_timing }}
              <span v-if="slot.status === 0" class="unavailable-label">(Unavailable)</span> 
          </label>
          </div>
          
      </div>
      
      <button type="submit">Submit</button>
  </form>
  </div>
</template>

<script>
  import axios from 'axios';
  import { toast } from "vue3-toastify";
  import "vue3-toastify/dist/index.css";

  export default {
  data() {
      return {
      formData: {
          customer_name: '',
          email: '',
          phone_number: '',
          vehicle_model: '',
          date: ''
      },
      showLabel: true,
      availableTimeSlots: [],
      selectedTimeSlot: [],
      minDate: '',
    };
  },
  
  methods: {
      fetchAvailableTimeSlots() {
          // Check if date value exists and is not changed to "cleared"
          console.log(this.formData.date);
          if (this.formData.date == null || this.formData.date == '') {
            return;
          }

          // Get the selected date from the form data
          const selectedDate = new Date(this.formData.date);
          
          // Get the current date
          const currentDate = new Date();

          // Get the day of the week (0 = Sunday, 1 = Monday, ..., 6 = Saturday)
          const dayOfWeek = selectedDate.getDay();

          // Check if the selected day is Monday to Friday (1 to 5)
          if (dayOfWeek === 0 || dayOfWeek === 6) {
            toast.error('Please select a date from Monday to Friday');
            // Clear the date input
            this.formData.date = '';
            return;
          }

          // Call API to fetch available time slots based on selected date
          axios.get(`/get-available-slots?date=${this.formData.date}`).then(response => {
              this.availableTimeSlots = response.data.data;

              // Show time slots
              this.showLabel = true;
          }).catch(error => {
              toast.error('Something Went Wrong');
          });
      },

      submitBookingForm() {
          // Assign the selectedTimeSlot array to the formData object
          this.formData.slot_id = this.selectedTimeSlot;

          if (this.formData.slot_id == null) {
            toast.error('Please select a slot');
            return;
          }

          axios.post('/save-booking', this.formData)
          .then(response => {
          // Handle success response
          toast.success(response.data.message);

          // Clear the form after successful submission
          this.clearForm();

          // Clear the slots
          this.showLabel = false;
          })
          .catch(error => {
            console.log(error);
          // Handle error response
          if (error.response && error.response.data && error.response.data.errors) {
                const errors = error.response.data.errors;

                // Show maximum of only 5 errors
                for (let i = 0; i < Math.min(errors.length, 5); i++) {
                    toast.error(errors[i]);
                }
            } else {
                toast.error('Something Went Wrong');
            }
          });
      },

      clearForm() {
        // Reset formData to its initial state
        this.formData.customer_name = ''; 
        this.formData.email = ''; 
        this.formData.phone_number = ''; 
        this.formData.vehicle_model = ''; 
        this.formData.date = ''; 
        
        // Reset slot selections when date is changed
        this.selectedTimeSlot = null;
      },

  },

  created() {
    // Set minimum date to today
    const today = new Date();
    this.minDate = today.toISOString().split('T')[0];
  },

  watch: {
      'formData.date': function(newDate, oldDate) {
        // Reset slot selections when date is changed
        this.selectedTimeSlot = null;
      }
  },
};

</script>  