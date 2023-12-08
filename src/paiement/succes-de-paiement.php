<?php session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if(!isset($_SESSION['email'])){
    header('location:forum.php');
    exit;
}

// Include configuration file  
require_once 'config.php'; 
 
// Include database connection file  
include_once '../include/db.php'; 
 
$payment_id = $statusMsg = ''; 
$status = 'error'; 
 
// Check whether stripe checkout session is not empty 
if(!empty($_GET['session_id'])){

    $session_id = $_GET['session_id']; 
     
     
        // Include the Stripe PHP library 
        require_once 'stripe-php/init.php'; 
         
        // Set API key 
        $stripe = new \Stripe\StripeClient(STRIPE_API_KEY); 
         
        // Fetch the Checkout Session to display the JSON result on the success page 
        try { 
            $checkout_session = $stripe->checkout->sessions->retrieve($session_id); 
        } catch(Exception $e) {  
            $api_error = $e->getMessage();  
        } 
        $paiement = false;
        if(empty($api_error) && $checkout_session){ 
            // Get customer details 
            $customer_details = $checkout_session->customer_details; 
 
            // Retrieve the details of a PaymentIntent 
            try { 
                $paymentIntent = $stripe->paymentIntents->retrieve($checkout_session->payment_intent); 
            } catch (\Stripe\Exception\ApiErrorException $e) { 
                $api_error = $e->getMessage(); 
            } 
            
            if(empty($api_error) && $paymentIntent){ 
                // Check whether the payment was successful 
                if(!empty($paymentIntent) && $paymentIntent->status == 'succeeded'){ 
                    // Transaction details  
                    $transactionID = $paymentIntent->id; 
                    $paidAmount = $paymentIntent->amount; 
                    $paidAmount = ($paidAmount/100); 
                    $paidCurrency = $paymentIntent->currency; 
                    $payment_status = $paymentIntent->status; 
                     
                    // Customer info 
                    $customer_name = $customer_email = ''; 
                    if(!empty($customer_details)){ 
                        $customer_name = !empty($customer_details->name)?$customer_details->name:''; 
                        $customer_email = !empty($customer_details->email)?$customer_details->email:''; 
                    } 
                     
                    // Check if any transaction data is exists already with the same TXN ID 
                    $q = "SELECT id FROM commande WHERE txn_id = ?"; 
                    $stmt = $bdd->prepare($q);  
                    $stmt->execute([
                        $transactionID
                    ]); 
                    $prevRow = $stmt->fetch(); 
                     
                    if(!empty($prevRow)){ 
                        $payment_id = $prevRow['id']; 
                    }else{
                        $paiement = true;
                        if (isset($_COOKIE['panier']) && !empty($_COOKIE['panier'])) {
                            $date_creation = date('Y-m-d H:i;s');  
                            $panier = unserialize($_COOKIE['panier']);
                            foreach($panier as $contenue){
                                $q = "INSERT INTO commande (id_users,id_annonce,paiement_montant,paiement_monnaie,txn_id,paiement_statue,stripe_checkout_session_id,date_creation,date_modification) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)"; 
                                $stmt = $bdd->prepare($q); 
                                $insert = $stmt->execute([
                                    $_SESSION['id'],
                                    $contenue['id'],
                                    $contenue['prix'],
                                    strtoupper($currency),
                                    $transactionID,
                                    $payment_status,
                                    $session_id,
                                    $date_creation,
                                    $date_creation
                                ]); 
                            }

                            foreach($panier as $contenue){
                                $q = "SELECT a.*, u.pseudo, u.email FROM annonce a
                                INNER JOIN users u on u.id = a.id_users
                                WHERE a.id = ?";
                                $an = $bdd->prepare($q);
                                $an->execute([
                                    $contenue['id']
                                ]);
                                $annonce = $an->fetch();

                                $q = "UPDATE users SET solde = solde + ?, points = points + ? WHERE id = ?"; 
                                $ven = $bdd->prepare($q); 
                                $ven->execute([
                                    $annonce['prix'],
                                    $annonce['prix'],
                                    $annonce['id_users']
                                ]);

                                $q = "UPDATE annonce SET valide = '2' WHERE id = ?"; 
                                $com = $bdd->prepare($q); 
                                $com->execute([
                                    $contenue['id']
                                ]);

                                $marque_mail = $annonce['marque'];
                                $prix_mail = $annonce['prix'];
                                $type_mail = $annonce['type'];
                                $reduction_mail = $annonce['reduction'];
                                $coupon_mail = $annonce['coupon'];
                                $pseudo = $_SESSION['pseudo'];
                                $destination = $_SESSION['email'];

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
                                            <p class='para'>Bonjour $pseudo,<br>Merci pour ta commande voici ton coupon de réduction de chez $marque_mail pour une réduction de $reduction_mail $type_mail acheté pour une valeur de $prix_mail €.<br><br>
                                                Coupon : <b>$coupon_mail</b><br><br>
                                                Retrouve aussi ton coupon sur ton profil Econami !
                                            </p>
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

                                require_once "../include/PHPMailer/src/Exception.php";
                                require_once "../include/PHPMailer/src/PHPMailer.php";
                                require_once "../include/PHPMailer/src/SMTP.php";

                                $mail = new PHPMailer();


                                // Configuration
                                $name = 'esgieconami@gmail.com';

                                $mail = new PHPMailer();
                                $mail->CharSet = "UTF-8";
                                $mail->isSMTP();
                                $mail->Host = 'smtp.gmail.com';
                                $mail->SMTPAuth = True;
                                $mail->Username = $name;
                                $mail->Password = 'wbeobwtgnrdwvffr';
                                $mail->SMTPSecure = 'ssl';
                                $mail->Port = 465;

                                //Destinataires
                                $mail->addAddress($destination);

                                // Expéditeur
                                $mail->setFrom($name);

                                //Contenu
                                $mail->isHTML(true);
                                $mail->Subject = "Econami :)";
                                $mail->Body = $message;
                                $mail->AltBody = $message;

                                //On envoie
                                $mail->send();

                                $pseudo = $annonce['pseudo'];
                                $destination = $annonce['email'];

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
                                            <p class='para'>Bonjour $pseudo,<br>Ton coupon de réduction : $marque_mail avec une réduction de $reduction_mail $type_mail à était vendu pour une valeur de <b>$prix_mail €</b>. Retrouve vite ton argent sur ton compte Econami !
                                            </p>
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

                                require_once "../include/PHPMailer/src/Exception.php";
                                require_once "../include/PHPMailer/src/PHPMailer.php";
                                require_once "../include/PHPMailer/src/SMTP.php";

                                $mail = new PHPMailer();


                                // Configuration
                                $name = 'esgieconami@gmail.com';

                                $mail = new PHPMailer();
                                $mail->CharSet = "UTF-8";
                                $mail->isSMTP();
                                $mail->Host = 'smtp.gmail.com';
                                $mail->SMTPAuth = True;
                                $mail->Username = $name;
                                $mail->Password = 'wbeobwtgnrdwvffr';
                                $mail->SMTPSecure = 'ssl';
                                $mail->Port = 465;

                                //Destinataires
                                $mail->addAddress($destination);

                                // Expéditeur
                                $mail->setFrom($name);

                                //Contenu
                                $mail->isHTML(true);
                                $mail->Subject = "Econami :)";
                                $mail->Body = $message;
                                $mail->AltBody = $message;

                                //On envoie
                                $mail->send();
                            }
                            $q = "UPDATE users SET solde = solde + ?, points = points + ? WHERE id = ?";
                            $rep = $bdd->prepare($q);
                            $rep->execute([
                                $productPrice,
                                $productPrice,
                                $_SESSION['id']
                            ]);
                        }
                         
                        // if($paiement == true){ 
                        //     $payment_id = $bdd->lastInsertId(); 
                        // } 
                    } 
                    $duree = 7 * 24 * 60 * 60;
                    setcookie('panier', serialize($panier), (time() - $duree));
                    unset($panier);

                    $status = 'success'; 
                    $statusMsg = 'Votre paiement a été effectué avec succès !'; 
                }else{ 
                    $statusMsg = "La transaction a échoué !"; 
                } 
            }else{ 
                $statusMsg = "Impossible de récupérer les détails de la transaction ! $api_error";  
            } 
        }else{ 
            $statusMsg = "Transaction invalide ! $api_error";  
        } 
    }else{ 
    $statusMsg = "Requête invalide !"; 
} 
?>

<?php if($paiement == true){ ?>
    <?php
    $title = 'Commande - success';
    include('../include/head.php');

    if(isset($_SESSION['id'])){
        include('../include/log.php');
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
                            <div class="col-md-8 col-xs-12">
                                <h1 class="forum__accueil__h1 <?php echo $status; ?>">
                                    <?php echo $statusMsg; ?>
                                </h1>
                                <p><b>Coupon :</b> retrouvez vos coupons envoyer par mail ou dans votre profil !!</p>
                            </div>
                        </div>
                        <h4>Informations de paiement</h4>
                        <p><b>Numéro de référence :</b> <?php echo $payment_id; ?></p>
                        <p><b>ID de transaction :</b> <?php echo $transactionID; ?></p>
                        <p><b>Montant payé :</b> <?php echo $paidAmount.' '.$paidCurrency; ?></p>
                        <p><b>Payment Status:</b> <?php echo $payment_status; ?></p>
                        
                        <h4>Informations client</h4>
                        <p><b>Nom :</b> <?php echo $customer_name; ?></p>
                        <p><b>Email :</b> <?php echo $customer_email; ?></p>
                        
                        <h4>Information produit</h4>
                        <p><b>Nom :</b> <?php echo $productName; ?></p>
                        <p><b>Prix :</b> <?php echo $productPrice.' '.$currency; ?></p>
                        <div class="row">
                            <div class="col-md-6 col-xs-12 text-center">
                                <form method="post" action="../panier_sppr.php">
                                    <input type="hidden" name="panier">
                                    <button class="btn__link" type="submit">
                                        Retour au panier
                                    </button>
                                </form>
                            </div>
                            <div class="col-md-6 col-xs-12 text-center">
                                <form method="post" action="../panier_sppr.php">
                                    <input type="hidden" name="commande">
                                    <button class="btn__link" type="submit">
                                        Voir ma commande
                                    </button>
                                </form>
                            </div>
                        </div>
                        
                    </div>
                </div>

            </main>

        </body>
        <script src="../js/bootstrap.min.js"></script>
    </html>
<?php }else{ ?>
    <?php
    $title = 'Commande - échoué';
    include('../include/head.php');

    if(isset($_SESSION['id'])){
        include('../include/log.php');
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
                            <div class="col-md-8 col-xs-12">
                                <h1 class="forum__accueil__h1 error">
                                    Votre paiement a échoué !
                                </h1>
                            </div>
                        </div>
                        <p class="error"><?php echo $statusMsg; ?></p>
                        <button class="btn__link">
                            <a href="../panier.php">Retour au panier</a>
                        </button>
                    </div>
                </div>

            </main>

        </body>
        <script src="../js/bootstrap.min.js"></script>
    </html>
<?php } ?>