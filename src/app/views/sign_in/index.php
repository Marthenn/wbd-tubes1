<div class="sign-in-page">
    <div class="sign-in-contents">
        <img class="logo" src="<?= BASEURL;?>/img/Logo.svg" alt="logo" >
        <div class="sign-in-form">
            <h2>Welcome!</h2>
            <h1>Sign in to WEBWBD</h1>
            <div id = 'flash-message'>
            </div>
            <form action="" method="post">
                <div class="input-field">
                    <label for="username">Username*</label>
                    <input type="text" name="username" id="username" autocomplete="username" required>
                </div>
                <div class="input-field">
                    <label for="password">Password* (min. 8 characters)</label>
                    <input type="password" name="password" id="password" autocomplete="current-password" minlength="8" required>
                </div>
                <div class="submit-button">
                    <button type="submit" name="submit">Sign In</button>
                </div>
            </form>
            <p>Don't have an account? <a href="<?= BASEURL;?>/signup">Sign Up</a></p>
        </div>
    </div>
</div>

<script src="<?= BASEURL; ?>/js/lib/flasher.js" defer></script>
<script src="<?= BASEURL; ?>/js/lib/debounce.js" defer></script>
<script src="<?= BASEURL; ?>/js/sign_in.js" defer></script>
