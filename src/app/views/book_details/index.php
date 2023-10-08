<div class="books-details-page">
    <a href="<?= BASEURL;?>/audiobooks">
       <img class="back-arrow" src="<?= BASEURL;?>/img/back-arrow.svg" alt="back">
    </a>
    <div class="books-details-content">
        <h1><?= $data['title']?></h1>
        <div class="cover-desc">
            <div class="cover">
                <?php if (!$data['cover_image_directory']) : ?>
                    <img class="cover-img" src="<?= BASEURL;?>/img/cover-placeholder.png" alt="logo">
                <?php else : ?>
                    <img class="cover-img" src="<?= $data['cover_image_directory']?>" alt="logo">
                <?php endif; ?>
            </div>
            <div class="description">
                <p><?= $data['cover_image_directory']?></p>
                <p><?= $data['audio_directory']?></p>
                <p class="description-title">Description</p>
                <p class="description-text"><?= $data['description']?></p>
                <p class="description-title">Author</p>
                <p class="description-text"><?= $data['author']?></p>
                <p class="description-title">Category</p>
                <p class="description-text"><?= $data['category']?></p>
                <p class="description-title">Duration</p>
                <p class="description-text"><?= convertTimeToMinutes($data['duration'])?> min</p>
                <p class="description-title">Rating</p>
                <div class="rating">
                    <img class="rating-star"src="<?= BASEURL;?>/img/star.svg" alt="star">
                    <p class="description-text"><?= number_format($data['rating'], 2)?></p>
                </div> 
            </div>
        </div>
    </div>
    <div class="progress-bar-container">
        <audio id="audio-player" src="<?= $data['audio_directory']?>"></audio> 
        <button id="play-pause-button" type="button" name="play-pause-button">
            <img id="play-pause-img" src="<?= BASEURL;?>/img/play-button.svg" alt="play"  data-play-src="<?= BASEURL;?>/img/play-button.svg" data-pause-src="<?= BASEURL;?>/img/pause-button.svg" width="50">
        </button>
        <p id="curr-duration"><?= $data['curr_duration']?></p>
        <input class="progress-bar" type="range" name="progress-bar" id="progress-bar" step="0.01" value="<?= $data['currentTotalSeconds']?>" min="0" max="<?= $data['totalSeconds']?>">
        <p id="final-duration"><?= $data['duration']?></p>
    </div>
</div>
<script src="<?= BASEURL; ?>/js/audio_player.js" defer></script>
<?php
function convertTimeToMinutes($time) {
    list($hours, $minutes, $seconds) = explode(':', $time);
    $totalMinutes = ($hours * 60) + $minutes;

    return $totalMinutes;
}
?>