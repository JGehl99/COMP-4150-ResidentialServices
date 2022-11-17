<nav class="fixed-top navbar navbar-expand-md background text-color shadow" id="navbar">
    <div class="container-fluid">
        <a class="navbar-brand d-flex" href="index.php">
            <img src="../static/icon.png" alt="Icon" class="navbar_icon">
        </a>
        <button class="navbar-toggler border border-1" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
            <img id="navbar_icon" class="navbar-toggler-icon" src="../static/hamburger_black.svg"
                 alt="Hamburger Menu Icon">
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <?php if (!isLoggedIn()) { ?>
                    <li class="nav-item">
                        <a class="nav-link link-color" aria-current="page" href="login.php">Log In</a>
                    </li>
                <?php } else { ?>
                    <li class="nav-item">
                        <a class="nav-link link-color" aria-current="page" href="logout.php">Log Out</a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</nav>