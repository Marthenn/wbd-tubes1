const username_input = document.getElementById('username');
const password_input = document.getElementById('password');
const email_input = document.getElementById('email');
const confirm_password_input = document.getElementById('confirm-password');

const username_error = document.getElementById('username-error-msg');
const password_error = document.getElementById('password-error-msg');
const email_error = document.getElementById('email-error-msg');
const confirm_password_error = document.getElementById('confirm-password-error-msg');

const submit_button = document.querySelector('.submit-button');

const emailRegex = /^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{1,256}$/i;
const usernameRegex = /^[a-zA-Z0-9][a-zA-Z0-9_]{2,15}$/;

let usernameIsValid = false;
let emailIsValid = false;
let passwordIsValid = false;
let confirmPasswordIsValid = false;

username_input && username_input.addEventListener(
    'keyup',
    debounce(() => {
        const username = username_input.value;
        usernameIsValid = (usernameRegex.test(username) && username.length >= 3 && username.length <= 16);
        if (username.length < 3 || username.length > 16){
            username_error.innerHTML = "Username must be between 3 and 16 characters long!";
        } else if (username.startsWith('_')){
            username_error.innerHTML = "Username cannot start with an underscore!";
        }else if (!usernameRegex.test(username)){
            username_error.innerHTML = "Username must only contain letters, numbers, and underscores!";
        } else {
            username_error.innerHTML = "";
        }
    }
))

email_input && email_input.addEventListener(
    'keyup',
    debounce(() => {
        const email = email_input.value;
        emailIsValid = emailRegex.test(email);
        if (emailIsValid) {
            email_error.innerHTML = "";
        } else {
            email_error.innerHTML = "Email format not valid!";
        }
    }
))

password_input && password_input.addEventListener(
    'keyup',
    debounce(() => {
        const password = password_input.value;
        const confirm_password = confirm_password_input.value;
        passwordIsValid = password.length >= 8;
        if (passwordIsValid) {
            password_error.innerHTML = "";
        } else {
            password_error.innerHTML = "Password must be at least 8 characters long!";
        }
        confirmPasswordIsValid = password === confirm_password;
        if (confirmPasswordIsValid) {
            confirm_password_error.innerHTML = "";
        } else {
            confirm_password_error.innerHTML = "Passwords do not match!";
        }
    }
))

confirm_password_input && confirm_password_input.addEventListener(
    'keyup',
    debounce(() => {
        const password = password_input.value;
        const confirm_password = confirm_password_input.value;
        confirmPasswordIsValid = password === confirm_password;
        if (confirmPasswordIsValid) {
            confirm_password_error.innerHTML = "";
        } else {
            confirm_password_error.innerHTML = "Passwords do not match!";
        }
    }
))

submit_button && submit_button.addEventListener(
    'click',
    async (e) => {
        e.preventDefault();
        if (usernameIsValid && emailIsValid && passwordIsValid && confirmPasswordIsValid) {
            const formData = new FormData();
            formData.append('username', username_input.value);
            formData.append('email', email_input.value);
            formData.append('password', password_input.value);

            const xhr = new XMLHttpRequest();
            xhr.open("POST", "/public/SignUp/register");
            xhr.send(formData);

            xhr.onreadystatechange = function () {
                if (this.readyState === XMLHttpRequest.DONE){
                    const data = JSON.parse(this.responseText);

                    const flash_div = document.getElementById('flash-message');
                    if (flash_div.firstChild){
                        for (let i = 0; i < flash_div.childNodes.length; i++){
                            flash_div.childNodes[i].remove();
                        }
                    }
                    flash_div.append(make_flash(data.message, data.type));
                }
            }
        } else {
            const flash_div = document.getElementById('flash-message');
            if (flash_div.firstChild){
                for (let i = 0; i < flash_div.childNodes.length; i++){
                    flash_div.childNodes[i].remove();
                }
            }
            flash_div.append(make_flash('Please fill out all fields correctly!', 'warning'));
        }
    }
)