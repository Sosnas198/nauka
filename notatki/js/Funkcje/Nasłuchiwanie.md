# `addEventListener` i obsługa zdarzeń

### 1. Jak działa `addEventListener` pod maską? (Czyli montowanie czujnika)

**Jak to działa po ludzku:**

Zamiast pisać zdarzenia bezpośrednio w HTML-u, dajemy przeglądarce instrukcję w pliku JavaScript za pomocą polecenia `addEventListener`.

Składa się ono z trzech głównych części:

1. **Obiekt (na kogo polujemy?):** np. `paragraf` – element DOM, na którym montujemy czujnik.
2. **Nazwa zdarzenia (na jaki sygnał czekamy?):** np. `"click"` – informujesz czujnik, żeby reagował tylko wtedy, gdy użytkownik kliknie.
3. **Funkcja zwrotna / callback (co robimy w odpowiedzi?):** np. `zmien` – instrukcja, którą przeglądarka wykona w momencie kliknięcia.

**Kluczowa pułapka – nawiasy!**

Pamiętaj, aby podawać nazwę funkcji **bez nawiasów** (`zmien`, a nie `zmien()`).

- **Bez nawiasów (`zmien`):** Dajesz przeglądarce wskazówkę: _„Odpal tę funkcję dopiero wtedy, gdy ktoś kliknie”_.
- **Z nawiasami (`zmien()`):** Zmuszasz JavaScript do uruchomienia funkcji **natychmiast** podczas ładowania strony, zanim użytkownik w ogóle zdąży cokolwiek kliknąć!

**Kod:**

### HTML

```HTML
<body>
    <p>paragraf</p>
    <script>
        let paragraf = document.querySelector('p');
        paragraf.addEventListener("click", zmien);

        function zmien() {
            paragraf.style.color = 'blue';
        }
    </script>
</body>
```

### 2. Dwa sposoby obsługi zdarzeń: HTML vs JavaScript

#### Sposób 1: Atrybuty w HTML (tzw. inline)

Wpisujesz zdarzenie bezpośrednio do znacznika HTML (np. `onclick="zmien()"`). Jest to przestarzałe i robi bałagan, gdy strona rośnie.

**Kod:**

### HTML

```HTML
<p onclick="zmien()">Kliknij mnie</p>

<script>
    function zmien() {
        alert('Kliknięto paragraf przez HTML!');
    }
</script>
```

#### Sposób 2: Nasłuchiwanie przez `addEventListener` w JS (Zalecany!)

HTML pozostaje czysty (odpowiada tylko za strukturę), a całą logikę i czujniki trzymasz w pliku JavaScript. Pozwala to m.in. na przypisanie **wielu funkcji** do jednego zdarzenia, czego stary sposób w HTML-u nie potrafił.

**Kod:**

### HTML

```HTML
<p id="moj-paragraf">Kliknij mnie</p>

<script>
    let paragraf = document.querySelector('#moj-paragraf');

    // Wiązanie akcji w JS (bez nawiasów przy funkcji!)
    paragraf.addEventListener('click', zmien);

    function zmien() {
        alert('Kliknięto paragraf przez JS!');
    }
</script>
```

### 3. Złota zasada przekładu: HTML ➔ JavaScript

Wszystkie atrybuty zdarzeń w HTML zaczynają się od słowa **`on...`** (np. `onclick`, `oninput`, `onchange`). Kiedy przenosisz je do metody `addEventListener` w JavaScripcie, **obcinasz początkowe „on”**, a resztę zostawiasz w cudzysłowie jako zwykły tekst.

| **Co robi użytkownik?**                  | **Atrybut w HTML** | **Nazwa zdarzenia w JS (addEventListener)** |
| ---------------------------------------- | ------------------ | ------------------------------------------- |
| Klika myszką                             | `onclick`          | `'click'`                                   |
| Rusza suwakiem / wpisuje tekst           | `oninput`          | `'input'`                                   |
| Zmienia stan (np. wybiera opcję z listy) | `onchange`         | `'change'`                                  |
| Najeżdża myszką na element               | `onmouseover`      | `'mouseover'`                               |
| Zjeżdża myszką z elementu                | `onmouseout`       | `'mouseout'`                                |
| Wysyła formularz                         | `onsubmit`         | `'submit'`                                  |
| Stuka w klawisz na klawiaturze           | `onkeydown`        | `'keydown'`                                 |
