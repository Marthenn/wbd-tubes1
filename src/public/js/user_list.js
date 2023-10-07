const prevButton = document.getElementById("prev");
const nextButton = document.getElementById("next");
const dataCards = document.getElementById("data-cards");
const pageInput = document.getElementById("page-input");
const searchButton = document.getElementById('search-button-user');
const paginationText = document.querySelector('.pagination p span');
const searchInput = document.getElementById('search-input-user');

let currentPage = 1;

searchButton && searchButton.addEventListener(
    'click', async (e) => {
        e.preventDefault();
        console.log("here")
        console.log(currentPage)
        currentPage = 1;
        let url
        console.log(searchInput.value);
        if(searchInput.value === "") {
            url = `/public/userlist/fetch/${currentPage}`;
        }
        else {
            url = `/public/userlist/fetch/${currentPage}/${searchInput.value}`;
        }
        const xhr = new XMLHttpRequest();
        xhr.open('GET', url);
        xhr.send();
        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                console.log(this.status)
                if (this.status === 200) {
                    console.log(this.responseText)
                    const data = JSON.parse(this.responseText);
                    MAX_PAGES = data.max_pages;
                    paginationText.textContent = MAX_PAGES;
                    updateData(data.users);
                    console.log(MAX_PAGES)
                } else {
                    alert("An error occured, please try again!");
                }
            }
        }
    }
)

prevButton &&
    prevButton.addEventListener("click", async (e) => {
        e.preventDefault();
        let url

        if (currentPage === 1) {
            return;
        }

        currentPage -= 1;
        pageInput.value = currentPage;

        if(searchInput.value === "") {
            url = `/public/userlist/fetch/${currentPage}`;
        }
        else {
            url = `/public/userlist/fetch/${currentPage}/${searchInput.value}`;
        }

        const xhr = new XMLHttpRequest();
        xhr.open(
            "GET", url
        );
        console.log(currentPage)
        xhr.send();
        xhr.onreadystatechange = function () {
            console.log("here")
            if (xhr.readyState === XMLHttpRequest.DONE) {
                console.log(this.status)
                if (this.status === 200) {
                    const data = JSON.parse(this.responseText);
                    console.log(data)
                    MAX_PAGES = data.max_pages;
                    paginationText.textContent = MAX_PAGES;
                    updateData(data.users);
                } else {
                    alert("An error occured, please try again!");
                }
            }
        };
    });

nextButton &&
    nextButton.addEventListener("click", async (e) => {
        e.preventDefault();
        let url

        if (currentPage === MAX_PAGES) {
            return;
        }

        currentPage += 1;
        pageInput.value = currentPage;

        if(searchInput.value === "") {
            url = `/public/userlist/fetch/${currentPage}`;
        }
        else {
            url = `/public/userlist/fetch/${currentPage}/${searchInput.value}`;
        }

        const xhr = new XMLHttpRequest();
        xhr.open(
            "GET", url
        );
        console.log(currentPage)
        xhr.send();
        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (this.status === 200) {
                    console.log(this.responseText)
                    const data = JSON.parse(this.responseText);
                    console.log(data)
                    MAX_PAGES = data.max_pages;
                    paginationText.textContent = MAX_PAGES;
                    updateData(data.users);
                } else {
                    alert("An error occured, please try again!");
                }
            }
        };
    });

pageInput &&
    pageInput.addEventListener("input", (e) => {
        e.preventDefault();
        let url
        const inputPage = parseInt(pageInput.value);

        console.log(inputPage)
        if (isNaN(inputPage) || inputPage < 1) {
            currentPage = 1;
        } else if (inputPage > MAX_PAGES) {
            currentPage = MAX_PAGES;
        }
        else {
            currentPage = inputPage;
        }

        if(searchInput.value === "") {
            url = `/public/userlist/fetch/${currentPage}`;
        }
        else {
            url = `/public/userlist/fetch/${currentPage}/${searchInput.value}`;
        }

        const xhr = new XMLHttpRequest();
        xhr.open(
            "GET",
            `/public/userlist/fetch/${currentPage}`
        );
        xhr.send();
        console.log(currentPage)
        xhr.onreadystatechange = function () {
            console.log("here")
            if (xhr.readyState === XMLHttpRequest.DONE) {
                console.log(this.status)
                if (this.status === 200) {
                    const data = JSON.parse(this.responseText);
                    console.log(data)
                    MAX_PAGES = data.max_pages;
                    paginationText.textContent = MAX_PAGES;
                    updateData(data.users);
                } else {
                    alert("An error occured, please try again!");
                }
            }
        };
    });

const updateData = (data) => {
    let generatedHTML = "";
    data.map((user) => {
        generatedHTML += `
        <div class="data-card">
        <div class="card-content">
            <p>User_ID: ${user.uid}</p>
            <p>Username: "${user.username}"</p>
            <p>Email: "${user.email}"</p>
            <p>Joined Date: "${user.joined_date}"</p>
            <p>Type: "${user.is_admin === true ? 'admin' : 'user'}"</p>
        </div>
        </div>
        `;
    });
        dataCards.innerHTML = generatedHTML;
    if (currentPage <= 1) {
        prevButton.disabled = true;
    } else {
        prevButton.disabled = false;
    }
    if (currentPage >= MAX_PAGES) {
        nextButton.disabled = true;
    } else {
        nextButton.disabled = false;
    }
};