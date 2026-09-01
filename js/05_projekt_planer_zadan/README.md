# Projekt JavaScript + DOM: planer zadań (przekreślanie + dodawanie zadań)

**Słowa kluczowe:** pobranie elementów (`querySelector`, `getElementById`), wędrowanie po DOM w górę (`closest('li')`), nasłuchiwacz zdarzenia (`addEventListener('click', ...)`), masowe podłączenie (`querySelectorAll` + `forEach`), tworzenie elementu (`createElement`), doczepienie na końcu listy (`appendChild`), przycinanie tekstu (`.trim()`).

Projekt to lista zadań, na której działają dwa niezależne, ale współpracujące
mechanizmy: przekreślanie zadania po kliknięciu "Wykonane" oraz dopisywanie
nowego zadania na końcu listy. Kluczowe zastrzeżenie z treści zadania —
elementy **mogą być dodawane, ale nie są usuwane** — sprawia, że cały kod
musi być tak zaprojektowany, żeby nowo dodane zadania działały dokładnie tak
samo jak te obecne od początku, bez pisania osobnej logiki dla "starych" i
"nowych" przycisków. Całość jest zebrana w dwóch działających plikach:
`planer.html` i `main.js`. Poniżej znajdziesz **esencję każdego wzorca** —
jeśli tylko chcesz sobie przypomnieć jak coś działało, masz to tutaj. Pełne,
powolne tłumaczenie "od zera" (z podziałem na sekcje SEC-1, SEC-2...)
znajduje się w README każdego podfolderu.

## Struktura projektu

```text
05_projekt_planer_zadan/
├── 01_oznaczanie_wykonane/   -> pobranie elementów + przekreślanie zadania
├── 02_dodawanie_zadania/     -> tworzenie i dopisywanie nowego zadania
├── planer.html               -> strona: lista zadań + formularz dodawania
└── main.js                   -> oba skrypty razem
```

Każdy z modułów zawiera `README.md` (pełne wytłumaczenie) i `script.js`
(czysta implementacja wzorca). `main.js` łączy oba wzorce w działający
skrypt strony — moduł 2 korzysta bezpośrednio z funkcji zdefiniowanej w
module 1, więc oba muszą działać razem, a nie osobno.

---

## Ściągawka wzorców

### 1. Pobranie elementów i przekreślanie zadania

```javascript
const listaZadan = document.querySelector("main ul");
const poleZadania = document.getElementById("zadanie");
const przyciskDodaj = document.querySelector("nav button");

function oznaczJakoWykonane(event) {
  const elementListy = event.currentTarget.closest("li");
  if (elementListy) {
    elementListy.style.textDecoration = "line-through";
  }
}

function podlaczPrzyciskiWykonane() {
  const przyciskiWykonane = listaZadan.querySelectorAll("button");
  przyciskiWykonane.forEach((przycisk) => {
    przycisk.addEventListener("click", oznaczJakoWykonane);
  });
}

podlaczPrzyciskiWykonane();
```

Trzy główne elementy strony (listę, pole tekstowe i przycisk "Dodaj")
pobiera się raz, na samym początku pliku, poza jakąkolwiek funkcją — dzięki
temu są dostępne globalnie w całym skrypcie. `event.currentTarget` to
dokładnie ten przycisk "Wykonane", który został kliknięty, a
`.closest('li')` wędruje od niego w górę po strukturze HTML, szukając
najbliższego rodzica `<li>` — czyli całego zadania, do którego przycisk
należy. Dzięki temu funkcja "domyśla się" swojego elementu na podstawie
tego, skąd została wywołana, zamiast wymagać przekazania identyfikatora
zadania. `podlaczPrzyciskiWykonane()` znajduje przez `querySelectorAll`
wszystkie przyciski wewnątrz listy i każdemu z osobna (`forEach`) podpina tę
samą funkcję `oznaczJakoWykonane` — wywołanie na końcu skryptu obsługuje
sześć początkowych przycisków obecnych w HTML od razu na starcie.

→ Pełne wytłumaczenie: [`01_oznaczanie_wykonane/README.md`](./01_oznaczanie_wykonane/README.md)

### 2. Dodawanie nowego zadania

```javascript
function dodajZadanie() {
  const trescZadania = poleZadania.value.trim();
  if (!trescZadania) {
    return;
  }

  const nowyElement = document.createElement("li");
  nowyElement.textContent = trescZadania + " ";

  const nowyPrzycisk = document.createElement("button");
  nowyPrzycisk.type = "button";
  nowyPrzycisk.textContent = "Wykonane";
  nowyPrzycisk.addEventListener("click", oznaczJakoWykonane);

  nowyElement.appendChild(nowyPrzycisk);
  listaZadan.appendChild(nowyElement);
  poleZadania.value = "";
}

przyciskDodaj.addEventListener("click", dodajZadanie);
```

`.trim()` usuwa białe znaki z brzegów wpisanego tekstu, a warunek
`if (!trescZadania)` przerywa funkcję przez `return`, jeśli po przycięciu
zostanie pusty tekst — to zabezpieczenie przed dodawaniem pustych zadań.
Nowy `<li>` i nowy `<button>` tworzone są od zera przez `createElement()`,
tak samo jak sześć zadań obecnych w HTML od początku — łącznie z ustawieniem
`type = 'button'` i identycznym tekstem "Wykonane". Kluczowy szczegół: do
nowego przycisku podpinana jest **ta sama** funkcja `oznaczJakoWykonane` z
modułu 1 — ponieważ ta funkcja sama "domyśla się" swojego `<li>` przez
`closest`, nie trzeba pisać dla nowych zadań żadnej osobnej logiki.
`appendChild()` wywoływane dwukrotnie najpierw wkłada przycisk do nowego
`<li>`, a potem dokłada gotowy `<li>` na **koniec** listy `<ul>`. Na końcu
pole tekstowe jest czyszczone, a cała funkcja podpięta jest pod jedyny na
stronie przycisk "Dodaj".

→ Pełne wytłumaczenie: [`02_dodawanie_zadania/README.md`](./02_dodawanie_zadania/README.md)

---

## Tabela referencyjna

| Plik / moduł             | Kluczowa funkcja                                                    | Do czego służy                                            |
| ------------------------ | ------------------------------------------------------------------- | --------------------------------------------------------- |
| `01_oznaczanie_wykonane` | `closest('li')`, `querySelectorAll` + `forEach`, `addEventListener` | Przekreślenie zadania i podłączenie obsługi do przycisków |
| `02_dodawanie_zadania`   | `.trim()`, `createElement`, `appendChild`                           | Utworzenie i dopisanie nowego zadania na końcu listy      |
| `main.js`                | moduły 1 + 2                                                        | Skrypt strony planera zadań                               |
