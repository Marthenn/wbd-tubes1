<div class="add-author-page">
    <a href="<?= BASEURL;?>/authorlist">
       <img class="back-arrow" src="<?= BASEURL;?>/img/back-arrow.svg" alt="back">
    </a>
    <div class="add-author-contents">
        <div class="add-author-header">
            <h1 id="add-author">Add Author</h1>
        </div>
        <form class="add-author-form"  action="/public/addauthor/add" method="POST" enctype="multipart/form-data">
            <div class="input-field">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" required>
            </div>
            <div class="input-field-description">
                <label for="description">Description</label>
                <textarea name="description" id="description" required></textarea>
            </div>
            <button id="save-changes-author" class="save-changes-author" type="submit" name="save-changes-author">Save Changes</button>
        </form>
    </div>
</div>