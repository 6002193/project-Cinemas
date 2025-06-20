// --- javascript/zoekfunctie.js ---
import { zoekFilms } from './zoekApi.js';
import { renderResultaten } from './zoekResultaatRenderer.js';

const zoekInput = document.getElementById('zoekInput');
const zoekResultaten = document.getElementById('zoekResultaten');

zoekInput.addEventListener('keyup', async function () {
  const zoekTerm = zoekInput.value.trim();

  if (zoekTerm === '') {
    zoekResultaten.innerHTML = '';
    return;
  }

  try {
    const data = await zoekFilms(zoekTerm);
    renderResultaten(data, zoekResultaten, zoekInput);
  } catch (err) {
    zoekResultaten.innerHTML = '<p>Fout bij ophalen van data.</p>';
  }
});

// Optioneel: Verberg resultaten als je op een resultaat klikt
zoekResultaten.addEventListener('click', () => {
  zoekResultaten.innerHTML = '';
  zoekInput.value = '';
});

