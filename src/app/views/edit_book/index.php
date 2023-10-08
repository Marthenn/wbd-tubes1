<div class="edit-book-page">
    <a href="<?= BASEURL;?>/audiobooklist">
       <img class="back-arrow" src="<?= BASEURL;?>/img/back-arrow.svg" alt="back">
    </a>
    <div class="edit-book-contents">
        <div class="edit-book-header">
            <h1 id="edit-book">Edit Book</h1>
        </div>
        <form class="edit-book-form" action="" method="post" enctype="multipart/form-data">
            <div class="input-field">
                <label for="title">Title</label>
                <input type="text" name="title" id="title" value="<?= $data['title']?>" required>
            </div>
            <div class="input-field">
                <label for="author">Author</label>
                <input type="text" name="author" id="author" value="<?= $data['author']?>" required>
            </div>
            <div class="input-field-rating">
                <label for="rating">Rating</label>
                <input type="number" name="rating" id="rating" min="0" max="5" step="0.01" value="<?= number_format($data['rating'], 2)?>" required>
            </div>
            <div class="input-field">
                <label for="category">Category</label>
                <input type="text" name="category" id="category" value="<?= $data['category']?>" required>
            </div>
            <div class="input-field-description">
                <label for="description">Description</label>
                <textarea name="description" id="description" required><?= $data['description']?></textarea>
            </div>
            <div class="file-field">
                <div>
                    <label for="cover-image">Cover Image</label>
                </div>
                <div>
                    <input type="file" accept="image/png, image/jpeg" name="cover-image" id="cover-image" required>
                    <p id="cover-filename">Current file: <?= $data['cover_image_directory']?></p>
                </div>
            </div>
            <div class="file-field">
                <div>
                    <label for="audio-file">Audio File</label>
                </div>
                <div>
                    <input type="file" accept="audio/mp3" name="audio-file" id="audio-file" required>
                    <p id="audio-filename">Current file: <?= $data['audio_directory']?></p>
                </div>
            </div>
            <button id="save-changes-book" class="save-changes-book" type="submit" name="save-changes-book">Save Changes</button>
            <button id="delete-book" class="delete-book" type="submit" name="delete-book">Delete Book</button>
        </form>
        <div id = 'flash-message'></div>
    </div>
</div>
<script src="<?= BASEURL; ?>/js/edit_book.js" defer></script>
<script src="<?= BASEURL; ?>/js/lib/flasher.js" defer></script>
<script type="text/javascript" defer>
    const bid = parseInt("<?= $data['bid']?>");
</script>