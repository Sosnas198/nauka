> **Krok 2 z 2** | [Krok 1](../01_wybor_ksztaltu_cukierka/README.md) wypisał treść zamówienia. Teraz **Skrypt (część 2)**: ustawienie koloru tła przycisku „Kolor” na podstawie wartości RGB.

---

# Kompletny przewodnik: Skrypt (część 2) — ustawienie koloru tła przyciskiem (`style.backgroundColor`, format `rgb()`)

---

## Wprowadzenie — o co chodzi w tej części zadania?

Druga część tego samego kliknięcia przycisku „Zamówienie” realizuje zupełnie inną funkcjonalność niż Moduł 1 — zamiast tekstu, mamy tu do czynienia z **kolorem**. Użytkownik podaje trzy liczby: R (czerwony), G (zielony) i B (niebieski), każda w zakresie od 0 do 255, a skrypt na tej podstawie ustawia kolor tła przycisku „Kolor”, który znajduje się na stronie tuż pod paragrafem z wynikiem zamówienia.

To dobra okazja, żeby przypomnieć sobie, czym właściwie jest model kolorów RGB: każdy kolor, jaki widzimy na ekranie, można opisać jako mieszankę trzech barw podstawowych — czerwonej, zielonej i niebieskiej — w różnych proporcjach, od 0 (brak danej barwy) do 255 (pełna intensywność danej barwy). Na przykład `rgb(255, 0, 0)` to czysta czerwień, `rgb(0, 255, 0)` to czysta zieleń, a `rgb(0, 0, 0)` to czerń (brak wszystkich barw).

---

## SEC-1: Zbudowanie tekstu koloru w formacie `rgb(...)` i przypisanie go do stylu przycisku

Arkusz: skrypt sprawdza wartości RGB, a następnie zmienia kolor tła przycisku „Kolor” na kolor odpowiadający podanej wartości RGB.

```js
document.getElementById('kolor').style.backgroundColor = 'rgb('+r+','+g+','+b+')';
```

Rozłóżmy tę pojedynczą, ale gęstą linijkę na czynniki pierwsze:

- **`document.getElementById('kolor')`** — znajduje na stronie przycisk `<button id="kolor">`, czyli ten drugi przycisk, widoczny pod paragrafem z wynikiem zamówienia.
- **`.style.backgroundColor`** — właściwość obiektu `style`, pozwalająca odczytać lub ustawić styl CSS `background-color` bezpośrednio z poziomu JavaScriptu, bez potrzeby modyfikowania osobnego pliku CSS. To dokładnie ten sam mechanizm, jaki widziałeś już wcześniej przy ustawianiu `textDecoration` w innym projekcie (przekreślanie tekstu) — tutaj zamiast dekoracji tekstu zmieniamy kolor tła.
- **`'rgb('+r+','+g+','+b+')'`** — to jest "ręczne sklejanie" tekstu operatorem `+`, budujące ostatecznie ciąg znaków w formacie zrozumiałym dla CSS, np. `rgb(120,80,200)`. Prześledźmy to sklejanie krok po kroku:
  - Zaczynamy od stałego fragmentu tekstu `'rgb('`.
  - Doklejamy do niego wartość zmiennej `r` (pobraną w Module 1, SEC-1) — czyli liczbę wpisaną przez użytkownika dla składowej czerwonej.
  - Doklejamy przecinek `','`, oddzielający kolejne składowe koloru — dokładnie tak, jak wymaga tego składnia CSS dla funkcji `rgb()`.
  - Doklejamy wartość `g` (składowa zielona), znowu przecinek, a potem wartość `b` (składowa niebieska).
  - Na końcu doklejamy zamykający nawias `')'`, kończący poprawny zapis funkcji `rgb()`.
  - Efektem tego całego sklejania jest np. tekst `"rgb(120,80,200)"` — dokładnie taki format tekstu, jaki CSS rozumie jako polecenie "ustaw ten kolor tła".
- Cały tak zbudowany tekst zostaje przypisany do `style.backgroundColor` przycisku „Kolor” — przeglądarka natychmiast interpretuje ten tekst i przemalowuje tło przycisku na odpowiedni kolor.

Warto zauważyć, że ten sposób budowania tekstu (przez sklejanie operatorem `+`) jest starszy i mniej czytelny niż szablon literału z backtickami (`` `rgb(${r},${g},${b})` ``), który widziałeś w innym projekcie — oba podejścia dają jednak dokładnie ten sam efekt końcowy, po prostu w nieco innym stylu zapisu.

Zwróć też uwagę, że skrypt **nie sprawdza** w żaden sposób, czy wpisane wartości R, G, B rzeczywiście mieszczą się w dopuszczalnym zakresie 0–255, ani czy pola w ogóle zostały wypełnione — arkusz w tym miejscu wymaga jedynie "sprawdzenia wartości RGB i zmiany koloru", co ten kod realizuje w najprostszy możliwy sposób: bierze to, co zostało wpisane, i przekazuje wprost do CSS. Gdyby pole zostało puste, przeglądarka po prostu zignorowałaby niepoprawną wartość koloru i tło pozostałoby bez zmian.

---

🏠 **[Spis treści](../README.md)**
