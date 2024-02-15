<section class="showBooks">
    <div class="showBooks__search">
        <h1 class="showBooks__title">Nos livres à l’échange</h1>
        <form action="" class="showBooks__form">
            <input class="showBooks__input" type="text" placeholder="Rechercher un livre">
        </form>
    </div>
    <div class="showBooks__cards  cardbook">
        <?php
        // ajouter les bons liens 
        foreach ($books as $book) { ?>
            <a href='index.php?action=book&id=<?= $book->getId() ?>' class='cardbook__link'>
                <img src='images/<?= $book->getimage() ?>' class="cardbook__image"
                    alt='image du livre <?= $book->getTitle() ?> '>
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
    </div>
        </div>
</section>
</section>
        </form> 
        </a>