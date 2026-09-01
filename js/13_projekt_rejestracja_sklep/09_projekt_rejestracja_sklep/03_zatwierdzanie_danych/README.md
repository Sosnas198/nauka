# Kompletny przewodnik: Zbieranie wartości ze wszystkich pól formularza i wypisanie ich w konsoli

Ten przewodnik tłumaczy **od A do Z**, jak funkcja `zatwierdz()` pobiera dane wpisane przez użytkownika we wszystkich trzech zakładkach formularza i wypisuje je jednym komunikatem w konsoli przeglądarki.

---

## 🎯 Cel skryptu

Po kliknięciu przycisku "Zatwiedź dane" (w trzeciej zakładce), odczytać wartość **każdego** pola formularza — również tych znajdujących się w zakładkach, które **w tym momencie mogą być ukryte** (np. dane z zakładki "Klient", mimo że użytkownik jest już w zakładce "Kontakt") — i wypisać wszystko razem w konsoli przeglądarki.

> ℹ️ **Uwaga:** Zgodnie z treścią zadania, ta funkcja **celowo pomija wszelką walidację** — nie sprawdza, czy pola są puste, czy dane mają poprawny format itd. Po prostu odczytuje to, co aktualnie znajduje się w każdym polu.

---

## SEC-1: Pobranie wartości z pól tekstowych, daty, liczby i telefonu

```javascript
let imie = document.getElementById('imie').value;
let nazwisko = document.getElementById('nazwisko').value;
let data = document.getElementById('data').value;
let ulica = document.getElementById('ulica').value;
let numer = document.getElementById('numer').value;
let miasto = document.getElementById('miasto').value;
let tel = document.getElementById('tel').value;
```

### Jak to działa?

- Każda linijka pobiera element po jego `id` (np. `document.getElementById('imie')`) i od razu odczytuje jego właściwość **`.value`** — czyli aktualnie wpisaną w to pole wartość (jako tekst).
- Wynik zapisywany jest w osobnej, znacząco nazwanej zmiennej (`imie`, `nazwisko`, `data`, `ulica`, `numer`, `miasto`, `tel`) — każda odpowiada dokładnie jednemu polu formularza, niezależnie od tego, w której zakładce (`main1`, `main2` czy `main3`) się znajduje.
- **Ważna właściwość elementów HTML:** nawet jeśli dany blok (`<div id="main1">` czy `<div id="main2">`) jest w danym momencie **ukryty** przez `style.display = 'none'`, jego pola formularza **wciąż istnieją** w strukturze strony (w tzw. DOM) i wciąż przechowują wpisane wcześniej wartości. Ukrycie elementu za pomocą CSS nie usuwa go ani nie czyści jego zawartości — więc `document.getElementById('imie').value` zwróci to, co użytkownik wpisał w zakładce "Klient", nawet jeśli w międzyczasie przełączył się na zakładkę "Kontakt".

---

## SEC-2: Odczytanie stanu pola wyboru (checkbox) za pomocą operatora warunkowego (`? :`)

```javascript
let rodo = document.getElementById('rodo').checked ? 'On' : 'Of';
```

### Jak to działa?

- **`document.getElementById('rodo').checked`** — pobiera pole checkbox `rodo` i odczytuje jego właściwość `.checked`, która zwraca `true` (zaznaczone) lub `false` (niezaznaczone) — tak samo jak w innych projektach z checkboxami z tego kursu.
- **`warunek ? wartość_gdy_prawda : wartość_gdy_falsz`** — to jest **operator warunkowy** (nazywany też *operatorem trójargumentowym* albo *ternary operator*), czyli skrócony zapis instrukcji `if`/`else` w jednej linijce. Czytamy go tak: *"jeśli `checked` jest prawdą, to `rodo` przyjmie wartość `'On'`; w przeciwnym razie `rodo` przyjmie wartość `'Of'`"*.
- To dokładnie to samo, co dłuższy zapis:
  ```javascript
  let rodo;
  if (document.getElementById('rodo').checked) {
      rodo = 'On';
  } else {
      rodo = 'Of';
  }
  ```
  ale zapisany bardziej zwięźle, w jednej linijce.

---

## SEC-3: Wypisanie wszystkich zebranych danych w konsoli przeglądarki

```javascript
console.log(imie + ", " + nazwisko + ", " + data + ", " + ulica + ", " + numer + ", " + miasto + ", " + tel + ", " + rodo);
```

### Jak to działa?

- **`console.log(...)`** — to wbudowana funkcja JavaScript wypisująca podaną wartość w **konsoli przeglądarki** (specjalnym panelu narzędzi deweloperskich, niewidocznym dla zwykłego użytkownika strony, ale przydatnym do testowania i debugowania kodu).
- Wewnątrz `console.log()` łączymy (konkatenujemy) wszystkie osiem zmiennych operatorem **`+`**, wstawiając między nimi tekst `", "` (przecinek i spacja) jako separator — dzięki temu w konsoli pojawi się jeden, czytelny wiersz tekstu, np.: `Jan, Kowalski, 2000-01-15, Kwiatowa, 12, Warszawa, 500600700, On`.
- To dokładnie odpowiada wymaganiu z treści zadania: *"Wartości wyświetlane są w konsoli przeglądarki"*.

---

## 🧠 Ściągawka z najważniejszych pojęć

| **Pojęcie / Funkcja**       | **Co oznacza / Co robi?**                                                                       |
| ---------------------------- | -------------------------------------------------------------------------------------------------- |
| `.value`                       | Właściwość pola formularza zwracająca aktualnie wpisaną/wybraną wartość.                              |
| Ukryty element a jego dane     | Element ukryty przez `style.display = 'none'` nadal istnieje w DOM i przechowuje swoje dane — ukrycie nie czyści zawartości. |
| Operator warunkowy (`warunek ? A : B`) | Skrócony zapis `if`/`else` w jednej linijce, zwracający `A`, gdy warunek jest prawdziwy, albo `B`, gdy jest fałszywy. |
| `console.log(...)`            | Wypisuje podaną wartość w konsoli przeglądarki — narzędziu do testowania i debugowania kodu.           |
| Konkatenacja przez `+` z separatorem | Łączenie wielu zmiennych w jeden tekst, z wstawionym między nimi stałym separatorem (tu: `", "`). |
