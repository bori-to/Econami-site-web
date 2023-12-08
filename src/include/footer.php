<style type="text/css">

  .wrapper_cookie{
    position: fixed;
    bottom: 30px;
    left: 30px;
    max-width: 365px;
    background: #fff;
    padding: 25px 25px 25px 25px;
    border-radius: 15px;
    box-shadow: 1px 7px 14px -5px rgba(0,0,0,0.15);
    text-align: center;
  }
  .wrapper_cookie.hide{
    opacity: 0;
    pointer-events: none;
    transform: scale(0.8);
    transition: all 0.3s ease;
  }
  ::selection{
    background: #DCD488;
  }
  .wrapper_cookie img{
    max-width: 90px;
  }
  .content .head_cookie{
    font-size: 25px;
    font-weight: 600;
  }
  .content{
    margin-top: 10px;
  }
  .content .buttons_cookie{
    display: flex;
    align-items: center;
    justify-content: center;
  }
  .item_cookie{
    color: #DCD488;
    font-weight: 500;
    transition: ease-out 0.5s;
  }
  .item_cookie:hover{
    color: #EDEAEA;
    transition: ease-out 0.5s;
  }
  .btn__link {
  position: relative;
  display: inline-block;
  margin: 15px;
  padding: 15px 30px;
  text-align: center;
  font-size: 18px;
  letter-spacing: 1px;
  text-decoration: none;
  color: black;
  background: transparent;
  cursor: pointer;
  transition: ease-out 0.5s;
  border: none;
  border-radius: 10px;
  box-shadow: inset 0 0 0 0 #DCD488;
  background-color: #EDEAEA;
}

.btn__link:hover {
  color: white;
  box-shadow: inset 0 -100px 0 0 #DCD488;
}

.btn__link:active {
  transform: scale(0.9);
}

.btn__link a{
  text-decoration: none;
  color: black;
}

.btn__link a:hover {
  color: #EDEAEA;
}

.line_footer {
    height: 2px;
    object-fit: cover;
    border: 2px solid #8e8885;
}

@media screen and (max-width: 400px) {
    .wrapper_cookie{
        left: 0px;
    }
}
  
</style>
<?php
if(isset($_COOKIE['accept_cookie'])){
  $showcookie = false;
}else{
  $showcookie = true;
}

if($showcookie){ ?>
  <div class="wrapper_cookie" style="
  <?php 
  if(isset($_COOKIE['theme']) && $_COOKIE['theme'] == "dark"){
    ?> 
    background-color: <?= $background_white ?>;
    <?php
  }
  ?> 
  ">
    <img src="images/cookie.png" alt="cookie">
    <div class="content">
      <p class="head_cookie">Consentement aux cookies</p>
      <p>Ce site utilise des cookies pour vous garantir la meilleure expérience sur notre site.</p>
      <div class="buttons_cookie">
        <button class="btn__link" style="padding: 10px 15px; font-weight: 500;">Je comprends</button>
        <a href="" class="item_cookie" style="
        <?php 
        if(isset($_COOKIE['theme']) && $_COOKIE['theme'] == "dark"){
          ?> 
          color: <?= $background_Jaune ?>;
          <?php
        }
        ?> 
        " data-bs-toggle="modal" data-bs-target="#exampleModal">Voir plus</a>
            
      </div>
    </div>
  </div>
<?php
}
?>
<script>
  const cookieBox = document.querySelector(".wrapper_cookie"),
  acceptBtn = cookieBox.querySelector("button");
  acceptBtn.onclick = ()=>{

  document.cookie = "accept_cookie=Yes; max-age="+60*60*24*30;
    if(document.cookie){
      cookieBox.classList.add("hide");
    }else{
      alert("Cookie can't be set! Please unblock this site from the cookie setting of your browser.");
    }
  }
  let checkCookie = document.cookie.indexOf("accept_cookie=Yes");
  checkCookie != -1 ? cookieBox.classList.add("hide") : cookieBox.classList.remove("hide");
  </script>
<footer style="
<?php 
if(isset($_COOKIE['theme']) && $_COOKIE['theme'] == "dark"){
  ?> 
  background-color: <?= $background_marron ?>;
  <?php
}else{
?>
  background-color: rgb(185, 168, 124);
<?php 
}
?> 
">
  <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content">
                  <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Les cookies</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <h5>Qu’entend-on par cookies ?</h5>
                    Nous désignons principalement par “cookies” les petits fichiers qui sont déposés sur votre terminal (ordinateur, mobile, smartphone, tablette…)  lorsque vous naviguez sur Econami. 
                    <br><br>
                    Par extension, nous désignons par “cookies” d’autres technologies ayant un comportement similaire et assurant la collecte d'informations relatives à votre navigation et à vos interactions avec Econami. Nous utilisons ces technologies pour différentes raisons, notamment pour faciliter votre navigation.
                    <br><br>
                    Les cookies ne permettent pas de directement vous identifier personnellement mais ils enregistrent des informations relatives à votre navigation et à votre comportement sur notre site. Nous pouvons ensuite y accéder lors de vos navigations ultérieures.
                    <br><br>
                    Plutôt utile, non ? <br><br>

                    <h5>Liste des Cookies</h5>
                    Vous trouverez ci-dessous la liste complète des cookies.
                    <br><br>
                    <div id="tableaux" class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">Finalité</th>
                                    <th scope="col">Emetteur</th>
                                    <th scope="col">Type</th>
                                    <th scope="col">Objectif</th>
                                    <th scope="col">Durée</th>
                                </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <td>Fonctionnalités Tierces</td>
                                <td>Econami</td>
                                <td>Cookie Third Party</td>
                                <td>Stocker l'email de l'utilisateur pour ses futures connexions.</td>
                                <td>1 semaine</td>
                              </tr>
                              <tr>
                                <td>Fonctionnalités Tierces</td>
                                <td>Econami</td>
                                <td>Cookie Third Party</td>
                                <td>Déterminer le thème light/dark.</td>
                                <td>Session</td>
                              </tr>
                              <tr>
                                <td>Fonctionnalités Tierces</td>
                                <td>Econami</td>
                                <td>Cookie Third Party</td>
                                <td>Stocker le panier de l'utilisateur pour ses achats sur le site.</td>
                                <td>1 semaine</td>
                              </tr>
                              <tr>
                                <td>Fonctionnalités Tierces</td>
                                <td>Econami</td>
                                <td>Cookie Third Party</td>
                                <td>Popup des cookie.</td>
                                <td>1 mois</td>
                              </tr>                
                            </tbody>
                        </table>
                    </div>
                    <br>
                    Pour davantage d’informations relatives au traitement des données à caractère personnel vous concernant, nous vous invitons à consulter notre Politique de Confidentialité.
                  </div>
                </div>
              </div>
            </div>
  <div class="container">
    <div class="col-12 text-center">
      <a href="index.php" class="">
        <img class="bi me-2" src="images/econami.png" alt="Logo econami" height="50px">
     </a>
    </div>
    <ul class="nav justify-content-center">
      <li class="nav-item"><a href="vente.php" class="nav-link px-2 text-muted">Vendre</a></li>
      <li class="nav-item"><a href="achats.php" class="nav-link px-2 text-muted">Achats</a></li>
      <li class="nav-item"><a href="forum_accueil.php" class="nav-link px-2 text-muted">Forum</a></li>
      <li class="nav-item"><a href="point.php" class="nav-link px-2 text-muted">VIP</a></li>
      <li class="nav-item"><a href="forum_question.php" class="nav-link px-2 text-muted">FAQs</a></li>
    </ul>
    <div class="line_footer"></div>
    <br>
    <h5 class="text-center text-muted">© 2023 Econami, Inc</h5>
    <br>
  </div>
</footer>