function filmActie(actie) {
  const titel = document.querySelector('input[name="titel"]').value;
  const pegi = document.querySelector('select[name="pegi"]').value;

  if (titel.trim() === "" || (actie === "toevoegen" && pegi === "")) {
    alert("Vul een titel en PEGI-rating in.");
    return;
  }

  const data = new URLSearchParams();
  data.append("actie", actie);
  data.append("titel", titel);
  if (actie === "toevoegen") data.append("pegi", pegi);

  fetch("filmbeheer.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: data.toString()
  })
    .then((res) => res.text())
    .then((html) => {
      document.body.innerHTML = html;
    })
    .catch((err) => console.error(err));
}
