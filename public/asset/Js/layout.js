document.querySelectorAll('.nav-link.dropdown-toggle').forEach(item => {
    item.addEventListener('click', function() {
        const icon = item.querySelector('.dropdown-icon');
        const isExpanded = item.getAttribute('aria-expanded') === 'true';
        icon.style.transform = isExpanded ? 'rotate(0deg)' : 'rotate(180deg)';
    });
});
