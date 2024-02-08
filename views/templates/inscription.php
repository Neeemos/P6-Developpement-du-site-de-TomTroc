<section class="login">
    <div class="login__content">
        <div class="login__form form">
            <h1 class="form__title">Inscription</h1>
            <form action="index.php?action=postInscription" method="POST">
                <div  class="form__line">
                    <label for="pseudo" class="form__label">Pseudo</label>
                    <input type="text" id="pseudo" name="pseudo" class="form__input">
                </div>
                <div  class="form__line">
                    <label for="email" class="form__label">Adresse email</label>
                    <input type="email" id="email" name="email" class="form__input">
                </div>
                <div  class="form__line">
                    <label for="password" class="form__label">Mot de passe</label>
                    <input type="password" id="password" name="password" class="form__input">
                </div>
                <input type="submit" class="button button-green form__button" value="S'inscrire">
            </form>
            <div class="form__text">Déjà inscrit ? <a href="index.php?action=connexion" class="form__link">Connectez-vous</a></div>
        </div>
    </div>
    <img src="images/Maskgroup.png" alt="image bibliothèque" class="login__img">
</section>

<?php
?>