let zdjecieIndex = 1;
const zdjecia = 7;
function kolejne() {
    zdjecieIndex++;
    if (zdjecieIndex > zdjecia) {
        zdjecieIndex = 1;
    }
    aktualizacja();
}
function poprzednie() {
    zdjecieIndex--;
    if (zdjecieIndex < 1) {
        zdjecieIndex = zdjecia;
    }
    aktualizacja();
}
function aktualizacja() {
    const zdjecieElement = document.querySelector("#srodkowy img");
    zdjecieElement.src = zdjecieIndex + ".jpg";
}
