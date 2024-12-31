let menu = document.querySelector('.menu_icon');
let overlay = document.getElementById('sidebar-overlay');
let header = document.querySelector('.sidebar-header');
let content = document.querySelector('aside .content');
let navigation = document.querySelector('.aside-navigation');

const mediaQuery = window.matchMedia('(max-width: 768px)');

function applyStyles() {
    if (!mediaQuery.matches) {
        content.style.display = 'block';
        overlay.style.display = 'none';
        navigation.style.display = 'flex';
        menu.classList.remove('open');
    } else {
        if (!menu.classList.contains('open')) {
            overlay.style.display = 'none';
            header.style.width = '0%';
            content.style.display = 'none';
            navigation.style.display = 'none';
        }
    }
}

menu.addEventListener('click', function () {
    if (mediaQuery.matches) {
        const isOpen = menu.classList.toggle('open');
        overlay.style.display = isOpen ? 'block' : 'none';
        overlay.style.opacity = isOpen ? '1' : '0';
        header.style.width = isOpen ? '100%' : '0%';
        content.style.display = isOpen ? 'block' : 'none';
        navigation.style.display = isOpen ? 'flex' : 'none';
    }
});

applyStyles();

mediaQuery.addEventListener('change', applyStyles);
