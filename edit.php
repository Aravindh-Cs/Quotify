<?php 

$servername = "localhost";
$username = "root";
$password = "";
$db = "quotes";
$table = $_POST["type"];
$quotes = $_POST["quote"];
$name = $_POST["name"];
$type = $_POST["type"];
$edit = $_POST["edit"];



$conn = new mysqli($servername,$username,$password,$db);
$tablename = "CREATE TABLE IF NOT EXISTS $table (sl INT AUTO_INCREMENT PRIMARY KEY,quotes varchar(255) NOT NULL,name varchar(20) NOT NULL)";
if($conn->query($tablename)===TRUE)
{
     echo "table";
}else{
       echo "no table";
     }
switch($edit)
{
 case 'Create':
        $insert = "INSERT INTO $table (quotes,name) VALUES ('$quotes','$name')";
        if($conn->query($insert)===TRUE)
       {
        echo"inserted";
        }else{
         echo"error in inserting";
        }
       break;
 case 'Update':
       $update = "UPDATE $table SET quotes = '$quotes',name = '$name' WHERE quotes= '$quotes'";
       if($conn->query($update)===TRUE)
       {
         echo "update";
       }else{
        echo "error in updating";
       }
       break; 
 case 'Delete':
       $delete = "DELETE FROM $table WHERE quotes ='$quotes'";
       if($conn->query($delete)===TRUE)
       {
        echo "deleted";
       }else{
        echo "error in deleting";
       }
       echo"delete";
       break;     
}

?>