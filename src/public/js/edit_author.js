const deleteButton = document.querySelector('.delete-author');

const deleteAuthor = async () => {
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
        flash.appendChild(make_flash("Are you sure you want to delete your account?", "danger", left_button_param, right_button_param));
    }
)