## 1. Czym jest obiekt zdarzenia (`event` / `e` / `a`)?

Kiedy użytkownik wykonuje jakąkolwiek akcję na stronie (np. klika myszką, przesuwa kursor czy wciska klawisz), przeglądarka automatycznie generuje **obiekt zdarzenia** i przekazuje go jako pierwszy argument do wywołanej funkcji (tzw. *callback*).

### Kod przykładowy:

**JavaScript**

```javascript
function punkty(a) {
    let x = a.clientX;
    let y = a.clientY;
    console.log(x, y);
}
```

### Wyjaśnienie mechanizmu:

* **Argument `a` (często nazywany też `e` lub `event`):** Jest to specjalny obiekt utworzony przez przeglądarkę, pełniący rolę „raportu z miejsca zdarzenia”. Przechowuje on pełny pakiet informacji technicznych – m.in. o tym, który przycisk myszy został wciśnięty, czy trzymano klawisze pomocnicze (Shift, Ctrl, Alt) oraz dokładną pozycję kursora w pikselach.
* **`a.clientX` oraz `a.clientY`:** Wyciągają ze środka obiektu `a` konkretne właściwości (szufladki) odpowiadające za pozycję kursora na osi $X$ (poziomej) i osi $Y$ (pionowej).

## 2. Cztery układy współrzędnych myszy – szczegółowe porównanie

Samo kliknięcie myszą zwraca różne wartości punktu $(0, 0)$ w zależności od tego, jakiej właściwości użyjemy. Wszystkie wartości podawane są w **pikselach**.

### A. `clientX` / `clientY` (Względem widocznego okna – Viewportu)

Mierzy odległość kursora od lewego górnego rogu **widocznej w danym momencie części ekranu**.

* **Punkt startowy $(0, 0)$:** Lewy górny róg widocznej ramki przeglądarki.
* **Wpływ przewijania strony (Scroll):** **NIE uwzględnia scrollowania**.
* **Działanie:** Niezależnie od tego, jak długa jest strona i jak daleko przewiniesz ją w dół, kliknięcie w sam lewy górny róg aktualnie widocznego okna zawsze zwróci `clientX: 0` oraz `clientY: 0`.

### B. `pageX` / `pageY` (Względem całego dokumentu)

Mierzy odległość kursora od lewego górnego rogu **całego dokumentu HTML**.

* **Punkt startowy $(0, 0)$:** Sam początek całej strony internetowej (szczyt dokumentu).
* **Wpływ przewijania strony (Scroll):** **TAK, uwzględnia scrollowanie**.
* **Działanie:** Jeśli strona jest długa i przewiniesz ją w dół o $500\text{ px}$, klikając w lewy górny róg widocznego okna otrzymasz:

  * `clientY = 0` (bo w widocznym oknie to sam szczyt).
  * `pageY = 500` (ponieważ uwzględniono $500\text{ px}$ przewiniętego wcześniej dokumentu).

### C. `screenX` / `screenY` (Względem fizycznego monitora)

Mierzy odległość kursora od lewego górnego rogu **Twój fizycznego ekranu komputera**.

* **Punkt startowy $(0, 0)$:** Lewy górny róg fizycznej matrycy monitora.
* **Wpływ przewijania strony (Scroll):** Nie dotyczy (mierzy przestrzeń całego pulpitu).
* **Zastosowanie:** Przydatne przy tworzeniu aplikacji okienkowych lub sprawdzaniu położenia kursora na całym pulpicie. Jeśli okno przeglądarki jest zmniejszone i przesunięte na środek ekranu, `screenX` i `screenY` zwrócą wysokie wartości nawet przy kliknięciu w krawędź okna przeglądarki.

### D. `offsetX` / `offsetY` (Względem klikniętego elementu)

Mierzy odległość od lewego górnego rogu **konkretnego elementu HTML**, na który nastąpiło kliknięcie (np. przycisku, obrazka czy kontenera `<canvas>`).

* **Punkt startowy $(0, 0):** Lewy górny róg wskazanego elementu.
* **Wpływ przewijania strony (Scroll):** Liczony tylko w obrębie tego jednego elementu.
* **Zastosowanie:** Idealne do tworzenia gier przeglądarkowych, aplikacji do rysowania na `<canvas>` oraz mechanizmów przeciągnij i upuść (*Drag & Drop*). Kliknięcie w lewy górny róg kwadratu o wymiarach $200 \times 200\text{ px}$ da wynik $(0, 0)$ bez względu na to, w którym miejscu strony ten kwadrat się znajduje.

## 3. Zestawienie podsumowujące

```text
+---------------+----------------------------------+------------------------------+-------------------------------------+
| Właściwość    | Punkt startowy (0, 0)            | Czy uwzględnia Scroll?       | Przykładowe zastosowanie            |
+---------------+----------------------------------+------------------------------+-------------------------------------+
| clientX / Y   | Lewy górny róg widocznego okna   | NIE             | Menu podręczne, elementy interfejsu |
| pageX / Y     | Lewy górny róg całego dokumentu  | TAK             | Pozycjonowanie elementów na stronie |
| screenX / Y   | Lewy górny róg monitora          | Nie dotyczy     | Aplikacje okienkowe / multi-screen  |
| offsetX / Y   | Lewy górny róg klikniętego obiektu| W obrębie obiektu| Gry, rysowanie canvas, Drag & Drop  |
+---------------+----------------------------------+------------------------------+---------
```
