<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tom troc</title>
    <link rel="stylesheet" href="./css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;400;700&display=swap" rel="stylesheet">
</head>

<body>
    <header>
        <nav class="navbar">
            <div class="navbar__content">
                <a href="index.php?action=home" class="navbar__link"><img src="images/logo.svg"
                        alt="Logo officiel de TomTroc" class=""></a>
            </div>
            <div class="navbar__content">
                <ul class="navbar__list">
                    <li
                        class="navbar__item <?= empty($_GET) || (isset($_GET['action']) && !empty($_GET['action'] == "home")) ? 'active' : "" ?>">
                        <a href="index.php?action=home" class="navbar__link">Accueil</a>
                    </li>
                    <li class="navbar__item">
                        <a href="index.php?action=showBooks" class="navbar__link">Nos livres à l'échange</a>
                    </li>
                    <li class="navbar__item">
                        <a href="index.php?action=messagerie" class="navbar__link">Messagerie</a>
                    </li>
                    <?php if (isset($_SESSION["user"])) { ?>
                        <li class="navbar__item">
                            <a href="index.php?action=profil" class="navbar__link">Mon compte</a>
                        </li>
                        <li>
                            <a href='index.php?action=logout' class="navbar__link">Déconnexion</a>
                        </li>
                    <?php } else { ?>
                        <li
                            class="navbar__item <?= empty($_GET) || (isset($_GET['action']) && ($_GET['action'] == "connexion" || $_GET['action'] == "inscription")) ? 'active' : "" ?>">
                            <a href="index.php?action=connexion" class="navbar__link">Connexion</a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </nav>
    </header>

    <main>
        <?= $content /* Ici est affiché le contenu réel de la page. */?>
    </main>

    <footer>
        <a href="index.php" class="footer__link">Politique de confidentialité</a>
        <a href="index.php" class="footer__link">Mentions légales</a>
        <a href="index.php" class="footer__link">Tom Troc©</a>
        <a href="index.php" class="footer__link">
            <img src="images/logo-footer.svg" alt="Logo Tom troc footer" class="footer__img">
        </a>
    </footer>

</body>

</html>