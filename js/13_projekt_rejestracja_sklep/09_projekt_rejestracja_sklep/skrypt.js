function aktywujZakladke(zakladkaId) {
    document.getElementById('main1').style.display = 'none';
    document.getElementById('main2').style.display = 'none';
    document.getElementById('main3').style.display = 'none';
    document.getElementById(zakladkaId).style.display = 'block';
}
function klient() {
    aktywujZakladke('main1');
}
function adres() {
    aktywujZakladke('main2');
}
function kontakt() {
    aktywujZakladke('main3');
}
let postepWartosc = 0;
function aktualizujPostep() {
    if (postepWartosc < 100) {
        postepWartosc += 12;
        if (postepWartosc > 100) {
            postepWartosc = 100;
        }
        document.querySelector('#postep > div').style.width = postepWartosc + '%';
    }
}
document.querySelectorAll('input[type="text"], input[type="date"], input[type="number"], input[type="tel"]').forEach(function (input) {
    input.addEventListener('blur', aktualizujPostep);
});
function zatwierdz() {
    let imie = document.getElementById('imie').value;
    let nazwisko = document.getElementById('nazwisko').value;
    let data = document.getElementById('data').value;
    let ulica = document.getElementById('ulica').value;
    let numer = document.getElementById('numer').value;
    let miasto = document.getElementById('miasto').value;
    let tel = document.getElementById('tel').value;
    let rodo = document.getElementById('rodo').checked ? 'On' : 'Of';
    console.log(imie + ", " + nazwisko + ", " + data + ", " + ulica + ", " + numer + ", " + miasto + ", " + tel + ", " + rodo);
}
