<?php

$register_date = new DateTime($user->register_date);
$current_date = new DateTime();
$interval = $current_date->diff($register_date);

if ($interval->y > 0) {
    $avatar__Date = "Membre depuis ". $interval->y . " an";
} elseif ($interval->m > 0) {
    $avatar__Date = "Membre depuis ". $interval->m . " mois";
} elseif ($interval->d > 0) {
    $avatar__Date = "Membre depuis ". $interval->d . " jour(s)";
} else {
    $avatar__Date = "Membre depuis aujourd'hui";
}

?>

<section class="profile__avatar avatar">
    <img class="avatar__img" src="images/<?= isset($user->image) ? $user->image : 'darwin-vegher.jpg' ?>" alt="photo de profile">
    <input class="avatar__input" type="file" id="avatar"  name="avatar" accept="image/png, image/jpeg">
    <label class="avatar__label" for="avatar">modifier</label>
    <div class="avatar__line"></div>
    <h2 class="avatar__title">
        <?= $user->pseudo ?>
    </h2>
    <p class="avatar__date"> <?= $avatar__Date ?></p>
    <h3 class="avatar__subtitle">BIBLIOTHEQUE</h3>
    <?php if (isset($books)): ?>
        <div class="avatar__count<?= $page == 'public' ? '--public' : '' ?>">
            <?= count($books) ?> livres
        </div>
    <?php else: ?>
        <div class="avatar__count<?= $page == 'public' ? '--public' : '' ?>">0 livres</div>
    <?php endif; ?>
    <?php if ($page == 'public'): ?>
        <a href="index.php?action=message&id=<?= $user->id ?>" class="button button-border-green">Écrire un message</a>
    <?php endif; ?>
</section>