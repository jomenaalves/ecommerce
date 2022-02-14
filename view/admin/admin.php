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
                <p><?= $product['nome']?></p>
                <p>R$<?= $product['valor']?></p>
            </div>
        <?php endforeach;?>        
    </div>

<?php $this->end() ?>
