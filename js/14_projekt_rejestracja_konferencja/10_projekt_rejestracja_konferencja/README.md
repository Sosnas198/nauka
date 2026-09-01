# Projekt JavaScript + DOM: rejestracja konferencji (wieloetapowy formularz z walidacją)

**Słowa kluczowe:** funkcja pomocnicza (`showFormBlock()`), przełączanie klas (`classList.add()` / `classList.remove()`), walidacja _truthy_/_falsy_, wspólny wzorzec walidacji + przejścia, dane w ukrytej karcie, porównanie ścisłe (`===`), szablon literału, `console.log()`.

Projekt to trzykartowy formularz rejestracyjny, w którym przejście na kolejną
kartę jest zawsze zablokowane, dopóki pola bieżącej karty nie są wypełnione.
Oba przejścia między kartami (1→2 i 2→3) korzystają z tej samej funkcji
pomocniczej `showFormBlock()`, różniąc się tylko sprawdzanymi polami i
argumentami przekazanymi do niej. Na końcu formularz porównuje hasła i —
dopiero jeśli się zgadzają — sięga po dane osobowe z **pierwszej**, dawno już
ukrytej karty, żeby zbudować powitanie. Całość jest zebrana w dwóch
działających plikach: `index.html` i `skrypt.js`. Poniżej znajdziesz
**esencję każdego wzorca** — jeśli tylko chcesz sobie przypomnieć jak coś
działało, masz to tutaj. Pełne, powolne tłumaczenie "od zera" (z podziałem na
sekcje SEC-1, SEC-2...) znajduje się w README każdego podfolderu.

## Struktura projektu

```text
10_projekt_rejestracja_konferencja/
├── 01_przejscie_blok1_do_blok2/    -> walidacja imię/nazwisko + przejście na kartę 2
├── 02_przejscie_blok2_do_blok3/    -> walidacja e-mail/telefon + przejście na kartę 3
├── 03_zatwierdzanie_formularza/    -> porównanie haseł + powitanie z danych karty 1
├── index.html                       -> pełna strona: trzy karty formularza
└── skrypt.js                        -> showFormBlock() + wszystkie trzy nasłuchiwacze razem
```

Każdy z modułów zawiera `README.md` (pełne wytłumaczenie) i `script.js`
(czysta implementacja wzorca). Funkcja pomocnicza `showFormBlock()` jest
zdefiniowana **tylko raz** w pełnym `skrypt.js`, ale korzystają z niej **oba**
przejścia między kartami (moduł 1 i 2) — w plikach modułów jest powtórzona
dla kompletności, żeby każdy fragment był samodzielnie zrozumiały.

> **Uwaga:** kod odwołuje się do plików `styl.css` i `motyl.mp4`, których nie
> było w treści zadania — trzeba je samodzielnie dodać, żeby strona
> wyglądała i działała poprawnie.

---

## Ściągawka wzorców

### 1. Przejście z karty 1 na kartę 2

```javascript
function showFormBlock(ukryjId, pokazId) {
  document.getElementById(ukryjId).classList.add("hidden");
  document.getElementById(pokazId).classList.remove("hidden");
}

document.getElementById("next1").addEventListener("click", function () {
  const imie = document.getElementById("imie").value;
  const nazwisko = document.getElementById("nazwisko").value;

  if (imie && nazwisko) {
    showFormBlock("karta1", "karta2");
  }
});
```

`showFormBlock()` to funkcja pomocnicza przyjmująca dwa argumenty: id karty
do ukrycia i id karty do pokazania — ukrywa jedną klasą `classList.add()`, a
pokazuje drugą przez `classList.remove()`. Warunek `if (imie && nazwisko)`
wykorzystuje wartości _truthy_/_falsy_ — pusty tekst (`""`) jest fałszywy w
warunku, więc przejście nastąpi tylko, gdy **oba** pola faktycznie coś
zawierają.

→ Pełne wytłumaczenie: [`01_przejscie_blok1_do_blok2/README.md`](./01_przejscie_blok1_do_blok2/README.md)

### 2. Przejście z karty 2 na kartę 3

```javascript
document.getElementById("next2").addEventListener("click", function () {
  const email = document.getElementById("email").value;
  const telefon = document.getElementById("telefon").value;

  if (email && telefon) {
    showFormBlock("karta2", "karta3");
  }
});
```

Dokładnie ten sam wzorzec co w module 1 — sprawdzenie _truthy_/_falsy_ dwóch
pól i wywołanie tej samej, współdzielonej funkcji `showFormBlock()`, tylko z
innymi argumentami (`"karta2"`, `"karta3"`). Pokazuje, jak jedna funkcja
pomocnicza obsługuje powtarzalny wzorzec w wieloetapowym formularzu, bez
duplikowania logiki przełączania kart.

→ Pełne wytłumaczenie: [`02_przejscie_blok2_do_blok3/README.md`](./02_przejscie_blok2_do_blok3/README.md)

### 3. Zatwierdzenie formularza — porównanie haseł i powitanie

```javascript
document.getElementById("submit").addEventListener("click", function () {
  const haslo1 = document.getElementById("haslo1").value;
  const haslo2 = document.getElementById("haslo2").value;

  if (haslo1 === haslo2) {
    const imie = document.getElementById("imie").value;
    const nazwisko = document.getElementById("nazwisko").value;

    console.log(`Witaj ${imie} ${nazwisko}`);
  }
});
```

`===` porównuje oba wpisane hasła ściśle (wartość i typ). Kluczowy szczegół:
`document.getElementById("imie").value` wciąż zwraca poprawną wartość, mimo
że karta 1 jest w tym momencie ukryta przez `classList.add("hidden")` —
ukrycie elementu w DOM nie usuwa jego danych. Szablon literału (backticki +
`${...}`) buduje gotowy tekst powitania, który trafia do `console.log()`.

→ Pełne wytłumaczenie: [`03_zatwierdzanie_formularza/README.md`](./03_zatwierdzanie_formularza/README.md)

---

## Tabela referencyjna

| Plik / moduł                  | Kluczowa technika                                              | Zastosowanie                                                  |
| ----------------------------- | -------------------------------------------------------------- | ------------------------------------------------------------- |
| `01_przejscie_blok1_do_blok2` | `showFormBlock()`, `classList`, walidacja _truthy_/_falsy_     | Bezpieczne przejście z karty 1 na kartę 2                     |
| `02_przejscie_blok2_do_blok3` | ten sam wzorzec, inne pola i karty                             | Powtarzalność wzorca w wieloetapowym formularzu               |
| `03_zatwierdzanie_formularza` | `===`, szablon literału, dane z ukrytej karty, `console.log()` | Finalna walidacja haseł i zebranie danych z całego formularza |
| `skrypt.js`                   | moduły 1 + 2 + 3, jedna wspólna `showFormBlock()`              | Skrypt strony formularza rejestracyjnego                      |
