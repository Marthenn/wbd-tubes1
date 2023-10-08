const playPauseButton = document.getElementById('play-pause-button');
const playPauseImg = document.getElementById('play-pause-img');
const playSrc = playPauseImg.getAttribute('data-play-src');
const pauseSrc = playPauseImg.getAttribute('data-pause-src');

const audio = document.querySelector('#audio-player');
const progressBar = document.querySelector("#progress-bar");
const currentTime = document.querySelector("#curr-duration");
const finalTime = document.querySelector("#final-duration")

let isPlaying = false;
let isHold = false;

// change later

progressBar && progressBar.addEventListener(
    'input', async (e) => {
        e.preventDefault();
        currentTime.innerHTML = getFormattedTime(progressBar.value);
    }
)

progressBar && progressBar.addEventListener(
    'change', async (e) => {
        e.preventDefault();
        audio.currentTime = parseFloat(progressBar.value);
    }
)

progressBar && progressBar.addEventListener(
    'mousedown', async (e) => {
        isHold = true;
    }
)

progressBar && progressBar.addEventListener(
    'mouseup', async (e) => {
        isHold = false;
    }
)

audio && audio.addEventListener(
    'timeupdate', async (e) => {
    currentTime.innerHTML = getFormattedTime(progressBar.value);
    if (!isHold) {
        progressBar.value = audio.currentTime;
    }
});

audio && audio.addEventListener(
    'ended', async (e) => {
    playPauseImg.src = playSrc;
    playPauseImg.alt = 'play';
    isPlaying = !isPlaying;
});

playPauseButton && playPauseButton.addEventListener(
    'click', async (e) => {
        if (isPlaying) {
            playPauseImg.src = playSrc;
            playPauseImg.alt = 'play';
        } else {
            playPauseImg.src = pauseSrc;
            playPauseImg.alt = 'pause';
        }
        isPlaying = !isPlaying;
        return audio.paused ? audio.play() : audio.pause();
    }
);

const getFormattedTime = (seconds) => {
    let hours = Math.floor(seconds / 3600);
    let minutes = Math.floor((seconds % 3600) / 60);
    let remainingSeconds = seconds % 60;

    hours = (hours < 10) ? "0" + hours : hours;
    minutes = (minutes < 10) ? "0" + minutes : minutes;
    remainingSeconds = (remainingSeconds < 10) ? "0" + parseInt(remainingSeconds) : parseInt(remainingSeconds);

    return hours + ":" + minutes + ":" + remainingSeconds;
}
