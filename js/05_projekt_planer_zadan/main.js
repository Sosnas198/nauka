// POŁĄCZONY WZORZEC (Moduły 01–02)
// -----------------------------------------------------------------------------

// Moduł 01: [SEC-1] Pobranie elementów DOM
const listaZadan = document.querySelector('main ul');
const poleZadania = document.getElementById('zadanie');
const przyciskDodaj = document.querySelector('nav button');

// Moduł 01: [SEC-2] Funkcja oznaczająca zadanie jako wykonane
function oznaczJakoWykonane(event) {
	const elementListy = event.currentTarget.closest('li');
	if (elementListy) {
		elementListy.style.textDecoration = 'line-through';
	}
}

// Moduł 01: [SEC-3] Podłączenie obsługi kliknięcia do wszystkich przycisków "Wykonane"
function podlaczPrzyciskiWykonane() {
	const przyciskiWykonane = listaZadan.querySelectorAll('button');
	przyciskiWykonane.forEach((przycisk) => {
		przycisk.addEventListener('click', oznaczJakoWykonane);
	});
}

// Moduł 02: [SEC-1] Funkcja dodająca nowe zadanie
function dodajZadanie() {
	const trescZadania = poleZadania.value.trim();
	if (!trescZadania) {
		return;
	}
	const nowyElement = document.createElement('li');
	nowyElement.textContent = trescZadania + ' ';
	const nowyPrzycisk = document.createElement('button');
	nowyPrzycisk.type = 'button';
	nowyPrzycisk.textContent = 'Wykonane';
	nowyPrzycisk.addEventListener('click', oznaczJakoWykonane);
	nowyElement.appendChild(nowyPrzycisk);
	listaZadan.appendChild(nowyElement);
	poleZadania.value = '';
}

// Moduł 02: [SEC-2] Podłączenie funkcji do przycisku "Dodaj"
przyciskDodaj.addEventListener('click', dodajZadanie);

// Moduł 01: [SEC-4] Uruchomienie podłączenia na starcie strony
podlaczPrzyciskiWykonane();
