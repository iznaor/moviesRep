document.addEventListener('DOMContentLoaded', function () {
    checkAndSetMode(); // Pozivanje funkcije za provjeru i postavljanje moda
});


function toggleMode() {
    var container = document.getElementById('container');
    var isLightMode = container.classList.contains('light-mode-container');

    // biranje između tamne teme ili svijetle
    if (isLightMode) {
        container.classList.remove('light-mode-container');
        container.classList.add('dark-mode-container');
        localStorage.setItem('mode', 'dark');
    } else {
        container.classList.remove('dark-mode-container');
        container.classList.add('light-mode-container');
        localStorage.setItem('mode', 'light');
    }
}

function checkAndSetMode() {
    var container = document.getElementById('container');
    var savedMode = localStorage.getItem('mode');

    if (savedMode === 'dark') {
        container.classList.add('dark-mode-container');
    } else {
        container.classList.remove('dark-mode-container');
        container.classList.add('light-mode-container');
    }
}

function searchMovies() {
    const searchTitle = document.getElementById('searchTitle').value;

    // zahtjev prema PHP skripti da se nađe film prema nazivu
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'search_movies.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            
            document.getElementById('searchResults').innerHTML = xhr.responseText;
        }
    };

    // slanje prema php skripti
    const params = 'searchTitle=' + encodeURIComponent(searchTitle);
    xhr.send(params);
}

