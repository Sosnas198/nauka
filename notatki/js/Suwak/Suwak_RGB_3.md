Jasne — **niczego nie zmieniam w treści ani w kodzie**. Tylko porządkuję i estetycznie formatuję Markdown.

# Pełny, czysty kod rozwiązania (HTML + JavaScript)

Aplikacja wykorzystuje zdarzenie `onload`, aby zaraz po załadowaniu strony wyświetlić wartości początkowe (`255`) w elementach `<span>`:

## HTML

```html id="m8xj2v"
<!DOCTYPE html>
<html lang="pl">
  <head>
    <meta charset="UTF-8" />
    <title>Zad1 - Suwaki RGB</title>
  </head>
  <body onload="zmiana_koloru()">
    <!-- 1. Suwaki HTML z wartością początkową 255 oraz miejscem na wyświetlenie liczby -->
    <input
      type="range"
      id="red"
      value="255"
      max="255"
      oninput="zmiana_koloru()"
    /><span id="span_r"></span> <br />
    <input
      type="range"
      id="green"
      value="255"
      max="255"
      oninput="zmiana_koloru()"
    /><span id="span_g"></span> <br />
    <input
      type="range"
      id="blue"
      value="255"
      max="255"
      oninput="zmiana_koloru()"
    /><span id="span_b"></span> <br />

    <script>
      function zmiana_koloru() {
        // A. Pobranie aktualnych wartości suwaków
        let r = document.getElementById("red").value;
        let g = document.getElementById("green").value;
        let b = document.getElementById("blue").value;

        // B. Wprowadzenie wartości liczbowych do elementów <span>
        document.getElementById("span_r").innerHTML = r;
        document.getElementById("span_g").innerHTML = g;
        document.getElementById("span_b").innerHTML = b;

        // C. Aktualizacja koloru tła strony za pomocą Template Literals
        document.body.style.backgroundColor = `rgb(${r}, ${g}, ${b})`;
      }
    </script>
  </body>
</html>
```

---

# Wyjaśnienie kluczowych pojęć ze zdjęć

## 1. Różnica między `document.body.style` a `blok.style`

- **`document.body.style`**: `document.body` to wbudowany w JavaScript globalny skrót dostępu do unikalnego znacznika `<body>`. Nie trzeba go wcześniej wyszukiwać za pomocą `getElementById` ani przypisywać do zmiennej.

- **`blok.style`**: Odnosi się do własnej zmiennej (np. `let blok = document.getElementById('box')`). Jeśli spróbujesz użyć zapisu `blok.style` bez wcześniejszego zdefiniowania zmiennej `blok`, JavaScript wygeneruje błąd `ReferenceError: blok is not defined`.

---

## 2. Kropka `.` jako "chodzenie po szufladkach" (Obiekty)

Współrzędna `document.body.style.backgroundColor` oznacza stopniowe wchodzenie do wnętrza obiektów:

- **`document`**: Główny obiekt reprezentujący cały dokument.
- **`.body`**: Sekcja `<body>` wewnątrz dokumentu.
- **`.style`**: Obiekt zawierający właściwości stylów CSS danego elementu.
- **`.backgroundColor`**: Konkretna właściwość przechowująca wartość koloru tła.

---

## 3. Dlaczego w JS używamy `backgroundColor` zamiast `background-color`?

W języku JavaScript znak myślnika (`-`) jest operatorem odejmowania. Zapis `document.body.style.background - color` zostałby zinterpretowany jako próba odjęcia zmiennej `color` od `background`. Z tego powodu właściwości CSS w JS zapisuje się w notacji **camelCase** (np. `fontSize`, `marginTop`, `borderRadius`).

---

## 4. Dostęp po sztywnym indeksie vs Pętla `for`

- **Sztywny indeks (`suwaki[0]`, `suwaki[1]`)**: Stosowany, gdy każdy element na liście pełni odmienną funkcję logiczną (np. pierwszy suwak odnosi się do czerwonego $R$, drugi do zielonego $G$, trzeci do niebieskiego $B$).

- **Pętla `for` (`suwaki[i]`)**: Stosowana do automatyzacji, gdy chcemy wykonać tę samą operację dla wszystkich elementów z grupy (np. przypisać nasłuchiwacz zdarzenia `addEventListener('input', ...)` do każdego suwaka na liście).
