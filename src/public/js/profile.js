const emailInput = document.getElementById('email');
const emailError = document.getElementById('email-error-msg');
const emailRegex = /^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{1,256}$/i;

const usernameInput = document.getElementById('username');
const usernameError = document.getElementById('username-error-msg');
const usernameRegex = /^[a-zA-Z0-9][a-zA-Z0-9_]{2,15}$/;

let emailIsValid = false;
let usernameIsValid = false;

const logoutButton = document.querySelector('.sign-out');
const deleteButton = document.querySelector('.delete-account');
const updateButton = document.querySelector('.save-changes');

emailInput && emailInput.addEventListener(
    "keyup",
    debounce(() => {
        const email = emailInput.value;
        emailIsValid = emailRegex.test(email);
        if (emailIsValid) {
            emailError.innerHTML = "";
        } else {
            emailError.innerHTML = "Email format not valid!";
        }
    })
)

usernameInput && usernameInput.addEventListener(
    'keyup',
    debounce(() => {
        const username = usernameInput.value;
        usernameIsValid = usernameRegex.test(username);
        if (usernameIsValid) {
            usernameError.innerHTML = "";
        } else {
            usernameError.innerHTML = "Username format not valid! (Must be 3-16 characters long that only contains alphabets, numbers, and/or underscores [can't start with underscore])";
        }
    })
)

logoutButton && logoutButton.addEventListener(
    'click', async () => {

        const xhr = new XMLHttpRequest();
        xhr.open("POST", "/public/Profile/logout");
        xhr.send();
        xhr.onreadystatechange = function () {
            if (this.readyState === XMLHttpRequest.DONE){
                if (this.status === 204){
                    location.replace('/public/SignIn');
                } else {
                    // TODO: flash error
                }
            }
        }
    }
)

document.addEventListener('DOMContentLoaded',  async () => {
    const formData = new FormData();

    const xhr = new XMLHttpRequest();
    xhr.open("GET", "/public/Profile/getProfile");
    xhr.send();

    xhr.onreadystatechange = function () {
        if (this.readyState === XMLHttpRequest.DONE){
            if (this.status === 200){
                const data = JSON.parse(this.responseText);
                emailInput.value = data.email;
                usernameInput.value = data.username;
                // TODO: profile picture
            } else {
                const data = JSON.parse(this.responseText);
                const flash = document.getElementById('flash-message');
                if (flash.firstChild) {
                    for (let i = 0; i < flash.childNodes.length; i++) {
                        flash.removeChild(flash.childNodes[i]);
                    }
                }
                flash.appendChild(make_flash(data.message, data.type));
            }
        }
    }
})

const deleteAccount = async () => {
    const formData = new FormData();

    const xhr = new XMLHttpRequest();
    xhr.open("DELETE", "/public/Profile/delete");
    xhr.send();

    xhr.onreadystatechange = function () {
        if (this.readyState === XMLHttpRequest.DONE){
            if (this.status === 204){
                location.replace('/public/SignIn');
            } else {
                const data = JSON.parse(this.responseText);
                const flash = document.getElementById('flash-message');
                if (flash.firstChild) {
                    for (let i = 0; i < flash.childNodes.length; i++) {
                        flash.removeChild(flash.childNodes[i]);
                    }
                }
                flash.appendChild(make_flash(data.message, data.type));
            }
        }
    }
}

deleteButton && deleteButton.addEventListener(
    'click', (e) => {
        e.preventDefault();
        const flash = document.getElementById('flash-message');
        if (flash.firstChild) {
            for (let i = 0; i < flash.childNodes.length; i++) {
                flash.removeChild(flash.childNodes[i]);
            }
        }
        const left_button_param = {
            text : 'Yes',
            functionality : deleteAccount
        }
        const right_button_param = {
            text : 'No'
        }
        flash.appendChild(make_flash("Are you sure you want to delete your account?", "danger", left_button_param, right_button_param));
    }
)