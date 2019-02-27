#  Teste PHP (v1.0)

API Restful usando Symfony
### Sumário
+ [Pré Requisitos](#pré-requisitos)
+ [Comandos da aplicação](#comandos-da-aplicação)
+ [Criando banco de dados](#criando-banco-de-dados)
+ [Criando tabelas e schemas](#criando-tabelas-e-schemas)
+ [Rodando o servidor e iniciando a aplicação](#rodando-o-servidor-e-iniciando-a-aplicação)
+ [Desenvolvido por](#desenvolvido-por)
+ [Contato](#contato)
 
### Pré Requisitos
+ [Composer](https://getcomposer.org/) 
+ [SQlite](https://sqlite.org/index.html) 

### Comandos da aplicação
```
composer install
```  

### Criando banco de dados
```
php bin/console doctrine:database:create
```  

### Criando tabelas e schemas
```
php bin/console doctrine:schema:update --force
``` 

### Rodando o servidor e iniciando a aplicação
```
php bin/console server:run
``` 

### Desenvolvido por
+ **Thiago Rocha Sales** 

### Contato
+ thiagorochafortal@gmail.com
