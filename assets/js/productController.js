class productController{
  constructor(){
    this.cepDestino = 32044455;
    this.btnSetCep = document.querySelector('#setCep');
    this.removeCep = document.querySelector('#removeCep');

    this.btnBuy = document.querySelectorAll('.buy');
    this.modalPayments = document.querySelector('.modalpayment');
    this.paymentsMethod = document.querySelectorAll('input[type="radio"]');
    this.buyWithCreditCard = document.querySelector('#buyWithCreditCard');
    this.buyWithBoleto = document.querySelector('#buyWithBoleto');
    this.paymentMethod = "";
    // sessão pagseguro
    this.sessionID = "";
    // hash pagseguro
    this.hash = "";
    this.token = "";
    this.initEvents();

  }


  async initEvents(){

    this.paymentsMethod.forEach((element) => {
      element.addEventListener('change', async () => {

        const allDiv = document.querySelectorAll(`[data-method]`);
        allDiv.forEach((element) => {
          element.style.display = "none";
        });

        this.paymentMethod = element.id;
        const reference = document.querySelector(`[data-method="${this.paymentMethod}"]`);

        reference.style.display = "flex";
      });
    })


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
          this.modalPayments.style.display = "flex";
          this.modalPayments.setAttribute('data-item', element.dataset.id);
        })
      });
    }

    this.modalPayments.addEventListener('click', (e) => {
      if(e.target.id == "closeModal"){
        this.modalPayments.style.display = "none";
      }
    })

    this.buyWithCreditCard.addEventListener('click', async () => {
      document.querySelector('.message').innerHTML = "Carregando...";
      this.makePaymentWithCreditCard(this.modalPayments.dataset.item);
    });

    this.buyWithBoleto.addEventListener('click', () => {
      document.querySelector('.messageBoleto').innerHTML = "Carregando...";
      this.makePaymentWithBoleto(this.modalPayments.dataset.item);
    })



  }

  createSession() {

  }
  async makePaymentWithCreditCard(idProduct){

    const URL = "api/getSessionPayment";
    const request = await fetch(URL);
    const {id} = await request.json();
    
    PagSeguroDirectPayment.setSessionId(id);

  
    // static data
    const CREDIT_CARD_INFO = {
      'cardNumber' :'4111111111111111',
      'brand' : 'visa',
      'cvv' : '123',
      'expirationMonth' : '12',
      'expirationYear' : 2030
    };

    PagSeguroDirectPayment.createCardToken({
      cardNumber: CREDIT_CARD_INFO.cardNumber, 
      brand: CREDIT_CARD_INFO.brand, 
      cvv: CREDIT_CARD_INFO.cvv, 
      expirationMonth: CREDIT_CARD_INFO.expirationMonth,
      expirationYear: CREDIT_CARD_INFO.expirationYear, 
      success: function({card}) {
        const token = card.token;
        // // realizar pagamento
        PagSeguroDirectPayment.onSenderHashReady(function({senderHash, status, message}){
          if(status == 'error') {
              console.log(message);
              return false;
          }
    
          var hash = senderHash;
          const formData = new FormData();

          formData.append('token', token);
          formData.append('hash', hash);
          formData.append('id', idProduct);

          const URL =  "api/makePaymentWithCreditCard";
          fetch(URL, {method : 'POST', body: formData})
            .then((response) => response.json())
            .then((response) => {
              if(!response.error){
                document.querySelector('.message').innerHTML = `
                  Transação Efetuada com sucesso!
                `;
                return;
              }
              if(response.error){
                document.querySelector('.message').innerHTML = `
                  Informe um CEP! 
                `;
                return;
              }
              alert('Erro interno');
            })
        });

      },
      error: function(response) {
        console.log(response);
      },
    });
  }
  
  async makePaymentWithBoleto(idProduct){
    const URL = "api/getSessionPayment";
    const request = await fetch(URL);
    const {id} = await request.json();
    
    PagSeguroDirectPayment.setSessionId(id);

    PagSeguroDirectPayment.onSenderHashReady(function({senderHash, status, message}){
      if(status == 'error') {
          console.log(message);
          return false;
      }

      var hash = senderHash;

      const formData = new FormData();
      formData.append('hash', hash);
      formData.append('id', idProduct);

      const URL =  "api/makePaymentWithBoleto";
      fetch(URL, {method : 'POST', body: formData})
        .then((response) => response.json())
        .then(({error, link}) => {
          if(!error){
            document.querySelector('.messageBoleto').innerHTML = `
              Transação Efetuada com sucesso!
              <a target="blank" href="${link['0']}">Imprimir boleto</a>
            `;
            return;
          }
          if(error){
            document.querySelector('.messageBoleto').innerHTML = `
              Informe um CEP! 
            `;
            return;
          }
          alert('Erro interno');
        })
    });
  }
  
}

new productController();