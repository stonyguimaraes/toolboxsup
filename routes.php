<?php
// routes.php
// Armazena todas as rotas
$rotas = [];

/**
 * Registrar rota
 * $metodo: GET, POST, etc.
 * $caminho: caminho da rota, pode conter parâmetros :param
 * $callback: função que será executada
 */
function rota($metodo, $caminho, $callback)
{
    global $rotas;
    $rotas[] = [
        'metodo' => strtoupper($metodo),
        'caminho' => $caminho,
        'callback' => $callback
    ];
}

/**
 * Executar as rotas
 */
function executarRotas()
{
    global $rotas;

    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $metodo = $_SERVER['REQUEST_METHOD'];

    foreach ($rotas as $rota) {
        if ($rota['metodo'] !== $metodo) continue;

        $padrao = preg_replace('/:[^\/]+/', '([^/]+)', $rota['caminho']);
        $padrao = '#^' . $padrao . '$#';

        if (preg_match($padrao, $uri, $matches)) {
            array_shift($matches); // remove o match completo
            call_user_func_array($rota['callback'], $matches);
            return;
        }
    }

    // Se nenhuma rota bateu
    http_response_code(404);
    echo "Página não encontrada.";
}

/**
 * Função para gerar URLs internas
 */
function url($caminho)
{
    return rtrim($_SERVER['BASE_URI'] ?? '', '/') . '/' . ltrim($caminho, '/');
}
