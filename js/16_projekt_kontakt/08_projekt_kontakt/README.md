# Projekt JavaScript + DOM: formularz kontaktowy (komunikat z danymi zgłoszenia)

**Słowa kluczowe:** odczyt pól formularza (`getElementById().value`), zamiana na małe litery (`.toLowerCase()`), sklejanie tekstu operatorem `+`, podział na wiersze (`<br>`), wstawienie komunikatu (`.innerHTML`), czyszczenie pól (`element.value = ""`), przywrócenie domyślnej opcji listy.

Projekt uczy dwóch niezależnych funkcji działających na tym samym
formularzu: `wyslij()`, która odczytuje wszystkie pola, formatuje adres
email i wyświetla trzywierszowy komunikat, oraz `czysc()`, która przywraca
formularz do stanu początkowego. Obie funkcje są od siebie w pełni
niezależne — `czysc()` nie jest kontynuacją `wyslij()`, tylko osobnym
nasłuchiwaczem podpiętym pod inny przycisk. Całość jest zebrana w jednym
działającym pliku, opartym o skrypt strony `kontakt.html`. Poniżej znajdziesz
**esencję każdego wzorca** — jeśli tylko chcesz sobie przypomnieć jak coś
działało, masz to tutaj. Pełne, powolne tłumaczenie "od zera" (z podziałem na
sekcje SEC-1, SEC-2...) znajduje się w README każdego podfolderu.

## Struktura projektu

```text
08_projekt_kontakt/
├── 01_pobieranie_danych_z_formularza/         -> getElementById().value dla wszystkich pól
├── 02_formatowanie_i_wyswietlanie_wyniku/     -> toLowerCase + sklejanie + <br> + innerHTML
└── 03_czyszczenie_formularza/                 -> reset pól przyciskiem "Czyść"
```

Każdy z modułów zawiera `README.md` (pełne wytłumaczenie) i `script.js`
(czysta implementacja wzorca). Moduły 01 i 02 to fragmenty jednej, wspólnej
funkcji `wyslij()`, wywoływanej przyciskiem `<button type="submit"
onclick="wyslij()">Wyślij</button>`. Moduł 03 to natomiast **osobna, druga**
funkcja `czysc()`, wywoływana przyciskiem "Czyść" — nie jest kontynuacją
`wyslij()`. Pełny, złożony razem kod obu funkcji znajdziesz w sekcji
"Wzorzec końcowy" poniżej.

---

## Ściągawka wzorców

### 1. Pobranie danych z formularza

```javascript
let imie = document.getElementById("imie").value;
let nazwisko = document.getElementById("nazwisko").value;
let email = document.getElementById("email").value;
let zgloszenie = document.getElementById("zgloszenie").value;
let wynik = document.getElementById("wynik");
```

`.value` odczytuje wpisaną lub wybraną wartość — działa tak samo dla pól
tekstowych, jak i dla listy rozwijanej `<select>` (`zgloszenie`). Element
`wynik` pobierany jest bez odczytu `.value`, bo w kolejnym kroku będziemy
ustawiać jego zawartość, a nie odczytywać.

→ Pełne wytłumaczenie: [`01_pobieranie_danych_z_formularza/README.md`](./01_pobieranie_danych_z_formularza/README.md)

### 2. Formatowanie i wyświetlenie wyniku

```javascript
wynik.innerHTML =
  "<p>" +
  imie +
  " " +
  nazwisko +
  "<br>" +
  email.toLowerCase() +
  "<br>Usługa: " +
  zgloszenie +
  "</p>";
```

`.toLowerCase()` zamienia adres email na same małe litery, niezależnie od
tego, jak wpisał go użytkownik. Cały komunikat budowany jest jedną
konkatenacją operatorem `+` — trzy wiersze (imię i nazwisko, email, rodzaj
usługi) rozdzielone są znacznikiem `<br>` wewnątrz jednego paragrafu `<p>`.
Gotowy tekst trafia na stronę przez `.innerHTML`.

→ Pełne wytłumaczenie: [`02_formatowanie_i_wyswietlanie_wyniku/README.md`](./02_formatowanie_i_wyswietlanie_wyniku/README.md)

### 3. Czyszczenie formularza

```javascript
function czysc() {
  document.getElementById("imie").value = "";
  document.getElementById("nazwisko").value = "";
  document.getElementById("email").value = "";
  document.getElementById("zgloszenie").value = "naprawa komputerów";
}
```

Pola tekstowe czyszczone są przez ustawienie `.value` na pusty tekst.
Wyjątkiem jest lista rozwijana `zgloszenie` — zamiast pustej wartości
przywracana jest jej domyślna opcja (`"naprawa komputerów"`), bo lista
zawsze musi mieć jakąś wybraną wartość. Funkcja `czysc()` jest wywoływana
niezależnie od `wyslij()`, przez osobny przycisk "Czyść".

→ Pełne wytłumaczenie: [`03_czyszczenie_formularza/README.md`](./03_czyszczenie_formularza/README.md)

---

## Tabela referencyjna

| Plik / moduł                            | Kluczowa funkcja                       | Do czego służy                                          |
| --------------------------------------- | -------------------------------------- | ------------------------------------------------------- |
| `01_pobieranie_danych_z_formularza`     | `getElementById().value`               | Odczyt danych z pól tekstowych i listy rozwijanej       |
| `02_formatowanie_i_wyswietlanie_wyniku` | `.toLowerCase()`, `<br>`, `.innerHTML` | Sformatowanie i wyświetlenie trzywierszowego komunikatu |
| `03_czyszczenie_formularza`             | `element.value = "..."`                | Wyczyszczenie pól tekstowych i reset listy rozwijanej   |
