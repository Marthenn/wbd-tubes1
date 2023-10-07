const usernameRegex = /^[a-zA-Z0-9_]{3,16}$/;

let username_input = document.getElementById('username');
let password_input = document.getElementById('password');
let submit_button = document.querySelector('.submit-button');

submit_button && submit_button.addEventListener(
    'click',
    async (e) => {
        e.preventDefault();
        let username = username_input.value;
        let password = password_input.value;

        // request to php
        const formData = new FormData();
        formData.append('username', username);
        formData.append('password', password);

        const xhr = new XMLHttpRequest();

        xhr.open("POST", "/public/SignIn/login");
        xhr.send(formData);

        xhr.onreadystatechange = function () {
            if (this.readyState === XMLHttpRequest.DONE){
                if (this.status === 201){
                    const data = JSON.parse(this.responseText);
                    location.replace(data.redirect);
                } else {
                    const data = JSON.parse(this.responseText);
                    const flash_div = document.getElementById('flash-message');
                    if (flash_div.firstChild){
                        for (let i = 0; i < flash_div.childNodes.length; i++){
                            flash_div.childNodes[i].remove();
                        }
                    }
                    flash_div.appendChild(make_flash(data.message, data.type));
                }
            }
        }
    }
)