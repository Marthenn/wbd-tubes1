<div class="list-page">
    <h1>Audio Book List</h1>
    <div class="search">
        <div class="search-bar">
            <input class="search-input" type="text" id="search" name="search" placeholder="Search..">
            <img class="search-logo"src="<?= BASEURL;?>/img/search.svg" alt="search">
        </div>
        <button class="search-button" type="submit">Search</button>
    </div>
    <div class="filter-sort">
        <select class="filter-dropdown" id="filter-category" name="filter-category">
            <option value="" disabled selected>By Category...</option>
            <option value="fantasy">Fantasy</option>
            <option value="comedy">Comedy</option>
            <option value="romance">Romance</option>
        </select>
        <button class="filter-button" type="submit">Apply Filter</button>
        <select class="filter-dropdown" id="filter-category" name="filter-category">
            <option value="" disabled selected>By Duration..</option>
            <option value="30-60 min">30-60 min</option>
            <option value="60-90 min">60-90 min</option>
            <option value="90-120 min">90-120 min</option>
        </select>
        <button class="filter-button" type="submit">Apply Filter</button>
        <select class="sort-dropdown" id="filter-category" name="filter-category">
            <option value="" disabled selected>Sort by..</option>
            <option value="DurationAsc">Duration (min-max)</option>
            <option value="DurationDesc">Duration (max-min)</option>
            <option value="TitleAsc">Title (A-Z)</option>
            <option value="TitleDesc">Title (Z-A)</option>
        </select>
        <button class="sort-button" type="submit">Sort</button>
    </div>
    <?php if (!$data['books']) : ?>
        <p class="info">There are no books yet available on webwbd!</p>
    <?php else : ?>
        <div class="data-cards" id="data-cards">
            <?php foreach ($data['books'] as $book) : ?>
                <div class="data-card">
                    <div class="card-content">
                        <p>Book_ID: <?= $book['bid'] ?></p>
                        <p>Title: "<?= $book["title"] ?>"</p>
                        <p>Decription: "<?= $book['description'] ?>"</p>
                        <p>Author: "<?= $book['author'] ?>"</p>
                        <p>Category: "<?= $book['category'] ?>"</p>
                        <p>Duration: <?= $book['duration']?></p>
                        <p>Rating: <?= $book['rating'] ?></p>
                    </div>
                    <a href="<?= BASEURL;?>/editbook">
                        <img class="edit" src="<?= BASEURL;?>/img/edit.svg" alt="edit">
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
<script src="<?= BASEURL; ?>/js/audio_book_list/audio_book_list.js" defer></script>
<script type="text/javascript" defer>
    const PAGES = parseInt("<?= $data['pages'] ?? 0 ?>");
</script>