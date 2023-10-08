const deleteButton = document.querySelector('#delete-book');
const updateButton = document.querySelector('#save-changes-book');
const titleInput = document.querySelector('#title');
const authorInput = document.querySelector('#author');
const ratingInput = document.querySelector('#rating');
const categoryInput = document.querySelector('#category');
const descInput = document.querySelector('#description');
const coverInput = document.querySelector('#cover-image');
const audioInput = document.querySelector('#audio-file');
const coverFilename = document.querySelector('#cover-filename');
const audioFilename = document.querySelector('#audio-filename');

const placeholderFunc = () => {
    console.log('masukbang');
}

const deleteBook = async (e) => {
    e.preventDefault();
    const xhr = new XMLHttpRequest();
    const formData = new FormData();

    formData.append('bid', bid);
    
    xhr.open('POST', `/public/editbook/delete`);
    xhr.send(formData);

    xhr.onreadystatechange = function () {
        if (this.readyState === XMLHttpRequest.DONE) {
            console.log(this.status);
            if (this.status === 204) {
                location.replace('/public/audiobooklist');
                alert(`Book with id ${bid} has been deleted`);
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

const updateBook = async (e) => {
    const formData = new FormData();
    const cover = coverInput.files[0];
    const audio = audioInput.files[0];
    formData.append('bid', bid);
    formData.append('title', titleInput.value);
    formData.append('author', authorInput.value);
    formData.append('rating', ratingInput.value);
    formData.append('category', categoryInput.value);
    formData.append('description', descInput.value);
    formData.append('cover', cover);
    formData.append('audio', audio);
    
    const xhr = new XMLHttpRequest();
    xhr.open("POST", `/public/editbook/update`);
    xhr.send(formData);

    xhr.onreadystatechange = function () {
        if (this.readyState === XMLHttpRequest.DONE){
            console.log(this.status)
            if (this.status === 204 || this.status == 200){
                const flash = document.getElementById('flash-message');
                if (flash.firstChild) {
                    for (let i = 0; i < flash.childNodes.length; i++) {
                        flash.removeChild(flash.childNodes[i]);
                    }
                }
                flash.appendChild(make_flash("Book updated!", "success"));
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
            functionality : deleteBook
        }
        const right_button_param = {
            text : 'No'
        }
        flash.appendChild(make_flash("Are you sure you want to delete this book?", "danger", left_button_param, right_button_param));
    }
)

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
            functionality : updateBook
        }
        const right_button_param = {
            text : 'No'
        }
        flash.appendChild(make_flash("Are you sure you want to update this book?", "action", left_button_param, right_button_param));
    }
)

