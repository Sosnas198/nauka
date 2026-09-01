document.getElementById('submit').addEventListener('click', function() {
    const haslo1 = document.getElementById('haslo1').value;
    const haslo2 = document.getElementById('haslo2').value;
    const imie = document.getElementById('imie').value;
    const nazwisko = document.getElementById('nazwisko').value;
    if (haslo1 === haslo2) {
        console.log(`Witaj ${imie} ${nazwisko}`);
        alert('Formularz zakończony');
    }
    else {
        alert('Podane hasła różnią się');
    }
});
