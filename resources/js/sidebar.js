document.addEventListener("DOMContentLoaded", function () {
    const toggleBtn = document.getElementById("toggleSidebarMobile");
    const sidebar = document.getElementById("sidebar");
    const wrapper = document.getElementById("main-wrapper");
    const iconOpen = document.getElementById("sidebarIconOpen");
    const iconClose = document.getElementById("sidebarIconClose");

    if (toggleBtn && sidebar && wrapper && iconOpen && iconClose) {
        toggleBtn.addEventListener("click", function () {
            // Toggle sidebar tampil/sembunyi
            sidebar.classList.toggle("hidden");

            // Toggle padding konten utama
            wrapper.classList.toggle("lg:pl-64");

            // Toggle icon open <-> close
            iconOpen.classList.toggle("hidden");
            iconClose.classList.toggle("hidden");
        });
    }
});
