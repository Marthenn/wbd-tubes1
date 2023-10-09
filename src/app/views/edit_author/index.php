<div class="edit-author-page">
    <a href="<?= BASEURL;?>/authorlist">
       <img class="back-arrow" src="<?= BASEURL;?>/img/back-arrow.svg" alt="back">
    </a>
    <div class="edit-author-contents">
        <div class="edit-author-header">
            <h1 id="edit-author">Edit Author</h1>
        </div>
        <form class="edit-author-form">
            <div class="input-field">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" value=<?= $data['name'] ?> required>
            </div>
            <div class="input-field-description">
                <label for="description">Description</label>
                <textarea name="description" id="description" required><?= $data['description'] ?></textarea>
            </div>
            <button class="save-changes-author" type="submit" name="save-changes-author">Save Changes</button>
            <button class="delete-author" type="submit" name="delete-author">Delete Author</button>
        </form>
        <div id = 'flash-message'></div>
    </div>
</div>
<script src="<?= BASEURL; ?>/js/edit_author.js" defer></script>
<script src="<?= BASEURL; ?>/js/lib/flasher.js" defer></script>
<script type="text/javascript" defer>
    const aid = parseInt("<?= $data['aid']?>");
</script>