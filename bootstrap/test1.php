<?php

    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "images_gallery_carousel";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "Connected successfully";

        $stmt = $conn->prepare("SELECT * FROM featured_gallery"); 
        $stmt->execute();

        $arr=array();
        $arrid=array();
        $num=1;
        foreach($stmt AS $row) {
            if($num==1){
                array_push($arrid, "<li data-target='#myCarousel' data-slide-to='".$row["id"]."' class='active'></li>");
                
                array_push($arr, "<div class='item active'><img src='img/".$row["photo_path"]."' alt='".$row["subtitle"]."' style='width:100%;''><div class='carousel-caption'><h3>".$row["subtitle"]."</h3><p>".$row["description"]."</p></div></div>");
            }
            else{
                array_push($arrid, "<li data-target='#myCarousel' data-slide-to='".$row["id"]."'></li>");
                
                array_push($arr, "<div class='item'><img src='img/".$row["photo_path"]."' alt='".$row["subtitle"]."' style='width:100%;''><div class='carousel-caption'><h3>".$row["subtitle"]."</h3><p>".$row["description"]."</p></div></div>");
            }
            $num+=1;
        }
    }
    catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Bootstrap Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

    <div class="container">
        <h2>Carousel Example</h2>
        <div id="myCarousel" class="carousel slide" data-ride="carousel">
            <!-- Indicators -->
            <ol class="carousel-indicators">
                <?php echo(implode("", $arrid)); ?>
            </ol>

            <!-- Wrapper for slides -->
            <div class="carousel-inner">
               <?php echo(implode("", $arr)); ?>
            </div>

            <!-- Left and right controls -->
            <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control" href="#myCarousel" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>

</body>
</html>
