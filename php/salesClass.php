<?php
    
    require_once('databaseConnection.php');
    
    class SALES{
       
        private $conn;
        private $proertyId;
        private $saleDate;
     
        public function __construct() {
            $database = new Database();
            $db = $database->dbConnection();
            $this->conn = $db;
        }
     
        public function runQuery($sql) {
            $stmt = $this->conn->prepare($sql);
            return $stmt;
        }

        public function getSalesByManager() {
            $year= date("Y",time());
            $stmt = $this->conn->prepare("
                SELECT PK_user_id, first_name, last_name,
                sum(if(year(sale_date)=?, price, 0)) AS year,
                sum(if(month(sale_date) = 1, price, 0))  AS Jan,
                sum(if(month(sale_date) = 2, price, 0))  AS Feb,
                sum(if(month(sale_date) = 3, price, 0))  AS Mar,
                sum(if(month(sale_date) = 4, price, 0))  AS Apr,
                sum(if(month(sale_date) = 5, price, 0))  AS May,
                sum(if(month(sale_date) = 6, price, 0))  AS Jun,
                sum(if(month(sale_date) = 7, price, 0))  AS Jul,
                sum(if(month(sale_date) = 8, price, 0))  AS Aug,
                sum(if(month(sale_date) = 9, price, 0))  AS Sep,
                sum(if(month(sale_date) = 10, price, 0)) AS Oct,
                sum(if(month(sale_date) = 11, price, 0)) AS Nov,
                sum(if(month(sale_date) = 12, price, 0)) AS `Dec`
                FROM users AS u JOIN sales AS sl JOIN property AS ppt 
                ON sl.PK_Property_id=ppt.property_id AND ppt.PK_user_id=u.user_id
                WHERE PK_user_type_id=? AND Year(sale_date)=?
                GROUP BY PK_user_id;
                ");
            $stmt->bindParam(1,$year);
            $stmt->bindValue(2,2);
            $stmt->bindParam(3,$year);
            $stmt->execute();
            foreach ($stmt AS $row) {
                $userId=$row["PK_user_id"];
                echo("
                    <div class='row'>
                        <div class='col col-2'>
                            ".$row["first_name"]." ".$row["last_name"]."
                        </div>
                        <div class='col col-7'>
                            <div class='row'>
                                <div class='col col-1'>
                                    ".$row["Jan"]."
                                </div>
                                <div class='col col-1'>
                                    ".$row["Feb"]."
                                </div>
                                <div class='col col-1'>
                                    ".$row["Mar"]."
                                </div>
                                <div class='col col-1'>
                                    ".$row["Apr"]."
                                </div>
                                <div class='col col-1'>
                                    ".$row["May"]."
                                </div>
                                <div class='col col-1'>
                                    ".$row["Jun"]."
                                </div>
                                <div class='col col-1'>
                                    ".$row["Jul"]."
                                </div>
                                <div class='col col-1'>
                                    ".$row["Aug"]."
                                </div>
                                <div class='col col-1'>
                                    ".$row["Sep"]."
                                </div>
                                <div class='col col-1'>
                                    ".$row["Oct"]."
                                </div>
                                <div class='col col-1'>
                                    ".$row["Nov"]."
                                </div>
                                <div class='col col-1'>
                                    ".$row["Dec"]."
                                </div>
                            </div>
                        </div>
                        <div class='col col-1'>
                            ".$row["year"]."
                        </div>
                        <div class='col col-1'>
                        <form method='post' action='../../php/managerSales_PDF.php'>

                            <input type='hidden' name='name' value='".$row["first_name"]." ".$row["last_name"]."'>
                            <input type='hidden' name='id' value='".$userId."'>
                            <input type='hidden' name='year' value='".$row["year"]."'>
                            <input type='hidden' name='Jan' value='".$row["Jan"]."'>
                            <input type='hidden' name='Feb' value='".$row["Feb"]."'>
                            <input type='hidden' name='Mar' value='".$row["Mar"]."'>
                            <input type='hidden' name='Apr' value='".$row["Apr"]."'>
                            <input type='hidden' name='May' value='".$row["May"]."'>
                            <input type='hidden' name='Jun' value='".$row["Jun"]."'>
                            <input type='hidden' name='Jul' value='".$row["Jul"]."'>
                            <input type='hidden' name='Aug' value='".$row["Aug"]."'>
                            <input type='hidden' name='Sep' value='".$row["Sep"]."'>
                            <input type='hidden' name='Oct' value='".$row["Oct"]."'>
                            <input type='hidden' name='Nov' value='".$row["Nov"]."'>
                            <input type='hidden' name='Dec' value='".$row["Dec"]."'>
                                <button type='submit' name='getManagerPDF' class='backend'><i class='fa fa-file-pdf-o'></i></button>
                            </form>
                        </div>
                        <div class='col col-1'>
                        <form method='post' action='../../php/managerSales_CSV.php'>
                        <input type='hidden' name='name' value='".$row["first_name"]." ".$row["last_name"]."'>
                    <input type='hidden' name='id' value='".$userId."'>
                    <input type='hidden' name='year' value='".$row["year"]."'>
                    <input type='hidden' name='Jan' value='".$row["Jan"]."'>
                    <input type='hidden' name='Feb' value='".$row["Feb"]."'>
                    <input type='hidden' name='Mar' value='".$row["Mar"]."'>
                    <input type='hidden' name='Apr' value='".$row["Apr"]."'>
                    <input type='hidden' name='May' value='".$row["May"]."'>
                    <input type='hidden' name='Jun' value='".$row["Jun"]."'>
                    <input type='hidden' name='Jul' value='".$row["Jul"]."'>
                    <input type='hidden' name='Aug' value='".$row["Aug"]."'>
                    <input type='hidden' name='Sep' value='".$row["Sep"]."'>
                    <input type='hidden' name='Oct' value='".$row["Oct"]."'>
                    <input type='hidden' name='Nov' value='".$row["Nov"]."'>
                    <input type='hidden' name='Dec' value='".$row["Dec"]."'>

                                <button type='submit' name='getManagerCSV' class='backend'><i class='fa fa-file-excel-o'></i></button>
                            </form>
                        </div>
                    </div>
                ");
            }
        }
    }
?>