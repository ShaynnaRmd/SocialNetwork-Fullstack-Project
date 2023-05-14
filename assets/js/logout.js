// Script For logout page

let seconds = 5;
const countdown = document.getElementById('countdown');

setInterval(() => {
    seconds--;
    countdown.innerText = seconds;
}, 1000)