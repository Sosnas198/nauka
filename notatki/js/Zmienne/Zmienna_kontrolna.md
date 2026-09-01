# Zmienna kontrolna zmieniająca stan (Przełącznik / Toggle)

Zadaniem tego skryptu jest zmiana obrazka na stronie po kliknięciu na niego. Każde kolejne kliknięcie przełącza obrazek na zmianę: z pierwszego na drugi, z drugiego na pierwszy i tak w kółko.

---

## 💡 Jak działa mechanizm przełączania?

Aby funkcja pamiętała, który obrazek jest obecnie wyświetlany, używamy **zmiennej kontrolnej (tzw. `stan`) umieszczonej poza funkcją (globalnie)**.

1. **Warunek** sprawdza aktualny stan i podmienia ścieżkę do pliku w atrybucie `src` obrazka.
2. **Zmiana stanu:** Wewnątrz tego samego warunku zmieniamy wartość zmiennej `stan` na przeciwną.
3. Dzięki temu przy kolejnym kliknięciu funkcja odczyta już nową wartość i wykona drugi warunek.

---

## 💻 Pełny kod HTML i JavaScript

**HTML**

```html
<body>
    <!-- Zdjęcie z podpiętą funkcją na kliknięcie (onclick) -->
    <img src="1.png" alt="" srcset="" onclick="zmiana()">

    <script>
        // Globalne określenie stanu, który wskazuje na wybrane zdjęcie.
        // Zmienna żyje poza funkcją, dzięki czemu nie resetuje się po kliknięciu!
        let stan = 1;

        function zmiana() {
            // Pobranie elementu obrazka z HTML po tagu <img>
            let zdj = document.querySelector("img");

            // W zależności od stanu wyświetla się odpowiednie zdjęcie
            if (stan == 1) {
                zdj.src = '1.png';
                stan = 0; // Zmiana stanu na przeciwny dla kolejnego kliknięcia
            } else {
                zdj.src = '2.png';
                stan = 1; // Zmiana stanu na przeciwny dla kolejnego kliknięcia
            }
        }
    </script>
</body>
```

---

## 🔍 Krok po kroku na chłopski rozum

1. **`let stan = 1;`** **(na zewnątrz funkcji):**

   Zmienna kontrolna startuje z wartością `1`. Dzięki temu, że jest na zewnątrz, strona pamięta jej wartość pomiędzy kolejnymi kliknięciami.

2. **`let zdj = document.querySelector("img");`**:

   Pobiera z kodu HTML znacznik `<img>`, aby JavaScript mógł zmodyfikować jego właściwości.

3. **Instrukcja warunkowa (`if / else`):**

   * Jeśli `stan == 1`: ustawia obrazek `1.png` i od razu przestawia `stan = 0`.
   * Podczas **drugiego kliknięcia**: `stan` wynosi już `0`, więc wykonuje się kod z bloku `else` – ustawia obrazek `2.png` i przestawia `stan = 1`.
   * Pętla działania trwa w kółko przy każdym kliknięciu.
