# Pobieranie nazwy wybranego pliku w JS

### Jak to działa:

Gdy używasz pola `<input type="file">`, przeglądarka przechowuje wybrane pliki w tablicy `files`.
Najprostszym sposobem na pobranie nazwy pliku (np. `smok.png`) bez ścieżki dostępowej jest użycie właściwości `.files[0].name`.

### Przykład użycia:

- `input.files[0]` - odwołuje się do pierwszego wybranego pliku.
- `input.files[0].name` - wyciąga tylko samą nazwę pliku jako tekst.
