<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header bg-primary text-white">Home Component</div>
          <div class="card-body">
            <p class="card-text text-danger text-center">I'm a Home component.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="container mt-5" style="width: 50%;margin-bottom: 50px;">
        <h1 class="mb-4">Employee Form</h1>
        <form @submit.prevent="submitForm">
            <div class="mb-3">
                <label for="firstname" class="form-label">First Name:</label>
                <input type="text" v-model="form.firstname" class="form-control" id="firstname">
            </div>
            <div class="mb-3">
                <label for="lastname" class="form-label">Last Name:</label>
                <input type="text" v-model="form.lastname" class="form-control" id="lastname">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" v-model="form.email" class="form-control" id="email">
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Phone:</label>
                <input type="text" v-model="form.phone" class="form-control" id="phone">
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status:</label>
                <input type="text" v-model="form.status" class="form-control" id="status">
            </div>
            <div class="mb-3">
                <label for="joining_date" class="form-label">Joining Date:</label>
                <input type="date" v-model="form.joining_date" class="form-control" id="joining_date">
            </div>
            <div class="mb-3">
                <label for="leaving_date" class="form-label">Leaving Date:</label>
                <input type="date" v-model="form.leaving_date" class="form-control" id="leaving_date">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

    <div class="container mt-5 mx-auto" style="width: 90%; margin-bottom: 50px;">
      <div class="row mx-auto text-center">
        <div class="col-md-12">
          <h2 class="bold" style="font-size: 20px;">Employee Records</h2>
          <div> <button @click="resetTable">Reset</button></div>
          <table class="table table-striped">
            <thead>
              <tr>
                <th @click="sortBy('id')">
                  ID
                  <i class="fas fa-sort-up" v-if="sortField === 'id' && sortDirection === 'asc'"></i>
                  <i class="fas fa-sort-down" v-if="sortField === 'id' && sortDirection === 'desc'"></i>
                  <i class="fas fa-sort" v-if="sortField !== 'id'"></i>
                </th>
                <th @click="sortBy('firstname')">
                  First Name
                  <i class="fas fa-sort-up" v-if="sortField === 'firstname' && sortDirection === 'asc'"></i>
                  <i class="fas fa-sort-down" v-if="sortField === 'firstname' && sortDirection === 'desc'"></i>
                  <i class="fas fa-sort" v-if="sortField !== 'firstname'"></i>
                </th>
                <th @click="sortBy('lastname')">
                  Last Name
                  <i class="fas fa-sort-up" v-if="sortField === 'lastname' && sortDirection === 'asc'"></i>
                  <i class="fas fa-sort-down" v-if="sortField === 'lastname' && sortDirection === 'desc'"></i>
                  <i class="fas fa-sort" v-if="sortField !== 'lastname'"></i>
                </th>
                <th @click="sortBy('email')">
                  Email
                  <i class="fas fa-sort-up" v-if="sortField === 'email' && sortDirection === 'asc'"></i>
                  <i class="fas fa-sort-down" v-if="sortField === 'email' && sortDirection === 'desc'"></i>
                  <i class="fas fa-sort" v-if="sortField !== 'email'"></i>
                </th>
                <th @click="sortBy('phone')">
                  Phone
                  <i class="fas fa-sort-up" v-if="sortField === 'phone' && sortDirection === 'asc'"></i>
                  <i class="fas fa-sort-down" v-if="sortField === 'phone' && sortDirection === 'desc'"></i>
                  <i class="fas fa-sort" v-if="sortField !== 'phone'"></i>
                </th>
                <th @click="sortBy('status')">
                  Status
                  <i class="fas fa-sort-up" v-if="sortField === 'status' && sortDirection === 'asc'"></i>
                  <i class="fas fa-sort-down" v-if="sortField === 'status' && sortDirection === 'desc'"></i>
                  <i class="fas fa-sort" v-if="sortField !== 'status'"></i>
                </th>
                <th @click="sortBy('joining_date')">
                  Joining Date
                  <i class="fas fa-sort-up" v-if="sortField === 'joining_date' && sortDirection === 'asc'"></i>
                  <i class="fas fa-sort-down" v-if="sortField === 'joining_date' && sortDirection === 'desc'"></i>
                  <i class="fas fa-sort" v-if="sortField !== 'joining_date'"></i>
                </th>
                <th @click="sortBy('leaving_date')">
                  Leaving Date
                  <i class="fas fa-sort-up" v-if="sortField === 'leaving_date' && sortDirection === 'asc'"></i>
                  <i class="fas fa-sort-down" v-if="sortField === 'leaving_date' && sortDirection === 'desc'"></i>
                  <i class="fas fa-sort" v-if="sortField !== 'leaving_date'"></i>
                </th>
              </tr>
            </thead>

            <tbody>
              <tr v-for="employee in filteredEmployees" :key="employee.id">
                <td>{{ employee.id }}</td>
                <td>{{ employee.firstname }}</td>
                <td>{{ employee.lastname }}</td>
                <td>{{ employee.email }}</td>
                <td>{{ employee.phone }}</td>
                <td>{{ employee.status }}</td>
                <td>{{ employee.joining_date }}</td>
                <td>{{ employee.leaving_date }}</td>
              </tr>
            </tbody>
          </table>
          <div class="d-flex justify-content-between">
            <div>
              <button class="btn btn-primary" :disabled="page <= 1" @click="prevPage">Previous</button>
              <span>{{ page }}</span>
              <button class="btn btn-primary" :disabled="page >= totalPages" @click="nextPage">Next</button>
            </div>
            <div>
              <label for="search">Search:</label>
              <input type="text" id="search" v-model="searchTerm" @input="applyFilters">
              <label for="dateFilter">Filter by Date:</label>
              <input type="date" id="dateFilter" v-model="dateFilter" @input="applyFilters">
              <label for="perPage">Per Page:</label>
              <select id="perPage" v-model="perPage" @change="applyFilters">
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="20">20</option>
                <option value="50">50</option>
                <option value="100">100</option>
              </select>
            </div>
          </div>
        </div>
      </div>
    </div>
</template>

<script>
export default {
  data() {
    return {
      form: {
        firstname: '',
        lastname: '',
        email: '',
        phone: '',
        status: '',
        joining_date: '',
        leaving_date: ''
      },
      filteredEmployees: [],
      page: 1,
      totalPages: 0,
      searchTerm: '',
      dateFilter: '',
      perPage: 5, // Default per page value
      sortField: 'id', // Initialize with the default sort field
      sortDirection: 'asc', // Initialize with the default sort direction
    };
  },
  mounted() {
    this.fetchEmployees();
  },
  methods: {
    async fetchEmployees() {
      try {
        const response = await fetch(
          `/api/employees?page=${this.page}&search=${this.searchTerm}&date=${this.dateFilter}&perPage=${this.perPage}&sort=${this.sortField}&direction=${this.sortDirection}`
        );
        const data = await response.json();
        this.filteredEmployees = data.data;
        this.totalPages = data.last_page;
      } catch (error) {
        console.error('Error fetching employees:', error);
      }
    },
    sortBy(field) {
      if (this.sortField === field) {
        this.sortDirection = this.sortDirection === 'asc' ? 'desc' : 'asc';
      } else {
        this.sortField = field;
        this.sortDirection = 'asc';
      }
      this.fetchEmployees();
    },
    async resetTable() {
      this.searchTerm = '';
      this.dateFilter = '';
      this.sortField = 'id';
      this.sortDirection = 'asc';
      this.page = 1;
      this.perPage = 5; // Reset to default per page value
      await this.fetchEmployees();
    },
    applyFilters() {
      this.page = 1; // Reset page to 1 when filters change
      this.fetchEmployees();
    },
    async prevPage() {
      if (this.page > 1) {
        this.page--;
        await this.fetchEmployees();
      }
    },
    async nextPage() {
      if (this.page < this.totalPages) {
        this.page++;
        await this.fetchEmployees();
      }
    },
    async submitForm() {
      const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

      if (!csrfToken) {
        alert('CSRF token not found');
        return;
      }

      try {
        const response = await fetch('/api/employees', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrfToken
          },
          body: JSON.stringify(this.form)
        });

        if (!response.ok) {
          throw new Error('Failed to submit form');
        }

        const data = await response.json();
        alert('Form submitted successfully');
        await this.fetchEmployees(); // Refresh employees list after submission
      } catch (error) {
        console.error('Error submitting form:', error);
        alert('An error occurred while submitting the form');
      }
    },
  },
};
</script>

<style>
.fas {
  margin-left: 5px;
  color: grey;
}
</style>
