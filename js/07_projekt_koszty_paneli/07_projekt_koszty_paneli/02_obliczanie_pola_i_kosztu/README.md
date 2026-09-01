> **Krok 2 z 3** | [Krok 1](../01_pobieranie_danych_i_walidacja/README.md) upewnił się, że dane są poprawne. Teraz **Skrypt (część 2)**: obliczenie pola powierzchni i kosztu montażu.

---

# Kompletny przewodnik: Skrypt (część 2) — obliczanie pola powierzchni i kosztu montażu (na podstawie tabeli 1)

---

## Wprowadzenie — o co chodzi w tej części zadania?

Mając już pewność, że dane wejściowe są poprawne (dzięki Modułowi 1), skrypt może przejść do właściwych obliczeń matematycznych. Tutaj dzieje się coś bardzo typowego dla kalkulatorów kosztowych: najpierw liczymy "ile czego potrzeba" (pole powierzchni w metrach kwadratowych), a potem mnożymy to przez "cenę za jednostkę", żeby otrzymać całkowity koszt. Cena za metr kwadratowy zależy od wybranego typu panelu — dokładnie te wartości (12, 14 i 18 złotych) pochodzą z ostatniej kolumny tabeli kosztów, którą widziałeś na stronie `oferta.html`.

---

## SEC-1: Obliczenie pola powierzchni pomieszczenia

Arkusz: skrypt oblicza pole powierzchni pomieszczenia.

```js
const pole = szerokosc * dlugosc;
```

To najprostszy możliwy wzór geometryczny — pole powierzchni prostokątnego pomieszczenia to po prostu iloczyn jego szerokości i długości. Obie te wartości zostały już pobrane i sprawdzone w Module 1, więc tutaj wystarczy jedno mnożenie. Jeśli np. `szerokosc` wynosi `4` metry, a `dlugosc` wynosi `5` metrów, to `pole` wyniesie `20` metrów kwadratowych.

---

## SEC-2: Ustalenie kosztu za metr kwadratowy zależnie od typu panelu

Arkusz: skrypt oblicza koszt montażu, uwzględniając pole powierzchni oraz typ panelu i koszt z tabeli 1.

```js
let kosztZaM2 = 0;
if (typPanelu.value === "laminowane") kosztZaM2 = 12;
else if (typPanelu.value === "winylowe") kosztZaM2 = 14;
else if (typPanelu.value === "deska") kosztZaM2 = 18;
```

- **`let kosztZaM2 = 0`** — na początek ustawiamy wartość domyślną `0`. Używamy tu `let` (a nie `const`), bo za chwilę ta zmienna zostanie **zmieniona** w jednym z poniższych warunków — a zmiennych `const` nie da się później przypisać nowej wartości.
- **`typPanelu.value`** — przypomnienie z Modułu 1: `typPanelu` to cały znaleziony element `<input type="radio">`, który został zaznaczony. Jego właściwość `.value` zawiera to, co zostało wpisane w atrybucie `value` danego przycisku w kodzie HTML — czyli jedną z trzech wartości: `"laminowane"`, `"winylowe"` albo `"deska"`.
- Trzy kolejne warunki `if / else if` sprawdzają, **który dokładnie** typ panelu został wybrany, i na tej podstawie przypisują zmiennej `kosztZaM2` odpowiednią stawkę, dokładnie zgodną z ostatnią kolumną tabeli kosztów ze strony `oferta.html`:

| Typ panelu (`value`) | Koszt montażu za m² (z tabeli 1) |
| ---------------------- | ---------------------------------- |
| `"laminowane"`          | 12 zł                               |
| `"winylowe"`            | 14 zł                               |
| `"deska"`               | 18 zł                               |

- Ponieważ w Module 1 upewniliśmy się już, że `typPanelu` na pewno istnieje (czyli **jakiś** przycisk został zaznaczony), dokładnie jeden z tych trzech warunków na pewno się wykona — nie ma potrzeby dodawania końcowego `else`, bo formularz nie pozwala na żadną inną wartość niż te trzy.

---

## SEC-3: Obliczenie całkowitego kosztu montażu

```js
const koszt = pole * kosztZaM2;
```

Ostatni krok obliczeniowy tego modułu to zwykłe mnożenie: pole powierzchni pomieszczenia (obliczone w SEC-1) razy koszt montażu za jeden metr kwadratowy (ustalony w SEC-2). Dla przykładu z pomieszczeniem o polu `20` m² i panelami laminowanymi (`12` zł/m²), koszt montażu wyniósłby `240` złotych.

Ta wartość, razem z wartością `pole`, zostanie wykorzystana w kolejnym module do zbudowania i wyświetlenia komunikatu z wynikiem.

---

👉 **[Krok 3: Wyświetlanie wyniku](../03_wyswietlanie_wyniku/README.md)**
