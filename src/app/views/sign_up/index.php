<div class="sign-up-page">
    <div class="sign-up-contents">
        <img class="logo" src="<?= BASEURL;?>/img/Logo.svg" alt="logo" >
        <div class="sign-up-form">
            <h2>Welcome!</h2>
            <h1>Sign up to WEBWBD</h1>
            <div id = 'flash-message'>
            </div>
            <form action="" method="post">
                <div class="input-field">
                    <label for="email">Email*</label>
                    <input type="email" name="email" id="email" pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$" autocomplete="email" required>
                    <div class = "error-msg">
                        <span id="email-error-msg"></span>
                    </div>
                </div>
                <div class="input-field">
                    <label for="username">Username*</label>
                    <input type="text" name="username" id="username" autocomplete="username" required>
                    <div class="error-msg">
                        <span id="username-error-msg"></span>
                    </div>
                </div>
                <div class="input-field">
                    <label for="password">Password*</label>
                    <input type="password" name="password" id="password" autocomplete="off" minlength="8" required>
                    <div class="error-msg">
                        <span id="password-error-msg"></span>
                    </div>
                </div>
                <div class="input-field">
                    <label for="confirm-password">Confirm Password*</label>
                    <input type="password" name="confirm-password" id="confirm-password" autocomplete="off" minlength="8" required>
                    <div class="error-msg">
                        <span id="confirm-password-error-msg"></span>
                    </div>
                </div>
                <div class="submit-button">
                    <button type="submit" name="submit">Sign Up</button>
                </div>
            </form>
            <p>Already have an account? <a href="<?= BASEURL;?>/signin">Sign In</a></p>
        </div>
    </div>
</div>

<script src="<?= BASEURL; ?>/js/lib/flasher.js" defer></script>
<script src="<?= BASEURL; ?>/js/lib/debounce.js" defer></script>
<script src="<?= BASEURL; ?>/js/sign_up.js" defer></script>