<template>
  <div class="container">
    <div class="button-container">
      <a href="/admin" class="admin-button">Admin Panel</a>
      <a href="/book-slots" class="booking-button">Booking Page</a>
    </div>
  </div>
</template>

<style>
.container {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
}

.button-container {
  text-align: center;
}

.admin-button,
.booking-button {
  padding: 10px 20px;
  margin: 10px;
  font-size: 18px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  text-decoration: none; /* Remove underline from anchor tags */
  display: inline-block; /* Make anchor tags behave like buttons */
  color: white;
}

.admin-button {
  background-color: #007bff; /* Blue color */
}

.booking-button {
  background-color: #28a745; /* Green color */
}
</style>
