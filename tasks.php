<!DOCTYPE html>
<?php session_start();
session_regenerate_id(true);
require 'database.php';

$username = "{username}";
$gorev = "{yetki}";
$mail = "{mail}";
$telefon = "{telefon}";
$yetki = "{yetki}";
$use_notes_permission = 1;

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
        if (isset($row['use_notes_permission']) && $row['use_notes_permission'] !== 0) {
            $use_notes_permission = $row['use_notes_permission'];
        } else {
            header("Location: dashboard.php");
            die();
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

$sql = "SELECT task, startDate,endDate,aciklamasi,id FROM mytask WHERE username = :username order by endDate desc";

$stmt = $pdo->prepare($sql);

$stmt->bindParam(':username', $username, PDO::PARAM_STR);

$stmt->execute();

$notes = $stmt->fetchAll(PDO::FETCH_ASSOC);


if ($username == "admin")
    $gorev = "Sistem Yöneticisi";

?>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Tasks</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
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








    <div id="addNoteDiv" class="mt-3">
        <?php require('quill.php'); ?>
        <!-- <textarea id="newNote" class="form-control mb-2" placeholder="Notunuzu buraya yazın..."></textarea> -->
    </div>



    <div class="account-edit-tab-tasks fade-in-down-4">
        

   
        <?php
        $now = new DateTime();
        foreach ($notes as $note) {
            $endDate = new DateTime($note['endDate']);


        ?>

            <div class="my-notes-menu-not tasks" id="<?php print_r($note['id']); ?>" <?php if ($endDate < $now) {
                                                                                    echo 'style="border: 2px solid #eeb2ff;";';
                                                                                } ?>>

                <div class="container text-center">
                    <div class="row">
                        <div class="col">
                            <span class="text">
                                <?php
                                if ($endDate < $now) {
                                    print_r("Bu görevin tarihi geçti.");
                                }else {
                                    $interval = $now->diff($endDate); 
                                    $daysLeft = $interval->days; 
                                    print_r("Süresinin dolmasına: " . $daysLeft . " gün kaldı.<br/>");
                                    print_r($note['endDate']);

                                }
                                ?>
                            </span>
                        </div>



                        <div class="col">
                            <span class="baslik"><?php echo $note['task']; ?></span>
                        </div>
                        <div class="col">
                            <span class="text"><?php echo $note['aciklamasi']; ?></span>
                        </div>

                    </div>
                </div>

            </div>






        <?php }
        if ($notes == null) {
            print_r("<div class='no-notes'><h3> Görev girişi yok.</h3></div>");
        } ?>
    </div>
    <script>
        const myNotesDivs = document.querySelectorAll('.my-notes-menu-not');
        const deleteButton = document.getElementById('deleteNote');
        let selectedNoteId = null;
        const addNoteButton = document.getElementById('addNoteButton');
        const addNoteDiv = document.getElementById('addNoteDiv');
        const saveNoteButton = document.getElementById('saveNoteButton');


        addNoteButton.addEventListener('click', () => {
            addNoteDiv.style.display = 'flex';
        });


        myNotesDivs.forEach(div => {
            div.addEventListener('click', () => {

                myNotesDivs.forEach(d => d.classList.remove('selected_note'));


                div.classList.add('selected_note');


                console.log(div.id);


                selectedNoteId = div.id;
                deleteButton.style.display = 'flex';
            });
        });


        deleteButton.addEventListener('click', () => {
            if (selectedNoteId && confirm("Bu notu silmek istediğinize emin misiniz?")) {


                const noteToDelete = document.getElementById(selectedNoteId);
                if (noteToDelete) {

                    fetch('delete_note.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                id: selectedNoteId
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                window.location.reload();
                                const noteToDelete = document.getElementById(selectedNoteId);
                                if (noteToDelete) {
                                    noteToDelete.remove();
                                }
                                deleteButton.style.display = 'none';
                                selectedNoteId = null;
                            } else {
                                alert('Not silinirken bir hata oluştu.');
                            }
                        })
                        .catch(error => console.error('Error:', error));
                }

                deleteButton.style.display = 'none';
                selectedNoteId = null;
            }
        });


        saveNoteButton.addEventListener('click', () => {
            const newNote = document.getElementById('newNote').value;
            if (newNote.trim() !== "") {
                fetch('add_note.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            note: newNote
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {



                            window.location.reload();


                        } else {
                            alert('Not eklenirken bir hata oluştu.');
                        }
                    })
                    .catch(error => console.error('Error:', error));
            } else {
                alert('Not boş olamaz.');
            }
        });
    </script>


    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js"></script>

</body>