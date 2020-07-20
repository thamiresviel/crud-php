<?php
    require_once('../config.php');
    require_once(DBAPI);

    $customers = null;
    $customer = null;

    /** Listagem de clientes */
    function index(){
        global $customers;
        $customers = find_all('customers');
    }

/** Cadastro de clientes */
function add(){
    if(!empty($_POST['customer'])) {
        $today = date_create('now', new DateTimeZone('America/Sao_Paulo'));
        $customer = $_POST['customer'];
        $customer['modified'] = $customer['created'] = $today -> format('Y/m/d H:i:s');
        save('customers', $customer);
        header('location: index.php');
    }
}

/** Atualização e edição de cliente */

function edit(){
    $now = date_create('now', new DateTimeZone('America/Sao_Paulo'));

    if(isset($_GET['id'])) {
        $id = $_GET['id'];

        if(isset($_POST['customer'])){
            $customer = $_POST['customer'];
            $customer['modified'] = $now -> format('Y,m,d H:i:s');

            update('customers', $id, $customer);
            header('location: index.php');
        } else {
            global $customer;
            $customer = find('customers', $id);
        }
    } else {
        header('location:index.php');
    }
}

/** Visualização de um Cliente */

function view($id = null) {
    global $customer;
    $customer = find('customers', $id);
}

/** Exclusão de um Cliente */

function delete($id = null ){
    global $customer;
    $customer = remove('customers', $id);

    header('location: index.php');
}