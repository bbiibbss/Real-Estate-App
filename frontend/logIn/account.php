<?php
    require_once("../../php/session.php");
 
    require_once("../../php/userClass.php");
    $user = new USER();

    require_once("../../php/visitClass.php");
    $visit = new VISIT();
 
    require('../../php/propertyClass.php');
    $property = new Property();
     
    $user_id = $_SESSION['user_session'];
    
    try{
        $stmt = $user->runQuery("SELECT * FROM users WHERE user_id=:id");
        $stmt->execute(array(":id"=>$user_id));
        $userRow=$stmt->fetch(PDO::FETCH_ASSOC);
    }
    catch(PDOException $e) {
        echo $e->getMessage(); 
    }

    try{
        $stmt = $user->runQuery("SELECT * FROM preferences WHERE PK_user_id=?");
        $stmt->bindParam(1, $user_id);
        $stmt->execute();
        $preferencesRow=$stmt->fetch(PDO::FETCH_ASSOC);
    }
    catch(PDOException $e) {
        echo $e->getMessage(); 
    }
 
    include("../../php/updateUserData.php");
 
?>
 
<!DOCTYPE html>
<html>
<head>
    <link rel="icon" href="../../images/logo_icon.jpg">
    <title>Conta de utilizador</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../../css/stylesheet.css">
    <link rel="stylesheet" href="../../css/gridStyle.css">
    <script type="text/javascript" src="../../js/topNav.js"></script>
    <script type="text/javascript" src="../../js/passwordValidation.js"></script>
</head>
<body>
 
   <!-- Navigation Bar -->
 
   <div class="topnav" id="myTopnav">
        <a href="index.php" class="navBarItemHome"><i class="fa fa-home home"></i></a>
        <a href="propertySearch.php" class="navBarItem">Imóveis</a>
        <a href="about.php" class="navBarItem">Sobre Nós</a>
        <a href="account.php" class="navBarItem">Conta</a>
        <a href="../../php/logout.php?logout=true" class="navBarItem navBarItemLogin">LogOut</a>
        <a class="navBarItem navBarItemLogin">Bem vindo <?php print($userRow['first_name']); ?></a>
        <a href="javascript:void(0);" class="navBarItemHome icon" onclick="topNavFunction()"><i class="fa fa-bars"></i></a>
    </div>
 
 
    <div class="page w3-content w3-card-2 w3-white">
        <div class="row">
            <div class="col col-12">
                <div class="row">
                    <div class="tab">
                        <div class="col col-3">
                            <button class="tablinks" onclick="openFeaturedPropertyTab(event, 'UserData')" id="defaultOpen">Os meus dados</button>  
                        </div>
                        <div class="col col-3">
                            <button class="tablinks" onclick="openFeaturedPropertyTab(event, 'Preferences')">Preferências</button>
                        </div>
                        <div class="col col-3">
                            <button class="tablinks" onclick="openFeaturedPropertyTab(event, 'bookedVisits')"><?php echo($visit->getbookedVisitNumber($user_id)); ?> Visitas marcadas</button>
                        </div>
                        <div class="col col-3">
                            <button class="tablinks" onclick="openFeaturedPropertyTab(event, 'VisitRequests')">Pedidos de visita</button>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col col-12">
                        <div id="UserData" class="tabcontent">
                            <div class="row">
                                <div class="col col-6">
                                    <h5><b>Nome:</b> <?php print($userRow['first_name']);?></h5>
                                </div>
                                <div class="col col-6">
                                    <button class="w3-button w3-black w3-margin-bottom" onclick="document.getElementById('userFirstName').style.display='block'" style="width:auto;">Alterar</button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col col-6">
                                    <h5><b>Apelido:</b> <?php print($userRow['last_name']);?></h5>
                                </div>
                                <div class="col col-6">
                                    <button class="w3-button w3-black w3-margin-bottom" onclick="document.getElementById('userLastName').style.display='block'" style="width:auto;">Alterar</button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col col-6">
                                    <h5><b>Email</b> <?php print($userRow['email']);?></h5>
                                </div>
                                <div class="col col-6">
                                    <button class="w3-button w3-black w3-margin-bottom" onclick="document.getElementById('userEmail').style.display='block'" style="width:auto;">Alterar</button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col col-6">
                                    <h5><b>Contacto:</b> <?php print($userRow['phone_number']);?></h5>
                                </div>
                                <div class="col col-6">
                                    <button class="w3-button w3-black w3-margin-bottom" onclick="document.getElementById('userPhone').style.display='block'" style="width:auto;">Alterar</button>
                                </div>
                            </div>
                            <br>
                            <button class="w3-button w3-black w3-margin-bottom" onclick="document.getElementById('userPassword').style.display='block'" style="width:auto;">Alterar a minha password</button>
                            <br>
                        </div>
                        <div id="Preferences" class="tabcontent">
                            <div class="row user">
                                <div class="col col-5">
                                    <h5><b>Tipos de Negócio:</b></h5>
                                </div>
                                <div class="col col-7">
                                    <h5>
                                    <?php
                                        echo($preferencesRow['business_types']);
                                    ?>
                                    </h5>
                                </div>
                            </div>
                            <div class="row user">
                                <div class="col col-5">
                                    <h5><b>Tipos de Propriedade:</b></h5>
                                </div>
                                <div class="col col-7">
                                    <h5>
                                    <?php
                                        print($preferencesRow['property_types']);
                                    ?>
                                    </h5>
                                </div>
                            </div>
                            <div class="row user">
                                <div class="col col-5">
                                    <h5><b>Tipologias de Propriedade:</b></h5>
                                </div>
                                <div class="col col-7">
                                    <h5>
                                    <?php
                                        print($preferencesRow['property_typologies']);
                                    ?>
                                    </h5>
                                </div>
                            </div>
                            <div class="row user">
                                <div class="col col-5">
                                    <h5><b>Localizações:</b></h5>
                                </div>
                                <div class="col col-7">
                                    <h5>
                                    <?php
                                        print($preferencesRow['parishes']);
                                    ?></h5>
                                </div>
                            </div>
                            <div class="row user">
                                <div class="col col-5">
                                    <h5><b>Preço mínimo:</b></h5>
                                </div>
                                <div class="col col-7">
                                    <h5><?php
                                        if($preferencesRow['min_value']!=""){
                                            echo($preferencesRow['min_value']." ‎€");
                                        }
                                        echo("");
                                    ?></h5>
                                </div>
                            </div>
                            <div class="row user">
                                <div class="col col-5">
                                    <h5><b>Preço máximo:</b><br></h5>
                                </div>
                                <div class="col col-7">
                                    <h5>
                                    <?php
                                        if($preferencesRow['max_value']!=""){
                                            echo($preferencesRow['max_value']." ‎€");
                                        }
                                        echo("");
                                    ?></h5>
                                </div>
                            </div>
                            <br>
                            <button class="w3-button w3-black w3-margin-bottom" onclick="document.getElementById('userPreferences').style.display='block'" style="width:auto;">Alterar as minhas preferencias</button>
                            <br>
                        </div>
                        <div id="bookedVisits" class="tabcontent">
                            <?php $visit->getVisitUser($user_id); ?>
                        </div>
                        <div id="VisitRequests" class="tabcontent">
                            <?php $visit->getVisitRequestUser($user_id); ?>
                        </div>
                    </div>
                </div>
            </div>    
        </div>

        <script src='../../js/openFeaturedPropertyTab.js'></script>
 
 
        <!-- User details Modal -->
        <div id="userFirstName" class="modal">
            <!-- Modal content -->
            <div class="modal-content">
                <div class="modal-header">
                    <h4>Alterar nome</h4>
                    <div class='close' onclick="document.getElementById('userFirstName').style.display='none'">
                        <i class="fa fa-remove"></i>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="row w3-margin-bottom">
                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                            Nome
                            <input type="text" name="firstname" value="<?php echo($userRow['first_name']) ?>" pattern="[^0-9]+" required>
                            <br><br>
                            <button type="submit" name="submitFirstName">Alterar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
 
 
        <!-- User details Modal -->
        <div id="userLastName" class="modal">
            <!-- Modal content -->
            <div class="modal-content">
                <div class="modal-header">
                    <h4>Alterar apelido</h4>
                    <div class='close' onclick="document.getElementById('userLastName').style.display='none'">
                        <i class="fa fa-remove"></i>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="row w3-margin-bottom">
                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                            Apelido
                            <input type="text" name="lastname" value="<?php echo($userRow['last_name']) ?>" pattern="[^0-9]+" required>
                            <br><br>
                            <button type="submit" name="submitLastName">Alterar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
 
 
        <!-- User details Modal -->
        <div id="userPhone" class="modal">
            <!-- Modal content -->
            <div class="modal-content">
                <div class="modal-header">
                    <h4>Alterar contacto</h4>
                    <div class='close' onclick="document.getElementById('userPhone').style.display='none'">
                        <i class="fa fa-remove"></i>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="row w3-margin-bottom">
                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                            Número de telefone
                            <input type="text" name="phoneNumber" value="<?php echo($userRow['phone_number']) ?>" pattern="[0-9]+" required>
                            <br><br>
                            <button type="submit" name="submitPhoneNumber">Alterar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
 
 
        <!-- User details Modal -->
        <div id="userEmail" class="modal">
            <!-- Modal content -->
            <div class="modal-content">
                <div class="modal-header">
                    <h4>Alterar email</h4>
                    <div class='close' onclick="document.getElementById('userEmail').style.display='none'">
                        <i class="fa fa-remove"></i>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="row w3-margin-bottom">
                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                            Email
                            <input type="email" name="email" value="<?php echo($userRow['email']) ?>" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" required>
                            <br><br>
                            <button type="submit" name="submitEmail">Alterar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
 
 
        <!-- User details Modal -->
        <div id="userPassword" class="modal">
            <!-- Modal content -->
            <div class="modal-content">
                <div class="modal-header">
                    <span onclick="document.getElementById('userPassword').style.display='none'" class="close">&times;</span>
                    <h3>Alterar password</h3>
                </div>
                <div class="modal-body">
                    <div class="row w3-margin-bottom">
                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                            Password atual
                            <input type="password" name="oldPassword" required>
                            <br><br>
                            Nova Password <div class="tooltip"> <b>?</b><span class="tooltiptext">A password tem que ter:<br>8 caracteres,<br>uma letra maiúscula,<br>uma letra minúscula,<br>um número!</span></div>
                            <input type="password" id="password" title="A password tem que ter: 8 caracteres, uma letra maiúscula, uma letra minúscula, um número!" name="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" onkeyup="passwordChanged();" required>
                            <span id="strength"></span>
                            <span id="forca"></span>
                            <br><br>
                            Repita a nova password
                            <input type="password" onkeyup="return validatePassword();" name="passwordRepeat" id="passwordRepeat" required><br>
                            <span id="simbolo"></span>
                            <span id="iguais"></span>
                            <br><br>
                            <button type="submit" name="submitPass">Alterar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
 
        <!-- preferences details Modal -->
        <div id="userPreferences" class="modal">
            <!-- Modal content -->
            <div class="modal-content">
                <div class="modal-header">
                    <span onclick="document.getElementById('userPreferences').style.display='none'" class="close">&times;</span>
                    <h3>Alterar preferencias</h3>
                </div>
                <div class="modal-body">
                    <div class="row w3-margin-bottom">
                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" oninput="outputMin.value=parseInt(minPrice.value); outputMax.value=parseInt(maxPrice.value)">
                            <h3>O que procura?</h3>
                            <br>
                            <div class="row">
                                <div class="col col-4">
                                    <?php
                                        $property->getBusinessTypes();
                                    ?>
                                </div>
                                <div class="col col-4">
                                    <?php
                                        $property->getTypes();
                                    ?>
                                </div>
                                <div class="col col-4">
                                    <?php
                                        $property->getTypologies();
                                    ?>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col col-4">
                                    <?php
                                        $property->getIslandFilters();
                                    ?> 
                                </div>
                                <div class="col col-4">
                                    <?php
                                        $property->getCountyFilters();
                                    ?>
                                </div>
                                <div class="col col-4">
                                    <?php
                                        $property->getParishes();
                                    ?> 
                                </div>
                            </div>
                            <br>
                            <div class='row'>
                                <div class="col col-6">
                                    Preço mínimo
                                    <input type="number" id="minPrice" name="minPrice">
                                </div>
                                <div class="col col-6">
                                    Preço máximo
                                    <input type="number" id="maxPrice" name="maxPrice">
                                </div>
                            </div>
                            <br><br>
                             
                            <button type="submit" name="submitPreferences">Alterar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
         
         
     <!-- Footer -->
    <footer>
        <div>
        VerdeMar - Gestão Imobiliária
        </div>
        <div class="w3-large">
            <i class="socialMediaIcon fa fa-facebook-official w3-hover-opacity"></i>
            <i class="socialMediaIcon fa fa-instagram w3-hover-opacity"></i>
            <i class="socialMediaIcon fa fa-twitter w3-hover-opacity"></i>
            <i class="socialMediaIcon fa fa-linkedin w3-hover-opacity"></i>
        </div>
    </footer> 
</body>
</html>