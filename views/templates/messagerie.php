<div class="message">
    <section class="message__overlay overlay">
        <h2 class=" overlay__title">Messagerie</h2>
        <!--- JS generate the HTML content -->
    </section>

    <section class="message__discussion discussion">
        <div class="discussion__top topdiscussion">
            <a class="topdiscussion__icon" href="#"> <i class="fa-solid fa-arrow-left"></i> retour </a>
            <a class="topdiscussion__link" href="index.php?action=public&id=6">
                <img class="topdiscussion__image" src="images/darwin-vegher.jpg" alt="Photo de profil">
                <p class="topdiscussion__username">Alexculture </p>
            </a>
        </div>
        <div class="discussion__messages messages">
            <!--- JS generate the HTML content -->
        </div>

        <div class="discussion__bot botdiscussion">
            <form class="botdiscussion__form" method="POST" action="index.php?action=addMessage">
                <input class="botdiscussion__input" id="add-message" name="message"
                    placeholder="Tapez votre message ici" required></textarea>
                <input name="userId" value="idUserReception" hidden="true">
                <input class="button button-green botdiscussion__button" type="submit" value="Envoyer">
            </form>
        </div>
    </section>
</div>