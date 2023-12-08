<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
  session_start();
}
// connexion à la base de données
try
{
  $bdd = new PDO('mysql:host=54.38.34.89:3306;dbname=econami', 'eco_A7D3N!', 'Yj328xNfa6zPT5', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
catch (Exception $e)
{
  die('Erreur PDO : ' . $e->getMessage());
}

if (!isset($_SESSION['ParPage'])) {
  $_SESSION['ParPage'] = 24;
}

$ParPage = $_SESSION['ParPage'];

// récupérer les critères de filtre envoyés par la requête
$marque = htmlspecialchars($_POST['marque'] ?? '');
$prixmin = htmlspecialchars($_POST['prixmin'] ?? '');
$prixmax = htmlspecialchars($_POST['prixmax'] ?? '');
$date_expiration = htmlspecialchars($_POST['date_expiration'] ?? '');
$type = htmlspecialchars($_POST['type'] ?? '');
if(isset($_POST['croissant'])){
  $prixCroissant = $_POST['croissant'];
}
if (isset($_POST['pagination'])) {
  $_SESSION['ParPage'] += 24;
  $ParPage = $_SESSION['ParPage'];
}

// construire la requête SQL pour récupérer les annonces filtrées
$q = "SELECT a.*, u.pseudo, u.points, u.image FROM annonce a INNER JOIN users u on u.id = a.id_users WHERE 1 = 1";
if (!empty($marque)) {
  $q .= " AND a.marque LIKE '%$marque%'";
}
if (!empty($prixmin)) {
  $q .= " AND a.prix >= $prixmin";
}
if (!empty($prixmax)) {
  $q .= " AND a.prix <= $prixmax";
}
if (!empty($date_expiration)) {
  $q .= " AND a.date_expiration >= '$date_expiration'";
}
if (!empty($type)) {
  $q .= " AND a.type = '$type'";
}
if (!empty($prixCroissant)) {
  $q .= " AND a.valide = true ORDER BY a.prix ASC";
}else{
  $q .= " AND a.valide = true ORDER BY u.points DESC, a.date_expiration DESC";
}
$toto = $bdd->query($q);
$tot = $toto->rowCount();

$q .= " LIMIT 0,$ParPage";

// exécuter la requête et récupérer les annonces filtrées
$ann = $bdd->query($q);
$annonces = $ann->fetchAll(PDO::FETCH_ASSOC);

if(empty($annonces) && $marque != 'Shabbat'){
?>
  <div style="font-weight: bold; font-size: 1.25rem; margin-bottom: 20px;">Aucun résultats</div>
<?php
}

if($marque == 'Shabbat'){
  include('../esterEggs/ester.php');
}

if (!isset($_SESSION['cont'])) {
  $_SESSION['cont'] = 0;
}

// construire le HTML pour la liste d'annonces filtrées
foreach ($annonces as $ra) {
  $_SESSION['cont'] += 1;

  if($_SESSION['cont'] == $tot){
    $_SESSION['cont'] = 0;
  }

  $chemin_avatar = null;
  if(isset($ra['image'])){
    $chemin_avatar = 'avatar/' .  $ra['image'];
  }else{
    $chemin_avatar = 'avatar/defaut/icon_profil.svg';
  }
?>
<div class="body__annonce">
  <a class="body__link__achat" href="achats_annonce.php?id=<?= $ra['id'] ?>" id="body_annonce">
    <div class="body__achat">
      <p class="text-center body__montant">
        <?= $ra['reduction'] . ' ' . $ra['type'] ?>
        <br>
        <?= $ra['marque'] ?>
      </p>
      <div class="body__pseudo" style="<?php if($ra['points'] >= 250){ ?>
        color: #DCD488;
        <?php
        }
        ?>
        ">
        <img src="<?= $chemin_avatar ?>" style="margin-right: 5px;" class="profil__avatar" width="16" height="16">
        <?= $ra['pseudo'] ?>
      </div>
      <div class="body__date">
        <i style="margin-right: 5px;" class="bi bi-calendar"></i><?= date_format(date_create($ra['date_expiration']), 'd/m/Y') ?>
      </div>
      <div class="body__prix text-center">
        <?= $ra['prix'] . ' €' ?>
      </div>
    </div>
  </a>
</div>
<?php   
}
?>
