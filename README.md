# Documentação: Configuração e Execução do Projeto

Este guia fornece instruções passo a passo para configurar e executar o projeto localmente.

Este projeto é composto por duas partes, sendo elas
- Repositório do Backend: [laravel-api-test](https://github.com/DaianeAndradeLT/laravel-api-test )
- Repositório do Frontend: [breeze-next](https://github.com/DaianeAndradeLT/breeze-next)
## Pré-requisitos

Antes de iniciar, certifique-se de ter os seguintes requisitos instalados em sua máquina:

- [PHP](https://www.php.net/) >= 8.2
- [Composer](https://getcomposer.org/)
- [Node.js](https://nodejs.org/) >= 12.x
- [npm](https://www.npmjs.com/) ou [Yarn](https://yarnpkg.com/)
- Um servidor de banco de dados MySQL ou simular. O projeto está configurado para conectar-se ao MYSQL, mas você pode alterar as configurações do banco de dados conforme necessário.


## Configuração do Backend

1. Clone o repositório do projeto backend:

    ```bash
    git clone https://github.com/DaianeAndradeLT/laravel-api-test 
    ```

    Repositório do Backend: [laravel-api-test](https://github.com/DaianeAndradeLT/laravel-api-test )


2. Navegue até o diretório do projeto backend:

    ```bash
    cd <diretorio_do_projeto_backend>
    ```

3. Instale as dependências do Composer:

    ```bash
    composer install
    ```

4. Crie um arquivo `.env` baseado no exemplo fornecido (`.env.example`) e configure-o de acordo com suas preferências e configurações locais, especialmente as configurações do banco de dados. Defina a porta do banco de dados conforme necessário:

5. Gere uma chave de aplicativo Laravel executando o seguinte comando:

    ```bash
    php artisan key:generate
    ```

6. Execute as migrações do banco de dados para criar as tabelas necessárias:

    ```bash
    php artisan migrate
    ```

7. Inicie o servidor Laravel:

    ```bash
    php artisan serve
    ```

    O servidor será iniciado em `http://localhost:8000`.

## Acesso ao Projeto

Se tudo correr bem, esperamos que os sevirdores estejam rodando em:

- Frontend: `http://localhost:3000`
- Backend: `http://localhost:8000`

# Documentação: conhecendo o projeto 


## Documentação de Acesso às Rotas

### Rotas de Produtos
As rotas de produtos são agrupadas sob o prefixo `products`. Aqui estão as rotas disponíveis:

### GET /products

Esta rota é usada para obter uma lista de todos os produtos. Não requer nenhum parâmetro.

Exemplo de uso:
```bash
GET /products
```

### POST /products

Esta rota é usada para criar um novo produto. Requer um corpo de solicitação contendo os detalhes do produto.

Exemplo de uso:
```bash
POST /products Content-Type: application/json
{
    "title": "string",
    "price": 10.0,
    "description": "string",
    "image": "img_url",
    "category": "Cat"
}
```

### PUT /products/{id}

Esta rota é usada para atualizar um produto existente. Requer o ID do produto como parâmetro na URL e um corpo de solicitação contendo os detalhes do produto a serem atualizados.

Exemplo de uso:4
```bash
PUT /products/1 Content-Type: application/json
{
    "title": "string",
    "price": 10.0,
    "description": "string",
    "image": "img_url",
    "category": "Cat"
}
```

### DELETE /products/{id}

Esta rota é usada para excluir um produto existente. Requer o ID do produto como parâmetro na URL.

Exemplo de uso:
```bash
DELETE /products/1
```

### POST /products/import

Esta rota é usada para importar produtos a partir de um arquivo. Requer um corpo de solicitação contendo o arquivo de produtos a ser importado.
Esta rota aceita arquivos do tipo CSV. O arquivo deve conter os campos `title`, `price`, `description`, `image`, `category`.
Esta rota lê os dados do arquivo e cria novos produtos na api externa. 

Exemplo de uso:
```bash
POST /products/import Content-Type: multipart/form-data
{
    "file": "file"
}
```

## Estrutura de código 

Nesse código foi organizado em pastas e arquivos de acordo com a estrutura do Laravel. 
Foi construído com base no padrão MVC (Model-View-Controller), com a adição de uma camada extra de serviços que é responsável pela abstração das regras de negócio da aplicação.

Sendo assim está dividido em: 

- `routes/api.php`: contém as definições das rotas da aplicação.
- `app/Http/Middleware`: contém os middlewares da aplicação, que são responsáveis por interceptar as requisições HTTP e executar alguma lógica antes de passar para o controlador.
- `app/Http/Requests`: contém as classes de validação das requisições HTTP.
- `app/Http/Controllers`: contém os controladores da aplicação, que são responsáveis por receber as requisições HTTP, processá-las e retornar uma resposta.
- `app/Services`: contém as classes de serviço da aplicação, que são responsáveis por abstrair as regras de negócio da aplicação.
- `app/Models`: contém as classes de modelo da aplicação, que são responsáveis por representar as entidades do banco de dados.
- `database/migrations`: contém os arquivos de migração do banco de dados, que são responsáveis por criar as tabelas e campos necessários para a aplicação.

