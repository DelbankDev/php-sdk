<?php

require_once __DIR__ . '/vendor/autoload.php';

use Delfinance\Abstractions\Startup\DelfinanceClient;
use Delfinance\Abstractions\Enums\Environment;
use Delfinance\Transfers\Services\TransfersService;

// Função simples para carregar .env (para não depender de vlucas/phpdotenv neste exemplo simples)
// Em um projeto real, recomenda-se usar bibliotecas robustas ou variáveis de ambiente do servidor.
function loadEnv($path) {
    if (!file_exists($path)) {
        return;
    }
    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue;
        list($name, $value) = explode('=', $line, 2);
        $_ENV[trim($name)] = trim($value);
    }
}

// Tenta carregar do .env se existir, senão usa valores padrão ou do .env.example
if (file_exists(__DIR__ . '/.env')) {
    loadEnv(__DIR__ . '/.env');
} else {
    loadEnv(__DIR__ . '/.env.example');
}

echo "<h1>Teste do SDK PHP 7.2</h1>";

try {
    // Configuração inicial via Variáveis de Ambiente
    $apiKey = isset($_ENV['DELFINANCE_API_KEY']) ? $_ENV['DELFINANCE_API_KEY'] : 'test_api_key_default';
    $accountId = isset($_ENV['DELFINANCE_ACCOUNT_ID']) ? $_ENV['DELFINANCE_ACCOUNT_ID'] : 'test_account_id_default';
    $env = isset($_ENV['DELFINANCE_ENVIRONMENT']) && $_ENV['DELFINANCE_ENVIRONMENT'] === 'production' 
           ? Environment::PRODUCTION 
           : Environment::SANDBOX;
    
    $certPath = isset($_ENV['DELFINANCE_CERT_PATH']) ? $_ENV['DELFINANCE_CERT_PATH'] : null;
    $keyPath = isset($_ENV['DELFINANCE_KEY_PATH']) ? $_ENV['DELFINANCE_KEY_PATH'] : null;
    $testTransferId = isset($_ENV['TEST_TRANSFER_ID']) ? $_ENV['TEST_TRANSFER_ID'] : 'tr_example';

    $client = new DelfinanceClient([
        'apiKey' => $apiKey,
        'accountId' => $accountId,
        'environment' => $env,
        'certificatePath' => $certPath,
        'privateKeyPath' => $keyPath
    ]);

    echo "<h3>1. Inicialização</h3>";
    echo "<ul>";
    echo "<li>Ambiente: " . $client->getEnvironment() . "</li>";
    echo "<li>Base URL: " . $client->getBaseUrl() . "</li>";
    echo "<li>API Key: " . substr($client->getApiKey(), 0, 5) . "***</li>";
    echo "<li>Account ID: " . $client->getAccountId() . "</li>";
    echo "</ul>";

    // Teste do Serviço de Transferências
    echo "<h3>2. Teste de GET Transfer</h3>";
    
    $transfersService = new TransfersService($client);
    
    try {
        echo "Buscando transferência: $testTransferId <br/>";
        
        $response = $transfersService->getTransfer($testTransferId);
        
        echo "<pre>";
        print_r($response);
        echo "</pre>";

    } catch (Exception $e) {
        echo "<p style='color:orange'><strong>Resultado esperado (Erro de API ou Conexão):</strong> " . $e->getMessage() . "</p>";
        echo "<small>Nota: Se você não configurou um .env com credenciais reais, este erro é esperado.</small>";
    }

} catch (Exception $e) {
    echo "<p style='color:red'>Erro Crítico: " . $e->getMessage() . "</p>";
}

echo "<br/>";
phpinfo();
