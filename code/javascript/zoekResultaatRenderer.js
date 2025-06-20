export function renderResultaten(resultaten, zoekResultaten, zoekInput) {
  zoekResultaten.innerHTML = '';
  if (resultaten.length === 0) {
    zoekResultaten.innerHTML = '<p>Geen resultaten gevonden.</p>';
    return;
  }
  resultaten.forEach(film => {
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
    link.addEventListener('click', () => {
      zoekResultaten.innerHTML = '';
      zoekInput.value = '';
    });
    zoekResultaten.appendChild(link);
  });
}