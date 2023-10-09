<div class="audio-books-page">
    <h1>Audio Books</h1>
    <div class="search">
        <div class="search-bar">
            <input class="search-input" type="text" id="search-input-book" name="search" placeholder="Search..">
            <img class="search-logo"src="<?= BASEURL;?>/img/search.svg" alt="search">
        </div>
        <button class="search-button" type="submit" id="search-button-book">Search</button>
    </div>
    <div class="filter-sort">
        <select class="filter-dropdown" id="filter-category" name="filter-category">
            <option value="" selected>By Category...</option>
            <?php if (!$data['categories']) : ?>
                <option value="" disabled>No Category Available</option>
            <?php else : ?>
                <?php foreach ($data['categories'] as $category) : ?>
                    <option value="<?= $category['name'] ?>"><?= $category['name'] ?></option>
                <?php endforeach; ?>
            <?php endif; ?>
        </select>
        <button class="filter-button" type="submit" id="filter-button-book-1">Apply Filter</button>
        <select class="filter-dropdown" id="filter-duration" name="filter-category">
            <option value="" selected>By Duration..</option>
            <option value="00:30:00-01:00:00">30-60 min</option>
            <option value="01:00:00-01:30:00">60-90 min</option>
            <option value="01:30:00-02:00:00">90-120 min</option>
        </select>
        <button class="filter-button" type="submit" id="filter-button-book-2">Apply Filter</button>
        <select class="sort-dropdown" id="sort-value" name="filter-category">
            <option value="" selected>Sort by..</option>
            <option value="duration_asc">Duration (min-max)</option>
            <option value="duration_desc">Duration (max-min)</option>
            <option value="title_asc">Title (A-Z)</option>
            <option value="title_desc">Title (Z-A)</option>
        </select>
        <button class="sort-button" type="submit" id="sort-button-book">Sort</button>
    </div>
    <div id = 'flash-message'></div>
    <?php if (!$data['books']) : ?>
        <p class='info'>There are no books yet available!</p>
    <?php else : ?>
        <div class="book-card-list">
            <?php foreach ($data['books'] as $book) : ?>
                <a href="<?= BASEURL;?>/bookdetails/<?= $book['bid']?>" class="book-card">
                    <div class="cover">
                    <?php if (!$book['cover_image_directory']) : ?>
                        <img class="cover-img" src="<?= BASEURL;?>/img/cover-placeholder.png" alt="cover">
                    <?php else : ?>
                        <img class="cover-img" src="<?= $book['cover_image_directory']?>" alt="cover">
                    <?php endif; ?>
                    </div>
                    <div class="details">
                        <p class="title"><?= $book['title']?></p>
                        <div class="rating">
                            <img class="rating-star"src="<?= BASEURL;?>/img/star.svg" alt="star">
                            <p class="rating-num"><?= number_format($book['rating'], 2)?></p>
                        </div>
                        <p class="author"><?= $book['author']?></p>
                        <p class="duration"><?= convertTimeToMinutes($book['duration'])?> min</p>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>    
</div>
<script src="<?= BASEURL; ?>/js/lib/debounce.js" ></script>
<script src="<?= BASEURL; ?>/js/lib/flasher.js" defer></script>
<script src="<?= BASEURL; ?>/js/audio_book_user.js" defer></script>
<script type="text/javascript" defer>
    var MAX_PAGES = parseInt("<?= $data['pages'] ?? 0 ?>");
</script>
<?php
function convertTimeToMinutes($time) {
    list($hours, $minutes, $seconds) = explode(':', $time);
    $totalMinutes = ($hours * 60) + $minutes;

    return $totalMinutes;
}
?>