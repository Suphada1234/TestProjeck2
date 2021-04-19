<?php
class University{

    public function AddUniversity($name_uni,$url_uni,$detail_uni){
        $dbhost = "localhost";
        $dbname = "education_service";
        $dbuser = "root";
        $dbpass = "";

        $conn = new mysqli($dbhost,$dbuser,$dbpass,$dbname);

        $datauni = "insert into university(name_uni,url_uni,detail_uni) values (? , ? , ?)";

        if($stmt = $conn->prepare($datauni)){
            if($stmt->bind_param("sss",$name_uni,$url_uni,$detail_uni)){
                if($stmt->execute()){
                    $stmt->close();
                    $conn->close();
                }
            }
        }

    }
}