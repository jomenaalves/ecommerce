class cadProductController {
  constructor() {

    this.form = document.querySelector('#form');
    this.message = document.querySelector('.message');
    this.initEvents();
  }


  initEvents() {

    this.form.valor.addEventListener('keyup', () => {
      const value = this.form.valor.value;
      const formatNumber = this.Format(value);

      this.form.valor.value = formatNumber;
  
    })

    this.form.addEventListener('submit',async (e) => {
      e.preventDefault();

      const nome = this.form.nome.value;
      const valor = this.form.valor.value;

      if(nome.trim() !== "" && valor.trim() !== ""){
        const formData = new FormData();

        formData.append('nome', nome);
        formData.append('valor', valor);

        const URL = "/Ecommerce/api/cadProduct";

        const request = await fetch(URL, {method: 'POST', body: formData});
        const response = await request.json();

        if(!response){
          this.message.innerHTML = `<div class="error">Produto já cadastrado</div>`;
          return;
        }
        this.message.innerHTML = `<div class="success">Produto cadastrado com sucesso</div>`

      }
    });
  }

  Format(valor) {
    const v = ((valor.replace(/\D/g, '') / 100).toFixed(2) + '').split('.');

    const m = v[0].split('').reverse().join('').match(/.{1,3}/g);

    for (let i = 0; i < m.length; i++)
      m[i] = m[i].split('').reverse().join('') + '.';

    const r = m.reverse().join('');

    return r.substring(0, r.lastIndexOf('.')) + '.' + v[1];
  }
}

new cadProductController();