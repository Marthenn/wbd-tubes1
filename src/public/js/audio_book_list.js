const prevButton = document.getElementById("prev");
const nextButton = document.getElementById("next");
const dataCards = document.getElementById("data-cards");
const pageInput = document.getElementById("page-input");
const searchButton = document.getElementById('search-button-book-admin');
const filterButton1 = document.getElementById('filter-button-book-admin-1');
const filterButton2 = document.getElementById('filter-button-book-admin-2');
const sortButton = document.getElementById('sort-button-book-admin');
const paginationText = document.querySelector('.pagination p span');
const searchInput = document.getElementById('search-input-book-admin');
const durationFilter = document.getElementById('filter-duration');
const categoryFilter = document.getElementById('filter-category');
const sortInput = document.getElementById('sort-value');

let currentPage = 1;

function fetchData(url) {
    const xhr = new XMLHttpRequest();
    
    xhr.onload = () => {
        if (xhr.status === 200) {
            console.log(xhr.responseText);
            const data = JSON.parse(xhr.responseText);
            MAX_PAGES = data.max_pages;
            paginationText.textContent = MAX_PAGES;
            updateView(data.books);
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

searchInput && searchInput.addEventListener(
    "keyup",
    debounce(() => {
        const url = buildUrl();
        fetchData(url);
    })
)

filterButton1 && filterButton1.addEventListener('click', (e) => {
    e.preventDefault();
    currentPage = 1;
    const url = buildUrl();
    fetchData(url);
});

filterButton2 && filterButton2.addEventListener('click', (e) => {
    e.preventDefault();
    currentPage = 1;
    const url = buildUrl();
    fetchData(url);
});

sortButton && sortButton.addEventListener('click', (e) => {
    e.preventDefault();
    currentPage = 1;
    const url = buildUrl();
    fetchData(url);
});

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

pageInput && pageInput.addEventListener('change', (e) => {
    e.preventDefault();
    pageNumber = parseInt(pageInput.value);
    if (isNaN(pageNumber) || pageNumber < 1) {
        currentPage = 1;
    } else if (pageNumber > MAX_PAGES) {
        currentPage = MAX_PAGES;
    } else {
        currentPage = pageNumber;
    }
    const url = buildUrl();
    fetchData(url);
});

function buildUrl() {
    const encodedSearch = encodeURIComponent(searchInput.value.replace(/ /g, '+').toLowerCase());
    const encodedDuration = encodeURIComponent(durationFilter.options[durationFilter.selectedIndex].value);
    const encodedCategory = encodeURIComponent(categoryFilter.options[categoryFilter.selectedIndex].value);
    const encodedSort = encodeURIComponent(sortInput.options[sortInput.selectedIndex].value);

    const queryParams = [];

    if (encodedSearch !== "") {
        queryParams.push(`&search=${encodedSearch}`);
    }

    if (encodedDuration !== "") {
        queryParams.push(`&duration=${encodedDuration}`);
    }

    if (encodedCategory !== "") {
        queryParams.push(`&category=${encodedCategory}`);
    }

    if (encodedSort !== "") {
        queryParams.push(`&sort=${encodedSort}`);
    }

    const queryString = queryParams.join('/');

    return `/public/audiobooklist/fetch/${currentPage}/${queryString}`;
}

const updateView = (data) => {
    let generatedHTML = "";
    data.map((book) => {
        generatedHTML += `
        <div class="data-card">
            <div class="card-content">
                <p>Book ID: ${book.bid}</p>
                <p>Title: "${book.title}"</p>
                <p>Description: "${book.description}"</p>
                <p>Author: "${book.author}"</p>
                <p>Category: "${book.category}"</p>
                <p>Duration: ${book.duration}</p>
                <p>Rating: ${book.rating}</p>
            </div>
            <a href="${BASEURL}/editbook/index/${book.bid}">
                <img class="edit" src="${BASEURL}/img/edit.svg" alt="edit">
            </a>
        </div>
        `;
    });
    dataCards.innerHTML = generatedHTML;
    pageInput.value = currentPage;
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