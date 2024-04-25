document.addEventListener("DOMContentLoaded", function () {
    // Make a request to fetch messagerie list
    fetch('index.php?action=getMessagerieList')
        .then(response => response.json())
        .then(data => {
            // Select the message overlay section
            const messageOverlay = document.querySelector('.message__overlay.overlay');

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

                    // Fetch conversation messages
                    fetch('index.php?action=getConversationMessages&userId=' + userId)
                        .then(response => response.json())
                        .then(data => {
                            // Select message discussion section
                            const messageDiscussion = document.querySelector('.discussion__messages.messages');

                            // Clear previous messages
                            messageDiscussion.innerHTML = '';

                            // Loop through the array data to build HTML for messages
                            data.forEach(message => {
                                var messageProfilePicture; // Declare the variable here

                                const idReceiver = parseInt(message.id_receiver);
                                const sessionId = parseInt(message.session_id);
                                const idSender = parseInt(message.id_sender);

                                const messageBox = document.createElement('div');
                                if (idSender == sessionId) {
                                    messageBox.classList.add('messages__sender', 'message__box');
                                } else {
                                    messageBox.classList.add('messages__receiver', 'message__box');
                                }
                                const messageDateTime = document.createElement('p');

                                if (idReceiver == sessionId) {
                                    // Create img element (no need to redeclare messageProfilePicture)
                                    messageProfilePicture = document.createElement('img');
                                    messageProfilePicture.classList.add('messages__photo');
                                    messageProfilePicture.src = message.image ? 'images/' + message.image : 'images/darwin-vegher.jpg';
                                    messageProfilePicture.alt = 'Photo de profil';
                                }
                                messageDateTime.classList.add('message__date-time');
                                messageDateTime.textContent = formatDateConversation(message.date);
                                const messageBlock = document.createElement('div');
                                messageBlock.classList.add('message__block');
                                const messageContent = document.createElement('p');
                                if (idReceiver !== sessionId) {
                                    messageContent.classList.add('message__content-sender');
                                } else {
                                    messageContent.classList.add('message__content');
                                }
                                messageContent.textContent = message.message;

                                if (messageProfilePicture) {
                                    messageBox.appendChild(messageProfilePicture);
                                }
                                messageBox.appendChild(messageDateTime);
                                messageBox.appendChild(messageBlock);
                                messageBlock.appendChild(messageContent);
                                messageDiscussion.appendChild(messageBox);
                            });

                        })
                        .catch(error => console.error('Error fetching conversation messages:', error));
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
