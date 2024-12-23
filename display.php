<?php 
$type = $_GET["type"]?? '';
?>
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
    $servername = "localhost";
    $username = "root";
    $password = "";
    $db = "quotes";

    $conn = new mysqli($servername,$username,$password,$db);
    if($conn->connect_errno)
    {
        echo "error";
    }
    else
    {
        switch($type)
        {
               case "mahabarat":
                $tablename = "mahabarat";
                $bgimg="img/bg2.jpg";
                $logoimg = "img/logoimg1.png";
                $img = "img/img1.jpg";
                break;
              case "bible":
                $tablename = "bible";
                $bgimg="img/bg3.jpg";
                $logoimg = "img/logoimg2.png";
                $img = "img/img2.jpg";
                break; 
               case "quran":
                $tablename = "quran";
                $bgimg="img/bg4.jpg";
                $logoimg = "img/logoimg3.jpg";
                $img = "img/img3.jpg";
                break;
               case "mottoes":
                $tablename = "mottoes";
                $bgimg = "img/bgimg5.jpeg";
                $logoimg = "img/logoimg4.png";
                $img = "img/img4.png";
                break;     
        }
        $sql = "SELECT COUNT(*) AS total FROM $tablename";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $totalQuotes = $row["total"];

        if(isset($_POST['nxt'])){
            $currentid = $_POST['currentid']+1;

        }elseif(isset($_POST['prev'])){
            $currentid = $_POST['currentid']-1;
        }else{
            $currentid = 1;
        }

        if($currentid<1){
            $currentid = 1;
        }elseif($currentid>$totalQuotes){
            $currentid = $totalQuotes;
        }
        $sql = "SELECT * FROM $tablename WHERE sl = $currentid";
        $result=$conn->query($sql);
        $currentquote=$result->fetch_assoc();
        $conn->close();
     }
    ?>
<section>
    <img src="<?php echo$bgimg?>" class="bgimg" alt="">
    <header>
    <div class="logo"><a href="index.html">Quote<span>Forge.</span></a></div>
        <div class="menu">
            <div class="lines" onclick="toggle();">
                <div class="line1"></div>
                <div class="line2"></div>
                <div class="line3"></div>
            </div>
            <div class="links">
                <a href="index.html">home</a>
                <a href="display.php?type=mahabarat">mahabharat</a>
                <a href="display.php?type=bible">bible</a>
                <a href="display.php?type=quran">quran</a>
                <a href="display.php?type=mottoes">mottoes</a>
                <a href="adminform.html">admin login</a>
            </div>
        </div>
    </header>
    <div class="box">
        <div class="title">
        <p><?php echo $type?></p>
        <img src="<?php echo$logoimg?>" alt="">
        </div>
        <div class="content">
            <img src="<?php echo$img?>" alt="" class="img">
            <div class="quote-box">
                <p class="quote">
                "<?php echo $currentquote['quotes']?>"</p>
                <p class="name">–
                “<?php echo $currentquote['name']?>”</p>
            </div>
        </div>
        <div class="button">
            <form action="" method="post" id="btns">
                <input type="hidden" name="type" value="<?php echo $type?>"/>
                <input type="hidden" name="currentid" value="<?php echo $currentid?>"/>
                <button type="submit" class="<?php echo($currentid==1) ? 'disabled' :'btn'?>" name="prev" <?php if($currentid == 1);?>>previous</button>
                <button onclick="copyToClipboard()" class="btn">Copy</button>
                <button type="submit" name="nxt" class="<?php echo($currentid==$totalQuotes) ? 'disabled' :'btn'?>" <?php if($currentid == $totalQuotes)?>>next</button>
            </form>
        </div>
    </div>
</section>
    <script>
        function copyToClipboard()
        {
            const quote = document.querySelector('.quote').innerHTML;
            const names = document.querySelector('.name').innerHTML;
            navigator.clipboard.writeText(quote+names).then(()=>{
                alert('Quote is copied to clipboard');
            })
        }
        const bar = document.querySelector('.lines');
        const list = document.querySelector('.links');
        function toggle()
        {
           if(list.className==="links"){
                list.className="active";
           }else{
                list.className="links";
           }
    }
    </script>
</body>
</html>