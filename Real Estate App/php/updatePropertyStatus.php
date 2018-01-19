<?php
    
    require_once('databaseConnection.php');
    require('propertyClass.php');
    
    $property = new Property();

    
    $date = date('Y-m-d');

    if(isset($_POST['updatePropertyStatus'])) {
        $status = $_POST['property_status'];
        $id = $_POST['id'];
        $price = $_POST["price"];

        $stmt = $property->runQuery("UPDATE property SET PK_property_status_id=? WHERE property_id=?");
        $stmt->bindValue(1, $status);
        $stmt->bindValue(2, $id);
        $stmt->execute();
        if($status == 1){
            $stmt = $property->runQuery("SELECT * FROM rentals WHERE PK_property_id=?");
            $stmt->bindValue(1, $id);
            $stmt->execute();
            if($stmt->rowCount() == 1) {
                $stmt = $property->runQuery("DELETE * FROM rentals WHERE PK_property_id=?");
                $stmt->bindValue(1, $id);
                $stmt->execute();
            }

            $stmt = $property->runQuery("SELECT * FROM sales WHERE PK_property_id=?");
            $stmt->bindValue(1, $id);
            $stmt->execute();
            if($stmt->rowCount() == 1) {
                $stmt = $property->runQuery("DELETE * FROM sales WHERE PK_property_id=?");
                $stmt->bindValue(1, $id);
                $stmt->execute();
            }
        }
        else if($status == 2){
            $stmt = $property->runQuery("SELECT * FROM rentals WHERE PK_property_id=?");
            $stmt->bindValue(1, $id);
            $stmt->execute();
            if($stmt->rowCount() == 1) {
                echo"
                    <script type='text/javascript'>
                        alert('Erro! esta propriedade já foi alugada');
                        window.location.replace(document.referrer);
                    </script>
                ";
            }
            else{
                $stmt = $property->runQuery("INSERT INTO rentals (PK_property_id, date) VALUES (?, ?)");
                $stmt->bindValue(1, $id);
                $stmt->bindValue(2, $date);
                $stmt->execute();
            }  
        }
        else if($status == 3){
            $stmt = $property->runQuery("SELECT * FROM sales WHERE PK_property_id=?");
            $stmt->bindValue(1, $id);
            $stmt->execute();
            if($stmt->rowCount() == 1) {
                echo"
                    <script type='text/javascript'>
                        alert('Erro! esta propriedade já foi vendida');
                        window.location.replace(document.referrer);
                    </script>
                ";
            }
            else{
                $stmt = $property->runQuery("INSERT INTO sales (PK_property_id, sale_date, sale_value) VALUES (?, ?, ?)");
                $stmt->bindValue(1, $id);
                $stmt->bindValue(2, $date);
                $stmt->bindValue(3, $price);
                $stmt->execute();
            }
        }
        if ($stmt) {
            echo"
                <script type='text/javascript'>
                    alert('Campo atualizado com sucesso!');
                    window.location.replace(document.referrer);
                </script>
            ";
        }
        else {
            echo"
                <script type='text/javascript'>
                    alert('ERRO! Este campo não foi atualizado');
                    window.location.replace(document.referrer);
                </script>
            ";
        }
    }
?>