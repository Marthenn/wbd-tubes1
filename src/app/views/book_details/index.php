<div class="books-details-page">
    <a href="<?= BASEURL;?>/audiobooks">
       <img class="back-arrow" src="<?= BASEURL;?>/img/back-arrow.svg" alt="back">
    </a>
    <div class="books-details-content">
        <h1>Book Title</h1>
        <div class="cover-desc">
            <div class="cover">
                <img class="cover-img" src="<?= BASEURL;?>/img/cover-placeholder.png" alt="logo">
            </div>
            <div class="description">
                <p class="description-title">Description</p>
                <p class="description-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur sollicitudin in enim quis finibus. </p>
                <p class="description-title">Author</p>
                <p class="description-text">Jerome Polin</p>
                <p class="description-title">Category</p>
                <p class="description-text">Horror</p>
                <p class="description-title">Duration</p>
                <p class="description-text">45 min</p>
                <p class="description-title">Rating</p>
                <div class="rating">
                    <img class="rating-star"src="<?= BASEURL;?>/img/star.svg" alt="">
                    <p class="description-text">5.0</p>
                </div> 
            </div>
        </div>
    </div>
    <div class="progress-bar-container">
        <audio id="audio-player" src="<?= BASEURL;?>/audio/<?= $data['title'] ?>.mp3"></audio> 
        <button id="play-pause-button" type="button" name="play-pause-button">
            <img id="play-pause-img" src="<?= BASEURL;?>/img/play-button.svg" alt="play">
        </button>
        <p id="curr-duration">0:00</p>
        <input class="progress-bar" type="range" name="progress-bar" id="progress-bar" step="0.01" value="0">
        <p id="final-duration"><?= floor($data['duration'] / 60) ?>:<?= str_pad($data['duration'] % 60, 2, "0") ?></p>
    </div>
</div>