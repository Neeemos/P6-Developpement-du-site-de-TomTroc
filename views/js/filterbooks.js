    document.addEventListener('DOMContentLoaded', function () {
        const inputField = document.querySelector('.showBooks__input');
        const cards = document.querySelectorAll('.cardbook__card');

        inputField.addEventListener('input', function () {
            const searchText = inputField.value.trim().toLowerCase();

            if (searchText.length >= 2) {
                cards.forEach(function (card) {
                    const title = card.querySelector('.cardbook__title').textContent.toLowerCase();
                    const author = card.querySelector('.cardbook__author').textContent.toLowerCase();

                    if (title.includes(searchText) || author.includes(searchText)) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                });
            } else {
                cards.forEach(function (card) {
                    card.style.display = 'block';
                });
            }
        });
    });
