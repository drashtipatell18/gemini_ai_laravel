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

document.getElementById('toggleConfirmPassword').addEventListener('click', function () {
    const confirmPassword = document.getElementById('confirmPassword');
    const type = confirmPassword.type === 'password' ? 'text' : 'password';
    confirmPassword.type = type;
    this.textContent = type === 'password' ? 'visibility' : 'visibility_off';
});

document.getElementById('signInForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const name = document.getElementById('name');
    const email = document.getElementById('email');
    const password = document.getElementById('password');
    const confirmPassword = document.getElementById('confirmPassword');

    const nameError = document.getElementById('nameError');
    const emailError = document.getElementById('emailError');
    const passwordError = document.getElementById('passwordError');
    const confirmError = document.getElementById('confirmError');

    // Reset error messages
    nameError.classList.add('hidden');
    emailError.classList.add('hidden');
    passwordError.classList.add('hidden');
    confirmError.classList.add('hidden');

    let isValid = true;

    // Name validation
    if (!name.value) {
        nameError.textContent = 'Please enter a valid name.';
        nameError.classList.remove('hidden');
        isValid = false;
    } else if (name.value.trim().length < 3) {
        nameError.textContent = 'Name must be at least 3 characters.';
        nameError.classList.remove('hidden');
        isValid = false;
    }

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
    } else if (password.value.length < 6) {
        passwordError.textContent = 'Password must be at least 6 characters.';
        passwordError.classList.remove('hidden');
        isValid = false;
    }

    // Confirm password match
    if (password.value !== confirmPassword.value) {
        confirmError.textContent = 'Passwords do not match.';
        confirmError.classList.remove('hidden');
        isValid = false;
    }

    if (!isValid) return;

    // Show loading state
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.textContent;
    submitBtn.textContent = 'Creating Account...';
    submitBtn.disabled = true;

    // Submit if all valid
    fetch(`${getBaseUrl()}/signupStore`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': getCsrfToken(),
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            name: name.value.trim(),
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
        // Success - redirect to dashboard or home
        window.location.href = `${getBaseUrl()}/login`;
    })
    .catch(error => {
        console.error('Error:', error);

        // Reset button state
        submitBtn.textContent = originalText;
        submitBtn.disabled = false;

        // Handle validation errors from server
        if (error.errors) {
            if (error.errors.name) {
                nameError.textContent = error.errors.name[0];
                nameError.classList.remove('hidden');
            }
            if (error.errors.email) {
                emailError.textContent = error.errors.email[0];
                emailError.classList.remove('hidden');
            }
            if (error.errors.password) {
                passwordError.textContent = error.errors.password[0];
                passwordError.classList.remove('hidden');
            }
        } else {
            alert('Failed to create account. Please try again.');
        }
    });
});
