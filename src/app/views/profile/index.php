<div class="profile-page">
    <div class="profile-contents">
        <div class="profile-header">
            <h1>Profile</h1>
            <a href="" class="close-link">
                <img class="close-img" src="<?= BASEURL;?>/img/close.svg" alt="close">
            </a>
        </div>
        <form class="profile" action="" method="post">
            <img class="profile-img" src="<?= BASEURL;?>/img/user-placeholder.svg" alt="profile">
            <div class="input-field">
                <label for="email">Email</label>
                <div class="inside-input-field">
                    <input type="email" name="email" id="email" pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$" autocomplete="email" required readonly="readonly">
                    <button class="edit-button" type="button" name="edit-button">Edit</button>
                </div>
            </div>
            <div class="input-field">
                <label for="username">Username</label>
                <div class="inside-input-field">
                    <input type="text" name="username" id="username" autocomplete="username" required readonly="readonly">
                    <button class="edit-button" type="button" name="edit-button">Edit</button>
                </div>
            </div>
            <button class="save-changes" type="submit" name="save-changes">Save Changes</button>
            <button class="sign-out" type="button" name="sign-out">Sign Out</button>
            <button class="delete-account" type="submit" name="delete-account">Delete Acccount</button>
        </form>
    </div>
    <div class="profile-decor"></div>
</div>