<?php
if (isset($_SESSION['mensagem'])):
    $tipo = $_SESSION['mensagem']['tipo'] ?? 'success';
    $texto = $_SESSION['mensagem']['texto'] ?? '';
?>
    <!-- Toast maior com animação suave -->
    <div class="position-fixed top-0 end-0 p-3" style="z-index: 1060; max-width: 400px;">
        <div id="toastMensagem" class="toast align-items-center text-bg-<?= $tipo ?> border-0 fade" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <!-- <img src="..." class="rounded me-2" alt="..."> -->
                <i class="bi bi-exclamation-circle"></i>
                <strong class="me-auto" style="padding-left: 10px;">Atenção</strong>
                <!-- <small class="text-muted">just now</small> -->
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="d-flex">

                <div class="toast-body" style="font-size: 1.1rem; padding: 1rem;">
                    <?= htmlspecialchars($texto) ?>
                </div>
                <!-- <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Fechar"></button>   -->
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var toastEl = document.getElementById('toastMensagem');
            if (toastEl) {
                // Inicializa o toast do Bootstrap com animação suave
                var toast = new bootstrap.Toast(toastEl, {
                    delay: 4000,
                    animation: true
                });
                toast.show();
            }
        });
    </script>

<?php unset($_SESSION['mensagem']);
endif; ?>