function przezroczystosc() {
    const img = document.querySelector('#blok3 img');
    const przezroczystoscValue = document.getElementById('przezroczystosc').value;
    img.style.filter = `opacity(${przezroczystoscValue}%)`;
}
