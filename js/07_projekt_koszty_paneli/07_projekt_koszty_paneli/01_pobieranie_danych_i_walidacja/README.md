> **Krok 1 z 3** | Start projektu. Teraz **Skrypt, część 1**: pobranie danych z formularza i sprawdzenie ich poprawności.

---

# Kompletny przewodnik: Skrypt (część 1) — pobieranie danych z pól i walidacja (`parseFloat`, `querySelector`)

---

## Wprowadzenie — o co chodzi w tej części zadania?

Kalkulator kosztów montażu paneli podłogowych potrzebuje od użytkownika trzech informacji: szerokości pomieszczenia, długości pomieszczenia oraz wybranego typu panelu. Zanim skrypt zacznie cokolwiek liczyć, musi te trzy wartości najpierw pobrać ze strony, a następnie sprawdzić, czy są sensowne — bo przecież nie da się obliczyć kosztu montażu dla pomieszczenia o szerokości "minus pięć metrów" albo bez wybranego rodzaju panelu.

W tym module poznasz dokładnie ten etap: jak pobrać liczby z pól typu `number`, jak sprawdzić, który przycisk radiowy został zaznaczony, oraz jak jednym warunkiem sprawdzić od razu kilka różnych rzeczy naraz.

---

## SEC-1: Pobranie wartości z pól formularza

```js
const szerokosc = parseFloat(document.getElementById('szerokosc').value);
const dlugosc = parseFloat(document.getElementById('dlugosc').value);
const typPanelu = document.querySelector('input[name="typ_panelu"]:checked');
const wynik = document.getElementById('wynik');
```

- **`document.getElementById('szerokosc').value`** — pobiera tekst wpisany w polu `<input type="number" id="szerokosc">`. Nawet jeśli pole ma typ `number`, właściwość `.value` zawsze zwraca tekst (string), dlatego trzeba go jeszcze zamienić na liczbę.
- **`parseFloat(...)`** — funkcja zamieniająca tekst na liczbę zmiennoprzecinkową (czyli mogącą mieć część dziesiętną, np. `3.5`). Różni się od poznanej wcześniej funkcji `Number()` tym, że potrafi "wyłuskać" liczbę nawet z tekstu, który zaczyna się od liczby, ale zawiera dodatkowe znaki na końcu (np. `parseFloat("12abc")` da `12`) — choć w tym konkretnym przypadku, przy polu typu `number`, wpisany tekst i tak będzie zwykle czystą liczbą.
- Dokładnie ta sama operacja jest powtórzona dla pola `dlugosc`.
- **`document.querySelector('input[name="typ_panelu"]:checked')`** — ten selektor CSS odczytuje: "znajdź element `<input>`, który ma atrybut `name` równy `"typ_panelu"` **oraz** jest aktualnie zaznaczony (`:checked`)". Ponieważ wszystkie trzy przyciski radiowe w formularzu mają tę samą nazwę `typ_panelu` (to właśnie sprawia, że są traktowane jako jedna grupa, z której można wybrać tylko jedną opcję), ten selektor zwróci dokładnie ten jeden przycisk, który użytkownik zaznaczył — albo `null`, jeśli żaden nie został zaznaczony.
- **`wynik`** — odniesienie do paragrafu `<p id="wynik">`, w którym na końcu wyświetlimy albo wynik obliczeń, albo komunikat o błędzie. Pobieramy je już teraz, żeby mieć do niego dostęp w dalszej części funkcji, bez ponownego wywoływania `getElementById`.

---

## SEC-2: Sprawdzenie poprawności wszystkich danych naraz

Arkusz: jeżeli oba pola edycyjne zostały wypełnione, skrypt oblicza wynik; w przeciwnym wypadku wyświetla komunikat „Wprowadź poprawne dane.”

```js
if (!szerokosc || !dlugosc || !typPanelu || szerokosc <= 0 || dlugosc <= 0) {
    wynik.textContent = "Wprowadź poprawne dane.";
    return;
}
```

Ten pojedynczy warunek `if` sprawdza aż **pięć** różnych, potencjalnie błędnych sytuacji naraz, połączonych operatorem `||` (logiczne "lub") — wystarczy, że **choć jedna** z nich zajdzie, żeby cały warunek okazał się prawdziwy:

- **`!szerokosc`** — jeżeli pole szerokości było puste, `parseFloat("")` zwróci specjalną wartość `NaN` ("Not a Number"). W JavaScripcie `NaN` jest traktowane jako wartość "fałszywa" (ang. *falsy*), więc `!NaN` daje `true` — ten fragment warunku wykryje więc zarówno puste pole, jak i sytuację, gdyby ktoś wpisał coś, co nie jest liczbą. Dodatkowo, gdyby szerokość wynosiła dokładnie `0`, `!0` również da `true` — to celowe, bo pomieszczenie o zerowej szerokości nie ma sensu.
- **`!dlugosc`** — dokładnie ta sama logika, zastosowana do pola długości.
- **`!typPanelu`** — jeżeli żaden przycisk radiowy nie został zaznaczony, `querySelector` (z SEC-1) zwrócił `null`. Wartość `null` również jest "fałszywa" w JavaScripcie, więc `!null` daje `true` — ten fragment wykrywa brak wyboru typu panelu.
- **`szerokosc <= 0`** oraz **`dlugosc <= 0`** — dodatkowe, jawne sprawdzenie na wypadek liczb ujemnych (np. `-5`). Choć `!szerokosc` już wykrywa `0`, to liczba ujemna, np. `-3`, jest wartością "prawdziwą" (ang. *truthy*) w JavaScripcie — `!(-3)` da `false` — dlatego potrzebne jest osobne, jawne porównanie `<= 0`, żeby odrzucić także wymiary ujemne, które fizycznie nie mają sensu dla pomieszczenia.
- Jeśli którykolwiek z tych pięciu warunków jest prawdziwy: wyświetlamy w paragrafie wynikowym komunikat „Wprowadź poprawne dane.” (metodą `textContent`, a nie `innerHTML`, bo ten tekst nie zawiera żadnych znaczników HTML do zinterpretowania) i **natychmiast kończymy** działanie funkcji instrukcją `return` — dzięki temu żadne dalsze obliczenia (Moduł 2) w ogóle się nie wykonają dla niepoprawnych danych.

---

👉 **[Krok 2: Obliczanie pola powierzchni i kosztu](../02_obliczanie_pola_i_kosztu/README.md)**
