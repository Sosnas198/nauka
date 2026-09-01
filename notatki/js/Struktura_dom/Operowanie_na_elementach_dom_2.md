# 🛠️ Metoda `setAttribute()` – Uniwersalny pilot do atrybutów HTML

Metoda `setAttribute(nazwaAtrybutu, wartosc)` to jeden z najbardziej uniwersalnych mechanizmów w DOM. Pozwala na modyfikację struktury kodu HTML bezpośrednio z poziomu JavaScriptu, obsługując niemal każdy atrybut, jaki istnieje w specyfikacji HTML.

## 1. Zarządzanie multimediami i linkami (Podstawowe atrybuty)

To najczęstsze zastosowanie tej metody. Służy do dynamicznej zmiany źródeł obrazków, filmów czy celów odnośników, na przykład na podstawie działań lub kliknięć użytkownika.

### JavaScript

```javascript
const obrazek = document.querySelector("img");
const link = document.querySelector("a");

// Zmiana wyświetlanego zdjęcia i opisu alternatywnego
obrazek.setAttribute("src", "img/pies.jpg");
obrazek.setAttribute("alt", "Zdjęcie słodkiego psa");

// Zmiana celu linku oraz wymuszenie otwarcia w nowej karcie
link.setAttribute("href", "https://github.com");
link.setAttribute("target", "_blank");
```

## 2. Zmiana stylów i identyfikatorów (Id i Klasy)

Choć do zarządzania klasami lepiej używać właściwości `classList`, a do stylów `.style`, to technicznie rzecz biorąc `setAttribute` również potrafi nimi zarządzać.

### JavaScript

```javascript
const element = document.querySelector("div");

// Nadanie lub zmiana ID elementu
element.setAttribute("id", "nowe-glowne-pudelko");

// Nadanie klas (Uwaga: ta metoda całkowicie nadpisuje stare klasy!)
element.setAttribute("class", "alert alert-success");

// Wstrzyknięcie surowego kodu CSS bezpośrednio jako styl inline
element.setAttribute("style", "display: block; color: blue; padding: 10px;");
```
