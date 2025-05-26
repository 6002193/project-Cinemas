
    const zoekInput = document.getElementById('zoekInput');
    const filmCards = document.querySelectorAll('.film-card');

    zoekInput.addEventListener('keyup', function () {
      const zoekTerm = zoekInput.value.toLowerCase();
      filmCards.forEach(card => {
        const titel = card.querySelector('p').textContent.toLowerCase();
        card.style.display = titel.includes(zoekTerm) ? '' : 'none';
      });
    });
