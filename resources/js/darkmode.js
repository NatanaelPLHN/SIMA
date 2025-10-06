document.addEventListener("DOMContentLoaded", () => {
    const themeToggleBtn = document.getElementById("theme-toggle");
    const darkIcon = document.getElementById("theme-toggle-dark-icon");
    const lightIcon = document.getElementById("theme-toggle-light-icon");

    function applyTheme(theme) {
        if (theme === "dark") {
            document.documentElement.classList.add("dark");
            darkIcon?.classList.add("hidden");
            lightIcon?.classList.remove("hidden");
        } else if (theme === "light") {
            document.documentElement.classList.remove("dark");
            darkIcon?.classList.remove("hidden");
            lightIcon?.classList.add("hidden");
        } else {
            // system default
            if (window.matchMedia("(prefers-color-scheme: dark)").matches) {
                document.documentElement.classList.add("dark");
                darkIcon?.classList.add("hidden");
                lightIcon?.classList.remove("hidden");
            } else {
                document.documentElement.classList.remove("dark");
                darkIcon?.classList.remove("hidden");
                lightIcon?.classList.add("hidden");
            }
        }
    }

    // Ambil theme awal (default = system)
    let savedTheme = localStorage.getItem("color-theme") || "system";
    applyTheme(savedTheme);

    // Ikuti perubahan sistem kalau mode = system
    window.matchMedia("(prefers-color-scheme: dark)")
        .addEventListener("change", () => {
            if (localStorage.getItem("color-theme") === "system") {
                applyTheme("system");
            }
        });

    // Toggle button event
    themeToggleBtn?.addEventListener("click", () => {
        let current = localStorage.getItem("color-theme") || "system";
        let nextTheme;

        if (current === "system") {
            nextTheme = "dark";
        } else if (current === "dark") {
            nextTheme = "light";
        } else {
            nextTheme = "system";
        }

        localStorage.setItem("color-theme", nextTheme);
        applyTheme(nextTheme);
    });
});
document.addEventListener("DOMContentLoaded", () => {
    const themeToggleBtn = document.getElementById("theme-toggle");
    const darkIcon = document.getElementById("theme-toggle-dark-icon");
    const lightIcon = document.getElementById("theme-toggle-light-icon");

    function applyTheme(theme) {
        if (theme === "dark") {
            document.documentElement.classList.add("dark");
            darkIcon?.classList.add("hidden");
            lightIcon?.classList.remove("hidden");
        } else if (theme === "light") {
            document.documentElement.classList.remove("dark");
            darkIcon?.classList.remove("hidden");
            lightIcon?.classList.add("hidden");
        } else {
            // system default
            if (window.matchMedia("(prefers-color-scheme: dark)").matches) {
                document.documentElement.classList.add("dark");
                darkIcon?.classList.add("hidden");
                lightIcon?.classList.remove("hidden");
            } else {
                document.documentElement.classList.remove("dark");
                darkIcon?.classList.remove("hidden");
                lightIcon?.classList.add("hidden");
            }
        }
    }

    // Ambil theme awal (default = system)
    let savedTheme = localStorage.getItem("color-theme") || "system";
    applyTheme(savedTheme);

    // Ikuti perubahan sistem kalau mode = system
    window.matchMedia("(prefers-color-scheme: dark)")
        .addEventListener("change", () => {
            if (localStorage.getItem("color-theme") === "system") {
                applyTheme("system");
            }
        });

    // Toggle button event
    themeToggleBtn?.addEventListener("click", () => {
        let current = localStorage.getItem("color-theme") || "system";
        let nextTheme;

        if (current === "system") {
            nextTheme = "dark";
        } else if (current === "dark") {
            nextTheme = "light";
        } else {
            nextTheme = "system";
        }

        localStorage.setItem("color-theme", nextTheme);
        applyTheme(nextTheme);
    });
});
document.addEventListener("DOMContentLoaded", () => {
    const themeToggleBtn = document.getElementById("theme-toggle");
    const darkIcon = document.getElementById("theme-toggle-dark-icon");
    const lightIcon = document.getElementById("theme-toggle-light-icon");

    function applyTheme(theme) {
        if (theme === "dark") {
            document.documentElement.classList.add("dark");
            darkIcon?.classList.add("hidden");
            lightIcon?.classList.remove("hidden");
        } else if (theme === "light") {
            document.documentElement.classList.remove("dark");
            darkIcon?.classList.remove("hidden");
            lightIcon?.classList.add("hidden");
        } else {
            // system default
            if (window.matchMedia("(prefers-color-scheme: dark)").matches) {
                document.documentElement.classList.add("dark");
                darkIcon?.classList.add("hidden");
                lightIcon?.classList.remove("hidden");
            } else {
                document.documentElement.classList.remove("dark");
                darkIcon?.classList.remove("hidden");
                lightIcon?.classList.add("hidden");
            }
        }
    }

    // Ambil theme awal (default = system)
    let savedTheme = localStorage.getItem("color-theme") || "system";
    applyTheme(savedTheme);

    // Ikuti perubahan sistem kalau mode = system
    window.matchMedia("(prefers-color-scheme: dark)")
        .addEventListener("change", () => {
            if (localStorage.getItem("color-theme") === "system") {
                applyTheme("system");
            }
        });

    // Toggle button event
    themeToggleBtn?.addEventListener("click", () => {
        let current = localStorage.getItem("color-theme") || "system";
        let nextTheme;

        if (current === "system") {
            nextTheme = "dark";
        } else if (current === "dark") {
            nextTheme = "light";
        } else {
            nextTheme = "system";
        }

        localStorage.setItem("color-theme", nextTheme);
        applyTheme(nextTheme);
    });
});
document.addEventListener("DOMContentLoaded", () => {
    const themeToggleBtn = document.getElementById("theme-toggle");
    const darkIcon = document.getElementById("theme-toggle-dark-icon");
    const lightIcon = document.getElementById("theme-toggle-light-icon");

    function applyTheme(theme) {
        if (theme === "dark") {
            document.documentElement.classList.add("dark");
            darkIcon?.classList.add("hidden");
            lightIcon?.classList.remove("hidden");
        } else if (theme === "light") {
            document.documentElement.classList.remove("dark");
            darkIcon?.classList.remove("hidden");
            lightIcon?.classList.add("hidden");
        } else {
            // system default
            if (window.matchMedia("(prefers-color-scheme: dark)").matches) {
                document.documentElement.classList.add("dark");
                darkIcon?.classList.add("hidden");
                lightIcon?.classList.remove("hidden");
            } else {
                document.documentElement.classList.remove("dark");
                darkIcon?.classList.remove("hidden");
                lightIcon?.classList.add("hidden");
            }
        }
    }

    // Ambil theme awal (default = system)
    let savedTheme = localStorage.getItem("color-theme") || "system";
    applyTheme(savedTheme);

    // Ikuti perubahan sistem kalau mode = system
    window.matchMedia("(prefers-color-scheme: dark)")
        .addEventListener("change", () => {
            if (localStorage.getItem("color-theme") === "system") {
                applyTheme("system");
            }
        });

    // Toggle button event
    themeToggleBtn?.addEventListener("click", () => {
        let current = localStorage.getItem("color-theme") || "system";
        let nextTheme;

        if (current === "system") {
            nextTheme = "dark";
        } else if (current === "dark") {
            nextTheme = "light";
        } else {
            nextTheme = "system";
        }

        localStorage.setItem("color-theme", nextTheme);
        applyTheme(nextTheme);
    });
});
