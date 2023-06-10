# Projeto de Gerenciamento de Clientes

Este projeto é um sistema simples de gerenciamento de clientes desenvolvido com Laravel, PHP e MySQL. Ele permite cadastrar, pesquisar, atualizar e excluir clientes.

## Requisitos

- PHP >= 7.4
- MySQL >= 5.7
- Composer
- Laravel >= 8.0

## Instruções de Instalação

1. Faça o clone do repositório para sua máquina local usando `git clone https://github.com/profparedes/customer-reg.git`
2. Navegue até a pasta do projeto. Exemplo: `cd seu-projeto`
3. Copie o arquivo `.env.example` e crie um novo arquivo `.env` com o comando: `cp .env.example .env`
4. Atualize o arquivo `.env` com as configurações do seu banco de dados (DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD)
5. Instale todas as dependências do projeto com o comando: `composer install`
6. Gere a chave do aplicativo com o comando: `php artisan key:generate`
7. Rode as migrations para criar as tabelas no banco de dados: `php artisan migrate`
8. Popule o banco de dados com os dados de exemplo: `php artisan db:seed`
9. Inicie o servidor de desenvolvimento com o comando: `php artisan serve`
10. Abra o navegador e navegue até `http://localhost`

## Recursos

- *Cadastro de Clientes*: permite o usuário cadastrar novos clientes com informações como CPF, nome, data de nascimento, sexo, endereço, estado e cidade.
- *Pesquisa de Clientes*: permite o usuário pesquisar clientes existentes com base no CPF, nome, data de nascimento, sexo, estado e cidade.
- *Atualização de Clientes*: permite o usuário atualizar as informações dos clientes.
- *Exclusão de Clientes*: permite o usuário excluir clientes.

## Licença

Este projeto é licenciado sob a Licença MIT - veja o arquivo [LICENSE.md](LICENSE.md) para mais detalhes.
