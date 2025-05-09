//
Contact
form
JavaScript

// Contact form JavaScript with Toastr notifications

document.addEventListener('DOMContentLoaded', function() {
    // Get the contact form
    const contactForm = document.querySelector('form[action*="contact"]');
    
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Show loading state
            const submitButton = contactForm.querySelector('button[type="submit"]');
            const originalButtonText = submitButton.innerHTML;
            submitButton.disabled = true;
            submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Sending...';
            
            // Get form data
            const formData = new FormData(contactForm);
            
            // Get CSRF token
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
            // Send AJAX request
            fetch('/contact', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': token,
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                // Show toast notification
                if (data.toast) {
                    toastr[data.toast.type](data.toast.message, data.toast.title);
                }
                
                // Reset form on success
                if (data.success) {
                    contactForm.reset();
                }
                
                // Restore button state
                submitButton.disabled = false;
                submitButton.innerHTML = originalButtonText;
                
                // Redirect if needed
                if (data.redirect) {
                    window.location.href = data.redirect;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                toastr.error('An unexpected error occurred. Please try again later.');
                
                // Restore button state
                submitButton.disabled = false;
                submitButton.innerHTML = originalButtonText;
            });
        });
    }
});
