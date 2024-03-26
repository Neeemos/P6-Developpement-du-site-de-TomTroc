<div class="profile">
    <div class="profile__card">
        <h1 class="profile__title">Mon compte</h1>
        <div class="profile__data">
            <section class="profile__avatar avatar">
                <img class="avatar__img" src="images/darwin-vegher.jpg" alt="photo de profile">
                <input class="avatar__input" type="file" id="avatar" value="modifier" name="avatar"
                    accept="image/png, image/jpeg">
                <label class="avatar__label" for="avatar">modifier</label>
                <div class="avatar__line"></div>
                <h2 class="avatar__title">
                    <?= $user->pseudo ?>
                </h2>
                <p class="avatar__date">Membre depuis 1 an</p>
                <h3 class="avatar__subtitle">BIBLIOTHEQUE</h3>
                <div class="avatar__count">
                    <?= isset ($books) ? count($books) : 0 ?> livres
                </div>
            </section>
            <section class="profile__information avatar personalInfo">
                <h3 class="personalInfo__title">Vos informations personnelles</h3>
                <form class="personalInfo__form" action="index.php?action=profil" method="POST">
                    <label class="personalInfo__label" for="email">Adresse email</label>
                    <input class="personalInfo__input" type="text" name="email" id="email" value="<?= $user->email ?>">
                    <label class="personalInfo__label" for="password">Mot de passe</label>
                    <input class="personalInfo__input" type="password" name="password" id="password">
                    <label class="personalInfo__label" for="pseudo">Pseudo</label>
                    <input class="personalInfo__input" type="text" name="pseudo" id="pseudo"
                        value="<?= $user->pseudo ?>" readonly>
                    <button type="submit" class="button-border-green button">Enregistrer</button>
                </form>
            </section>
        </div>
        <section class="profile__books profileBooks">
            <table class="profileBooks__table">
                <thead class="profileBooks__head">
                    <tr class="head__tab">
                        <th>PHOTO</th>
                        <th>TITRE</th>
                        <th>AUTEUR</th>
                        <th>DESCRIPTION</th>
                        <th>DISPONIBILITE</th>
                        <th>ACTION</th>
                    </tr>
                </thead>
                <tbody class="tbody">
                    <?php

                    if (isset ($books)) {
                        foreach ($books as $book) {
                            ?>
                            <tr class="tablook">
                                <td class="tablook__image">
                                    <img src="images/<?php echo $book->getimage(); ?>"
                                        alt="Image du livre <?php echo $book->getTitle(); ?>">
                                </td>
                                <td class="tablook__title">
                                    <?php echo $book->getTitle(); ?>
                                </td>
                                <td class="tablook__author">
                                    <?php echo $book->getAuthor(); ?>
                                </td>
                                <td class="tablook__description">
                                    <p class="tablook__description">
                                        <?php echo $book->getDescription(); ?>
                                    </p>
                                </td>
                                <td class="tablook__disponibilite">
                                    <?php if ($book->getAvailable()): ?>
                                        <div class="disponible">Disponible</div>
                                    <?php else: ?>
                                        <div class="indisponible">Non disponible</div>
                                    <?php endif; ?>
                                </td>
                                <td class="tablook__edit-delete">
                                    <a href="index.php?action=editBook&id=<?php echo $book->getId(); ?>" class="edit">Éditer</a>
                                    <a href="#" class="delete">Supprimer</a>
                                </td>
                            </tr>
                            <?php
                        }
                    }
                    ?>

                </tbody>
            </table>
        </section>
    </div>
</div>