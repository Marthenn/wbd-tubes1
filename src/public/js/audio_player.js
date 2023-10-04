const playPauseButton = document.getElementById('play-pause-button');
const playPauseImg = document.getElementById('play-pause-img');
let isPlaying = false;

function togglePlayPause() {
    const playSrc = playPauseImg.getAttribute('data-play-src');
    const pauseSrc = playPauseImg.getAttribute('data-pause-src');

    if (isPlaying) {
        playPauseImg.src = playSrc;
        playPauseImg.alt = 'play';
    } else {
        playPauseImg.src = pauseSrc;
        playPauseImg.alt = 'pause';
    }
    isPlaying = !isPlaying;
}

playPauseButton.addEventListener('click', togglePlayPause);
