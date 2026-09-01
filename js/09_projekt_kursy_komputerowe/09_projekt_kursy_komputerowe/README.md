# Kompleksowy kurs JavaScript & DOM: Kalkulator rat za kursy komputerowe

Witaj w dziewiątym module projektowym JS! Ten przewodnik prowadzi Cię przez skrypt kalkulatora rat na stronie `raty.html`: **pobranie danych z checkboxów, pola liczby rat i listy rozwijanej oraz obliczenie kwoty całkowitej**, **walidację liczby rat** oraz **obliczenie wysokości pojedynczej raty i wyświetlenie pełnego wyniku**.

To dobra okazja, żeby zobaczyć, jak obsługuje się pola typu `checkbox` (niezależne, wielokrotne zaznaczanie) w odróżnieniu od `radio` (wybór jednej opcji z grupy), a także jak skrypt może wyświetlać **stopniowo coraz pełniejsze** komunikaty, w zależności od tego, ile poprawnych danych podał użytkownik.

Cała logika znajduje się w funkcji `Oblicz()`, osadzonej bezpośrednio w pliku **`raty.html`** (zgodnie z oryginalnym kodem źródłowym).

---

## 📁 Architektura

```text
09_projekt_kursy_komputerowe/
│
├── 01_pobieranie_danych_i_kwota_calkowita/
├── 02_walidacja_liczby_rat/
├── 03_obliczanie_raty_i_wyswietlanie/
├── README.md
├── index.html
├── raty.html
└── main.js
```

`style.css` pochodzi z arkusza (w HTML tylko `<link>`). Plik `main.js` to referencyjna, połączona wersja wszystkich trzech modułów — w oryginalnym kodzie źródłowym funkcja `Oblicz()` znajduje się bezpośrednio wewnątrz znacznika `<script>` w treści strony `raty.html` i pozostaje tam bez zmian.

---

## 🔄 Przepływ

```text
     Kliknięcie przycisku "Oblicz" → Oblicz()
                         │
                         ▼
     [ 01_pobieranie_danych_i_kwota_calkowita ]   .checked (React, JS), parseInt(raty), select.value
                                                  kwotaCalkowita = suma zaznaczonych kursów
                                                  (jeśli 0) → "Wybierz przynajmniej jeden kurs."
                         │ (kwota > 0)
                         ▼
     [ 02_walidacja_liczby_rat ]                  isNaN(liczbaRat) || liczbaRat < 1 ?
                                                  (jeśli tak) → częściowy wynik: miasto + koszt
                         │ (liczba rat poprawna)
                         ▼
     [ 03_obliczanie_raty_i_wyswietlanie ]        rata = (kwota / liczbaRat).toFixed(2)
                                                  pełny komunikat: miasto + koszt + raty + rata
```

Skrypt ma trzy możliwe "wyjścia": brak wybranego kursu (Moduł 1), niepoprawna liczba rat — częściowy wynik (Moduł 2), oraz pełny wynik ze wszystkimi czterema wartościami (Moduł 3).

---

# 🎓 Moduły

| Moduł | README | Treść |
| ----- | ------ | ----- |
| 01 | [pobieranie danych i kwota całkowita](./01_pobieranie_danych_i_kwota_calkowita/README.md) | `.checked`, `parseInt`, sumowanie warunkowe, `select.value` |
| 02 | [walidacja liczby rat](./02_walidacja_liczby_rat/README.md) | `isNaN`, wcześniejszy `return`, częściowy komunikat |
| 03 | [obliczanie raty i wyświetlanie](./03_obliczanie_raty_i_wyswietlanie/README.md) | dzielenie, `toFixed(2)`, pełny szablon literału |

Połączenie jak w kontrolce: jedna funkcja `Oblicz()`, wywoływana atrybutem `onclick` przycisku „Oblicz” w `raty.html`.
