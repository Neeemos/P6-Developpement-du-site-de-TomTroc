<section class="showBook">
    <div class="showBook__header">
        <a href="#" class="showBook__link">Nos livres > <?= $book->getTitle() ?></a>
    </div>
    <div class="book">
        <img class="book__image" src="images/<?= ($book->getimage()) ? $book->getimage() : "hamza-nouasria.jpg" ?>" alt="image du livre <?= $book->getTitle() ?>">
        <div class="book__content">
            <h2 class="book__title"><?= $book->getTitle() ?></h2>
            <p class="book__author">par <?= $book->getAuthor() ?></p>
            <h3 class="book__soustitle">DESCRIPTION</h3>
            <p class="book__description"><?= $book->getDescription() ?></p>
            <h3 class="book__soustitle">Propriétaire</h3>
            <div class="book__userInformation userInformation">
                <img class="userInformation__image"
                    src="images/<?= ($book->getuserImage()) ? $book->getuserImage() : 'darwin-vegher.jpg' ?>"
                    alt="image du propriétaire">
                <p class="userInformation__text"><a href="index.php?action=public&id=<?= $book->getuserId() ?>">
                        <?= $book->getPseudo() ?></a></p>
            </div>
            <?php if ($book->getuserId() != $_SESSION['user']->getId()) { ?>
            <a href="index.php?action=messagerie&id=<?= $book->getuserId() ?>" class="button button-green book__button">Envoyer un message</a>
            <?php } ?>
        </div>
    </div>
</section>