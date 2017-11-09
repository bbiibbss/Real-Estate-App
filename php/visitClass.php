<?php
    
    require_once('databaseConnection.php');
    
    class VISIT{
       
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

        public function getObservations($visit_id) {
            $stmt = $this->conn->prepare("SELECT observations FROM visit_request WHERE id_visit_request=?");
            $stmt->bindParam(1, $visit_id);
            $stmt->execute();
            foreach ($stmt as $row){
                return "<textarea id='observations' name='observations' rows='6' style='width:100%'>".$row["observations"]."</textarea>";
            }
        }

        public function getVisitDate($visit_id) {
            $stmt = $this->conn->prepare("SELECT DATE_FORMAT(date_time, '%Y-%m-%dT%H:%i') AS visit_date FROM visit_request WHERE id_visit_request=?");
            $stmt->bindParam(1, $visit_id);
            $stmt->execute();
            foreach ($stmt as $row){
                $visitDate=$row["visit_date"];
                return "<input type='datetime-local' value='".$visitDate."' name='visitDate'>";
            }
        }

        public function getVisitRequestDate($visit_id) {
            $stmt = $this->conn->prepare("SELECT DATE_FORMAT(date_time, '%Y-%m-%dT%H:%i') AS visit_date FROM visit_request WHERE id_visit_request=?");
            $stmt->bindParam(1, $visit_id);
            $stmt->execute();
            foreach ($stmt as $row){
                $visitDate=$row["visit_date"];
                return ("<input type='datetime-local' value='".$visitDate."' name='visitDate'>");
            }
        }

        public function getVisitUser($userId) {
            $stmt = $this->conn->prepare("SELECT * FROM visit AS vs JOIN property AS ppt JOIN users AS u
                ON vs.PK_property_id=ppt.property_id AND vs.PK_client_id=u.user_id
                WHERE PK_client_id=?");
            $stmt->bindParam(1, $userId);
            $stmt->execute();
            $visitNumber=1;
            foreach ($stmt as $row) {
                $propertyId=$row["property_id"];
                $visitDate=$row["date_time"];
                $day= date("d", strtotime($visitDate));
                $month= date("M", strtotime($visitDate));
                $year= date("Y", strtotime($visitDate));
                $hour= date("h", strtotime($visitDate));
                $minute= date("i", strtotime($visitDate));
                $visitId=$row["id_visit"];

                echo"
                    <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
                    <script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js'></script>
                    
                    <div class='row'>
                        <div class='col col-11'>
                            <h4><b>Visita nº ".$visitNumber."</b></h4>
                        </div>
                        <div class='col col-1'>
                            <form method='post' action='../../php/removeVisit.php'>
                                <input type='hidden' name='visitId' value='".$row["id_visit"]."'>
                                <button type='submit' name='removeVisitBooked' class='backend'><i class='fa fa-remove'></i></button>
                            </form>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col col-4'>
                            <img style='width:100%;' src='../".$row["photo_path"]."'>
                        </div>
                        <div class='col col-8'>
                            <div class='row user'>
                                <div class='col col-5'>
                                    <h5><b>Propriedade:</b></h5>
                                </div>
                                <div class='col col-7'>
                                    <h5>".$row["property_name"]."</h5>
                                </div>
                            </div>
                            <div class='row user'>
                                <div class='col col-5'>
                                    <h5><b>Morada:</b></h5>
                                </div>
                                <div class='col col-7'>
                                    <h5>".$row["address"]."</h5>
                                </div>
                            </div>
                            <div class='row user'>
                                <div class='col col-5'>
                                    <h5><b>Data e Hora:</b></h5>
                                </div>
                                <div class='col col-7'>
                                    <h5>".$day." de ".$month." de ".$year." às ".$hour."H".$minute."</h5>
                                </div>
                            </div>
                            <div class='row user'>
                                <div class='col col-5'>
                                    <h5><b>Observações:</b></h5>
                                </div>
                                <div class='col col-7'>
                                    <h5>".$row["client_observations"]."</h5>
                                </div>
                            </div>

                            <div class='row user'>
                                <div class='col col-5'>
                                    <h5><b>Observações do gestor:</b></h5>
                                </div>
                                <div class='col col-7'>
                                    <h5>".$row["manager_observations"]."</h5>
                                </div>
                            </div>
                        </div>
                        <hr>
                    </div>
                    
                ";
                $visitNumber+=1;
            }
        }


        public function getVisitRequestUser($userId) {
            $stmt = $this->conn->prepare("SELECT * FROM visit_request AS vs JOIN property AS ppt JOIN users AS u
                ON vs.PK_property_id=ppt.property_id AND vs.PK_client_id=u.user_id
                WHERE PK_client_id=?");
            $stmt->bindParam(1, $userId);
            $stmt->execute();
            $visitNumber=1;
            foreach ($stmt as $row) {
                $idVisit=$row["id_visit_request"];
                $propertyId=$row["property_id"];
                $visitDate=$row["date_time"];
                $day= date("d", strtotime($visitDate));
                $month= date("M", strtotime($visitDate));
                $year= date("Y", strtotime($visitDate));
                $hour= date("h", strtotime($visitDate));
                $minute= date("i", strtotime($visitDate));

                echo"
                    <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
                    <script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js'></script>
                    
                    <div class='row'>
                        <div class='col col-11'>
                            <h4><b>Visita nº ".$visitNumber."</b></h4>
                        </div>
                        <div class='col col-1'>
                            <form method='post' action='../../php/removeVisit.php'>
                                <input type='hidden' name='visitId' value='".$idVisit."'>
                                <button type='submit' name='removeVisitRequest' class='backend'><i class='fa fa-remove'></i></button>
                            </form>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col col-4'>
                            <img style='width:100%;' src='../".$row["photo_path"]."'>
                        </div>
                        <div class='col col-8'>
                            <div class='row user'>
                                <div class='col col-5'>
                                    <h5><b>Propriedade:</b></h5>
                                </div>
                                <div class='col col-7'>
                                    <h5>".$row["property_name"]."</h5>
                                </div>
                            </div>
                            <div class='row user'>
                                <div class='col col-5'>
                                    <h5><b>Morada:</b></h5>
                                </div>
                                <div class='col col-7'>
                                    <h5>".$row["address"]."</h5>
                                </div>
                            </div>
                            <div class='row user'>
                                <div class='col col-5'>
                                    <h5><b>Data e Hora:</b></h5>
                                </div>
                                <div class='col col-6'>
                                    <h5>".$day." de ".$month." de ".$year." às ".$hour."H".$minute."</h5>
                                </div>
                                <div class='col col-1'>
                                    <button type='button' data-toggle='modal' data-target='#myModalUpdateDateTime-".$idVisit."' class='backend'><i class='fa fa-pencil'></i></button>
                                </div>
                            </div>
                            <div class='row user'>
                                <div class='col col-5'>
                                    <h5><b>Observações:</b></h5>
                                </div>
                                <div class='col col-6'>
                                    <h5>".$row["observations"]."</h5>
                                </div>
                                <div class='col col-1'>
                                    <button type='button' data-toggle='modal' data-target='#myModalUpdateObservations-".$idVisit."' class='backend'><i class='fa fa-pencil'></i></button>
                                </div>
                            </div>
                        </div>
                        <hr>
                    </div>

                    <!-- DATE TIME MODAL -->
                    <div class='container'>
                        <div class='modal fade' id='myModalUpdateDateTime-".$idVisit."' role='dialog'>
                            <div class='modal-dialog modal-sm'>
                                <div class='modal-content'>
                                    <div class='modal-header'>
                                        <h4 class='modal-title'><b>Visita nº ".$visitNumber."</b> - ".$row["property_name"]."</h4>
                                        <div class='close' data-dismiss='modal'>&times;</div>
                                    </div>
                                    <div class='modal-body'>
                                        <form method='post' action='../../php/visit.php'>
                                            <input type='hidden' name='visitId' value='".$idVisit."'>
                                            <input type='hidden' name='propertyId' value='".$propertyId."'>
                                            <input type='hidden' name='userId' value='".$userId."'>
                                            <h5>Alterar data e hora da visita</h5>
                                            <br>
                                            ".$this->getVisitDate($idVisit)."
                                            <br><br>
                                            <button type='submit' name='updateDateTime'>Alterar</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- OBSERVATIONS MODAL -->
                    <div class='container'>
                        <div class='modal fade' id='myModalUpdateObservations-".$idVisit."' role='dialog'>
                            <div class='modal-dialog modal-sm'>
                                <div class='modal-content'>
                                    <div class='modal-header'>
                                        <h4 class='modal-title'><b>Visita nº ".$visitNumber."</b> - ".$row["property_name"]."</h4>
                                        <div class='close' data-dismiss='modal'>&times;</div>
                                    </div>
                                    <div class='modal-body'>
                                        <form method='post' action='../../php/visit.php'>
                                            <input type='hidden' name='visitId' value='".$idVisit."'>
                                            <input type='hidden' name='propertyId' value='".$propertyId."'>
                                            <input type='hidden' name='userId' value='".$userId."'>
                                            <h5>Alterar observações</h5>
                                            <br>
                                            ".$this->getObservations($idVisit)."
                                            <br><br>
                                            <button type='submit' name='updateObservations'>Alterar</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                ";
                $visitNumber+=1;
            }
        }

        public function getVisitManager($userId) {
            $stmt = $this->conn->prepare("SELECT * FROM visit AS vs JOIN property AS ppt ON vs.PK_property_id=ppt.property_id  WHERE PK_client_id=?");
            $stmt->bindParam(1, $userId);
            $stmt->execute();
            $visitNumber=1;
            $arr=array();
            foreach ($stmt as $row) {
                $visitDate=$row["date_time"];
                $day= date("d", strtotime($visitDate));
                $month= date("M", strtotime($visitDate));
                $year= date("Y", strtotime($visitDate));
                $hour= date("h", strtotime($visitDate));
                $minute= date("i", strtotime($visitDate));
                array_push($arr, "
                    <div class='row'>
                            <div class='col col-6'>
                                <h4>Visita nº ".$visitNumber."</h4>
                            </div>
                            <div class='row user'>
                                <div class='col col-6'>
                                    <p><b>Propriedade:</b></p>
                                </div>
                                <div class='col col-6'>
                                    <p>".$row["property_name"]."</p>
                                </div>
                            </div>
                            <div class='row user'>
                                <div class='col col-6'>
                                    <p><b>Morada:</b></p>
                                </div>
                                <div class='col col-6'>
                                    <p>".$row["address"]."</p>
                                </div>
                            </div>
                            <div class='row user'>
                                <div class='col col-6'>
                                    <p><b>Data e Hora:</b></p>
                                </div>
                                <div class='col col-6'>
                                    <p>".$day." de ".$month." de ".$year." às ".$hour."H".$minute."</p>
                                </div>
                            </div>
                            <div class='row user'>
                                <div class='col col-6'>
                                    <p><b>Observações:</b></p>
                                </div>
                                <div class='col col-6'>
                                    <p>".$row["client_observations"]."</p>
                                </div>
                            </div>
                    </div>
                    <hr>
                ");
                $visitNumber+=1;
            }
            return implode("", $arr);
        }


        public function getVisitRequestsManager($userId) {
            $stmt = $this->conn->prepare("SELECT * FROM visit_request AS vs JOIN property AS ppt ON vs.PK_property_id=ppt.property_id  WHERE PK_client_id=?");
            $stmt->bindParam(1, $userId);
            $stmt->execute();
            $visitNumber=1;
            $arr=array();
            foreach ($stmt as $row) {
                $id=$row["id_visit_request"];
                $visitDate=$row["date_time"];
                $day= date("d", strtotime($visitDate));
                $month= date("M", strtotime($visitDate));
                $year= date("Y", strtotime($visitDate));
                $hour= date("h", strtotime($visitDate));
                $minute= date("i", strtotime($visitDate));
                array_push($arr, "
                    <div class='row'>
                        <div class='row'>
                            <div class='col col-10'>
                                <h4>Pedido de Visita nº ".$visitNumber."</h4>
                            </div>
                            <div class='col col-1'>
                                <form method='post' action='../../php/visit.php'>
                                    <input type='hidden' name='propertyId' value='".$row["PK_property_id"]."'>
                                    <input type='hidden' name='userId' value='".$row["PK_client_id"]."'>
                                    <input type='hidden' name='dateTime' value='".$row["date_time"]."'>
                                    <input type='hidden' name='observations' value='".$row["observations"]."'>
                                    <button type='submit' name='bookVisit' class='backend'><i class='fa fa-plus'></i></button>
                                </form>
                            </div>
                            <div class='col col-1'>
                                <button class='backend' type='button' data-toggle='modal' data-target='#myModalVisit-".$id."'><i class='fa fa-pencil'></i></button>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col col-6'>
                                <p><b>Propriedade:</b></p>
                            </div>
                            <div class='col col-6'>
                                <p>".$row["property_name"]."</p>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col col-6'>
                                <p><b>Morada:</b></p>
                            </div>
                            <div class='col col-6'>
                                <p>".$row["address"]."</p>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col col-6'>
                                <p><b>Data e Hora:</b></p>
                            </div>
                            <div class='col col-6'>
                                <p>".$day." de ".$month." de ".$year." às ".$hour."H".$minute."</p>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col col-6'>
                                <p><b>Observações:</b></p>
                            </div>
                            <div class='col col-6'>
                                <p>".$row["observations"]."</p>
                            </div>
                        </div>
                        <hr>
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
                                            <input type='hidden' name='propertyId' value='".$row["property_id"]."'>
                                            <input type='hidden' name='userId' value='".$row["PK_client_id"]."'>
                                            <input type='hidden' name='clientObservations' value='".$row["observations"]."'>
                                            <textarea id='observations' name='managerObservations' rows='4' width='100%'></textarea>
                                            <br>
                                            ".$this->getVisitRequestDate($id)."
                                            <br>
                                            <button type='submit' name='editBookVisit'>Marca Visita</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                ");
                $visitNumber+=1;
            }
            return implode("", $arr);
        }

        public function getVisitPdf($userId) {
            $stmt = $this->conn->prepare("SELECT * FROM visit AS vs JOIN property AS ppt ON vs.PK_property_id=ppt.property_id  WHERE PK_client_id=?");
            $stmt->bindParam(1, $userId);
            $stmt->execute();
            $visitNumber=1;
            $arr=array();
            foreach ($stmt as $row) {
                $date=$row["date_time"];
                $day= date("d", strtotime($date));
                $month= date("M", strtotime($date));
                $year= date("Y", strtotime($date));
                $hour= date("h", strtotime($date));
                $minute= date("i", strtotime($date));

                array_push($arr, "
                    <h4>Visita nº ".$visitNumber."</h4>
                    <table>
                        <tr><td><p><b>PROPRIEDADE:</b></p></td><td><p>".$row["property_name"]."</p></td></tr>
                        <tr><td><p><b>MORADA:</b></p></td><td><p>".$row["address"]."</p></td></tr>
                        <tr><td><p><b>DATA:</b></p></td><td><p> Dia ".$day." de ".$month." de ".$year."</p></td></tr>
                        <tr><td><p><b>HORA:</b></p></td><td><p>".$hour." Horas e ".$minute." minutos</p></td></tr>
                        <tr><td><p><b>OBSERVAÇÕES:</b></p></td><td><p>".$row["observations"]."</p></td></tr></table>
                    <hr>
                ");
                $visitNumber+=1;
            }
            return implode("", $arr);
        }

        public function getAllVisitsPdf() {
            $stmt = $this->conn->prepare("SELECT * FROM visit AS vs JOIN property AS ppt JOIN users AS u
                ON vs.PK_property_id=ppt.property_id AND ppt.PK_user_id=u.user_id
                ORDER BY date_time");
            $stmt->execute();
            $visitNumber=1;
            $arr=array();
            foreach ($stmt as $row) {
                $date=$row["date_time"];
                $day= date("d", strtotime($date));
                $month= date("M", strtotime($date));
                $m= date("m", strtotime($date));
                $year= date("Y", strtotime($date));
                $hour= date("h", strtotime($date));
                $minute= date("i", strtotime($date));

                array_push($arr, "
                    <h4>Visita nº ".$visitNumber." || ".$day."/".$m."/".$year."</h4>
                    <table>
                        <tr><td><p><b>GESTOR RESPONSÁVEL:</b></p></td><td><p><b>ID: </b>".$row["user_id"]." - ".$row["first_name"]." ".$row["last_name"]."</p></td></tr>
                        <tr><td><p><b>PROPRIEDADE:</b></p></td><td><p>".$row["property_name"]."</p></td></tr>
                        <tr><td><p><b>MORADA:</b></p></td><td><p>".$row["address"]."</p></td></tr>
                        <tr><td><p><b>DATA:</b></p></td><td><p> Dia ".$day." de ".$month." de ".$year."</p></td></tr>
                        <tr><td><p><b>HORA:</b></p></td><td><p>".$hour." Horas e ".$minute." minutos</p></td></tr>
                        <tr><td><p><b>OBSERVAÇÕES:</b></p></td><td><p>".$row["observations"]."</p></td></tr>
                        </table>
                    <hr>
                ");
                $visitNumber+=1;
            }
            return implode("", $arr);
        }

        public function getManagerVisitsPdf($id) {
            $stmt = $this->conn->prepare("SELECT * FROM visit AS vs JOIN property AS ppt JOIN users AS u
                ON vs.PK_property_id=ppt.property_id AND u.user_id=ppt.PK_user_id
                WHERE PK_user_id=?
                ORDER BY date_time");
            $stmt->bindValue(1, $id);
            $stmt->execute();
            $visitNumber=1;
            $arr=array();
            foreach ($stmt as $row) {
                $date=$row["date_time"];
                $day= date("d", strtotime($date));
                $month= date("M", strtotime($date));
                $m= date("m", strtotime($date));
                $year= date("Y", strtotime($date));
                $hour= date("h", strtotime($date));
                $minute= date("i", strtotime($date));

                array_push($arr, "
                    <h4>Visita nº ".$visitNumber." || ".$day."/".$m."/".$year."</h4>
                    <table>
                        <tr><td><p><b>PROPRIEDADE:</b></p></td><td><p>".$row["property_name"]."</p></td></tr>
                        <tr><td><p><b>MORADA:</b></p></td><td><p>".$row["address"]."</p></td></tr>
                        <tr><td><p><b>DATA:</b></p></td><td><p> Dia ".$day." de ".$month." de ".$year."</p></td></tr>
                        <tr><td><p><b>HORA:</b></p></td><td><p>".$hour." Horas e ".$minute." minutos</p></td></tr>
                        <tr><td><p><b>OBSERVAÇÕES:</b></p></td><td><p>".$row["observations"]."</p></td></tr>
                        </table>
                    <hr>
                ");
                $visitNumber+=1;
            }
            return implode("", $arr);
        }

        public function getVisitRequestsNumber($userid) {
            $stmt = $this->conn->prepare("SELECT * FROM visit_request WHERE PK_client_id=?");
            $stmt->bindValue(1, $userid);
            $stmt->execute();
            if($stmt->rowCount() <= 0){
                echo"";
            }
            else{
                return "<span class='visitRequestsNumber'>".$stmt->rowCount()."</span>";
            }
            
        }

        public function getbookedVisitNumber($userid) {
            $stmt = $this->conn->prepare("SELECT * FROM visit WHERE PK_client_id=?");
            $stmt->bindValue(1, $userid);
            $stmt->execute();
            if($stmt->rowCount() == 0){
                echo"";
            }
            else{
                return "<span class='visitRequestsNumber'>".$stmt->rowCount()."</span>";
            }
            
        }


        public function getAllVisitsByManagerByDay($userid) {
            $stmt = $this->conn->prepare("SELECT date_time, photo_path, property_name,address, DATE_FORMAT(date_time, '%Y-%m-%d') FROM visit AS vs JOIN property AS ppt
                ON vs.PK_property_id=ppt.property_id
                WHERE PK_user_id=? AND  DATE_FORMAT(date_time, '%Y-%m-%d') = ?");
            $stmt->bindValue(1, $userid);
            $stmt->bindValue(2, date('Y-m-d'));
            $stmt->execute();
            $arr=array();
            if($stmt->rowCount() <= 0){
                array_push($arr, "<h2>Não tem visitas marcadas para hoje...</h2>");
            }
            else{
                array_push($arr, "<h2>Visitas para hoje - ".date('d/m/Y')."</h2>");
                foreach ($stmt AS $row) {
                    $date=$row["date_time"];
                    $hour= date("h", strtotime($date));
                    $minute= date("i", strtotime($date));
                    array_push($arr, "
                        <div class='row'>
                            <div class='col col-4'>
                                <img class='ppty' src='../".$row["photo_path"]."'>
                            </div>
                            <div class='col col-7'>
                                <div class='col col-6'>
                                    <h3><b>HORA:</b></h3>
                                </div>
                                <div class='col col-6'>
                                    <h3>".$hour."H".$minute."</h3>
                                </div>
                                <div class='col col-6'>
                                    <b>PROPRIEDADE:</b>
                                </div>
                                <div class='col col-6'>
                                    ".$row["property_name"]."
                                </div>
                                <div class='col col-6'>
                                    <b>MORADA:</b>
                                </div>
                                <div class='col col-6'>
                                    ".$row["address"]."
                                </div>
                            </div>
                            <div class='col col-1'>
                                <button class='backend'><i class='fa fa-check'></i></button>
                            </div>
                            <hr>
                        </div>
                    ");
                }
            }
            return (implode(" ", $arr));
        }


    }
?>