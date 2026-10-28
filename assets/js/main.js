var registrationForm = document.getElementById('registration-form');

var navigationToggle = document.querySelector('.nav-toggle');
var mainNavigation = document.getElementById('main-navigation');

if (navigationToggle && mainNavigation) {
    navigationToggle.addEventListener('click', function () {
        var isOpen = mainNavigation.classList.toggle('nav-open');
        navigationToggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
    });

    mainNavigation.querySelectorAll('a').forEach(function (link) {
        link.addEventListener('click', function () {
            mainNavigation.classList.remove('nav-open');
            navigationToggle.setAttribute('aria-expanded', 'false');
        });
    });
}

if (registrationForm) {
    var passwordInput = document.getElementById('password');
    var confirmPasswordInput = document.getElementById('confirm_password');

    function validatePasswordConfirmation() {
        if (confirmPasswordInput.value !== passwordInput.value) {
            confirmPasswordInput.setCustomValidity('Passwords do not match.');
        } else {
            confirmPasswordInput.setCustomValidity('');
        }
    }

    passwordInput.addEventListener('input', validatePasswordConfirmation);
    confirmPasswordInput.addEventListener('input', validatePasswordConfirmation);

    registrationForm.addEventListener('submit', function (event) {
        validatePasswordConfirmation();

        if (!registrationForm.checkValidity()) {
            event.preventDefault();
            registrationForm.reportValidity();
        }
    });
}

var experienceLevelSelect = document.getElementById('experience_level');
var priceGuidance = document.getElementById('price-guidance');

if (experienceLevelSelect && priceGuidance) {
    var suggestedPrices = {
        Beginner: 'Suggested price: Rs. 500 – Rs. 1,000/hour',
        Intermediate: 'Suggested price: Rs. 1,000 – Rs. 2,000/hour',
        Advanced: 'Suggested price: Rs. 2,000 – Rs. 4,000/hour',
        Expert: 'Suggested price: Rs. 4,000+/hour'
    };

    function updatePriceGuidance() {
        priceGuidance.textContent = suggestedPrices[experienceLevelSelect.value] || '';
    }

    experienceLevelSelect.addEventListener('change', updatePriceGuidance);
    updatePriceGuidance();
}

var deleteSkillForms = document.querySelectorAll('.delete-skill-form');

deleteSkillForms.forEach(function (form) {
    form.addEventListener('submit', function (event) {
        if (!window.confirm('Are you sure you want to delete this teaching skill?')) {
            event.preventDefault();
        }
    });
});

var adminDeleteForms = document.querySelectorAll('.admin-delete-form');

adminDeleteForms.forEach(function (form) {
    form.addEventListener('submit', function (event) {
        if (!window.confirm('Are you sure you want to delete this item?')) {
            event.preventDefault();
        }
    });
});
