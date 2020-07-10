# Tutorial de CRUD com Bootstrap, PHP e MysSQL

Neste tutoria, você vai aprender uma forma eficaz de implementar um sistema de CRUD completo, usando Bootstrap no front-end com MySQL no back end. 
Ao final, você vai ter criado um mecanismo de cadastro que funciona a partir de uma tela de dashboard.

Antes de iniciar as telas é preciso montar um ambiente de desenvolvimento que já tenha o PHP e o MySQL funcionando.

1. Baixe e instale o XAMPP
2. Baixe e "instale" o Bootstrap (utilize o comando "npm install bootstrap)
3. Inicialize a estrutura do projeto:

Esse é um projeto bem simples. Vamos aproveitar estrutura que o Bootstrap traz para o front-end, e adicionar algumas patas para os codigos de back end.

Então, você deve criar apenas uma pasta **"inc"** no seu projeto. Esta pasta vai conter os arquivos PHP que serão reaproveitados em todo o CRUD.

A estrutura do seu projeto deve estar assim:

- crud-php-bootstrap
    - css
    - fonts
    - inc
    - js

** Ao longo do tutorial será criado mais arquivos e pastas.

## Passo 1: Crie o Banco de Dados e a Tabela de clientes

Para esse tutorial vamos criar um banco de dados simples, com uma tabela de clientes apenas.
O mapeamento das colunas da tebala de clientes ficou assim:

Clientes (codigo, nome, cpf/cnpj, data de nascimento,
          endereço, bairro, cep, cidade, estado,
          telefone, celular, inscrição estadual,
          data de cadastro, data de atualização)

Uma boa prática, é traduzir os nomes de tabelas e os campos para o inglês, e a partir dai criar seu banco de dados. Isso facilita na hora de escrever as consultas, e na hora de escrever o código do sistema.

Convertendo a tabela em SQL, fica assim:

~~~sql
CREATE TABLE customers (
    id int(11) NOT NULL,
    name varchar(255) NOT NULL,
    cpf_cnpj varchar(14) NOT NULL,
    birthdate date NOT NULL,
    address varchar(255) NOT NULL,
    hood varchar(100) NOT NULL,
    zip_code int(8) NOT NULL,
    city varchar(100) NOT NULL,
    state varchar(100) NOT NULL,
    phone int(13) NOT NULL,
    mobile int(13) NOT NULL,
    ie int(11) NOT NULL,
    created datetime NOT NULL,
    modified datetime NOT NULL
);
ALTER TABLE customers
    add PRIMARY KEY(id)
ALTER TABLE customers
    modify id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENTE=1;
~~~

Em seguida, abra o phpMyAdmin do Xampp e crie um banco de dados. Eu utilizei o nome: *wda_crud*
Se preferir por fazer isso via SQL direto (na aba SQL, do phpMyAdmin)

```sql
CREATE DATABASE wda_crud;
```