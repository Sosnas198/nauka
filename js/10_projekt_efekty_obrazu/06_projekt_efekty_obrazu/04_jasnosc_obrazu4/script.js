function jasnosc() {
    const img = document.querySelector('#blok4 img');
    const jasnoscValue = document.getElementById('jasnosc').value;
    img.style.filter = `brightness(${jasnoscValue}%)`;
}
