<div class="add-book-page">
    <a href="<?= BASEURL;?>/audiobooklist">
       <img class="back-arrow" src="<?= BASEURL;?>/img/back-arrow.svg" alt="back">
    </a>
    <div class="add-book-contents">
        <div class="add-book-header">
            <h1 id="add-book">Add Book</h1>
        </div>
        <form class="add-book-form" action="/public/addauthor/add" method="POST" enctype="multipart/form-data">
            <div class="input-field">
                <label for="title">Title</label>
                <input type="text" name="title" id="title" required>
            </div>
            <div class="input-field">
                <label for="author">Author</label>
                <input type="text" name="author" id="author" required>
            </div>
            <div class="input-field-rating">
                <label for="rating">Rating</label>
                <input type="number" name="rating" id="rating" min="0" max="5" step="0.1" required>
            </div>
            <div class="input-field">
                <label for="category">Category</label>
                <input type="text" name="category" id="category" required>
            </div>
            <div class="input-field-description">
                <label for="description">Description</label>
                <textarea name="description" id="description" required></textarea>
            </div>
            <div class="file-field">
                <div>
                    <label for="cover-image">Cover Image</label>
                </div>
                <div>
                    <input type="file" name="cover-image" id="cover-image" required>
                </div>
            </div>
            <div class="file-field">
                <div>
                    <label for="audio-file">Audio File</label>
                </div>
                <div>
                    <input type="file" name="audio-file" id="audio-file" required>
                </div>
            </div>
            <button class="save-changes-book" type="submit" name="save-changes-book" id="save-changes-book">Save Changes</button>
        </form>
    </div>
</div>
<script src="<?= BASEURL; ?>/js/add_book.js" defer></script>