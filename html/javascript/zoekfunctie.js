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
      const link = document.createElement('a');
      link.href = `reserveren.php?film=${encodeURIComponent(film.naam)}`;
      link.classList.add('film-card');

      link.innerHTML = `
        <article class="film-info">
          <p>${film.naam}</p>
          <p>PG ${film.rating}</p>
          <p>Roomnumber: ${film.room}</p>
          <p>Seats left over: ${film.seats}</p>
        </article>
        ${film.foto_url ? `<img src="${film.foto_url}" alt="Filmfoto">` : ''}
      `;

      zoekResultaten.appendChild(link);
    });

  } catch (err) {
    zoekResultaten.innerHTML = '<p>Fout bij ophalen van data.</p>';
  }
});

// Optioneel: Verberg resultaten als je op een resultaat klikt
zoekResultaten.addEventListener('click', () => {
  zoekResultaten.innerHTML = '';
  zoekInput.value = '';
});
