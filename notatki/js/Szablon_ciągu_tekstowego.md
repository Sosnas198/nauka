## 1. Czym jest Template Literal i dlaczego powstał?

W klasycznym języku JavaScript (przed standardem ES6 z 2015 roku) tworzenie dynamicznych napisów wymagało stosowania techniki zwanej **konkatenacją**. Polegała ona na łączeniu poszczególnych fragmentów tekstu i zmiennych za pomocą symbolu plusa (`+`) oraz zwykłych cudzysłowów (`"` lub `'`).

### Stary sposób (Konkatenacja):

**JavaScript**

```javascript
let tekst = "Blok numer: " + i + " - wynik końcowy.";
```

- **Problemy starego sposobu:** Łatwo było pominąć spację przed lub po zmiennej, zgubić cudzysłów albo popełnić błąd w składni przy wielokrotnym otwieraniu i zamykaniu ciągów.

## 2. Dwie filarowe zasady składni Template Literals

### A. Użycie grawisów / odwróconych apostrofów (Backticks: `` ` ``)

Zamiast tradycyjnych cudzysłowów (`"` lub `'`) cały ciąg tekstowy zamyka się w **odwróconych apostrofach** (ang. _backticks_).

- **Gdzie znaleźć ten klawisz?** Znajduje się on na klawiaturze w lewym górnym rogu, bezpośrednio pod klawiszem **Escape** (tam, gdzie znajduje się tylda `~`).
- **Rola:** Użycie grawisów sygnalizuje przeglądarce, że wewnątrz danego tekstu będą wykonywane operacje dynamiczne.

### B. Wstrzykiwanie zmiennych i wyrażeń: `${ ... }`

Miejsce, w którym ma pojawić się dynamiczna wartość, oznacza się specjalną „wtyczką” w postaci znaku dolara i nawiasów klamrowych: `${zmienna}`.

### Nowy sposób (Template Literal):

**JavaScript**

```javascript
let tekst = `Blok numer: ${i} - wynik końcowy.`;
```

- **Korzyść:** Tekst pisze się ciągiem, bez konieczności ciągłego dzielenia go plusami, co drastycznie zwiększa czytelność i eliminuje ryzyko zgubienia spacji.

## 3. Szczegółowe omówienie największych zalet Template Literals

### Zaleta 1: Wykonywanie operacji matematycznych i logicznych wewnątrz `${}`

Wewnątrz składni `${}` nie trzeba ograniczać się wyłącznie do wpisania nazwy zmiennej. Można tam wstawić **dowolne prawidłowe wyrażenie JavaScript**, np. proste obliczenia matematyczne, wywołania funkcji czy operatory logiczne.

**JavaScript**

```javascript
let cena = 100;

// Wewnątrz ${} mnożymy cenę przez 1.23, aby od razu wyliczyć kwotę z podatkiem VAT:
console.log(`Cena z podatkiem to: ${cena * 1.23} zł`);
// Wynik w konsoli: Cena z podatkiem to: 123 zł
```

### Zaleta 2: Łatwe tworzenie tekstów wielolinijkowych (Multi-line strings)

W przypadku tworzenia dynamicznych struktur HTML wewnątrz kodu JavaScript, stary sposób wymuszał stosowanie znaków nowej linii `\n` oraz łączenie każdej linijki plusami.

W **Template Literals** wystarczy nacisnąć klawisz **Enter** w edytorze kodu – przeglądarka automatycznie zachowa wszystkie odstępy i przeniesienia do nowej linii dokładnie tak, jak zostały napisane.

#### Porównanie zapisu kodu HTML:

**JavaScript**

```javascript
// Stary, trudny w utrzymaniu sposób:
let htmlStary = "<div>\n" + "   <p>Tekst</p>\n" + "</div>";

// Nowy, czytelny sposób (Template Literal):
let htmlNowy = `
    <div>
        <p>Tekst</p>
    </div>
`;
```

## Podsumowanie zestawieniowe

```text
+---------------------------+-----------------------------------+-----------------------------------+
| Cecha                     | Stary sposób (Konkatenacja)       | Nowy sposób (Template Literals)   |
+---------------------------+-----------------------------------+-----------------------------------+
| Znaki otwierające/łączące | Cudzysłowy " " lub ' ' oraz +     | Backticki ` `                     |
| Wstawianie zmiennych      | "Tekst " + zmienna + " tekst"     | `Tekst ${zmienna} tekst`          |
| Wyrażenia matematyczne    | "Suma: " + (a + b)                | `Suma: ${a + b}`                  |
| Wielolinijkowość          | Wymaga znaków \n oraz plusów      | Wystarczy wcisnąć Enter
```
