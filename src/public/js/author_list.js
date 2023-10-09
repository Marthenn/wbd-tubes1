const prevButton = document.querySelector('#prev');
const nextButton = document.querySelector('#next');
const pageNumberInput = document.querySelector('#page-input');
const authorList = document.querySelector('.data-cards');
const searchInput = document.getElementById('search-input-author');
const searchButton = document.getElementById('search-button-author');
const paginationText = document.querySelector('.pagination p span');

let currentPage = 1;

function fetchData(url) {
    const xhr = new XMLHttpRequest();

    xhr.onload = () => {
        if (xhr.status === 200) {
            const data = JSON.parse(xhr.responseText);
            MAX_PAGES = data.max_pages;
            paginationText.textContent = MAX_PAGES;
            updateView(data.authors);
        } else {
            const flash = document.getElementById('flash-message');
            if (flash.firstChild) {
                for (let i = 0; i < flash.childNodes.length; i++) {
                    flash.removeChild(flash.childNodes[i]);
                }
            }
            flash.appendChild(make_flash("An error occurred, please try again!", "danger"));
        }
    };

    xhr.onerror = () => {
        const flash = document.getElementById('flash-message');
        if (flash.firstChild) {
            for (let i = 0; i < flash.childNodes.length; i++) {
                flash.removeChild(flash.childNodes[i]);
            }
        }
        flash.appendChild(make_flash("Error Request!", "danger"));
    };

    xhr.open('GET', url);
    xhr.send();
}

function buildUrl() {
    const queryParameters = [];
    if (searchInput.value !== "") {
        queryParameters.push(`${encodeURIComponent(searchInput.value.replace(/ /g, '+'))}`);
    }
    return `/public/authorlist/fetch/${currentPage}${queryParameters.length > 0 ? `/${queryParameters.join('/')}` : ''}`;
}

searchInput && searchInput.addEventListener(
    "keyup",
    debounce(() => {
        const url = buildUrl();
        console.log(url);
        fetchData(url);
    })
)

searchButton && searchButton.addEventListener('click', (e) => {
    e.preventDefault();
    currentPage = 1;
    const url = buildUrl();
    fetchData(url);
});

prevButton && prevButton.addEventListener('click', (e) => {
    e.preventDefault();
    if (currentPage === 1) {
        return;
    }
    currentPage -= 1;
    const url = buildUrl();
    fetchData(url);
});

nextButton && nextButton.addEventListener('click', (e) => {
    e.preventDefault();
    if (currentPage === MAX_PAGES) {
        return;
    }
    currentPage += 1;
    const url = buildUrl();
    fetchData(url);
});

pageNumberInput && pageNumberInput.addEventListener('change', (e) => {
    e.preventDefault();
    const newPage = parseInt(pageNumberInput.value);
    if (!isNaN(newPage) && newPage >= 1 && newPage <= MAX_PAGES) {
        currentPage = newPage;
    }
    const url = buildUrl();
    fetchData(url);
});

const updateView = (data) => {
    let updatedHTML = "";
    data.forEach((author) => {
        const authoredBooks = author.books.map(book => `"${book.title}"`).join(', ');
        updatedHTML += `
        <div class="data-card">
            <div class="card-content">
                <p>Author ID: ${author.aid}</p>
                <p>Name: "${author.name}"</p>
                <p>Description: "${author.description}"</p>
                <p>Authored Books: [${authoredBooks}]</p>
            </div>
            <a href="${BASEURL}/editauthor/index/${author.aid}">
                <img class="edit" src="${BASEURL}/img/edit.svg" alt="edit">
            </a>
        </div>`;
    });

    authorList.innerHTML = updatedHTML;
    pageNumberInput.value = currentPage;

    prevButton.disabled = currentPage <= 1;
    nextButton.disabled = currentPage >= MAX_PAGES;
};
