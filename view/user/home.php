<?php $this->layout('../_theme'); ?>

<?php $this->unshift('head') ?>
    <title> <?= $this->e($title) ?> </title>
    <link rel="stylesheet" href="<?= PATH_OF_YOUR_APP . "/assets/css/home.css" ?>">
<?php $this->end() ?>


<?php $this->unshift('mainContent');?>

    <header>
        <?php if(!isset($_SESSION['cep'])):?>
            <div class="setCep">
                <button id="setCep">Informe seu cep para o calculo do frete</button>
            </div>
        <?php else:?>
            <div class="cep">
                <p>Cep: <?= $_SESSION['cep'] ?></p>
                <p>Preço de frete: R$ <?= $_SESSION['valorFrete'] ?></p>
            </div>
        <?php endif; ?>

        <?php if(isset($_SESSION['cep'])):?>
            <div class="setCep">
                <button id="removeCep">Remover cep</button>
            </div>
        <?php endif; ?>
    </header>

    <section class="buyProducts">
        <?php if($products == []):?>
            não tem produtos
        <?php else:?>
            <div class="products">
                <?php foreach($products as $product):?>
                    <div class="product">
                        <p>Nome: <?= $product['nome'];?></p>
                        <p>Valor: R$<?= $product['valor'] ?></p>
                        <button 
                            class="buy" 
                            data-id="<?= $product['id']?>"
                            data-addressServer ="<?= PATH_OF_YOUR_APP ?>"
                        >Comprar</button>
                    </div>
                <?php endforeach;?>
            </div>
        <?php endif;?>
    </section>
    <div class="modalpayment" id="closeModal">
        <div class="contentModalPayment">
            <div class="selectPayment">
                <div>
                    <p>Escolha a forma de pagamento</p>
                </div>
                <div class="radio">
                    <div>
                        <label for="credit_card">Cartão de credito</label>
                        <input type="radio" name="checkbox" id="credit_card">
                    </div>
                    <div>
                        <label for="boleto">Boleto</label>
                        <input type="radio" name="checkbox" id="boleto">
                    </div>
                </div>
            </div>

            <div class="credit_card" data-method="credit_card">
                <p class="message"></p><br>
                <button id="buyWithCreditCard">Comprar</button>
            </div>
            
            <div class="boleto" data-method="boleto">
                <div class="messageBoleto"></div>
                <button id="buyWithBoleto">Comprar</button>
            </div>
        </div>
    </div>
<?php $this->end() ?>
<?php $this->unshift('srcs');?>
    <script type="text/javascript" src="https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js"></script>
    <script src="<?= PATH_OF_YOUR_APP . "assets/js/productController.js"?>"></script>
<?php $this->end() ?>
