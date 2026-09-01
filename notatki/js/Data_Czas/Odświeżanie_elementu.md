# Jak ustawić czas odświeżania elementu w JavaScript? – Poradnik dla początkujących

Często podczas pisania skryptów w JavaScript pojawia się potrzeba, aby jakaś funkcja uruchamiała się automatycznie po upływie określonego czasu. Służą do tego dwie podstawowe metody: `setInterval()` oraz `setTimeout()`.

## 1. Cykliczne odświeżanie: `setInterval()`

Ta metoda pozwala na wielokrotne, cykliczne uruchamianie wybranej funkcji co wskazany przedział czasowy.

- **Jak to zapisać:** `setInterval("funkcja", czas)`

- **Co to oznacza:** Podana funkcja będzie wywoływana co określoną liczbę milisekund (1 sekunda to 1000 milisekund).

- **Przykład:** Jeśli mamy przygotowaną funkcję `zegar()`, zapis:

  JavaScript

  ```
  setInterval("zegar()", 1000);

  ```

  spowoduje, że zegar będzie odświeżał się samoczynnie co 1000 milisekund (czyli co każdą sekundę).

## 2. Jednorazowe opóźnienie: `setTimeout()`

Ta metoda działa podobnie, ale służy do **jednorazowego** uruchomienia funkcji po upływie wskazanego czasu.

- **Jak to zapisać:** `setTimeout("funkcja", czas)`

- **Co to oznacza:** Funkcja wykona się tylko jeden raz, po odliczeniu podanej liczby milisekund.

- **Przykład:** Zapis:

  JavaScript

  ```
  setTimeout("zegar()", 1000);

  ```

  spowoduje uruchomienie funkcji `zegar()` dokładnie jeden raz, po upływie 1000 milisekund (1 sekundy).
