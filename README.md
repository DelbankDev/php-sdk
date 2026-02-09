# Delfinance SDK - PHP

Este repositório contém o SDK oficial da Delfinance para PHP, projetado para oferecer uma integração consistente, segura e eficiente com nossas APIs.

## 1. Objetivo

Definir a arquitetura, padrões técnicos e diretrizes para o desenvolvimento do SDK oficial em PHP, garantindo consistência, baixo acoplamento, compatibilidade ampla, desempenho e facilidade de manutenção.

## 2. Requisitos e Suporte

O SDK é implementado de forma **nativa ("vanilla")**, evitando frameworks específicos e reduzindo dependências externas ao mínimo para maximizar a compatibilidade.

*   **Runtime Mínimo**: PHP 7.2+
*   **Distribuição**: Packagist
*   **Extensões Necessárias**: `json`, `curl`, `mbstring`

### 2.1 Compatibilidade Retroativa
O SDK prioriza compatibilidade com versões mais antigas (ex: PHP 7.2), evitando padrões excessivamente modernos que limitem a adoção.

### 2.2 Controle de Versão
O arquivo `composer.lock` **não é versionado** neste repositório. Isso garante que o SDK seja sempre testado contra as versões mais recentes das dependências compatíveis, evitando conflitos ocultos com as aplicações que o consumirão.

## 3. Instalação

```bash
composer require delfinance/php-sdk
```

## 4. Estrutura do Projeto

O projeto segue estritamente a arquitetura definida nas diretrizes da Delfinance:

```text
src/
├── Abstractions/       # Contratos públicos e configuração
│   ├── Startup/        # Classes de configuração e fábrica do cliente
│   ├── Enums/          # Enums globais
│   └── Dtos/           # DTOs base e comuns
├── Utils/              # Helpers internos (Datas, Strings, Http)
└── [Modulo]/           # Ex: Payments, Accounts
    ├── Dtos/           # Objetos de transferência de dados do módulo
    ├── Enums/          # Enums específicos do módulo
    ├── Requests/       # Objetos de requisição
    ├── Responses/      # Objetos de resposta
    ├── Interfaces/     # Contratos dos serviços
    └── Services/       # Implementação da lógica de negócios
```

## 5. Configuração e Inicialização

O SDK deve ser inicializado fornecendo as credenciais e o ambiente desejado.

```php
use Delfinance\Abstractions\Startup\DelfinanceClient;
use Delfinance\Abstractions\Enums\Environment;

$client = new DelfinanceClient([
    'apiKey' => 'sua_api_key',
    'accountId': 'seu_account_id',
    'certificatePath' => '/caminho/para/certificado.pem', // Para mTLS
    'privateKeyPath' => '/caminho/para/chave.key',
    'environment' => Environment::SANDBOX
]);
```

## 6. Diretrizes Técnicas

### Abordagem API-First
*   O desenvolvimento é guiado pela especificação **OpenAPI** (presente na pasta `openapi/`).
*   A especificação serve como contrato e guia de modelagem.

### Tratamento de Tipos Sensíveis
*   **Decimais/Monetários**: Tratados com precisão de 18,2 para evitar erros de ponto flutuante. Nunca use `float` para dinheiro.
*   **Datas e Horários**: Sempre em **UTC** e no padrão **ISO 8601**.

### Segurança e Logs
*   **Logs**: Nível padrão `DEBUG`. Níveis `INFO` ou superior exigem configuração explícita. O SDK utiliza PSR-3 quando disponível.
*   **Dados Sensíveis**: Nunca são expostos em logs.
*   **Autenticação**: Suporte automático a **mTLS** e injeção de **API Key**.

### Ambientes
Suporte nativo para alternância entre ambientes:
*   **Sandbox**
*   **Produção**

### Tratamento de Erros
O SDK lança exceções específicas para erros de validação da API (4xx) e erros de servidor (5xx). Não há validação prévia de regras de negócio no cliente.

## 7. Executando com Docker

Para testes e desenvolvimento local:

```bash
docker-compose up --build
```

Isso iniciará uma aplicação PHP simples que executa um teste de integração e exibe o resultado em `http://localhost:8080`.

### Depuração (Xdebug)

O ambiente Docker já está configurado com Xdebug 3. Para depurar no VS Code:

1.  Certifique-se de que a extensão **PHP Debug** (xdebug.php-debug) esteja instalada.
2.  Vá para a aba "Run and Debug" (Ctrl+Shift+D).
3.  Selecione **"Listen for Xdebug"** no dropdown superior.
4.  Inicie o listener (F5).
5.  Coloque breakpoints no seu código.
6.  Acesse `http://localhost:8080` ou rode scripts via CLI no container.
