<div class="navbar-user">
    <img class="logo" src="<?= BASEURL;?>/img/Logo.svg" alt="logo" >
    <button class="sidebar-button" id="sidebar-button">
        <img src="<?= BASEURL;?>/img/menu.svg"  alt="sidebar"/>
    </button>
    <div class="navbar-contents">
        <div class="titles">
            <a href="<?= BASEURL;?>/audiobooklist" class="navbar-title">Audio Book List</a>
            <a href="<?= BASEURL;?>/authorlist" class="navbar-title">Author List</a>
            <a href="<?= BASEURL;?>/addbook" class="navbar-title">Add Book</a>
            <a href="<?= BASEURL;?>/addauthor" class="navbar-title">Add Author</a>
            <a href="<?= BASEURL;?>/userlist" class="navbar-title">User List</a>
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
        <a href="<?= BASEURL;?>/audiobooklist" class="navbar-title">Audio Book List</a>
        <a href="<?= BASEURL;?>/authorlist" class="navbar-title">Author List</a>
        <a href="<?= BASEURL;?>/addbook" class="navbar-title">Add Book</a>
        <a href="<?= BASEURL;?>/addauthor" class="navbar-title">Add Author</a>
        <a href="<?= BASEURL;?>/userlist" class="navbar-title">User List</a>
    </div>
</div>