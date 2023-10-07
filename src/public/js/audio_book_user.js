const prevButton = document.querySelector('#prev');
const nextButton = document.querySelector('#next');
const pageNumberInput = document.querySelector('#page-input');
const bookList = document.querySelector('.book-card-list');

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

        xhr.open('GET', `/public/audiobooks/fetch/${currentPage}`);
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

        xhr.open('GET', `/public/audiobooks/fetch/${currentPage}`);
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

        xhr.open('GET', `/public/audiobooks/fetch/${currentPage}`);
        xhr.send();
    }
)

const updateView = (data) => {
    let updatedHTML = "";
    data.map((book) => {
        updatedHTML +=
        `
        <a href="${BASEURL}/bookdetails" class="book-card">
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
                <p class="duration"> ${book.duration}</p>
            </div>
        </a>
        `;
    });
    bookList.innerHTML = updatedHTML;
    pageNumberInput.value = currentPage;
}