# Carteira Digital 💼

Descrição breve do que faz o projeto e seu propósito.

## Funcionalidades

- Cadastro e login de usuários
- Consulta de saldo e extrato
- Transferência entre contas (opcional)
- Envio e recebimento de recursos

## Tecnologias

- PHP 8.x
- MySQL / MariaDB
- PDO com prepared statements
- Argon2id para hash de senhas

## Instalação

1. Clone o repositório  
2. Crie um banco de dados conforme a imagem da pasta: \dao\db\image.png
  ![Image](https://github.com/user-attachments/assets/a94a4dc8-d55e-4307-b5bd-a79f426c894c)
3. Inicie o servidor PHP: `php -S localhost:8000 -t public`

## Uso

- Acesse `http://localhost:8000/register` para criar conta  
- A partir do login, gerencie sua carteira
