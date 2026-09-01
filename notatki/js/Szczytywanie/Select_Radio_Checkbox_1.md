# 1. Lista rozwijalna (`<select>`)

Lista rozwijalna pozwala na wybór **jednej** opcji spośród dostępnych elementów `<option>`.

### Kod HTML:

**HTML**

```html
<select id="lista">
    <option value="wybierz">wybierz z listy</option>
    <option value="wart1">lista1</option>
    <option value="wart2">lista2</option>
    <option value="wart3">lista3</option>
</select>
```

### Odczyt w JavaScript:

Z racji tego, że lista zwraca bezpośrednio jedną wybraną wartość, sczytujemy ją bezpośrednio przez właściwość `.value` przypisaną do całego kontenera `<select>`.

**JavaScript**

```javascript
var lista = document.getElementById('lista');

// Wyświetlenie aktualnie wybranej wartości
document.write(lista.value);
```

> **Warto pamiętać:** Właściwość `lista.value` zwraca ciąg znaków z atrybutu `value` aktualnie zaznaczonego tagu `<option>`.

---

# 2. Pole wyboru (`<checkbox>`)

Pole typu `checkbox` umożliwia niezależne zaznaczanie **wielu opcji naraz**. Każde pole posiada swój unikalny identyfikator `id`.

### Kod HTML:

**HTML**

```html
<input type="checkbox" id="pole1" value="wart1">Wybór 1<br>
<input type="checkbox" id="pole2" value="wart2">Wybór 2<br>
```

### Odczyt w JavaScript:

Do każdego pola odwołujemy się osobno. Kluczowa jest tu właściwość logiczna `.checked`, która zwraca `true` (jeśli pole jest zaznaczone) lub `false` (jeśli nie jest).

**JavaScript**

```javascript
var wart1 = document.getElementById('pole1');
var wart2 = document.getElementById('pole2');

// Sprawdzamy stan pierwszego pola
if (wart1.checked) {
    document.write(wart1.value);
}

// Sprawdzamy stan drugiego pola
if (wart2.checked) {
    document.write(wart2.value);
}
```

---

# 3. Pole opcji (`<radio>`)

Grupa przycisków radio pozwala na wybór **tylko jednej opcji** z danego zbioru. Wszystkie przyciski należące do tej samej grupy muszą mieć identyczną wartość atrybutu `name`.

### Kod HTML:

**HTML**

```html
<input type="radio" name="opcja" value="wart1">opcja1<br>
<input type="radio" name="opcja" value="wart2">opcja2<br>
<input type="radio" name="opcja" value="wart3">opcja3<br>
```

### Odczyt w JavaScript:

Ponieważ elements mają tę samą nazwę, pobieramy je jako tablicę/kolekcję za pomocą metody `getElementsByName()`. Następnie przechodzimy przez całą grupę pętlą `for`, by odnaleźć ten element, który ma właściwość `checked == true`.

**JavaScript**

```javascript
// Pobieramy całą grupę elementów o name="opcja"
var opcja = document.getElementsByName('opcja');

// Przechodzimy po wszystkich elementach w grupie
for (var i = 0; i < opcja.length; i++) {
    // Sprawdzamy, który przycisk został zaznaczony przez użytkownika
    if (opcja[i].checked) {
        document.write(opcja[i].value);
    }
}
```

---

# Podsumowanie różnic

| **Typ pola**                  | **Liczba wyborów**   | **Sposób wyszukiwania w DOM** | **Pobierana właściwość**         |
| ----------------------------- | -------------------- | ----------------------------- | -------------------------------- |
| **`<select>`**                | Jeden wybór          | `getElementById('id')`        | `.value` z kontenera             |
| **`<input type="checkbox">`** | Wiele wyborów        | `getElementById('id')`        | `.checked` oraz `.value`         |
| **`<input type="radio">`**    | Wykluczający (jeden) | `getElementsByName('name')`   | Pętla + `.checked` oraz `.value` |
