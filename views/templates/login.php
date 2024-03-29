<section class="login">
    <div class="login__content">
        <div class="login__form form">
            <h1 class="form__title">Connexion</h1>
            <form action="index.php?action=login" method="POST">
                <div class="form__line">
                    <label for="email" class="form__label">Adresse email</label>
                    <input type="email" id="email" name="email" class="form__input">
                </div>
                <div class="form__line">
                    <label for="password" class="form__label" >Mot de passe</label>
                    <input type="password" id="password" name="password" class="form__input">
                </div>
                <input type="submit" class="button button-green form__button" value="Se connecter">
            </form>
            <p class="form__text">Pas de compte ? <a href="index.php?action=register" class="form__link">Inscrivez-vous</a></p>
        </div>
    </div>
    <img src="images/Maskgroup.png" alt="image bibliothèque" class="login__img">
</section>