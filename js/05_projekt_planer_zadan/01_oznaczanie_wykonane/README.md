> **Krok 1 z 2** | Start projektu. Teraz **Skrypt 1**: pobranie elementów strony i przekreślanie zadania po kliknięciu „Wykonane”.

---

# Kompletny przewodnik: Skrypt 1 — przekreślanie zadania (`closest`, `addEventListener`)

---

## Wprowadzenie — o co chodzi w tej części zadania?

Zanim jakikolwiek przycisk na stronie zacznie "coś robić" po kliknięciu, JavaScript musi wiedzieć, **do którego elementu HTML** się odnosi. W tym module realizujemy dokładnie ten mechanizm: znajdujemy potrzebne elementy na stronie, a następnie definiujemy, co ma się wydarzyć, gdy użytkownik kliknie przycisk „Wykonane” przy dowolnym zadaniu na liście.

Zwróć uwagę, że w treści zadania jest zastrzeżenie: elementy listy **mogą być dodawane, ale nie są usuwane**. To bardzo ważna wskazówka — oznacza to, że przyciski „Wykonane” nie tylko istnieją od razu na starcie (sześć sztuk, po jednym dla każdego z sześciu początkowych zadań), ale też będą **później dochodzić nowe**, gdy użytkownik doda kolejne zadanie (o tym w Skrypcie 2). Dlatego kod musi być tak zaprojektowany, żeby "podłączanie" obsługi kliknięcia dało się łatwo powtórzyć dla nowo utworzonych przycisków — stąd osobna funkcja `podlaczPrzyciskiWykonane`, a nie pojedyncze, "sztywne" podłączenie zdarzenia.

---

## SEC-1: Pobranie elementów DOM

```js
const listaZadan = document.querySelector('main ul');
const poleZadania = document.getElementById('zadanie');
const przyciskDodaj = document.querySelector('nav button');
```

Zanim cokolwiek zrobimy z elementami strony, musimy najpierw "złapać" do nich odniesienie w JavaScripcie — inaczej silnik przeglądarki nie wie, o który konkretnie element HTML nam chodzi.

- **`listaZadan`** — odniesienie do listy `<ul>` znajdującej się wewnątrz znacznika `<main>`. To właśnie do tego elementu będziemy później dopisywać nowe zadania (w Skrypcie 2) oraz w nim wyszukiwać istniejące przyciski „Wykonane” (poniżej, w SEC-3).
- **`poleZadania`** — pole tekstowe `<input id="zadanie">`, z którego użytkownik wpisuje treść nowego zadania. Wykorzystamy je dopiero w Skrypcie 2, ale zapisujemy je już tutaj, bo to jeden z trzech "głównych" elementów, z którymi cały skrypt pracuje przez cały czas swojego działania.
- **`przyciskDodaj`** — przycisk „Dodaj” z sekcji `<nav>`. Podobnie jak wyżej, jego pełne wykorzystanie (podpięcie funkcji dodawania zadania) nastąpi w Skrypcie 2.

Wszystkie trzy stałe są zdefiniowane na samym początku pliku `main.js`, poza jakąkolwiek funkcją — dzięki temu są dostępne globalnie, w każdej funkcji poniżej, bez potrzeby pobierania ich od nowa za każdym razem.

---

## SEC-2: Funkcja oznaczająca zadanie jako wykonane

Arkusz: kliknięcie przycisku „Wykonane” **przekreśla treść elementu listy** związanego z tym konkretnym przyciskiem.

```js
function oznaczJakoWykonane(event) {
	const elementListy = event.currentTarget.closest('li');
	if (elementListy) {
		elementListy.style.textDecoration = 'line-through';
	}
}
```

To jest funkcja, która zostanie wywołana dokładnie w momencie kliknięcia **dowolnego** przycisku „Wykonane” — niezależnie, czy jest to jeden z sześciu początkowych przycisków, czy przycisk utworzony później przy dodawaniu nowego zadania.

- **`event`** — parametr, który JavaScript automatycznie przekazuje do funkcji obsługującej zdarzenie (tutaj: kliknięcie). Zawiera on informacje o tym zdarzeniu, m.in. które dokładnie miejsce na stronie zostało kliknięte.
- **`event.currentTarget`** — element, do którego został "podpięty" nasłuchiwacz zdarzenia (`addEventListener`) — czyli w naszym przypadku dokładnie ten przycisk „Wykonane”, który został kliknięty.
- **`.closest('li')`** — metoda, która zaczyna od danego elementu (tutaj: klikniętego przycisku) i "wędruje w górę" po strukturze HTML (przez rodziców), szukając **najbliższego** przodka pasującego do podanego selektora — w tym przypadku znacznika `<li>`. Ponieważ przycisk „Wykonane” znajduje się bezpośrednio wewnątrz elementu `<li>` danego zadania, `closest('li')` zwróci właśnie ten konkretny element listy, do którego przycisk należy.
- **`if (elementListy)`** — zabezpieczenie na wypadek, gdyby z jakiegoś powodu nie udało się znaleźć pasującego elementu `<li>` (wtedy `closest` zwróciłoby `null`). Dzięki temu warunkowi kod nie "wysypie się" błędem, tylko po prostu nic nie zrobi.
- **`elementListy.style.textDecoration = 'line-through'`** — właściwa "akcja" tej funkcji: ustawiamy styl CSS `text-decoration` bezpośrednio z poziomu JavaScriptu, na wartość `line-through`, czyli przekreślenie tekstu. Ponieważ ustawiamy ten styl na całym elemencie `<li>`, przekreślony zostaje cały tekst zadania (przycisk „Wykonane” pozostaje bez zmian, bo interesuje nas tylko wygląd tekstu zadania).

Warto zwrócić uwagę na sam **pomysł** tego rozwiązania: zamiast np. przekazywać do funkcji identyfikator konkretnego zadania, funkcja "domyśla się", którego elementu dotyczy, na podstawie tego, **skąd** została wywołana (czyli z którego przycisku). To bardzo uniwersalne podejście — dokładnie ta sama funkcja `oznaczJakoWykonane` obsłuży zarówno stare, jak i nowo dodane przyciski, bez żadnych modyfikacji.

---

## SEC-3: Podłączenie obsługi kliknięcia do wszystkich przycisków „Wykonane”

```js
function podlaczPrzyciskiWykonane() {
	const przyciskiWykonane = listaZadan.querySelectorAll('button');
	przyciskiWykonane.forEach((przycisk) => {
		przycisk.addEventListener('click', oznaczJakoWykonane);
	});
}
```

Sama funkcja `oznaczJakoWykonane` z SEC-2 "wie", co ma zrobić po kliknięciu — ale żeby została w ogóle wywołana, trzeba ją najpierw **podłączyć** do konkretnych przycisków jako obsługę zdarzenia `click`. Tym właśnie zajmuje się `podlaczPrzyciskiWykonane`.

- **`listaZadan.querySelectorAll('button')`** — znajduje **wszystkie** przyciski (`<button>`) znajdujące się wewnątrz listy zadań. Ponieważ w tym HTML-u jedynymi przyciskami wewnątrz `<ul>` są przyciski „Wykonane”, to zapytanie zwróci dokładnie te przyciski, które nas interesują (na starcie: sześć sztuk).
- **`.forEach((przycisk) => { ... })`** — metoda iterująca po każdym elemencie zwróconej listy przycisków, po kolei, jeden po drugim.
- **`przycisk.addEventListener('click', oznaczJakoWykonane)`** — dla każdego przycisku z osobna "mówimy" przeglądarce: "gdy ten konkretny przycisk zostanie kliknięty, wywołaj funkcję `oznaczJakoWykonane`". Zwróć uwagę, że podajemy tu **nazwę funkcji bez nawiasów** (`oznaczJakoWykonane`, a nie `oznaczJakoWykonane()`) — chodzi o przekazanie samej definicji funkcji, żeby przeglądarka wywołała ją sama, dopiero w momencie kliknięcia, a nie od razu w trakcie wykonywania tej linijki kodu.

Ta funkcja jest wywoływana **dwukrotnie** w całym skrypcie: raz na samym początku (żeby obsłużyć sześć początkowych przycisków), a drugi raz — pośrednio — za każdym razem, gdy w Skrypcie 2 zostanie dodane nowe zadanie (tam jednak podłączenie nowego przycisku odbywa się bezpośrednio, bez ponownego wywoływania całej tej funkcji — więcej w module 2).

---

## SEC-4: Uruchomienie podłączenia na starcie strony

```js
podlaczPrzyciskiWykonane();
```

To wywołanie znajduje się na samym końcu pliku `main.js` (poza jakąkolwiek funkcją) i wykonuje się automatycznie od razu po wczytaniu skryptu przez przeglądarkę. Dzięki niemu sześć początkowych przycisków „Wykonane”, obecnych w kodzie HTML od samego początku, od razu reagują na kliknięcie — bez tego wywołania obsługa `click` nigdy nie zostałaby do nich podłączona.

---

👉 **[Krok 2: Dodawanie zadania](../02_dodawanie_zadania/README.md)**
