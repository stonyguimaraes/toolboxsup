    </div> <!-- fecha content -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const sidebar = document.getElementById('sidebar');
        const btnToggle = document.getElementById('btn-toggle-sidebar');

        btnToggle.addEventListener('click', () => {
            if (window.innerWidth <= 768) {
                // Mobile: abre/fecha sidebar
                sidebar.classList.toggle('show');
            } else {
                // Desktop: minimiza/maximiza
                sidebar.classList.toggle('minimized');
            }
        });

        // Fecha sidebar mobile clicando fora
        window.addEventListener('click', function(e) {
            if (window.innerWidth <= 768 && !sidebar.contains(e.target) && !btnToggle.contains(e.target)) {
                sidebar.classList.remove('show');
            }
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const sidebar = document.getElementById("sidebar");
            const toggleBtn = document.getElementById("mobileToggle");

            toggleBtn.addEventListener("click", function() {
                if (sidebar.classList.contains("expanded")) {
                    sidebar.classList.remove("expanded");
                    sidebar.classList.add("collapsed");
                } else {
                    sidebar.classList.remove("collapsed");
                    sidebar.classList.add("expanded");
                }
            });
        });
    </script>

    </body>

    </html>