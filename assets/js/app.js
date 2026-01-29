/**
 * Nurdaya Store - Main JavaScript
 */

document.addEventListener('DOMContentLoaded', function() {
    // Initialize all components
    initDropdowns();
    initForms();
    initAlerts();
});

/**
 * Initialize dropdown menus
 */
function initDropdowns() {
    const dropdowns = document.querySelectorAll('.user-dropdown');

    dropdowns.forEach(dropdown => {
        const toggle = dropdown.querySelector('.dropdown-toggle');
        const menu = dropdown.querySelector('.dropdown-menu');

        if (toggle && menu) {
            toggle.addEventListener('click', function(e) {
                e.stopPropagation();
                menu.classList.toggle('show');
            });
        }
    });

    // Close dropdowns when clicking outside
    document.addEventListener('click', function() {
        document.querySelectorAll('.dropdown-menu.show').forEach(menu => {
            menu.classList.remove('show');
        });
    });
}

/**
 * Initialize form validation
 */
function initForms() {
    const forms = document.querySelectorAll('form[data-validate]');

    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!validateForm(form)) {
                e.preventDefault();
            }
        });
    });
}

/**
 * Validate form
 */
function validateForm(form) {
    let isValid = true;
    const required = form.querySelectorAll('[required]');

    required.forEach(field => {
        clearError(field);

        if (!field.value.trim()) {
            showError(field, 'This field is required');
            isValid = false;
        }
    });

    // Email validation
    const emails = form.querySelectorAll('[type="email"]');
    emails.forEach(field => {
        if (field.value && !isValidEmail(field.value)) {
            showError(field, 'Please enter a valid email');
            isValid = false;
        }
    });

    return isValid;
}

/**
 * Show field error
 */
function showError(field, message) {
    field.classList.add('is-invalid');
    const error = document.createElement('div');
    error.className = 'invalid-feedback';
    error.textContent = message;
    field.parentNode.appendChild(error);
}

/**
 * Clear field error
 */
function clearError(field) {
    field.classList.remove('is-invalid');
    const error = field.parentNode.querySelector('.invalid-feedback');
    if (error) {
        error.remove();
    }
}

/**
 * Validate email format
 */
function isValidEmail(email) {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
}

/**
 * Initialize auto-dismiss alerts
 */
function initAlerts() {
    const alerts = document.querySelectorAll('.alert[data-auto-dismiss]');

    alerts.forEach(alert => {
        const timeout = parseInt(alert.dataset.autoDismiss) || 5000;
        setTimeout(() => {
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 300);
        }, timeout);
    });
}

/**
 * Show loading state on button
 */
function setLoading(button, loading = true) {
    if (loading) {
        button.disabled = true;
        button.dataset.originalText = button.innerHTML;
        button.innerHTML = '<span class="spinner"></span> Loading...';
    } else {
        button.disabled = false;
        button.innerHTML = button.dataset.originalText;
    }
}

/**
 * AJAX helper function
 */
async function fetchData(url, options = {}) {
    const defaultOptions = {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
        },
    };

    const response = await fetch(url, { ...defaultOptions, ...options });

    if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`);
    }

    return response.json();
}

/**
 * POST data helper
 */
async function postData(url, data) {
    const formData = new FormData();

    for (const key in data) {
        formData.append(key, data[key]);
    }

    return fetchData(url, {
        method: 'POST',
        body: formData,
    });
}

/**
 * Confirm dialog
 */
function confirmAction(message) {
    return confirm(message);
}

/**
 * Format price
 */
function formatPrice(price) {
    return 'RM ' + parseFloat(price).toFixed(2);
}

/**
 * Logout function
 */
function logout() {
    if (confirmAction('Are you sure you want to logout?')) {
        window.location.href = '?page=logout';
    }
}
