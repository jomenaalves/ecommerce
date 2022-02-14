class productController{
  constructor(){
    this.cepDestino = 32044455;
    this.btnSetCep = document.querySelector('#setCep');
    this.removeCep = document.querySelector('#removeCep');

    this.btnBuy = document.querySelectorAll('.buy');

    this.modalPayments = document.querySelector('.modalpayment');
    this.initEvents();

  }


  async initEvents(){

    if(this.btnSetCep){
      this.btnSetCep.addEventListener('click', async () => {
        const cep = prompt("Digite seu cep sem hífen(-)");
  
        if(cep.length == 8 && !isNaN(parseInt(cep))){
          const URL = `api/calcFrete/${cep}` 
  
          const request = await fetch(URL, {method: 'POST'});
          const response = await request.json();
  
          if(response.ok){
            location.reload();
          }
          console.log(response);
          return
        }
  
        alert('insira um cep valido');
      });
    }

    if(this.removeCep){
      this.removeCep.addEventListener('click', async() => {
        const URL = "api/removeCep";
        const request = await fetch(URL);
        const response = await request.json();

        if(response){
          location.reload();
          return;
        }
        
        alert('erro');
      });
    }

    if(this.btnBuy){
      this.btnBuy.forEach((element) => {
        element.addEventListener('click', async (e) => {
          const URL = "api/getSessionPayment";
          const request = await fetch(URL);
          const {id} = await request.json();

          this.modalPayments.style.display = "flex";
          PagSeguroDirectPayment.setSessionId(id);
          PagSeguroDirectPayment.getPaymentMethods({
            amount: 500.00,
            success: function(response) {
              const creditCardFlags = document.querySelector('.flags');
              const boletoDiv = document.querySelector('.boleto');

              const optionsCreditCard = response.paymentMethods.CREDIT_CARD.options;
              const optionBoleto = response.paymentMethods.BOLETO.options;

              Object.values(optionBoleto).forEach((boleto) => {
                console.log(boleto);
                boletoDiv.innerHTML += `<img src="https://stc.pagseguro.uol.com.br${boleto.images.SMALL.path}"/>`;
              });
              console.log(optionBoleto);
              Object.values(optionsCreditCard).forEach((card) => {
                creditCardFlags.innerHTML += `<img src="https://stc.pagseguro.uol.com.br${card.images.SMALL.path}"/>`;
              });
          
            },
            error: function(response) {
                console.log(response);
            },
            complete: function(response) {
              
            }
        });
        })
      })
    }


  }

}

new productController();