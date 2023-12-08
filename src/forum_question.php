<?php session_start();

if(!empty($_POST)){
	extract($_POST);

	if(isset($_POST['msg_cont'])){
		$valid = true;

		if(empty($_POST['message_contact']) 
		|| !isset($_POST['message_contact']) 
		){
			$valid = false;
			$msg = 'Le message est vide';
			header('location:forum_question.php?type=danger&message=' . $msg);
			exit;
		}

		if(strlen($_POST['message_contact']) < 10){
			$valid = false;
			$msg = 'Message trop petit';
			header('location:forum_question.php?type=danger&message=' . $msg);
			exit;
		}

		if(isset($_SESSION['email'])){
			$mail_contact = $_SESSION['email'];
		}else{
			if(empty($_POST['message_email']) 
			|| !isset($_POST['message_email']) 
			){
				$valid = false;
				$msg = 'email vide';
				header('location:forum_question.php?type=danger&message=' . $msg);
				exit;
			}

			if(!filter_var($_POST['message_email'], FILTER_VALIDATE_EMAIL)){
				$valid = false;
				$msg = 'Adresse email non valide.';
				header('location:forum_question.php?type=danger&message=' . $msg);
				exit;
			}

			if($valid){
				$mail_contact = $_POST['message_email'];
			}
		}

		if($valid){
			
			$message_mail_contact = htmlspecialchars($_POST['message_contact']);
			$destination = 'esgieconami@gmail.com';
			$message = 'Message de '. $_SESSION['email'] . ' - ' . htmlspecialchars($_POST['message_contact']);
			$message = "
		      <!DOCTYPE html>
		      <html>
		      <head>
		        <title>Email econami</title>
		        <meta charset='utf-8'>
		        <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ' crossorigin='anonymous'>
		        <style type='text/css'>
		          .m_a{
		            font-size:50pt;
		            color: black;
		          }
		          .m_a img{
		            width: 200px;
		          }
		          .para{
		            font-size: 16px;
		          }

		          mark{
		            background-color: #DCD488;
		          }

		          button{
		            border: none;
		            background-color: rgba(185, 168, 124,0);
		          }

		          .forum__body__btn {
		              margin: 20px 0;
		          }
		          .forum__btn__create {
		              background: #DCD488;
		              color: black;
		              align-items: center;
		              cursor: pointer;
		              border: 0;
		              padding: 0.375rem;
		              border-radius: 6px;
		              font-size: .8rem;
		              text-decoration: none;
		              box-shadow: 1px 1px 5px rgba(0, 0, 0, .2);
		              transition: all .5s ease;
		              justify-content: center;
		          }
		          .forum__btn__create:hover {
		              box-shadow: none;
		          }
		        </style>
		      </head>
		      <body style='background-color: #f6f9fc;'>
		        <div class='container'>
		          <div class='row'>
		            <div class='col-3'></div>
		            <div class='col-6' style='background-color: rgba(185, 168, 124, 0.5); border-radius: 10px; padding: 20px 20px;'>
		              <div class='m_a'>
		                <img src='https://econami.ddns.net/images/econami2.png'>
		              </div>
		              <div>
		                <p class='para'>Message de $mail_contact : <br><br>$message_mail_contact</p>
		                <button class='forum__body__btn'>
		                  <a href='https://econami.ddns.net/' class='forum__btn__create' style='background-color: #DCD488; font-size: 25px; color: black;'>
		                    Econami
		                  </a>
		                </button>
		                <p class='para'>Vous avez des questions ? Consultez le forum de <mark>Econami</mark> ou contactez-nous.</p>
		                <p class='para'>Merci,<br><mark>Econami</mark></p>
		                <p class='para'>© 2023 <mark>Econami</mark>, Inc</p>
		              </div>
		            </div>
		            <div class='col-3'></div>
		          </div>
		        </div>
		      </body>
		      </html>
		      ";
			include('include/email.php');
			$msg = 'Message envoyé avec succès';
			header('location:forum_question.php?type=success&message=' . $msg);
			exit;
		}
	}

}

$title = 'Forum';
include('include/head.php');

if(isset($_SESSION['id'])){
	include('include/log.php');
	writeLog($title);
}
?>
	<link rel="stylesheet" type="text/css" href="css/styleforum.css">
	<link rel="stylesheet" type="text/css" href="css/pagination.css">
	</head>
	<?php
		if(isset($_COOKIE['theme'])){
			if($_COOKIE["theme"] == "dark") {
				$background_white = "#454D67";
				$background_marron = "#92A7B0";
				$background_marronClaire = "#3B5D6B";
				$background_Jaune= "#92A7B0";
				$background_PAG= "#92A7B0";
				$background_btn = "#585A56";
				$border_btn = "#585A56";
			} else {
				$background_white = "white";
				$background_marron = "rgba(185, 168, 124)";
				$background_marronClaire = "rgba(185, 168, 124, 0.5)";
				$background_Jaune= "#DCD488";
				$background_btn = "#B9A87C";
				$border_btn = "#B9A87C";
			}
		}else{
			$background_white = "white";
			$background_marron = "rgba(185, 168, 124)";
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
						<div class="col-6">
							<h1 class="forum__accueil__h1">
								Questions
							</h1>
						</div>
						<div class="col-6">
							<h1 class="forum__accueil__h1">
								<i class="bi bi-chat-right-quote"></i>
							</h1>
						</div>
						<div class="col-6"></div>
						<div class="col-6">
							<?php 

              				include('include/message.php');

              				?>
						</div>
					</div>

					<div class="row">
						<div class="col-md-6 col-xs-12">
							<div class="forum__body">
								<h2 class="forum__h1">Tout savoir sur Econami</h2>

								<div class="accordion mt-4 mb-3" id="accordionExample">
								  <div class="accordion-item">
								    <h2 class="accordion-header">
								      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">
								        Quelle est la définition du terme coupon de réduction ?
								      </font></font></button>
								    </h2>
								    <div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionExample" style="">
								      <div class="accordion-body">
								        Un coupon de réduction est un bon de réduction, une offre promotionnelle ou un code de réduction offert par une entreprise ou un détaillant, qui permet à un consommateur d'obtenir une réduction de prix sur un produit ou un service. <br><br>Les coupons de réduction peuvent être distribués sous différentes formes, comme des coupons imprimables, des coupons en ligne, des codes promotionnels, des cartes de fidélité, des offres de remboursement, etc. <br><br>Les consommateurs peuvent utiliser ces coupons lors de leurs achats pour économiser de l'argent sur leurs achats. Les coupons de réduction peuvent être une stratégie marketing efficace pour attirer de nouveaux clients et fidéliser les clients existants.
								      </div>
								    </div>
								  </div>
								  <div class="accordion-item">
								    <h2 class="accordion-header">
								      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">
								        Quoi acheter sur Econami ?
								      </font></font></button>
								    </h2>
								    <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
								      <div class="accordion-body">
								        Vous pouvez accéder à une variété de coupons de réduction pour les marques que vous aimez, qui ont été partagés par des utilisateurs de toute la France. <br><br>Cela peut être utile si vous cherchez à économiser de l'argent sur vos achats en ligne ou en magasin. En utilisant ces coupons, vous pouvez obtenir des réductions sur une gamme de produits et services, ce qui peut vous permettre d'économiser de l'argent sur vos achats réguliers.
								      </div>
								    </div>
								  </div>
								  <div class="accordion-item">
								    <h2 class="accordion-header">
								      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">
								        Les ventes privées c'est quoi ?
								      </font></font></button>
								    </h2>
								    <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
								      <div class="accordion-body">
								        Des coupons vente privée sont déposés sur le site par les administrateurs pour récompenser les clients fidèles du site, les VIP. <br><br>Seuls les utilisateurs VIP peuvent avoir accès aux ventes privées, les coupons de ventes privées sont très intéressants et à moindre prix.
								      </div>
								    </div>
								  </div>
								  <div class="accordion-item">
								    <h2 class="accordion-header">
								      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">
								        Un Forum ?
								      </font></font></button>
								    </h2>
								    <div id="collapseFour" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
								      <div class="accordion-body">
								        Notre forum permet aux utilisateurs de partager des informations et des bons plans autour de l'achat et de la vente de coupons de réduction. Le forum est un espace de discussion en ligne où les membres peuvent publier des messages, poser des questions, partager des expériences, des avis, des astuces et des conseils, et interagir les uns avec les autres.<br><br>

										Sur notre site d'achat et de vente de coupons de réduction, le forum peut permettre aux membres de discuter de sujets liés aux coupons, tels que les meilleures offres, les marques populaires, les dernières tendances, les astuces pour économiser de l'argent, et plus encore.<br><br>

										Le forum peut également servir de lieu d'échange pour les membres qui cherchent des informations sur la validité des coupons, la manière de les utiliser, les règles de vente et d'achat, et plus encore. Les forums peuvent également permettre aux membres de donner leur avis sur les transactions qu'ils ont effectuées et de partager des recommandations sur les vendeurs ou les acheteurs fiables.<br><br>

										En somme, notre forum permet aux membres de partager des informations et de collaborer pour obtenir les meilleurs prix et les meilleures offres sur les coupons de réduction, ainsi que de faire des transactions en toute sécurité et en toute confiance.
								      </div>
								    </div>
								  </div>
								</div>

							</div>
						</div>
						<div class="col-md-6 col-xs-12">
							<div class="forum__body">
								<h2 class="forum__h1">Nous contacter</h2>

								<div class="mt-4">

									<div class="list__cat__forum">
										<form method="post">
											<?php if(!isset($_SESSION['email'])){ ?>
											<div class="mb-3">
												<label class="form-label">Email</label>
												<input class="form-control" type="email" name="message_email" placeholder="Votre email ...">
											</div>
											<?php
											}
											?>
											<div class="mb-3">
												<label class="form-label">Rédigez un message ou une question</label>
												<textarea class="topic__com__body__textarea" type="text" name="message_contact" placeholder="Votre message ..."></textarea>
											</div>
											<div class="mb-3">
												<button type="submit" name="msg_cont" class="forum__btn__create" style="background-color: <?= $background_Jaune?>;">Envoyer</button>
											</div>
										</form>
									</div>
									

								</div>

							</div>

						</div>
					</div>
				</div>


				</div>
			</div>
		
		</main>

		<?php include 'include/footer.php' ?>
	</body>
	<script src="js/bootstrap.min.js"></script>
</html>

