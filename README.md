# BetaTestMarvel API

Desafio Programação – Jornada Labs HAVAN.

Documentação para acesso:
* [**Configurações**](#configs)

<a id="configs"></a>

## Configurações do projeto
Requisitos mínimos:
- [PHP ^7.2](https://www.php.net)
- [Mysql 5.5.5-10.4.17-MariaDB](https://www.mysql.com)
- [Composer](https://getcomposer.org)

Framework utilizado:
- [Laravel ^8.37](https://laravel.com/docs/8.x)
<br>


Primeiramente, ao abrir o projeto, lembre-se de instalar as dependências:
```
composer install
```

Após instalar as dependências, copie o arquivo `.env.example` e renomeie para `.env`, se preciso, faça as configurações necessárias e crie o banco de dados local em sua máquina.

Rode as migrations para criar as tabelas necessárias:
```
php artisan migrate
```

Após todas as dependencias instaladas e o bando de dados configurado, basta iniciar o projeto e acessar o link que será disponibilizado:
```
php artisan serve
```