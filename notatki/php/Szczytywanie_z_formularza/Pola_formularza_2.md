## 1. Pole opcji (Radio) – `<input type="radio">`

Pole typu radio pozwala użytkownikowi zaznaczyć tylko jedną opcję z przygotowanej puli.

- **Zasada działania:** Wszystkie pola opcji, które należą do tej samej grupy (np. wybór płci czy oceny), muszą posiadać **dokładnie taką samą nazwę** w atrybucie `name`.
- **Wynik:** Po wysłaniu formularza skrypt otrzymuje tylko jedną wartość – tę, którą zaznaczył użytkownik.

### Przykład kodu (HTML + PHP):

### HTML

```html
<form action="" method="post">
  <input type="radio" name="radio" value="opcaj1" />opcja 1<br />
  <input type="radio" name="radio" value="opcaj2" />opcja 2<br />
  <input type="radio" name="radio" value="opcaj3" />opcja 3<br />
  <input type="submit" value="klik" />
</form>

<?php $zmienna = $_POST['radio']; echo $zmienna; ?>
```

- Wybraną wartość wyciągamy z tablicy `$_POST['radio']` i możemy ją od razu wyświetlić na ekranie.

## 2. Lista rozwijalna (Select) – `<select>` i `<option>`

Lista rozwijalna pozwala zaoszczędzić miejsce na stronie, chowając opcje w menu, które rozwija się po kliknięciu.

- **Atrybut** **`name`\*\***:\*\* W przeciwieństwie do pól radio, tutaj nazwę (`name`) definiujemy w głównym znaczniku `<select>`, a nie w pojedynczych opcjach.
- **Odczyt:** Wartości z listy sczytujemy w PHP dokładnie tak samo jak zwykłe pole tekstowe.
- **Co trafia do skryptu:** Lista zwraca jedną wybraną wartość – domyślnie jest to tekst znajdujący się pomiędzy znacznikami `<option>`, a `</option>`, chyba że w znaczniku `<option>` dopiszemy własny atrybut `value="..."`.

### Przykład kodu (HTML + PHP):

### HTML

```html
<form action="" method="post">
  <select name="lista" id="">
    <option value="">Wybierz</option>
    <option value="opcja 1">opcja 1</option>
    <option value="opcja 2">opcja 2</option>
    <option value="opcja 3">opcja 3</option>
  </select>
  <input type="submit" value="klik" />
</form>

<?php $zmienna = $_POST['lista']; echo $zmienna; ?>
```

- Wybrana pozycja z listy trafia do zmiennej `$zmienna` poprzez odwołanie do `$_POST['lista']`.
