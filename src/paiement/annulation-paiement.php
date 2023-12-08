<?php
$title = 'commande annulée';
include('../include/head.php');

if(isset($_SESSION['id'])){
    include('include/log.php');
    writeLog($title);
}
?>
<link rel="stylesheet" type="text/css" href="../css/styleforum.css">
<link rel="stylesheet" type="text/css" href="../css/style_achats.css">
<link rel="stylesheet" type="text/css" href="../css/paiement.css">
<link rel="icon" type="image/png" href="../images/econami_onglet.png" />
<script src="https://js.stripe.com/v3/"></script>
</head>
<body>
    <main>

        <div class="container-fluid">
            <div class="container container_paiement">
                <div class="row forum__accueil__line">
                    <div class="col-md-8 col-xs-12 status">
                        <h1 class="forum__accueil__h1 error">
                            Votre transaction a été annulée !
                        </h1>
                    </div>
                </div>
                <button class="btn__link">
                    <a href="../panier.php">Retour à la page produit</a>
                </button>
            </div>
        </div>

    </main>

</body>
<script src="../js/bootstrap.min.js"></script>
</html>