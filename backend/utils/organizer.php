<?php
$organizerRules = [
    'controllers' => [
        'pattern' => 'backend/*Controller.php', // Assume controlador com 'Controller' no nome
        'target' => 'backend/controllers' // Nova pasta para controladores
    ],
    'views' => [
        'pattern' => 'frontend/*view.php', // Assume visualizações com 'view' no nome
        'target' => 'frontend/views' // Nova pasta para views
    ],
    'assets' => [
        'pattern' => 'frontend/*.{css,js,png,jpg}', // Ativos na pasta FRONT_END
        'target' => 'frontend/asset s'// Nova pasta para ativos
    ]
];

foreach ($organizerRules as $rule) {
    foreach (glob($rule['pattern']) as $file) {
        // Verifica se o diretório alvo existe; se não, cria
        if (!file_exists($rule['target'])) {
            mkdir($rule['target'], 0777, true);
        }
        // Renomeia o arquivo para o novo diretório
        rename($file, $rule['target'].'/'.basename($file));
    }
}

echo "Projeto organizado!";
?>