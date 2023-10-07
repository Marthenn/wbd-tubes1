const deleteButton = document.querySelector('.delete-author');
const updateButton = document.querySelector('.save-changes-author');
const nameInput = document.getElementById('name');
const descriptionInput = document.getElementById('description');

const deleteAuthor = async (e) => {
    e.preventDefault();
    const xhr = new XMLHttpRequest();
    xhr.open("POST", `/public/editauthor/delete/${aid}`);
    xhr.send();

    xhr.onreadystatechange = function () {
        if (this.readyState === XMLHttpRequest.DONE){
            console.log(this.status)
            if (this.status === 204){
                location.replace('/public/authorlist');
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
            console.log(this.status)
            if (this.status === 204){
                location.replace('/public/authorlist');
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

// document.addEventListener('DOMContentLoaded',  async () => {
//     const xhr = new XMLHttpRequest();
//     xhr.open("GET", `/public/editauthor/getauthor/${aid}`);
//     xhr.send();

//     xhr.onreadystatechange = function () {
//         if (this.readyState === XMLHttpRequest.DONE){
//             if (this.status === 200){
//                 const data = JSON.parse(this.responseText);
//                 nameInput.value = data.name;
//                 descriptionInput.value = data.description;
//             } else {
//                 const data = JSON.parse(this.responseText);
//                 const flash = document.getElementById('flash-message');
//                 if (flash.firstChild) {
//                     for (let i = 0; i < flash.childNodes.length; i++) {
//                         flash.removeChild(flash.childNodes[i]);
//                     }
//                 }
//                 flash.appendChild(make_flash(data.message, data.type));
//             }
//         }
//     }
// })