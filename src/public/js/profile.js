const emailInput = document.getElementById('email');
const emailError = document.getElementById('email-error-msg');
const emailRegex = /^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{1,256}$/i;

const usernameInput = document.getElementById('username');
const usernameError = document.getElementById('username-error-msg');
const usernameRegex = /^[a-zA-Z0-9][a-zA-Z0-9_]{2,15}$/;

const formInput = document.querySelector('.profile');

let emailIsValid = false;
let usernameIsValid = false;

const logoutButton = document.querySelector('.sign-out');

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
    formData.append('uid', uid);

    const xhr = new XMLHttpRequest();
    xhr.open("GET", "/public/Profile/getProfile");
    xhr.send(formData);

    xhr.onreadystatechange = function () {
        if (this.readyState === XMLHttpRequest.DONE){
            if (this.status === 200){
                const data = JSON.parse(this.responseText);
                emailInput.value = data.email;
                usernameInput.value = data.username;
                // TODO: profile picture
            } else {
                // TODO: flash error message
            }
        }
    }
})

// formInput && formInput.addEventListener(
//     'submit', async (e) => {
//         e.preventDefault();


//     }
// )
