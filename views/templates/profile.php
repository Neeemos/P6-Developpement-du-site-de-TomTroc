<div class="profile">
    <div class="profile__card">
        <h1 class="profile__title">Mon compte</h1>
        <div class="profile__data">
            <?php
            $page = "profile";
            include 'includes/profile.php'; ?>
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
        <?php
        include 'includes/tabBook.php';
        ?>

    </div>
</div>