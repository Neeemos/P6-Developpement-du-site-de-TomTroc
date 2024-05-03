document.addEventListener("DOMContentLoaded", function () {
    // Make a request to fetch messagerie list
    fetch('index.php?action=getMessagerieList')
        .then(response => response.json())
        .then(data => {
            // Select the message overlay section
            const messageOverlay = document.querySelector('.message__overlay.overlay');
            const header = document.querySelector('.discussion__top.topdiscussion');
            // Loop through the array data to build HTML
            data.forEach(user => {
                // Create elements
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

                // Create and add hidden input
                const overlayLinkHiddenInput = document.createElement('input');
                overlayLinkHiddenInput.type = 'hidden';
                overlayLinkHiddenInput.name = 'conversation_id';
                if (user.id_receiver == user.session_id) {
                    overlayLinkHiddenInput.value = user.id_sender;
                } else {
                    overlayLinkHiddenInput.value = user.id_receiver;
                }
                overlayLink.appendChild(overlayLinkHiddenInput);

                // Append elements
                overlayLink.appendChild(overlayImage);
                overlayLink.appendChild(overlaySnippet);
                overlaySnippet.appendChild(snippetTitle);
                overlaySnippet.appendChild(snippetMessage);
                overlayCard.appendChild(overlayLink);
                overlayCard.appendChild(snippetTime);
                messageOverlay.appendChild(overlayCard);

                // Add event listener to overlay link
                overlayLink.addEventListener('click', function (event) {
                    event.preventDefault(); // Prevent default link behavior

                    const userId = overlayLinkHiddenInput.value; // Get user ID from hidden input
                    // Remove existing header elements
                    while (header.firstChild) {
                        header.removeChild(header.firstChild);
                    }

                    // Create elements header
                    const headerIcon = document.createElement('a');
                    headerIcon.classList.add('topdiscussion__icon');
                    headerIcon.href = '#';
                    headerIcon.innerHTML = '<i class="fa-solid fa-arrow-left"></i> retour';

                    const headerLink = document.createElement('a');
                    headerLink.classList.add('topdiscussion__link');
                    headerLink.href = 'index.php?action=public&id=' + user.id;

                    const headerImage = document.createElement('img');
                    headerImage.classList.add('topdiscussion__image');
                    headerImage.src = user.image ? 'images/' + user.image : 'images/darwin-vegher.jpg';
                    headerImage.alt = 'Photo de profil';

                    const headerUsername = document.createElement('p');
                    headerUsername.classList.add('topdiscussion__username');
                    headerUsername.textContent = user.pseudo;

                    // Append elements to header
                    headerLink.appendChild(headerImage);
                    headerLink.appendChild(headerUsername);
                    header.appendChild(headerIcon);
                    header.appendChild(headerLink);

                    fetchAndDisplayConversationMessages(userId);
                });
            });
        })
        .catch(error => console.error('Error fetching messagerie list:', error));
});

// Function to format date
function formatDate(dateString) {
    return new Date(dateString).toLocaleTimeString('fr-FR', { hour: '2-digit', minute: '2-digit' });
}

// Function to format date for conversation messages
function formatDateConversation(dateString) {
    return new Date(dateString).toLocaleTimeString('fr-FR', { day: '2-digit', month: '2-digit', hour: '2-digit', minute: '2-digit', separator: '.' });
}

function fetchAndDisplayConversationMessages(userId) {
    // Fetch conversation messages
    fetch('index.php?action=getConversationMessages&userId=' + userId)
        .then(response => response.json())
        .then(data => {
            // Select message discussion section
            const messageDiscussion = document.querySelector('.discussion__messages.messages');
            // Select user ID input hidden field
            const userIdInput = document.querySelector('input[name="userId"]');
            userIdInput.value = userId;
            // Clear previous messages
            messageDiscussion.innerHTML = '';

            // Loop through the array data to build HTML for messages
            data.forEach(message => {
                const idReceiver = parseInt(message.id_receiver);
                const sessionId = parseInt(message.session_id);

                const messageBox = document.createElement('div');
                if (message.id_sender == sessionId) {
                    messageBox.classList.add('messages__sender', 'message__box');
                } else {
                    messageBox.classList.add('messages__receiver', 'message__box');
                }
                const messageDateTime = document.createElement('p');

                if (idReceiver == sessionId) {
                    const messageProfilePicture = document.createElement('img');
                    messageProfilePicture.classList.add('messages__photo');
                    messageProfilePicture.src = message.image ? 'images/' + message.image : 'images/darwin-vegher.jpg';
                    messageProfilePicture.alt = 'Photo de profil';
                    messageBox.appendChild(messageProfilePicture);
                }
                messageDateTime.classList.add('message__date-time');
                messageDateTime.textContent = formatDateConversation(message.date);
                const messageBlock = document.createElement('div');
                messageBlock.classList.add('message__block');
                const messageContent = document.createElement('p');
                messageContent.classList.add(idReceiver !== sessionId ? 'message__content-sender' : 'message__content');
                messageContent.textContent = message.message;

                messageBox.appendChild(messageDateTime);
                messageBox.appendChild(messageBlock);
                messageBlock.appendChild(messageContent);
                messageDiscussion.appendChild(messageBox);
            });

        })
        .catch(error => console.error('Error fetching conversation messages:', error));
}

function submitMessageViaAjax(event) {
    event.preventDefault(); // Prevent default form submission
    const form = event.target;
    const formData = new FormData(form);
    fetch(form.action, {
        method: 'POST',
        body: formData
    })
        .then(response => response.json()
            .then(data => {
                fetchAndDisplayConversationMessages(formData.get('userId'))
            }))
        .catch(error => console.error('Error adding message:', error));
}

document.getElementById('add-message-form').addEventListener('submit', submitMessageViaAjax);
