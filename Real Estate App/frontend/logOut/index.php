<?php

    session_start();
    require('../../php/propertyClass.php');
    $property = new Property();

    require_once('../../php/userClass.php');
    $user = new USER();

    try {
        $stmt = $property->runQuery("SELECT * FROM featured AS ft JOIN property AS ppt JOIN business_type AS bt ON ft.PK_property_id=ppt.property_id AND ppt.PK_business_type_id=bt.business_type_id"); 
        $stmt->execute();

        $arr=array();
        $arrid=array();
        if($stmt->rowCount()==0){
            array_push($arrid, "<li data-target='#carousel-featured-properties' data-slide-to='0' class='active'></li>");

            array_push($arr, "<div class='active item'><img src='../../images/house.jpg' alt='VerdeMar' class='carousel-image'><div class='carousel-caption'><h3>VerdeMar Imobiliária</h3></div></div>");
        }
        else{
            $num=0;
            foreach($stmt AS $row) {
                if($num==0){
                    array_push($arrid, "<li data-target='#carousel-featured-properties' data-slide-to='".$num."' class='active'></li>");
                        
                    array_push($arr, "<div data-toggle='modal' data-target='#myModal-".$row["property_id"]."' id='propertyShow' style='cursor:pointer;' class='active item'><div class='row'><div class='col col-4'><div class='carousel-caption'><h3>".$row["property_name"]."</h3><br><h4>".$row["business_type_name"]."</h4><br><h5>".$row["area"]." m<sup>2</sup></h5><br><h4>".$row["price"]."  ‎€</h4></div></div><div class='col col-8'><img src='../".$row["photo_path"]."' alt='".$row["property_name"]."' class='carousel-image'></div></div></div>");
                } else{
                    array_push($arrid, "<li data-target='#carousel-featured-properties' data-slide-to='".$num."'></li>");
                        
                    array_push($arr, "<div data-toggle='modal' data-target='#myModal-".$row["property_id"]."' id='propertyShow' style='cursor:pointer;' class='item'><div class='row'><div class='col col-4'><div class='carousel-caption'><h3>".$row["property_name"]."</h3><br><h4>".$row["business_type_name"]."</h4><br><h5>".$row["area"]." m<sup>2</sup></h5><br><h4>".$row["price"]."  ‎€</h4></div></div><div class='col col-8'><img src='../".$row["photo_path"]."' alt='".$row["property_name"]."' class='carousel-image'></div></div></div>");
                }  
                ++$num;
            } 
        }     
    }
    catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="icon" href="../../images/logo_icon.jpg">
    <title>VerdeMar - Gestão Imobiliária</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../../css/stylesheet.css">
    <link rel="stylesheet" href="../../css/gridStyle.css">
    <script type="text/javascript" src="../../js/topNav.js"></script>
    <script type="text/javascript" src="../../js/slideshow.js"></script>
</head>
<body>

    <div class="topnav" id="myTopnav">
        <a href="index.php" class="navBarItemHome"><i class="fa fa-home home"></i></a>
        <a href="propertySearch.php" class="navBarItem">Imóveis</a>
        <a href="about.php" class="navBarItem">Sobre Nós</a>
        <a href="login.php" class="navBarItem navBarItemLogin">Login</a>
        <a href="javascript:void(0);" class="navBarItemHome icon" onclick="topNavFunction()"><i class="fa fa-bars"></i></a>
    </div>

   
    <div id="startchange"></div>
    <div id="carousel-featured-properties" class="carousel slide" data-ride="carousel">
        <div class="slideshow_container">  
            <ol class="carousel-indicators">
                <?php echo(implode("", $arrid)); ?>
            </ol>
            <div class="carousel-inner">
                <?php echo(implode("", $arr)); ?>
            </div>
        </div>
            <a class="left carousel-control" href="#carousel-featured-properties" role="button" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left"></span>
            </a>
            <a class="right carousel-control" href="#carousel-featured-properties" role="button" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right"></span>
            </a>
    </div>
    <div class=" page w3-content w3-card-2 w3-white">
        <div class="w3-container w3-margin-top">
            <h3>Destaques</h3>
        </div>
        <div class="row">
            <?php
                $property->getAllFeaturedProperties();
            ?>
        </div>
    </div>

    <footer>
        <div>
        VerdeMar - Gestão Imobiliária
        </div>
        <div>
            <i class="socialMediaIcon fa fa-facebook-official w3-hover-opacity"></i>
            <i class="socialMediaIcon fa fa-instagram w3-hover-opacity"></i>
            <i class="socialMediaIcon fa fa-twitter w3-hover-opacity"></i>
            <i class="socialMediaIcon fa fa-linkedin w3-hover-opacity"></i>
        </div>
    </footer> 
</body>
</html>