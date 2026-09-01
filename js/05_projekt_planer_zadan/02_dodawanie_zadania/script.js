// UNIWERSALNY WZORZEC: Skrypt 2 — dodawanie nowego zadania na końcu listy
// -----------------------------------------------------------------------------

// --- KROK 1: Funkcja dodająca nowe zadanie ---
// [ZOBACZ W README: SEC-1]
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

// --- KROK 2: Podłączenie funkcji do przycisku "Dodaj" ---
// [ZOBACZ W README: SEC-2]
przyciskDodaj.addEventListener('click', dodajZadanie);
