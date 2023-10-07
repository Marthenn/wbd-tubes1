<div class="edit-author-page">
    <a href="<?= BASEURL;?>/authorlist">
       <img class="back-arrow" src="<?= BASEURL;?>/img/back-arrow.svg" alt="back">
    </a>
    <div class="edit-author-contents">
        <div class="edit-author-header">
            <h1 id="edit-author">Edit Author</h1>
        </div>
        <form class="edit-author-form" action="/public/addauthor/add" method="PUT" enctype="multipart/form-data">
            <div class="input-field">
                <label for="title">Name</label>
                <input type="text" name="title" id="title" value="data from db" required>
            </div>
            <div class="input-field-description">
                <label for="description">Description</label>
                <textarea name="description" id="description" required></textarea>
            </div>
            <button class="save-changes-author" type="submit" name="save-changes-author">Save Changes</button>
            <button class="delete-author" type="submit" name="delete-author">Delete Author</button>
        </form>
    </div>
</div>