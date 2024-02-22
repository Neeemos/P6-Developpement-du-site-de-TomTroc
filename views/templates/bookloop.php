<?php
foreach ($books as $book) { ?>
    <a href='index.php?action=book&id=<?= $book->getId() ?>' class='cardbook__link'>
        <img src='images/<?= $book->getimage() ?>' class="cardbook__image" alt='image du livre <?= $book->getTitle() ?> '>
        <div class='cardbook__information'>
            <h3 class="cardbook__title">
                <?= $book->getTitle() ?>
            </h3>
            <p class='cardbook__author'>
                <?= $book->getAuthor() ?>
            </p>
            <p class='cardbook__seller'>vendu par :
                <?= $book->getPseudo() ?>
            </p>
        </div>
    </a>
<?php }
?>