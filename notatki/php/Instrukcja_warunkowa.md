## 1. Instrukcja warunkowa (`if`, `else`, `elseif`)

Instrukcja warunkowa to jedno z najczęściej stosowanych wyrażeń programistycznych. W zależności od tego, czy warunek zwróci prawdę (`true`) czy fałsz (`false`), komputer wykonuje odpowiedni blok kodu.

### Podstawowa wersja (`if`)

Pozwala wykonać kod tylko wtedy, gdy warunek jest prawdziwy:

PHP

```php
if (wyrażenie_warunkowe) {
    // instrukcja wykonywana, jeśli spełniony zostanie warunek
}

```

### Wersja rozbudowana (`if ... else`)

Daje możliwość obsłużenia sytuacji alternatywnej. Jeśli warunek jest prawdziwy, wykonuje się `instrukcja_1`; w przeciwnym razie (gdy warunek to `false`) uruchamiana jest `instrukcja_2`:

PHP

```php
if (wyrażenie_warunkowe) {
    // instrukcja_1 wykonywana, jeśli spełniony zostanie warunek
} else {
    // instrukcja_2 wykonywana, jeśli warunek nie zostanie spełniony
}

```

### Wersja wielostopniowa (`if ... elseif ... else`)

Składa się z kilku następujących po sobie warunków:

PHP

```php
if (wyrażenie_warunkowe_1) {
    // instrukcja_1 wykonywana, jeśli spełniony zostanie pierwszy warunek
} elseif (wyrażenie_warunkowe_2) {
    // instrukcja_2 wykonywana, jeśli spełniony zostanie drugi warunek, a pierwszy nie
} else {
    // instrukcja wykonywana, jeśli nie zostanie spełniony żaden z warunków
}

```

## 2. Instrukcja wyboru (`switch`)

Instrukcja wyboru `switch` działa podobnie do najbardziej rozbudowanej wersji instrukcji warunkowej, ale jest czytelniejsza, gdy sprawdzamy jedną zmienną pod kątem wielu konkretnych wartości.

- Na początku ustalana jest wartość zmiennej (`$zmienna`), która jest kolejno porównywana z wartościami wprowadzonymi dla poszczególnych przypadków (`case`).
- Jeżeli wartość jest równa zmiennej, wykonywane są instrukcje dla danego przypadku, aż do napotkania słowa kluczowego `break`, które przerywa działanie instrukcji `switch` i pozwala opuścić blok.
- Etykieta `default` działa jak ostateczne zabezpieczenie – jej instrukcje zostaną wykonane wtedy, gdy żadna z wcześniejszych wartości nie będzie pasować do sprawdzanej zmiennej.

PHP

```php
switch ($zmienna) {
    case 'wartość1':
        // instrukcje
        break;
    case 'wartość2':
        // instrukcje
        break;
    default:
        // instrukcje domyślne
}
```
