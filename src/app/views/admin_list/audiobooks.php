<div class="list-page">
    <h1>Audio Book List</h1>
    <div class="search">
        <div class="search-bar">
            <input class="search-input" type="text" id="search-input-book-admin" name="search" placeholder="Search..">
            <img class="search-logo"src="<?= BASEURL;?>/img/search.svg" alt="search">
        </div>
        <button class="search-button" type="submit" id="search-button-book-admin">Search</button>
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
        <button class="filter-button" type="submit" id="filter-button-book-admin-1">Apply Filter</button>
        <select class="filter-dropdown" id="filter-duration" name="filter-category">
            <option value="" selected>By Duration..</option>
            <option value="00:30:00-01:00:00">30-60 min</option>
            <option value="01:00:00-01:30:00">60-90 min</option>
            <option value="01:30:00-02:00:00">90-120 min</option>
        </select>
        <button class="filter-button" type="submit" id="filter-button-book-admin-2">Apply Filter</button>
        <select class="sort-dropdown" id="sort-value" name="filter-category">
            <option value="" selected>Sort by..</option>
            <option value="duration_asc">Duration (min-max)</option>
            <option value="duration_desc">Duration (max-min)</option>
            <option value="title_asc">Title (A-Z)</option>
            <option value="title_desc">Title (Z-A)</option>
        </select>
        <button class="sort-button" type="submit" id="sort-button-book-admin">Sort</button>
    </div>
    <div id = 'flash-message'></div>
    <?php if (!$data['books']) : ?>
        <p class="info">There are no books yet available on webwbd!</p>
    <?php else : ?>
        <div class="data-cards" id="data-cards">
            <?php foreach ($data['books'] as $book) : ?>
                <div class="data-card">
                    <div class="card-content">
                        <p>Book ID: <?= $book['bid'] ?></p>
                        <p>Title: "<?= $book["title"] ?>"</p>
                        <p>Decription: "<?= $book['description'] ?>"</p>
                        <p>Author: "<?= $book['author'] ?>"</p>
                        <p>Category: "<?= $book['category'] ?>"</p>
                        <p>Duration: <?= $book['duration']?></p>
                        <p>Rating: <?= $book['rating'] ?></p>
                    </div>
                    <a href="<?= BASEURL;?>/editbook/index/<?= $book['bid']?>">
                        <img class="edit" src="<?= BASEURL;?>/img/edit.svg" alt="edit">
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
<script src="<?= BASEURL; ?>/js/lib/debounce.js" defer></script>
<script src="<?= BASEURL; ?>/js/lib/flasher.js" defer></script>
<script src="<?= BASEURL; ?>/js/audio_book_list.js" defer></script>
<script type="text/javascript" defer>
    var MAX_PAGES = parseInt("<?= $data['pages'] ?? 0 ?>");
</script>