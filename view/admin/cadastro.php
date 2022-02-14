<?php $this->layout('../_themeAdmin'); ?>

<?php $this->unshift('head') ?>
    <title> <?= $this->e($title) ?> </title>
    <link rel="stylesheet" href="<?= PATH_OF_YOUR_APP . "/assets/css/admin.css" ?>">
<?php $this->end() ?>


<?php $this->unshift('mainContent');?>
  <div class="cadProduct">
    <p class="title">Cadastro de produtos</p>

    <form action="" id="form">
      <div class="form-control">
        <label for="nome">Nome </label>
        <input type="text" placeholder="Nome do produto" id="nome" name="nome" required>
      </div>
      <div class="form-control">
        <label for="valor">Valor do produto</label>
        <input type="text" name="valor" id="valor" placeholder="Ex: 49.99" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
      </div>
      <button type="submit">Cadastrar</button>
    </form>

    <div class="message"></div>
  </div>
<?php $this->end() ?>
<?php $this->unshift('srcs');?>
  <script src="<?= PATH_OF_YOUR_APP . "assets/js/cadProductController.js"?>"></script>
<?php $this->end();?>