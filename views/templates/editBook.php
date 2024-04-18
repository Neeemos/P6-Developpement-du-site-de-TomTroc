<div class="EditBook profile">

    <div class="profile__card">
        <h1 class="profile__title">Modifier les informations</h1>
        <div class="editBook__background">
            <div class="editBook__card">
                <p class="editBook__text">Photo</p>
                <img class="editBook__image" src="images/hamza-nouasria.jpg" alt="image du livre Titre Livre 3">
                <label for="fileInput" class="editBook__link">Modifier la photo</label>
                <input class="editBook__hidden"type="file" id="fileInput">
            </div>
            <div class="editBook__editInfo editInfo ">
                <form class="personalInfo__form" action="index.php?action=editBook" method="POST">
                    <label class="personalInfo__label" for="titre">Titre</label>
                    <input class="personalInfo__input" type="text" name="titre" id="titre"
                        value="<?= $book->getTitle() ?>">
                    <label class="personalInfo__label" for="auteur">Auteur</label>
                    <input class="personalInfo__input" type="text" name="auteur" id="auteur"
                        value="<?= $book->getAuthor() ?>">
                    <label class="personalInfo__label" for="commentaire">Commentaire</label>
                    <textarea class="personalInfo__input editInfo__textarea" name="commentaire" id="commentaire"
                        type="text-area"><?= $book->getDescription() ?></textarea>
                    <label class="personalInfo__label" for="disponibilite">Disponibilité</label>
                    <select class="personalInfo__input" id="disponibilite" name="disponibilite">
                        <option value="1" <?= ($book->getAvailable() == 1) ? "selected" : "" ?>>Disponible </option>
                        <option value="0" <?= ($book->getAvailable() == 0) ? "selected" : "" ?>>Indisponible</option>

                    </select>
                    <input class="editBook__hidden" type="text" id="id" name="bookId" value="<?= $book->getId() ?>">
                    <button type="submit" class="button button-green button__full">Enregistrer</button>
                </form>
            </div>
        </div>
    </div>
</div>