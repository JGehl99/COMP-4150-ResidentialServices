<nav class="sticky-top navbar navbar-expand-md background text-color shadow">
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
        <?php
            if(isAdminUser()) {
                include('adminnav.php');
            }
            else {
                include('studentnav.php');
            }
        ?>
    </div>
</nav>