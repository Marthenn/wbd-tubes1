const emailInput = document.getElementById('email');
const emailError = document.getElementById('email-error-msg');
const emailRegex = /^(?=.{1,256})(?=.{1,64}@.{1,255}$)(?=.{1,255}\..{1,255}$)[a-zA-Z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-zA-Z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?\.)+[a-zA-Z]{2,}$/;

const usernameInput = document.getElementById('username');
const usernameError = document.getElementById('username-error-msg');
const usernameRegex = /^[a-zA-Z0-9_]{3,16}$/;

const formInput = document.querySelector('.profile');

let emailIsValid = false;
let usernameIsValid = false;



emailInput && emailInput.addEventListener(
    "keyup",
    debounce(() => {
        const email = emailInput.value;
        emailIsValid = emailRegex.test(email);
        if (emailIsValid) {
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
        usernameIsValid = usernameRegex.test(username);
        if (usernameIsValid) {
            usernameError.innerHTML = "";
            usernameIsValid = true;
        } else {
            usernameError.innerHTML = "Username format not valid! (Must be 3-16 characters long that only contains alphabets and/or numbers)";
            usernameIsValid = false;
        }
    })
)

// formInput && formInput.addEventListener(
//     'submit', async (e) => {
//         e.preventDefault();


//     }
// )
