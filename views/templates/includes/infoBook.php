
<?php $book = $book ?? new book; 
?>

<div class="editBook__editInfo editInfo ">
    <form class="personalInfo__form" <?php echo ($_GET["action"] == "ajoutLivre") ? 'action="index.php?action=ajouterLivre"' : 'action="index.php?action=editBook"'; ?> method="POST">
        <label class="personalInfo__label" for="titre">Titre</label>
        <input class="personalInfo__input" type="text" name="titre" id="titre" value="<?= htmlentities($book->getTitle() ?? '') ?>">
        
        <label class="personalInfo__label" for="auteur">Auteur</label>
        <input class="personalInfo__input" type="text" name="auteur" id="auteur" value="<?= htmlentities($book->getAuthor() ?? '') ?>">
        
        <label class="personalInfo__label" for="commentaire">Commentaire</label>
        <textarea class="personalInfo__input editInfo__textarea" name="commentaire" id="commentaire"><?= htmlentities($book->getDescription() ?? '') ?></textarea>
        
        <label class="personalInfo__label" for="disponibilite">Disponibilité</label>
        <select class="personalInfo__input" id="disponibilite" name="disponibilite">
            <option value="1" <?= ($book && $book->getAvailable() == 1) ? "selected" : "" ?>>Disponible</option>
            <option value="0" <?= ($book && $book->getAvailable() == 0) ? "selected" : "" ?>>Indisponible</option>
        </select>
        
        <input class="editBook__hidden" type="hidden" id="id" name="bookId" value="<?= htmlentities($book->getId() ?? '') ?>">
        
        <button type="submit" class="button button-green button__full">Enregistrer</button>
    </form>
</div>
