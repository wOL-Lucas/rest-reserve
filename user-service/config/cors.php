<?php

//cors.php

return [
    'paths' => ['*'], // Rotas que devem permitir CORS
    'allowed_methods' => ['*'], // Métodos HTTP permitidos
    'allowed_origins' => ['*'], // Origens permitidas (substitua '*' por domínios específicos em produção)
    'allowed_headers' => ['*'], // Cabeçalhos permitidos
    'supports_credentials' => true, // Se for usar cookies ou autenticação com credenciais, defina como true
];
