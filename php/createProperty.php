<?php

    require('databaseConnection.php');
    require('propertyClass.php');
    
    $property = new Property();

    if(isset($_POST['submitProperty'])) {
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

        $fileName = filter_var($name, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
        $fileAddress = filter_var($address, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
 
        $target_dir = "C:/xampp/htdocs/PWII-PROJECT/images/properties/".$fileName."_".$fileAddress."/";
        
        if(!is_dir($target_dir)) {
            mkdir("$target_dir");
            chmod("$target_dir", 0755);
        }

        $target_file = $target_dir . basename($_FILES["photoToUpload"]["name"]);
        $uploadOk = 1;
        $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

        if ($_FILES["fileToUpload"]["size"] > 500000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }
        $check = getimagesize($_FILES["photoToUpload"]["tmp_name"]);
        if($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "File is not an image.". $check["mime"];
            $uploadOk = 0;
        }
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        } else {
            if (move_uploaded_file($_FILES["photoToUpload"]["tmp_name"], $target_file)) {
                echo "The file ". basename( $_FILES["photoToUpload"]["name"]). " has been uploaded.";
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }

        $file="../images/properties/".$fileName."_".$fileAddress."/".$_FILES["photoToUpload"]["name"];

        try{
            $stmt = $property->runQuery("INSERT INTO property (property_name, property_description, photo_path, PK_property_type_id, PK_property_typology_id, PK_parish_id, address, area, bedrooms, bathrooms, latitude, longitude, PK_business_type_id, price, PK_user_id, PK_property_status_id) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
            $stmt->bindparam(1, $name);
            $stmt->bindparam(2, $description);
            $stmt->bindparam(3, $file);
            $stmt->bindparam(4, $type);
            $stmt->bindparam(5, $typology);
            $stmt->bindparam(6, $parish);
            $stmt->bindparam(7, $address);
            $stmt->bindparam(8, $area);
            $stmt->bindparam(9, $bedrooms);
            $stmt->bindparam(10, $bathrooms);
            $stmt->bindparam(11, $latitude);
            $stmt->bindparam(12, $longitude);
            $stmt->bindparam(13, $businessType);
            $stmt->bindparam(14, $price);
            $stmt->bindparam(15, $manager);
            $stmt->bindValue(16, 1);
            $stmt->execute();
        }
        catch(PDOException $e) {
            echo $e->getMessage();
        }
        /*    
        echo "
            <script type='text/javascript'>
                alert('Propriedade criada!<br>Foto gurdadaem: $path$photoName');
                window.location.replace(document.referrer);
            </script>
        ";   */
    }

?>