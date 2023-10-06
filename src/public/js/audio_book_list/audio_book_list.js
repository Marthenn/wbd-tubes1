const prevButton = document.getElementById("prev");
const nextButton = document.getElementById("next");
const dataCards = document.getElementById("data-cards");


let currentPage = 1;

prevButton &&
    prevButton.addEventListener("click", async () => {
        if (currentPage === 1) {
            return;
        }

        currentPage -= 1;

        const xhr = new XMLHttpRequest();
        xhr.open(
            "GET",
            `/public/audiobooklist/fetch/${currentPage}`
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
                    updateData(data);
                } else {
                    alert("An error occured, please try again!");
                }
            }
        };
    });

nextButton &&
    nextButton.addEventListener("click", async () => {
        if (currentPage === PAGES) {
            return;
        }

        currentPage += 1;

        const xhr = new XMLHttpRequest();
        xhr.open(
            "GET",
            `/public/audiobooklist/fetch/${currentPage}`
        );
        console.log(currentPage)
        xhr.send();
        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (this.status === 200) {
                    console.log(this.responseText)
                    const data = JSON.parse(this.responseText);
                    console.log(data)
                    updateData(data);
                } else {
                    alert("An error occured, please try again!");
                }
            }
        };
    });

const updateData = (data) => {
    let generatedHTML = "";
    data.books.map((book) => {
        generatedHTML += `
        <div class="data-card">
        <div class="card-content">
            <p>Book_ID: ${book.bid}</p>
            <p>Title: "${book.title}"</p>
            <p>Decription: "${book.description}"</p>
            <p>Author: "${book.author}"</p>
            <p>Category: "${book.category}"</p>
            <p>Duration: ${book.duration}</p>
            <p>Rating: ${book.rating}</p>
        </div>
        </div>
        `;
    });
    dataCards.innerHTML = generatedHTML;

    if (currentPage === 1) {
        prevButton.disabled = true;
    } else {
        prevButton.disabled = false;
    }

    if (currentPage === PAGES) {
        nextButton.disabled = true;
    } else {
        nextButton.disabled = false;
    }
};