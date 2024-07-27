<?php
$con = mysqli_connect("localhost","root","","carmaintainance");
//Check connection (optionl)
if (mysqli_connect_errno()){
    echo "Fail to connect to MySQL". mysqli_connect_error();
}

?>