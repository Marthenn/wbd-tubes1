<div class="navbar-user">
    <img class="logo" src="<?= BASEURL;?>/img/Logo.svg" alt="logo" >
    <button class="sidebar-button" id="sidebar-button">
        <img src="<?= BASEURL;?>/img/menu.svg"  alt="sidebar"/>
    </button>
    <div class="navbar-contents">
        <div class="titles">
            <a href="<?= BASEURL;?>/audiobooks" class="navbar-title">Audio Books</a>
        </div>
        <div class="user-info">
            <a href="<?= BASEURL;?>/profile" class="user-photo">
                <img src="<?= BASEURL;?>/img/user-placeholder.svg" class="user-photo-img" alt="User photo"/>
            </a>
            <a href="<?= BASEURL;?>/profile" class="username"> <?=$_COOKIE['username']?> </a>
        </div>
    </div>
</div>
<div class="sidebar" id="sidebar">
    <button class="close-sidebar-button" id="close-sidebar-button">
        <img class="close-img" src="<?= BASEURL;?>/img/close.svg" alt="close">
    </button>
    <div class="sidebar-user-info">
        <a href="<?= BASEURL;?>/profile" class="user-photo">
            <img src="<?= BASEURL;?>/img/user-placeholder.svg" class="user-photo-img" alt="User photo"/>
        </a>
        <a href="<?= BASEURL;?>/profile" class="username"> <?=$_COOKIE['username']?> </a>
    </div>
    <div class="sidebar-titles">
        <a href="<?= BASEURL;?>/audiobooks" class="navbar-title">Audio Books</a>
    </div>
</div>

<script src="<?= BASEURL;?>/js/navbar.js"></script>