function toggleForm() {
    var container = document.querySelector(".container");
    container.classList.toggle("active");
}


window.addEventListener('DOMContentLoaded', () => {
    let error = document.querySelector(".error").style;
    if((error.opacity = 1))
    {
        (function fade(){(error.opacity-=.1)<0?(error.display="none"):setTimeout(fade,500)})();
    }
    let message = document.querySelector(".message").style;
    if((message.opacity = 1))
    {
        (function fade(){(message.opacity-=.1)<0?message.display="none":setTimeout(fade,500)})();
    }
});