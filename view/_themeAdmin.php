<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?= $this->section("head"); ?>
    <!-- GLOBAL CSS -->
    <link rel="stylesheet" href="<?= PATH_OF_YOUR_APP . "assets/css/global.css"?>">
    <link rel="stylesheet" href="<?= PATH_OF_YOUR_APP . "assets/css/adminTheme.css" ?>">
    <!-- favicon -->
    <link rel="icon" href="https://th.bing.com/th/id/R55669b73c184da6902ca05876cae4d9e?rik=ZUFqFanYB%2fXVkw&riu=http%3a%2f%2fwww.clipartbest.com%2fcliparts%2f4ib%2fLzX%2f4ibLzXgxT.png&ehk=zbAK44hJ9x6rTL3BrYBu%2bK5rioIv50TUo1Hu3VccB%2bw%3d&risl=&pid=ImgRaw" type="image/x-icon" />
    <!-- Fonte  -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">

</head>
<body>
    <section class="container">
      <p class="title">Aréa Administrativa</p>
      <div class="content">
        <header>
          <ul>
            <a href="<?= PATH_OF_YOUR_APP . "area-administrativa" ?>">
              <li>Produtos</li>
            </a>
            <a href="<?= PATH_OF_YOUR_APP . "area-administrativa/cadastro" ?>">
              <li>Cadastro de produtos</li>
            </a>
            <a href="<?= PATH_OF_YOUR_APP . "area-administrativa/editar-ou-remover" ?>">
              <li>Edição / exclusão  de produtos</li>
            </a>
          </ul>
        </header>
        <main>
            <?= $this->section("mainContent"); ?>
        </main>
      </div>
    </section>
    
    <?= $this->section("srcs"); ?>
</body>
</html>