### 1. `join(separator)` — Scalanie tablicy w tekst

Łączy elementy tablicy w jeden ciąg tekstowy.

* Parametr `separator` jest opcjonalny. Jeśli nie zostanie podany, domyślnie używany jest przecinek.

**JavaScript**

```javascript
var tablica = ["Marcin", "Ania", "Agnieszka", "Marek"];

document.write(tablica.join());    // "Marcin,Ania,Agnieszka,Marek"
document.write(tablica.join(":"));  // "Marcin:Ania:Agnieszka:Marek"
document.write(tablica.join(" ")); // "Marcin Ania Agnieszka Marek"
```

### 2. Spread syntax (`...`) — Rozbijanie na składowe

Umożliwia rozbicie iterowalnej wartości (tablicy lub łańcucha znaków) na pojedyncze elementy.

**JavaScript**

```javascript
// Rozbijanie tekstu na tablicę liter
var tekst = "Ala ma kota";
var tablica = [...tekst]; // ["A", "l", "a", " ", "m", "a", " ", "k", "o", "t", "a"]
```

### 3. `split(separator)` — Rozdzielenie tekstu na tablicę

Dzieli łańcuch znaków na tablicę elementów na podstawie wskazanego separatora.

**JavaScript**

```javascript
var tekst = "Ala ma kota";
var tablica = tekst.split(" "); // ["Ala", "ma", "kota"]
```

### 4. Wyszukiwanie elementów w tablicy

* **`indexOf(szukanyElement)`**: Zwraca indeks pierwszego wystąpienia elementu lub `-1`, jeśli element nie istnieje.

**JavaScript**

```javascript
var tablica = ["Marcin", "Ania", "Agnieszka", "Marek"];

if (tablica.indexOf("Ania") !== -1) {
    document.write("Znaleziono na indeksie: ", tablica.indexOf("Ania")); // 1
}
```

* **`lastIndexOf(szukanyElement)`**: Działa jak `indexOf()`, ale zwraca indeks **ostatniego** wystąpienia elementu w tablicy.

**JavaScript**

```javascript
var tablica = ["Agnieszka", "Marcin", "Ania", "Agnieszka", "Marek"];
var numer = tablica.lastIndexOf("Agnieszka"); // 3
```

### 5. `concat()` — Łączenie tablic

Tworzy nową tablicę poprzez połączenie dwóch lub więcej tablic.

**JavaScript**

```javascript
var domowe = ["Pies", "Kot"];
var podworkowe = ["Kura", "Kaczka"];
var ptaki = ["Sroka", "Kawka"];

var polaczone1 = domowe.concat(podworkowe); 
// ["Pies", "Kot", "Kura", "Kaczka"]

var polaczone2 = domowe.concat(podworkowe, ptaki); 
// ["Pies", "Kot", "Kura", "Kaczka", "Sroka", "Kawka"]
```

### 6. `splice(index, ileUsunąć, noweElementy...)` — Modyfikacja zawartości tablicy

Pozwala usuwać, dodawać lub jednocześnie zastępować elementy w określonym miejscu tablicy:

* **`index`**: Miejsce rozpoczęcia operacji.
* **`ileUsunąć`**: Liczba elementów do usunięcia (wartość `0` oznacza brak usuwania).
* **`noweElementy`** *(opcjonalnie)*: Elementy wstawiane w miejsce operacji.

#### Przykłady zastosowania:

* **Usuwanie elementów:**

**JavaScript**

```javascript
var tablica = ["Marcin", "Ania", "Agnieszka", "Marek"];

tablica.splice(2, 1); // Usuwa 1 element od indeksu 2
// Wynik: ["Marcin", "Ania", "Marek"]
```

* **Wstawianie elementów:**

**JavaScript**

```javascript
var tablica = ["Marcin", "Ania", "Agnieszka", "Marek"];

tablica.splice(2, 0, "Ola", "Adam"); // Wstawia 2 elementy od indeksu 2 bez usuwania
// Wynik: ["Marcin", "Ania", "Ola", "Adam", "Agnieszka", "Marek"]
```

* **Jednoczesne usuwanie i zastępowanie:**

**JavaScript**

```javascript
var tablica = ["Marcin", "Ania", "Agnieszka", "Marek", "Piotr", "Ewa"];

tablica.splice(1, 3, "Ola", "Adam"); // Usuwa 3 elementy od indeksu 1 i wstawia 2 nowe
// Wynik: ["Marcin", "Ola", "Adam", "Piotr", "Ewa"]
```

### Podsumowanie weryfikacji błędów w kodzie ze źródła:

W dostarczonym pliku znajduje się kilka drobnych literówek syntaktycznych w skryptach przykładowych:

1. W przykładzie z `concat()` użyto nawiasu okrągłego `)` zamiast kwadratowego `]` przy definicji tablicy `podworkowe` oraz pominięto operator przypisania `=` przy definicji tablic `ptaki`, `tablica1` i `tablica2`.
2. W przykładzie z `indexOf()` zmienna wywołująca została nazwana `tablica3`, podczas gdy zdefiniowano `tablica`.
3. W przykładzie z `lastIndexOf()` zmienna `numer` nie miała przypisanej wartości przed sprawdzeniem jej w warunku.
