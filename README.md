# Delfinance SDK (PHP)

SDK oficial da Delfinance para PHP, fornecendo uma interface simplificada para integração com os serviços PIX, Transferências, Cobranças e Webhooks da Delfinance.

## Índice

- [Estrutura do Repositório](#estrutura-do-repositório)
- [Requisitos](#requisitos)
- [Instalação](#instalação)
- [Início Rápido](#início-rápido)
- [Configuração mTLS](#configuração-mtls)
- [Funcionalidades](#funcionalidades)
- [Exemplos de Uso](#exemplos-de-uso)
- [Contribuindo](#contribuindo)
- [Documentação Técnica](#documentação-técnica)

## Estrutura do Repositório

```
src/
├── Abstractions/          # Configurações e Enums globais
├── Charges/               # Módulo de Cobranças e Pagamentos de Contas
│   ├── Services/          # ChargesService
│   ├── Requests/          # DTOs de Requisição
│   └── Responses/         # DTOs de Resposta
├── QrCode/                # Módulo de QR Codes PIX (Estático e Dinâmico)
├── Transfers/             # Módulo de Transferências (PIX/TED) e Chaves PIX
│   ├── Services/          # TransfersService e PixService
│   └── ...
├── Webhooks/              # Módulo de Gerenciamento de Webhooks
└── Utils/                 # Utilitários (RequestHelper, etc.)
```

## Requisitos

- **PHP 7.4+**
- **Composer** para gerenciamento de dependências
- Extensões PHP: `curl`, `json`

## Instalação

Instale via Composer:

```bash
composer require delfinance/delfinance-api-sdk
```

## Início Rápido

```php
<?php

require 'vendor/autoload.php';

use Delfinance\Abstractions\Startup\DelfinanceClient;
use Delfinance\Abstractions\Enums\Environment;
use Delfinance\Transfers\Services\PixService;

// 1. Configurar o Client
$client = new DelfinanceClient([
    'apiKey' => 'sua-api-key',
    'accountId' => 'sua-account-id', // Opcional em alguns contextos
    'environment' => Environment::SANDBOX, // ou Environment::PRODUCTION
    // Opcional: Configuração de mTLS (obrigatório apenas ao ambiente PRODUCTION)
    // 'certificatePath' => '/path/to/cert.pem',
    // 'privateKeyPath' => '/path/to/key.pem'
]);

// 2. Instanciar o Serviço desejado (ex: PixService)
$pixService = new PixService($client);

// 3. Utilizar os métodos do serviço
try {
    $keys = $pixService->getPixKeys();
    print_r($keys);
} catch (Exception $e) {
    echo "Erro: " . $e->getMessage();
}
```

## Configuração mTLS

Para ambientes de produção, a autenticação via mTLS (Mutual TLS) é obrigatória em algumas operações. Você deve fornecer os caminhos absolutos para o seu certificado público (`.pem`) e chave privada (`.key` ou `.pem`).

```php
$client = new DelfinanceClient([
    'apiKey' => 'sua-api-key',
    'accountId' => 'sua-account-id',
    'environment' => Environment::PRODUCTION,
    'certificatePath' => '/caminho/absoluto/para/certificado.pem',
    'privateKeyPath' => '/caminho/absoluto/para/chave_privada.pem'
]);
```

Certifique-se de que os arquivos de certificado sejam legíveis pelo processo do PHP.

## Funcionalidades

### QR Code Estático (Módulo `QrCode`)

Classe: `Delfinance\QrCode\Services\QrCodeService`

| Funcionalidade | Método | Descrição |
|---------------|--------|-----------|
| Criar QR Code | `createStaticQrCode(StaticQrCodeRequest $request)` | Cria um QR Code PIX estático com ou sem valor fixo |
| Consultar QR Code | `getStaticQrCode($transactionIdentifier)` | Busca informações de um QR Code estático por identificador |
| Listar Pagamentos | `getStaticQrCodePayments($identifier)` | Lista todos os pagamentos recebidos de um QR Code estático |
| Cancelar QR Code | `cancelStaticQrCode($transactionIdentifier)` | Cancela um QR Code estático previamente criado |

### QR Code Dinâmico Imediato (Módulo `QrCode`)

Classe: `Delfinance\QrCode\Services\QrCodeService`

| Funcionalidade | Método | Descrição |
|---------------|--------|-----------|
| Criar QR Code | `createImmediateQrCode(ImmediateQrCodeRequest $request)` | Cria um QR Code dinâmico para pagamento imediato com expiração |
| Consultar QR Code | `getImmediateQrCode($id)` | Busca informações de um QR Code dinâmico por ID |
| Cancelar QR Code | `cancelImmediateQrCode($id)` | Cancela um QR Code dinâmico imediato |

### QR Code Dinâmico com Vencimento (Módulo `QrCode`)

Classe: `Delfinance\QrCode\Services\QrCodeService`

| Funcionalidade | Método | Descrição |
|---------------|--------|-----------|
| Criar QR Code | `createDueDateQrCode(DueDateQrCodeRequest $request)` | Cria um QR Code dinâmico com data de vencimento e encargos |
| Consultar QR Code | `getDueDateQrCode($id)` | Busca informações de um QR Code com vencimento por ID |
| Cancelar QR Code | `cancelDueDateQrCode($id)` | Cancela um QR Code dinâmico com vencimento |

### Transferências e Pagamentos (Módulo `Transfers`)

Classes: `Delfinance\Transfers\Services\PixService` e `Delfinance\Transfers\Services\TransfersService`

| Funcionalidade | Método | Serviço | Descrição |
|---------------|--------|---------|-----------|
| Inicializar Pagamento (DICT) | `paymentInitialization(PaymentInitializationRequest $request)` | `PixService` | Inicializa pagamento via chave PIX (CPF, e-mail, etc.) |
| Inicializar Pagamento (QR Code) | `decodeQrCode(DecodeQrCodeRequest $request)` | `PixService` | Decodifica/Inicializa pagamento via payload de QR Code |
| Criar Transferência PIX | `createTransfer(CreateTransferRequest $request, $idempotencyKey)` | `TransfersService` | Executa transferência PIX após inicialização |
| Criar Transferência TED | `createTedTransfer(CreateTedTransferRequest $request, $idempotencyKey)` | `TransfersService` | Executa transferência TED |
| Criar Transferência em Lote | `createBatchTransfer(CreateBatchTransferRequest $request)` | `TransfersService` | Executa múltiplas transferências em lote |
| Consultar Transferência | `getTransfer($transferIdentifier)` | `TransfersService` | Consulta detalhes de uma transferência por ID |

### Gerenciamento de Chaves PIX (Módulo `Transfers`)

Classe: `Delfinance\Transfers\Services\PixService`

| Funcionalidade | Método | Descrição |
|---------------|--------|-----------|
| Gerar Código de Autenticação | `generateAuthCode(GenerateAuthCodeRequest $request)` | Gera código para vincular chave PIX (e-mail/telefone) |
| Criar Chave PIX | `createPixKey(CreatePixKeyRequest $request, $idempotencyKey)` | Cria/vincula uma nova chave PIX à conta |
| Listar Chaves PIX | `getPixKeys()` | Lista todas as chaves PIX vinculadas à conta |
| Deletar Chave PIX | `deletePixKey(DeletePixKeyRequest $request, $idempotencyKey)` | Remove uma chave PIX vinculada à conta |

### Webhooks (Módulo `Webhooks`)

Classe: `Delfinance\Webhooks\Services\WebhookService`

| Funcionalidade | Método | Descrição |
|---------------|--------|-----------|
| Criar Webhook | `createWebhook(CreateWebhookRequest $request)` | Registra um novo webhook |
| Listar Webhooks | `getAllWebhooks()` | Lista todos os webhooks registrados |
| Consultar Webhook | `getWebhookById($id)` | Consulta detalhes de um webhook por ID |
| Atualizar Webhook | `updateWebhook(UpdateWebhookRequest $request)` | Atualiza configuração de um webhook |
| Deletar Webhook | `deleteWebhook($id)` | Remove um webhook registrado |

**Tipos de Eventos Suportados:**
- `CHARGE_PAID` - Boleto pago
- `PIX_RECEIVED` - PIX recebido (novo fluxo)
- `PIX_PAYMENT_UPDATED` - Atualização de status de pagamento PIX
- `PIX_REFUNDED` - Reembolso recebido
- `PIX_REFUND_PAYMENT_UPDATED` - Erro em reembolso
- `TRANSFER_INTERNAL_CREDITED` - Transferência interna recebida
- `TRANSFER_INTERNAL_DEBITED` - Transferência interna enviada
- `TRANSFER_EXTERNAL_CREDITED` - TED recebida
- `TRANSFER_EXTERNAL_DEBITED` - TED enviada
- `INFRACTION_NOTIFICATION_CREATED` - Notificação de infração
- `WHITELABEL_CUSTOMER_DOCUMENTATION_REJECTED` - Documentos rejeitados
- `WHITELABEL_CUSTOMER_APPROVED` - Cliente aprovado

**Esquemas de Autorização:**
- `NONE` - Sem autenticação
- `BASIC` - Basic Authentication (username:password base64)
- `BEARER` - Bearer Token (JWT ou API Key)
- `HEADER` - Header customizado

### Cobranças (Módulo `Charges`)

Classe: `Delfinance\Charges\Services\ChargesService`

| Funcionalidade | Método | Descrição |
|---------------|--------|-----------|
| Criar Cobrança | `createCharge(CreateChargeRequest $request)` | Cria uma cobrança (Boleto, Boleto+PIX, etc.) |
| Consultar Cobrança | `getCharge($correlationId)` | Busca detalhes de uma cobrança por ID de correlação |
| Listar Cobranças | `getCharges($startDate, $endDate, $page, $limit)` | Lista cobranças com filtros |
| Atualizar Cobrança | `updateCharge($correlationId, UpdateChargeRequest $request)` | Atualiza dados (ex: vencimento) de uma cobrança |
| Cancelar Cobrança | `voidCharge($correlationId)` | Cancela uma cobrança pendente |

### Pagamentos de Contas (Módulo `Charges`)

Classe: `Delfinance\Charges\Services\ChargesService`

| Funcionalidade | Método | Descrição |
|---------------|--------|-----------|
| Consultar Boleto | `getPaymentInfo($paymentIdentifier)` | Consulta informações de boleto por código de barras/linha digitável |
| Pagar Boleto | `makePayment(MakePaymentRequest $request, $idempotencyKey)` | Realiza o pagamento de um boleto |

**Tipos de Cobrança Suportados:**
- `BANKSLIP` - Boleto bancário tradicional
- `BANKSLIP_PIX` - Boleto com opção de pagamento via PIX
- `PIX_STATIC` - Cobrança PIX estática
- `PIX_DYNAMIC` - Cobrança PIX dinâmica
- `PIX_DYNAMIC_DUEDATE` - Cobrança PIX dinâmica com vencimento

**Recursos:**
- Multa e juros configuráveis (fixo ou percentual)
- Descontos e abatimentos
- Dados completos do pagador e endereço
- Geração automática de código de barras e linha digitável
- QR Code PIX integrado (para tipos BANKSLIP_PIX e PIX_*)
- Notificação automática ao pagador

**Status de Pagamento:**
- `PAID` - Pago com sucesso
- `SCHEDULED` - Agendado para data futura
- `CHARGEBACKED` - Estornado
- `PENDING_APPROVAL` - Pendente de aprovação
- `SCHEDULE_FAILURE` - Falha no agendamento

## Exemplos de Uso

### Criar QR Code Estático

```php
use Delfinance\QrCode\Services\QrCodeService;
use Delfinance\QrCode\Requests\StaticQrCodeRequest;

// $client deve ser instanciado conforme a seção "Início Rápido"
$qrService = new QrCodeService($client);

// Parâmetros: CorrelationId, Valor (opcional), Chave Pix (opcional), ...
$request = new StaticQrCodeRequest(
    uniqid(),
    50.00,
    "11999999999", 
    null,
    null,
    "Minha Empresa",
    "Pagamento Exemplo"
);
$request->formatResponse = "PAYLOAD_AND_QRCODE";

$response = $qrService->createStaticQrCode($request);
echo "QR Code criado. Payload: " . $response->payloadPix;
```

### Criar Cobrança (Boleto + PIX)

```php
use Delfinance\Charges\Services\ChargesService;
use Delfinance\Charges\Requests\CreateChargeRequest;
use Delfinance\Charges\Dto\Payer;
use Delfinance\Charges\Dto\Address;
use Delfinance\Charges\Dto\Phone;

// $client deve ser instanciado conforme a seção "Início Rápido"
$chargeService = new ChargesService($client);

// Configurar o Pagador
$address = new Address("01001000", "Praça da Sé", "Centro", "1", "", "São Paulo", "SP");
$phone = new Phone("11", "999999999");
$payer = new Payer("João Silva", "12345678901", "joao@email.com", $phone, $address);

// Configurar a Requisição
// Parâmetros: CorrelationId, SeuNumero, DataVencimento, Valor, Pagador
$request = new CreateChargeRequest(
    uniqid(),
    "12345",
    "2024-12-31",
    150.00,
    $payer
);
$request->type = "BANKSLIP_PIX";
$request->description = "Mensalidade";

$response = $chargeService->createCharge($request);
echo "Cobrança criada! ID: " . $response->id;
```

### Inicializar e Realizar Transferência PIX

```php
use Delfinance\Transfers\Services\PixService;
use Delfinance\Transfers\Services\TransfersService;
use Delfinance\Transfers\Requests\PaymentInitializationRequest;
use Delfinance\Transfers\Requests\CreateTransferRequest;

// $client deve ser instanciado conforme a seção "Início Rápido"
$pixService = new PixService($client);
$transferService = new TransfersService($client);

// 1. Inicializar (Obter EndToEndId)
// Parâmetros: Chave PIX, Documento do Titular (opcional)
$initRequest = new PaymentInitializationRequest("email@exemplo.com");

$initResponse = $pixService->paymentInitialization($initRequest);
$endToEndId = $initResponse->endToEndId;

// 2. Efetivar a Transferência
// Parâmetros: Valor
$transferRequest = new CreateTransferRequest(100.00);
$transferRequest->endToEndId = $endToEndId;
$transferRequest->description = "Pagamento de serviço";
$transferRequest->initiationType = "KEY";
$transferRequest->type = "PIX";

$idempotencyKey = uniqid();
$transferResponse = $transferService->createTransfer($transferRequest, $idempotencyKey);

echo "Transferência realizada: " . $transferResponse->id;
```

### Criar Webhook

```php
use Delfinance\Webhooks\Services\WebhookService;
use Delfinance\Webhooks\Requests\CreateWebhookRequest;

// $client deve ser instanciado conforme a seção "Início Rápido"
$webhookService = new WebhookService($client);

// Parâmetros: EventType, URL, AuthScheme, AuthToken
$request = new CreateWebhookRequest(
    "CHARGE_PAID",
    "https://meusite.com/callback",
    "BEARER",
    "meu-token-secreto"
);

$response = $webhookService->createWebhook($request);
echo "Webhook criado: " . $response->id;
```

### Consultar e Pagar Boleto

```php
use Delfinance\Charges\Services\ChargesService;
use Delfinance\Charges\Requests\MakePaymentRequest;

// $client deve ser instanciado conforme a seção "Início Rápido"
$chargeService = new ChargesService($client);

// 1. Consultar informações
$digitableLine = "12345678901234567890123456789012345678901234567";
$info = $chargeService->getPaymentInfo($digitableLine);

echo "Valor do boleto: " . $info->amount;

// 2. Pagar
$paymentRequest = new MakePaymentRequest();
$paymentRequest->digitableLine = $digitableLine;
$paymentRequest->amount = $info->amount;

$idempotencyKey = uniqid();
$paymentResponse = $chargeService->makePayment($paymentRequest, $idempotencyKey);

echo "Pagamento realizado: " . $paymentResponse->id;
```

## Contribuindo

Para contribuir com o projeto:

1. Faça um Fork do projeto
2. Crie uma branch para sua feature (`git checkout -b feature/MinhaFeature`)
3. Commit suas mudanças (`git commit -m 'Adiciona MinhaFeature'`)
4. Push para a branch (`git push origin feature/MinhaFeature`)
5. Abra um Pull Request

## Documentação Técnica

Para mais detalhes sobre os endpoints e parâmetros, consulte a [Documentação da API Delfinance](https://docs.delfinance.com.br).
