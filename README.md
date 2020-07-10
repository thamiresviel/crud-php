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

## Passo 2: Crie o arquivo de configuração do sistema

Agora, vamos criar um arquivo de configuração, que vai guardar todos os dados que serão utilizados em todos os *scripts* PHP do sistema.
Crie um arquivo chamado "**config.php**, na pasta principal e coloque o código a seguir:

~~~php
<?php

/** O nome do banco */
define('DB_NAME', 'wda_crud');

/** Usuario do banco */
define('DB_USER','root');

/** senha do banco */
define('DB_PASSWORD', '');

/** nome do host */
define('DB_HOST', 'localhost');

/** caminho absoluto para a pasta do sistema */
if(!defined('ABSPATH'))
    define('ABSPATH', dirname(__FILE__).'/');

/** CAMINHO NO SERVER  */
if(!defined('BASEURL'))
    define('BASEURL', '/CRUD-PHP-BOOTSTRAP/');

/** caminho do arquivo de banco de dados */
if(!defined('DBAPI'))
    define('DBAPI', ABSPATH.'inc/database.php');
?>
~~~
Este arquivo de configurações é baseado no *wp-config* do Wordpress.
Os quatro primeiros itens são as contantes que vão guardar as credenciais para acessar o banco de dados.

- o *DB_NAME* define o nome do seu banco de dados;
- o *DB_USER* é o usuário para acessar o banco de dados;
- o *DB_PASSWORD* é a senha deste usuário (no XAMPP, este usuário *root* não tem senha);
- e o *DB_HOST* é o endereço do servidor do banco de dados;

Você deve modificar esses valores de acordo com o seu ambiente de desenvolvimento, ou de produção.
Além dessas constantes, temos mais duas outras que são muito importantes:
O **ABSPATH**, define o caminho absoluto da pasta deste *webapp* no sistema de arquivos. Ela vai ser usada para chamar os outros arquivos e templates via PHP (usando o *include_once*), já que ela guarda o caminho físico da pasta.

E o **BASEURL**, define o caminho deste *webapp* no servidor web. Esse valor deve ser igual ao nome da pasta que você criou no começo do projeto. Ela será usada para montar os links da aplicação, já que ela aguarda a *URL* inicial.

## Passo 3: Implemente o *script* de Conexão com o Banco de Dados

Vamos criar um arquivo que vai reunir todas as funções de acesso ao banco de dados. Assim, podemos reaproveitar código nas outras partes do CRUD.

Crie um arquivo chamado *database.php* na pasta **inc** do seu projeto e coloque o código a seguir:

~~~php
<?php

mysqli_report(MYSQLI_REPORT_STRICT);

function open_database() {
    try {
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        return $conn;
    } catch(Exception $e){
        echo $e -> getMessage();
        return null;
    }
}

function close_database($conn){
    try {
        mysqli_close($conn);
    } catch (Exception $e) {
        echo $e -> getMessage();
    }
}
~~~

Este é um arquivo de funções do banco de dados. Tudo o que for relativo ao BD estará nele.

### Entendendo o código

Em *mysqli_report()* configuramos o MySQL para avisar sobre erros graves. Em seguida, temos duas funções.
A primeira funcão ***open_database()*** -- abre a conexão com a base de dados e retorna a conexão realizada, se der tudo certo. Se houver algum erro, a função dispara uma exceção, que pode ser exibida ao usuário.

Já a segunda função ***close_database()*** -- fecha a conexão que for passada. Se houver algum erro, a função dispara uma exceção também.

## Passo 4: Testar a Conexão

Agora, vamos verificar se o banco de dados está conectado ao CRUD.

Crie um arquivo chamado **index.php**, na pasta principal e coloque o código a seguir:

~~~php
<?php require_once 'config.php';?>
<?php require_once DBAPI; ?>

<?php

$db = open_database();
if ($db) {
    echo '<h1>Banco de Dados conectado</h1>';
} else {
    echo'<h1>ERRO: Não foi possível conectar</h1>';
}

?>
~~~

