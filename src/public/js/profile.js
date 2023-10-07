const emailInput = document.getElementById('email');
const emailError = document.getElementById('email-error-msg');
const emailRegex = /^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{1,256}$/i;

const usernameInput = document.getElementById('username');
const usernameError = document.getElementById('username-error-msg');
const usernameRegex = /^[a-zA-Z0-9][a-zA-Z0-9_]{2,15}$/;

let emailIsValid = true;
let usernameIsValid = true;

const logoutButton = document.querySelector('.sign-out');
const deleteButton = document.querySelector('.delete-account');
const updateButton = document.querySelector('.save-changes');

const imageInput = document.querySelector('.profile-img-edit');

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

const deleteAccount = async (e) => {
    e.preventDefault();
    const formData = new FormData();

    const xhr = new XMLHttpRequest();
    xhr.open("POST", "/public/Profile/delete");
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

const updateProfile = async (e) => {
    e.preventDefault();
    const formData = new FormData();
    formData.append('email', emailInput.value);
    formData.append('username', usernameInput.value);

    const xhr = new XMLHttpRequest();
    xhr.open("POST", "/public/Profile/update");
    xhr.send(formData);

    xhr.onreadystatechange = function () {
        if (this.readyState === XMLHttpRequest.DONE){
            if (this.status === 204){
                const flash = document.getElementById('flash-message');
                if (flash.firstChild) {
                    for (let i = 0; i < flash.childNodes.length; i++) {
                        flash.removeChild(flash.childNodes[i]);
                    }
                }

                // update navbar username
                const navbar_username = document.querySelector('.username');
                navbar_username.innerHTML = usernameInput.value;
                flash.appendChild(make_flash("Profile updated!", "success"));
            } else {
                alert(this.responseText)
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

updateButton && updateButton.addEventListener(
    'click', (e) => {
        e.preventDefault();
        if (emailIsValid && usernameIsValid){
            const flash = document.getElementById('flash-message');
            if (flash.firstChild) {
                for (let i = 0; i < flash.childNodes.length; i++) {
                    flash.removeChild(flash.childNodes[i]);
                }
            }
            const left_button_param = {
                text : 'Yes',
                functionality : updateProfile
            }
            const right_button_param = {
                text : 'No',
                functionality : () => {
                    location.reload(); // to reset the profile picture
                }
            }
            flash.appendChild(make_flash("Are you sure you want to update your profile?", "action", left_button_param, right_button_param));
        } else {
            const flash = document.getElementById('flash-message');
            if (flash.firstChild) {
                for (let i = 0; i < flash.childNodes.length; i++) {
                    flash.removeChild(flash.childNodes[i]);
                }
            }
            flash.appendChild(make_flash("Please fix the errors!", "danger"));
        }
    }
)

imageInput && imageInput.addEventListener(
    'change', (e) => {
        e.preventDefault();

        const profile_img = document.querySelector('.profile-img');
        profile_img.src = URL.createObjectURL(e.target.files[0]);
    }
)