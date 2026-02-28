<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">🗺️ Interactive Map</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="home.php">🏠 Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="about.php">🔍 About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="contact.php">📞 Contact</a>
                </li>
                <?php if ($id == 1) { ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            ⚙️ Filter Options
                        </a>
                        <ul class="dropdown-menu">
                            <div class="inline-item">
                                <a class="dropdown-item" href="#" onclick="fetchPins(0)">All pins</a>
                                <img src="" alt="" style="height: 20;">
                            </div>
                            <!-- <li><a class="dropdown-item" href=""></a></li> -->
                            <li id="li-add"></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="#" onclick="showEmptyForm()">Empty Map 🗑️</a></li>
                            <li><a class="dropdown-item" href="#">Support Developer 💰</a></li>
                        </ul>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</nav>