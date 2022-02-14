<?php $this->layout('../_themeAdmin'); ?>

<?php $this->unshift('head') ?>
    <title> <?= $this->e($title) ?> </title>
    <link rel="stylesheet" href="<?= PATH_OF_YOUR_APP . "/assets/css/admin.css" ?>">
<?php $this->end() ?>


<?php $this->unshift('mainContent');?>
    <div class="products">
        <?php if($products == []):?>
          <p class="dontHaveProducts">
            Nenhum produto cadastrado
          </p>
        <?php endif;?>
        
        <?php foreach($products as $product): ?>
            <div class="product">
                <p id="idProductClicked" data-id="<?= $product['id']?>">
                  <?= $product['nome'];?>
                </p>
                <p id="valueProductClicked" data-id="<?= $product['id']?>">
                  R$ <?= number_format($product['valor'], 2, '.', ' ');?>
                </p>

                <input type="hidden" name="nome" id="nomeProduct" value="<?=$product['nome'];?>" data-id="<?= $product['id']?>">
                <input type="hidden" name="valor" id="valorProduct" value="<?=$product['valor'];?>" data-id="<?= $product['id']?>">
                <button id="remove" data-id="<?= $product['id']?>">Remover</button>
                <button id="editar" data-id="<?= $product['id']?>">Editar</button>
            </div>
        <?php endforeach;?>        
    </div>

    <div class="modalEdit" id="closeModal">
      <div class="contentModalEdit">
          <form action="" id="formModal">
            <p class="title">Editar produto</p>
            <div class="message"></div>
            <div class="form-control">
              <label for="nome">Nome</label>
              <input type="text" name="nome" id="nome">
            </div>
            <div class="form-control">
              <label for="nome">Valor</label>
              <input type="text" name="valor" id="valor">
            </div>
            <button type="submit">
              Editar
            </button>
          </form>
      </div>
    </div>
<?php $this->end() ?>
<?php $this->unshift('srcs');?>
    <script src="<?= PATH_OF_YOUR_APP . "assets/js/updateController.js"?>"></script>
<?php $this->end();?>