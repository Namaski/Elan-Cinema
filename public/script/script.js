const genreList = document.querySelector('.genre__list-cards');
const images = document.querySelectorAll('.genre__card img');

let isDragging = false;
let startX;
let scrollLeft;


images.forEach((img) => {
    img.addEventListener('dragstart', (e) => e.preventDefault());
});

genreList.addEventListener('mousedown', (e) => {
    isDragging = true;
    startX = e.pageX - genreList.offsetLeft;
    scrollLeft = genreList.scrollLeft;
    genreList.style.cursor = 'grabbing';
});

genreList.addEventListener('mouseleave', () => {
    isDragging = false;
    genreList.style.cursor = 'grab';
});

genreList.addEventListener('mouseup', () => {
    isDragging = false;
    genreList.style.cursor = 'grab';
});

genreList.addEventListener('mousemove', (e) => {
    if (!isDragging) return;
    e.preventDefault();
    const x = e.pageX - genreList.offsetLeft;
    const walk = (x - startX) * 2;
    genreList.scrollLeft = scrollLeft - walk;
});
