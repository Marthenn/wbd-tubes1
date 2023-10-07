const prevButton = document.querySelector('#prev');
const nextButton = document.querySelector('#next');
const pageNumberInput = document.querySelector('#page-input');
const authorList = document.querySelector('.data-cards');
console.log(pageNumberInput);
let currentPage = 1;

prevButton && prevButton.addEventListener(
    'click', async (e) => {
        e.preventDefault();
        if (currentPage === 1) {
            return;
        }

        currentPage -= 1;
        
        const xhr = new XMLHttpRequest();
        
        xhr.onload = () => {
            const data = JSON.parse(xhr.responseText);
            updateView(data);
        }

        xhr.onerror = () => {
            alert("Error request");
        }

        xhr.open('GET', `/public/authorlist/fetch/${currentPage}`);
        xhr.send();
    }
)

nextButton && nextButton.addEventListener(
    'click', async (e) => {
        e.preventDefault();
        if (currentPage === MAX_PAGES) {
            return;
        }

        currentPage += 1;
        
        const xhr = new XMLHttpRequest();
        
        xhr.onload = () => {
            const data = JSON.parse(xhr.responseText);
            updateView(data);
        }

        xhr.onerror = () => {
            alert("Error request");
        }

        xhr.open('GET', `/public/authorlist/fetch/${currentPage}`);
        xhr.send();
        
    }
)

pageNumberInput && pageNumberInput.addEventListener(
    'change', async (e) => {
        e.preventDefault();
        pageNumber = parseInt(pageNumberInput.value)
        if (isNaN(pageNumber) || pageNumber < 1) {
            currentPage = 1;
        } else if (pageNumber > MAX_PAGES) {
            currentPage = MAX_PAGES;
        }
        else {
            currentPage = pageNumber;
        }

        const xhr = new XMLHttpRequest();
        
        xhr.onload = () => {
            const data = JSON.parse(xhr.responseText);
            updateView(data);
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
}