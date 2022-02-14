class updateController {
  constructor() {

    this.form = document.querySelector('#formModal');
    this.message = document.querySelector('.message');  
    this.modal = document.querySelector('.modalEdit');

    this.btnEdit = document.querySelectorAll('#editar');
    this.btnRemove = document.querySelectorAll('#remove');
    this.initEvents();
  }


  initEvents() {

    this.btnRemove.forEach((element) => {
      element.addEventListener('click', async (e) => {
        const id = element.dataset.id;

        const URL = `/Ecommerce/api/delProduct/${id}`;
        const request = await fetch(URL, {method: 'DELETE'});
        const response = await request.json();

        if(response){
          location.reload();
        }
      })
    })
    this.btnEdit.forEach((element) => {
      element.addEventListener('click', (e) => {
        const id = element.dataset.id;
        const nome = document.querySelector(`#nomeProduct[data-id="${id}"]`);
        const valor = document.querySelector(`#valorProduct[data-id="${id}"]`);

        this.form.nome.value = nome.value;
        this.form.valor.value = valor.value;

        this.form.setAttribute('data-id', id);
        this.modal.style.display = "flex";
      })
    })
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
        console.log('oi');
  

        formData.append('nome', nome);
        formData.append('valor', valor);
        formData.append('id', this.form.dataset.id)
        const URL = "/Ecommerce/api/upProduct";

        const request = await fetch(URL, {method: 'POST', body: formData});
        const response = await request.json();

        if(response){
          this.message.innerHTML = `<div class="success">Produto editado com sucesso</div>`
          return;
        }

        alert('Insira um valor diferente')
        return;
      }

      alert('Preencha todos os campos')
    });
    this.modal.addEventListener('click', (e) => {
      if(e.target.id == "closeModal"){
        document.location.reload();
      }
    })
  }

  Format(valor) {
    const v = ((valor.replace(/\D/g, '') / 100).toFixed(2) + '').split('.');

    const m = v[0].split('').reverse().join('').match(/.{1,3}/g);

    for (let i = 0; i < m.length; i++)
      m[i] = m[i].split('').reverse().join('') + '.';

    const r = m.reverse().join('');

    return r.substring(0, r.lastIndexOf('.')) + '.' + v[1];
  }


  mountModal(){

  }
}

new updateController();