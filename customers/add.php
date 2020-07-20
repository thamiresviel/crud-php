<?php
    require_once('functions.php');
    add();
?>

<?php include(HEADER_TEMPLATE); ?>

<h2>Novo Cliente</h2>

<form action="add.php" method="post">
    <hr/>
    <div class="row">
        <div class="form-group col-md-7">
            <label for="name">Nome/Razão Social</label>
            <input type="text" class="form-control" name="customer['name']">
        </div>

        <div class="form-group col-md-3">
            <label for="campo2">CPF/CNPJ</label>
            <input type="text" name="customer['cpf_cnpj']" claa="form-control">
        </div>

        <div class="form-group col-md-2">
            <label for="campo3">Data de Nascimento</label>
            <input type="text" class="form-control" name="customer['birthdate']">
        </div>
    </div>

    <div class="row">
        <div class="form-group col-md-5">
            <label for="campo1">Endereço</label>
            <input type="text" class="form-control" name="customer['address']">
        </div>

        <div class="form-group col-md-3">
            <label for="campo2">Bairro</label>
            <input type="text" class="form-control" name="customer['hood']">
        </div>

        <div class="form-group col-md-2">
            <label for="campo3">CEP</label>
            <input type="text" class="form-control" name="customer['zip_code']">
        </div>

        <div class="form-group col-md-2">
            <label for="campo3">Data de Cadastro</label>
            <input type="text" class="form-control" name="customer['created']" disable>
        </div>
    </div>

    <div class="row">
        <div class="form-group col-md-3">
            <label for="campo1">Municipio</label>
            <input type="text" class="form-control" name="customer['city']">
        </div>

        <div class="form-group col-md-2">
            <label for="campo2">Telefone</label>
            <input type="text" class="form-control" name="customer['phone']">
        </div>

        <div class="form-group col-md-2">
            <label for="campo3">Celular</label>
            <input type="text"  class="form-control" name="customer['mobile']">
        </div>

        <div class="form-group col-md-1">
            <label for="campo3">UF</label>
            <input type="text" class="form-control" name="customer['state']">
        </div>

        <div class="form-group col-md-2">
            <label for="campo3">Incrição estadual</label>
            <input type="text" class="form-control" name="customer['ie']">
        </div>

        <div class="form-group col-md-2">
            <label for="campo3">UF</label>
            <input type="text" class="form-control">
        </div>
    </div>

    <div class="row" id="actions">
        <div class="col-md-12">
            <button type="submit" class="btn btn-primary">Salvar</button>
            <a href="index.php" class="btn btn-secondary">Cancelar</a>
        </div>
    </div>
</form>

<?php include(FOOTER_TEMPLATE);