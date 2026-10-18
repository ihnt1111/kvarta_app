document.addEventListener('DOMContentLoaded', () => {
    const track = document.getElementById('carouselTrack');
    if (!track) return;

    const images = track.querySelectorAll('img');
    if (images.length === 0) return;

    let currentIndex = 0;

    setInterval(() => {
        currentIndex++;

        if (currentIndex >= images.length) {

            track.style.transition = 'none';
            track.style.transform = 'translateX(0)';
            currentIndex = 0;


            setTimeout(() => {
                track.style.transition = 'transform 0.6s ease-in-out';
            }, 50);
        } else {

            track.style.transition = 'transform 0.6s ease-in-out';
            track.style.transform = `translateX(-${currentIndex * 100}%)`;
        }
    }, 5000); // 5 секунд
});