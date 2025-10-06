// resources/js/navbar.js

document.addEventListener('DOMContentLoaded', () => {
    // --- Toggle Sidebar Mobile ---
    const toggleSidebarMobile = document.getElementById('toggleSidebarMobile');
    const sidebar = document.getElementById('sidebar');
    const toggleSidebarMobileHamburger = document.getElementById('toggleSidebarMobileHamburger');
    const toggleSidebarMobileClose = document.getElementById('toggleSidebarMobileClose');

    if (toggleSidebarMobile && sidebar) {
        toggleSidebarMobile.addEventListener('click', () => {
            sidebar.classList.toggle('-translate-x-full');
            toggleSidebarMobileHamburger?.classList.toggle('hidden');
            toggleSidebarMobileClose?.classList.toggle('hidden');
        });
    }

    // --- Dropdowns (Notifikasi, Profil, Apps) ---
    document.querySelectorAll('[data-dropdown-toggle]').forEach(button => {
        button.addEventListener('click', (e) => {
            e.stopPropagation();
            const targetId = button.getAttribute('data-dropdown-toggle');
            const dropdown = document.getElementById(targetId);
            if (dropdown) {
                dropdown.classList.toggle('hidden');
            }
        });
    });

    // Tutup dropdown saat klik di luar
    document.addEventListener('click', (e) => {
        document.querySelectorAll('[data-dropdown-toggle]').forEach(button => {
            const targetId = button.getAttribute('data-dropdown-toggle');
            const dropdown = document.getElementById(targetId);
            if (dropdown && !button.contains(e.target) && !dropdown.contains(e.target)) {
                dropdown.classList.add('hidden');
            }
        });
    });

    // --- Toggle Dark Mode ---
    const themeToggleBtn = document.getElementById('theme-toggle');
    const themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
    const themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');

    if (!themeToggleBtn || !themeToggleDarkIcon || !themeToggleLightIcon) return;

    function applyTheme(theme) {
        if (theme === 'dark') {
            document.documentElement.classList.add('dark');
            localStorage.setItem('color-theme', 'dark');
            themeToggleLightIcon.classList.remove('hidden');
            themeToggleDarkIcon.classList.add('hidden');
        } else {
            document.documentElement.classList.remove('dark');
            localStorage.setItem('color-theme', 'light');
            themeToggleDarkIcon.classList.remove('hidden');
            themeToggleLightIcon.classList.add('hidden');
        }
    }

    // Load saved theme or respect system preference
    const savedTheme = localStorage.getItem('color-theme');
    const systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

    if (savedTheme === 'dark' || (!savedTheme && systemPrefersDark)) {
        applyTheme('dark');
    } else {
        applyTheme('light');
    }

    // Toggle on click
    themeToggleBtn.addEventListener('click', () => {
        const current = localStorage.getItem('color-theme') === 'dark' ? 'light' : 'dark';
        applyTheme(current);
    });
});// resources/js/navbar.js

document.addEventListener('DOMContentLoaded', () => {
    // --- Toggle Sidebar Mobile ---
    const toggleSidebarMobile = document.getElementById('toggleSidebarMobile');
    const sidebar = document.getElementById('sidebar');
    const toggleSidebarMobileHamburger = document.getElementById('toggleSidebarMobileHamburger');
    const toggleSidebarMobileClose = document.getElementById('toggleSidebarMobileClose');

    if (toggleSidebarMobile && sidebar) {
        toggleSidebarMobile.addEventListener('click', () => {
            sidebar.classList.toggle('-translate-x-full');
            toggleSidebarMobileHamburger?.classList.toggle('hidden');
            toggleSidebarMobileClose?.classList.toggle('hidden');
        });
    }

    // --- Dropdowns (Notifikasi, Profil, Apps) ---
    document.querySelectorAll('[data-dropdown-toggle]').forEach(button => {
        button.addEventListener('click', (e) => {
            e.stopPropagation();
            const targetId = button.getAttribute('data-dropdown-toggle');
            const dropdown = document.getElementById(targetId);
            if (dropdown) {
                dropdown.classList.toggle('hidden');
            }
        });
    });

    // Tutup dropdown saat klik di luar
    document.addEventListener('click', (e) => {
        document.querySelectorAll('[data-dropdown-toggle]').forEach(button => {
            const targetId = button.getAttribute('data-dropdown-toggle');
            const dropdown = document.getElementById(targetId);
            if (dropdown && !button.contains(e.target) && !dropdown.contains(e.target)) {
                dropdown.classList.add('hidden');
            }
        });
    });

    // --- Toggle Dark Mode ---
    const themeToggleBtn = document.getElementById('theme-toggle');
    const themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
    const themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');

    if (!themeToggleBtn || !themeToggleDarkIcon || !themeToggleLightIcon) return;

    function applyTheme(theme) {
        if (theme === 'dark') {
            document.documentElement.classList.add('dark');
            localStorage.setItem('color-theme', 'dark');
            themeToggleLightIcon.classList.remove('hidden');
            themeToggleDarkIcon.classList.add('hidden');
        } else {
            document.documentElement.classList.remove('dark');
            localStorage.setItem('color-theme', 'light');
            themeToggleDarkIcon.classList.remove('hidden');
            themeToggleLightIcon.classList.add('hidden');
        }
    }

    // Load saved theme or respect system preference
    const savedTheme = localStorage.getItem('color-theme');
    const systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

    if (savedTheme === 'dark' || (!savedTheme && systemPrefersDark)) {
        applyTheme('dark');
    } else {
        applyTheme('light');
    }

    // Toggle on click
    themeToggleBtn.addEventListener('click', () => {
        const current = localStorage.getItem('color-theme') === 'dark' ? 'light' : 'dark';
        applyTheme(current);
    });
});// resources/js/navbar.js

document.addEventListener('DOMContentLoaded', () => {
    // --- Toggle Sidebar Mobile ---
    const toggleSidebarMobile = document.getElementById('toggleSidebarMobile');
    const sidebar = document.getElementById('sidebar');
    const toggleSidebarMobileHamburger = document.getElementById('toggleSidebarMobileHamburger');
    const toggleSidebarMobileClose = document.getElementById('toggleSidebarMobileClose');

    if (toggleSidebarMobile && sidebar) {
        toggleSidebarMobile.addEventListener('click', () => {
            sidebar.classList.toggle('-translate-x-full');
            toggleSidebarMobileHamburger?.classList.toggle('hidden');
            toggleSidebarMobileClose?.classList.toggle('hidden');
        });
    }

    // --- Dropdowns (Notifikasi, Profil, Apps) ---
    document.querySelectorAll('[data-dropdown-toggle]').forEach(button => {
        button.addEventListener('click', (e) => {
            e.stopPropagation();
            const targetId = button.getAttribute('data-dropdown-toggle');
            const dropdown = document.getElementById(targetId);
            if (dropdown) {
                dropdown.classList.toggle('hidden');
            }
        });
    });

    // Tutup dropdown saat klik di luar
    document.addEventListener('click', (e) => {
        document.querySelectorAll('[data-dropdown-toggle]').forEach(button => {
            const targetId = button.getAttribute('data-dropdown-toggle');
            const dropdown = document.getElementById(targetId);
            if (dropdown && !button.contains(e.target) && !dropdown.contains(e.target)) {
                dropdown.classList.add('hidden');
            }
        });
    });

    // --- Toggle Dark Mode ---
    const themeToggleBtn = document.getElementById('theme-toggle');
    const themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
    const themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');

    if (!themeToggleBtn || !themeToggleDarkIcon || !themeToggleLightIcon) return;

    function applyTheme(theme) {
        if (theme === 'dark') {
            document.documentElement.classList.add('dark');
            localStorage.setItem('color-theme', 'dark');
            themeToggleLightIcon.classList.remove('hidden');
            themeToggleDarkIcon.classList.add('hidden');
        } else {
            document.documentElement.classList.remove('dark');
            localStorage.setItem('color-theme', 'light');
            themeToggleDarkIcon.classList.remove('hidden');
            themeToggleLightIcon.classList.add('hidden');
        }
    }

    // Load saved theme or respect system preference
    const savedTheme = localStorage.getItem('color-theme');
    const systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

    if (savedTheme === 'dark' || (!savedTheme && systemPrefersDark)) {
        applyTheme('dark');
    } else {
        applyTheme('light');
    }

    // Toggle on click
    themeToggleBtn.addEventListener('click', () => {
        const current = localStorage.getItem('color-theme') === 'dark' ? 'light' : 'dark';
        applyTheme(current);
    });
});