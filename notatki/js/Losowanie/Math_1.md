# JavaScript

```JavaScript
function kolor() {
    // 1. Pobieramy element diva o id "blok" z dokumentu HTML i przypisujemy do zmiennej
    let blok = document.querySelector('#blok');

    // 2. Losujemy składową czerwoną (Red) z przedziału od 1 do 255
    let liczba_r = Math.floor(Math.random() * 255 + 1);

    // 3. Losujemy składową zieloną (Green) z przedziału od 1 do 255
    let liczba_g = Math.floor(Math.random() * 255 + 1);

    // 4. Losujemy składową niebieską (Blue) z przedziału od 1 do 255
    let liczba_b = Math.floor(Math.random() * 255 + 1);

    // 5. Wypisujemy w konsoli przeglądarki wylosowaną wartość kanału czerwonego w celach testowych
    console.log(liczba_r);

    // 6. Składamy wylosowane liczby w format koloru RGB i przypisujemy do tła elementu `#blok`
    blok.style.backgroundColor = `rgb(${liczba_r}, ${liczba_g}, ${liczba_b})`;
}
```

## Jak działa matematyka w tym kodzie (na przykładzie `liczba_r`):

- **`Math.random()`** – generuje losową liczbę z przedziału $\langle0, 1)$ (może wylosować `0`, ale nigdy równej `1`).
- **`* 255`** – „rozciąga” ten przedział do zakresu od $0$ do $254.999999\dots$.
- **`+ 1`** – przesuwa cały przedział o jeden w górę, dając zakres od $1$ do $255.999999\dots$.
- **`Math.floor(...)`** – bezlitośnie zaokrągla w dół (odcina część ułamkową), zamieniając maksymalną wartość na idealną, równą liczbę całkowitą `255`.
