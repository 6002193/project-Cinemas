// --- javascript/zoekfunctie.js ---

const zoekInput = document.getElementById('zoekInput');
const zoekResultaten = document.getElementById('zoekResultaten');

zoekInput.addEventListener('keyup', async function () {
  const zoekTerm = zoekInput.value.trim();

  if (zoekTerm === '') {
    zoekResultaten.innerHTML = '';
    return;
  }

  try {
    const response = await fetch(`films.php?q=${encodeURIComponent(zoekTerm)}`);
    const data = await response.json();

    zoekResultaten.innerHTML = '';
    if (data.length === 0) {
      zoekResultaten.innerHTML = '<p>Geen resultaten gevonden.</p>';
      return;
    }

    data.forEach(film => {
      const div = document.createElement('div');
      div.classList.add('film-card');
      div.innerHTML = `<p>${film.naam}</p><small>Rating: ${film.rating}</small>`;
      zoekResultaten.appendChild(div);
    });

  } catch (err) {
    zoekResultaten.innerHTML = '<p>Fout bij ophalen van data.</p>';
  }
});
