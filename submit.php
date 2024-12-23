<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php
    $servername="localhost";
    $username="root";
    $password="";
    $admindb="admin";
    $admintable="admins";
    $admin=false;
    if(isset($_POST["admform"]))
    {
    

    
    $adminname=$_POST["admname"]; 
    $admid=$_POST["admid"];
    $adminpwd=md5($_POST["admpwd"]);

    $adminconn = new mysqli($servername,$username,$password,$admindb);
    $adminselect=$adminconn->prepare("SELECT * FROM $admintable WHERE AdmiN_Id = ?");
    $adminselect->bind_param("i",$admid);
    $adminselect->execute();
    $admerslt=$adminselect->get_result();
    if($adminconn->connect_errno){
        echo"error in connection";
    }
    else{   
        if($admerslt->num_rows>0)
        {
                while($row=$admerslt->fetch_assoc())
                {
                 $stdname=$row["Name"];
                 $stdid=$row["Admin_Id"];
                 $stdpwd=$row["Password"];
                 if($stdname==$adminname&&$stdpwd==$adminpwd){
                   $admin=true;
                 }
                 else{
                   $admin=false; 
                   echo "admin crendtials is not correct";
                 }
                }$adminconn->close();
        }else{
                echo "Admin id is not available";
        }
    }
}
    if(isset($_POST["option"]))
    {
        $quotedb="quotes";
        $quotes=$_POST["quote"];
        $name=$_POST["name"];
        $quotetable=$_POST["type"];
        $option=$_POST["option"];
        $table=$_POST["type"];

        $conn = new mysqli($servername,$username,$password,$quotedb);
        if($conn->connect_errno){
            echo "error in connection";
        }else{
            if($quotes===null&&$name===null)
            {
                echo"<script>alert('input should not null');</script>";
            }
            $createtable ="CREATE TABLE IF NOT EXISTS $table(sl INT AUTO_INCREMENT PRIMARY KEY,quotes varchar(500) NOT NULL,name varchar(20) NOT NULL)";
            if($conn->query($createtable)===TRUE)
            {
                echo"";
            }else{
                echo"not created";
            }
            switch($option){
                case "Create":
                    $insert = "INSERT INTO $table (quotes,name) VALUES ('$quotes','$name')";
                    if($conn->query($insert)===TRUE)
                    {
                        echo "<script>alert('inserted');</script>";
                        $arrange = "SET @row_number=0; UPDATE $table SET sl=(@row_number:=@row_number+1) ORDER BY sl ASC";
                        if($conn->multi_query($arrange))
                        {
                            echo"";
                        }
                    }else{
                    echo "<script>alert('not inserted');</script>";
                    }
                    break;
                case "Update":
                    $update = "UPDATE $table SET quotes = '$quotes',name = '$name' WHERE quotes= '$quotes'";
                    if($conn->query($update)===TRUE)
                    {
                        echo "<script>alert('updated');</script>";
                    }else{
                    echo "<script>alert('not updated');</script>";
                    }
                    break;
                case "Delete":
                    
                    $delete = "DELETE FROM $table WHERE quotes ='$quotes'";
                    if($conn->query($delete)===TRUE)
                    {
                        echo "<script>alert('deleted');</script>";
                        $arrange = "SET @row_number=0; UPDATE $table SET sl=(@row_number:=@row_number+1) ORDER BY sl ASC";
                        if($conn->multi_query($arrange))
                        {
                            echo"";
                        }
                    }else{
                    echo "<script>alert('not deleted');</script>";
                    }
                    break;
                default:
                    echo "not an option";
                    break;    
            }
        } 
    }
    ?>
    <div class="form">
        <?php if($admin===false):?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" name="formsec">
                <div class="inpt">
                    <label for="quote">
                        Quote:
                        <textarea name="quote" id="quote"></textarea>
                    </label>
                    <label for="name">
                        Name/Verse:
                        <input type="text" name="name" id="name"/>
                    </label>
                    <label for="">
                        Type:
                        <select name="type" id="type">
                            <option value="mahabarat">Mahabarat</option>
                            <option value="bible">Bible</option>
                            <option value="quran">Quran</option>
                            <option value="mottoes">Mottoes</option>
                        </select>
                    </label>
                        <div class="btns">
                            <input type="submit" class="btn" value="Create" name="option"/>
                            <input type="submit" class="btn" value="Update" name="option"/>
                            <input type="submit" class="btn" value="Delete" name="option"/>
                        </div>
                </div>
        </form><?php endif; ?>
    </div>
</body>
</html>