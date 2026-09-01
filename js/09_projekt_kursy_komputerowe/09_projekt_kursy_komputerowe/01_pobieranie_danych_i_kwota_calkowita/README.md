> **Krok 1 z 3** | Start projektu. Teraz **Skrypt, część 1**: pobranie danych z kontrolek i ustalenie kwoty całkowitej za wybrane kursy.

---

# Kompletny przewodnik: Skrypt (część 1) — pobieranie danych i sumowanie ceny kursów (`.checked`, sumowanie warunkowe)

---

## Wprowadzenie — o co chodzi w tej części zadania?

Kalkulator rat pozwala użytkownikowi zaznaczyć **dowolną kombinację** kursów (może wybrać tylko React, tylko JavaScript, oba naraz, albo żaden), a następnie ma zsumować ceny wszystkich zaznaczonych kursów w jedną, całkowitą kwotę. Dopiero na tej sumie będą później wykonywane dalsze obliczenia (podział na raty). Ten moduł zajmuje się właśnie tym pierwszym etapem: sprawdzeniem, co dokładnie zostało zaznaczone, i zsumowaniem odpowiednich cen.

Zwróć uwagę na istotną różnicę względem poprzednich projektów: tutaj mamy do czynienia z polami typu `checkbox` (pole wyboru, które można niezależnie zaznaczyć lub odznaczyć), a nie `radio` (grupa, z której można wybrać tylko jedną opcję) — dlatego sprawdzanie ich stanu wygląda nieco inaczej.

---

## SEC-1: Pobranie danych ze wszystkich kontrolek formularza

```js
const kursReact = document.getElementById('react').checked;
const kursJS = document.getElementById('js').checked;
const liczbaRat = parseInt(document.getElementById('raty').value);
const miasto = document.getElementById('miasto').value;
const wynik = document.getElementById('wynik');
```

- **`document.getElementById('react').checked`** — właściwość `.checked` dla pola typu `checkbox` zwraca wartość logiczną: `true`, jeśli pole jest zaznaczone, albo `false`, jeśli nie jest. To zupełnie inny mechanizm niż `.value`, którego używaliśmy dla pól tekstowych czy liczbowych — `checkbox` nie ma "wpisanej treści", tylko po prostu stan zaznaczenia.
- Dokładnie ta sama zasada dotyczy pola `kursJS` — sprawdzamy, czy checkbox o identyfikatorze `js` jest zaznaczony.
- **`parseInt(document.getElementById('raty').value)`** — pobiera tekst z pola liczby rat i zamienia go na liczbę **całkowitą** (funkcja `parseInt`, w odróżnieniu od poznanej wcześniej `parseFloat`, obcina ewentualną część dziesiętną, co ma sens, bo liczba rat musi być liczbą całkowitą — nie można zapłacić np. "3,5 raty").
- **`document.getElementById('miasto').value`** — dla elementu `<select>` (listy rozwijanej) właściwość `.value` zwraca wartość aktualnie wybranej opcji `<option>` — czyli w tym przypadku nazwę wybranego miasta (np. `"Katowice"`).
- **`wynik`** — odniesienie do paragrafu `<p id="wynik">`, w którym na końcu wyświetlimy komunikat — zapisujemy je od razu na początku funkcji, żeby mieć do niego wygodny dostęp w dalszych krokach.

---

## SEC-2: Ustalenie cen poszczególnych kursów

```js
const cenaReact = 5000;
const cenaJS = 3000;
```

Te dwie stałe odpowiadają dokładnie cenom z tabeli kursów widocznej na stronie głównej (`index.html`) — kurs React.js kosztuje 5000 zł, a kurs JavaScript 3000 zł. Zapisanie tych wartości jako osobnych, nazwanych stałych (zamiast wpisywania "gołych" liczb bezpośrednio w dalszych obliczeniach) sprawia, że kod jest czytelniejszy — od razu widać, skąd bierze się dana liczba, bez konieczności zaglądania do tabeli na stronie.

---

## SEC-3: Zsumowanie ceny wybranych kursów

Arkusz: skrypt ustala całkowitą kwotę za wybrane kursy na podstawie cen z tabeli.

```js
let kwotaCalkowita = 0;
if (kursReact) kwotaCalkowita += cenaReact;
if (kursJS) kwotaCalkowita += cenaJS;
```

- **`let kwotaCalkowita = 0`** — zaczynamy od zera, a następnie stopniowo "dobudowujemy" tę sumę, w zależności od tego, które kursy zostały zaznaczone.
- **`if (kursReact) kwotaCalkowita += cenaReact;`** — ponieważ `kursReact` to wartość logiczna (`true` albo `false`, zapamiętana w SEC-1), sam warunek `if (kursReact)` czytamy po prostu jako "jeżeli kurs React został zaznaczony". Jeśli tak, operator `+=` dodaje do `kwotaCalkowita` cenę kursu React (`cenaReact`, czyli 5000). Zapis `kwotaCalkowita += cenaReact` to skrócona forma `kwotaCalkowita = kwotaCalkowita + cenaReact`.
- **`if (kursJS) kwotaCalkowita += cenaJS;`** — dokładnie ta sama logika, zastosowana do kursu JavaScript.
- Ponieważ oba warunki są od siebie **niezależne** (nie jest to `if / else if`, tylko dwa osobne `if`), możliwe są wszystkie kombinacje: brak zaznaczenia (kwota zostaje `0`), zaznaczenie tylko jednego kursu, albo zaznaczenie obu naraz — wtedy `kwotaCalkowita` zsumuje ceny obu kursów (5000 + 3000 = 8000).

---

## SEC-4: Sprawdzenie, czy wybrano jakikolwiek kurs

Arkusz zakłada sensowne działanie kalkulatora tylko wtedy, gdy użytkownik faktycznie coś zamawia — dlatego zaraz po obliczeniu sumy warto sprawdzić, czy w ogóle jest co liczyć dalej.

```js
if (kwotaCalkowita === 0) {
    wynik.textContent = "Wybierz przynajmniej jeden kurs.";
    return;
}
```

- **`kwotaCalkowita === 0`** — jeżeli po sprawdzeniu obu checkboxów suma nadal wynosi zero, oznacza to, że użytkownik **nie zaznaczył żadnego** kursu (bo przecież jedyny sposób, żeby `kwotaCalkowita` pozostała `0`, to niezaznaczenie ani jednego, ani drugiego pola — obie ceny są dodatnie).
- W takim przypadku wyświetlamy komunikat informujący o tym w paragrafie wynikowym i **natychmiast kończymy** działanie funkcji instrukcją `return` — dalsze obliczenia (dotyczące liczby rat i wysokości raty) nie miałyby sensu, skoro nie ma żadnej kwoty do podziału.

---

👉 **[Krok 2: Walidacja liczby rat](../02_walidacja_liczby_rat/README.md)**
