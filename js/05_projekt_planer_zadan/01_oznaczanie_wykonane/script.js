// UNIWERSALNY WZORZEC: Skrypt 1 — przekreślanie zadania po kliknięciu "Wykonane"
// -----------------------------------------------------------------------------

// --- KROK 1: Pobranie elementów DOM ---
// [ZOBACZ W README: SEC-1]
const listaZadan = document.querySelector('main ul');
const poleZadania = document.getElementById('zadanie');
const przyciskDodaj = document.querySelector('nav button');

// --- KROK 2: Funkcja oznaczająca zadanie jako wykonane ---
// [ZOBACZ W README: SEC-2]
function oznaczJakoWykonane(event) {
	const elementListy = event.currentTarget.closest('li');
	if (elementListy) {
		elementListy.style.textDecoration = 'line-through';
	}
}

// --- KROK 3: Podłączenie obsługi kliknięcia do wszystkich przycisków "Wykonane" ---
// [ZOBACZ W README: SEC-3]
function podlaczPrzyciskiWykonane() {
	const przyciskiWykonane = listaZadan.querySelectorAll('button');
	przyciskiWykonane.forEach((przycisk) => {
		przycisk.addEventListener('click', oznaczJakoWykonane);
	});
}

// --- KROK 4: Uruchomienie podłączenia na starcie strony ---
// [ZOBACZ W README: SEC-4]
podlaczPrzyciskiWykonane();
