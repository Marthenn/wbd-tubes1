<div class="profile-page">
    <div class="profile-contents">
        <div class="profile-header">
            <h1>Profile</h1>
            <a href="<?= BASEURL;?>/audiobooks" class="close-link">
                <img class="close-img" src="<?= BASEURL;?>/img/close.svg" alt="close">
            </a>
        </div>
        <form class="profile" action="" method="post">
            <div class="image-field">
                <img class="profile-img" src="<?= BASEURL;?>/img/user-placeholder.svg" alt="profile">
                <input class="profile-img-edit" accept="image/png, image/jpeg" type="file" id="profile-img-edit" name="profile-img-edit" name="edit-button"/>
                <label for="profile-img-edit" class="custom-file-label">Choose Image</label>
            </div>
            <div class="input-field">
                <label for="email">Email</label>
                <div class="inside-input-field">
                    <input type="email" name="email" id="email" autocomplete="email" required>
                </div>
                <div class="error-msg">
                    <span id="email-error-msg"></span>
                </div>
            </div>
            <div class="input-field">
                <label for="username">Username</label>
                <div class="inside-input-field">
                    <input type="text" name="username" id="username" autocomplete="username" required>
                </div>
                <div class="error-msg">
                    <span id="username-error-msg"></span>
                </div>
            </div>
            <button class="save-changes" type="submit" name="save-changes">Save Changes</button>
            <button class="sign-out" type="button" name="sign-out">Sign Out</button>
            <button class="delete-account" type="submit" name="delete-account">Delete Acccount</button>
        </form>
    </div>
    <div class="profile-decor"></div>
</div>