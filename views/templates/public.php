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
                <div class="avatar__count--public">
                    <?= isset($books) ? count($books) : 0 ?> livres
                </div>
                <a href="index.php?action=message&id=<?= $user->id ?>" class="button button-border-green">Écrire un message</a>
            </section>
            <section class="profile__books profileBooks">
                <table class="profileBooks__table">
                    <thead class="profileBooks__head white__background">
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

                        if (isset($books)) {
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
                                        <a href="index.php?action=editBook&id=<?php echo $book->getId(); ?>"
                                            class="edit">Éditer</a>
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
</div>