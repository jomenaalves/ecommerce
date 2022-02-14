<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?= $this->section("head"); ?>
    <!-- GLOBAL CSS -->
    <link rel="stylesheet" href="<?= PATH_OF_YOUR_APP . "assets/css/global.css"?>">
    <!-- Icones do fonte awesome -->
    <script src="https://kit.fontawesome.com/77cd38f0c6.js" crossorigin="anonymous"></script>
    <!-- favicon -->
    <link rel="icon" href="https://th.bing.com/th/id/R55669b73c184da6902ca05876cae4d9e?rik=ZUFqFanYB%2fXVkw&riu=http%3a%2f%2fwww.clipartbest.com%2fcliparts%2f4ib%2fLzX%2f4ibLzXgxT.png&ehk=zbAK44hJ9x6rTL3BrYBu%2bK5rioIv50TUo1Hu3VccB%2bw%3d&risl=&pid=ImgRaw" type="image/x-icon" />
    <!-- Fonte  -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">

</head>
<body>
    <main>
        <?= $this->section("mainContent"); ?>
    </main>
    
    <?= $this->section("srcs"); ?>
</body>
</html>