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

  <div class="container mt-5" style="width: 50%; margin-bottom: 50px;">
    <h1 class="mb-4">Employee Form</h1>
    <form @submit.prevent="submitForm">
      <!-- Form inputs -->
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

        <div class="d-flex align-items-center justify-content-end my-2">
          <div class="me-3">
            <label for="search" class="me-2">Search:</label>
            <input type="text" id="search" v-model="searchTerm" @input="applyFilters" class="form-control">
          </div>
          <div class="me-3">
            <label for="dateFilter" class="me-2">Filter by Date:</label>
            <input type="date" id="dateFilter" v-model="dateFilter" @input="applyFilters" class="form-control">
          </div>
          <!-- <button @click="resetTable" class="btn btn-primary mt-4">Reset</button> -->
          <button @click="resetTable" :class="{ 'btn btn-primary mt-4': true, 'btn-warning': hasFilters }"
            class="btn mt-4">Reset</button>

        </div>

        <div class="d-flex justify-content-between align-items-center mb-3">
          <div>
            <button @click="deleteSelected" class="btn btn-danger">Delete Selected</button>
            <button type="button" @click="exportToExcel" class="btn btn-outline-success p-2 mx-2">
              <i :class="loading ? 'fa fa-spinner' : 'fa fa-download'"></i>
              Export to
              Excel</button>
            <button @click="openSendMailModal" :disabled="selectedEmployees.length === 0" class="btn btn-info">Send
              Mail</button>

          </div>
        </div>

        <table class="table table-striped">
          <thead>
            <tr>
              <th>
                <input type="checkbox" @change="toggleSelectAll" v-model="selectAll">
              </th>
              <th class="cursor-pointer" @click="sortBy('id')">
                ID
                <i class="fas fa-sort-up" v-if="sortField === 'id' && sortDirection === 'asc'"></i>
                <i class="fas fa-sort-down" v-if="sortField === 'id' && sortDirection === 'desc'"></i>
                <i class="fas fa-sort" v-if="sortField !== 'id'"></i>
              </th>
              <th class="cursor-pointer" @click="sortBy('firstname')">
                First Name
                <i class="fas fa-sort-up" v-if="sortField === 'firstname' && sortDirection === 'asc'"></i>
                <i class="fas fa-sort-down" v-if="sortField === 'firstname' && sortDirection === 'desc'"></i>
                <i class="fas fa-sort" v-if="sortField !== 'firstname'"></i>
              </th>
              <th class="cursor-pointer" @click="sortBy('lastname')">
                Last Name
                <i class="fas fa-sort-up" v-if="sortField === 'lastname' && sortDirection === 'asc'"></i>
                <i class="fas fa-sort-down" v-if="sortField === 'lastname' && sortDirection === 'desc'"></i>
                <i class="fas fa-sort" v-if="sortField !== 'lastname'"></i>
              </th>
              <th class="cursor-pointer" @click="sortBy('email')">
                Email
                <i class="fas fa-sort-up" v-if="sortField === 'email' && sortDirection === 'asc'"></i>
                <i class="fas fa-sort-down" v-if="sortField === 'email' && sortDirection === 'desc'"></i>
                <i class="fas fa-sort" v-if="sortField !== 'email'"></i>
              </th>
              <th class="cursor-pointer" @click="sortBy('phone')">
                Phone
                <i class="fas fa-sort-up" v-if="sortField === 'phone' && sortDirection === 'asc'"></i>
                <i class="fas fa-sort-down" v-if="sortField === 'phone' && sortDirection === 'desc'"></i>
                <i class="fas fa-sort" v-if="sortField !== 'phone'"></i>
              </th>
              <th class="cursor-pointer" @click="sortBy('status')">
                Status
                <i class="fas fa-sort-up" v-if="sortField === 'status' && sortDirection === 'asc'"></i>
                <i class="fas fa-sort-down" v-if="sortField === 'status' && sortDirection === 'desc'"></i>
                <i class="fas fa-sort" v-if="sortField !== 'status'"></i>
              </th>
              <th class="cursor-pointer" @click="sortBy('joining_date')">
                Joining Date
                <i class="fas fa-sort-up" v-if="sortField === 'joining_date' && sortDirection === 'asc'"></i>
                <i class="fas fa-sort-down" v-if="sortField === 'joining_date' && sortDirection === 'desc'"></i>
                <i class="fas fa-sort" v-if="sortField !== 'joining_date'"></i>
              </th>
              <th class="cursor-pointer" @click="sortBy('leaving_date')">
                Leaving Date
                <i class="fas fa-sort-up" v-if="sortField === 'leaving_date' && sortDirection === 'asc'"></i>
                <i class="fas fa-sort-down" v-if="sortField === 'leaving_date' && sortDirection === 'desc'"></i>
                <i class="fas fa-sort" v-if="sortField !== 'leaving_date'"></i>
              </th>
            </tr>
          </thead>

          <tbody>
            <tr v-for="employee in filteredEmployees" :key="employee.id">
              <td>
                <input type="checkbox" v-model="selectedEmployees" :value="employee.id">
              </td>
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



  <!-- Send Mail Modal -->
  <div class="modal" tabindex="-1" role="dialog" ref="sendMailModal">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Send Mail</h5>
          <button type="button" class="close" @click="closeSendMailModal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form @submit.prevent="sendMail" enctype="multipart/form-data">
            <!-- <div class="form-group">
              <label for="emailSubject">Subject</label>
              <input type="text" class="form-control" id="emailSubject" v-model="emailSubject">
          </div>
          <div class="form-group">
            <label for="emailBody">Message</label>
            <div ref="quillEditor" style="min-height: 200px;"></div>
          </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" @click="closeSendMailModal">Close</button>
          <button type="button" class="btn btn-primary" @click="sendMail">Send Mail</button>
        </div> -->
            <div class="mb-3">
              <label for="emailSubject" class="form-label">Subject</label>
              <input type="text" id="emailSubject" v-model="emailSubject" class="form-control">
            </div>
            <div class="mb-3">
              <label for="emailBody" class="form-label">Body</label>
              <!-- Quill Editor Container -->
              <div ref="quillEditor" id="quillEditor" style="min-height: 200px;"></div>
            </div>
            <!-- File Upload -->
            <div class="mb-3">
              <label for="fileUpload" class="form-label">Attach File</label>
              <input type="file" id="fileUpload" @change="handleFileUpload($event)" class="form-control">
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" @click="closeSendMailModal">Close</button>
              <button type="submit" class="btn btn-primary">Send</button>
            </div>
          </form>
        </div>

      </div>
    </div>
  </div>
</template>



<script>
import { ref, onMounted } from 'vue';
import Quill from 'quill';
import 'quill/dist/quill.snow.css';
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
      loading: false,
      filteredEmployees: [],
      page: 1,
      totalPages: 0,
      searchTerm: '',
      dateFilter: '',
      perPage: 5, // Default per page value
      sortField: 'id', // Initialize with the default sort field
      sortDirection: 'asc', // Initialize with the default sort direction
      selectedEmployees: [], // Track selected employees
      selectAll: false, // Track select all state
      emailSubject: '', // Subject for the email
      emailBody: '', // Body of the email
      quillEditor: null,
      attachedFile: null,
    };
  },
  mounted() {
    this.fetchEmployees();

    this.initializeQuill();
  },
  computed: {
    hasFilters() {
      return this.searchTerm || this.dateFilter;
    }
  },
  watch: {
    selectedEmployees(newVal) {
      this.selectAll = newVal.length === this.filteredEmployees.length;
    }
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
    toggleSelectAll() {
      if (this.selectAll) {
        this.selectedEmployees = this.filteredEmployees.map(employee => employee.id);
        console.log(this.selectedEmployees);
      } else {
        this.selectedEmployees = [];
      }
    },
    async deleteSelected() {
      if (this.selectedEmployees.length === 0) {
        alert('No employees selected');
        return;
      }
      const confirmed = confirm('Are you sure you want to delete the selected employees?');
      if (!confirmed) {
        return;
      }
      try {
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        const response = await fetch('/api/employees/delete', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrfToken
          },
          body: JSON.stringify({ ids: this.selectedEmployees })
        });

        if (!response.ok) {
          throw new Error('Failed to delete employees');
        }

        alert('Employees deleted successfully');
        this.selectedEmployees = [];
        await this.fetchEmployees();
      } catch (error) {
        console.error('Error deleting employees:', error);
        alert('An error occurred while deleting employees');
      }
    },

    async exportToExcel() {
      if (!this.loading) {
        this.loading = true;
        try {

          const response = await fetch('/api/employees/export');
          if (!response.ok) {
            throw new Error('Failed to export data');
          }

          const blob = await response.blob();
          const url = window.URL.createObjectURL(blob);
          const link = document.createElement('a');
          link.href = url;
          link.setAttribute('download', 'employees.xlsx');
          document.body.appendChild(link);
          link.click();
          link.parentNode.removeChild(link);

        } catch (error) {
          console.error('Error exporting data:', error);
          alert('An error occurred while exporting data');
        }
        this.loading = false;
      }
    },
    openSendMailModal() {
      this.$refs.sendMailModal.style.display = 'block';
    },
    closeSendMailModal() {
      this.$refs.sendMailModal.style.display = 'none';
    },

    initializeQuill() {
      this.quillEditor = new Quill(this.$refs.quillEditor, {
        theme: 'snow',
        modules: {
          toolbar: [
            [{ 'header': '1' }, { 'header': '2' }, { 'font': [] }],
            [{ 'list': 'ordered' }, { 'list': 'bullet' }],
            ['bold', 'italic', 'underline'],
            ['link', 'image', 'video'],
            ['clean']
          ],
        },
      });
    },


    handleFileUpload(event) {
      this.attachedFile = event.target.files[0]; // Store the selected file
    },

    sendMail() {
      const emailBody = this.quillEditor.root.innerHTML;
      const formData = new FormData();
      formData.append('subject', this.emailSubject);
      formData.append('body', emailBody);
      formData.append('selectedEmployees', JSON.stringify(this.selectedEmployees));

      if (this.attachedFile) {
        formData.append('file', this.attachedFile); // Append attached file to FormData
      }

      // Fetch CSRF token from meta tag
      const csrfToken = document.head.querySelector('meta[name="csrf-token"]').content;

      fetch('/api/send-email', {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': csrfToken // Include CSRF token in headers
        },
        body: formData
      })
        .then(response => {
          if (!response.ok) {
            throw new Error('Failed to send email');
          }
          alert('Email sent successfully');
          this.emailSubject = '';
          this.quillEditor.root.innerHTML = '';
          this.attachedFile = null;
          this.closeSendMailModal(); // Close modal after sending
        })
        .catch(error => {
          console.error('Error sending email:', error);
          alert('An error occurred while sending the email');
        });
    },


  }
};
</script>

<style>
.fas {
  margin-left: 5px;
  color: grey;
}

.modal {
  display: none;
  position: fixed;
  z-index: 1050;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  overflow: hidden;
  outline: 0;
}

.modal-dialog {
  max-width: 500px;
  margin: 30px auto;
}

.modal-content {
  position: relative;
  display: flex;
  flex-direction: column;
  background-color: #fff;
  background-clip: padding-box;
  border: 1px solid rgba(0, 0, 0, 0.2);
  border-radius: 0.3rem;
  outline: 0;
}

.modal-header {
  display: flex;
  align-items: flex-start;
  justify-content: space-between;
  padding: 1rem;
  border-bottom: 1px solid #dee2e6;
  border-top-left-radius: 0.3rem;
  border-top-right-radius: 0.3rem;
}

.modal-body {
  position: relative;
  flex: 1 1 auto;
  padding: 1rem;
}

.modal-footer {
  display: flex;
  align-items: center;
  justify-content: flex-end;
  padding: 1rem;
  border-top: 1px solid #dee2e6;
}
</style>
