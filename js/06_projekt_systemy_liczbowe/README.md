# Kompleksowy kurs JavaScript & Math: Pozycyjne systemy liczbowe

Witaj w szóstym module projektowym JS! Ten przewodnik prowadzi Cię przez skrypt zamieniający liczbę dziesiętną na jej odpowiednik w systemie binarnym: **walidację danych wejściowych**, właściwy **algorytm zamiany** (dzielenie przez 2 i zbieranie reszt) oraz **grupowanie i wyświetlanie wyniku** w formacie z arkusza.

To dobra okazja, żeby zobaczyć, jak gotowy pseudokod algorytmu (kroki K1–K6 z treści zadania) przekłada się krok po kroku na rzeczywisty kod JavaScript, oraz jak funkcje obiektu `Math` (`floor`, `abs`, `max`) pomagają zapanować nad przypadkami brzegowymi (liczby ujemne, ułamkowe, zero).

Cała logika znajduje się w funkcji `Przelicz()`, osadzonej bezpośrednio w pliku **`systemy-liczbowe.html`** (zgodnie z oryginalnym kodem źródłowym).

---

## 📁 Architektura

```text
06_projekt_systemy_liczbowe/
│
├── 01_walidacja_i_przygotowanie_liczby/
├── 02_zamiana_na_binarny/
├── 03_grupowanie_i_wyswietlanie_wyniku/
├── README.md
├── systemy-liczbowe.html
└── main.js
```

`styl.css` pochodzi z arkusza (w HTML tylko `<link>`). Plik `main.js` to referencyjna, połączona wersja wszystkich trzech modułów — w oryginalnym kodzie źródłowym (`systemy-liczbowe.html`) funkcja `Przelicz()` znajduje się bezpośrednio wewnątrz znacznika `<script>` w treści strony i pozostaje tam bez zmian.

---

## 🔄 Przepływ

```text
     Kliknięcie przycisku "Przelicz na binarny" → Przelicz()
                         │
                         ▼
     [ 01_walidacja_i_przygotowanie_liczby ]   pobranie wartości, isNaN, Math.floor(Math.abs(...))
                         │
     [ 02_zamiana_na_binarny ]                  przypadek "0", pętla: liczba % 2, liczba / 2
                         │
     [ 03_grupowanie_i_wyswietlanie_wyniku ]    podział co 4 znaki od prawej, <sub>(2)</sub>
                         ▼
                 wynikElement.innerHTML = ...
```

Każdy z trzech modułów kończy się albo przekazaniem przygotowanych danych do kolejnego etapu, albo (w przypadku błędnych danych czy liczby zero) wcześniejszym zakończeniem funkcji instrukcją `return`.

---

# 🎓 Moduły

| Moduł | README | Treść |
| ----- | ------ | ----- |
| 01 | [walidacja i przygotowanie liczby](./01_walidacja_i_przygotowanie_liczby/README.md) | `isNaN`, `Math.floor`, `Math.abs`, `Number` |
| 02 | [zamiana na binarny](./02_zamiana_na_binarny/README.md) | przypadek zera, pętla `while`, `%`, dzielenie z zaokrągleniem |
| 03 | [grupowanie i wyświetlanie wyniku](./03_grupowanie_i_wyswietlanie_wyniku/README.md) | `substring`, `Math.max`, pętla `for` malejąca, `<sub>` |

Połączenie jak w kontrolce: jedna funkcja `Przelicz()`, wywoływana atrybutem `onclick` przycisku w `systemy-liczbowe.html`.
