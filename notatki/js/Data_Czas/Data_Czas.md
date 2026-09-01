## 1. Czym jest obiekt `Date()`?

JavaScript udostępnia gotowy obiekt `Date()`, dzięki któremu możemy w łatwy sposób manipulować czasem oraz datami. Praca z tym obiektem zawsze opiera się na użyciu konstruktora (słowa kluczowego `new`).

Możemy go wywołać na dwa sposoby:

- **Konstruktor bezparametrowy:** Pobiera aktualną datę i godzinę ustawioną w systemie klienta (a nie na serwerze!).

  JavaScript

  ```
  var now = new Date();

  ```

- **Konstruktor z parametrami:** Przyjmuje od jednego do siedmiu parametrów w kolejności: `rok, miesiąc, dzień, godzina, minuty, sekundy, milisekundy`.

## 2. Pobieranie informacji o czasie (Metody `get...`)

Za pomocą specjalnych metod możemy wyciągnąć z obiektu daty konkretne wartości liczbowe. Oto najczęściej używane z nich:

| MetodaOpis      |     |
| --------------- | --- |
| `getFullYear()` |     |

Zwraca pełną liczbę reprezentującą rok (np. 1999 lub 2005).

| `getMonth()` |     |
| ------------ | --- |

Zwraca aktualny miesiąc **(UWAGA: liczony od zera! 0 to styczeń, 1 to luty itd.)**.

| `getDate()` |     |
| ----------- | --- |

Zwraca dzień miesiąca (wartość z przedziału od 1 do 31).

| `getDay()` |     |
| ---------- | --- |

Zwraca dzień tygodnia **(0 to niedziela, 1 to poniedziałek, 2 to wtorek itd.)**.

| `getHours()` |     |
| ------------ | --- |

Zwraca aktualną godzinę (wartość z przedziału od 0 do 23).

| `getMinutes()` |     |
| -------------- | --- |

Zwraca minuty (wartość z przedziału od 0 do 59).

| `getSeconds()` |     |
| -------------- | --- |

Zwraca aktualną liczbę sekund (wartość z przedziału od 0 do 59).

| `getMilliseconds()` |     |
| ------------------- | --- |

Zwraca milisekundy (wartość z przedziału od 0 do 999).

| `getTime()` |     |
| ----------- | --- |

Zwraca aktualny czas jako liczbę milisekund, które upłynęły od godziny 00:00 1 stycznia 1970 roku.

| `getYear()` |     |
| ----------- | --- |

_(Przestarzała)_ Zwraca rok: dla lat 1900–1999 zwraca liczbę 2-cyfrową (np. 99), a dla późniejszych 4-cyfrową (np. 2002). Zamiast niej zawsze lepiej używać `getFullYear()`.

### Przykład użycia – wyświetlenie obecnego roku:

Aby pobrać i wypisać na stronie dzisiejszy rok, piszemy:

JavaScript

```
var now = new Date();
var rok = now.getFullYear();
document.write(rok);

```

## 3. Zmienianie czasu (Metody `set...`)

Obiekt `Date` pozwala nie tylko odczytywać czas, ale także go modyfikować za pomocą metod ustawiających:

- `setYear()` – ustawia dwie ostatnie cyfry roku.

- `setMonth()` – ustawia miesiąc.

- `setDay()` – ustawia dzień miesiąca.

- `setHour()` – ustawia godzinę.

- `setMinutes()` – ustawia minutę.

- `setSeconds()` – ustawia sekundy.
