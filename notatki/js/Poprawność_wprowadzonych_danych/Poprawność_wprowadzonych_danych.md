## 1. Kompletny i poprawny kod skryptu (HTML + JavaScript)

Zgodnie z treścią zadania przedstawionego w pliku, poniżej znajduje się pełny kod aplikacji.

> **Ważna uwaga techniczna:** W treści polecenia zaznaczono, że skrypt ma działać na **liczbach rzeczywistych** (ułamkach, np. `4.5` lub `3.75`). W załączonym przykładowym kodzie uczeń użył funkcji `parseInt()`, która ucina część ułamkową i konwertuje tekst wyłącznie na liczby całkowite. Aby spełnić wymaganie obsługi średnich ocen (liczb rzeczywistych), należy zastosować funkcję `parseFloat()` lub `Number()`.

**HTML**

```html
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Wyznaczanie najniższej średniej</title>
</head>
<body>

    <h2>Wyznaczanie najniższej średniej</h2>
    
    <ol>
        <li>Kowalski <input type="text" id="Kowalski"></li>
        <li>Nowak <input type="text" id="Nowak"></li>
        <li>Lis <input type="text" id="Lis"></li>
    </ol>

    <button onclick="wyznacz()">wyznacz</button>

    <p id="wynik">Najnizsza srednia: </p>

    <script>
        function wyznacz() {
            // KROK 1: Pobranie wartości z pól i konwersja na liczby rzeczywiste (ułamkowe)
            let kowalski = parseFloat(document.getElementById("Kowalski").value);
            let nowak = parseFloat(document.getElementById("Nowak").value);
            let lis = parseFloat(document.getElementById("Lis").value);

            // KROK 2: Walidacja poprawności danych za pomocą funkcji isNaN()
            if (isNaN(kowalski) || isNaN(nowak) || isNaN(lis)) {
                alert("wpisz poprawne dane"); // Okienko ostrzegawcze
                return; // Przerwanie dalszego wykonywania funkcji
            }

            // KROK 3: Wyznaczenie najmniejszej wartości za pomocą Math.min()
            let min = Math.min(kowalski, nowak, lis);

            // KROK 4: Wypisanie wyniku w paragrafie poniżej
            let wynik = document.getElementById('wynik');
            wynik.innerHTML = "Najnizsza srednia: " + min;
        }
    </script>

</body>
</html>
```

## 2. Szczegółowa analiza krok po kroku

### Krok 1: Pobieranie danych i konwersja na liczby (`parseFloat` / `parseInt`)

**JavaScript**

```javascript
let kowalski = parseFloat(document.getElementById("Kowalski").value);
```

1. **`document.getElementById("Kowalski").value`**: Pobiera zawartość pola tekstowego jako ciąg znaków (np. `"4.5"`).
2. **`parseFloat(...)`**: Próbuje przekształcić pobrany ciąg znaków na liczbę rzeczywistą (z przecinkiem/kropką ułamkową).

   * Jeśli użytkownik wpisze `"4.5"`, funkcja zwróci liczbę `4.5`.
   * Jeśli użytkownik pozostawi pole puste `""` albo wpisze tekst `"abc"`, funkcja nie będzie w stanie utworzyć liczby i zwróci wartość specjalną **`NaN`** (ang. *Not a Number* – nie-liczba).

### Krok 2: Sprawdzanie poprawności danych (`isNaN` oraz `return`)

**JavaScript**

```javascript
if (isNaN(kowalski) || isNaN(nowak) || isNaN(lis)) {
    alert("wpisz poprawne dane");
    return;
}
```

1. **Czym jest `NaN`?** W języku JavaScript `NaN` reprezentuje stan, w którym operacja matematyczna lub konwersja typów nie powiodła się.
2. **Funkcja `isNaN(wartość)`**:

   * Zwraca `true` – jeśli przekazany parametr **NIE jest** poprawną liczbą (np. jest wartością `NaN`).
   * Zwraca `false` – jeśli wartość jest poprawną liczbą.
3. **Operator logiczny LUB (`||`)**: Sprawdza, czy **przynajmniej jedno** z pól zawiera błędne dane.
4. **Instrukcja `alert(...)`**: Wyświetla w przeglądarce osobne okienko dialogowe z komunikatem.
5. **Instrukcja `return`**: Kluczowy element walidacji. Natychmiast **przerywa wykonywanie funkcji** **`wyznacz()`**. Zabezpiecza to kod przed wykonywaniem dalszych obliczeń na błędnych danych.

### Krok 3: Obiekt `Math` i metoda `Math.min()`

**JavaScript**

```javascript
let min = Math.min(kowalski, nowak, lis);
```

1. **Obiekt `Math`**: Wbudowany, globalny obiekt w JavaScript zawierający metody i stałe matematyczne. Nie trzeba go wcześniej tworzyć ani inicjalizować.
2. **Metoda `Math.min(a, b, c, ...)`**: Przyjmuje dowolną liczbę argumentów numerycznych i zwraca z nich wartość najmniejszą.

#### Przykłady popularnych metod i stałych obiektu `Math`

:

* **`Math.min(x, y, z)`** – zwraca najmniejszą wartość z podanych.
* **`Math.max(x, y, z)`** – zwraca największą wartość z podanych.
* **`Math.round(x)`** – zaokrągla liczbę do najbliższej liczby całkowitej.
* **`Math.abs(x)`** – zwraca wartość bezwzględną (moduł) liczby.
* **`Math.PI`** – stała matematyczna reprezentująca liczbę $\pi$ (ok. $3.14159$).

### Krok 4: Wypisanie wyniku w elemencie HTML

**JavaScript**

```javascript
let wynik = document.getElementById('wynik');
wynik.innerHTML = "Najnizsza srednia: " + min;
```

1. **`document.getElementById('wynik')`**: Pobiera uchwyt do paragrafu `<p id="wynik">`.
2. **`wynik.innerHTML = ...`**: Nadpisuje dotychczasową zawartość paragrafu gotowym ciągiem tekstowym zawierającym wyliczoną najmniejszą wartość.

## Podsumowanie mechanizmu walidacji

```text
+--------------------------+------------------------------+---------------------------+
| Wprowadzona treść        | Wynik parseFloat/parseInt    | Wynik funkcji isNaN()     |
+--------------------------+------------------------------+---------------------------+
| "4.5"                    | 4.5                          | false (dane poprawne)     |
| "" (puste pole)          | NaN                          | true (aktywacja alertu)   |
| "Kowalski" (tekst)       | NaN                          | true (aktywacja alertu)   |
+--------------------------+------------------------------+---------------------------
```
