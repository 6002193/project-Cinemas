  const form = document.querySelector("form");
  const fields = ["film", "naam", "email", "telefoon", "locatie", "datum", "tijd", "aantal"];

  // ✅ Bij laden: vul formuliervelden met opgeslagen waarden
  window.addEventListener("DOMContentLoaded", () => {
    fields.forEach(field => {
      const value = localStorage.getItem("reservering_" + field);
      if (value && form.elements[field]) {
        form.elements[field].value = value;
      }
    });
  });

  // ✅ Tijdens typen: sla waarden live op
  fields.forEach(field => {
    const input = form.elements[field];
    if (input) {
      input.addEventListener("input", () => {
        localStorage.setItem("reservering_" + field, input.value);
      });
    }
  });

  // 🧹 Bij succesvol verzenden: wis opgeslagen data
  form.addEventListener("submit", () => {
    fields.forEach(field => localStorage.removeItem("reservering_" + field));
  });