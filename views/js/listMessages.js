document.addEventListener("DOMContentLoaded", function () {
    fetchMessagerieList();
});

function fetchMessagerieList() {
    fetch('index.php?action=getMessagerieList')
        .then(response => response.json())
        .then(data => {
            const messageOverlay = document.querySelector('.message__overlay.overlay');
            data.forEach(user => {
                const overlayCard = createOverlayCard(user);
                messageOverlay.appendChild(overlayCard);
            });

            // Check if URL contains an id parameter
            const urlParams = new URLSearchParams(window.location.search);
            const userIdParam = urlParams.get('id');
            if (userIdParam) {
                // Execute updateHeader with userId from id parameter
                fetchUserInfo(userIdParam);
            }
        })
        .catch(error => console.error('Error fetching messagerie list:', error));
}
function fetchUserInfo(userId) {
    fetch(`index.php?action=userInfo&userId=${userId}`)
        .then(response => response.json())
        .then(user => {
            // Execute updateHeader with user information
            updateHeader(userId, user);
        })
        .catch(error => console.error('Error fetching user information:', error));
}
function createOverlayCard(user) {
    const overlayCard = document.createElement('div');
    overlayCard.classList.add('overlay__card');
    if (user.id_receiver == user.session_id) {
        overlayCard.classList.add('overlay__receiver');
    }
    const overlayLink = document.createElement('a');
    overlayLink.classList.add('overlay__link');
    const overlayImage = document.createElement('img');
    overlayImage.classList.add('overlay__image');
    overlayImage.src = user.image ? 'images/' + user.image : 'images/darwin-vegher.jpg';
    overlayImage.alt = 'Photo de profil';
    const overlaySnippet = document.createElement('div');
    overlaySnippet.classList.add('overlay__snippet', 'snippet');
    const snippetTitle = document.createElement('p');
    snippetTitle.classList.add('snippet__title');
    snippetTitle.textContent = user.pseudo;
    const snippetMessage = document.createElement('p');
    snippetMessage.classList.add('snippet__message');
    snippetMessage.textContent = user.message;
    const snippetTime = document.createElement('p');
    snippetTime.classList.add('snippet__time');
    snippetTime.textContent = formatDate(user.date);

    const overlayLinkHiddenInput = document.createElement('input');
    overlayLinkHiddenInput.type = 'hidden';
    overlayLinkHiddenInput.name = 'conversation_id';
    overlayLinkHiddenInput.value = user.id_receiver == user.session_id ? user.id_sender : user.id_receiver;
    overlayLink.appendChild(overlayLinkHiddenInput);

    overlayLink.appendChild(overlayImage);
    overlayLink.appendChild(overlaySnippet);
    overlaySnippet.appendChild(snippetTitle);
    overlaySnippet.appendChild(snippetMessage);
    overlayCard.appendChild(overlayLink);
    overlayCard.appendChild(snippetTime);

    overlayLink.addEventListener('click', function (event) {
        event.preventDefault();
        if (window.innerWidth <= 1200) {
            document.querySelector('.message__overlay.overlay').style.display = "none";
        }
        const userId = overlayLinkHiddenInput.value;
        updateHeader(userId, user);
        fetchAndDisplayConversationMessages(userId);
    });

    return overlayCard;
}

function updateHeader(userId, user) {
    console.log(user);
    const header = document.querySelector('.discussion__top.topdiscussion');
    header.innerHTML = '';
    const userIdInput = document.querySelector('input[name="userId"]');
    userIdInput.value = userId;
    const headerIcon = document.createElement('a');
    headerIcon.classList.add('topdiscussion__icon');
    headerIcon.href = '#';
    headerIcon.innerHTML = '<i class="fa-solid fa-arrow-left"></i> retour';

    const headerLink = document.createElement('a');
    headerLink.classList.add('topdiscussion__link');
    headerLink.href = 'index.php?action=public&id=' + userId;

    const headerImage = document.createElement('img');
    headerImage.classList.add('topdiscussion__image');

    headerImage.src = user.image ? 'images/' + user.image : 'images/darwin-vegher.jpg';
    headerImage.alt = 'Photo de profil';

    const headerUsername = document.createElement('p');
    headerUsername.classList.add('topdiscussion__username');
    headerUsername.textContent = user.pseudo;

    headerLink.appendChild(headerImage);
    headerLink.appendChild(headerUsername);
    header.appendChild(headerIcon);
    header.appendChild(headerLink);

    headerIcon.addEventListener('click', function (event) {
        event.preventDefault();
        document.querySelector('.message__overlay.overlay').style.display = "block";
        header.innerHTML = '';
        document.querySelector('.discussion__messages.messages').innerHTML = '';
    });
}

function formatDate(dateString) {
    return new Date(dateString).toLocaleTimeString('fr-FR', { hour: '2-digit', minute: '2-digit' });
}

function formatDateConversation(dateString) {
    return new Date(dateString).toLocaleTimeString('fr-FR', { day: '2-digit', month: '2-digit', hour: '2-digit', minute: '2-digit', separator: '.' });
}

function fetchAndDisplayConversationMessages(userId) {
    fetch('index.php?action=getConversationMessages&userId=' + userId)
        .then(response => response.json())
        .then(data => {
            const messageDiscussion = document.querySelector('.discussion__messages.messages');
            messageDiscussion.innerHTML = '';

            data.forEach(message => {
                const messageBox = createMessageBox(message);
                messageDiscussion.appendChild(messageBox);
            });

        })
        .catch(error => console.error('Error fetching conversation messages:', error));
}

function createMessageBox(message) {
    const messageBox = document.createElement('div');
    messageBox.classList.add('message__box', message.id_sender == message.session_id ? 'messages__sender' : 'messages__receiver');

    const messageDateTime = document.createElement('p');
    messageDateTime.classList.add('message__date-time');
    messageDateTime.textContent = formatDateConversation(message.date);

    if (parseInt(message.id_receiver) == parseInt(message.session_id)) {
        const messageProfilePicture = document.createElement('img');
        messageProfilePicture.classList.add('messages__photo');
        messageProfilePicture.src = message.image ? 'images/' + message.image : 'images/darwin-vegher.jpg';
        messageProfilePicture.alt = 'Photo de profil';
        messageBox.appendChild(messageProfilePicture);
    }

    const messageBlock = document.createElement('div');
    messageBlock.classList.add('message__block');

    const messageContent = document.createElement('p');
    messageContent.classList.add(parseInt(message.id_receiver) !== parseInt(message.session_id) ? 'message__content-sender' : 'message__content');
    messageContent.textContent = message.message;

    messageBox.appendChild(messageDateTime);
    messageBox.appendChild(messageBlock);
    messageBlock.appendChild(messageContent);

    return messageBox;
}

function submitMessageViaAjax(event) {
    event.preventDefault();
    const form = event.target;
    const formData = new FormData(form);
    fetch(form.action, {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            const messageDiscussion = document.querySelector('.discussion__messages.messages');
            const newMessage = data;
            const messageBox = createMessageBox(newMessage);
            messageDiscussion.appendChild(messageBox);
        })
        .catch(error => console.error('Error adding message:', error));
}

document.getElementById('add-message-form').addEventListener('submit', submitMessageViaAjax);
