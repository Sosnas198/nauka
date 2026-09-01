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
