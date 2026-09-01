# Projekt JavaScript + DOM: rejestracja w sklepie (zakładki, pasek postępu, zatwierdzanie danych)

**Słowa kluczowe:** funkcja parametrowa (`aktywujZakladke`), przełączanie widoczności (`style.display`), zdarzenie opuszczenia pola (`blur`), zaznaczenie wielu elementów naraz (`querySelectorAll` + `forEach`), selektor bezpośredniego potomka (`#postep > div`), odczyt wartości pola (`.value`), operator warunkowy (`? :`), wypisanie w konsoli (`console.log()`).

Projekt to wieloetapowy formularz rejestracyjny złożony z trzech niezależnych
od siebie mechanizmów działających na tym samym formularzu: przełączania
widocznej zakładki, rosnącego wizualnie paska postępu oraz końcowego
zebrania i wypisania wszystkich wpisanych danych — również tych ukrytych w
niewidocznych aktualnie zakładkach. Żaden z trzech mechanizmów nie wywołuje
bezpośrednio drugiego — razem tworzą spójne doświadczenie użytkownika.
Całość jest zebrana w dwóch działających plikach: `index.html` i
`skrypt.js`. Poniżej znajdziesz **esencję każdego wzorca** — jeśli tylko
chcesz sobie przypomnieć jak coś działało, masz to tutaj. Pełne, powolne
tłumaczenie "od zera" (z podziałem na sekcje SEC-1, SEC-2...) znajduje się w
README każdego podfolderu.

## Struktura projektu

```text
09_projekt_rejestracja_sklep/
├── 01_aktywacja_zakladek/       -> przełączanie widocznej zakładki formularza
├── 02_pasek_postepu/            -> rosnący pasek postępu po opuszczeniu pola
├── 03_zatwierdzanie_danych/     -> zebranie i wypisanie wszystkich danych
├── index.html                   -> pełna strona: formularz + zakładki + pasek
└── skrypt.js                    -> wszystkie trzy mechanizmy razem
```

Każdy z modułów zawiera `README.md` (pełne wytłumaczenie) i `script.js`
(czysta implementacja wzorca). `index.html` i `skrypt.js` łączą te wzorce w
działającą stronę — moduły są logicznie niezależne i żaden nie wywołuje
bezpośrednio drugiego.

> **Uwaga:** kod odwołuje się do plików `styl.css` i `obraz.png`, których nie
> było w treści zadania — trzeba je samodzielnie dodać, żeby strona
> wyglądała poprawnie.

---

## Ściągawka wzorców

### 1. Przełączanie widocznej zakładki

```javascript
function aktywujZakladke(nazwa) {
  document.getElementById("klient").style.display = "none";
  document.getElementById("adres").style.display = "none";
  document.getElementById("kontakt").style.display = "none";

  document.getElementById(nazwa).style.display = "block";
}

function klient() {
  aktywujZakladke("klient");
}
function adres() {
  aktywujZakladke("adres");
}
function kontakt() {
  aktywujZakladke("kontakt");
}
```

Funkcja parametrowa `aktywujZakladke()` najpierw ukrywa wszystkie trzy bloki
formularza, a potem pokazuje tylko ten jeden, którego nazwę dostała jako
argument — dzięki temu zawsze widoczna jest dokładnie jedna zakładka.
Funkcje `klient()`, `adres()` i `kontakt()` to cienkie "opakowania"
wywołujące tę samą logikę z różnym parametrem — to one są bezpośrednio
podpięte pod przyciski zakładek w HTML.

→ Pełne wytłumaczenie: [`01_aktywacja_zakladek/README.md`](./01_aktywacja_zakladek/README.md)

### 2. Wizualny pasek postępu

```javascript
function aktualizujPostep() {
  const pasek = document.querySelector("#postep > div");
  let szerokosc = parseInt(pasek.style.width) || 0;

  szerokosc += 12;
  if (szerokosc > 100) {
    szerokosc = 100;
  }

  pasek.style.width = szerokosc + "%";
}

document.querySelectorAll("input").forEach(function (pole) {
  pole.addEventListener("blur", aktualizujPostep);
});
```

Zdarzenie `blur` uruchamia się w momencie **opuszczenia** pola (kliknięcia
poza nim), a nie przy każdym wpisanym znaku. `querySelectorAll("input")` +
`forEach()` podpina ten sam nasłuchiwacz do wszystkich pól formularza naraz,
niezależnie od tego, w której są zakładce. Selektor `#postep > div` wybiera
tylko **bezpośredniego** potomka kontenera paska — czyli sam wypełniany pasek,
nie jego dzieci. Warunek `if (szerokosc > 100)` to zabezpieczenie przed
przekroczeniem 100% szerokości, gdyby użytkownik opuścił więcej pól niż
wynosi jeden pełny cykl paska.

→ Pełne wytłumaczenie: [`02_pasek_postepu/README.md`](./02_pasek_postepu/README.md)

### 3. Zebranie i wypisanie wszystkich danych

```javascript
function zatwierdz() {
  const imie = document.getElementById("imie").value;
  const email = document.getElementById("email").value
    ? document.getElementById("email").value
    : "brak";

  console.log(imie, email /* , ... pozostałe pola */);
}
```

`.value` odczytuje aktualną wartość pola formularza — działa dokładnie tak
samo, niezależnie od tego, czy pole znajduje się aktualnie w widocznej, czy w
ukrytej (przez `style.display = "none"`) zakładce; ukryty element nie traci
swoich danych. Operator warunkowy `? :` to skrócony zapis `if/else` w jednej
linii — sprawdza, czy wartość pola istnieje, i podstawia tekst zastępczy
(`"brak"`), gdy pole jest puste. Na końcu wszystkie zebrane wartości trafiają
do `console.log()`, widocznego w konsoli przeglądarki.

→ Pełne wytłumaczenie: [`03_zatwierdzanie_danych/README.md`](./03_zatwierdzanie_danych/README.md)

---

## Tabela referencyjna

| Plik / moduł              | Kluczowa technika                                                 | Zastosowanie                                      |
| ------------------------- | ----------------------------------------------------------------- | ------------------------------------------------- |
| `01_aktywacja_zakladek`   | funkcja parametrowa, `style.display`                              | Przełączanie widocznej sekcji formularza          |
| `02_pasek_postepu`        | zdarzenie `blur`, `querySelectorAll().forEach()`, `#postep > div` | Wizualny wskaźnik postępu wypełniania formularza  |
| `03_zatwierdzanie_danych` | `.value`, operator warunkowy `? :`, `console.log()`               | Zebranie i wypisanie wszystkich danych formularza |
| `skrypt.js`               | moduły 1 + 2 + 3                                                  | Skrypt strony rejestracji                         |
