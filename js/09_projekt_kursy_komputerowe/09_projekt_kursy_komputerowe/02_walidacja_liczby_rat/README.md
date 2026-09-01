> **Krok 2 z 3** | [Krok 1](../01_pobieranie_danych_i_kwota_calkowita/README.md) ustalił kwotę całkowitą. Teraz **Skrypt (część 2)**: sprawdzenie, czy podano poprawną liczbę rat.

---

# Kompletny przewodnik: Skrypt (część 2) — walidacja liczby rat i częściowy wynik (`isNaN`, wcześniejszy `return`)

---

## Wprowadzenie — o co chodzi w tej części zadania?

Skoro wiemy już (dzięki Modułowi 1), że użytkownik wybrał przynajmniej jeden kurs i mamy policzoną kwotę całkowitą, kolejnym krokiem jest sprawdzenie **drugiej** wymaganej informacji: liczby rat, na jaką ma zostać podzielona ta kwota. Ten moduł jest ciekawy dlatego, że pokazuje sytuację "pośrednią" — gdy część danych jest już znana i można ją pokazać użytkownikowi, mimo że reszta obliczeń (wysokość pojedynczej raty) jeszcze się nie odbyła, bo brakuje do niej poprawnej liczby rat.

---

## SEC-1: Sprawdzenie poprawności liczby rat

Arkusz nie precyzuje wprost komunikatu na wypadek błędnej liczby rat, ale wymaga, żeby skrypt sensownie obsługiwał sytuację, gdy nie da się obliczyć raty (np. przy braku tej wartości).

```js
if (isNaN(liczbaRat) || liczbaRat < 1) {
    wynik.textContent = `Kurs odbędzie się w ${miasto}. Koszt całkowity: ${kwotaCalkowita} zł.`;
    return;
}
```

- **`isNaN(liczbaRat)`** — przypomnienie z poprzednich modułów: `parseInt` (użyty w Module 1, SEC-1) zwraca specjalną wartość `NaN` ("Not a Number"), jeśli nie udało się odczytać żadnej sensownej liczby z pola — na przykład wtedy, gdy pole „Liczba rat” zostało pozostawione puste. Funkcja `isNaN(...)` sprawdza właśnie, czy dana wartość jest taką "nie-liczbą".
- **`liczbaRat < 1`** — dodatkowe zabezpieczenie: nawet jeśli `parseInt` zwrócił jakąś liczbę, to liczba rat mniejsza niż 1 (czyli `0` albo liczba ujemna) nie ma żadnego sensu — nie da się przecież zapłacić za kurs w "zero rat" albo w "minus dwie raty".
- **`||`** — operator "lub": warunek jest prawdziwy, jeśli **którakolwiek** z tych dwóch sytuacji zachodzi (brak poprawnej liczby **lub** liczba mniejsza od 1).
- Jeżeli warunek jest prawdziwy, skrypt **nie przerywa** działania z pustym komunikatem błędu (tak jak robiły to poprzednie projekty) — zamiast tego wyświetla **częściowy**, ale w pełni sensowny wynik: informację o mieście, w którym odbędzie się kurs, oraz o obliczonej już wcześniej (w Module 1) kwocie całkowitej. Jedyne, czego w tym komunikacie brakuje, to informacja o racie — bo bez poprawnej liczby rat nie da się jej obliczyć.
- Po wyświetleniu tego częściowego komunikatu funkcja kończy działanie instrukcją `return`, więc obliczenie właściwej raty (Moduł 3) w ogóle się nie wykonuje.

To bardzo praktyczne podejście: zamiast pokazywać użytkownikowi ogólnikowy komunikat "błąd" albo nic nie wyświetlać, skrypt pokazuje **tyle informacji, ile faktycznie da się w tym momencie ustalić** — miasto i cenę całkowitą, pomijając jedynie tę część, której nie da się policzyć bez poprawnej liczby rat.

---

👉 **[Krok 3: Obliczanie raty i wyświetlanie pełnego wyniku](../03_obliczanie_raty_i_wyswietlanie/README.md)**
