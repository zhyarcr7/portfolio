<template>
  <div>
    <div v-if="successMessage" class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
      {{ successMessage }}
    </div>
    
    <div v-if="errorMessage" class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg" role="alert">
      {{ errorMessage }}
    </div>
    
    <form @submit.prevent="submitForm" class="space-y-6">
      <div>
        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Name</label>
        <input 
          type="text" 
          id="name" 
          v-model="form.name" 
          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-800 dark:text-white dark:border-gray-700" 
          :class="{'border-red-500': errors.name}"
          required
        >
        <p v-if="errors.name" class="mt-1 text-sm text-red-600">{{ errors.name[0] }}</p>
      </div>
      
      <div>
        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email Address</label>
        <input 
          type="email" 
          id="email" 
          v-model="form.email" 
          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-800 dark:text-white dark:border-gray-700" 
          :class="{'border-red-500': errors.email}"
          required
        >
        <p v-if="errors.email" class="mt-1 text-sm text-red-600">{{ errors.email[0] }}</p>
      </div>
      
      <div>
        <label for="subject" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Subject</label>
        <input 
          type="text" 
          id="subject" 
          v-model="form.subject" 
          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-800 dark:text-white dark:border-gray-700" 
          :class="{'border-red-500': errors.subject}"
          required
        >
        <p v-if="errors.subject" class="mt-1 text-sm text-red-600">{{ errors.subject[0] }}</p>
      </div>
      
      <div>
        <label for="message" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Message</label>
        <textarea 
          id="message" 
          v-model="form.message" 
          rows="4" 
          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-800 dark:text-white dark:border-gray-700" 
          :class="{'border-red-500': errors.message}"
          required
        ></textarea>
        <p v-if="errors.message" class="mt-1 text-sm text-red-600">{{ errors.message[0] }}</p>
      </div>
      
      <div>
        <button 
          type="submit" 
          :disabled="isSubmitting"
          class="w-full py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-[#FF750F] hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-all duration-200"
          :class="{'opacity-75 cursor-not-allowed': isSubmitting}"
        >
          <span v-if="isSubmitting">
            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
              <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Sending...
          </span>
          <span v-else>Send Message</span>
        </button>
      </div>
    </form>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      form: {
        name: '',
        email: '',
        subject: '',
        message: ''
      },
      errors: {},
      isSubmitting: false,
      successMessage: '',
      errorMessage: ''
    }
  },
  methods: {
    async submitForm() {
      this.isSubmitting = true;
      this.errors = {};
      this.successMessage = '';
      this.errorMessage = '';
      
      try {
        // Get the CSRF token from the meta tag
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        // Make the AJAX request
        const response = await axios.post('/contact', this.form, {
          headers: {
            'X-CSRF-TOKEN': token
          }
        });
        
        // Handle success
        this.successMessage = 'Thank you! Your message has been sent successfully.';
        this.form = {
          name: '',
          email: '',
          subject: '',
          message: ''
        };
        
      } catch (error) {
        // Handle validation errors
        if (error.response && error.response.status === 422) {
          this.errors = error.response.data.errors;
        } else {
          // Handle other errors
          this.errorMessage = 'Sorry, there was a problem sending your message. Please try again later.';
          console.error('Error:', error);
        }
      } finally {
        this.isSubmitting = false;
      }
    }
  }
}
</script> 