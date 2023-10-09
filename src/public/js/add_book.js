const addButton = document.querySelector('#save-changes-book');
const titleInput = document.querySelector('#title');
const authorInput = document.querySelector('#author');
const ratingInput = document.querySelector('#rating');
const categoryInput = document.querySelector('#category');
const descInput = document.querySelector('#description');
const coverInput = document.querySelector('#cover-image');
const audioInput = document.querySelector('#audio-file');
const coverFilename = document.querySelector('#cover-filename');
const audioFilename = document.querySelector('#audio-filename');
const addBookForm = document.querySelector('#add-book-form');

const redirectToBooklist = () => {
    location.replace('/public/audiobooklist');
}

const disableAllInputs = () => {
    const allInputs = document.querySelectorAll('input');
    allInputs.forEach((button) => {
        button.disabled = true;
    });
    addButton.disabled = true;
    descInput.disabled = true;
}

addButton && addButton.addEventListener(
    'click', (e) => {
        e.preventDefault();
        const formData = new FormData();
        const cover = coverInput.files[0];
        const audio = audioInput.files[0];
        formData.append('title', titleInput.value);
        formData.append('author', authorInput.value);
        formData.append('rating', ratingInput.value);
        formData.append('category', categoryInput.value);
        formData.append('description', descInput.value);
        formData.append('cover', cover);
        formData.append('audio', audio);
        formData.append('duration', getFormattedTime(audioDuration));
        
        const xhr = new XMLHttpRequest();
        xhr.open("POST", `/public/addbook/add`);
        xhr.send(formData);

        xhr.onreadystatechange = function () {
            if (this.readyState === XMLHttpRequest.DONE){
                if (this.status === 200){
                    console.log(this.responseText);
                    disableAllInputs();
                    const right_button_param = {
                        text : 'Go Back',
                        functionality : redirectToBooklist
                    }
                    const flash = document.getElementById('flash-message');
                    if (flash.firstChild) {
                        for (let i = 0; i < flash.childNodes.length; i++) {
                            flash.removeChild(flash.childNodes[i]);
                        }
                    }
                    flash.appendChild(make_flash("Book has been added!", "success", null, right_button_param));
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

audioInput && audioInput.addEventListener(
    'change', (e) => {
        let file = e.target.files[0];
        let audio = new Audio();
        let objectURL = URL.createObjectURL(file);
        audio.src = objectURL;

        audio.onloadedmetadata = () => {
            audioDuration = audio.duration;
            URL.revokeObjectURL(objectURL);
        };
    }
);

const getFormattedTime = (seconds) => {
    let hours = Math.floor(seconds / 3600);
    let minutes = Math.floor((seconds % 3600) / 60);
    let remainingSeconds = seconds % 60;

    hours = (hours < 10) ? "0" + hours : hours;
    minutes = (minutes < 10) ? "0" + minutes : minutes;
    remainingSeconds = (remainingSeconds < 10) ? "0" + parseInt(remainingSeconds) : parseInt(remainingSeconds);

    return hours + ":" + minutes + ":" + remainingSeconds;
}