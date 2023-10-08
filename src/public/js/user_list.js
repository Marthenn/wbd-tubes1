const prevButton = document.getElementById("prev");
const nextButton = document.getElementById("next");
const dataCards = document.getElementById("data-cards");
const pageInput = document.getElementById("page-input");
const searchButton = document.getElementById('search-button-user');
const paginationText = document.querySelector('.pagination p span');
const searchInput = document.getElementById('search-input-user');

let currentPage = 1;

function fetchData(url) {
    const xhr = new XMLHttpRequest();

    xhr.onload = () => {
        if (xhr.status === 200) {
            const data = JSON.parse(xhr.responseText);
            MAX_PAGES = data.max_pages;
            paginationText.textContent = MAX_PAGES;
            updateData(data.users);
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

function buildUrl() {
    const queryParameters = [];
    if (searchInput.value !== "") {
        queryParameters.push(`search=${encodeURIComponent(searchInput.value)}`);
    }
    return `/public/userlist/fetch/${currentPage}${queryParameters.length > 0 ? `/${queryParameters.join('/')}` : ''}`;
}

searchButton && searchButton.addEventListener('click', (e) => {
    e.preventDefault();
    currentPage = 1;
    const url = buildUrl();
    fetchData(url);
});

prevButton &&
    prevButton.addEventListener("click", async (e) => {
        e.preventDefault();
        if (currentPage === 1) {
            return;
        }
        currentPage -= 1;
        pageInput.value = currentPage;
        const url = buildUrl();
        fetchData(url);
    });

nextButton &&
    nextButton.addEventListener("click", async (e) => {
        e.preventDefault();
        if (currentPage === MAX_PAGES) {
            return;
        }
        currentPage += 1;
        pageInput.value = currentPage;
        const url = buildUrl();
        fetchData(url);
    });

pageInput &&
    pageInput.addEventListener("input", (e) => {
        e.preventDefault();
        const inputPage = parseInt(pageInput.value);
        if (isNaN(inputPage) || inputPage < 1) {
            currentPage = 1;
        } else if (inputPage > MAX_PAGES) {
            currentPage = MAX_PAGES;
        }
        else {
            currentPage = inputPage;
        }
        const url = buildUrl();
        fetchData(url);
    });

const updateData = (data) => {
    let generatedHTML = "";
    data.forEach((user) => {
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
    prevButton.disabled = currentPage <= 1;
    nextButton.disabled = currentPage >= MAX_PAGES;
};
