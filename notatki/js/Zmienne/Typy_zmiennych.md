# 📘 Typy zmiennych w JavaScript: Tekst (`String`) vs Liczba (`Number`)

## ⚡ Dlaczego formularze w HTML „oszukują”?

Gdy pobierasz wartość z pola edycyjnego HTML za pomocą `.value`:

### HTML

```html
<!-- HTML -->
<input id="liczba" value="5" />
```

### JavaScript

```javascript
// JavaScript
let x = document.querySelector("#liczba").value;
```

Zmienna `x` **NIE JEST liczbą**, tylko **tekstem (`string`)**: `"5"`.

Nawet jeśli ustawisz w HTML `<input type="number">`, przeglądarka i tak wyciąga z niego wartość w formie tekstowej!

---

## ➕ Wielka pułapka operatora `+`

W JavaScript znak `+` ma dwie całkowicie różne role:

1. **Dodawanie matematyczne** — gdy łączysz liczby.
2. **Łączenie tekstów / sklejanie** — tzw. _konkatenacja_, gdy chociaż jeden element to tekst.

### Przykład

- `"5" + "3"` → **`"53"`** _(bo to sklejanie dwóch tekstów)_
- `"5" + 3` → **`"53"`** _(tekst z liczbą też się skleja)_
- `5 + 3` → **`8`** _(prawidłowe dodawanie matematyczne)_

> 💡 **Wniosek:** Aby zrobić prawidłowe dodawanie, musisz najpierw zamienić tekst na liczbę:
>
> `Number("5") + Number("3")` → **`8`**

---

## ⚙️ Jak inne operatory traktują tekst?

O ile operator `+` skleja teksty, o tyle pozostałe operatory próbują automatycznie zamienić tekst na liczbę.

### 1. Operatory porównania (`<`, `>`, `<=`, `>=`)

JavaScript sam próbuje konwertować tekst na liczbę:

- `"5" < 10` → JS zamienia to na `5 < 10` → wynik: **`true`**

### 2. Operacje matematyczne (`*`, `/`, `-`, `%`)

Prawie zawsze zamieniają tekst na liczby:

- `"5" * 2` → wynik: **`10`**
- `"10" - "3"` → wynik: **`7`**

### 3. Równość (`==` vs `===`)

- **`==` — zwykła równość:** robi automatyczną konwersję typów.

  `5 == "5"` → **`true`**
  _(bo tekst `"5"` zamienia na liczbę `5`)_

- **`===` — ścisła równość:** sprawdza wartość **ORAZ** typ danych.

  `5 === "5"` → **`false`**
  _(bo po lewej jest liczba, a po prawej tekst)_

---

## 🔄 Metody zamiany tekstu (`String`) na liczbę (`Number`)

### 1. `Number()` — najbardziej uniwersalny sposób

Zamienia cały tekst na liczbę.

- `Number("10")` → `10`
- `Number("5.5")` → `5.5`
- `Number("abc")` → **`NaN`** _(Not a Number — to nie jest liczba)_

### 2. `parseInt()` — czyta liczbę CAŁKOWITĄ

Wyciąga liczbę całkowitą z początku tekstu (odcina ułamki i litery z końca).

- `parseInt("10")` → `10`
- `parseInt("10.5")` → `10` _(odcina ułamek!)_
- `parseInt("10abc")` → `10` _(odcina litery na końcu)_
- `parseInt("abc10")` → **`NaN`** _(bo tekst zaczyna się od liter)_

### 3. `parseFloat()` — czyta liczbę Z PRZECINKIEM (ułamkową)

- `parseFloat("5.5")` → `5.5`
- `parseFloat("5.5abc")` → `5.5` _(odcina litery na końcu)_

---

# 🧮 Praktyczny przykład: Skrypt generujący ciąg arytmetyczny

## Kod HTML

```html
<h2>Generowanie ciągu arytmetycznego</h2>
Pierwszy wyraz A1: <input type="number" id="pierwszy_wyraz" /> <br />
Różnica ciągu R: <input type="number" id="ciag" /> <br />
Liczba wyrazów w ciągu N: <input type="number" id="liczba_ciagu" /> <br />
<button onclick="generuj()">generuj ciag</button>

<div id="wynik"></div>
```

## Kod JavaScript

```javascript
function generuj() {
  // 1. Pobieramy wartości z formularza i konwertujemy tekst na liczby całkowite (parseInt)
  var pierwszy_wyraz = parseInt(
    document.querySelector("#pierwszy_wyraz").value,
  );
  var ciag = parseInt(document.querySelector("#ciag").value);
  var liczba_ciągu = parseInt(document.querySelector("#liczba_ciagu").value);

  // 2. Pobieramy element div, w którym wyświetlimy wynik
  var wynik = document.querySelector("#wynik");

  // 3. WAŻNE: Czyścimy stary wynik przed nowym generowaniem!
  // Bez tego kolejne kliknięcia dopisywałyby nowe liczby do starych (np. 135135135...)
  wynik.innerHTML = "";

  // 4. Pętla wykonuje się dokładnie tyle razy, ile wynosi "liczba wyrazów ciągu" (N)
  for (let i = 0; i < liczba_ciągu; i++) {
    // Obliczamy kolejny wyraz ciągu: A1 + (R * i)
    let obliczenie = pierwszy_wyraz + ciag * i;

    // Wyświetlamy w konsoli dla testu
    console.log(obliczenie);

    // Dopisujemy wynik do diva na stronie (dodając spację na końcu)
    wynik.innerHTML += obliczenie + " ";
  }
}
```

---

## 🔍 Jak działa ten skrypt krok po kroku?

1. Pobiera dane z trzech pól: pierwszy wyraz ($A_1$), różnicę ($R$) i ilość wyrazów ($N$).
2. Każda wartość przechodzi przez `parseInt()`, dzięki czemu działamy na **liczbach**, a nie na tekście.
3. Przed wystartowaniem pętli czyścimy zawartość diva (`wynik.innerHTML = ""`), by po ponownym kliknięciu przycisku wyniki się nie nakładały.
4. Pętla `for` wykonuje się $N$ razy (dla `i = 0`, `i = 1`, `i = 2` ... itd.).
5. W każdej iteracji obliczany jest nowy wyraz ciągu i dopisywany do widoku na stronie (`+= obliczenie + " "`).
