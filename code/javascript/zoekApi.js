export async function zoekFilms(zoekTerm) {
  const response = await fetch(`films.php?q=${encodeURIComponent(zoekTerm)}`);
  if (!response.ok) throw new Error('Fout bij ophalen van data.');
  return await response.json();
}