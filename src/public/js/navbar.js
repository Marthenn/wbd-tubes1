const navbar_img = document.querySelector('.user-photo-img');
const user_photo = document.querySelectorAll('.user-photo-img')[1];

document.addEventListener('DOMContentLoaded', async (e) => {
    e.preventDefault()

    const xhr = new XMLHttpRequest();
    xhr.open("GET", "/public/Profile/getProfile");
    xhr.send();

    xhr.onreadystatechange = function () {
        if (this.readyState === XMLHttpRequest.DONE){
            if (this.status === 200){
                const data = JSON.parse(this.responseText);
                if (data.profile_pic_directory !=  null){
                    navbar_img.src = data.profile_pic_directory;
                    user_photo.src = data.profile_pic_directory;
                }

            }
        }
    }
})