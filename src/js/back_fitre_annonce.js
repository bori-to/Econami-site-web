document.addEventListener('DOMContentLoaded', function() {
  const btnTrierOff = document.querySelector('#btn-trier-offValide');
  const btnTrierOn = document.querySelector('#btn-trier-valide');
  const btnTrierVendu = document.querySelector('#btn-trier-vendus');
  const btnTrierRien = document.querySelector('#btn-trier-rien');

  btnTrierOff.addEventListener('click', function() {

    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'api/filtre-annonce.php');
    xhr.onload = function() {
      if (xhr.status === 200) {
        // mettre à jour la liste d'annonces avec les annonces triées
        document.querySelector('#annonces').innerHTML = xhr.responseText;
      }
    };
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    const data = '&offValide=offValide';
    console.log(data);
    console.log(document.querySelector('#annonces'));
    xhr.send(data);
  });


  btnTrierOn.addEventListener('click', function() {

    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'api/filtre-annonce.php');
    xhr.onload = function() {
      if (xhr.status === 200) {
        // mettre à jour la liste d'annonces avec les annonces triées
        document.querySelector('#annonces').innerHTML = xhr.responseText;
      }
    };
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    const data = '&onValide=onValide';
    console.log(data);
    console.log(document.querySelector('#annonces'));
    xhr.send(data);
  });


  btnTrierVendu.addEventListener('click', function() {

    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'api/filtre-annonce.php');
    xhr.onload = function() {
      if (xhr.status === 200) {
        // mettre à jour la liste d'annonces avec les annonces triées
        document.querySelector('#annonces').innerHTML = xhr.responseText;
      }
    };
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    const data = '&Vendu=Vendu';
    console.log(data);
    console.log(document.querySelector('#annonces'));
    xhr.send(data);
  });

  btnTrierRien.addEventListener('click', function() {

    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'api/filtre-annonce.php');
    xhr.onload = function() {
      if (xhr.status === 200) {
        // mettre à jour la liste d'annonces avec les annonces triées
        document.querySelector('#annonces').innerHTML = xhr.responseText;
      }
    };
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    const data = '&Rien=Rien';
    console.log(data);
    console.log(document.querySelector('#annonces'));
    xhr.send(data);
  });

  const btnPag = document.querySelector('#btn-pagination');
btnPag.addEventListener('click', function() {

  const xhr = new XMLHttpRequest();
  xhr.open('POST', 'api/filtre-annonce.php');
  xhr.onload = function() {
    if (xhr.status === 200) {
      // mettre à jour la liste d'annonces avec les annonces triées
      document.querySelector('#annonces').innerHTML = xhr.responseText;
    }
  };
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  const data = '&pagination=pagination';
  console.log(data);
  console.log(document.querySelector('#annonces'));
  xhr.send(data);
});
});
