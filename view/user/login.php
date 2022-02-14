<?php $this->layout('../_theme'); ?>

<?php $this->unshift('head') ?>
    <title> <?= $this->e($title) ?> </title>
    <link rel="stylesheet" href="<?= PATH_OF_YOUR_APP . "/assets/css/login.css" ?>">
<?php $this->end() ?>


<?php $this->unshift('mainContent');?>
  <section class="container-login">
    <div class="content-login">
      <div class="apresentation">
        <img src="<?= PATH_OF_YOUR_APP . "assets/images/logo.jpg"?>" alt="">
        <p>Aréa Administrativa</p>
        <span>Faça login para continuar</span>
      </div>

      <form action="" id="form">
        <div class="message"></div>
        <div class="form-control">
          <label for="email">E-mail</label>
          <input type="email" name="email" id="email" required/>
        </div>
        <div class="form-control">
          <label for="password">Senha</label>
          <input type="password" name="password" id="password" required/>
        </div>
        <button type="submit">Entrar</button>
      </form>
      <div class="loading">
        <img src="<?= PATH_OF_YOUR_APP . "assets/images/loader.gif"?>" alt="" width="25px">
      </div>
    </div>
  </section>
<?php $this->end(); ?>
<?php $this->unshift('srcs'); ?>
  <script src="<?= PATH_OF_YOUR_APP . "assets/js/LoginAdminController.js"?>"></script>
<?php $this->end();?>
