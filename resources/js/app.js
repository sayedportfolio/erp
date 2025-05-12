import './bootstrap';
// Toggle sidebar for mobile and desktop
document.getElementById('toggle-sidebar').addEventListener('click', function () {
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.querySelector('.main-content');
    const sidebarOverlay = document.getElementById('sidebarOverlay');

    if (window.innerWidth < 992) {
        // Mobile behavior
        sidebar.classList.toggle('show');
        sidebarOverlay.classList.toggle('show');
    } else {
        // Desktop behavior
        sidebar.classList.toggle('sidebar-collapsed');
        mainContent.classList.toggle('sidebar-expanded');
    }
});

// Close sidebar when clicking overlay (mobile only)
document.getElementById('sidebarOverlay').addEventListener('click', function () {
    this.classList.remove('show');
    document.getElementById('sidebar').classList.remove('show');
});

// Close sidebar when clicking outside (mobile only)
document.addEventListener('click', function (event) {
    const sidebar = document.getElementById('sidebar');
    const toggleBtn = document.getElementById('toggle-sidebar');
    const sidebarOverlay = document.getElementById('sidebarOverlay');

    if (window.innerWidth < 992 &&
        !sidebar.contains(event.target) &&
        !toggleBtn.contains(event.target) &&
        sidebar.classList.contains('show')) {
        sidebar.classList.remove('show');
        sidebarOverlay.classList.remove('show');
    }
});