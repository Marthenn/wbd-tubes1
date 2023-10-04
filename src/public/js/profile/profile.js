const emailInput = document.getElementById('email');
const emailError = document.getElementById('email-error-msg');
const emailRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/;

const usernameInput = document.getElementById('username');
const usernameError = document.getElementById('username-error-msg');
const usernameRegex = /^[a-zA-Z0-9_]{3,16}$/;

let emailIsValid = false;
let usernameIsValid = false;

emailInput && emailInput.addEventListener(
    "keyup",
    debounce(() => {
        const email = emailInput.value;
        if (emailRegex.test(email)) {
            emailError.innerHTML = "";
            emailIsValid = true;
        } else {
            emailError.innerHTML = "Email format not valid!";
            emailIsValid = false;
        }
    })
)

usernameInput && usernameInput.addEventListener(
    'keyup',
    debounce(() => {
        const username = usernameInput.value;

        if (usernameRegex.test(username)) {
            usernameError.innerHTML = "";
            usernameIsValid = true;
        } else {
            usernameError.innerHTML = "Username format not valid! (Must be 3-16 characters long that only contains alphabets and/or numbers)";
            usernameIsValid = false;
        }
    })
)