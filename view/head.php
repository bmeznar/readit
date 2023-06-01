<div class="header_main">
    <div class="main-title">
        <h1><a class="head_title" href="<?php echo BASE_URL; ?>">READIT</a></h1>
    </div>
    <div class="head_links">
        <?php
        if (isset($_SESSION['user_id'])) { ?>
            <div class="dropdown">
                <button class="btn dropdown-toggle profile-btn" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa-solid fa-user"></i>
                    <?php echo $_SESSION['user']; ?>
                </button>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="<?php echo BASE_URL; ?>"><i class="fa-solid fa-house"></i>&nbsp;&nbsp; Home</a>
                    <a class="dropdown-item" href="<?php echo BASE_URL; ?>myprofile"><i class="fa-solid fa-user-gear"></i>&nbsp; My profile</a>
                    <a class="dropdown-item" href="<?php echo BASE_URL; ?>mymessages"><i class="fa-solid fa-comment-dots"></i>&nbsp;&nbsp; My messages</a>
                    <a class="dropdown-item" href="<?php echo BASE_URL; ?>forum/search"><i class="fa-solid fa-magnifying-glass"></i>&nbsp;&nbsp; Search forums</a>
                    <a class="dropdown-item" href="<?php echo BASE_URL; ?>users/search"><i class="fa-solid fa-users"></i>&nbsp; Search users </a>
                    <a class="dropdown-item" href="<?php echo BASE_URL; ?>forum/add"><i class="fa-regular fa-pen-to-square"></i>&nbsp;&nbsp; Create new discussion</a>
                    <a class="dropdown-item" class="dropdown-item" href="<?php echo BASE_URL; ?>logout"><i class="fa-solid fa-right-from-bracket"></i>&nbsp;&nbsp; Logout</a>
                </div>
            </div>

        <?php
        } else { ?>
            <div class="dropdown">
                <button class="btn dropdown-toggle profile-btn" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa-solid fa-user"></i>
                    GUEST
                </button>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="<?php echo BASE_URL; ?>"><i class="fa-solid fa-house"></i>&nbsp;&nbsp; Home</a>
                    <a class="dropdown-item" href="forum/search"><i class="fa-solid fa-magnifying-glass"></i>&nbsp;&nbsp; Search forums</a>
                    <a class="dropdown-item" href="<?php echo BASE_URL; ?>login"><i class="fa-solid fa-right-to-bracket"></i>&nbsp; Login</a>
                </div>
            </div>
        <?php } ?>
    </div>
</div>