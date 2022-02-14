class LoginAdminController{

  constructor(){
    this.form = document.querySelector('#form');
    this.message = document.querySelector('.message');
    this.loader = document.querySelector('.loading');
    this.initEvents();
  }

  initEvents(){
    this.form.addEventListener('submit', async (e) => {
      e.preventDefault();

      this.loader.style.display = "flex";

      const email = this.form.email.value;
      const password = this.form.password.value;
      const formData = new FormData();

      if(email.trim() !== '' && password.trim() !== ''){
        formData.append('email', email); 
        formData.append('passwd', password);

        const URL = "api/loginAdmin";
        const request = await fetch(URL, {method: 'POST', body: formData});
        const {error, message} = await request.json();

        this.loader.style.display = "none";

        if(error){
          this.message.innerHTML = `<p class="error">${message}</p>`;
          return;
        }

        document.location.href = "area-administrativa";
      }
    });
  }
}

new LoginAdminController();