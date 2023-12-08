const form = document.getElementById('avatar-form');
const avatar = document.getElementById('avatar');

const corps = document.querySelector('.corps');
const chapeau = document.createElement('img');
const element1 = document.createElement('img');
const element2 = document.createElement('img');

form.addEventListener('submit', (event) => {
  event.preventDefault();

  const corpsSrc = document.getElementById('corps').value;
  const chapeauSrc = document.getElementById('chapeau').value;
  const element1Src = document.getElementById('element1').value;
  const element2Src = document.getElementById('element2').value;

  chapeau.src = chapeauSrc;
  chapeau.alt = 'Chapeau';
  chapeau.className = 'chapeau';

  element1.src = element1Src;
  element1.alt = 'Element 1';
  element1.className = 'element1';

  element2.src = element2Src;
  element2.alt = 'Element 2';
  element2.className = 'element2';

  avatar.innerHTML = '';
  avatar.appendChild(corps);

  if (chapeauSrc !== '0') {
    avatar.appendChild(chapeau);
    chapeau.style.zIndex = '1';
  }

  if (element1Src !== '0') {
    avatar.appendChild(element1);
    element1.style.zIndex = '2';
  }

  if (element2Src !== '0') {
    avatar.appendChild(element2);
    element2.style.zIndex = '3';
  }
});


const saveBtn = document.getElementById('save-btn');

saveBtn.addEventListener('click',async function() {
  try {
    // Obtenir la taille de l'image de base
    largeur = 605;
    hauteur = 607;
    const baseImageWidth = largeur;
    const baseImageHeight = hauteur;

    // Créer un canvas de la même taille que l'image de base et dessiner l'image finale superposée
    const canvas = document.createElement('canvas');
    const scale = 2; // Ajout de l'échelle
    canvas.width = baseImageWidth * scale;
    canvas.height = baseImageHeight * scale;
    const context = canvas.getContext('2d');
    context.scale(scale, scale); // Appliquer l'échelle

    const corpsSrc = document.getElementById('corps').value;
    const chapeauSrc = document.getElementById('chapeau').value;
    const element1Src = document.getElementById('element1').value;
    const element2Src = document.getElementById('element2').value;

    context.drawImage(corps, 0, 0);

    if (chapeauSrc != '0') {
      chapeau.src = chapeauSrc;
      context.drawImage(chapeau, 0, 0);
    }

    if (element1Src != '0') {
      element1.src = element1Src;
      context.drawImage(element1, 0, 0);
    }

    if (element2Src != '0') {
      element2.src = element2Src;
      context.drawImage(element2, 0, 0);
    }

    const dataURL = canvas.toDataURL('image/png');

    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'avatar_save.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.send('image=' + encodeURIComponent(dataURL)); 

    // const dataURL = canvas.toDataURL('image/png');

    // const img = new Image();
    // img.src = dataURL;
    // document.body.appendChild(img); // ou remplacez document.body par le sélecteur de l'élément que vous voulez utiliser

    // const blob = await new Promise(resolve => canvas.toBlob(resolve));

  } catch (err) {
    console.error(err);
  }
});


const corpsDropdown = document.getElementById('corps');
const corpsImg = document.querySelector('.corps');

corpsDropdown.addEventListener('change', (event) => {
  const selectedCorps = event.target.value;
  corpsImg.src = selectedCorps;
});

const successMessage = document.getElementById('success-message');

  saveBtn.addEventListener('click', async function() {
    try {
      // Ton code actuel pour créer et enregistrer l'avatar

      // Affichage du message de succès
      successMessage.style.display = 'block';

    } catch (err) {
      console.error(err);
    }
  });


