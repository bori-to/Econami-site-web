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

if (!isset($_SESSION['back_ParPage'])) {
  $_SESSION['back_ParPage'] = 24;
}

$ParPage = $_SESSION['back_ParPage'];

if(isset($_POST['offValide'])){
  $offValide = $_POST['offValide'];
}

if(isset($_POST['onValide'])){
  $onValide = $_POST['onValide'];
}

if(isset($_POST['Vendu'])){
  $Vendu = $_POST['Vendu'];
}

if(isset($_POST['Rien'])){
  $Rien = $_POST['Rien'];
}

if (isset($_POST['pagination'])) {
  $_SESSION['back_ParPage'] += 24;
  $ParPage = $_SESSION['back_ParPage'];
}

// construire la requête SQL pour récupérer les annonces filtrées
$q = "SELECT a.*, u.pseudo, u.points, u.image FROM annonce a INNER JOIN users u on u.id = a.id_users";
if (!empty($offValide)) {
  $q .= " WHERE a.valide = false ORDER BY a.date_creation DESC";
}
if (!empty($onValide)) {
  $q .= " WHERE a.valide = true ORDER BY a.date_creation DESC";
}
if (!empty($Vendu)) {
  $q .= " WHERE a.valide = '2' ORDER BY a.date_creation DESC";
}
if (!empty($Rien)) {
  $q .= " ORDER BY a.date_creation DESC";
}
if(!empty($offValide) && !empty($onValide) && !empty($Vendu)){
  $q .= " ORDER BY a.date_creation DESC";
}
$toto = $bdd->query($q);
$tot = $toto->rowCount();

$q .= " LIMIT 0,$ParPage";

// exécuter la requête et récupérer les annonces filtrées
$ann = $bdd->query($q);
$annonces = $ann->fetchAll(PDO::FETCH_ASSOC);

if(empty($annonces)){
?>
  <div style="font-weight: bold; font-size: 1.25rem; margin-bottom: 20px;">Aucun résultats</div>
<?php
}

// construire le HTML pour la liste d'annonces filtrées
if (!isset($_SESSION['back_cont'])) {
  $_SESSION['back_cont'] = 0;
}

foreach($annonces as $ra){
  $_SESSION['back_cont'] += 1;

  if($_SESSION['back_cont'] == $tot){
    $_SESSION['back_cont'] = 0;
  }

  $chemin_avatar = null;
  if(isset($ra['image'])){
    $chemin_avatar = 'avatar/' .  $ra['image'];
  }else{
    $chemin_avatar = 'avatar/defaut/icon_profil.svg';
  } 
  ?>
  <div class="body__annonce">
  <a class="body__link__achat" href="achats_annonce.php?id=<?= $ra['id'] ?>">   
    <div class="body__achat">
      <p class="text-center body__montant">
        <?= $ra['reduction'] . ' ' . $ra['type'] . ' ' ?>
        <?php if($ra['valide'] == '1'){
          ?>
          <i class="bi bi-bag-check annonce__para__btn btn__valide"></i>
          <?php
        }elseif($ra['valide'] == '2'){
          ?>
          <i class="bi bi-cart-check annonce__para__btn btn__vendus"></i>
          <?php
        }else{
          ?>
          <i class="bi bi-bag-x annonce__para__btn btn__novalide"></i>
          <?php
        }
        ?>
        <?php if($ra['top'] == '1'){
          ?>
          <i class="bi bi-award" style="color: #FFD700;"></i>
          <?php
        }elseif($ra['top'] == '2'){
          ?>
          <i class="bi bi-award" style="color:#C0C0C0 ;"></i>
          <?php
        }elseif($ra['top'] == '3'){
          ?>
          <i class="bi bi-award" style="color:#CD7F32 ;"></i>
          <?php
        }
        ?>
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
        <i style="margin-right: 5px;" class="bi bi-calendar"></i><?= date_format(date_create($ra['date_creation']), 'd/m/Y') ?>
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
