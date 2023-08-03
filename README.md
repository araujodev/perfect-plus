## Perfect-Plus

Checkout Assas Sandbox Project

## Apos clonar o projeto

-   Rode `composer install`.
-   Rode `npm i`.
-   Copie o .env.example e informe sua chave de integracao. Caso nao tenha,
    utilizar (sandbox): `$aact_YTU5YTE0M2M2N2I4MTliNzk0YTI5N2U5MzdjNWZmNDQ6OjAwMDAwMDAwMDAwMDAwNjA2NTM6OiRhYWNoXzBhMzU3MzQ5LTVhZTEtNDA1NC05MmYwLTA2OTMxMjRkNGZhNQ==`

## Sail Laravel

Run command: `./vendor/bin/sail up --build` to run local project.
Run Vite Sail: `./vendor/bin/sail npm run dev`.

**Atenção**: Caso ao rodar o `npm run dev` no container de problema com o esbuild.
Favor entrar no container laravel.test, remover o node_modules e rodar o `npm i`.
Desta forma, os binarios do pacote que foram trazidos do sistema de origem para o container nao estarão em conflito.

## Banco de dados e Migration

No sail, rodar: `./vendor/bin/sail php artisan migrate`

## Acessando

Para acessar após rodar o sail, basta digitar no navegador `http://localhost`
