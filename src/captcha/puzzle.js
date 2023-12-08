var nombreDossiers = nbDossiers;

choiceImg = Math.floor(Math.random()*nombreDossiers);
let nb = 0;
switch (choiceImg){
    case 0:
        choice1 = "captcha/1/";
    break;
    case 1:
        choice1 = "captcha/2/";
    break;
    case 2:
        choice1 = "captcha/3/";
    break;
    case 3:
        choice1 = "captcha/4/";
    break;
    case 4:
        choice1 = "captcha/5/";
    break;
}

var rows = 3;
var columns = 3;

var piece_saisi;
var piece_visee;

var turns = 0;

// Initialise le tableau imgOrder avec des nombres de 1 à 9
let img_order = ["1", "2", "3", "4" ,"5", "6" ,"7", "8", "9"];
let img_order_stored = img_order.sort(function(){return 0.5 - Math.random()});

console.log(img_order);


window.onload = function() {
    
    let count = 1;
    for (let i = 0 ; i < rows ; i++){
        for (let j = 0 ; j < columns ; j++){
            let piece = document.createElement("img");
            piece.id = count;
            piece.src = choice1 +img_order[count - 1] + ".png";
            document.getElementById("board").append(piece);

            piece.addEventListener("dragstart", drag_start);
            piece.addEventListener("dragover", drag_over)
            piece.addEventListener("dragenter", drag_enter);
            piece.addEventListener("dragleave", drag_leave);
            piece.addEventListener("drop", drag_drop);
            piece.addEventListener("dragend", drag_end);
            piece.addEventListener("touchstart", touch_start);
            piece.addEventListener("touchmove", touch_move);
            piece.addEventListener("touchend", touch_end);
            
            count += 1;
        }
    }
}

function drag_start() {
    piece_saisi = this;
}

function drag_over(e) {
    e.preventDefault();
}

function drag_enter(e) {
    e.preventDefault();
}

function drag_leave() {

}

function drag_drop() {
    piece_visee = this;
}

function drag_end() {
    let img_saisi = piece_saisi.src;
    let img_visee = piece_visee.src;
    let verify,verify2;
    let win = false;

    piece_saisi.src = img_visee;
    piece_visee.src = img_saisi;


    for(let i = 1; i < 10 ; i++){
        console.log(document.getElementById(i).id,img_order_stored[i-1]);
        verify = document.getElementById(i).src.split("/");
        console.log(verify);
        verify2 = verify[verify.length - 1].split(".")[0];
        console.log(verify2);
        if(document.getElementById(i).id !== verify2 ){
            win = false;
            break;
        }else{
            win = true;
            console.log("Youpi !");
        }
    }
    
    if (win === true){
        add_element();
    }
}

function touch_start(e) {
    e.preventDefault();
    piece_saisi = this;
}

function touch_move(e) {
    e.preventDefault();
    piece_visee = document.elementFromPoint(e.touches[0].clientX, e.touches[0].clientY);
}

function touch_end() {
    let img_saisi = piece_saisi.src;
    let img_visee = piece_visee.src;
    let verify,verify2;
    let win = false;

    piece_saisi.src = img_visee;
    piece_visee.src = img_saisi;


    for(let i = 1; i < 10 ; i++){
        console.log(document.getElementById(i).id,img_order_stored[i-1]);
        verify = document.getElementById(i).src.split("/");
        console.log(verify);
        verify2 = verify[verify.length - 1].split(".")[0];
        console.log(verify2);
        if(document.getElementById(i).id !== verify2 ){
            win = false;
            break;
        }else{
            win = true;
            console.log("Youpi !");
        }
    }
    
    if (win === true){
        add_element();
    }
}

function add_element() {
    if(nb == 0){
        nb = 1;
    //document.location.href="captcha.html";
        // Créer un élément de bouton
        var btn = document.createElement("button");

        // Ajouter des propriétés au bouton
        btn.setAttribute("type", "submit");
        btn.setAttribute("class", "btn btn-outline-dark me-2");
        

        // Ajouter le bouton à un élément parent
        var div = document.getElementById("connexionCaptcha");
        div.appendChild(btn);


        //document.location.href="captcha.html";
        // Créer un élément de bouton
        var btn2 = document.createElement("a");
        btn.innerHTML = "Connexion";

        // Ajouter des propriétés au bouton
        btn2.setAttribute("href", "#");
        btn2.setAttribute("class", "dropdown dropdown-item");
        

        // Ajouter le bouton à un élément parent
        var div = document.getElementById("connexionCaptcha2");
        div.appendChild(btn2);
    
    console.log("Oui");
    }
}