document.addEventListener('DOMContentLoaded', function() {
  const btnFiltrer = document.querySelector('#btn-filtrer');
  btnFiltrer.addEventListener('click', function() {
  // récupérer les critères de filtre
    const marque = document.querySelector('#marque').value;
    const prixmin = document.querySelector('#prixmin').value;
    const prixmax = document.querySelector('#prixmax').value;
    const date_expiration = document.querySelector('#date-expiration').value;
    const type = document.querySelector('#type').value;

  // créer la requête Ajax
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'api/filtre-achats.php');
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
      if (xhr.status === 200) {
      // mettre à jour la liste d'annonces avec les annonces filtrées
        document.querySelector('#annonces').innerHTML = xhr.responseText;
      }
    };

  // envoyer la requête Ajax avec les critères de filtre
    const data = 'marque=' + encodeURIComponent(marque) + '&prixmin=' + encodeURIComponent(prixmin) + '&prixmax=' + encodeURIComponent(prixmax) + '&date_expiration=' + encodeURIComponent(date_expiration) + '&type=' + encodeURIComponent(type);
    console.log(data);
    console.log(document.querySelector('#annonces'));
    xhr.send(data);
  });


  const btnTrier = document.querySelector('#btn-trier');
btnTrier.addEventListener('click', function() {
  // récupérer les annonces dans l'ordre croissant de prix
  const marque = document.querySelector('#marque').value;
  const prixmin = document.querySelector('#prixmin').value;
  const prixmax = document.querySelector('#prixmax').value;
  const date_expiration = document.querySelector('#date-expiration').value;
  const type = document.querySelector('#type').value;

  const xhr = new XMLHttpRequest();
  xhr.open('POST', 'api/filtre-achats.php');
  xhr.onload = function() {
    if (xhr.status === 200) {
      // mettre à jour la liste d'annonces avec les annonces triées
      document.querySelector('#annonces').innerHTML = xhr.responseText;
    }
  };
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  const data = 'marque=' + encodeURIComponent(marque) + '&prixmin=' + encodeURIComponent(prixmin) + '&prixmax=' + encodeURIComponent(prixmax) + '&date_expiration=' + encodeURIComponent(date_expiration) + '&type=' + encodeURIComponent(type) + '&croissant=croissant';
  console.log(data);
  console.log(document.querySelector('#annonces'));
  xhr.send(data);
});

const btnPag = document.querySelector('#btn-pagination');
btnPag.addEventListener('click', function() {
  // récupérer les annonces dans l'ordre croissant de prix
  const marque = document.querySelector('#marque').value;
  const prixmin = document.querySelector('#prixmin').value;
  const prixmax = document.querySelector('#prixmax').value;
  const date_expiration = document.querySelector('#date-expiration').value;
  const type = document.querySelector('#type').value;

  const xhr = new XMLHttpRequest();
  xhr.open('POST', 'api/filtre-achats.php');
  xhr.onload = function() {
    if (xhr.status === 200) {
      // mettre à jour la liste d'annonces avec les annonces triées
      document.querySelector('#annonces').innerHTML = xhr.responseText;
    }
  };
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  const data = 'marque=' + encodeURIComponent(marque) + '&prixmin=' + encodeURIComponent(prixmin) + '&prixmax=' + encodeURIComponent(prixmax) + '&date_expiration=' + encodeURIComponent(date_expiration) + '&type=' + encodeURIComponent(type) + '&pagination=pagination';
  console.log(data);
  console.log(document.querySelector('#annonces'));
  xhr.send(data);
});


});
