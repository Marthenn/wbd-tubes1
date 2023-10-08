const prevButton = document.getElementById("prev");
const nextButton = document.getElementById("next");
const bookList = document.querySelector(".book-card-list");
const pageInput = document.getElementById("page-input");
const searchButton = document.getElementById('search-button-book');
const filterButton1 = document.getElementById('filter-button-book-1');
const filterButton2 = document.getElementById('filter-button-book-2');
const sortButton = document.getElementById('sort-button-book');
const paginationText = document.querySelector('.pagination p span');
const searchInput = document.getElementById('search-input-book');
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
            alert("An error occurred, please try again!");
        }
    };
    
    xhr.onerror = () => {
        alert("Error request");
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
    const encodedSearch = encodeURIComponent(searchInput.value);
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

    return `/public/audiobooks/fetch/${currentPage}/${queryString}`;
}

const updateView = (data) => {
    let updatedHTML = "";
    data.map((book) => {
        const durationParts = book.duration.split(':');
        const hoursInMinutes = parseInt(durationParts[0]) * 60;
        const minutes = parseInt(durationParts[1]);
        const totalMinutes = hoursInMinutes + minutes;

        updatedHTML +=
        `
        <a href="${BASEURL}/bookdetails/${book.bid}" class="book-card">
            <div class="cover">
                <img class="cover-img" src="${BASEURL}/img/cover-placeholder.png" alt="logo">
            </div>
            <div class="details">
                <p class="title"> ${book.title}</p>
                <div class="rating">
                    <img class="rating-star"src="${BASEURL}/img/star.svg" alt="star">
                    <p class="rating-num"> ${parseFloat(book.rating).toFixed(2)}</p>
                </div>
                <p class="author"> ${book.author}</p>
                <p class="duration"> ${totalMinutes} min</p>
            </div>
        </a>
        `;
    });
    bookList.innerHTML = updatedHTML;
    pageInput.value = currentPage;
}