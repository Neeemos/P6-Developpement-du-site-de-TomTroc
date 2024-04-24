    <div class="message">
        <section class="message__overlay overlay" style="display: none;">
            <h2 class=" overlay__title">Messagerie</h2>
            <?php foreach ($messages as $message) {
            ?>
                <div class="overlay__card">
                    <a class="overlay__link" href=" index.php?action=messagerie&contact=<?= Access::checkMessageOwnership($message) ?>">
                        <img class="overlay__image" src="images/darwin-vegher.jpg" alt="Photo de profil">
                        <div class="overlay__snippet snippet">
                            <p class="snippet__title">Jean Claude</p>
                            <p class="snippet__message"><?= $message->getMessage(); ?></p>
                        </div>
                    </a>
                    <p class="snippet__time">15:43</p>
                </div>
            <?php } ?>
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
                <div class="messages__sender message__box">
                    <!-- <img class="messages__photo" src="" alt="username"> -->
                    <p class="message__date-time">24.04 15:33</p>
                    <div class="message__block">
                        <p class="message__content-sender">Message blablalbla</p>
                    </div>
                </div>
                <div class="messages__receiver message__box">
                    <img class="messages__photo" src="images/darwin-vegher.jpg" alt="username">
                    <p class="message__date-time">24.04 15:33</p>

                    <div class="message__block">
                        <p class="message__content">Message blablalbla</p>
                    </div>
                </div>
            </div>

            <div class="discussion__bot botdiscussion">
                <form class="botdiscussion__form" method="POST" action="index.php?action=addMessage">
                    <input class="botdiscussion__input" id="add-message" name="message" placeholder="Tapez votre message ici" required></textarea>
                    <input name="userId" value="idUserReception" hidden="true">
                    <input class="button button-green botdiscussion__button" type="submit" value="Envoyer">
                </form>
            </div>
        </section>
    </div>