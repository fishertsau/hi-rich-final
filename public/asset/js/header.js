const toggleMobileMenu = function() {
    const body = document.body;
    const hasActive = body.classList.contains('is-menu-open')

    if (hasActive) {
        body.classList.remove('is-menu-open')
    } else {
        body.classList.add('is-menu-open')
    }
}

window.onload = function() {
    const navbarToggleEL = document.querySelector('button.navbar-toggle');
    navbarToggleEL.addEventListener('click', toggleMobileMenu)
};