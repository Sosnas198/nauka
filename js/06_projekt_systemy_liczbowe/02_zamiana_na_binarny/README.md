> **Krok 2 z 3** | [Krok 1](../01_walidacja_i_przygotowanie_liczby/README.md) przygotował poprawną liczbę całkowitą. Teraz **Skrypt (część 2)**: właściwy algorytm zamiany na system binarny.

---

# Kompletny przewodnik: Skrypt (część 2) — algorytm zamiany na system binarny (dzielenie przez 2, reszta z dzielenia)

---

## Wprowadzenie — o co chodzi w tej części zadania?

To jest serce całego zadania — właściwy algorytm zamiany liczby zapisanej w systemie dziesiętnym na jej odpowiednik w systemie binarnym (dwójkowym). Arkusz podaje gotowy algorytm w postaci pseudokodu (kroki K1–K6), a ten moduł pokazuje, jak dokładnie ten algorytm został przełożony na kod JavaScript.

Zanim przejdziemy do kodu, przypomnijmy samą ideę algorytmu w ludzkim języku: żeby zamienić liczbę dziesiętną na binarną, dzielimy ją wielokrotnie przez 2, za każdym razem zapisując **resztę** z tego dzielenia (czyli 0 albo 1) — reszty te, odczytane w odwrotnej kolejności (od ostatniej do pierwszej), tworzą zapis liczby w systemie binarnym. Przykładowo, dla liczby 5: `5 / 2 = 2` reszta `1`, `2 / 2 = 1` reszta `0`, `1 / 2 = 0` reszta `1` — odczytując reszty od końca, dostajemy `101`, co rzeczywiście jest zapisem binarnym liczby 5.

---

## SEC-1: Przypadek szczególny — liczba zero

```js
if (liczba === 0) {
    wynikElement.innerHTML = "0 <sub>(2)</sub>";
    return;
}
```

Zanim przejdziemy do właściwej pętli algorytmu, warto zauważyć jeden szczególny przypadek: co się stanie, jeśli użytkownik wpisze liczbę `0`? Algorytm z pseudokodu (K1–K6) opiera się na pętli, która działa **dopóki** liczba jest większa od zera (`L = 0` to warunek zakończenia w kroku K5) — gdyby więc liczba wejściowa od razu wynosiła `0`, pętla `while` z SEC-2 w ogóle by się nie wykonała, a zmienna przechowująca wynik pozostałaby pustym tekstem, co dałoby błędny (pusty) wynik.

Dlatego skrypt sprawdza ten przypadek **z góry**, jeszcze przed wejściem w pętlę, i od razu wypisuje poprawną odpowiedź: `"0 <sub>(2)</sub>"`, czyli liczbę `0` z oznaczeniem systemu binarnego w indeksie dolnym — dokładnie w formacie wymaganym przez arkusz. Podobnie jak w Module 1, funkcja kończy działanie instrukcją `return`, więc reszta kodu (właściwa pętla i grupowanie) w ogóle się dla tego przypadku nie wykonuje.

---

## SEC-2: Pętla algorytmu — dzielenie przez 2 i zbieranie reszt

Porównajmy pseudokod z arkusza z jego implementacją w JavaScripcie:

| Krok pseudokodu | Znaczenie | Odpowiednik w kodzie |
| ---------------- | --------- | --------------------- |
| K2 | B (liczba binarna) = pusty napis | `let binarny = "";` |
| K3 | B = L mod 2 | `binarny = (liczba % 2) + binarny;` |
| K4 | L = L / 2 (zaokrąglone w dół) | `liczba = Math.floor(liczba / 2);` |
| K5 | jeśli L = 0, zakończ; w przeciwnym razie wróć do K3 | `while (liczba > 0) { ... }` |
| K6 | odwróć napis B i wypisz | *(patrz wyjaśnienie w SEC-3 poniżej)* |

```js
let binarny = "";
while (liczba > 0) {
    binarny = (liczba % 2) + binarny;
    liczba = Math.floor(liczba / 2);
}
```

- **`let binarny = ""`** — to jest krok K2 z pseudokodu: na początku zapis binarny jest po prostu pustym tekstem, do którego będziemy stopniowo dopisywać kolejne cyfry.
- **`while (liczba > 0)`** — pętla wykonuje się **dopóki** liczba jest większa od zera. To odpowiednik kroku K5 z pseudokodu, tyle że zapisany "od strony przeciwnej" — zamiast sprawdzać "czy liczba wynosi już 0, żeby zakończyć", sprawdzamy "czy liczba jest nadal większa od zera, żeby kontynuować". Oba podejścia dają dokładnie ten sam efekt.
- **`liczba % 2`** — operator `%` (modulo) zwraca **resztę** z dzielenia całkowitego przez 2. Ponieważ dzielimy przez 2, reszta może wynosić tylko `0` albo `1` — to właśnie ta wartość odpowiada krokowi K3 z pseudokodu ("B przypisz L mod 2").
- **`(liczba % 2) + binarny`** — tutaj dzieje się coś ważnego i sprytnego: nową cyfrę (`0` albo `1`) dopisujemy **z przodu** dotychczasowego tekstu `binarny`, a nie na jego końcu. Dzięki temu **nie musimy** później osobno "odwracać" napisu (jak sugerowałby dosłownie krok K6 z pseudokodu) — każda kolejna cyfra od razu ląduje na właściwym miejscu, na początku, przesuwając poprzednie cyfry w prawo. To alternatywny, ale równoważny sposób realizacji kroku K6 — zamiast budować napis w kolejności odwrotnej, a potem go odwracać, budujemy go od razu w kolejności właściwej, dopisując z lewej strony.
- **`liczba = Math.floor(liczba / 2)`** — to krok K4 z pseudokodu: dzielimy liczbę przez 2 i zaokrąglamy wynik w dół do liczby całkowitej (`Math.floor` — poznane już w Module 1), żeby otrzymać kolejną, mniejszą liczbę do dalszego dzielenia w następnym obiegu pętli.
- Pętla kończy się automatycznie, gdy `liczba` osiągnie wartość `0` — dokładnie zgodnie z warunkiem z kroku K5 pseudokodu.

Po zakończeniu tej pętli zmienna `binarny` zawiera **kompletny**, poprawnie uporządkowany zapis liczby w systemie binarnym — gotowy do dalszego formatowania (grupowania spacjami), którym zajmuje się kolejny moduł.

---

👉 **[Krok 3: Grupowanie i wyświetlanie wyniku](../03_grupowanie_i_wyswietlanie_wyniku/README.md)**
