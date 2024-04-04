<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tom troc</title>
    <link rel="stylesheet" href="./css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@100;400;700&display=swap&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap"
        rel="stylesheet">
    <script src="https://kit.fontawesome.com/c975db2d5d.js" crossorigin="anonymous"></script>
</head>

<body>
    <header>
        <nav class="navbar">
            <div class="navbar__content">
                <a href="index.php?action=home" class="navbar__link"><img src="images/logo.svg"
                        alt="Logo officiel de TomTroc" class=""></a>
                <ul class="navbar__list">
                    <li
                        class="navbar__item <?= (isset($_GET['action']) && !empty($_GET['action'] == "home")) ? 'active' : "" ?>">
                        <a href="index.php?action=home" class="navbar__link">Accueil</a>
                    </li>
                    <li
                        class="navbar__item <?= (isset($_GET['action']) && !empty($_GET['action'] == "showBooks")) ? 'active' : "" ?>">
                        <a href="index.php?action=showBooks" class="navbar__link">Nos livres à l'échange</a>
                    </li>
                </ul>
            </div>
            <div class="navbar__content">
                <input type="checkbox" id="menu-toggle" class="navbar__menu-toggle">
                <label for="menu-toggle" class="navbar__menu-icon">&#9776;</label>
                <ul class="navbar__list">
                    <li
                        class="navbar__item <?= (isset($_GET['action']) && !empty($_GET['action'] == "messagerie")) ? 'active' : "" ?>">
                        <a href="index.php?action=messagerie" class="navbar__link"><i class="fa-regular fa-comment flipped-icon"></i> Messagerie</a>
                    </li>
                    <li
                            class="navbar__item <?= (isset($_GET['action']) && !empty($_GET['action'] == "profile")) ? 'active' : "" ?>">
                            <a href="index.php?action=profile" class="navbar__link"><i class="fa-regular fa-user flipped-icon"></i> Mon compte</a>
                        </li>
                    <?php if (isset($_SESSION["user"])) { ?>
                        <li>
                            <a href='index.php?action=logout' class="navbar__link">Déconnexion</a>
                        </li>
                    <?php } else { ?>
                        <li
                            class="navbar__item <?= (isset($_GET['action']) && ($_GET['action'] == "login" || $_GET['action'] == "register")) ? 'active' : "" ?>">
                            <a href="index.php?action=login" class="navbar__link">Connexion</a>
                        </li>
                    <?php } ?>
                </ul>

            </div>
        </nav>
    </header>

    <main>
        <?= $content /* Ici est affiché le contenu réel de la page. */ ?>
    </main>

    <footer>
        <a href="index.php" class="footer__link">Politique de confidentialité</a>
        <a href="index.php" class="footer__link">Mentions légales</a>
        <a href="index.php" class="footer__link">Tom Troc©</a>
        <a href="index.php" class="footer__link">
            <img src="images/logo-footer.svg" alt="Logo Tom troc footer" class="footer__img">
        </a>
    </footer>
    <?= (isset($_GET['action']) && !empty($_GET['action'] == "showBooks")) ? '<script src="views/js/filterbooks.js"></script>' : "" ?>
</body>

</html>