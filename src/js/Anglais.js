function translateToEnglish() {
  // Balise <a>
  const vendre = document.querySelector('#titreC');
  vendre.innerHTML = 'Sell';
  
  const deposeAnnonce = document.querySelector('a[href="vente.php"]');
  deposeAnnonce.innerHTML = 'Place an ad';
  
  const infoVendre = document.querySelector('a[href="infoVendre.php"]');
  infoVendre.innerHTML = 'Info';
  
  const achat = document.querySelector('#tkt');
  achat.innerHTML = 'Purchase';
  
  const recherche = document.querySelector('a[href="achats.php"]');
  recherche.innerHTML = 'Search';
  
  const top = document.querySelector('a[href="achatsTop.php"]');
  top.innerHTML = 'TOP';
  
  const ventePrivee = document.querySelector('a[href="ventePrivee.php"]');
  ventePrivee.innerHTML = 'Private sale';
  
  const forum = document.querySelector('#tkt2');
  forum.innerHTML = 'Forum';
  
  const forumAccueil = document.querySelector('a[href="forum_accueil.php"]');
  forumAccueil.innerHTML = 'Home';
  
  const categories = document.querySelector('a[href="forum.php"]');
  categories.innerHTML = 'Categories';
  
  const questions = document.querySelector('a[href="questions.php"]');
  questions.innerHTML = 'Questions';
  
  const vip = document.querySelector('a.nav-link.dropdown-toggle:last-of-type');
  vip.innerHTML = 'VIP';
  
  const points = document.querySelector('a[href="point.php"]');
  points.innerHTML = 'Points';
  
  const avantageVip = document.querySelector('a[href="AvantageVip.php"]');
  avantageVip.innerHTML = 'Advantages';
  
  const classement = document.querySelector('a[href="classement"]');
  classement.innerHTML = 'Ranking';

  // Balise <div>
  const solde = document.querySelector('.dropdown-item:contains("Solde :")');
  solde.innerHTML = `Balance: ${$avatar['solde']} €`;
  
  // Balise <li>
  const panier = document.querySelector('a[href="panier.php"]');
  panier.innerHTML = 'Cart';
  
  const profil = document.querySelector('a[href="profil.php"]');
  profil.innerHTML = 'Profile';
  
  const parametre = document.querySelector('a.dropdown-item:contains("Paramètre")');
  parametre.innerHTML = 'Settings';
  
  const admin = document.querySelector('a[href="back_admin.php"]');
  admin.innerHTML = 'Admin';
  
  const deconnexion = document.querySelectorAll('a[href="deconnexion.php"]');
  deconnexion.forEach(link => link.innerHTML = 'Log out');
}
