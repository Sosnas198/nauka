Pętle (czyli potocznie instrukcje iteracyjne) to specjalne konstrukty służące do wykonywania powtarzających się czynności, dzięki czemu nie musisz pisać tego samego kodu ręcznie po stokroć. Iteracja to po prostu powtarzanie.

W programowaniu do dyspozycji mamy trzy główne rodzaje pętli: `for`, `while` oraz `do while`.

## 1. Pętla `for` (Gdy wiesz, ile razy chcesz coś powtórzyć)

Pętlę typu `for` stosuje się wtedy, gdy z góry **znasz liczbę wykonań pętli** oraz znasz warunek, który musi być spełniony, aby pętla ruszyła kolejny raz.

- **Jak wygląda składnia:**

  JavaScript

  ```
  for(wyrażenie początkowe; wyrażenie warunkowe; wyrażenie modyfikujące) {
      blok instrukcji;
  }

  ```

- **Co to oznacza w praktyce:**
  - **Wyrażenie początkowe** – uruchamia i ustawia zmienną, która służy jako licznik pętli.
  - **Wyrażenie warunkowe** – pilnuje, czy warunek jest spełniony; jeśli tak, pętla kręci się dalej.
  - **Wyrażenie modyfikujące** – zmienia wartość licznika po każdym obrocie.

## 2. Pętla `while` (Gdy nie znasz liczby powtórzeń)

Pętla `while` jest używana najczęściej wtedy, gdy **liczba powtórzeń nie jest znana** z góry.

- **Jak wygląda składnia:**

  JavaScript

  ```
  while (wyrażenie warunkowe) {
      blok instrukcji;
  }

  ```

- **Jak to działa:** Blok instrukcji wykonuje się w kółko tak długo, dopóki wyrażenie warunkowe jest prawdziwe. Konstrukcję tę można przetłumaczyć na polski jako: _„Dopóki wyrażenie warunkowe jest prawdziwe, wykonuj instrukcje”_.

## 3. Pętla `do while` (Zawsze chociaż jeden obrót)

Pętla `do while` to bliska kuzynka zwykłej pętli `while` – również stosuje się ją wtedy, gdy liczba powtórzeń nie jest znana.

- **Jak wygląda składnia:**

  JavaScript

  ```
  do {
      blok instrukcji;
  }
  while (wyrażenie warunkowe);

  ```

- **Czym się różni?** W pętli `do while` blok instrukcji wykona się **co najmniej jeden raz**, nawet jeśli warunek podany w nawiasie od samego początku jest fałszywy. Dzieje się tak dlatego, że komputer najpierw wykonuje ciąg instrukcji, a dopiero na samym końcu sprawdza warunek.
