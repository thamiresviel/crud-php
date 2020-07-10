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

### Para entender o código

Primeiro, adicionamos o arquivo de configurações e o arquivo de funções do banco de dados (ou API de banco de dados), usando o *require_once*.
Depois usamos a função para abrir a conexão. E, então, é feito um teste para saber se a conexão existe: *if($db)*...
Para testar se funciona, [acesse o CRUD pelo navegador](localhost/crud-php-bootstrap)

**Se aparecer a mensagem: 'Banco de Dados Conectado' sua conexão está ok.**
Até aqui, seu projeto deve estar assim:

- crud-php-bootstrap
    - css
    - fonts
    - inc
        - database.php
    - js
    - config.php
    - index.php

Sempre que utilizamos PHP devemos pensar em reaproveitamento de código. Ao fazer isso você aumenta sua produtividade e evita gerar *bugs*. O idela é utilizar *templates* e funções sempre que possível.

## Passo 5: Crie o *Template* do *Header*

Primeiro de tudo: crie um arquivo chamado ***header.php*** na pasta **inc** do seu projeto. Depois coloque esta marcação:

~~~html
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD - PHP + BOOTSTRAP</title>
    <!-- bootstrap -->
    <link rel="stylesheet" href="<?php echo BASEURL; ?>node_modules/bootstrap/dist/css/bootstrap.css">
    <!-- css padrão -->
    <link rel="stylesheet" href="<?php echo BASEURL;?>css/style.css">
    <!-- fontawesome -->
    <script src="https://kit.fontawesome.com/a17b1634a4.js" crossorigin="anonymous"></script>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-ligth bg-dark navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria--expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <i class="fas fa-bars"></i>
                </button>
                <a href="<?php echo BASEURL;?>index.php" class="navbar-brand">Crud</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            Clientes <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo BASEURL; ?>customers">Gerenciar Cliente</a></li>
                            <li><a href="<?php echo BASEURL; ?>customers/add.php">Novo Cliente</a></li>
                        </ul>
                    </li>
                </ul>
            </div><!--/.navbar-collapse-->
        </div>
    </nav>
        <main class="container">
~~~

Essa marcação define o início de uma página HTML básica, já usando o Bootstrap. Também vamos usar o *Font Awesome*, que é uma biblioteca de icones, para os nossos botões.

Esse *header* também cria um menu, que ficará no topo da página, eu já adicionei dois links para os futuros "módulos" do CRUD.

## Passo 6: Crie o *Template* do *Footer*

Agora, crie um arquivo chamado ***footer.php*** na pasta **inc** do seu projeto. E coloque esta marcação

~~~html
</main><!--/container-->
<hr>
<footer class="container">
    <p>&copy; 2018 - Thamires Viel</p>
</footer>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="<?php echo BASEURL; ?>node_modules/jquery/dist/js/jquery.js"><\/script>')</script>	
        <script src="<?php echo BASEURL; ?>node_modules/dist/js/bootstrap.js"></script>	
        <script src="<?php echo BASEURL; ?>js/main.js"></script>	
    </body>
</html>
~~~
O que essa marcação faz é "fechar" a página e criar um rodapé. Além disso, ela faz a referencia aos arquivos *JavaScript* e do *jQuery*.
Chamamos os .js ao final, para manter a performance da página.

## Passo 7: Altere o config.php

Abra o arquivo *config.php* e adicione as constantes para os templates no seu arquivo. Ele deve ficar assim:

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

/** Caminhos dos templares header e footer */
define('HEADER_TEMPLATE', ABSPATH . 'inc/header.php');
define('FOOTER_TEMPLATE', ABSPATH . 'inc/footer.php');
~~~

Agora, sempre que você criar uma página nova, você pode usar essas constantes HEADER_TEMPLATE E FOOTER_TEMPLATE para importar o topo e o final da página.

**Isso evita a repetição de código e economiza tempo de desenvolvimento**

## Passo 8: Crie a Página Inicial

Altere agora o arquivo *index.php* na pasta principal do projeto.E coloque essa marcação:

~~~html
<?php require_once 'config.php'; ?>
<?php require DBAPI;?>

<?php include(HEADER_TEMPLATE); ?>
<?php $db = open_database(); ?>

<h1>Dashboard</h1>
<hr/>

<?php if($db) : ?>
    <div class="row">
        <div class="col-xs-6 col-sm-3 col-md-2">
            <a href="customers/add.php" class="btn btn-primary">
                <div class="row">
                    <div class="col-xs-12 text-center">
                        <i class="fa fa-plus fa-5x"></i>
                    </div>
                    <div class="col-xs-12 text-center">
                        <p>Novo Cliente</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-xs-6 col-md-2 col-sm-3">
            <a href="customers" class="btn btn-secondary">
                <div class="row">
                    <div class="col-xs-12 text-center">
                        <i class="fas fa-users fa-5x"></i>
                    </div>
                    <div class="col-xs-12 text-center">
                        <p>Clientes</p>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <?php else : ?>
        <div class="alert alert-danger" role="alert">
            <p><strong>Erro:</strong>Não foi possível conectar ao Banco de Dados</p>
        </div>
    <?php endif; ?>
    <?php include(FOOTER_TEMPLATE); ?>
    
~~~
### Entendendo o código

As primeiras linhas fazem a inclusão do arquivo de configuração e da camada de banco de dados.
O seguinte comando `<?php include(HEADER_TEMPLATE); ?>`é quem faz a importação do template de *header* para a página e, traz toda aquela marcação em HTML. Assim, você não precisa escrever o topo da página várias vezes.
A seguir começa a página em si. Coloquei titulo simples, e um grid que vai manter os botões do *dashboard*. Esses botões usam o componente do *Bootstrap* e o icone vem do *FontAwesome*.
Por último, usamos o comando para importar o template *footer* da página: `<?php include(FOOTER_TEMPLATE);?>`

Até aqui, seu projeto deve estar assim:

- CRUD-PHP-BOOTSTRAP
    - css
    - fonts
    - inc
        - database.php
        - footer.php
        - header.php
    - js
    - config.php
    - index.php


