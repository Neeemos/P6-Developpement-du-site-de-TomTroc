<section class="showBooks">
    <div class="showBooks__search">
        <h1 class="showBooks__title">Nos livres à l’échange</h1>
        <form action="" class="showBooks__form">
            <div class="input-container">
                <input class="showBooks__input" type="text" placeholder="Rechercher un livre">
                <i class="fa-solid fa-magnifying-glass"></i>
            </div>
        </form>

    </div>
    <div class="showBooks__cards  cardbook">
        <?php include('views/templates/bookloop.php'); ?>
    </div>
</section>
