const deleteButton = document.querySelector('.delete-author');
const updateButton = document.querySelector('.save-changes-author');
const nameInput = document.getElementById('name');
const descriptionInput = document.getElementById('description');

const redirectToAuthorList = () => {
    location.replace('/public/authorlist');
}

const deleteAuthor = async (e) => {
    e.preventDefault();
    const xhr = new XMLHttpRequest();
    xhr.open("POST", `/public/editauthor/delete/${aid}`);
    xhr.send();

    xhr.onreadystatechange = function () {
        if (this.readyState === XMLHttpRequest.DONE){
            if (this.status === 204){
                disableAllInputs();
                const right_button_param = {
                    text : 'Go Back',
                    functionality : redirectToAuthorList
                }
                const flash = document.getElementById('flash-message');
                if (flash.firstChild) {
                    for (let i = 0; i < flash.childNodes.length; i++) {
                        flash.removeChild(flash.childNodes[i]);
                    }
                }
                flash.appendChild(make_flash("Author has been deleted!", "success", null, right_button_param));
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
            functionality : deleteAuthor
        }
        const right_button_param = {
            text : 'No'
        }
        flash.appendChild(make_flash("Are you sure you want to delete this author?", "danger", left_button_param, right_button_param));
    }
)

const updateAuthor = async (e) => {
    const formData = new FormData();
    formData.append('name', nameInput.value);
    formData.append('description', descriptionInput.value);
    const xhr = new XMLHttpRequest();
    xhr.open("POST", `/public/editauthor/update/${aid}`);
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
                flash.appendChild(make_flash("Author updated!", "success"));
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

updateButton && updateButton.addEventListener(
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
            functionality : updateAuthor
        }
        const right_button_param = {
            text : 'No'
        }
        flash.appendChild(make_flash("Are you sure you want to update this author?", "action", left_button_param, right_button_param));
    }
)

const disableAllInputs = () => {
    const allInputs = document.querySelectorAll('input');
    allInputs.forEach((button) => {
        button.disabled = true;
    });
    deleteButton.disabled = true;
    updateButton.disabled = true;
    descriptionInput.disabled = true;
}