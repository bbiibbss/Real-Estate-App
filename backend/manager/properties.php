<?php
   
    require_once("../../php/session.php");
    
    require_once("../../php/userClass.php");
    $auth_user = new USER();
    
    require('../../php/propertyClass.php');
    
    $property = new Property();
    
    $user_id = $_SESSION['user_session'];
    
    $stmt = $auth_user->runQuery("SELECT * FROM users WHERE user_id=:id");
    $stmt->execute(array(":id"=>$user_id));
    
    $userRow=$stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="icon" href="../../images/logo_icon.jpg">
    <title>Propriedades</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../../css/stylesheet.css">
    <link rel="stylesheet" href="../../css/gridStyle.css">
    <script type="text/javascript" src="../../js/topNav.js"></script>
    <script src='../../js/previewFile.js'></script>
    <script src='../../js/priceFilter.js'></script>
</head>
<body>

   <!-- Navigation Bar -->

    <div class="topnav" id="myTopnav">
        <a href="index.php" class="navBarItemHome"><i class="fa fa-bar-chart"></i></a>
        <a href="users.php" class="navBarItem">Utilizadores</a>
        <a href="properties.php" class="navBarItem">Propriedades</a>
        <a href="../../php/logout.php?logout=true" class="navBarItem navBarItemLogin">LogOut</a>
        <a href="javascript:void(0);" class="navBarItemHome icon" onclick="topNavFunction()"><i class="fa fa-bars"></i></a>
    </div>
   
    <div class="page properties">
        <div class="row">
            <div class="col col-2 scrollmenu" style="margin-bottom: 60px; padding-bottom: 200px;">

                <h3><i class="fa fa-search"></i> Pesquisa</h3>
                <br>
                <button class="accordion">Estado da propriedade:</button>
                <div class="panel">
                    <?php
                        $property->getPropertyStatusFilters();
                    ?>
                </div>
                <br>
                <button class="accordion">Tipo de negócio:</button>
                <div class="panel">
                    <?php
                        $property->getBusinessTypeFilters();
                    ?>
                </div>
                <br>
                <button class="accordion">Tipo da propriedade:</button>
                <div class="panel">
                    <?php
                        $property->getPropertyTypeFilters();
                    ?>
                </div>
                <br>
                <button class="accordion">Tipologia da propriedade:</button>
                <div class="panel">
                    <?php
                        $property->getPropertyTypologyFilters();
                    ?> 
                </div>
                <br>
                <button class="accordion">Intervalo de preço:</button>
                <div class="panel">
                    Preço mínimo:<br>
                    <input onchange="filterSystem(<?php echo($property->minPrice());?>, <?php echo($property->maxPrice());?>);" type="number" id="minPrice" name="minPrice" value="" min="<?php echo($property->minPrice());?>" max="<?php echo($property->maxPrice());?>">
                    <br><br>
                    Preço máximo:<br>
                    <input onchange="filterSystem(<?php echo($property->minPrice());?>, <?php echo($property->maxPrice());?>);" type="number" id="maxPrice" name="maxPrice" value="" min="<?php echo($property->minPrice());?>" max="<?php echo($property->maxPrice());?>">
                    <br><br>
                </div>
                <br>
                <button class="accordion">Localização:</button>
                <div class="panel">
                    <button class="accordion">Ilha:</button>
                    <div class="panel">
                        <?php
                            $property->getIslandFilters();
                        ?> 
                    </div>
                    <button class="accordion">Concelho:</button>
                    <div class="panel">
                        <?php
                            $property->getCountyFilters();
                        ?>
                    </div>
                    <button class="accordion">Freguesia:</button>
                    <div class="panel">
                        <?php
                            $property->getParishFilters();
                        ?> 
                    </div>
                </div>
            </div>
       
            <!-- Page content -->
            <div class="w3-content col col-10" style="margin-left:25%; width: 100%;">
                <div class="row">
                    <div class="col col-12">
                        <div class="row">
                            <div class="tab">
                                <div class="col col-4">
                                    <button class="tablinks" onclick="openFeaturedPropertyTab(event, 'All')" id="defaultOpen">Todas as Propriedades</button>  
                                </div>
                                <div class="col col-4">
                                    <button class="tablinks" onclick="openFeaturedPropertyTab(event, 'Featured')">Propriedades em Destaque</button>  
                                </div>
                                <div class="col col-3">
                                    <button class="tablinks" onclick="openFeaturedPropertyTab(event, 'Sugested')">Sugestões</button>
                                </div>
                                <div class="col col-1">
                                    <button data-toggle='modal' data-target='#view-create-property-modal' id='createProperty' class='btn backend'><i class="fa fa-plus"></i></button>
                                </div>
                            </div>
                        </div>
                        <div id="All" class="tabcontent">
                            <div class="row">
                                <i class='fa fa-file-pdf-o'></i> Imprimir ficheiro PDF || <i class='fa fa-bookmark'></i> Editar estado || <i class='fa fa-calendar-plus-o'></i> Sugerir para Featured || <i class='fa fa-remove'></i> Eliminar || <i class='fa fa-pencil'></i> Editar informação
                            </div>
                            <?php
                                $property->getAllPropertiesBackendManagerView($user_id);
                            ?>  
                        </div>
                        <div id="Featured" class="tabcontent">
                            <?php
                                $property->getAllFeaturedPropertiesBackendManagerView();
                            ?>  
                        </div>
                        <div id="Sugested" class="tabcontent">
                            <div class="row">
                                <i class='fa fa-remove'></i> Eliminar sugestão
                            </div>
                            <?php
                                $property->getAllSugestedPropertiesManagerView($user_id);
                            ?>
                        </div>
                    </div>
                </div>    
            </div>
        </div>
    </div>

    <script src='../../js/openFeaturedPropertyTab.js'></script>
    
    <script src='../../js/filters.js'></script>
    <script src='../../js/accordion.js'></script>


    <!-- MODAL -->
    <div id="view-create-property-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class='modal-dialog modal-lg'>
            <div class='modal-content'>
                <div class='modal-header'>
                    <span data-dismiss='modal' style='position: absolute;right: 25px;top: 0;color: #000;font-size: 35px;font-weight: bold; cursor: pointer;'>&times;</span>
                </div>
                <div class='modal-body'>
                    <form action='../../php/createProperty.php' method='post' enctype="multipart/form-data">
                        <div class='row'>
                            <div class='col col-12'>
                                <h4>Fotografia:</h4>
                                <div class="row">
                                    <div Class="col col-4">
                                        <img id='imgPreviewHouse' src='' style="width:100%;">
                                    </div>
                                    <div Class="col col-8">
                                        <input type="file" name="photoToUpload" id="photoToUpload" onchange="previewHouse();">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br><br>
                        <div class='row'>
                            <div class='col col-12'>
                                <h4>Nome da propriedade:</h4>
                                <input type='text' name="property_name" required>
                            </div>
                        </div>
                        <br><br>

                        <h4>Descrição da propriedade:</h4>
                        <textarea name='property_description' rows='5' style='width:100%;' required></textarea>
                        <br><br>

                        <div class='row'>
                            <div class='col col-6'>
                                <h4>Tipo da propriedade:</h4>
                                <select name="property_type" required>
                                    <option name="property_type" selected disabled>Selecione um tipo</option>
                                    <?php $property->getAllPropertyTypes(); ?>
                                </select>
                            </div>
                            <div class='col col-6'>
                                <h4>Tipologia da propriedade:</h4>
                                <select name="property_typology" required>
                                    <option name="property_typology" selected disabled>Selecione uma tipologia</option>
                                    <?php $property->getAllPropertyTypologies(); ?>
                                </select>
                            </div>
                        </div>
                        <br><br>

                        <div class='row'>
                            <div class='col col-4'>
                                <h4>Ilha:</h4>
                                <?php
                                    $property->getIslandFilters();
                                ?> 
                            </div>
                            <div class='col col-4'>
                                <h4>Concelho:</h4>
                                <?php
                                    $property->getCountyFilters();
                                ?>
                            </div>
                            <div class='col col-4'>
                                <h4>Freguesia:</h4>
                                <?php
                                    $property->getParishFilters();
                                ?> 
                            </div>
                             <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
                            <script src="../../js/filterselect.js"></script>
                        </div>
                        <br><br>

                        <div class='row'>
                            <div class='col col-12'>
                                <h4>Morada:</h4>
                                <input type='text' name='address' required>
                            </div>
                        </div>
                        <br><br>

                        <div class='row'>
                            <div class='col col-4'>
                                <h4>Área:</h4>
                                <input type='text' name='area' required>
                            </div>
                            <div class='col col-4'>
                                <h4>Quartos:</h4>
                                <input type='number' name='bedrooms'>
                            </div>
                            <div class='col col-4'>
                                <h4>Casas de banho:</h4>
                                <input type='number' name='bathrooms'>
                            </div>
                        </div>
                        <br><br>

                        <div class='row'>
                            <div class='col col-6'>
                                <h4>Latitude:</h4>
                                <input type='text' name='latitude' required>
                            </div>
                            <div class='col col-6'>
                                <h4>Longitude:</h4>
                                <input type='text' name='longitude' required>
                            </div>
                        </div>
                        <br><br>

                        <div class='row'>
                            <div class='col col-6'>
                                <h4>Tipo de negócio:</h4>
                                <select name="business_type" required>
                                    <option name="business_type" selected disabled>Selecione uma finalidade</option>
                                    <?php $property->getAllPropertyBusinessTypes(); ?>
                                </select>
                            </div>
                        <div class='col col-6'>
                            <h4>Preço:</h4>
                            <input type='text' name='price'>
                        </div>
                        </div>
                        <br><br>

                        <h4>Agente responsável:</h4>
                        <select name="manager" required>
                            <option name="manager" selected disabled>Selecione uma gestor</option>
                            <?php $property->getAllUserIds(); ?>
                        </select>
                        <br><br>

                        <button style="color:#fff;" type="submit" name='submitProperty'><i class="fa fa-plus"></i> Criar Proprieade</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<script src='../../js/checkboxFilter.js'></script>
   
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