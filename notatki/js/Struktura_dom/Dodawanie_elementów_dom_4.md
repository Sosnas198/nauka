# 📋 Interaktywna Lista Zadań (To-Do List) – Krok po Kroku

Ten przewodnik tłumaczy, jak stworzyć prostą, ale w pełni działającą listę zadań za pomocą HTML i JavaScript. Wszystko zostało wyjaśnione w prosty sposób.

## 1. Wygląd początkowy (HTML)

Zanim napiszemy jakikolwiek skrypt, musimy przygotować strukturę naszej strony. Tworzymy pole tekstowe do wpisywania zadań, przycisk „Dodaj” oraz listę wypunktowaną zawierającą kilka początkowych zadań.

### HTML

```html
<body>
  <nav>
    <input type="text" name="" id="wpis" placeholder="Dodaj zdanie" />
    <button onclick="dodaj()">Dodaj</button>
  </nav>
  <main>
    <ul>
      <li>Wyprowadzic psa <button onclick="wykonane(0)">wykonane</button></li>
      <li>Gimnastyka <button onclick="wykonane(1)">wykonane</button></li>
      <li>Zakupy <button onclick="wykonane(2)">wykonane</button></li>
      <li>Spacer z kumplem <button onclick="wykonane(3)">wykonane</button></li>
      <li>
        Odrabianie lekcji z młodszą siostrą
        <button onclick="wykonane(4)">wykonane</button>
      </li>
      <li>
        Projekt na geografię <button onclick="wykonane(5)">wykonane</button>
      </li>
    </ul>
  </main>
</body>
```

## 2. Jak przeglądarka widzi listę na starcie?

Gdy strona się ładuje, przeglądarka czyta kod HTML od góry do dołu. Widzi element `<ul>`, a w nim 6 gotowych elementów `<li>`.

Gdy w skrypcie uruchomimy linijkę:

### JavaScript

```javascript
let lista = document.querySelectorAll("li");
```

Komputer tworzy w pamięci niewidoczną listę (tablicę) i wrzuca do niej wszystkie sześć zadań, numerując je od zera:

- `lista[0]` $\rightarrow$ Wyprowadzic psa
- `lista[1]` $\rightarrow$ Gimnastyka
- `lista[2]` $\rightarrow$ Zakupy
- `lista[3]` $\rightarrow$ Spacer z kumplem
- `lista[4]` $\rightarrow$ Odrabianie lekcji z młodszą siostrą
- `lista[5]` $\rightarrow$ Projekt na geografię

## 3. Akcja skreślania zadania (Funkcja `wykonane`)

Gdy użytkownik kliknie przycisk „wykonane” obok konkretnego zadania, uruchamia się funkcja przekazująca numer indeksu `x`.

### Kod funkcji:

### JavaScript

```javascript
function wykonane(x) {
  let lista = document.querySelectorAll("li");
  lista[x].style.textDecoration = "line-through";
}
```

### Jak to działa?

1. Jeśli klikniesz przycisk przy zadaniu „Zakupy”, w HTML masz zapisane `onclick="wykonane(2)"`. Zmienna `x` staje się równa `2`.
2. Komputer bierze z pamięci element `lista[2]` („Zakupy”) i za pomocą właściwości `.style.textDecoration = 'line-through'` dorysowuje poziomą kreskę przechodzącą przez tekst.

## 4. Dodawanie nowego zadania (Funkcja `dodaj`)

Gdy użytkownik wpisze coś w pole tekstowe i kliknie przycisk „Dodaj”, uruchamia się funkcja `dodaj()`. Składa się ona z kilku logicznych kroków:

### JavaScript

```javascript
function dodaj() {
  // Krok 1: Pobranie tekstu z inputa oraz znalezienie listy
  let wpis = document.querySelector("#wpis").value;
  let listaUl = document.querySelector("ul");

  // Krok 2: Sprawdzenie, ile zadań jest obecnie na liście (do nadania indeksu)
  let aktualnaIlosc = document.querySelectorAll("li").length;

  // Krok 3: Tworzymy nowy element listy <li> i wpisujemy do niego tekst
  let nowyLi = document.createElement("li");
  nowyLi.textContent = wpis + " ";

  // Krok 4: Tworzymy przycisk <button>
  let nowyBtn = document.createElement("button");
  nowyBtn.textContent = "wykonane";

  // Krok 5: Podpinamy pod przycisk zdarzenie z odpowiednim numerem indeksu
  nowyBtn.setAttribute("onclick", `wykonane(${aktualnaIlosc})`);

  // Krok 6: Składamy klocki – wrzucamy przycisk do wnętrza elementu <li>
  nowyLi.appendChild(nowyBtn);

  // Krok 7: Wrzucamy kompletny element <li> do głównej listy <ul> na stronie
  listaUl.appendChild(nowyLi);

  // Krok 8: Czyszczenie pola tekstowego
  document.querySelector("#wpis").value = "";
}
```

### Szczegółowe wyjaśnienie poszczególnych etapów:

- **Pobranie danych:** Pobieramy wpisany tekst z pola o id `#wpis` oraz znajdujemy główny element listy `<ul>`.
- **Sprawdzenie liczby elementów (`aktualnaIlosc`):** Komputer pyta: _„Ile elementów `<li>` jest teraz na stronie?”_. Jeśli na starcie było 6 zadań, wynik to `6`. Dzięki temu nowe zadanie otrzyma odpowiedni indeks `6`.
- **Tworzenie wirtualnych elementów:** Używamy `document.createElement("li")` oraz `document.createElement("button")`, aby stworzyć nowe klocki w pamięci przeglądarki.
- **Metoda `setAttribute()`:** Używamy `nowyBtn.setAttribute("onclick", ...)` jako uniwersalnego pilota do wstrzyknięcia atrybutu HTML z poprawnym numerem funkcji (np. `wykonane(6)`).
- **`appendChild()`:** Metoda ta służy do „wrzucania” stworzonego elementu do środka innego elementu (najpierw pakujemy przycisk do `<li>`, a potem `<li>` do głównego `<ul>`).
- **Czyszczenie pola:** Na samym końcu przypisujemy pusty ciąg znaków (`""`) do `.value` pola tekstowego, aby użytkownik mógł od razu wpisać kolejne zadanie.
