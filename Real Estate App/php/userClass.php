<?php
    
    require_once('databaseConnection.php');
    require_once('visitClass.php');
    
    class USER{
       
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

        public function register($firstname, $lastname, $email, $pass, $phone) {
            try {
             
                $new_password = md5($pass);
                $stmt = $this->conn->prepare("INSERT INTO users(first_name, last_name, email, password, phone_number, PK_user_type_id) 
                    VALUES(:firstname, :lastname, :email, :pass, :phone, :userType)");
                $stmt->bindparam(":firstname", $firstname);
                $stmt->bindparam(":lastname", $lastname);
                $stmt->bindparam(":email", $email);
                $stmt->bindparam(":pass", $new_password);
                $stmt->bindparam(":phone", $phone);
                $stmt->bindvalue(":userType", 1);           
                $stmt->execute(); 
       
                return $stmt; 
            }
            catch(PDOException $e) {
                echo $e->getMessage();
            }    
        }

        public function updateFirstName($firstname, $userId) {
            try {
                $stmt = $this->conn->prepare("UPDATE users SET first_name=? WHERE user_id=?");
                  
                $stmt->bindparam(1, $firstname);
                $stmt->bindparam(2, $userId);          
                $stmt->execute(); 
       
                return $stmt; 
            }
            catch(PDOException $e) {
                echo $e->getMessage();
            }    
        }

        public function updateLastName($lastname, $userId) {
            try {
                $stmt = $this->conn->prepare("UPDATE users SET last_name=? WHERE user_id=?");
                  
                $stmt->bindparam(1, $lastname);
                $stmt->bindparam(2, $userId);       
                $stmt->execute(); 
       
                return $stmt; 
            }
            catch(PDOException $e) {
                echo $e->getMessage();
            }    
        }

        public function updateEmail($email, $userId) {
            try {
                $stmt = $this->conn->prepare("UPDATE users SET email=? WHERE user_id=?");
                  
                $stmt->bindparam(1, $email);
                $stmt->bindparam(2, $userId);     
                $stmt->execute(); 
       
                return $stmt; 
            }
            catch(PDOException $e) {
                echo $e->getMessage();
            }    
        }

        public function updatePhoneNumber($phone, $userId) {
            try {
                $stmt = $this->conn->prepare("UPDATE users SET phone_number=? WHERE user_id=?");
                  
                $stmt->bindparam(1, $phone);
                $stmt->bindparam(2, $userId);
                $stmt->execute(); 
       
                return $stmt; 
            }
            catch(PDOException $e) {
                echo $e->getMessage();
            }    
        }

        public function doLogin($email, $pass) {
            try {
                $stmt = $this->conn->prepare("SELECT user_id, first_name, last_name, phone_number, email, password, PK_user_type_id FROM users WHERE email=:email");
                $stmt->execute(array(':email'=>$email));
                $userRow=$stmt->fetch(PDO::FETCH_ASSOC);
                if($stmt->rowCount() == 1) {
                    if($pass == $userRow['password']) {
                        $_SESSION['user_session'] = $userRow['user_id'];
                        return true;
                    }
                    else {
                        return false;
                    }
                }
            }
            catch(PDOException $e) {
                echo $e->getMessage();
            }
        }

        public function is_loggedin() {
            if(isset($_SESSION['user_session'])) {
                return true;
            }
        }
     
        public function redirect($url) {
            header("Location: $url");
        }
     
        public function doLogout() {
            session_destroy();
            unset($_SESSION['user_session']);
            return true;
        }

        public function getAllUsers() {
            $visit= new VISIT();
            $stmt = $this->conn->prepare("SELECT * FROM users AS u
                LEFT JOIN preferences AS pf
                ON u.user_id=pf.Pk_user_id
                WHERE PK_user_type_id = ?");
            $stmt->bindValue(1, 1);
            $stmt->execute();
            if (!$result = $stmt) {
                die ('ERRO ['.$db->error.']');
                return;
            }
            foreach ($result as $row) {
                $id=$row['user_id'];
                echo"
                    <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
                    <script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js'></script>

                    <li>
                        <div class='col col-1'>
                           <h5>".$row['user_id']."</h5>
                        </div>
                        <div class='col col-3'>
                            <h5><a>".$row['first_name']." ".$row['last_name']."</a></h5>
                        </div>
                        <div class='col col-3'>
                            <h5> ".$row['email']." </h5>
                        </div>
                        <div class='col col-2'>
                            <h5> ".$row['phone_number']." </h5>
                        </div>
                        <div class='col col-1'>
                            <button data-toggle='modal' data-target='#view-user-details-modal-".$id."' id='updatePhoto' class='backend'><i style='font-size:30px;' class='fa fa-eye'></i></button>
                        </div>
                        <div class='col col-1'>
                            <form method='post' action='../../php/client_info_pdf.php'>
                                <input type='hidden' name='id' value='".$id."'>
                                <input type='hidden' name='firstName' value='".$row["first_name"]."'>
                                <input type='hidden' name='lastName' value='".$row["last_name"]."'>
                                <input type='hidden' name='email' value='".$row["email"]."'>
                                <input type='hidden' name='phone' value='".$row["phone_number"]."'>
                                <input type='hidden' name='businessTypes' value='".$row["business_types"]."'>
                                <input type='hidden' name='propertyTypes' value='".$row["property_types"]."'>
                                <input type='hidden' name='propertyTypologies' value='".$row["property_typologies"]."'>
                                <input type='hidden' name='parishes' value='".$row["parishes"]."'>
                                <input type='hidden' name='maxValue' value='".$row["max_value"]."'>
                                <input type='hidden' name='minValue' value='".$row["min_value"]."'>
                                <button type='submit' name='submitUserDetails' class='backend'><i style='font-size:30px;' class='  fa fa-file-pdf-o'></i></button>
                            </form>
                        </div>
                        <div class='col col-1'>
                            <form action='../../php/addManager.php?user_id='".$id."' method='post'>
                                <input type='hidden' name='id' value='".$id."'>
                                <button type='submit' class='btn backend' id='".$id."'><i style='font-size:30px;' class='fa fa-user-plus'></i></button>
                            </form>
                        </div>
                    </li>

                    <!-- SEE USER DETAILS -->
            <div id='view-user-details-modal-".$id."' class='modal fade' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true' style='display: none;''>
                <div class='modal-dialog modal-lg'>
                    <div class='modal-content'>
                        <div class='modal-header'>
                            <span data-dismiss='modal' style='position: absolute;right: 25px;top: 0;color: #000;font-size: 35px;font-weight: bold; cursor: pointer;'>&times;</span>
                        </div>
                        <div class='modal-body'>

                            <button class='accordion'>Informação Pessoal</button>
                            <div class='panel'>
                                <div class='col col-6'>
                                photo
                                </div>
                                <div class='col col-6'>
                                    <div class='row user'>
                                        <p><b>ID:</b> ".$row["user_id"]."</p>
                                    </div>
                                    <div class='row user'>
                                        <p><b>Nome:</b> ".$row["first_name"]." ".$row["last_name"]."</p>
                                    </div>
                                    <div class='row user'>
                                        <p><b>Email:</b> ".$row["email"]."</p>
                                    </div>
                                    <div class='row user'>
                                        <p><b>Contacto:</b> ".$row["phone_number"]."</p>
                                    </div>
                                </div>
                            </div>

                            <button class='accordion'>Preferências</button>
                            <div class='panel'>
                                ".$this->getPreferences($id)."
                            </div>

                            <button class='accordion'>Visitas Marcadas</button>
                            <div class='panel'>
                                ".$visit->getVisitManager($id)."
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script src='../../js/accordion.js'></script>
                ";
            }
        }

        public function getAllManagers() {
            $stmt = $this->conn->prepare("SELECT * FROM users as u 
                WHERE PK_user_type_id = ?");
            $stmt->bindValue(1, 2);
            $stmt->execute();
            if (!$result = $stmt) {
                die ('ERRO ['.$db->error.']');
                return;
            }
            foreach ($result as $row) {
                $id=$row['user_id'];
                echo"
                    <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
                    <script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js'></script>

                    <li>
                        <div class='col col-1'>
                           <h5> ".$row['user_id']." </h5>
                        </div>
                        <div class='col col-3'>
                            <h5><a>".$row['first_name']." ".$row['last_name']."</a></h5>
                        </div>
                        <div class='col col-3'>
                            <h5> ".$row['email']." </h5>
                        </div>
                        <div class='col col-2'>
                            <h5> ".$row['phone_number']." </h5>
                        </div>
                        <div class='col col-1'>
                            <button data-toggle='modal' data-target='#view-manager-details-modal-".$id."' id='updatePhoto' class='backend'><i style='font-size:30px;' class='fa fa-eye'></i></button>
                        </div>
                        <div class='col col-1'>
                            <form method='post' action='../../php/manager_info_pdf.php'>
                                <input type='hidden' name='id' value='".$id."'>
                                <input type='hidden' name='firstName' value='".$row["first_name"]."'>
                                <input type='hidden' name='lastName' value='".$row["last_name"]."'>
                                <input type='hidden' name='email' value='".$row["email"]."'>
                                <input type='hidden' name='phone' value='".$row["phone_number"]."'>
                                <button type='submit' name='submitUserDetails' class='backend'><i style='font-size:30px;' class='  fa fa-file-pdf-o'></i></button>
                            </form>
                        </div>
                        <div class='col col-1'>
                            <form action='../../php/deleteManager.php?id='".$id."' method='post'>
                                <input type='hidden' name='id' value='".$id."'>
                                <button type='submit' class='btn backend' id='".$id."'><i style='font-size:30px;' class='fa fa-remove'></i></button>
                            </form>
                        </div>
                    </li>

                    <!-- SEE USER DETAILS -->
             <div id='view-manager-details-modal-".$id."' class='modal fade' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true' style='display: none;''>
                <div class='modal-dialog modal-lg'>
                    <div class='modal-content'>
                        <div class='modal-header'>
                        <h4>Informação Pessoal e de contacto</h4>
                            <span data-dismiss='modal' style='position: absolute;right: 25px;top: 0;color: #000;font-size: 35px;font-weight: bold; cursor: pointer;'>&times;</span>
                        </div>
                        <div class='modal-body'>
                            <div class='row'>
                                <div class='col col-6'>
                                    photo
                                </div>
                                <div class='col col-6'>
                                    <div class='row'>
                                        <p><b>ID:</b> ".$row["user_id"]."</p>
                                    </div>
                                    <div class='row'>
                                        <p><b>Nome:</b> ".$row["first_name"]." ".$row["last_name"]."</p>
                                    </div>
                                    <div class='row'>
                                        <p><b>Email:</b> ".$row["email"]."</p>
                                    </div>
                                    <div class='row'>
                                        <p><b>Contacto:</b> ".$row["phone_number"]."</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script src='../../js/accordion.js'></script>
                ";
            }
        }

        public function addToManagers() {
            $stmt = $this->conn->prepare("SELECT * FROM users WHERE PK_user_type_id = ?");
            $stmt->bindValue(1, 2);
            $stmt->execute();
            if (!$result = $stmt) {
                die ('ERRO ['.$db->error.']');
                return;
            }
            foreach ($result as $row) {
                $id=$row['user_id'];
                echo"
                    <div class='row'>
                        <div class='col col-2'>
                           <h5> ".$row['user_id']." </h5>
                        </div>
                        <div class='col col-3'>
                            <h5> ".$row['first_name']." ".$row['last_name']." </h5>
                        </div>
                        <div class='col col-3'>
                            <h5> ".$row['email']." </h5>
                        </div>
                        <div class='col col-3'>
                            <h5> ".$row['phone_number']." </h5>
                        </div>
                        <div class='col col-1'>
                            <button type='button' class='btn backend' data-toggle='modal' data-target='#myModal'><i class='fa fa-remove'></i></button>
                        </div>
                    </div>
                ";
            }
        }

        public function removeFromManagers() {
            $stmt = $this->conn->prepare("SELECT * FROM users WHERE PK_user_type_id = ?");
            $stmt->bindValue(1, 2);
            $stmt->execute();
            if (!$result = $stmt) {
                die ('ERRO ['.$db->error.']');
                return;
            }
            foreach ($result as $row) {
                $id=$row['user_id'];
                echo"
                    <div class='row'>
                        <div class='col col-2'>
                           <h5> ".$row['user_id']." </h5>
                        </div>
                        <div class='col col-3'>
                            <h5> ".$row['first_name']." ".$row['last_name']." </h5>
                        </div>
                        <div class='col col-3'>
                            <h5> ".$row['email']." </h5>
                        </div>
                        <div class='col col-3'>
                            <h5> ".$row['phone_number']." </h5>
                        </div>
                        <div class='col col-1'>
                            <button><i class='fa fa-remove'></i></button>
                        </div>
                    </div>
                ";
            }
        }

        public function getPreferences($userId) {
            $stmt = $this->conn->prepare("SELECT * FROM preferences WHERE PK_user_id = ?");
            $stmt->bindValue(1, $userId);
            $stmt->execute();
            if (!$result = $stmt) {
                die ('ERRO ['.$db->error.']');
                return;
            }
            foreach ($result as $row) {
                return"
                    <div class='row'>
                        <div class='col col-12'>
                            <h3>Preferências:</h3>
                            <div class='row user'>
                                <div class='col col-6'>
                                     <p><b>Tipos de negócio</b></p>      
                                </div>
                                <div class='col col-6'>
                                    ".$row["business_types"]."
                                </div>
                            </div>
                            <div class='row user'>
                                <div class='col col-6'>
                                     <p><b>Tipos de propriedade:</b></p>    
                                </div>
                                <div class='col col-6'>
                                    ".$row["property_types"]."
                                </div>
                            </div>
                            <div class='row user'>
                                <div class='col col-6'>
                                     <p><b>Tipologias:</b></p>     
                                </div>
                                <div class='col col-6'>
                                    ".$row["property_typologies"]."
                                </div>
                            </div>
                            <div class='row user'>
                                <div class='col col-6'>
                                     <p><b>Localidades:</b></p>
                                </div>
                                <div class='col col-6'>
                                    ".$row["parishes"]."
                                </div>
                            </div>
                            <div class='row user'>
                                <div class='col col-6'>
                                     <p><b>Preço máximo:</b></p>
                                     ".$row["max_value"]." ‎€
                                </div>
                                <div class='col col-6'>
                                    <p><b>Preço mínimo:</b></p>
                                     ".$row["min_value"]." ‎€
                                </div>
                            </div>
                        </div>
                    </div>
                ";
            }
        }

        public function getAllUsersManagerView() {
            $visit= new VISIT();
            $stmt = $this->conn->prepare("SELECT * FROM users AS u
                LEFT JOIN preferences AS pf
                ON u.user_id=pf.Pk_user_id
                WHERE PK_user_type_id = ?");

            $stmt->bindValue(1, 1);
            $stmt->execute();
            if (!$result = $stmt) {
                die ('ERRO ['.$db->error.']');
                return;
            }
            foreach ($result as $row) {
                $id=$row['user_id'];
                echo"
                    <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
                    <script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js'></script>
                  
                    <li>
                        <div class='col col-1'>
                           <h5> ".$row['user_id']." </h5>
                        </div>
                        <div class='col col-3'>
                            <h5><a>".$row['first_name']." ".$row['last_name']."</a></h5>
                        </div>
                        <div class='col col-3'>
                            <h5> ".$row['email']." </h5>
                        </div>
                        <div class='col col-2'>
                            <h5> ".$row['phone_number']." </h5>
                        </div>
                        <div class='col col-1'>
                            ".$visit->getVisitRequestsNumber($id)."
                        </div>
                        <div class='col col-1'>
                            <button data-toggle='modal' data-target='#view-user-details-modal-".$id."' id='updatePhoto' class='backend'><i style='font-size:30px;' class='fa fa-eye'></i></button>
                        </div>
                        <div class='col col-1'>
                            <form method='post' action='../../php/client_info_pdf.php'>
                                <input type='hidden' name='id' value='".$id."'>
                                <input type='hidden' name='firstName' value='".$row["first_name"]."'>
                                <input type='hidden' name='lastName' value='".$row["last_name"]."'>
                                <input type='hidden' name='email' value='".$row["email"]."'>
                                <input type='hidden' name='phone' value='".$row["phone_number"]."'>
                                <input type='hidden' name='businessTypes' value='".$row["business_types"]."'>
                                <input type='hidden' name='propertyTypes' value='".$row["property_types"]."'>
                                <input type='hidden' name='propertyTypologies' value='".$row["property_typologies"]."'>
                                <input type='hidden' name='parishes' value='".$row["parishes"]."'>
                                <input type='hidden' name='maxValue' value='".$row["max_value"]."'>
                                <input type='hidden' name='minValue' value='".$row["min_value"]."'>
                                <button type='submit' name='submitUserDetails' class='backend'><i style='font-size:30px;' class='  fa fa-file-pdf-o'></i></button>
                            </form>
                        </div>
                    </li>

                   <!-- SEE USER DETAILS -->
            <div id='view-user-details-modal-".$id."' class='modal fade' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true' style='display: none;''>
                <div class='modal-dialog modal-lg'>
                    <div class='modal-content'>
                        <div class='modal-header'>
                            <span data-dismiss='modal' style='position: absolute;right: 25px;top: 0;color: #000;font-size: 35px;font-weight: bold; cursor: pointer;'>&times;</span>
                        </div>
                        <div class='modal-body'>

                            <button class='accordion'>Informação Pessoal</button>
                            <div class='panel'>
                                <div class='col col-12'>
                                    <div class='row user'>
                                        <p><b>ID:</b> ".$row["user_id"]."</p>
                                    </div>
                                    <div class='row user'>
                                        <p><b>Nome:</b> ".$row["first_name"]." ".$row["last_name"]."</p>
                                    </div>
                                    <div class='row user'>
                                        <p><b>Email:</b> ".$row["email"]."</p>
                                    </div>
                                    <div class='row user'>
                                        <p><b>Contacto:</b> ".$row["phone_number"]."</p>
                                    </div>
                                </div>
                            </div>

                            <button class='accordion'>Preferências</button>
                            <div class='panel'>
                                ".$this->getPreferences($id)."
                            </div>

                            <button class='accordion'>Visitas Marcadas</button>
                            <div class='panel'>
                                ".$visit->getVisitManager($id)."
                            </div>

                            <button class='accordion'>".$visit->getVisitRequestsNumber($id)." Pedidos de Visita</button>
                            <div class='panel'>
                                ".$visit->getVisitRequestsManager($id)."
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script src='../../js/accordion.js'></script>
                ";
            }
        }
    }
?>