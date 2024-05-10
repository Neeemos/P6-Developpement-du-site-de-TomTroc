<div class="EditBook profile">

    <div class="profile__card">
        <?php if ($_GET["action"] != "ajoutLivre") { ?>
            <h1 class="profile__title">Modifier les informations</h1>
        <?php } else { ?>
            <h1 class="profile__title">Ajouter un livre</h1>
        <?php } ?>
        <div class="editBook__background">
            <div class="editBook__card">
                <?php if ($_GET["action"] != "ajoutLivre") { ?>
                    <p class="editBook__text">Photo</p>

                    <img class="editBook__image"
                        src="images/<?= ($book->getImage()) ? $book->getImage() : "hamza-nouasria.jpg" ?>">
                    <form id="uploadForm" action="index.php?action=editBookPhoto" method="post"
                        enctype="multipart/form-data">
                        <input class="avatar__input" type="file" id="avatar" name="avatar" accept="image/png, image/jpeg">
                        <input class="hidden" id="bookId" name="bookId" value="<?= $book->getId() ?>" hidden>
                        <label class="avatar__label" for="avatar">modifier</label>
                    </form>
                <?php } ?>
            </div>
            <?php include ('views/templates/includes/infoBook.php'); ?>
        </div>
    </div>
</div>