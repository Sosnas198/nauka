# Kompletny przewodnik: Przejście do kolejnej karty formularza z walidacją wypełnienia pól

Ten przewodnik tłumaczy **od A do Z**, jak przycisk "Następna karta" w pierwszym bloku formularza sprawdza, czy pola imię/nazwisko są wypełnione, i dopiero wtedy przełącza widoczną kartę formularza.

---

## 🎯 Cel skryptu

Po kliknięciu przycisku `next1`, sprawdzić, czy pola "imię" i "nazwisko" **nie są puste**. Jeśli oba są wypełnione — ukryć blok 1 i pokazać blok 2. Jeśli którekolwiek jest puste — pokazać okienko z ostrzeżeniem i **nie** przechodzić dalej.

> ℹ️ **Uwaga:** Funkcja pomocnicza `showFormBlock()` (patrz SEC-1) jest **współdzielona** z submodułem 2 (`02_przejscie_blok2_do_blok3`) — w pełnym pliku `skrypt.js` jest zdefiniowana tylko raz, a korzystają z niej oba przejścia między kartami.

---

## SEC-1: Funkcja pomocnicza `showFormBlock()` — przełączanie widocznej karty przez klasę CSS

```javascript
function showFormBlock(currentId, nextId) {
    document.getElementById(currentId).classList.remove('active');
    document.getElementById(nextId).classList.add('active');
}
```

### Jak to działa?

- **`function showFormBlock(currentId, nextId) { ... }`** — funkcja przyjmuje **dwa** parametry: `currentId` (identyfikator karty aktualnie widocznej, którą trzeba ukryć) oraz `nextId` (identyfikator karty, która ma się pojawić).
- **`document.getElementById(currentId).classList.remove('active')`** — pobiera kartę o podanym `id` i **usuwa** z niej klasę CSS `active` za pomocą **`classList.remove()`**. To odmienna technika od poprzednich projektów tego kursu (gdzie przełączano widoczność przez `style.display = 'none'`/`'block'`) — tutaj widoczność karty jest sterowana **obecnością klasy `active`** w arkuszu CSS (`styl.css`), a nie bezpośrednim ustawianiem stylu z poziomu JavaScriptu.
- **`document.getElementById(nextId).classList.add('active')`** — analogicznie, **dodaje** klasę `active` do następnej karty za pomocą **`classList.add()`**, dzięki czemu ta karta staje się widoczna (zgodnie z regułami zdefiniowanymi w CSS dla klasy `.form-block.active`).

---

## SEC-2: Nasłuchiwacz kliknięcia przycisku `next1` z walidacją pól

```javascript
document.getElementById('next1').addEventListener('click', function() {
    const imie = document.getElementById('imie').value;
    const nazwisko = document.getElementById('nazwisko').value;
    if (imie && nazwisko) {
        showFormBlock('form1', 'form2');
    }
    else {
        alert('Proszę wypełnić wszystkie pola');
    }
});
```

### Jak to działa?

- **`document.getElementById('next1').addEventListener('click', function() { ... })`** — podpinamy nasłuchiwacz kliknięcia do przycisku o `id="next1"` (przycisk "Następna karta" w pierwszym bloku).
- **`const imie = document.getElementById('imie').value;`** (i analogicznie `nazwisko`) — odczytujemy aktualnie wpisane wartości z obu pól tekstowych pierwszego bloku.
- **`if (imie && nazwisko) { ... }`** — to jest **prosta walidacja** wykorzystująca operator **`&&`** ("ORAZ") w nietypowy, ale bardzo powszechny w JavaScript sposób: zamiast porównywać zmienne z czymś (np. `imie !== ''`), sprawdzamy **bezpośrednio wartość zmiennej** w warunku `if`. W JavaScript pusty tekst (`''`) jest traktowany jako **wartość fałszywa** (*falsy*), a niepusty tekst — jako **wartość prawdziwa** (*truthy*). Czyli `if (imie && nazwisko)` czytamy jako: *"jeśli `imie` nie jest pustym tekstem ORAZ `nazwisko` nie jest pustym tekstem"*.
- Jeśli oba pola są wypełnione — wywołujemy `showFormBlock('form1', 'form2')`, czyli ukrywamy pierwszą kartę i pokazujemy drugą.
- Jeśli **którekolwiek** pole jest puste — wykonuje się blok `else`, wyświetlający wbudowane okienko przeglądarki **`alert('Proszę wypełnić wszystkie pola');`** — to standardowe, systemowe okienko z komunikatem i przyciskiem "OK", które **zatrzymuje** działanie strony, dopóki użytkownik go nie zamknie.

---

## 🧠 Ściągawka z najważniejszych pojęć

| **Pojęcie / Funkcja**            | **Co oznacza / Co robi?**                                                                        |
| ------------------------------------ | -------------------------------------------------------------------------------------------------- |
| `classList.remove('nazwa')`            | Usuwa podaną klasę CSS z elementu.                                                                     |
| `classList.add('nazwa')`               | Dodaje podaną klasę CSS do elementu.                                                                    |
| Przełączanie widoczności przez klasę CSS | Alternatywa dla `style.display` — widoczność elementu zależy od tego, czy ma on daną klasę (zdefiniowaną w arkuszu CSS). |
| Wartości "falsy" / "truthy"              | W JavaScript pusty tekst (`''`), `0`, `null`, `undefined` są traktowane jako fałsz w warunku `if`; niepusty tekst i inne wartości — jako prawda. |
| `alert('tekst')`                         | Wyświetla systemowe okienko z komunikatem, wstrzymujące działanie strony do czasu zamknięcia go przez użytkownika. |
