const prevButton = document.querySelector('#prev');
const nextButton = document.querySelector('#next');
const pageNumberInput = document.querySelector('#page-input');
const authorList = document.querySelector('.data-cards');
const searchInput = document.getElementById('search-input-author');
const searchButton = document.getElementById('search-button-author');
const paginationText = document.querySelector('.pagination p span');

console.log(pageNumberInput);
let currentPage = 1;

searchButton && searchButton.addEventListener(
    'click', async (e) => {
        e.preventDefault();
        console.log(currentPage)
        currentPage = 1;
        let url
        console.log(searchInput.value);
        if(searchInput.value === "") {
            url = `/public/authorlist/fetch/${currentPage}`;
        }
        else {
            url = `/public/authorlist/fetch/${currentPage}/${searchInput.value}`;
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
                    updateView(data.authors);
                    console.log(MAX_PAGES)
                } else {
                    alert("An error occured, please try again!");
                }
            }
        }
    }
)


prevButton && prevButton.addEventListener(
    'click', async (e) => {
        e.preventDefault();
        let url
        if (currentPage === 1) {
            return;
        }
        currentPage -= 1;
        console.log(currentPage)
        if(searchInput.value === "") {
            url = `/public/authorlist/fetch/${currentPage}`;
        }
        else {
            url = `/public/authorlist/fetch/${currentPage}/${searchInput.value}`;
        }
    
        const xhr = new XMLHttpRequest();
        
        xhr.onload = () => {
            const data = JSON.parse(xhr.responseText);
            MAX_PAGES = data.max_pages;
            paginationText.textContent = MAX_PAGES;
            updateView(data.authors);
        }

        xhr.onerror = () => {
            alert("Error request");
        }

        xhr.open('GET', url);
        xhr.send();
    }
)

nextButton && nextButton.addEventListener(
    'click', async (e) => {
        e.preventDefault();
        let url
        if (currentPage === MAX_PAGES) {
            return;
        }
        currentPage += 1;
        console.log(currentPage)
        if(searchInput.value === "") {
            url = `/public/authorlist/fetch/${currentPage}`;
        }
        else {
            url = `/public/authorlist/fetch/${currentPage}/${searchInput.value}`;
        }
        
        const xhr = new XMLHttpRequest();
        
        xhr.onload = () => {
            const data = JSON.parse(xhr.responseText);
            MAX_PAGES = data.max_pages;
            paginationText.textContent = MAX_PAGES;
            updateView(data.authors);
        }
        xhr.onerror = () => {
            alert("Error request");
        }
        xhr.open('GET', url);
        xhr.send();
    }
)

pageNumberInput && pageNumberInput.addEventListener(
    'change', async (e) => {
        e.preventDefault();
        console.log(currentPage)
        let url
        pageNumber = parseInt(pageNumberInput.value)
        if (isNaN(pageNumber) || pageNumber < 1) {
            currentPage = 1;
        } else if (pageNumber > MAX_PAGES) {
            currentPage = MAX_PAGES;
        }
        else {
            currentPage = pageNumber;
        }
        if(searchInput.value === "") {
            url = `/public/authorlist/fetch/${currentPage}`;
        }
        else {
            url = `/public/authorlist/fetch/${currentPage}/${searchInput.value}`;
        }
        const xhr = new XMLHttpRequest();
        
        xhr.onload = () => {
            const data = JSON.parse(xhr.responseText);
            MAX_PAGES = data.max_pages;
            paginationText.textContent = MAX_PAGES;
            updateView(data.authors);
        }
        xhr.onerror = () => {
            alert("Error request");
        }
        xhr.open('GET', `/public/authorlist/fetch/${currentPage}`);
        xhr.send();
    }
)

const updateView = (data) => {
    let updatedHTML = "";
    data.map((author) => {
        let authoredBooks = "[";
        author['books'].map((book) => {
            authoredBooks += ` "${book.title}" `;
        })
        authoredBooks += "]";
        updatedHTML +=
        `
        <div class="data-card">
            <div class="card-content">
                <p>Author ID: ${author.aid}</p>
                <p>Name: ${author.name}</p>
                <p>Description: ${author.description}</p>
                <p>Authored Books: ${authoredBooks}</p>
            </div>
            <a href="${BASEURL}/editauthor/index/${author.aid}">
                <img class="edit" src="${BASEURL}/img/edit.svg" alt="edit">
            </a>
        </div>
        `;
    });
    authorList.innerHTML = updatedHTML;
    pageNumberInput.value = currentPage;
    console.log(currentPage)
    console.log(MAX_PAGES)
    if (currentPage <= 1) {
        prevButton.disabled = true;
    } else {
        prevButton.disabled = false;
    }
    if (currentPage >= MAX_PAGES) {
        console.log("here")
        nextButton.disabled = true;
    } else {
        nextButton.disabled = false;
    }
}