document.addEventListener('DOMContentLoaded', function () {
    const signUpForm = document.querySelector('.sign-up-form');
    const passwordInput = signUpForm.querySelector('input[name="password"]');
    const rePasswordInput = signUpForm.querySelector('input[name="repassword"]');
    const signUpButton = signUpForm.querySelector('input[type="submit"]');
    const passwordError = signUpForm.querySelector('.password-error');
    const rePasswordError = signUpForm.querySelector('.repassword-error');

    signUpButton.disabled = true; // Initially disable sign-up button

    // Function to check if password meets the required format
    function isPasswordValid(password) {
        // Password must be at least 8 characters long, contain one uppercase letter, one special character, and one number
        const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
        return passwordRegex.test(password);
    }

    // Function to display error messages
    function displayError(input, message) {
        const errorElement = input.nextElementSibling;
        errorElement.textContent = message;
        errorElement.style.display = 'block';
    }

    // Function to hide error messages
    function hideError(input) {
        const errorElement = input.nextElementSibling;
        errorElement.textContent = '';
        errorElement.style.display = 'none';
    }

    // Function to handle form submission
    function handleFormSubmission(event) {
        const password = passwordInput.value;
        const rePassword = rePasswordInput.value;

        if (!isPasswordValid(password)) {
            displayError(passwordInput, 'Password must be at least 8 characters long, contain one uppercase letter, one special character, and one number.');
            event.preventDefault(); // Prevent form submission
        } else {
            hideError(passwordInput);
        }

        if (password !== rePassword) {
            displayError(rePasswordInput, 'Passwords do not match.');
            event.preventDefault(); // Prevent form submission
        } else {
            hideError(rePasswordInput);
        }
    }

    // Add event listener for form submission
    signUpForm.addEventListener('submit', handleFormSubmission);

    // Function to enable/disable sign-up button based on password validity
    function handlePasswordInput() {
        const password = passwordInput.value;
        const rePassword = rePasswordInput.value;

        if (isPasswordValid(password) && password === rePassword) {
            signUpButton.disabled = false;
        } else {
            signUpButton.disabled = true;
        }
    }

    // Add event listeners for password input fields
    passwordInput.addEventListener('input', handlePasswordInput);
    rePasswordInput.addEventListener('input', handlePasswordInput);
});