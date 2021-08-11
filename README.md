# Lumen PHP Framework

[![Build Status](https://travis-ci.org/laravel/lumen-framework.svg)](https://travis-ci.org/laravel/lumen-framework)
[![Total Downloads](https://img.shields.io/packagist/dt/laravel/framework)](https://packagist.org/packages/laravel/lumen-framework)
[![Latest Stable Version](https://img.shields.io/packagist/v/laravel/framework)](https://packagist.org/packages/laravel/lumen-framework)
[![License](https://img.shields.io/packagist/l/laravel/framework)](https://packagist.org/packages/laravel/lumen-framework)

Laravel Lumen is a stunningly fast PHP micro-framework for building web applications with expressive, elegant syntax. We believe development must be an enjoyable, creative experience to be truly fulfilling. Lumen attempts to take the pain out of development by easing common tasks used in the majority of web projects, such as routing, database abstraction, queueing, and caching.

## Official Documentation

Documentation for the framework can be found on the [Lumen website](https://lumen.laravel.com/docs).

## Sobre o projeto

A proposta do sistema é de criar um backend simples com API Restful, que simula cadastro de usuários que podem (ou não) realizar transações entre si. Todas requisições são tratadas via JSON.
Os usuários podem ser cadastrados com 2 tipos diferentes: usuário comum (1) e lojista (2). 
O usuário comum pode realizar transações para qualquer outro cliente ou lojista, já o lojista só pode receber transações, nunca efetuar.
O usuário precisa ser cadastrado com: nome, cpf/cnpj, tipo, senha, email e saldo. Os campos de cpf e email são únicos.
A transação precisa definir pagador, recebedor e valor da transação. O valor a ser transferido não pode ser superior ao que o cliente possua na conta.

## Como utilizar

- Copie ou faça o download deste repositório
- No terminal vamos instalar o composer para para instalar todas as dependências.
	<code> composer install </code>
- Antes de iniciar o projeto, é necessário criar um banco de dados com o nome "paydb", depois alterar no arquivo .env inserindo o nome do banco e a senha criada por você.
- Após criar o banco, vamos executar o comando para criar as tabelas.
	<code> php artisan migrate </code>
- Para realizar teste de cadastro de usuário utilize o seguinte caminho, método POST no formato JSON. Tipo indica se o usuário é 1- comum ou 2- lojista
<code>POST http://localhost/projeto_harumi/public/CadastraUsuario </code> 

<pre>
{ 
  "nome" 	   : "Harumi",
  "cpf_cnpj"   : "12345678901",
  "email" 	   : "teste@teste.com", 
  "tipo"  	   : "1", 
  "senha" 	   : "123456",	 
  "saldo" 	   : "1000" 
}
</pre>   

- No teste de transação no método POST, temos o payer(pagador), payee(recebedor) e value(valor) que vai ser transferido.
<code>POST http://localhost/projeto_harumi/public/Transacao </code>
<pre>
{ 
"payer" : "1", 
"payee" : "2",  
"value" : "100.55" 
}
</pre>

