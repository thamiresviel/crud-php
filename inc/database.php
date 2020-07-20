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

    /** Pesquisa todos os registros de uma tabela */

    function find_all($table) {
        return find($table);
    }
    
    /** Pesquisa por ID em uma tabela */
    
    function find($table = null, $id = null){
        $database = open_database();
        $found = null;

        try {
            if($id){
                $sql = "SELECT * FROM" . $table . "WHERE id =" . $id;
                $result = $database -> query($sql);

                if($result -> num_rows > 0) {
                    $found = $result -> fetch_assoc();
                }
            } else {
                $sql = "SELECT * FROM" . $table;
                $result = $database -> query($sql);

                if($result -> num_rows > 0) {
                    $found = $result -> fetch_all(MYSQLI_ASSOC);
                }
            }
        } catch (Exception $e) {
            $_SESSION['message'] = $e -> GetMessage();
            $_SESSION['type'] = 'danger';
        }

        close_database($database);
        return $found;
    }

    /** Insere um Registro no BD */
    function save($table = null, $data = null){
        $database = open_database();
        $columns = null;
        $values = null;

        foreach($data  as $key => $value){
            $columns .= trim($key, "'") . ",";
            $values .= "'$value',";
        }

        /** renove a ultinma virgula */
        $columns = rtrim($columns, ',');
        $values = rtrim($values, ',');
        $sql = "INSERT INTO" . $table . "($columns)" . "VALUES" . "($values);";

        try {
            $database -> query($sql);
            $_SESSION['message'] = 'Registro cadastrado com sucesso';
            $_SESSION['type'] = 'sucess';

        } catch (Exception $e) {
            $_SESSION['message'] = 'Não foi possível realizar a operação';
            $_SESSION['type'] = 'danger';
        }

        close_database($database);
    }

    