<div class="message">
    <section class="message__overlay overlay">
        <h2 class=" overlay__title">Messagerie</h2>
        <!--- JS generate the HTML content -->
    </section>

    <section class="message__discussion discussion">
        <div class="discussion__top topdiscussion">
            <!--- JS generate the HTML content -->
        </div>
        <div class="discussion__messages messages">
            <!--- JS generate the HTML content -->
        </div>

        <div class="discussion__bot botdiscussion">
            <form class="botdiscussion__form" id="add-message-form" method="POST" action="index.php?action=addMessage">
                <input class="botdiscussion__input" id="add-message" name="message"
                    placeholder="Tapez votre message ici" required>
                <input name="userId" id="user-id-input" hidden>
                <input class="button button-green botdiscussion__button" id="submit-button" type="submit"
                    value="Envoyer">
            </form>
        </div>
    </section>
</div>