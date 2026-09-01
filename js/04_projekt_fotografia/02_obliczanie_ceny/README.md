> **Krok 2 z 3** | [Krok 1](../01_pobieranie_danych_z_kontrolek/README.md) pobrał `copies` i `paperType`. Teraz **Skrypt 2**: cena za kopię i cena łączna.

---

# Kompletny przewodnik: Skrypt 2 — obliczanie ceny wg liczby kopii i rodzaju papieru

---

## SEC-1: Cennik za kopię

Arkusz: dla papieru błyszczącego cena jednostkowa wynosi **1,5 zł**, dla papieru matowego – **2 zł**.

```js
const pricePerCopy = {
    blyszczacy: 1.5,
    matowy: 2
}
```

| Rodzaj papieru | Wartość `value` (radio) | Cena za kopię |
| -------------- | ------------------------ | -------------- |
| Błyszczący     | `blyszczacy`              | 1,5 zł          |
| Matowy         | `matowy`                  | 2 zł            |

Obiekt `pricePerCopy` pozwala odczytać cenę jednostkową po kluczu równym wartości zaznaczonego radiobuttona.

---

## SEC-2: Cena jednostkowa i cena całkowita

```js
const unitPrice = pricePerCopy[paperType] ?? pricePerCopy.blyszczacy
const totalPrice = (copies * unitPrice)
```

- **`pricePerCopy[paperType]`** — dostęp do ceny po kluczu (nazwie rodzaju papieru z Skryptu 1).
- **`?? pricePerCopy.blyszczacy`** — zabezpieczenie: gdyby `paperType` nie pasował do żadnego klucza, przyjmowana jest cena papieru błyszczącego.
- **`totalPrice`** — iloczyn liczby kopii i ceny jednostkowej; to wartość, która trafi później do paragrafu „Cena: ”.

---

👉 **[Krok 3: Tworzenie elementów koszyka](../03_tworzenie_elementow_koszyka/README.md)**
