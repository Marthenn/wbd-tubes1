<div class="edit-book-page">
    <a href="<?= BASEURL;?>/audiobooklist">
       <img class="back-arrow" src="<?= BASEURL;?>/img/back-arrow.svg" alt="back">
    </a>
    <div class="edit-book-contents">
        <div class="edit-book-header">
            <h1 id="edit-book">Edit Book</h1>
        </div>
        <form class="edit-book-form" action="" method="post">
            <div class="input-field">
                <label for="title">Title</label>
                <input type="text" name="title" id="title" value="data from db" required>
            </div>
            <div class="input-field">
                <label for="author">Author</label>
                <input type="text" name="author" id="author" value="data from db" required>
            </div>
            <div class="input-field-rating">
                <label for="rating">Rating</label>
                <input type="number" name="rating" id="rating" min="0" max="5" step="0.1" value=5.0 required>
            </div>
            <div class="input-field">
                <label for="category">Category</label>
                <input type="text" name="category" id="category" value="data from db" required>
            </div>
            <div class="input-field-description">
                <label for="description">Description</label>
                <textarea name="description" id="description" required>data from db</textarea>
            </div>
            <div class="file-field">
                <div>
                    <label for="cover-image">Cover Image</label>
                </div>
                <div>
                    <input type="file" name="cover-image" id="cover-image" value="data from db" required>
                </div>
            </div>
            <div class="file-field">
                <div>
                    <label for="audio-file">Audio File</label>
                </div>
                <div>
                    <input type="file" name="audio-file" id="audio-file" value="data from db" required>
                </div>
            </div>
            <button class="save-changes-book" type="submit" name="save-changes-book">Save Changes</button>
            <button class="delete-book" type="submit" name="delete-book">Delete Book</button>
        </form>
    </div>
</div>