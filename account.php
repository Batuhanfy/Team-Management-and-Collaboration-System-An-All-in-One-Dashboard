<!DOCTYPE html>
<?php session_start();
session_regenerate_id(true);
require 'database.php';


$username = "{username}";
$gorev = "{yetki}";
$mail = "{mail}";
$telefon = "{telefon}";
$yetki = "{yetki}";

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    $username = $_SESSION['username'];
} else {
    header("Location: login.php");
    die();
}




try {

    $sql = "SELECT * FROM users WHERE username = :username";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
    $stmt->execute();

    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);


    foreach ($rows as $row) {
        if (isset($row['gorev']) && $row['gorev'] !== false) {
            $gorev = $row['gorev'];
        } else {
        }

        if (isset($row['email']) && $row['email'] !== false) {
            $mail = $row['email'];
        } else {
        }

        if (isset($row['telefon']) && $row['telefon'] !== false) {
            $telefon = $row['telefon'];
        } else {
        }

        if (isset($row['yetki']) && $row['yetki'] !== false) {
            $yetki = $row['yetki'];
        } else {
        }
    }
} catch (PDOException $e) {
}

if ($username == "admin")
    $gorev = "Sistem Yöneticisi";

?>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">
    <link href="main.css" rel="stylesheet">


</head>


<body>

    <div class="headings fade-in-down-4">
        <div class="logo"><img src="images/openmytask.png" onClick="window.location.href='dashboard.php'"></div>
        <div class="account">
            <span class="account_dev"><img src="openmytask/user.svg" alt="Notlarım"></span>
            <span class="account_dev" id="hesabim"> <span class="name"><?php echo $username; ?></span> <span class="auth"><?php echo $gorev; ?> </span> </span>
            <div class="details">
                <a href="account.php"><span class="inlinebutton mavi">Hesabım</span></a>
                <a href="logout.php"> <span class="inlinebutton darkblue">Çıkış Yap</span></a>
            </div>
        </div>
    </div>

    <div class="account-edit-tab fade-in-down-4">
        <div class="account-edit-menu" id="account-edit">

            <div class="container text-center">
                <div class="row">
                    <div class="col">
                        <span class="baslik"><img src="openmytask/user-card.svg" alt="Kullanıcı Adı"> Kullanıcı Adınız:</span>
                        <span class="text"><?php echo $username; ?></span>

                    </div>
                    <div class="col">
                        <span class="baslik"><img src="openmytask/mail.svg" alt="Mail Adresi"> Mail Adresiniz:</span>
                        <span class="text"> <?php echo $mail; ?></span>

                    </div>
                    <div class="col">
                        <span class="baslik"><img src="openmytask/telephone.svg" alt="Telefon">Telefon Numaranız:</span>
                        <span class="text"> <?php echo $telefon; ?></span>
                    </div>
                </div>

                <div class="row" style="margin-top:50px;">
                    <div class="col">
                        -

                    </div>
                    <div class="col">
                        <span class="baslik"><img src="openmytask/permission.svg" alt="Telefon"></span>
                        <span class="text"> <?php echo $gorev; ?></span>
                    </div>
                    <div class="col">
                        -
                    </div>

                </div>
                <div class="row" style="margin-top:50px;">
                    <div class="col">


                    </div>
                    <div class="col">

                    </div>
                    <div class="col">

                    </div>

                </div>
            </div>
        </div>
</body>

</html>