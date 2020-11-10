document.addEventListener('DOMContentLoaded', () => {
    var key = 'adminerMenuScrollTop';
    var menu = document.getElementById('menu');
    var scrollTop = localStorage.getItem(key);
    var scrolled = false;

    if (scrollTop > 0) {
        menu.scrollTop = scrollTop;
    }
    menu.addEventListener('scroll', function(event) {
        scrollTop = event.target.scrollTop;
        scrolled = true;
    });

    setInterval(() => {
        if (scrolled) {
            localStorage.setItem(key, scrollTop);
            scrolled = false;
        }
    }, 500)
})
