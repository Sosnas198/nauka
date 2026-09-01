> **Krok 4 z 5** | [W Kroku 3](../03_dane_potrawy_i_trudnosc/README.md) pokazaliśmy jedną potrawę. Teraz **Skrypt 3**: wiele alergenów, tabela łącząca i pętla `while`.

---

# Kompletny przewodnik: Skrypt 3 — alergeny oddzielone spacją

Ta ściąga wytłumaczy Ci **od A do Z** relację wiele-do-wielu między potrawami a alergenami oraz wypisywanie **wielu** nazw w jednej linii.

---

## SEC-1: Tabela łącząca `lista_alergenow`

- Jedna potrawa może mieć **wiele** alergenów.
- Jeden alergen (np. gluten) może dotyczyć **wielu** potraw.

To relacja **N:M**. Para kluczy siedzi w tabeli pośredniczącej, np. `lista_alergenow` (`idPotrawy`, `idAlergeny`).

Nazwy alergenów są w tabeli `alergeny`, nie w `potrawy`.

---

## SEC-2: Zapytanie 3 zmodyfikowane o zmienną ID

Arkusz: wyślij **zapytanie 3**, tak zmodyfikowane, że sprawdzana jest zmienna ID.

```sql
SELECT potrawy.nazwa, alergeny.alergen
FROM potrawy
JOIN lista_alergenow ON potrawy.idPotrawy = lista_alergenow.idPotrawy
JOIN alergeny ON lista_alergenow.idAlergeny = alergeny.idAlergeny
WHERE potrawy.idPotrawy = $id;
```

### Rozbicie JOIN-ów

1. `potrawy` + `lista_alergenow` po `idPotrawy` — które alergeny są przypisane do tej potrawy.
2. `lista_alergenow` + `alergeny` po `idAlergeny` — jak się ten alergen nazywa.

`WHERE potrawy.idPotrawy = $id` zostawia tylko bieżący przepis.

Wynik: **wiele wierszy** (po jednym na alergen), nie jeden.

---

## SEC-3: Pętla `while` i `$row["alergen"]`

Tu **musisz** użyć pętli — w przeciwieństwie do Skryptów 1, 2 i 4.

```php
while ($row = $result->fetch_assoc()) {
    echo $row["alergen"] . " ";
}
```

Każde `fetch_assoc()` zdejmuje kolejny wiersz. Gdy wiersze się skończą, funkcja zwraca `false` i pętla się kończy.

---

## SEC-4: Oddzielenie spacją (wymóg arkusza)

Arkusz: wyświetl **oddzielone spacją** nazwy wszystkich alergenów.

W praktyce po każdej nazwie dajesz spację (`. " "`). Na stronie może zostać spacja na końcu — na egzaminie jest to akceptowane.

Kontrolka owija wynik w paragraf z etykietą:

```php
echo "<p>Alergeny: ";
while ($row = $result->fetch_assoc()) {
    echo $row["alergen"] . " ";
}
echo "</p>";
```

Rdzeń zadania to same nazwy ze spacją; etykieta `Alergeny:` pasuje do układu witryny.

---

# Podsumowanie przepływu danych

```text
JOIN potrawy → lista_alergenow → alergeny
WHERE idPotrawy = $id
                 ↓
$result (wiele wierszy)
                 ↓
while fetch_assoc()
                 ↓
echo alergen + spacja
```

---

# Ściągawka z najważniejszych pojęć

| **Pojęcie / Element**   | **Co oznacza / Co robi?**                                   |
| ----------------------- | ----------------------------------------------------------- |
| **`lista_alergenow`**   | Tabela łącząca potrawy z alergenami (N:M).                  |
| **Podwójny `JOIN`**     | Najpierw powiązania, potem nazwy z `alergeny`.              |
| **`while`**             | Obowiązkowa, bo alergenów jest wiele.                       |
| **Spacja**              | Separator między nazwami wymagany w arkuszu.                |

---

### Co dalej?

Ostatni krok: **Skrypt 4** — treść przepisu i plik tła sekcji.

👉 **[Przejdź do Kroku 5: Przepis i tło CSS](../05_przepis_i_tlo_css/README.md)**
