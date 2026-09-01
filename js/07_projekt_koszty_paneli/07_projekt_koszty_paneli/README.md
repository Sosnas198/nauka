# Kompleksowy kurs JavaScript & DOM: Kalkulator kosztów montażu paneli

Witaj w siódmym module projektowym JS! Ten przewodnik prowadzi Cię przez skrypt kalkulatora kosztów montażu paneli podłogowych na stronie `koszty.html`: **pobranie i walidację danych z formularza**, **obliczenie pola powierzchni i kosztu montażu** na podstawie stawek z tabeli 1 (strona `oferta.html`) oraz **wyświetlenie sformatowanego wyniku**.

To dobry przykład typowego "kalkulatora" — wzorzec pobierz dane → sprawdź poprawność → policz → wyświetl wynik, spotykany bardzo często w różnych aplikacjach webowych.

Cała logika znajduje się w funkcji `Oblicz()`, osadzonej bezpośrednio w pliku **`koszty.html`** (zgodnie z oryginalnym kodem źródłowym).

---

## 📁 Architektura

```text
07_projekt_koszty_paneli/
│
├── 01_pobieranie_danych_i_walidacja/
├── 02_obliczanie_pola_i_kosztu/
├── 03_wyswietlanie_wyniku/
├── README.md
├── index.html
├── oferta.html
├── koszty.html
└── main.js
```

`style.css` pochodzi z arkusza (w HTML tylko `<link>`). Plik `main.js` to referencyjna, połączona wersja wszystkich trzech modułów — w oryginalnym kodzie źródłowym funkcja `Oblicz()` znajduje się bezpośrednio wewnątrz znacznika `<script>` w treści strony `koszty.html` i pozostaje tam bez zmian.

---

## 🔄 Przepływ

```text
     Kliknięcie przycisku "Oblicz" → Oblicz()
                         │
                         ▼
     [ 01_pobieranie_danych_i_walidacja ]   parseFloat, querySelector(':checked')
                                            walidacja: puste / 0 / ujemne / brak wyboru
                         │ (dane poprawne)
                         ▼
     [ 02_obliczanie_pola_i_kosztu ]        pole = szerokość × długość
                                            kosztZaM2 wg typu panelu (tabela 1)
                                            koszt = pole × kosztZaM2
                         │
                         ▼
     [ 03_wyswietlanie_wyniku ]             szablon literału → wynik.textContent
```

Jeżeli walidacja w Module 1 wykryje błędne dane, funkcja kończy działanie instrukcją `return` już na tym etapie — Moduły 2 i 3 w ogóle się wtedy nie wykonują.

---

# 🎓 Moduły

| Moduł | README | Treść |
| ----- | ------ | ----- |
| 01 | [pobieranie danych i walidacja](./01_pobieranie_danych_i_walidacja/README.md) | `parseFloat`, `querySelector(':checked')`, warunek walidacyjny |
| 02 | [obliczanie pola i kosztu](./02_obliczanie_pola_i_kosztu/README.md) | wzór na pole prostokąta, stawki z tabeli 1, `if/else if` |
| 03 | [wyświetlanie wyniku](./03_wyswietlanie_wyniku/README.md) | szablon literału, `textContent` |

Połączenie jak w kontrolce: jedna funkcja `Oblicz()`, wywoływana atrybutem `onclick` przycisku „Oblicz” w `koszty.html`.
