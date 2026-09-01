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
