// [ZOBACZ W README: SEC-1]
function prevImage() {
    currentImageIndex = (currentImageIndex - 1 + imageArray.length) % imageArray.length;
    updateImage();
}

// [ZOBACZ W README: SEC-2]
function nextImage() {
    currentImageIndex = (currentImageIndex + 1) % imageArray.length;
    updateImage();
}
