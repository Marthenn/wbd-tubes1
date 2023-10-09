<div class="list-page">
    <h1>Author List</h1>
    <div class="search">
        <div class="search-bar">
            <input class="search-input" type="text" id="search-input-author" name="search" placeholder="Search..">
            <img class="search-logo"src="<?= BASEURL;?>/img/search.svg" alt="">
        </div>
        <button class="search-button" id="search-button-author" type="submit">Search</button>
    </div>
    <div id = 'flash-message'></div>
    <?php if (!$data['authors']) : ?>
        <p class="info">There are no authors yet available on webwbd!</p>
    <?php else : ?>
        <div class=data-cards>
            <?php foreach ($data['authors'] as $author) : ?>
                <div class="data-card">
                    <div class="card-content">
                        <p>Author ID: "<?= $author['aid'] ?>"</p>
                        <p>Name: "<?= $author['name'] ?>"</p>
                        <p>Description: "<?= $author['description'] ?>"</p>
                        <p>Authored Books: 
                        <?php
                        echo '[';
                        foreach($author['books'] as $book) {
                            echo ' "' . $book['title'] . '" ';
                        }
                        echo ']';
                        ?>
                        </p>
                    </div>
                    <a href="<?= BASEURL;?>/editauthor/index/<?= $author['aid'] ?>">
                        <img class="edit" src="<?= BASEURL;?>/img/edit.svg" alt="edit">
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
<script src="<?= BASEURL; ?>/js/lib/debounce.js" defer></script>
<script src="<?= BASEURL; ?>/js/lib/flasher.js" defer></script>
<script src="<?= BASEURL; ?>/js/author_list.js" defer></script>
<script type="text/javascript" defer>
    var MAX_PAGES = parseInt("<?= $data['pages'] ?? 0 ?>");
</script>