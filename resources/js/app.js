import './bootstrap';

import Alpine from 'alpinejs';
import { createApp } from 'vue';

// Register Alpine.js
window.Alpine = Alpine;
Alpine.start();

// Import Vue components
import ContactForm from './components/ContactForm.vue';

// Initialize Vue for specific components when they exist in the DOM
document.addEventListener('DOMContentLoaded', () => {
    // Mount contact form component if it exists
    const contactFormElement = document.getElementById('vue-contact-form');
    if (contactFormElement) {
        createApp(ContactForm).mount('#vue-contact-form');
    }
});
