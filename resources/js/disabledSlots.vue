<template>
    <div class="form-container">
      <h2>Disable Slots</h2>
      <form id="disableSlots" @submit.prevent="disableSlotsForm">
        
        <div class="form-group">
          <label for="date">Date of Booking:</label>
          <input type="date" id="date" v-model="formData.date" @change="fetchAvailableTimeSlots" :min="minDate" required />
        </div>

        <!-- Checkboxes generated based on API response -->
        <div v-if="availableTimeSlots.length > 0" class="time-slots">
          <div v-if="showLabel">
            <p>Time Slots</p>
            <label  v-for="(slot, index) in availableTimeSlots" :key="index" class="time-slot-label">
        
                <input
                :id="'slot_id_' + index"
                type="checkbox"
                v-model="selectedTimeSlots[index]"
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
          date: ''
        },
        showLabel: true,
        availableTimeSlots: [],
        selectedTimeSlots: []
      };
    },

    created() {
        // Initialize selectedTimeSlots with null values
        this.selectedTimeSlots = Array(this.availableTimeSlots.length).fill(null);

        // Set minimum date to today
        const today = new Date();
        this.minDate = today.toISOString().split('T')[0];
    },
    
    methods: {
      fetchAvailableTimeSlots() {
        // Check if date value exists and is not changed to "cleared"
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
        axios.get(`/get-available-slots?date=${this.formData.date}`)
          .then(response => {
            this.availableTimeSlots = response.data.data;
            
            // Show time slots
            this.showLabel = true;

            // Reset selectedTimeSlots when date is changed
            this.selectedTimeSlots = Array(this.availableTimeSlots.length).fill(false);
          })
          .catch(error => {
            toast.error('Something went wrong');
          });
      },

    disableSlotsForm() {
        // Filter out only the selected slots
        const selectedSlots = this.availableTimeSlots.filter((slot, index) => this.selectedTimeSlots[index]);
  
        if (selectedSlots.length === 0) {
          toast.error('Please select at least one slot');
          return;
        }

        // Extract the slot_ids from the selected slots
        const selectedSlotIds = selectedSlots.map(slot => slot.slot_id);
        
        // Assign the selected slot_ids to the formData object
        this.formData.slot_ids = selectedSlotIds;
  
        axios.post('/disable-slots', this.formData)
          .then(response => {
            toast.success(response.data.message);
            
            // Clear the form after successful submission
            this.clearForm();

            // Clear the slots
            this.showLabel = false;
          })
          .catch(error => {
            if (error.response && error.response.data && error.response.data.errors) {
              const errors = error.response.data.errors;

              // Display multiple errors but not more than 5 at a time
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
        this.formData.date = ''; // Reset date field
        
        // Reset selectedTimeSlots to an array of null values
        this.selectedTimeSlots = Array(this.availableTimeSlots.length).fill(null);
    }
    },
  };
  </script>
  