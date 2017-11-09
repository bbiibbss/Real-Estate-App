<?php
	require_once('databaseConnection.php');

	class PROPERTY{

		private $conn;
     
        public function __construct() {
            $database = new Database();
            $db = $database->dbConnection();
            $this->conn = $db;
        }

        public function runQuery($sql) {
            $stmt = $this->conn->prepare($sql);
            return $stmt;
        }

		public function getAllFeaturedProperties(){
            $stmt = $this->conn->prepare("SELECT * FROM featured AS ft INNER JOIN property AS ppt INNER JOIN property_type AS pptt INNER JOIN property_typology AS pptty INNER JOIN island AS isl INNER JOIN county AS cnty INNER JOIN parish AS par INNER JOIN business_type AS bt INNER JOIN users AS u
                ON ft.PK_property_id=ppt.property_id AND ppt.PK_property_type_id = pptt.property_type_id AND ppt.PK_property_typology_id = pptty.property_typology_id AND ppt.PK_parish_id = par.parish_id AND par.PK_county_id=cnty.county_id AND cnty.PK_island_id = isl.island_id AND ppt.PK_business_type_id = bt.business_type_id AND ppt.PK_user_id = u.user_id WHERE PK_property_status_id=?");
            $stmt->bindValue(1, 1);
            $stmt->execute();

            if (!$result = $stmt) {
                die ('ERRO ['.$db->error.']');
                return;
            }
            foreach ($result as $row) {
                if($row["bathrooms"]==0 || $row["bathrooms"]==NULL){
                    $bathrooms="";
                }
                else{
                    $bathrooms="<p><i class='fa fa-fw fa-bath'></i> ".$row["bathrooms"]."</p>";
                }
                if($row["bedrooms"]==0 || $row["bedrooms"]==NULL){
                    $bedrooms="";
                }
                else{
                    $bedrooms="<p><i class='fa fa-fw fa-bed'></i> ".$row["bedrooms"]."</p>";
                }
                if($row["property_typology_name"]=="n/a" || $row["property_typology_name"]==NULL){
                    $typology="";
                }
                else{
                    $typology="<p>".$row["property_typology_name"]."</p>";
                }
                if($row["price"]=="" || $row["price"]==NULL){
                    $price="Preço sob consulta";
                }
                else{
                    $price="<p><b>".$row["price"]." &euro;</b></p>";
                }

                $id=$row['property_id'];
                echo"
                    <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
                    <script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js'></script>
                    
                    <div class='col col-4'>
                        <div class='row'>
                            <div class='col col-12'>
                                <img class='pptys' src='../".$row["photo_path"]."'>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col col-12'>
                            <h4><b>Ref: ".$row["property_id"]."</b> || ".$row["property_name"]."</h4>
                            <h6>".$price."</h6>
                            <p>".$row["island_name"]."-".$row["county_name"]."-".$row["parish_name"]."</p>
                            <h5>".$row["area"]." m<sup>2</sup></h5>
                            </div>
                        </div>
                        <div class='row'>
                            <button data-toggle='modal' data-target='#myModal-".$id."' id='propertyShow' style='cursor:pointer;'>Ver Mais</button>
                        </div>
                    </div>

                    <!-- Modal -->
                    <div class='modal fade' id='myModal-".$id."' role='dialog'>
                        <div class='modal-dialog modal-lg'>
                            <!-- Modal content-->
                            <div class='modal-content'>
                                <div class='modal-header'>
                                    <h3 class='modal-title'>".$row["property_name"]."</h3>
                                    <span data-dismiss='modal' Style='position: absolute;right: 25px;top: 0;color: #000;font-size: 35px;font-weight: bold; cursor: pointer;'>&times;</span>
                                </div>
                                <div class='modal-body'>
                                    <div class='row w3-margin-bottom'>
                                        <div class='col col-5'>
                                            <img class='ppty1' src='../".$row["photo_path"]."'>
                                        </div>
                                        <div class='col col-7 w3-container w3-white'>
                                            <h5><b>".$row["price"]." &euro;</b></h5>
                                            <p>".$row["business_type_name"]."</p>
                                            <p>Área: ".$row["area"]." m<sup>2</sup></p>
                                            <p>".$row["property_type_name"]."</p>
                                            ".$typology."
                                            ".$bathrooms."
                                            ".$bedrooms."
                                            <p></b>Morada:</b> ".$row["address"]."</p>
                                            <p><b>Agente Responsável:</b> ".$row["first_name"]." ".$row["last_name"]."</p>
                                        </div>
                                    </div>
                                    <div class='row'>
                                        <p>".$row["property_description"]."</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                ";
            }     
        }

        public function getAllProperties(){
        	$stmt = $this->conn->prepare("SELECT * FROM property AS ppt JOIN property_type AS pptt JOIN property_typology AS pptty JOIN island AS isl JOIN county AS cnty JOIN parish AS par JOIN business_type AS bt JOIN users AS u
        		ON ppt.PK_property_type_id = pptt.property_type_id AND ppt.PK_property_typology_id = pptty.property_typology_id AND par.PK_county_id = cnty.county_id AND cnty.PK_island_id = isl.island_id AND ppt.PK_parish_id = par.parish_id AND ppt.PK_business_type_id = bt.business_type_id AND ppt.PK_user_id = u.user_id WHERE PK_property_status_id=?");
            $stmt->bindValue(1, 1);
        	$stmt->execute();
        	if (!$result = $stmt) {
        		die ('ERRO ['.$db->error.']');
        		return;
    		}

    	
    		foreach ($result as $row) {
                if($row["bathrooms"]==0 || $row["bathrooms"]==NULL){
                    $bathrooms="";
                }
                else{
                    $bathrooms="<p><i class='fa fa-fw fa-bath'></i> ".$row["bathrooms"]."</p>";
                }
                if($row["bedrooms"]==0 || $row["bedrooms"]==NULL){
                    $bedrooms="";
                }
                else{
                    $bedrooms="<p><i class='fa fa-fw fa-bed'></i> ".$row["bedrooms"]."</p>";
                }
                 if($row["property_typology_name"]=="n/a" || $row["property_typology_name"]==NULL){
                    $typology="";
                }
                else{
                    $typology="<p>".$row["property_typology_name"]."</p>";
                }
                         
    			$btn1 = strtolower(str_replace(' ', '', $row["business_type_name"]));
    			$btn = filter_var($btn1, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

    			$ptn1 = strtolower(str_replace(' ', '', $row["property_type_name"]));
    			$ptn = filter_var($ptn1, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

    			$ptyn1 = strtolower(str_replace(' ', '', $row["property_typology_name"]));
    			$ptyn = filter_var($ptyn1, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

    			$in1 = strtolower(str_replace(' ', '', $row["island_name"]));
    			$in = filter_var($in1, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

    			$cn1 = strtolower(str_replace(' ', '', $row["county_name"]));
    			$cn = filter_var($cn1, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

    			$pn1 = strtolower(str_replace(' ', '', $row["parish_name"]));
    			$pn = filter_var($pn1, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

    			$id=$row['property_id'];
    			echo"
                    <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
                    <script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js'></script>
					
					<div data-toggle='modal' data-target='#myModal-".$id."'  class='row w3-margin-bottom propertyShow' id='propertyShow' data-price='".$row["price"]."' data-category='".$btn." ".$ptn." ".$ptyn." ".$in." ".$cn." ".$pn."' style='cursor:pointer;'>
	                    <div class='col col-4'>
	                        <img class='pptys' src='../".$row["photo_path"]."'>
	                    </div>
	                    <div class='col col-6 w3-container w3-white'>
                            <div class='row'>
                                <h3><b>Ref: ".$row["property_id"]."</b> || ".$row["property_name"]."</h3>
                            </div>
                            <div class='row'>
                                <div class='col col-8'>
                                    <p><b>".$row["price"]." &euro;</b></p>
                                </div>
                                <div class='col col-4'>
                                    <p>".$row["business_type_name"]."</p>
                                </div>
                            </div>
                            <div class='row'>
                                <div class='col col-8'>
                                    <p>".$row["address"]."</p>
                                </div>
                                <div class='col col-4'>
                                    <p>".$row["area"]." m<sup>2</sup></p>
                                </div>
                            </div>
	                    </div>
	                    <div class='col col-2'>
	                    	<img style='max-width:100%;' src='../../images/info.png'>
	                	</div>
	                </div>

					<!-- Modal -->
					<div class='modal fade' id='myModal-".$id."' role='dialog'>
					    <div class='modal-dialog modal-lg'>
					        <!-- Modal content-->
					        <div class='modal-content'>
					            <div class='modal-header'>
					                <h3 class='modal-title'>".$row["property_name"]."</h3>
					                <span data-dismiss='modal' Style='position: absolute;right: 25px;top: 0;color: #000;font-size: 35px;font-weight: bold; cursor: pointer;'>&times;</span>
					            </div>
					            <div class='modal-body'>
					                <div class='row w3-margin-bottom'>
					                    <div class='col col-5'>
					                        <img class='ppty' src='../".$row["photo_path"]."'>
					                    </div>
					                    <div class='col col-7 w3-container w3-white'>
					                        <h5><b>".$row["price"]." &euro;</b></h5>
					                        <p>".$row["business_type_name"]."</p>
					                        <p>Área: ".$row["area"]." m<sup>2</sup></p>
					                        <p>".$row["property_type_name"]."</p>
					                        ".$typology."
					                        ".$bathrooms."
                                            ".$bedrooms."
					                        <p></b>Morada:</b> ".$row["address"]."</p>
					                        <p><b>Agente Responsável:</b> ".$row["first_name"]." ".$row["last_name"]."</p>
					                    </div>
					                </div>
                                    <div class='row'>
                                        <p>".$row["property_description"]."</p>
                                    </div>
					            </div>
					        </div>
					    </div>
					</div>
    			";
	        }     
	    }
        
	    public function getBusinessTypeFilters(){
            $stmt = $this->conn->prepare("SELECT * FROM business_type");
            $stmt->execute();

    		foreach ($stmt as $row) {
    			$btID=$row['business_type_id'];
    			$btName=$row['business_type_name'];
    			$replace = strtolower(str_replace(' ', '', $btName));
    			$value = filter_var($replace, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
    			echo"
                    <input type='checkbox' name='businessType' id='".$value."' value='".$value."'> ".$btName."<br>
    			";
	        }      
        }

        public function getPropertyTypeFilters(){
            $stmt = $this->conn->prepare("SELECT * FROM property_type");
            $stmt->execute();

    		foreach ($stmt as $row) {
    			$ptID=$row['property_type_id'];
    			$ptName=$row['property_type_name'];
    			$replace = strtolower(str_replace(' ', '', $ptName));
    			$value = filter_var($replace, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
    			echo"
                    <input type='checkbox' name='propertyType' id='".$value."' value='".$value."'> ".$ptName."<br>
    			";
	        }     
        }

        public function getPropertyTypologyFilters(){
            $stmt = $this->conn->prepare("SELECT * FROM property_typology");
            $stmt->execute();

    		foreach ($stmt as $row) {
    			$ptyID=$row['property_typology_id'];
    			$ptyName=$row['property_typology_name'];
    			$replace = strtolower(str_replace(' ', '', $ptyName));
    			$value = filter_var($replace, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
                if($ptyName=='n/a'){
                    echo"";
                }
                else{
                echo"
                    <input type='checkbox' name='propertyTypology' id='".$value."' value='".$value."'> ".$ptyName."<br>
                ";
                }
	        }     
        }

        public function getPropertyStatusFilters(){
            $stmt = $this->conn->prepare("SELECT * FROM property_status");
            $stmt->execute();

            foreach ($stmt as $row) {
                $psID=$row['property_status_id'];
                $psName=$row['property_status_name'];
                $replace = strtolower(str_replace(' ', '', $psName));
                $value = filter_var($replace, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
                echo"
                    <input type='checkbox' name='propertyStatus' id='".$value."' value='".$value."'> ".$psName."<br>
                ";
            }      
        }

        public function getIslandFilters(){
            $stmt = $this->conn->prepare("SELECT * FROM island");
            $stmt->execute();

    		foreach ($stmt as $row) {
    			$islID=$row['island_id'];
    			$islName=$row['island_name'];
    			$replace = strtolower(str_replace(' ', '', $islName));
    			$value = filter_var($replace, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
    			echo"
    				<input type='checkbox' data-type='island' name='island' id='".$value."' value='".$islID."'> ".$islName."<br>
    			";
	        }     
        }

        public function getCountyFilters(){
            $stmt = $this->conn->prepare("SELECT * FROM county AS cnty JOIN island AS isl on cnty.PK_island_id=isl.island_id");
            $stmt->execute();

    		foreach ($stmt as $row) {
    			$cntID=$row['county_id'];
    			$cntName=$row['county_name'];
                $replace = strtolower(str_replace(' ', '', $cntName));
                $value = filter_var($replace, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

    			$islName=$row['island_name'];
                $replaceISL = strtolower(str_replace(' ', '', $islName));
                $islValue = filter_var($replaceISL, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
    			echo"
        			<div class='county' data-category='".$islValue."'>
        				<input type='checkbox' name='county' id='".$value."' value='".$value."'> ".$cntName."
    				</div>
    			";
	        }     
        }

        public function getParishFilters(){
            $stmt = $this->conn->prepare("SELECT * FROM parish AS prs JOIN county AS cnty JOIN island AS isl ON cnty.PK_island_id=isl.island_id AND prs.PK_county_id=cnty.county_id");
            $stmt->execute();

    		foreach ($stmt as $row) {
    			$prshID=$row['parish_id'];
    			$prshName=$row['parish_name'];
    			$replace = strtolower(str_replace(' ', '', $prshName));
    			$value = filter_var($replace, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

                $cntyName=$row['county_name'];
                $replaceCnty = strtolower(str_replace(' ', '', $cntyName));
                $cntyValue = filter_var($replaceCnty, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

                $islName=$row['island_name'];
                $replaceIsl = strtolower(str_replace(' ', '', $islName));
                $islValue = filter_var($replaceIsl, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

    			echo"
                    <div class='parish' data-category='".$cntyValue." ".$islValue."'>
        				<input type='checkbox' name='parish' id='".$value."' value='".$prshID."'> ".$prshName."
                    </div>
    			";
	        }     
        }
                
        public function addGoogleMapsMarker(){
            $stmt = $this->conn->prepare("SELECT * FROM property AS ppt JOIN property_type AS pptt JOIN property_typology AS pptty JOIN island AS isl JOIN county AS cnty JOIN parish AS par JOIN business_type AS bt JOIN users AS u
                ON ppt.PK_property_type_id = pptt.property_type_id AND ppt.PK_property_typology_id = pptty.property_typology_id AND par.PK_county_id = cnty.county_id AND cnty.PK_island_id = isl.island_id AND ppt.PK_parish_id = par.parish_id AND ppt.PK_business_type_id = bt.business_type_id AND ppt.PK_user_id = u.user_id WHERE PK_property_status_id=?");
            $stmt->bindValue(1, 1);
            $stmt->execute();

            foreach ($stmt as $row) {
                $ptn = filter_var(strtolower(str_replace(' ', '', $row["property_type_name"])), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
               
                $lat=$row['latitude'];
                $long=$row['longitude'];
                $id=$row['property_id'];
                $bt=$row['business_type_name'];
                $name=$row['property_name'];
                $address=$row['address'];
                $price=$row['price'];
                $pin=$row['pin'];

                echo"
                    var ppty".$id." = new google.maps.LatLng(".$lat.", ".$long.");
                    var marker".$id." = new google.maps.Marker(
                        {
                            id: ".$id.",
                            position:ppty".$id.",
                            animation: google.maps.Animation.DROP,
                            icon:'../../images/pins/".$pin."',
                            category:'".$ptn."'
                        }
                    );

                    marker".$id.".setMap(map);
                    
                    google.maps.event.addListener(marker".$id.", 'click', function() {
                        map.setZoom(12);
                        map.setCenter(marker".$id.".getPosition());
                        $('#myModal-".$id."').modal('show')
                    });

                    google.maps.event.addListener(marker".$id.",'mouseover',function() {
                        var infowindow".$id." = new google.maps.InfoWindow(
                            {
                                content:'".$name."<br>".$price."‎€ - ".$bt."<br>$address'
                            });
                    infowindow".$id.".open(map,marker".$id.");
                });
                ";
            }
        }

        public function addPin(){
            $stmt = $this->conn->prepare("SELECT * FROM property AS ppt JOIN property_type AS pptt JOIN property_typology AS pptty JOIN island AS isl JOIN county AS cnty JOIN parish AS par JOIN business_type AS bt JOIN users AS u
                ON ppt.PK_property_type_id = pptt.property_type_id AND ppt.PK_property_typology_id = pptty.property_typology_id AND par.PK_county_id = cnty.county_id AND cnty.PK_island_id = isl.island_id AND ppt.PK_parish_id = par.parish_id AND ppt.PK_business_type_id = bt.business_type_id AND ppt.PK_user_id = u.user_id WHERE PK_property_status_id=?");
            $stmt->bindValue(1, 1);
            $stmt->execute();

            foreach ($stmt as $row) {
                $id=$row['property_id'];

                echo"      
                    filterMarkers = function (category) {
                        if (marker".$id.".category == category || category.length === 0) {
                            marker".$id.".setVisible(true);
                        }
                        else {
                            marker".$id.".setVisible(false);
                        }
                    }
                ";
            }
        }

        public function getLabels(){
            $stmt = $this->conn->prepare("SELECT * FROM property_type");
            $stmt->execute();
            foreach ($stmt as $row) {
                $name=$row['property_type_name'];
                $pin=$row['pin'];

                echo"
                    <div><img src='../../images/pins/".$pin."''> ".$name."</div><br>
                ";

            } 
        }

        public function getAllFeaturedPropertiesLogin($userId){
            $stmt = $this->conn->prepare("SELECT * FROM featured AS ft INNER JOIN property AS ppt INNER JOIN property_type AS pptt INNER JOIN property_typology AS pptty INNER JOIN island AS isl INNER JOIN county AS cnty INNER JOIN parish AS par INNER JOIN business_type AS bt INNER JOIN users AS u
                ON ft.PK_property_id=ppt.property_id AND ppt.PK_property_type_id = pptt.property_type_id AND ppt.PK_property_typology_id = pptty.property_typology_id AND ppt.PK_parish_id = par.parish_id AND par.PK_county_id=cnty.county_id AND cnty.PK_island_id = isl.island_id AND ppt.PK_business_type_id = bt.business_type_id AND ppt.PK_user_id = u.user_id WHERE PK_property_status_id=?");
            $stmt->bindValue(1, 1);
            $stmt->execute();

            if (!$result = $stmt) {
                die ('ERRO ['.$db->error.']');
                return;
            }
            foreach ($result as $row) {
                $id=$row['property_id'];
                echo"
                    <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
                    <script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js'></script>
                    
                    <div class='row w3-margin-bottom' data-category='".$row["business_type_name"]." ".$row["property_type_name"]." ".$row["property_typology_name"]." ".$row["island_name"]." ".$row["county_name"]." ".$row["parish_name"]."'>
                        <div class='col col-4'>
                            <img class='ppty' src='../".$row["photo_path"]."'>
                        </div>
                        <div class='col col-6 w3-container w3-white'>
                            <h3>".$row["property_name"]."</h3>
                            <h6 class='w3-opacity'>".$row["price"]." &euro;</h6>
                            <p>".$row["business_type_name"]."</p>
                            <p>".$row["area"]." m<sup>2</sup></p>
                        </div>
                        <div class='col col-2'>
                            <button type='button' class='btn btn-info btn-lg' data-toggle='modal' data-target='#myModal-".$id."' style='background-color:#223A5E; border: none;'>Ver Mais</button>
                        </div>
                    </div>

                    <!-- Modal -->
                <div class='modal fade' id='myModal-".$id."' role='dialog'>
                    <div class='modal-dialog modal-lg'>
                        <!-- Modal content-->
                        <div class='modal-content'>
                            <div class='modal-header'>
                                <h3 class='modal-title'>".$row["property_name"]."</h3>
                                <span data-dismiss='modal' Style='position: absolute;right: 25px;top: 0;color: #000;font-size: 35px;font-weight: bold; cursor: pointer;'>&times;</span>
                            </div>
                            <div class='modal-body'>
                                <div class='row w3-margin-bottom'>
                                    <div class='col col-5'>
                                        <img class='ppty1' src='../".$row["photo_path"]."'>
                                    </div>
                                    <div class='col col-7 w3-container w3-white'>
                                        <h5><b>".$row["price"]." &euro;</b></h5>
                                        <p>".$row["business_type_name"]."</p>
                                        <p>Área: ".$row["area"]." m<sup>2</sup></p>
                                        <p>".$row["property_type_name"]."</p>
                                        <p>".$row["property_typology_name"]."</p>
                                        <p><i class='fa fa-fw fa-bath'></i> ".$row["bathrooms"]."</p>
                                        <p><i class='fa fa-fw fa-bed'></i> ".$row["bedrooms"]."</p>
                                        <p>Morada: ".$row["address"]."</p>
                                        <p>Agente Responsável: ".$row["first_name"]." ".$row["last_name"]."</p>
                                        <br>
                                    </div>
                                </div>
                                <div class='row'>
                                    <div class='col col-12'>
                                        <p>".$row["property_description"]."</p>
                                    </div>
                                </div>
                                <div class='row'>
                                    <div class='col col-12'>
                                        <button type='button' data-toggle='modal' data-target='#myModalVisit-".$id."'>Marcar Visita</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- VISIT MODAL -->
                <div class='container'>
                    <div class='modal fade' id='myModalVisit-".$id."' role='dialog'>
                        <div class='modal-dialog modal-sm'>
                            <div class='modal-content'>
                                <div class='modal-header'>
                                    <h4 class='modal-title'>".$row["property_name"]."</h4>
                                    <div class='close' data-dismiss='modal'>&times;</div>
                                </div>
                                <div class='modal-body'>
                                    <form method='post' action='../../php/visit.php'>
                                        <input type='hidden' name='propertyId' value='".$id."'>
                                        <input type='hidden' name='userId' value='".$userId."'>
                                        <h5><b>Observações:</b></h5>
                                        <textarea id='observations' name='observations' rows='4' style='width:100%;'></textarea>
                                        <br><br>
                                        <h5><b>Data e Hora:</b></h5>
                                        <input type='datetime-local' name='visitDate'>
                                        <br>
                                        <button type='submit' name='submitVisitRequest'>Marca Visita</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                ";
            }     
        }

        public function getAllPropertiesLogin($userId){
            $stmt = $this->conn->prepare("SELECT * FROM property AS ppt JOIN property_type AS pptt JOIN property_typology AS pptty JOIN island AS isl JOIN county AS cnty JOIN parish AS par JOIN business_type AS bt JOIN users AS u
                ON ppt.PK_property_type_id = pptt.property_type_id AND ppt.PK_property_typology_id = pptty.property_typology_id AND par.PK_county_id = cnty.county_id AND cnty.PK_island_id = isl.island_id AND ppt.PK_parish_id = par.parish_id AND ppt.PK_business_type_id = bt.business_type_id AND ppt.PK_user_id = u.user_id WHERE PK_property_status_id=?");
            $stmt->bindValue(1, 1);
            $stmt->execute();
            if (!$result = $stmt) {
                die ('ERRO ['.$db->error.']');
                return;
            }

        
            foreach ($result as $row) {
                $btn1 = strtolower(str_replace(' ', '', $row["business_type_name"]));
                $btn = filter_var($btn1, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

                $ptn1 = strtolower(str_replace(' ', '', $row["property_type_name"]));
                $ptn = filter_var($ptn1, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

                $ptyn1 = strtolower(str_replace(' ', '', $row["property_typology_name"]));
                $ptyn = filter_var($ptyn1, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

                $in1 = strtolower(str_replace(' ', '', $row["island_name"]));
                $in = filter_var($in1, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

                $cn1 = strtolower(str_replace(' ', '', $row["county_name"]));
                $cn = filter_var($cn1, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

                $pn1 = strtolower(str_replace(' ', '', $row["parish_name"]));
                $pn = filter_var($pn1, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

                $id=$row['property_id'];
                echo"
                <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
                <script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js'></script>
                    
                <div data-toggle='modal' data-target='#myModal-".$id."'  class='propertyShow row w3-margin-bottom' data-price='".$row["price"]."' data-category='".$btn." ".$ptn." ".$ptyn." ".$in." ".$cn." ".$pn."' style='cursor:pointer;'>
                    <div class='col col-3'>
                        <img class='pptys' src='../".$row["photo_path"]."'>
                    </div>
                    <div class='col col-7 w3-container w3-white'>
                        <h3>".$row["property_name"]." | Ref: ".$row["property_id"]."</h3>
                        <div class='row'>
                            <div class='col col-8'>
                                <h4><b>".$row["price"]." &euro;</b></h4>
                            </div>
                            <div class='col col-4'>
                                <h5>".$row["business_type_name"]."</h5>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col col-8'>
                                <h5>".$row["address"]."</h5>
                            </div>
                            <div class='col col-4'>
                                <h5>".$row["area"]." m<sup>2</sup></h5>
                            </div>
                        </div>
                    </div>
                    <div class='col col-2'>
                        <img style='max-width:100%;' src='../../images/info.png'>
                    </div>
                </div>

                <!-- Modal -->
                <div class='modal fade' id='myModal-".$id."' role='dialog'>
                    <div class='modal-dialog modal-lg'>
                        <!-- Modal content-->
                        <div class='modal-content'>
                            <div class='modal-header'>
                                <h3 class='modal-title'>".$row["property_name"]."</h3>
                                <span data-dismiss='modal' Style='position: absolute;right: 25px;top: 0;color: #000;font-size: 35px;font-weight: bold; cursor: pointer;'>&times;</span>
                            </div>
                            <div class='modal-body'>
                                <div class='row w3-margin-bottom'>
                                    <div class='col col-5'>
                                        <img class='ppty' src='../".$row["photo_path"]."'>
                                    </div>
                                    <div class='col col-7 w3-container w3-white'>
                                        <h5><b>".$row["price"]." &euro;</b></h5>
                                        <p>".$row["business_type_name"]."</p>
                                        <p>Área: ".$row["area"]." m<sup>2</sup></p>
                                        <p>".$row["property_type_name"]."</p>
                                        <p>".$row["property_typology_name"]."</p>
                                        <p><i class='fa fa-fw fa-bath'></i> ".$row["bathrooms"]."</p>
                                        <p><i class='fa fa-fw fa-bed'></i> ".$row["bedrooms"]."</p>
                                        <p>Morada: ".$row["address"]."</p>
                                        <p>Agente Responsável: ".$row["first_name"]." ".$row["last_name"]."</p>
                                        <br>
                                    </div>
                                </div>
                                <div class='row'>
                                    <div class='col col-12'>
                                        <p>".$row["property_description"]."</p>
                                    </div>
                                </div>
                                <div class='row'>
                                    <div class='col col-12'>
                                        <button type='button' data-toggle='modal' data-target='#myModalVisit-".$id."'>Marcar Visita</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- VISIT MODAL -->
                <div class='container'>
                    <div class='modal fade' id='myModalVisit-".$id."' role='dialog'>
                        <div class='modal-dialog modal-sm'>
                            <div class='modal-content'>
                                <div class='modal-header'>
                                    <h4 class='modal-title'>".$row["property_name"]."</h4>
                                    <div class='close' data-dismiss='modal'>&times;</div>
                                </div>
                                <div class='modal-body'>
                                    <form method='post' action='../../php/visit.php'>
                                        <input type='hidden' name='propertyId' value='".$id."'>
                                        <input type='hidden' name='userId' value='".$userId."'>
                                        <h5><b>Observações:</b></h5>
                                        <textarea id='observations' name='observations' rows='4' style='width:100%;'></textarea>
                                        <br><br>
                                        <h5><b>Data e Hora:</b></h5>
                                        <input type='datetime-local' name='visitDate'>
                                        <br>
                                        <button type='submit' name='submitVisitRequest'>Marca Visita</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                ";
            }     
        }

        public function getAllPropertiesBackend(){
            $stmt = $this->conn->prepare("SELECT * FROM property AS ppt JOIN property_type AS pptt JOIN property_typology AS pptty JOIN island AS isl JOIN county AS cnty JOIN parish AS par JOIN business_type AS bt JOIN users AS u JOIN property_status AS ps
                ON ppt.PK_property_type_id = pptt.property_type_id AND ppt.PK_property_typology_id = pptty.property_typology_id AND par.PK_county_id = cnty.county_id AND cnty.PK_island_id = isl.island_id AND ppt.PK_parish_id = par.parish_id AND ppt.PK_business_type_id = bt.business_type_id AND ppt.PK_user_id = u.user_id AND ppt.PK_property_status_id=ps.property_status_id
                ");
            $stmt->execute();
            if (!$result = $stmt) {
                die ('ERRO ['.$db->error.']');
                return;
            }
            foreach ($result as $row) {
                $btn1 = strtolower(str_replace(' ', '', $row["business_type_name"]));
                $btn = filter_var($btn1, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

                $ptn1 = strtolower(str_replace(' ', '', $row["property_type_name"]));
                $ptn = filter_var($ptn1, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

                $ptyn1 = strtolower(str_replace(' ', '', $row["property_typology_name"]));
                $ptyn = filter_var($ptyn1, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

                $in1 = strtolower(str_replace(' ', '', $row["island_name"]));
                $in = filter_var($in1, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

                $cn1 = strtolower(str_replace(' ', '', $row["county_name"]));
                $cn = filter_var($cn1, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

                $pn1 = strtolower(str_replace(' ', '', $row["parish_name"]));
                $pn = filter_var($pn1, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

                $ps1 = strtolower(str_replace(' ', '', $row["property_status_name"]));
                $ps = filter_var($ps1, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
                
                $id=$row['property_id'];
                
                echo"
                    <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
                    <script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js'></script>

                    <div class='row w3-margin-bottom propertyShow' data-price='".$row["price"]."' data-category='".$btn." ".$ptn." ".$ptyn." ".$in." ".$cn." ".$pn." ".$ps."'>
                        <div class='row'>
                            <div class='col col-9'>
                            </div>
                            <div class='col col-1'>
                                <button data-toggle='modal' data-target='#property-details-modal-".$id."' data-id='".$id."' class='btn backend'><i class='fa fa-eye'></i></button>
                            </div>
                            <div class='col col-1'>
                                <form method='post' action='../../php/property_info_pdf.php'>
                                    <input type='hidden' name='id' value='".$row["property_id"]."'>
                                    <input type='hidden' name='name' value='".$row["property_name"]."'>
                                    <input type='hidden' name='description' value='".$row["property_description"]."'>
                                    <input type='hidden' name='photo' value='".$row["photo_path"]."'>
                                    <input type='hidden' name='propertyType' value='".$row["property_type_name"]."'>
                                    <input type='hidden' name='propertyTypology' value='".$row["property_typology_name"]."'>
                                    <input type='hidden' name='parish' value='".$row["parish_name"]."'>
                                    <input type='hidden' name='address' value='".$row["address"]."'>
                                    <input type='hidden' name='area' value='".$row["area"]."'>
                                    <input type='hidden' name='bedrooms' value='".$row["bedrooms"]."'>
                                    <input type='hidden' name='bathrooms' value='".$row["bathrooms"]."'>
                                    <input type='hidden' name='latitude' value='".$row["latitude"]."'>
                                    <input type='hidden' name='longitude' value='".$row["longitude"]."'>
                                    <input type='hidden' name='businessType' value='".$row["business_type_name"]."'>
                                    <input type='hidden' name='price' value='".$row["price"]."'>
                                    <input type='hidden' name='manager' value='".$row["first_name"]." ".$row["last_name"]."'>
                                    <input type='hidden' name='propertyStatus' value='".$row["property_status_name"]."'>
                                    <button type='submit' name='submitUserDetails' class='btn backend'><i class='  fa fa-file-pdf-o'></i></button>
                                </form>
                            </div>
                            <div class='col col-1'>
                                <form action='../../php/addToFeatured.php?id='".$id."' method='post'>
                                    <input type='hidden' name='id' value='".$id."'>
                                    <button type='submit' class='btn backend' id='".$id."'><i class='fa fa-plus'></i></button>
                                </form>
                            </div>
                        </div>
                        <div class='col col-12'>
                            <div class='row'>
                                <div class='col col-3'>
                                    <div class='cont'>
                                        <img class='pptys image' src='../".$row["photo_path"]."'>
                                    </div>
                                </div>
                                <div class='col col-9'>
                                    <div class='row'>
                                        <div class='col col-3'>
                                            <h4>REF: ".$row["property_id"]."</h4>
                                        </div>
                                        <div class='col col-9'>
                                            <h4>".$row["property_name"]."</h4>
                                        </div>
                                    </div>
                                    <div class='row'>
                                        <div class='col col-4'>
                                            ".$row["property_type_name"]."
                                        </div>
                                        <div class='col col-4'>
                                            ".$row["property_typology_name"]."
                                        </div>
                                        <div class='col col-4'>
                                            ".$row["area"]." m<sup>2</sup>
                                        </div>
                                    </div>
                                    <div class='row'>
                                        <div class='col col-4'>
                                            <i class='fa fa-bed'></i> ".$row["bedrooms"]."
                                        </div>
                                        <div class='col col-4'>
                                            <i class='fa fa-bath'></i> ".$row["bathrooms"]."
                                        </div>
                                        <div class='col col-4'>
                                            ".$row["price"]." £
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class='row'>
                                <div class='col col-12'>
                                    ".$row["property_description"]."
                                </div>
                            </div>
                        </div>
                        <hr>
                    </div>


                    <!-- Modal -->
                    <div class='modal fade' id='property-details-modal-".$id."' role='dialog'>
                        <div class='modal-dialog modal-lg'>
                            <!-- Modal content-->
                            <div class='modal-content'>
                                <div class='modal-header'>
                                    <h3 class='modal-title'>".$row["property_name"]."</h3>
                                    <span data-dismiss='modal' Style='position: absolute;right: 25px;top: 0;color: #000;font-size: 35px;font-weight: bold; cursor: pointer;'>&times;</span>
                                </div>
                                <div class='modal-body'>
                                    <div class='row w3-margin-bottom'>
                                        <div class='col col-5'>
                                            <img class='ppty' src='../".$row["photo_path"]."'>
                                        </div>
                                        <div class='col col-7 w3-container w3-white'>
                                            <h5><b>".$row["price"]." &euro;</b></h5>
                                            <p>".$row["business_type_name"]."</p>
                                            <p>Área: ".$row["area"]." m<sup>2</sup></p>
                                            <p>".$row["property_type_name"]."</p>
                                            <p>".$row["property_typology_name"]."</p>
                                            <p><i class='fa fa-fw fa-bath'></i> ".$row["bathrooms"]."</p>
                                            <p><i class='fa fa-fw fa-bed'></i> ".$row["bedrooms"]."</p>
                                            <p>Morada: ".$row["address"]."</p>
                                            <p>Agente Responsável: ".$row["first_name"]." ".$row["last_name"]."</p>
                                            <br>
                                        </div>
                                    </div>
                                    <div class='row'>
                                        <div class='col col-12'>
                                            <p>".$row["property_description"]."</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                ";
            }       
        }

        public function getAllFeaturedPropertiesBackend(){
            $stmt = $this->conn->prepare("SELECT * FROM featured AS ft INNER JOIN property AS ppt JOIN property_type AS pptt JOIN property_typology AS pptty JOIN island AS isl JOIN county AS cnty JOIN parish AS par JOIN business_type AS bt JOIN users AS u JOIN property_status as ps
                ON ft.PK_property_id=ppt.property_id AND ppt.PK_property_type_id = pptt.property_type_id AND ppt.PK_property_typology_id = pptty.property_typology_id AND ppt.PK_parish_id = par.parish_id AND par.PK_county_id=cnty.county_id AND cnty.PK_island_id = isl.island_id AND ppt.PK_business_type_id = bt.business_type_id AND ppt.PK_user_id = u.user_id AND ppt.PK_property_status_id=ps.property_status_id
                ");
            $stmt->execute();
            if (!$result = $stmt) {
                die ('ERRO ['.$db->error.']');
                return;
            }
            foreach ($result as $row) {
                $btn1 = strtolower(str_replace(' ', '', $row["business_type_name"]));
                $btn = filter_var($btn1, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

                $ptn1 = strtolower(str_replace(' ', '', $row["property_type_name"]));
                $ptn = filter_var($ptn1, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

                $ptyn1 = strtolower(str_replace(' ', '', $row["property_typology_name"]));
                $ptyn = filter_var($ptyn1, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

                $in1 = strtolower(str_replace(' ', '', $row["island_name"]));
                $in = filter_var($in1, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

                $cn1 = strtolower(str_replace(' ', '', $row["county_name"]));
                $cn = filter_var($cn1, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

                $pn1 = strtolower(str_replace(' ', '', $row["parish_name"]));
                $pn = filter_var($pn1, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

                $ps1 = strtolower(str_replace(' ', '', $row["property_status_name"]));
                $ps = filter_var($ps1, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
                
                $id=$row['property_id'];
                
                echo"
                    <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
                    <script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js'></script>

                    <div class='row w3-margin-bottom propertyShow' data-price='".$row["price"]."' data-category='".$btn." ".$ptn." ".$ptyn." ".$in." ".$cn." ".$pn." ".$ps."'>
                        <div class='row'>
                            <div class='col col-11'>
                            </div>
                            <div class='col col-1'>
                                <form action='../../php/deleteFromFeatured.php?user_id='".$id."' method='post'>
                                    <input type='hidden' name='id' value='".$id."'>
                                    <button type='submit' class='btn backend' id='".$id."''><i class='fa fa-remove'></i></button>
                                </form>
                            </div>
                        </div>
                        <div class='col col-12'>
                            <div class='row'>
                                <div class='col col-3'>
                                    <div class='cont'>
                                        <img class='pptys image' src='../".$row["photo_path"]."'>
                                    </div>
                                </div>
                                <div class='col col-9'>
                                    <div class='row'>
                                        <div class='col col-3'>
                                            <h4>REF: ".$row["property_id"]."</h4>
                                        </div>
                                        <div class='col col-9'>
                                            <h4>".$row["property_name"]."</h4>
                                        </div>
                                    </div>
                                    <div class='row'>
                                        <div class='col col-4'>
                                            ".$row["property_type_name"]."
                                        </div>
                                        <div class='col col-4'>
                                            ".$row["property_typology_name"]."
                                        </div>
                                        <div class='col col-4'>
                                            ".$row["area"]." m<sup>2</sup>
                                        </div>
                                    </div>
                                    <div class='row'>
                                        <div class='col col-4'>
                                            <i class='fa fa-bed'></i> ".$row["bedrooms"]."
                                        </div>
                                        <div class='col col-4'>
                                            <i class='fa fa-bath'></i> ".$row["bathrooms"]."
                                        </div>
                                        <div class='col col-4'>
                                            ".$row["price"]." £
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class='row'>
                                <div class='col col-12'>
                                    ".$row["property_description"]."
                                </div>
                            </div>

                            <div class='row'>
                                <div class='col col-6'>
                                    ".$row["address"]."
                                </div>
                                <div class='col col-3'>
                                    ".$row["parish_name"]."
                                </div>
                                <div class='col col-3'>
                                    <div class='row'>
                                        <b>Posição geogáfica:</b>
                                    </div>
                                    <div class='row'>
                                        ".$row["latitude"].", ".$row["longitude"]."
                                    </div>
                                </div>
                            </div>

                            <div class='row'>
                                <div class='col col-6'>
                                    ".$row["business_type_name"]."
                                </div>
                                <div class='col col-6'>
                                    ".$row["property_status_name"]."
                                </div>
                            </div>

                            <div class='row'>
                                <div class='col col-12'>
                                   <b>Agente responsável:</b> ".$row["first_name"]." ".$row["last_name"]."
                                </div>
                            </div>
                        </div>
                        <hr>
                    </div>
                ";
            }   
        }

        public function getAllSugestedProperties(){
            $stmt = $this->conn->prepare("SELECT * FROM featured_suggestions AS fs INNER JOIN property AS ppt JOIN property_type AS pptt JOIN property_typology AS pptty JOIN island AS isl JOIN county AS cnty JOIN parish AS par JOIN business_type AS bt JOIN users AS u
                ON fs.PK_property_id=ppt.property_id AND ppt.PK_property_type_id = pptt.property_type_id AND ppt.PK_property_typology_id = pptty.property_typology_id AND ppt.PK_parish_id = par.parish_id AND par.PK_county_id=cnty.county_id AND cnty.PK_island_id = isl.island_id AND ppt.PK_business_type_id = bt.business_type_id AND ppt.PK_user_id = u.user_id
                ");
            $stmt->execute();
            if (!$result = $stmt) {
                die ('ERRO ['.$db->error.']');
                return;
            }
            foreach ($result as $row) {
                $id=$row['property_id'];
                echo"
                    <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
                    <script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js'></script>

                    <div class='row'>
                        <div class='col col-10'>
                        </div>
                        <div class='col col-1'>
                            <form action='../../php/addToFeatured.php?user_id='".$id."' method='post'>
                                <input type='hidden' name='id' value='".$id."'>
                                <button type='submit' class='btn backend' id='".$id."'><i class='fa fa-plus'></i></button>
                            </form>
                        </div>
                        <div class='col col-1'>
                            <form action='../../php/removeFromFeaturedSuggestions.php?user_id='".$id."' method='post'>
                                <input type='hidden' name='id' value='".$id."'>
                                <button type='submit' class='btn backend' id='".$id."'><i class='fa fa-remove'></i></button>
                            </form>
                        </div>
                    </div>
                    <div class='row w3-margin-bottom propertyShow'>
                        <div class='col col-3'>
                            <img class='pptys' src='../".$row["photo_path"]."'>
                        </div>
                        <div class='col col-8'>
                            <div class='row'>
                                <div class='col col-2'>
                                    Ref: ".$row["property_id"]."
                                </div>
                                <div class='col col-7'>
                                    ".$row["property_name"]."
                                </div>
                                <div class='col col-3'>
                                    ".$row["business_type_name"]."
                                </div>
                            </div>
                            <div class='row'>
                                <div class='col col-4'>
                                    ".$row["property_type_name"]."
                                </div>
                                <div class='col col-4'>
                                    ".$row["property_typology_name"]."
                                </div>
                                <div class='col col-4'>
                                    ".$row["price"]." &euro;
                                </div>
                            </div>
                            <div class='row'>
                                <div class='col col-5'>
                                    ".$row["address"]."
                                </div>
                                <div class='col col-2'>
                                    ".$row["area"]." m<sup>2</sup>
                                </div>
                                <div class='col col-2'>
                                    <i class='fa fa-fw fa-bath'></i> ".$row["bathrooms"]."
                                </div>
                                <div class='col col-2'>
                                    <i class='fa fa-fw fa-bed'></i> ".$row["bedrooms"]."
                                </div>
                            </div>
                        </div>
                    <hr>
                    </div>
                ";
            }     
        }

        public function getAllFeaturedPropertiesBackendManagerView(){
            $stmt = $this->conn->prepare("SELECT * FROM featured AS ft JOIN property AS ppt JOIN property_type AS pptt JOIN property_typology AS pptty JOIN island AS isl JOIN county AS cnty JOIN parish AS par JOIN business_type AS bt JOIN users AS u JOIN property_status AS ppts
                ON ft.PK_property_id=ppt.property_id AND ppt.PK_property_type_id = pptt.property_type_id AND ppt.PK_property_typology_id = pptty.property_typology_id AND par.PK_county_id = cnty.county_id AND cnty.PK_island_id = isl.island_id AND ppt.PK_parish_id = par.parish_id AND ppt.PK_business_type_id = bt.business_type_id AND ppt.PK_user_id = u.user_id AND ppt.PK_property_status_id=ppts.property_status_id
                ");
            $stmt->execute();
            if (!$result = $stmt) {
                die ('ERRO ['.$db->error.']');
                return;
            }

            foreach ($result as $row) {
                $id=$row['PK_property_id'];
                echo"
                    <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
                    <script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js'></script>

                    <div class='row w3-margin-bottom'>
                        <div class='col col-12'>
                            <div class='row'>
                                <div class='col col-3'>
                                    <div class='cont'>
                                        <img class='pptys image' src='../".$row["photo_path"]."'>
                                        <div class='ovl'>
                                            <div class='text'>
                                                <button data-toggle='modal' data-target='#view-update-property-image-modal-".$id."' id='updatePhoto' class='btn backendbtn'><i class='fa fa-pencil'></i> EDITAR</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class='col col-9'>
                                    <div class='row'>
                                        <div class='col col-3'>
                                            <h4>REF: ".$row["property_id"]."</h4>
                                        </div>
                                        <div class='col col-9'>
                                            <h4>".$row["property_name"]."</h4>
                                        </div>
                                    </div>
                                    <div class='row'>
                                        <div class='col col-4'>
                                            ".$row["property_type_name"]."
                                        </div>
                                        <div class='col col-4'>
                                            ".$row["property_typology_name"]."
                                        </div>
                                        <div class='col col-4'>
                                            ".$row["area"]." m<sup>2</sup>
                                        </div>
                                    </div>
                                    <div class='row'>
                                        <div class='col col-4'>
                                            <i class='fa fa-bed'></i> ".$row["bedrooms"]."
                                        </div>
                                        <div class='col col-4'>
                                            <i class='fa fa-bath'></i> ".$row["bathrooms"]."
                                        </div>
                                        <div class='col col-4'>
                                            ".$row["price"]." £
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class='row'>
                                <div class='col col-12'>
                                    ".$row["property_description"]."
                                </div>
                            </div>

                            <div class='row'>
                                <div class='col col-6'>
                                    ".$row["address"]."
                                </div>
                                <div class='col col-3'>
                                    ".$row["parish_name"]."
                                </div>
                                <div class='col col-3'>
                                    <div class='row'>
                                        <b>Posição geogáfica:</b>
                                    </div>
                                    <div class='row'>
                                        ".$row["latitude"].", ".$row["longitude"]."
                                    </div>
                                </div>
                            </div>

                            <div class='row'>
                                <div class='col col-6'>
                                    ".$row["business_type_name"]."
                                </div>
                                <div class='col col-6'>
                                    ".$row["property_status_name"]."
                                </div>
                            </div>

                            <div class='row'>
                                <div class='col col-12'>
                                   <b>Agente responsável:</b> ".$row["first_name"]." ".$row["last_name"]."
                                </div>
                            </div>
                        </div>
                         <hr>
                    </div>
                ";
            }
        }

        public function getAllPropertiesBackendManagerView($user_id){
            $stmt = $this->conn->prepare("SELECT * FROM property AS ppt JOIN property_type AS pptt JOIN property_typology AS pptty JOIN island AS isl JOIN county AS cnty JOIN parish AS par JOIN business_type AS bt JOIN users AS u JOIN property_status AS ppts
                ON ppt.PK_property_type_id = pptt.property_type_id AND ppt.PK_property_typology_id = pptty.property_typology_id AND par.PK_county_id = cnty.county_id AND cnty.PK_island_id = isl.island_id AND ppt.PK_parish_id = par.parish_id AND ppt.PK_business_type_id = bt.business_type_id AND ppt.PK_user_id = u.user_id AND ppt.PK_property_status_id=ppts.property_status_id
                ");
            $stmt->execute();
            if (!$result = $stmt) {
                die ('ERRO ['.$db->error.']');
                return;
            }

            foreach ($result as $row) {
                $btn1 = strtolower(str_replace(' ', '', $row["business_type_name"]));
                $btn = filter_var($btn1, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

                $ptn1 = strtolower(str_replace(' ', '', $row["property_type_name"]));
                $ptn = filter_var($ptn1, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

                $ptyn1 = strtolower(str_replace(' ', '', $row["property_typology_name"]));
                $ptyn = filter_var($ptyn1, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

                $in1 = strtolower(str_replace(' ', '', $row["island_name"]));
                $in = filter_var($in1, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

                $cn1 = strtolower(str_replace(' ', '', $row["county_name"]));
                $cn = filter_var($cn1, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

                $pn1 = strtolower(str_replace(' ', '', $row["parish_name"]));
                $pn = filter_var($pn1, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

                $ps1 = strtolower(str_replace(' ', '', $row["property_status_name"]));
                $ps = filter_var($ps1, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
                
                $id=$row['property_id'];
                
                echo"
                    <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
                    <script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js'></script>

                    <div class='row w3-margin-bottom propertyShow' data-price='".$row["price"]."' data-category='".$btn." ".$ptn." ".$ptyn." ".$in." ".$cn." ".$pn." ".$ps."'>
                        <div class='row'>
                            <div class='col col-6'>
                            </div>
                            <div class='col col-1'>
                                <button data-toggle='modal' data-target='#property-details-modal-".$id."' data-id='".$id."' class='btn backend'><i class='fa fa-eye'></i></button>
                            </div>
                            <div class='col col-1'>
                                <form method='post' action='../../php/property_info_pdf.php'>
                                    <input type='hidden' name='id' value='".$row["property_id"]."'>
                                    <input type='hidden' name='name' value='".$row["property_name"]."'>
                                    <input type='hidden' name='description' value='".$row["property_description"]."'>
                                    <input type='hidden' name='photo' value='".$row["photo_path"]."'>
                                    <input type='hidden' name='propertyType' value='".$row["property_type_name"]."'>
                                    <input type='hidden' name='propertyTypology' value='".$row["property_typology_name"]."'>
                                    <input type='hidden' name='parish' value='".$row["parish_name"]."'>
                                    <input type='hidden' name='address' value='".$row["address"]."'>
                                    <input type='hidden' name='area' value='".$row["area"]."'>
                                    <input type='hidden' name='bedrooms' value='".$row["bedrooms"]."'>
                                    <input type='hidden' name='bathrooms' value='".$row["bathrooms"]."'>
                                    <input type='hidden' name='latitude' value='".$row["latitude"]."'>
                                    <input type='hidden' name='longitude' value='".$row["longitude"]."'>
                                    <input type='hidden' name='businessType' value='".$row["business_type_name"]."'>
                                    <input type='hidden' name='price' value='".$row["price"]."'>
                                    <input type='hidden' name='manager' value='".$row["first_name"]." ".$row["last_name"]."'>
                                    <input type='hidden' name='propertyStatus' value='".$row["property_status_name"]."'>
                                    <button type='submit' name='submitUserDetails' class='btn backend'><i class='  fa fa-file-pdf-o'></i></button>
                                </form>
                            </div>
                            <div class='col col-1'>
                                <button data-toggle='modal' data-target='#view-update-status-modal-".$id."' data-id='".$id."' id='getUser' class='btn backend'><i class='fa fa-bookmark'></i></button>
                            </div>
                            <div class='col col-1'>
                                <form action='../../php/addToFeaturedSuggestions.php?id='".$id."'&user_id='".$user_id."' method='post'>
                                    <input type='hidden' name='id' value='".$id."'>
                                    <button type='submit' class='btn backend' id='".$id."'><i class='fa fa-calendar-plus-o'></i></button>
                                </form>
                            </div>
                            <div class='col col-1'>
                                <button data-toggle='modal' data-target='#view-alert-modal-".$id."' class='btn backend'><i class='fa fa-remove'></i></button>
                            </div>
                            <div class='col col-1'>
                                <button data-toggle='modal' data-target='#view-update-property-modal-".$id."' id='getUser' class='btn backend'><i class='fa fa-pencil'></i></button>
                            </div>
                        </div>
                        <div class='col col-12'>
                            <div class='row'>
                                <div class='col col-3'>
                                    <div class='cont'>
                                        <img class='pptys image' src='../".$row["photo_path"]."'>
                                        <div class='ovl'>
                                            <div class='text'>
                                                <button data-toggle='modal' data-target='#view-update-property-image-modal-".$id."' id='updatePhoto' class='btn backendbtn'><i class='fa fa-pencil'></i> EDITAR</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class='col col-9'>
                                    <div class='row'>
                                        <div class='col col-3'>
                                            <h4>REF: ".$row["property_id"]."</h4>
                                        </div>
                                        <div class='col col-9'>
                                            <h4>".$row["property_name"]."</h4>
                                        </div>
                                    </div>
                                    <div class='row'>
                                        <div class='col col-4'>
                                            ".$row["property_type_name"]."
                                        </div>
                                        <div class='col col-4'>
                                            ".$row["property_typology_name"]."
                                        </div>
                                        <div class='col col-4'>
                                            ".$row["area"]." m<sup>2</sup>
                                        </div>
                                    </div>
                                    <div class='row'>
                                        <div class='col col-4'>
                                            <i class='fa fa-bed'></i> ".$row["bedrooms"]."
                                        </div>
                                        <div class='col col-4'>
                                            <i class='fa fa-bath'></i> ".$row["bathrooms"]."
                                        </div>
                                        <div class='col col-4'>
                                            ".$row["price"]." £
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class='row'>
                                <div class='col col-12'>
                                    ".$row["property_description"]."
                                </div>
                            </div>

                            <div class='row'>
                                <div class='col col-6'>
                                    ".$row["address"]."
                                </div>
                                <div class='col col-3'>
                                    ".$row["parish_name"]."
                                </div>
                                <div class='col col-3'>
                                    <div class='row'>
                                        <b>Posição geogáfica:</b>
                                    </div>
                                    <div class='row'>
                                        ".$row["latitude"].", ".$row["longitude"]."
                                    </div>
                                </div>
                            </div>

                            <div class='row'>
                                <div class='col col-6'>
                                    ".$row["business_type_name"]."
                                </div>
                                <div class='col col-6'>
                                    ".$row["property_status_name"]."
                                </div>
                            </div>

                            <div class='row'>
                                <div class='col col-12'>
                                   <b>Agente responsável:</b> ".$row["first_name"]." ".$row["last_name"]."
                                </div>
                            </div>
                        </div>
                         <hr>
                    </div>

            <!-- ALERT MODAL -->
            <div id='view-alert-modal-".$id."' class='modal fade' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true' style='display: none;'>
                <div class='modal-dialog modal-sm'>
                    <div class='modal-content'>
                        <div class='modal-header'>
                            <h4>".$row["property_name"]."</h4>
                            <span data-dismiss='modal' style='position: absolute;right: 25px;top: 0;color: #000;font-size: 35px;font-weight: bold; cursor: pointer;'>&times;</span>
                        </div>
                        <div class='modal-body'>
                            <div class='row'>
                                <div class='col col-12'>
                                    <h5>Tem a certeza que deseja eliminar este item?</h5>
                                </div>
                            </div>
                            <div class='row'>
                                <div class='col col-6'>
                                    <form action='../../php/deleteProperty.php' method='post'>
                                        <input type='hidden' name='id' value='".$id."'>
                                        <button type='submit' class='btn backend' style='color:#000;'>SIM</button>
                                    </form>
                                </div>
                                <div class='col col-6'>
                                    <button class='btn backend' data-dismiss='modal' style='color:#000;'>Não</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <!-- UPDATE IMAGE MODAL -->
            <div id='view-update-property-image-modal-".$id."' class='modal fade' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true' style='display: none;''>
                <div class='modal-dialog modal-lg'>
                    <div class='modal-content'>
                        <div class='modal-header'>
                            <h4>".$row["property_name"]."</h4>
                            <span data-dismiss='modal' style='position: absolute;right: 25px;top: 0;color: #000;font-size: 35px;font-weight: bold; cursor: pointer;'>&times;</span>
                        </div>
                        <div class='modal-body'>
                            <form action='../../php/updatePropertyStatus.php?id='".$id."' method='post'>
                                <input type='hidden' name='id' value='".$id."'>
                                <div class='row'>
                                    <div class='col col-12'>
                                        <h4>Fotografia:</h4>
                                        <script src='../../js/previewFile.js'></script>
                                        <input type='file' name='photoUpload' id='photoUpload'  onchange='previewFile()' required>
                                        <img id='imgPreview' src='' height='200' alt='Image preview...'>
                                        <script src='../../js/previewFile.js'></script>
                                    </div>
                                </div>
                                <br><br>
                                <br><br><br>
                                <button style='color:#fff;' type='submit' name='updatePropertyStatus'><i class='fa fa-pencil'></i> Editar imagem</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


            <!-- UPDATE STATUS MODAL -->
            <div id='view-update-status-modal-".$id."' class='modal fade' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true' style='display: none;''>
                <div class='modal-dialog modal-lg'>
                    <div class='modal-content'>
                        <div class='modal-header'>
                            <h4>".$row["property_name"]."</h4>
                            <span data-dismiss='modal' style='position: absolute;right: 25px;top: 0;color: #000;font-size: 35px;font-weight: bold; cursor: pointer;'>&times;</span>
                        </div>
                        <div class='modal-body'>
                            <form action='../../php/updatePropertyStatus.php?id='".$id."' method='post'>
                            <input type='hidden' name='price' value='".$row["price"]."'>
                            <input type='hidden' name='id' value='".$id."'>
                                <h4>Estado:</h4>
                                <select name='property_status'>
                                    <option name='property_status' selected disabled>Selecione um estado</option>
                                    ".$this->setAllPropertyStatuses($row["PK_property_status_id"])."
                                </select>
                                <br><br><br>
                                <button style='color:#fff;' type='submit' name='updatePropertyStatus'><i class='fa fa-pencil'></i> Editar estado</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


            <!-- UPDATE PROPERTY MODAL -->
            <div id='view-update-property-modal-".$id."' class='modal fade' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true' style='display: none;''>
                <div class='modal-dialog modal-lg'>
                    <div class='modal-content'>
                        <div class='modal-header'>
                            <span data-dismiss='modal' style='position: absolute;right: 25px;top: 0;color: #000;font-size: 35px;font-weight: bold; cursor: pointer;'>&times;</span>
                        </div>
                        <div class='modal-body'>
                            <form action='../../php/updateProperty.php' method='post'>
                                <div class='row'>
                                <input type='hidden' name='id' value='".$row["property_id"]."'>
                                    <div class='col col-12'>
                                        <h4>Nome da propriedade:</h4>
                                        <input type='text' name='property_name' required value='".$row["property_name"]."'>
                                    </div>
                                </div>
                                <br><br>

                                <h4>Descrição da propriedade:</h4>
                                <textarea name='property_description' rows='5' style='width:100%;' required>".$row["property_description"]."</textarea>
                                <br><br>

                                <div class='row'>
                                    <div class='col col-6'>
                                        <h4>Tipo da propriedade:</h4>
                                        <select name='property_type'>
                                            <option name='property_type' selected disabled>Selecione um tipo</option>
                                            ".$this->setAllPropertyTypes($row["PK_property_type_id"])."
                                        </select>
                                    </div>
                                    <div class='col col-6'>
                                        <h4>Tipologia da propriedade:</h4>
                                        <select name='property_typology'>
                                            <option name='property_typology' selected disabled>Selecione uma tipologia</option>
                                            ".$this->setAllPropertyTypologies($row["PK_property_typology_id"])."
                                        </select>
                                    </div>
                                </div>
                                <br><br>

                                <div class='row'>
                                    <div class='col col-4'>
                                        <h4>Ilha:</h4>
                                        <select name='island' class='filterSelect' data-target='select-county' id='select-island'>
                                            <option value='-1' selected>Selecione uma ilha</option>
                                            ".$this->setAllPropertyIslands()."
                                        </select>
                                    </div>
                                    <div class='col col-4'>
                                        <h4>Concelho:</h4>
                                        <select name='county' class='filterSelect' data-target='select-parish' id='select-county' data-allowempty>
                                            <option value='-1' selected>Selecione um concelho</option>
                                            ".$this->setAllPropertyCounties()."
                                        </select>
                                    </div>
                                    <div class='col col-4'>
                                        <h4>Freguesia:</h4>
                                        <select name='parish' id='select-parish'>
                                            <option value='-1' selected>Selecione uma freguesia</option>
                                            ".$this->setAllPropertyParishes($row["PK_parish_id"])."
                                        </select>
                                    </div>
                                     <script src='https://code.jquery.com/jquery-1.12.4.min.js'></script>
                                    <script src='../../js/filterselect.js'></script>
                                    <script type='text/javascript'>
                                        $('.filterSelect').filterSelect({
                                            allowEmpty: true
                                        });
                                    </script>
                                </div>
                                <br><br>

                                <div class='row'>
                                    <div class='col col-12'>
                                        <h4>Morada:</h4>
                                        <input type='text' name='address' value='".$row["address"]."' required>
                                    </div>
                                </div>
                                <br><br>

                                <div class='row'>
                                    <div class='col col-4'>
                                        <h4>Área:</h4>
                                        <input type='text' name='area' value='".$row["area"]."' required>
                                    </div>
                                    <div class='col col-4'>
                                        <h4>Quartos:</h4>
                                        <input type='number' name='bedrooms' value='".$row["bedrooms"]."'>
                                    </div>
                                    <div class='col col-4'>
                                        <h4>Casas de banho:</h4>
                                        <input type='number' name='bathrooms' value='".$row["bathrooms"]."'>
                                    </div>
                                </div>
                                <br><br>

                                <div class='row'>
                                    <div class='col col-6'>
                                        <h4>Latitude:</h4>
                                        <input type='text' name='latitude' value='".$row["latitude"]."' required>
                                    </div>
                                    <div class='col col-6'>
                                        <h4>Longitude:</h4>
                                        <input type='text' name='longitude' value='".$row["longitude"]."' required>
                                    </div>
                                </div>
                                <br><br>

                            <div class='row'>
                                <div class='col col-6'>
                                    <h4>Tipo de negócio:</h4>
                                    <select name='business_type'>
                                        <option name='business_type' selected disabled>Selecione uma finalidade</option>
                                        ".$this->setAllPropertyBusinessTypes($row["PK_business_type_id"])."
                                    </select>
                                </div>
                                <div class='col col-6'>
                                    <h4>Preço:</h4>
                                    <input type='text' name='price' value='".$row["price"]."' required>
                                </div>
                            </div>
                            <br><br>

                            <h4>Agente responsável:</h4>
                            <select name='manager'>
                                <option name='manager' selected disabled>Selecione uma gestor</option>
                                ".$this->setAllUserIds($row["PK_user_id"])."
                            </select>
                            <br><br>
                                <button style='color:#fff;' type='submit' name='updateProperty'><i class='fa fa-pencil'></i> Editar estado</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Modal -->
            <div class='modal fade' id='property-details-modal-".$id."' role='dialog'>
                <div class='modal-dialog modal-lg'>
                    <!-- Modal content-->
                    <div class='modal-content'>
                        <div class='modal-header'>
                            <h3 class='modal-title'>".$row["property_name"]."</h3>
                            <span data-dismiss='modal' Style='position: absolute;right: 25px;top: 0;color: #000;font-size: 35px;font-weight: bold; cursor: pointer;'>&times;</span>
                        </div>
                        <div class='modal-body'>
                            <div class='row w3-margin-bottom'>
                                <div class='col col-5'>
                                    <img class='ppty' src='../".$row["photo_path"]."'>
                                </div>
                                <div class='col col-7 w3-container w3-white'>
                                    <h5><b>".$row["price"]." &euro;</b></h5>
                                    <p>".$row["business_type_name"]."</p>
                                    <p>Área: ".$row["area"]." m<sup>2</sup></p>
                                    <p>".$row["property_type_name"]."</p>
                                    <p>".$row["property_typology_name"]."</p>
                                    <p><i class='fa fa-fw fa-bath'></i> ".$row["bathrooms"]."</p>
                                    <p><i class='fa fa-fw fa-bed'></i> ".$row["bedrooms"]."</p>
                                    <p>Morada: ".$row["address"]."</p>
                                    <p>Agente Responsável: ".$row["first_name"]." ".$row["last_name"]."</p>
                                    <br>
                                </div>
                            </div>
                            <div class='row'>
                                <div class='col col-12'>
                                    <p>".$row["property_description"]."</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                ";
            }
        }

        public function getAllSugestedPropertiesManagerView($user_id){
            $stmt = $this->conn->prepare("SELECT * FROM featured_suggestions AS fs INNER JOIN property AS ppt JOIN property_type AS pptt JOIN property_typology AS pptty JOIN island AS isl JOIN county AS cnty JOIN parish AS par JOIN business_type AS bt JOIN users AS u JOIN property_status AS ps
                ON fs.PK_fs_user_id =u.user_id AND fs.PK_property_id=ppt.property_id AND ppt.PK_property_type_id = pptt.property_type_id AND ppt.PK_property_typology_id = pptty.property_typology_id AND ppt.PK_parish_id = par.parish_id AND par.PK_county_id=cnty.county_id AND cnty.PK_island_id = isl.island_id AND ppt.PK_business_type_id = bt.business_type_id AND ppt.PK_user_id = u.user_id AND ppt.PK_property_status_id=ps.property_status_id WHERE PK_fs_user_id=?
                ");
            $stmt->bindValue(1, $user_id);
            $stmt->execute();
            if (!$result = $stmt) {
                die ('ERRO ['.$db->error.']');
                return;
            }
            foreach ($result as $row) {
               
                $id=$row['property_id'];
                echo"
                    <div class='row w3-margin-bottom'>
                        <div class='row'>
                            <div class='col col-11'>
                            </div>
                            <div class='col col-1'>
                                <form action='../../php/removeFromFeaturedSuggestions.php?id='".$id."'  method='post'>
                                    <input type='hidden' name='id' value='".$id."'>
                                    <button type='submit' class='btn backend' id='".$id."'><i class='   fa fa-calendar-times-o'></i></button>
                                </form>
                            </div>
                        </div>
                        <div class='col col-12'>
                            <div class='row'>
                                <div class='col col-3'>
                                    <img class='pptys' src='../".$row["photo_path"]."'>
                                </div>
                                <div class='col col-9'>
                                    <div class='row'>
                                        <div class='col col-3'>
                                            <h4>REF: ".$row["property_id"]."</h4>
                                        </div>
                                        <div class='col col-9'>
                                            <h4>".$row["property_name"]."</h4>
                                        </div>
                                    </div>
                                    <div class='row'>
                                        <div class='col col-4'>
                                            ".$row["property_type_name"]."
                                        </div>
                                        <div class='col col-4'>
                                            ".$row["property_typology_name"]."
                                        </div>
                                        <div class='col col-4'>
                                            ".$row["area"]." m<sup>2</sup>
                                        </div>
                                    </div>
                                    <div class='row'>
                                        <div class='col col-4'>
                                            <i class='fa fa-bed'></i> ".$row["bedrooms"]."
                                        </div>
                                        <div class='col col-4'>
                                            <i class='fa fa-bath'></i> ".$row["bathrooms"]."
                                        </div>
                                        <div class='col col-4'>
                                            ".$row["price"]." £
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class='row'>
                                <div class='col col-12'>
                                    ".$row["property_description"]."
                                </div>
                            </div>

                            <div class='row'>
                                <div class='col col-6'>
                                    ".$row["address"]."
                                </div>
                                <div class='col col-3'>
                                    ".$row["parish_name"]."
                                </div>
                                <div class='col col-3'>
                                    ".$row["latitude"].", ".$row["longitude"]."
                                </div>
                            </div>

                            <div class='row'>
                                <div class='col col-6'>
                                    ".$row["business_type_name"]."
                                </div>
                                <div class='col col-6'>
                                    ".$row["property_status_name"]."
                                </div>
                            </div>

                            <div class='row'>
                                <div class='col col-12'>
                                    <b>Agente responsável:</b> ".$row["first_name"]." ".$row["last_name"]."
                                </div>
                            </div>
                        </div>
                    <hr>
                    </div>
                ";
            }     
        }
           
        public function getSugestedPropertiesNumber(){
            $stmt = $this->conn->prepare("SELECT * FROM featured_suggestions");
            $stmt->execute();
            if (!$result = $stmt) {
                die ('ERRO ['.$db->error.']');
                return;
            }
            if($stmt->rowCount() <= 0){
                echo"";
            }
            else{
                echo "<span class='sugestedPropertiesNumber'>".$stmt->rowCount()."</span>";
            }
        }

        public function getAllPropertyTypes(){
            $stmt = $this->conn->prepare("SELECT * FROM property_type");
            $stmt->execute();
            foreach ($stmt as $row) {
                $id=$row['property_type_id'];
                $name=$row['property_type_name'];
                echo"
                    <option id='".$id."' value='".$id."'>".$name."</option>
                ";
            }
        }

        public function getAllPropertyTypologies(){
            $stmt = $this->conn->prepare("SELECT * FROM property_typology");
            $stmt->execute();
            foreach ($stmt as $row) {
                $id=$row['property_typology_id'];
                $name=$row['property_typology_name'];
                echo"
                    <option id='".$id."' value='".$id."'>".$name."</option>
                ";
            }
        }

        public function getAllPropertyIslands(){
            $stmt = $this->conn->prepare("SELECT * FROM island");
            $stmt->execute();
            echo"
                <select name='island' class='filterSelect' data-target='select-county' id='select-island'>
                    <option value='-1' selected>Selecione uma ilha</option>
            ";
            foreach ($stmt as $row) {
                $id=$row['island_id'];
                $name=$row['island_name'];

                echo"
                    <option value='".$id."' data-reference='".$id."'>".$name."</option>
                ";
            }
            echo"</select>";
        }

        public function getAllPropertyCounties(){
            $stmt = $this->conn->prepare("SELECT * FROM county AS cnty JOIN island AS isl ON cnty.PK_island_id=isl.island_id");
            $stmt->execute();
            echo"
                <select name='county' class='filterSelect' data-target='select-parish' id='select-county' data-allowempty>
                    <option value='-1' selected>Selecione um concelho</option>
            ";
            foreach ($stmt as $row) {
                $id=$row['county_id'];
                $name=$row['county_name'];
                $idisl=$row['island_id'];

                echo"
                    <option value='".$id."' data-reference='".$id."' data-belongsto='".$idisl."'>".$name."</option>
                ";
            }
            echo"</select>";
        }

        public function getAllPropertyParishes(){
            $stmt = $this->conn->prepare("SELECT * FROM parish AS prsh JOIN county AS cnty ON prsh.PK_county_id=cnty.county_id");
            $stmt->execute();

            echo"
                <select name='parish' id='select-parish'>
                    <option value='-1' selected>Selecione uma freguesia</option>
            ";
            foreach ($stmt as $row) {
                $id=$row['parish_id'];
                $name=$row['parish_name'];
                $idcnty=$row['county_id'];

                echo"
                    <option value='".$id."' data-belongsto='".$idcnty."'>".$name."</option>
                ";
            }
            echo"</select>";
        }

        public function getAllPropertyBusinessTypes(){
            $stmt = $this->conn->prepare("SELECT * FROM business_type");
            $stmt->execute();
            foreach ($stmt as $row) {
                $id=$row['business_type_id'];
                $name=$row['business_type_name'];
                echo"
                    <option id='".$id."' value='".$id."'>".$name."</option>
                ";
            }
        }

        public function getAllUserIds(){
            $stmt = $this->conn->prepare("SELECT * FROM users WHERE PK_user_type_id=?");
            $stmt->bindValue(1,2);
            $stmt->execute();
            foreach ($stmt as $row) {
                $id=$row['user_id'];
                $name=$row['first_name'];
                $last_name=$row['last_name'];
                echo"
                    <option id='".$id."' value='".$id."'>".$name." ".$last_name."</option>
                ";
            }
        }

        public function getAllPropertyStatuses(){
            $stmt = $this->conn->prepare("SELECT * FROM property_status");
            $stmt->execute();
            foreach ($stmt as $row) {
                $id=$row['property_status_id'];
                $name=$row['property_status_name'];
                
                echo"<option id='".$id."' value='".$id."'>".$name."</option>";
            }
        }

        public function setAllPropertyTypes($propertyType){
            $stmt = $this->conn->prepare("SELECT * FROM property_type");
            $stmt->execute();
            $arr=array();
            foreach ($stmt as $row) {
                $id=$row['property_type_id'];
                $name=$row['property_type_name'];
                if($id== $propertyType){
                    $type = "selected";
                }
                else{
                    $type="";
                }
                array_push($arr,"<option id='".$id."' value='".$id."' ".$type.">".$name."</option>");
            }
            return implode("", $arr);
        }

        public function setAllPropertyTypologies($propertyTypology){
            $stmt = $this->conn->prepare("SELECT * FROM property_typology");
            $stmt->execute();
            $arr=array();
            foreach ($stmt as $row) {
                $id=$row['property_typology_id'];
                $name=$row['property_typology_name'];
                if($id== $propertyTypology){
                    $typo = "selected";
                }
                else{
                    $typo="";
                }
                array_push($arr, "<option id='".$id."' value='".$id."' ".$typo.">".$name."</option>");
            }
            return implode("", $arr);
        }

        public function setAllPropertyIslands(){
            $stmt = $this->conn->prepare("SELECT * FROM island");
            $stmt->execute();
            $arr=array();
            foreach ($stmt as $row) {
                $id=$row['island_id'];
                $name=$row['island_name'];
                array_push($arr, "<option value='".$id."' data-reference='".$id."'>".$name."</option>");
            }
            return implode(" ",$arr);
        }

        public function setAllPropertyCounties(){
            $stmt = $this->conn->prepare("SELECT * FROM county AS cnty JOIN island AS isl ON cnty.PK_island_id=isl.island_id");
            $stmt->execute();
            $arr=array();
            foreach ($stmt as $row) {
                $id=$row['county_id'];
                $name=$row['county_name'];
                $idisl=$row['island_id'];
                array_push($arr, "<option value='".$id."' data-reference='".$id."' data-belongsto='".$idisl."'>".$name."</option>");
            }
            return implode(" ",$arr);
        }

        public function setAllPropertyParishes($parish){
            $stmt = $this->conn->prepare("SELECT * FROM parish AS prsh JOIN county AS cnty ON prsh.PK_county_id=cnty.county_id");
            $stmt->execute();
            $arr=array();
            foreach ($stmt as $row) {
                $id=$row['parish_id'];
                $name=$row['parish_name'];
                $idcnty=$row['county_id'];
                if($id== $parish){
                    $par = "selected";
                }
                else{
                    $par="";
                }
                array_push($arr, "<option value='".$id."' data-belongsto='".$idcnty."' ".$par.">".$name."</option>");
            }
            return implode(" ",$arr);
        }

        public function setAllPropertyBusinessTypes($businessType){
            $stmt = $this->conn->prepare("SELECT * FROM business_type");
            $stmt->execute();
            $arr=array();
            foreach ($stmt as $row) {
                $id=$row['business_type_id'];
                $name=$row['business_type_name'];
                if($id== $businessType){
                    $bt = "selected";
                }
                else{
                    $bt="";
                }
                array_push($arr, "<option id='".$id."' value='".$id."' ".$bt.">".$name."</option>");
            }
            return implode(" ",$arr);
        }

        public function setAllUserIds($userId){
            $stmt = $this->conn->prepare("SELECT * FROM users WHERE PK_user_type_id=?");
            $stmt->bindValue(1,2);
            $stmt->execute();
            $arr = array();
            foreach ($stmt as $row) {
                $id=$row['user_id'];
                $name=$row['first_name'];
                $last_name=$row['last_name'];
                if($id== $userId){
                    $ui = "selected";
                }
                else{
                    $ui="";
                }
                array_push($arr,"<option id='".$id."' value='".$id."' ".$ui.">".$name." ".$last_name."</option>");
            }
            return implode(" ",$arr);
        }

        public function setAllPropertyStatuses($status){
            $stmt = $this->conn->prepare("SELECT * FROM property_status");
            $stmt->execute();
            $arr = array();
            foreach ($stmt as $row) {
                $id=$row['property_status_id'];
                $name=$row['property_status_name'];
                if($id== $status){
                    $stat = "selected";
                }
                else{
                    $stat="";
                }

                array_push($arr,"<option id='".$id."' value='".$id."' ".$stat.">".$name."</option>");
            }
            return implode(" ",$arr);
        }

        public function getBusinessTypes(){
            $stmt = $this->conn->prepare("SELECT * FROM business_type");
            $stmt->execute();

            foreach ($stmt as $row) {
                $btID=$row['business_type_id'];
                $btName=$row['business_type_name'];
                $replace = strtolower(str_replace(' ', '', $btName));
                $value = filter_var($replace, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
                echo"
                    <input type='checkbox' name='businessType[]' id='".$value."' value='".$btName."'> ".$btName."<br>
                ";
            }      
        }

        public function getTypes(){
            $stmt = $this->conn->prepare("SELECT * FROM property_type");
            $stmt->execute();

            foreach ($stmt as $row) {
                $ptID=$row['property_type_id'];
                $ptName=$row['property_type_name'];
                $replace = strtolower(str_replace(' ', '', $ptName));
                $value = filter_var($replace, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
                echo"
                    <input type='checkbox' name='propertyType[]' id='".$value."' value='".$ptName."'> ".$ptName."<br>
                ";
            }     
        }

        public function getTypologies(){
            $stmt = $this->conn->prepare("SELECT * FROM property_typology");
            $stmt->execute();

            foreach ($stmt as $row) {
                $ptyID=$row['property_typology_id'];
                $ptyName=$row['property_typology_name'];
                $replace = strtolower(str_replace(' ', '', $ptyName));
                $value = filter_var($replace, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
                if($ptyName=='n/a'){
                    echo"";
                }
                else{
                echo"
                    <input type='checkbox' name='propertyTypology[]' id='".$value."' value='".$ptyName."'> ".$ptyName."<br>
                ";
                }
            }     
        }

        public function getParishes(){
            $stmt = $this->conn->prepare("SELECT * FROM parish AS prs JOIN county AS cnty JOIN island AS isl ON cnty.PK_island_id=isl.island_id AND prs.PK_county_id=cnty.county_id");
            $stmt->execute();

            foreach ($stmt as $row) {
                $prshID=$row['parish_id'];
                $prshName=$row['parish_name'];
                $replace = strtolower(str_replace(' ', '', $prshName));
                $value = filter_var($replace, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

                $cntyName=$row['county_name'];
                $replaceCnty = strtolower(str_replace(' ', '', $cntyName));
                $cntyValue = filter_var($replaceCnty, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

                $islName=$row['island_name'];
                $replaceIsl = strtolower(str_replace(' ', '', $islName));
                $islValue = filter_var($replaceIsl, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

                echo"
                    <div class='parish' data-category='".$cntyValue." ".$islValue."'>
                        <input type='checkbox' name='parish[]' id='".$prshID."' value='".$prshName." - ".$cntyName." - ".$islName."'> ".$prshName."
                    </div>
                ";
            }     
        }

        public function getPropertiesNumberByParish(){
            $stmt = $this->conn->prepare("SELECT parish_name, PK_parish_id, parish_id, COUNT(*) AS `total`
                FROM property AS ppt JOIN parish AS ps
                ON ppt.PK_parish_id=ps.parish_id
                GROUP BY parish_id");
            $stmt->execute();

            echo"
                <div class='row'>
                    <div class='col col-6'>
                        <form action='../../php/propertiesNumberByParish_PDF.php'>
                            <button type='submit' class='backend'><i class='fa fa-file-pdf-o'></i></button>
                        </form>
                    </div>
                    <div class='col col-6'>
                        <form action='../../php/propertiesNumberByParish_CSV.php'>
                            <button type='submit' class='backend'><i class='fa fa-file-excel-o'></i></button>
                        </form>
                    </div>
                </div>
                <div class='row'><div class='col col-6'><b>Freguesia</div><div class='col col-6'>Nº propriedades</b></div></div>
            ";
            foreach ($stmt as $row) {
                if($row["total"]){
                    $total=$row["total"];
                } else{
                    $total=0;
                }
                echo"<div class='row'><div class='col col-6'>".$row["parish_name"]."</div><div class='col col-6'>".$total."</div></div>
                ";
            }
        }

        public function getPropertiesNumberByCounty(){
            $stmt = $this->conn->prepare("SELECT county_name, county_id, PK_county_id, PK_parish_id, parish_id, COUNT(*) AS `total`
                FROM property AS ppt JOIN county AS cnty JOIN parish AS ps
                ON ppt.PK_parish_id=ps.parish_id AND cnty.county_id=ps.PK_county_id
                GROUP BY county_id");
            $stmt->execute();

            echo"
                <div class='row'>
                    <div class='col col-6'>
                        <form action='../../php/propertiesNumberByCounty_PDF.php'>
                            <button type='submit' class='backend'><i class='fa fa-file-pdf-o'></i></button>
                        </form>
                    </div>
                    <div class='col col-6'>
                        <form action='../../php/propertiesNumberByCounty_CSV.php'>
                            <button type='submit' class='backend'><i class='fa fa-file-excel-o'></i></button>
                        </form>
                    </div>
                </div>";

            echo"<div class='row'><div class='col col-6'><b>Concelho</div><div class='col col-6'>Nº propriedades</b></div></div>";
            foreach ($stmt as $row) {
                echo"<div class='row'><div class='col col-6'>".$row["county_name"]."</div><div class='col col-6'>".$row["total"]."</div></div>";

            }
        }

        public function getPropertiesNumberByIsland(){
            $stmt = $this->conn->prepare("SELECT island_name, PK_island_id, island_id, county_id, PK_county_id, PK_parish_id, parish_id, COUNT(*) AS `total`
                FROM property AS ppt JOIN island AS isl JOIN county AS cnty JOIN parish AS ps
                ON ppt.PK_parish_id=ps.parish_id AND cnty.county_id=ps.PK_county_id AND isl.island_id=cnty.PK_island_id
                GROUP BY island_id");
            $stmt->execute();

            echo"
                <div class='row'>
                    <div class='col col-6'>
                        <form action='../../php/propertiesNumberByIsland_PDF.php'>
                            <button type='submit' class='backend'><i class='fa fa-file-pdf-o'></i></button>
                        </form>
                    </div>
                    <div class='col col-6'>
                        <form action='../../php/propertiesNumberByIsland_CSV.php'>
                            <button type='submit' name='getPropertiesNumberByParishCSV' class='backend'><i class='fa fa-file-excel-o'></i></button>
                        </form>
                    </div>
                </div>
            ";

            echo"<div class='row'><div class='col col-6'><b>Ilha</div><div class='col col-6'>Nº propriedades</b></div></div>";
            foreach ($stmt as $row) {
                if($row["total"] != 0){
                    $total=$row["total"];
                }
                else{
                    $total=0;
                }
                echo"<div class='row'><div class='col col-6'>".$row["island_name"]."</div><div class='col col-6'>".$total."</div></div>";

            }
        }

        public function getPropertiesNumberByParishPDF(){
            $stmt = $this->conn->prepare("SELECT parish_name, PK_parish_id, parish_id, COUNT(*) AS `total`
                FROM property AS ppt  JOIN parish AS ps
                ON ppt.PK_parish_id=ps.parish_id
                GROUP BY parish_id");
            $stmt->execute();

            $arr=array();
            
            array_push($arr, "<table style='width:50%;><tr><th>Freguesia:</th><th>Nº propriedades:</th></tr>");
            foreach ($stmt as $row) {
                array_push($arr, "<tr><td>".$row["parish_name"]."</td><td>".$row["total"]."</td></tr>");
            }
            array_push($arr, "</table>");
            return implode("", $arr);
        }

        public function getPropertiesNumberByCountyPDF(){
            $stmt = $this->conn->prepare("SELECT county_name, county_id, PK_county_id, PK_parish_id, parish_id, COUNT(*) AS `total`
                FROM property AS ppt JOIN county AS cnty JOIN parish AS ps
                ON ppt.PK_parish_id=ps.parish_id AND cnty.county_id=ps.PK_county_id
                GROUP BY county_id");
            $stmt->execute();

            $arr=array();
            
            array_push($arr, "<table style='width:50%;><tr><th>Concelho:</th><th>Nº propriedades:</th></tr>");
            foreach ($stmt as $row) {
                array_push($arr, "<tr><td>".$row["county_name"]."</td><td>".$row["total"]."</td></tr>");
            }
            array_push($arr, "</table>");
            return implode("", $arr);
        }

        public function getPropertiesNumberByIslandPDF(){
            $stmt = $this->conn->prepare("SELECT island_name, PK_island_id, island_id, county_id, PK_county_id, PK_parish_id, parish_id, COUNT(*) AS `total`
                FROM property AS ppt JOIN island AS isl JOIN county AS cnty JOIN parish AS ps
                ON ppt.PK_parish_id=ps.parish_id AND cnty.county_id=ps.PK_county_id AND isl.island_id=cnty.PK_island_id
                GROUP BY island_id");
            $stmt->execute();

            $arr=array();
            
            array_push($arr, "<table style='width:50%;'><tr><th>Ilha:</th><th>Nº propriedades:</th></tr>");
            foreach ($stmt as $row) {
                array_push($arr, "<tr><td>".$row["island_name"]."</td><td>".$row["total"]."</td></tr>");
            }
            array_push($arr, "</table>");
            return implode("", $arr);
        }

        public function getPropertiesNumberByType(){
            $stmt = $this->conn->prepare("SELECT property_type_name, property_type_id, PK_property_type_id, COUNT(*) AS `total`
                FROM property AS ppt JOIN property_type AS pt
                ON ppt.PK_property_type_id=pt.property_type_id
                GROUP BY PK_property_type_id");
            $stmt->execute();

            echo"
                <div class='row'>
                    <div class='col col-6'>
                        <form action='../../php/propertiesNumberByParish_PDF.php'>
                            <button type='submit' class='backend'><i class='fa fa-file-pdf-o'></i></button>
                        </form>
                    </div>
                    <div class='col col-6'>
                        <form action='../../php/propertiesNumberByParish_CSV.php'>
                            <button type='submit' class='backend'><i class='fa fa-file-excel-o'></i></button>
                        </form>
                    </div>
                </div>";

            echo"<div class='row'><div class='col col-6'><b>Tipo de propriedade:</div><div class='col col-6'>Nº propriedades</b></div></div>";
            foreach ($stmt as $row) {
                echo"<div class='row'><div class='col col-6'>".$row["property_type_name"]."</div><div class='col col-6'>".$row["total"]."</div></div>";

            }
        }

        public function getPropertiesNumberByRange(){
            $stmt = $this->conn->prepare("SELECT '0-100' AS `range`,
                SUM(CASE WHEN price BETWEEN 0 AND 100 THEN 1 ELSE 0 END) AS `total` FROM property union
                SELECT '100-200' AS `range`,
                SUM(CASE WHEN price BETWEEN 100 AND 200 THEN 1 ELSE 0 END) AS `total` FROM property union
                SELECT '200-300' AS `range`,
                SUM(CASE WHEN price BETWEEN 200 AND 300 THEN 1 ELSE 0 END) AS `total` FROM property union
                SELECT '300-400' AS `range`,
                SUM(CASE WHEN price BETWEEN 300 AND 400 THEN 1 ELSE 0 END) AS `total` FROM property union
                SELECT '400-500' AS `range`,
                SUM(CASE WHEN price BETWEEN 400 AND 500 THEN 1 ELSE 0 END) AS `total` FROM property union
                SELECT '500-600' AS `range`,
                SUM(CASE WHEN price BETWEEN 500 AND 600 THEN 1 ELSE 0 END) AS `total` FROM property union
                SELECT '600-700' AS `range`,
                SUM(CASE WHEN price BETWEEN 600 AND 700 THEN 1 ELSE 0 END) AS `total` FROM property union
                SELECT '700-800' AS `range`,
                SUM(CASE WHEN price BETWEEN 700 AND 800 THEN 1 ELSE 0 END) AS `total` FROM property union
                SELECT '800-900' AS `range`,
                SUM(CASE WHEN price BETWEEN 800 AND 900 THEN 1 ELSE 0 END) AS `total` FROM property union
                SELECT '900-1000' AS `range`,
                SUM(CASE WHEN price BETWEEN 900 AND 1000 THEN 1 ELSE 0 END) AS `total` FROM property union
                SELECT '1000-2000' AS `range`,
                SUM(CASE WHEN price BETWEEN 1000 AND 2000 THEN 1 ELSE 0 END) AS `total` FROM property union
                SELECT '2000-3000' AS `range`,
                SUM(CASE WHEN price BETWEEN 2000 AND 3000 THEN 1 ELSE 0 END) AS `total` FROM property union
                SELECT '3000-4000' AS `range`,
                SUM(CASE WHEN price BETWEEN 3000 AND 4000 THEN 1 ELSE 0 END) AS `total` FROM property union
                SELECT '4000-5000' AS `range`,
                SUM(CASE WHEN price BETWEEN 4000 AND 5000 THEN 1 ELSE 0 END) AS `total` FROM property union
                SELECT '5000-6000' AS `range`,
                SUM(CASE WHEN price BETWEEN 5000 AND 6000 THEN 1 ELSE 0 END) AS `total` FROM property union
                SELECT '6000-7000' AS `range`,
                SUM(CASE WHEN price BETWEEN 6000 AND 7000 THEN 1 ELSE 0 END) AS `total` FROM property union
                SELECT '7000-8000' AS `range`,
                SUM(CASE WHEN price BETWEEN 7000 AND 8000 THEN 1 ELSE 0 END) AS `total` FROM property union
                SELECT '8000-9000' AS `range`,
                SUM(CASE WHEN price BETWEEN 8000 AND 9000 THEN 1 ELSE 0 END) AS `total` FROM property union
                SELECT '9000-10000' AS `range`,
                SUM(CASE WHEN price BETWEEN 9000 AND 10000 THEN 1 ELSE 0 END) AS `total` FROM property union
                SELECT '10000-20000' AS `range`,
                SUM(CASE WHEN price BETWEEN 10000 AND 20000 THEN 1 ELSE 0 END) AS `total` FROM property union
                SELECT '20000-30000' AS `range`,
                SUM(CASE WHEN price BETWEEN 20000 AND 30000 THEN 1 ELSE 0 END) AS `total` FROM property union
                SELECT '30000-40000' AS `range`,
                SUM(CASE WHEN price BETWEEN 30000 AND 40000 THEN 1 ELSE 0 END) AS `total` FROM property union
                SELECT '40000-50000' AS `range`,
                SUM(CASE WHEN price BETWEEN 40000 AND 50000 THEN 1 ELSE 0 END) AS `total` FROM property union
                SELECT '50000-60000' AS `range`,
                SUM(CASE WHEN price BETWEEN 50000 AND 60000 THEN 1 ELSE 0 END) AS `total` FROM property union
                SELECT '60000-70000' AS `range`,
                SUM(CASE WHEN price BETWEEN 60000 AND 70000 THEN 1 ELSE 0 END) AS `total` FROM property union
                SELECT '70000-80000' AS `range`,
                SUM(CASE WHEN price BETWEEN 70000 AND 80000 THEN 1 ELSE 0 END) AS `total` FROM property union
                SELECT '80000-90000' AS `range`,
                SUM(CASE WHEN price BETWEEN 80000 AND 90000 THEN 1 ELSE 0 END) AS `total` FROM property union
                SELECT '90000-100000' AS `range`,
                SUM(CASE WHEN price BETWEEN 90000 AND 100000 THEN 1 ELSE 0 END) AS `total` FROM property union
                SELECT '100000-200000' AS `range`,
                SUM(CASE WHEN price BETWEEN 100000 AND 200000 THEN 1 ELSE 0 END) AS `total` FROM property union
                SELECT '200000-300000' AS `range`,
                SUM(CASE WHEN price BETWEEN 200000 AND 300000 THEN 1 ELSE 0 END) AS `total` FROM property union
                SELECT '300000-400000' AS `range`,
                SUM(CASE WHEN price BETWEEN 300000 AND 400000 THEN 1 ELSE 0 END) AS `total` FROM property union
                SELECT '400000-500000' AS `range`,
                SUM(CASE WHEN price BETWEEN 400000 AND 500000 THEN 1 ELSE 0 END) AS `total` FROM property union
                SELECT '500000-600000' AS `range`,
                SUM(CASE WHEN price BETWEEN 500000 AND 600000 THEN 1 ELSE 0 END) AS `total` FROM property union
                SELECT '600000-7000000' AS `range`,
                SUM(CASE WHEN price BETWEEN 600000 AND 700000 THEN 1 ELSE 0 END) AS `total` FROM property union
                SELECT '700000-800000' AS `range`,
                SUM(CASE WHEN price BETWEEN 700000 AND 800000 THEN 1 ELSE 0 END) AS `total` FROM property union
                SELECT '800000-900000' AS `range`,
                SUM(CASE WHEN price BETWEEN 800000 AND 900000 THEN 1 ELSE 0 END) AS `total` FROM property union
                SELECT '900000-1000000' AS `range`,
                SUM(CASE WHEN price BETWEEN 900000 AND 1000000 THEN 1 ELSE 0 END) AS `total` FROM property union
                SELECT ' > 1000000' AS `range`,
                SUM(CASE WHEN price > 1000000 THEN 1 ELSE 0 END) AS `total` FROM property");
            $stmt->execute();

            $arr=array();
            array_push($arr, "
                <div class='row'>
                    <div class='col col-6'>
                        <form action='../../php/propertiesNumberByPriceRange_PDF.php'>
                            <button type='submit' class='backend'><i class='fa fa-file-pdf-o'></i></button>
                        </form>
                    </div>
                    <div class='col col-6'>
                        <form action='../../php/propertiesNumberByPriceRange_CSV.php'>
                            <button type='submit' class='backend'><i class='fa fa-file-excel-o'></i></button>
                        </form>
                    </div>
                </div>
                <div class='row'><div class='col col-6'><b>Intervalo de preço:</div><div class='col col-6'>Nº propriedades</b></div></div>");
            
            foreach ($stmt as $row) {
                array_push($arr,"<div class='row'><div class='col col-6'>".$row["range"]."€</div><div class='col col-6'>".$row["total"]."</div></div>");
            }
            echo (implode("", $arr));
            return (implode("", $arr));
        }

        public function getPropertiesNumberByRangePDF(){
            $stmt = $this->conn->prepare("SELECT '0-100' AS `range`,
                SUM(CASE WHEN price BETWEEN 0 AND 100 THEN 1 ELSE 0 END) AS `total` FROM property union
                SELECT '100-200' AS `range`,
                SUM(CASE WHEN price BETWEEN 100 AND 200 THEN 1 ELSE 0 END) AS `total` FROM property union
                SELECT '200-300' AS `range`,
                SUM(CASE WHEN price BETWEEN 200 AND 300 THEN 1 ELSE 0 END) AS `total` FROM property union
                SELECT '300-400' AS `range`,
                SUM(CASE WHEN price BETWEEN 300 AND 400 THEN 1 ELSE 0 END) AS `total` FROM property union
                SELECT '400-500' AS `range`,
                SUM(CASE WHEN price BETWEEN 400 AND 500 THEN 1 ELSE 0 END) AS `total` FROM property union
                SELECT '500-600' AS `range`,
                SUM(CASE WHEN price BETWEEN 500 AND 600 THEN 1 ELSE 0 END) AS `total` FROM property union
                SELECT '600-700' AS `range`,
                SUM(CASE WHEN price BETWEEN 600 AND 700 THEN 1 ELSE 0 END) AS `total` FROM property union
                SELECT '700-800' AS `range`,
                SUM(CASE WHEN price BETWEEN 700 AND 800 THEN 1 ELSE 0 END) AS `total` FROM property union
                SELECT '800-900' AS `range`,
                SUM(CASE WHEN price BETWEEN 800 AND 900 THEN 1 ELSE 0 END) AS `total` FROM property union
                SELECT '900-1000' AS `range`,
                SUM(CASE WHEN price BETWEEN 900 AND 1000 THEN 1 ELSE 0 END) AS `total` FROM property union
                SELECT '2000-3000' AS `range`,
                SUM(CASE WHEN price BETWEEN 2000 AND 3000 THEN 1 ELSE 0 END) AS `total` FROM property union
                SELECT '3000-4000' AS `range`,
                SUM(CASE WHEN price BETWEEN 3000 AND 4000 THEN 1 ELSE 0 END) AS `total` FROM property union
                SELECT '4000-5000' AS `range`,
                SUM(CASE WHEN price BETWEEN 4000 AND 5000 THEN 1 ELSE 0 END) AS `total` FROM property union
                SELECT '5000-6000' AS `range`,
                SUM(CASE WHEN price BETWEEN 5000 AND 6000 THEN 1 ELSE 0 END) AS `total` FROM property union
                SELECT '6000-7000' AS `range`,
                SUM(CASE WHEN price BETWEEN 6000 AND 7000 THEN 1 ELSE 0 END) AS `total` FROM property union
                SELECT '7000-8000' AS `range`,
                SUM(CASE WHEN price BETWEEN 7000 AND 8000 THEN 1 ELSE 0 END) AS `total` FROM property union
                SELECT '8000-9000' AS `range`,
                SUM(CASE WHEN price BETWEEN 8000 AND 9000 THEN 1 ELSE 0 END) AS `total` FROM property union
                SELECT '9000-10000' AS `range`,
                SUM(CASE WHEN price BETWEEN 9000 AND 10000 THEN 1 ELSE 0 END) AS `total` FROM property union
                SELECT '10000-20000' AS `range`,
                SUM(CASE WHEN price BETWEEN 10000 AND 20000 THEN 1 ELSE 0 END) AS `total` FROM property union
                SELECT '20000-30000' AS `range`,
                SUM(CASE WHEN price BETWEEN 20000 AND 30000 THEN 1 ELSE 0 END) AS `total` FROM property union
                SELECT '30000-40000' AS `range`,
                SUM(CASE WHEN price BETWEEN 30000 AND 40000 THEN 1 ELSE 0 END) AS `total` FROM property union
                SELECT '40000-50000' AS `range`,
                SUM(CASE WHEN price BETWEEN 40000 AND 50000 THEN 1 ELSE 0 END) AS `total` FROM property union
                SELECT '50000-60000' AS `range`,
                SUM(CASE WHEN price BETWEEN 50000 AND 60000 THEN 1 ELSE 0 END) AS `total` FROM property union
                SELECT '60000-70000' AS `range`,
                SUM(CASE WHEN price BETWEEN 60000 AND 70000 THEN 1 ELSE 0 END) AS `total` FROM property union
                SELECT '70000-80000' AS `range`,
                SUM(CASE WHEN price BETWEEN 70000 AND 80000 THEN 1 ELSE 0 END) AS `total` FROM property union
                SELECT '80000-90000' AS `range`,
                SUM(CASE WHEN price BETWEEN 80000 AND 90000 THEN 1 ELSE 0 END) AS `total` FROM property union
                SELECT '90000-100000' AS `range`,
                SUM(CASE WHEN price BETWEEN 90000 AND 100000 THEN 1 ELSE 0 END) AS `total` FROM property union
                SELECT '100000-200000' AS `range`,
                SUM(CASE WHEN price BETWEEN 100000 AND 200000 THEN 1 ELSE 0 END) AS `total` FROM property union
                SELECT '200000-300000' AS `range`,
                SUM(CASE WHEN price BETWEEN 200000 AND 300000 THEN 1 ELSE 0 END) AS `total` FROM property union
                SELECT '300000-400000' AS `range`,
                SUM(CASE WHEN price BETWEEN 300000 AND 400000 THEN 1 ELSE 0 END) AS `total` FROM property union
                SELECT '400000-500000' AS `range`,
                SUM(CASE WHEN price BETWEEN 400000 AND 500000 THEN 1 ELSE 0 END) AS `total` FROM property union
                SELECT '500000-600000' AS `range`,
                SUM(CASE WHEN price BETWEEN 500000 AND 600000 THEN 1 ELSE 0 END) AS `total` FROM property union
                SELECT '600000-7000000' AS `range`,
                SUM(CASE WHEN price BETWEEN 600000 AND 700000 THEN 1 ELSE 0 END) AS `total` FROM property union
                SELECT '700000-800000' AS `range`,
                SUM(CASE WHEN price BETWEEN 700000 AND 800000 THEN 1 ELSE 0 END) AS `total` FROM property union
                SELECT '800000-900000' AS `range`,
                SUM(CASE WHEN price BETWEEN 800000 AND 900000 THEN 1 ELSE 0 END) AS `total` FROM property union
                SELECT '900000-1000000' AS `range`,
                SUM(CASE WHEN price BETWEEN 900000 AND 1000000 THEN 1 ELSE 0 END) AS `total` FROM property union
                SELECT ' > 1000000' AS `range`,
                SUM(CASE WHEN price > 1000000 THEN 1 ELSE 0 END) AS `total` FROM property");
            $stmt->execute();

            $arr=array();
            array_push($arr, "<table style='width:50%;'><tr><th>Intervalo de preço:</th><th>Nº propriedades:</th></tr>");
            
            foreach ($stmt as $row) {
                array_push($arr,"<tr><td style='text-align:left;'>".$row["range"]."€</td><td style='text-align:center;'>".$row["total"]."</td></tr>");
            }
            array_push($arr,"</table>");
            return (implode("", $arr));
        }

        public function minPrice(){
            $stmt = $this->conn->prepare("SELECT MIN(price) AS price FROM property");
            $stmt->execute();

            $row=$stmt->fetch(PDO::FETCH_ASSOC);
            return $row["price"];
        }

        public function maxPrice(){
            $stmt = $this->conn->prepare("SELECT MAX(price) AS price FROM property");
            $stmt->execute();

            $row=$stmt->fetch(PDO::FETCH_ASSOC);
            return $row["price"];
        }

	}

?>

