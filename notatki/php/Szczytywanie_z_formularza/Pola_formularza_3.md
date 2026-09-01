## 1. Jak przygotować pole Checkbox w HTML?

Aby PHP mogło poprawnie odebrać zaznaczone przez użytkownika opcje, musisz w kodzie HTML spełnić dwa kluczowe warunki:

- Każde pole musi posiadać atrybut `value` określający wartość, jaka ma zostać przesłana.
- Atrybut `name` musi obowiązkowo kończyć się pustymi nawiasami kwadratowymi `[]` (np. `name="nazwa[]"`). Dzięki temu PHP automatycznie wie, że ma spakować wszystkie zaznaczone opcje do jednej wspólnej tablicy.

Przykład poprawnego formularza:

### HTML

```html
<form action="" method="post">
  <input type="checkbox" name="nazwa[]" value="wart1" />wart1<br />
  <input type="checkbox" name="nazwa[]" value="wart2" />wart2<br />
  <input type="checkbox" name="nazwa[]" value="wart3" />wart3<br />
  <input type="submit" value="Wyślij" />
</form>
```

## 2. Jak odbieramy dane w PHP?

Gdy użytkownik zaznaczy okienka i kliknie przycisk wysyłania, dane odbierasz w pliku PHP za pomocą standardowej superglobalnej tablice (`$_POST` lub `$_GET`):

### PHP

```php
<?php
$zmienna = $_POST['nazwa'];
```

- Otrzymana w ten sposób zmienna `$zmienna` **nie jest zwykłym tekstem, lecz tablicą** przechowującą wszystkie pozycje zaznaczone przez użytkownika.
