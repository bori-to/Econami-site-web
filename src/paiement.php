<?php session_start();

if(!isset($_SESSION['email'])){
	header('location:connexion.php');
	exit;
}

if(!isset($_COOKIE['panier'])){
	header('location:panier.php');
	exit;
}

include('paiement/config.php');
// require_once 'paiement/config.php';

$title = 'Paiement';
include('include/head.php');

if(isset($_SESSION['id'])){
	include('include/log.php');
	writeLog($title);
}
?>
	<link rel="stylesheet" type="text/css" href="css/styleforum.css">
	<link rel="stylesheet" type="text/css" href="css/style_achats.css">
	<script src="https://js.stripe.com/v3/"></script>
	</head>
	<?php
		if(isset($_COOKIE['theme'])){
			if($_COOKIE["theme"] == "dark") {
				$background_white = "#454D67";
				$background_marron = "#92A7B0";
				$background_marronClaire = "#3B5D6B";
				$background_Jaune= "#92A7B0";
				$background_btn = "#585A56";
				$border_btn = "#585A56";
			} else {
				$background_white = "white";
				$background_marron = "rgb(185, 168, 124)";
				$background_marronClaire = "rgba(185, 168, 124, 0.5)";
				$background_Jaune= "#DCD488";
				$background_btn = "#B9A87C";
				$border_btn = "#B9A87C";
			}
		}else{
			$background_white = "white";
			$background_marron = "rgb(185, 168, 124)";
			$background_marronClaire = "rgba(185, 168, 124, 0.5)";
			$background_Jaune= "#DCD488";
			$background_btn = "#B9A87C";
			$border_btn = "#B9A87C";
		}
	?>
	<body style="background-color: <?= $background_white?>;">
		<?php include 'include/header.php' ?>
		<main>

			<div class="container-fluid" style="background-color: <?= $background_marronClaire?>;">
				<div class="container">
					<div class="row forum__accueil__line">
						<div class="col-md-8 col-xs-12">
							<h1 class="forum__accueil__h1">
								Econami paiement
							</h1>
						</div>
					</div>
					
					<div class="item__paiement">
						<!-- Display errors returned by checkout session -->
						<div id="paymentResponse" class="hidden"></div>
							<?php

							if (isset($_COOKIE['panier']) && !empty($_COOKIE['panier'])) {  
							    $panier = unserialize($_COOKIE['panier']);
							    foreach($panier as $contenue){
							    	?>
							       <h2> <?=  $contenue['marque'] .' '. $contenue['reduction'] .' '. $contenue['type'] ?> </h2>
							       <?php
							    }
							?>
						
								<p> ID de commande : <b> <?= $productID ?> </b> </p> 
								<p> Prix : <b> <?= $productPrice .' '. strtoupper($currency); ?> </b> </p>
								<p> Nombre d'articles : <b> <?= $quantity ?> </b> </p>

								<!-- Payment button -->
								<button class="stripe-button forum__btn__create" id="payButton" style="background-color: <?= $background_Jaune?>;">
								    <div class="spinner hidden" id="spinner"></div>
								    <span id="buttonText">Payez maintenant</span>
								</button>
							<?php
							}
							?>
					</div>
					<div><br></div>
				</div>
			</div>

		</main>

		<?php include 'include/footer.php' ?>
	</body>
	<script>
		// Définir la clé publiable Stripe pour initialiser Stripe.js 
		const stripe = Stripe('<?php echo STRIPE_PUBLISHABLE_KEY; ?>');

		// Sélectionnez le bouton de paiement
		const payBtn = document.querySelector("#payButton");

		// Gestionnaire de demande de paiement 
		payBtn.addEventListener("click", function (evt) {
		    setLoading(true);

		    createCheckoutSession().then(function (data) {
		        if(data.sessionId){
		            stripe.redirectToCheckout({
		                sessionId: data.sessionId,
		            }).then(handleResult);
		        }else{
		            handleResult(data);
		        }
		    });
		});
		    
		// Créer une session de paiement avec le produit sélectionné
		const createCheckoutSession = function (stripe) {
		    return fetch("paiement/paiement_init.php", {
		        method: "POST",
		        headers: {
		            "Content-Type": "application/json",
		        },
		        body: JSON.stringify({
		            createCheckoutSession: 1,
		        }),
		    }).then(function (result) {
		        return result.json();
		    });
		};

		// Traiter toutes les erreurs renvoyées par Checkout
		const handleResult = function (result) {
		    if (result.error) {
		        showMessage(result.error.message);
		    }
		    
		    setLoading(false);
		};

		// Afficher un spinner sur le traitement des paiements
		function setLoading(isLoading) {
		    if (isLoading) {
		        // Désactive le bouton et affiche un spinner 
		        payBtn.disabled = true;
		        document.querySelector("#spinner").classList.remove("hidden");
		        document.querySelector("#buttonText").classList.add("hidden");
		    } else {
		        // Activer le bouton et masquer le spinner 
		        payBtn.disabled = false;
		        document.querySelector("#spinner").classList.add("hidden");
		        document.querySelector("#buttonText").classList.remove("hidden");
		    }
		}

		// Afficher
		function showMessage(messageText) {
		    const messageContainer = document.querySelector("#paymentResponse");
			
		    messageContainer.classList.remove("hidden");
		    messageContainer.textContent = messageText;
			
		    setTimeout(function () {
		        messageContainer.classList.add("hidden");
		        messageText.textContent = "";
		    }, 5000);
		}
	</script>
	<script src="js/bootstrap.min.js"></script>
</html>