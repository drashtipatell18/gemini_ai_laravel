// Get base URL from meta tag or current location
const getBaseUrl = () => {
    const metaBaseUrl = document.querySelector('meta[name="base-url"]');
    return metaBaseUrl ? metaBaseUrl.getAttribute('content') : window.location.origin;
};

// Get CSRF token
const getCsrfToken = () => {
    const metaCsrf = document.querySelector('meta[name="csrf-token"]');
    return metaCsrf ? metaCsrf.getAttribute('content') : '';
};

document.getElementById('togglePassword').addEventListener('click', function () {
    const password = document.getElementById('password');
    const type = password.type === 'password' ? 'text' : 'password';
    password.type = type;
    this.textContent = type === 'password' ? 'visibility' : 'visibility_off';
});

document.getElementById('loginForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const email = document.getElementById('email');
    const password = document.getElementById('password');
    const emailError = document.getElementById('emailError');
    const passwordError = document.getElementById('passwordError');

    // Reset error messages
    emailError.classList.add('hidden');
    passwordError.classList.add('hidden');

    let isValid = true;

    // Email validation
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailPattern.test(email.value.trim())) {
        emailError.textContent = 'Please enter a valid email.';
        emailError.classList.remove('hidden');
        isValid = false;
    }

    // Password validation
    if (!password.value) {
        passwordError.textContent = 'Please enter a password.';
        passwordError.classList.remove('hidden');
        isValid = false;
    }

    if (!isValid) return;

    // Show loading state
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.textContent;
    submitBtn.textContent = 'Signing In...';
    submitBtn.disabled = true;

    // Submit login request
    fetch(`${getBaseUrl()}/loginStore`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': getCsrfToken(),
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                email: email.value.trim(),
                password: password.value
            })
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => Promise.reject(err));
            }
            return response.json();
        })
        .then(data => {
            // Success - redirect to dashboard
            window.location.href = `${getBaseUrl()}`;
        })
        .catch(error => {
            console.error('Error:', error);

            // Reset button state
            submitBtn.textContent = originalText;
            submitBtn.disabled = false;

            // Handle validation errors from server
            if (error.errors) {
                if (error.errors.email) {
                    emailError.textContent = error.errors.email[0];
                    emailError.classList.remove('hidden');
                }
                if (error.errors.password) {
                    passwordError.textContent = error.errors.password[0];
                    passwordError.classList.remove('hidden');
                }
            } else {
                alert('Login failed. Please check your credentials and try again.');
            }
        });
});

