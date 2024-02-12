<template>
  <div id="app">
    <div class="sidebar">
      <ul>
        <router-link to="/admin/show-bookings"><li @click="selectedTab = 'showBookings'" :class="{ 'active': selectedTab === 'showBookings' }">Show Bookings</li></router-link>
        <router-link to="/admin/disable-slots"><li @click="selectedTab = 'disabledSlots'" :class="{ 'active': selectedTab === 'disabledSlots' }">Disable Slots</li></router-link>
      </ul>
    </div>

    <div class="content">
      <router-view></router-view>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      selectedTab: 'showBookings'
    };
  }
};
</script>

<style>
#app {
  display: flex;
}

.sidebar {
  width: 200px;
  background-color: #f0f0f0;
  padding: 20px;
}

.sidebar h2 {
  margin-bottom: 20px;
}

.sidebar ul {
  list-style-type: none;
  padding: 0;
}

.sidebar ul li {
  cursor: pointer;
  padding: 10px;
  transition: background-color 0.3s;
}

.sidebar ul li:hover {
  background-color: #ddd;
}

.sidebar ul li.active {
  background-color: #ccc;
}

.content {
  flex: 1;
  padding: 20px;
}
</style>
