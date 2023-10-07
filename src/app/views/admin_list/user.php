<div class="list-page">
    <h1>User List</h1>
    <div class="search">
        <div class="search-bar">
            <input class="search-input" type="text" id="search" name="search" placeholder="Search..">
            <img class="search-logo"src="<?= BASEURL;?>/img/search.svg" alt="search">
        </div>
        <button class="search-button" type="submit">Search</button>
    </div>
    <?php if (!$data['users']) : ?>
        <p class="info">There are no user yet on webwbd!</p>
    <?php else : ?>
        <div class="data-cards" id="data-cards">
            <?php foreach ($data['users'] as $user) : ?>
                <div class="data-card">
                    <div class="card-content">
                        <p>User_ID: <?= $user['uid'] ?></p>
                        <p>Username: <?= $user['username'] ?></p>
                        <p>Email: <?= $user['email'] ?></p>
                        <p>Joined Date: <?= $user['joined_date'] ?></p>
                        <p>Type: <?= $user['is_admin'] === true ? 'admin' : 'user' ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
<script type="text/javascript" defer>
    const MAX_PAGES = parseInt("<?= $data['pages'] ?? 0 ?>");
</script>