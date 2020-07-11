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
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
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