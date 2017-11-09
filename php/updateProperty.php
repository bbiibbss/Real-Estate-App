<?php

    require('databaseConnection.php');
    require('propertyClass.php');
    
    $property = new Property();


    if(isset($_POST['updateProperty'])) {
        $id = $_POST['id'];
        $name = $_POST['property_name'];
        $description = $_POST['property_description'];
        $type = $_POST['property_type'];
        $typology = $_POST['property_typology'];
        $parish = $_POST['parish'];
        $address = $_POST['address'];
        $area = $_POST['area'];
        $bedrooms = $_POST['bedrooms'];
        $bathrooms = $_POST['bathrooms'];
        $latitude = $_POST['latitude'];
        $longitude = $_POST['longitude'];
        $businessType = $_POST['business_type'];
        $price = $_POST['price'];
        $manager = $_POST['manager'];
 
        try{
            $stmt = $property->runQuery("UPDATE property SET property_name=?, property_description=?, PK_property_type_id=?, PK_property_typology_id=?, PK_parish_id=?, address=?, area=?, bedrooms=?, bathrooms=?, latitude=?, longitude=?, PK_business_type_id=?, price=?, PK_user_id=?, PK_property_status_id=? WHERE property_id=?");
            $stmt->bindparam(1, $name);
            $stmt->bindparam(2, $description);
            $stmt->bindparam(3, $type);
            $stmt->bindparam(4, $typology);
            $stmt->bindparam(5, $parish);
            $stmt->bindparam(6, $address);
            $stmt->bindparam(7, $area);
            $stmt->bindparam(8, $bedrooms);
            $stmt->bindparam(9, $bathrooms);
            $stmt->bindparam(10, $latitude);
            $stmt->bindparam(11, $longitude);
            $stmt->bindparam(12, $businessType);
            $stmt->bindparam(13, $price);
            $stmt->bindparam(14, $manager);
            $stmt->bindValue(15, 1);
            $stmt->bindParam(16, $id);
            $stmt->execute();

            echo"
                <script type='text/javascript'>
                    alert('Propriedade Alterada');
                    window.location.replace(document.referrer);
                </script>
            ";
        }
        catch(PDOException $e) {
            echo $e->getMessage();
        }
  
    }

?>