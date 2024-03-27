document.addEventListener('DOMContentLoaded', function () {
    const inputField = document.querySelector('.showBooks__input');
    const cardsContainer = document.querySelector('.showBooks__cards');



    // Function to rebuild cards with provided books data
    function rebuildCards(books) {
        // Remove all existing cardbook__card elements
        while (cardsContainer.firstChild) {
            cardsContainer.removeChild(cardsContainer.firstChild);
        }

        // Rebuild cardbook__card elements with the provided books data
        books.forEach(book => {
            const card = document.createElement('div');
            card.classList.add('cardbook__card');

            card.innerHTML = `
                <a href="index.php?action=book&amp;id=${book.id}" class="cardbook__link">
                    <img src="images/${book.image}" class="cardbook__image" alt="image du livre ${book.title}">
                    <div class="cardbook__information">
                        <h3 class="cardbook__title">${book.title}</h3>
                        <p class="cardbook__author">${book.author}</p>
                        <p class="cardbook__seller">vendu par : ${book.seller}</p>
                    </div>
                </a>
            `;

            cardsContainer.appendChild(card);
        });
    }


    inputField.addEventListener('input', function () {
        const searchText = inputField.value.trim().toLowerCase();
        if (searchText.length >= 2) {
            fetch(`index.php?action=showBooks&id=${searchText}`)
                .then(response => response.json())
                .then(data => {
                    rebuildCards(data); // Rebuild cards with the returned data
                })
                .catch(error => console.error('Error fetching data:', error));
        } else {
            fetch('index.php?action=showBooks&id=')
                .then(response => response.json())
                .then(data => {
                    rebuildCards(data); // Build the cards initially
                })
                .catch(error => console.error('Error fetching initial data:', error));
        }
    });
});
