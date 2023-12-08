function numérique() {
    let formulaire = document.getElementById ("form");
    var explication = document.getElementById("explication");
    formulaire.value = "€";
    explication.style.display = "contents";
    var num = document.getElementById("num");
    var per = document.getElementById("per");
    num.style.color = "#DCD488";
    per.style.color = "gray";
    const input1 = document.getElementById("montant");
    const input2 = document.getElementById("prix_coupon_a");
    input1.removeAttribute("disabled");
    input2.removeAttribute("disabled");
    input1.addEventListener('input', function() {
        input2.max = input1.value;
    });
    }
function pourcent() {
    let formulaire = document.getElementById("form");
    var explication = document.getElementById("explication");
    formulaire.value = "%";
    explication.style.display = "none";
    var num = document.getElementById("num");
    var per = document.getElementById("per");
    num.style.color = "gray";
    per.style.color = "#DCD488";
    const input1 = document.getElementById("montant");
    const input2 = document.getElementById("prix_coupon_a");
    input1.removeAttribute("disabled");
    input2.removeAttribute("disabled");
    input2.removeAttribute("max");
}

function showNumber() {
    const input = document.getElementById("prix_coupon_a");
    const display = document.getElementById("displayNumber");
    const valueInpute = input.value * 0.95
    display.innerText = valueInpute.toFixed(2);+"€ "
}

async function cat_hidden() {
                alert('coucou');
                const dateAppa = document.getElementById("dateApp");
                dateAppa.classList.add("hidden");
            }