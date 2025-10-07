document.addEventListener("DOMContentLoaded", function () {
    const toggleBtn = document.getElementById("toggleSidebarMobile");
    const sidebar = document.getElementById("sidebar");
    const wrapper = document.getElementById("main-wrapper");
    const backdrop = document.getElementById("sidebarBackdrop");
    const iconOpen = document.getElementById("sidebarIconOpen");
    const iconClose = document.getElementById("sidebarIconClose");

    // Cek apakah di mobile (lebar < 1024px)
    function isMobile() {
        return window.innerWidth < 1024;
    }

    // Fungsi untuk menyimpan state sidebar ke localStorage (hanya untuk desktop)
    function isSidebarCollapsed() {
        const saved = localStorage.getItem('sidebar-collapsed');
        return saved === 'true';
    }

    function setSidebarCollapsed(collapsed) {
        // Hanya simpan ke localStorage jika di desktop
        if (!isMobile()) {
            localStorage.setItem('sidebar-collapsed', collapsed);
        }
        if (collapsed) {
            document.documentElement.classList.add('sidebar-collapsed');
            document.documentElement.classList.remove('sidebar-expanded');
        } else {
            document.documentElement.classList.add('sidebar-expanded');
            document.documentElement.classList.remove('sidebar-collapsed');
        }
    }

    // 🔁 INISIALISASI: Di mobile, selalu mulai dengan sidebar TERTUTUP
    let initiallyCollapsed;
    if (isMobile()) {
        initiallyCollapsed = true; // Mobile: selalu collapsed saat halaman dimuat
    } else {
        initiallyCollapsed = isSidebarCollapsed(); // Desktop: baca dari localStorage
    }
    setSidebarCollapsed(initiallyCollapsed);

    // Pastikan di mobile, backdrop disembunyikan & scroll diizinkan saat halaman dimuat
    if (isMobile()) {
        backdrop?.classList.add("hidden");
        document.body.classList.remove("overflow-hidden");
        // Pastikan ikon sesuai: open terlihat, close tersembunyi
        if (iconOpen) iconOpen.classList.remove("hidden");
        if (iconClose) iconClose.classList.add("hidden");
    }

    // Toggle sidebar
    function toggleSidebar() {
        const isCollapsed = document.documentElement.classList.contains('sidebar-collapsed');
        const newCollapsed = !isCollapsed;
        setSidebarCollapsed(newCollapsed);

        // Toggle ikon
        if (iconOpen && iconClose) {
            iconOpen.classList.toggle("hidden", !newCollapsed);
            iconClose.classList.toggle("hidden", newCollapsed);
        }

        // Handle mobile backdrop
        if (isMobile()) {
            if (newCollapsed) {
                backdrop?.classList.add("hidden");
                document.body.classList.remove("overflow-hidden");
            } else {
                backdrop?.classList.remove("hidden");
                document.body.classList.add("overflow-hidden");
            }
        }
    }

    // Event: toggle button
    if (toggleBtn) {
        toggleBtn.addEventListener("click", toggleSidebar);
    }

    // Event: klik backdrop (mobile only)
    if (backdrop) {
        backdrop.addEventListener("click", function () {
            if (!isMobile()) return;
            setSidebarCollapsed(true);
            iconOpen?.classList.remove("hidden");
            iconClose?.classList.add("hidden");
            backdrop.classList.add("hidden");
            document.body.classList.remove("overflow-hidden");
        });
    }

    // Opsional: saat resize ke desktop, pastikan backdrop disembunyikan
    window.addEventListener('resize', () => {
        if (!isMobile()) {
            backdrop?.classList.add("hidden");
            document.body.classList.remove("overflow-hidden");
        }
    });
});