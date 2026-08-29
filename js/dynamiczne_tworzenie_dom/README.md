# Dynamiczne tworzenie i wstawianie elementów HTML

### Jak to działa:

1. `document.createElement("tag")` – tworzy nowy znacznik HTML w pamięci.
2. Nadajemy mu potrzebne atrybuty (`src`, `alt`, `classList.add()`).
3. `rodzic.appendChild(dziecko)` – wstawia stworzony element na stronę na koniec wskazanego rodzica.

### Przykład:

Tworzenie nowego obrazka `<img>` i dodawanie go do sekcji `<section id="galeria">`.
