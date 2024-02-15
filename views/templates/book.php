<section class="showBook">
    <div class="showBook__header">
        <a href="#" class="showBook__link">Nos livres > <?= $book->getTitle() ?></a>
    </div>
    <div class="book">
        <img class="book__image" src="images/<?= $book->getimage() ?>" alt="image du livre <?= $book->getTitle() ?>">
        <div class="book__content">
            <h2 class="book__title"><?= $book->getTitle() ?></h2>
            <p class="book__author">par <?= $book->getAuthor() ?></p>
            <h3 class="book__soustitle">DESCRIPTION</h3>
            <p class="book__description"><?= $book->getDescription() ?></p>
            <h3 class="book__soustitle">Propriétaire</h3>
            <div class="book__userInformation userInformation">
                <img class="userInformation__image"src="images/<?= $book->getuserImage() ?>" alt="image du propriétaire">
                <p class="userInformation__text"><?= $book->getPseudo() ?></p>
            </div>
            <a href="#" class="button button-green book__button">Envoyer un message</a>
        </div>
    </div>
</section>