// function to set a given theme/color-scheme
function setTheme(themeName) {
    localStorage.setItem('theme', themeName);
    document.documentElement.className = themeName;
}

// function to toggle between light and dark theme
function toggleTheme() {
    if (localStorage.getItem('theme') === 'theme-dark') {
        setTheme('theme-light');
        document.documentElement.setAttribute('data-bs-theme', 'light');
        document.getElementById('switch').innerHTML = '<i class="bi bi-brightness-high"></i>';
        document.body.classList.remove('bg-dark');
        document.body.classList.add('bg-light');
    } else {
        setTheme('theme-dark');
        document.documentElement.setAttribute('data-bs-theme', 'dark');
        document.getElementById('switch').innerHTML = '<i class="bi bi-moon"></i>';
        document.body.classList.remove('bg-light');
        document.body.classList.add('bg-dark');
    }
}


// Immediately invoked function to set the theme on initial load
(function () {
    if (localStorage.getItem('theme') === 'theme-dark') {
        setTheme('theme-dark');
        document.documentElement.setAttribute('data-bs-theme', 'dark');
        document.getElementById('switch').innerHTML = '<i class="bi bi-moon"></i>';
        document.body.classList.remove('bg-light');
        document.body.classList.add('bg-dark');
    } else {
        setTheme('theme-light');
        document.documentElement.setAttribute('data-bs-theme', 'light');
        document.getElementById('switch').innerHTML = '<i class="bi bi-brightness-high"></i>';
        document.body.classList.remove('bg-dark');
        document.body.classList.add('bg-light');
    }
})();