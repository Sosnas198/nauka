# Kompleksowy kurs JavaScript & DOM: Fabryka cukierków

Witaj w ósmym module projektowym JS! Ten przewodnik prowadzi Cię przez skrypt strony zamówień: **ustalenie treści zamówienia** na podstawie numeru wybranego kształtu cukierka oraz **zmianę koloru tła przycisku** na podstawie wartości RGB wpisanych przez użytkownika.

To ciekawy przykład skryptu, który w jednym kliknięciu przycisku „Zamówienie” realizuje dwie zupełnie niezależne od siebie funkcjonalności — jedną tekstową (dopasowanie liczby do nazwy), a drugą wizualną (zmianę koloru elementu na stronie).

Całość łączy plik **`skrypt.js`**, podpięty do **`zamowienie.html`**.

---

## 📁 Architektura

```text
08_projekt_fabryka_cukierkow/
│
├── 01_wybor_ksztaltu_cukierka/
├── 02_ustawienie_koloru_przycisku/
├── README.md
├── index.html
├── zamowienie.html
└── skrypt.js
```

`styl10.css` pochodzi z arkusza (w HTML tylko `<link>`).

---

## 🔄 Przepływ

```text
     Kliknięcie przycisku "Zamówienie" → zamowienie()
                         │
                         ▼
     [ 01_wybor_ksztaltu_cukierka ]        pobranie ksztalt, r, g, b
                                           if/else if/else → tekst zamówienia
                                           wpisanie tekstu do <p id="wynik">
                         │
     [ 02_ustawienie_koloru_przycisku ]    'rgb('+r+','+g+','+b+')'
                                           przypisanie do style.backgroundColor
                                           przycisku <button id="kolor">
```

Oba moduły wykonują się jedno po drugim, w ramach tego samego wywołania funkcji `zamowienie()` — nie ma tu żadnego warunku blokującego jeden moduł przed drugim, jak to bywało w projektach z walidacją danych.

---

# 🎓 Moduły

| Moduł | README | Treść |
| ----- | ------ | ----- |
| 01 | [wybór kształtu cukierka](./01_wybor_ksztaltu_cukierka/README.md) | `if/else if/else`, `innerHTML` |
| 02 | [ustawienie koloru przycisku](./02_ustawienie_koloru_przycisku/README.md) | `style.backgroundColor`, sklejanie tekstu w formacie `rgb()` |

Połączenie jak w kontrolce: jedna funkcja `zamowienie()`, wywoływana atrybutem `onclick` przycisku „Zamówienie” w `zamowienie.html`.
