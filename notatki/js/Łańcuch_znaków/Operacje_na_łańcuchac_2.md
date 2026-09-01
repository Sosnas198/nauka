Oto kompletny kod strony HTML z rozwiązaniem zadania przedstawionego w dokumentacji oraz wyjaśnieniem kluczowych mechanizmów i wykrytych niuansów.

### Pełny kod programu (HTML + JavaScript)

**HTML**

```html
<!DOCTYPE html>
<html lang="pl">
  <head>
    <meta charset="UTF-8" />
    <title>Dodaj wpis</title>
  </head>
  <body>
    <h1>Dodaj wpis</h1>
    Podaj wpis <input type="text" id="wpis" /> <br /><br />
    <button onclick="dodaj()">Dodaj wpis</button>

    <p id="wynik">Wpisane wyrazy oddzielone przecinkiem: <br /></p>

    <script>
      // Tablica musi być zadeklarowana GLOBALNIE, aby zachowywać dane między kliknięciami
      let tablica = [];

      function dodaj() {
        // 1. Pobranie pola tekstowego oraz paragrafu z DOM
        let inputWpis = document.getElementById("wpis");
        let wpis = inputWpis.value;
        let wynik = document.getElementById("wynik");

        // 2. Zabezpieczenie przed pustym wpisem (sprawdzanie braku znaków lub samych spacji)
        if (wpis.trim() === "") {
          alert("Wpis nie może być pusty!");
          return; // Przerwanie działania funkcji
        }

        // 3. Formatowanie: Pierwsza litera wielka, pozostałe małe
        // Alternatywnie: wpis[0].toUpperCase() + wpis.slice(1).toLowerCase()
        let format = wpis.charAt(0).toUpperCase() + wpis.slice(1).toLowerCase();

        // 4. Dodanie sformatowanego tekstu do tablicy globalnej i jej posortowanie
        tablica.push(format);
        tablica.sort();

        // 5. Wyświetlenie wyników oddzielonych przecinkiem i spacją
        wynik.innerHTML =
          "Wpisane wyrazy oddzielone przecinkiem: <br>" + tablica.join(", ");

        // 6. Wyczyszczenie pola tekstowego oraz przywrócenie w nim kursora
        inputWpis.value = "";
        inputWpis.focus();
      }
    </script>
  </body>
</html>
```

### Szczegółowe omówienie mechanizmów z dokumentu

#### 1. Zmienna globalna vs lokalna

- Zdeklarowanie `let tablica = [];` na zewnątrz funkcji sprawia, że tablica jest przechowywana w pamięci przez cały czas działania strony. Dopisanie każdego kolejnego elementu metodą `.push()` zwiększa istniejącą listę.
- Gdyby zdeklarować `let tablica = [];` wewnątrz funkcji `dodaj()`, po każdym kliknięciu tablica byłaby tworzona od nowa jako pusta, tracąc wcześniejsze wpisy.

#### 2. Kapitalizacja ciągu znaków (Metody String)

- `wpis.charAt(0).toUpperCase()` (lub `wpis[0].toUpperCase()`) wyciąga pierwszy znak i podnosi go do wielkiej litery.
- `wpis.slice(1).toLowerCase()` odcina pozostałą część ciągu od indeksu `1` do końca i formatuje na małe litery.
- Połączenie ich operatorem `+` daje wymuszony układ: **Pierwsza wielka, reszta małe**.

#### 3. Właściwość (`property`) a Metoda (`method`)

- **Właściwość** przechowywana jest jako cecha obiektu, więc nie wywołuje się jej z nawiasami, np. `wpis.length` (zwraca liczbę znaków).
- **Metoda** to funkcja wbudowana w obiekt, która wykonuje określoną operację, dlatego wymaga nawiasów, np. `wpis.toUpperCase()`.

#### 4. Poprawa UX (User Experience)

- `inputWpis.value = ""` czyści pole po zatwierdzeniu tekstu.
- `inputWpis.focus()` natychmiast umieszcza kursor w polu tekstowym, umożliwiając szybkie wpisanie kolejnego hasła bez konieczności używania myszki.

#### 5. Łączenie tablicy w ciąg tekstowy

- Domyślne przypisanie tablicy do `innerHTML` (np. `wynik.innerHTML = tablica`) wypisze elementy połączone samymi przecinkami (np. `Pies,Kot,Mysz`).
- Zastosowanie funkcji `.join(", ")` dodaje spację po każdym przecinku (`Pies, Kot, Mysz`), co ulepsza czytelność tekstu na stronie.
