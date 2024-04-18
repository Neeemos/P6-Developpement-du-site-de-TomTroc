<!-- profile_books_section.php -->
<section class="profile__books profileBooks">
    <table class="profileBooks__table <?= $page == 'public' ? 'white__background' : '' ?>">
        <thead class="profileBooks__head ">
            <tr class="head__tab">
                <th>PHOTO</th>
                <th>TITRE</th>
                <th>AUTEUR</th>
                <th>DESCRIPTION</th>
                <?php if ($page != 'public'): ?>
                    <th>DISPONIBILITE</th>
                    <th>ACTION</th>
                <?php endif; ?>

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
                        <?php if ($page != 'public'): ?>
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
                        <?php endif; ?>
                    </tr>
                    <?php
                }
            }
            ?>
        </tbody>
    </table>
</section>