class InjectMysql {
    async ajaxCall(url, data, button, successCallback, errorCallback) {
        const buttonElem = button;
        const originalText = buttonElem.textContent;

        buttonElem.textContent = "Loading...";
        buttonElem.disabled = true;

        try {
            const response = await $.ajax({
                url,
                type: 'POST',
                dataType: 'JSON',
                data: { ...data }
            });

            successCallback(response);
        } catch (error) {
            errorCallback(error);
        } finally {
            buttonElem.textContent = originalText;
            buttonElem.disabled = false;
        }
    }
    async setLogin(url, data, button, message) {
        const successCallback = (response) => {
            if (response !== 0) {
                window.location.reload();
            } else {
                Swal.fire({
                    title: 'Erro no Login',
                    text: 'Verifique o seu email ou o password!',
                    icon: 'error',
                    confirmButtonText: 'Ok'
                })
            }
        };

        const errorCallback = (error) => {
            alert(error.responseText);
        };

        await this.ajaxCall(url, data, button, successCallback, errorCallback);
    }
    async setSignUp(url, data, button) {
        const successCallback = (response) => {
            if (response !== 0) {
                Swal.fire({
                    title: 'Sign Up Concluido',
                    text: 'Seja Bem Vindo!',
                    icon: 'success',
                    confirmButtonText: 'Ok'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var url = window.location.href.split('/').slice(0, -1).join('/') + '/?confirm&email=' + document.querySelector('input[name="email"]').value;
                        window.location.href = url;
                    }
                });
            }
        };

        const errorCallback = (error) => {
            alert(error.responseText);
        };

        await this.ajaxCall(url, data, button, successCallback, errorCallback);
    }
    async getConfirmEmail(url, data, button) {
        return new Promise((resolve, reject) => {
            const successCallback = (response) => {
                resolve(response);
            };
        
            const errorCallback = (error) => {
                reject(error);
            };
        
            this.ajaxCall(url, data, button, successCallback, errorCallback);
        });
    }
    async getTimeConfirmEmail(url, data, button) {
        return new Promise((resolve, reject) => {
            const successCallback = (response) => {
                resolve(response);
            };
        
            const errorCallback = (error) => {
                reject(error);
            };
        
            this.ajaxCall(url, data, button, successCallback, errorCallback);
        });
    }
    async setConfirmEmail(url, data, button) {
        const successCallback = (response) => {
            if (response !== 0) {
                Swal.fire({
                    title: 'Email Confirmado',
                    text: 'Já Podes fazer o seu Login!',
                    icon: 'success',
                    confirmButtonText: 'Ok'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var url = window.location.href.split('/').slice(0, -1).join('/');
                        window.location.href = url;
                    }
                });
            }
        };

        const errorCallback = (error) => {
            alert(error.responseText);
        };

        await this.ajaxCall(url, data, button, successCallback, errorCallback);
    }
    async reenviarConfirmEmail(url, data, button) {
        const successCallback = (response) => {
            if (response !== 0) {
                Swal.fire({
                    title: 'Email Reenviado',
                    text: 'Verifique Novamente a sua caixa de entrada!',
                    icon: 'success',
                    confirmButtonText: 'Ok'
                }).then((result) => {
                    
                });
            }
        };

        const errorCallback = (error) => {
            alert(error.responseText);
        };

        await this.ajaxCall(url, data, button, successCallback, errorCallback);
    }
}
class Config {
    static login = 'controller/login.php';
    static sign_up = 'controller/sign_up.php';
    static getconfirmation = 'controller/getConfirmation.php';
    static setconfirmation = 'controller/setConfirmation.php';
    static getimeconfirmation = 'controller/getTimeCode.php';
    static reenviarconfirmation = 'controller/reenviarConfirmation.php';
}
const EMAIL_REGEX = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
const PASSWORD_REGEX = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{8,}$/;
class Login {
    constructor() {
        this.emailInput = document.querySelector('input[name="email"]');
        this.passwordInput = document.querySelector('input[name="password"]');
        this.injectMysql = new InjectMysql();
    }

    async login(button, message) {
        const email = this.emailInput.value.trim();
        const password = this.passwordInput.value.trim();

        // validação do campo de email

        if (!EMAIL_REGEX.test(email)) {
            $('#' + message).text('Por favor, insira um email válido.');
            return;
        }
        if (!email || !password) {
            $('#' + message).text('Por favor, insira um email e o password.');
            return;
        }

        $('#' + message).text('');

        await this.injectMysql.setLogin(Config.login, [email, password], button, message);
    }

}
class Sign_up {
    constructor() {
        this.nameInput = document.querySelector('input[name="name"]');
        this.surnameInput = document.querySelector('input[name="surname"]');
        this.emailInput = document.querySelector('input[name="email"]');
        this.passwordInput = document.querySelector('input[name="password"]');
        this.reenter_passwordInput = document.querySelector('input[name="reenter_password"]');
        this.injectMysql = new InjectMysql();
    }
    async sign_up(button, message) {
        const name = this.nameInput.value;
        const surname = this.surnameInput.value;
        const email = this.emailInput.value.trim();
        const password = this.passwordInput.value.trim();
        const reenter_password = this.reenter_passwordInput.value.trim();


        if (!EMAIL_REGEX.test(email)) {
            $('#' + message).text('Por favor, insira um email válido.');
            return;
        }

        if (!email || !password || !name || !surname || !reenter_password) {
            $('#' + message).text('Por favor, preencha os Dados acima!');
            return;
        }
        if (password === '' || !PASSWORD_REGEX.test(password)) {
            $('#' + message).text('Por favor, informe uma senha válida (mínimo de 8 caracteres, com pelo menos uma letra maiúscula, uma letra minúscula e um número)');
            return;
        }
        if (password != reenter_password) {
            $('#' + message).text('Por favor, reinsira o mesmo password!)');
            return;
        }
        $('#' + message).text('');

        await this.injectMysql.setSignUp(Config.sign_up, [name, surname, email, password], button);
    }

}
class ConfirmEmail {
    constructor() {
        const urlParams = new URLSearchParams(window.location.search);
        this.email = urlParams.get('email');
        this.codeInput = document.querySelector('input[name="code"]').value;
        this.injectMysql = new InjectMysql();
    }
    async confirm_email(button){
        try {
            const response = await this.injectMysql.getConfirmEmail(Config.getconfirmation, [this.email,this.codeInput], button);
            if(response > 0){
                const time = await this.injectMysql.getTimeConfirmEmail(Config.getimeconfirmation, [this.email,this.codeInput], button);
                
                if(time <= 0){
                    Swal.fire({
                        title: 'Código Expirou!',
                        text: 'O codigo tem duração de 1 hora, clique em Ok para enviar novamente um novo código!',
                        icon: 'error',
                        confirmButtonText: 'Ok'
                    }).then(async (result) => {
                        await this.injectMysql.reenviarConfirmEmail(Config.reenviarconfirmation, [this.email], button);
                        
                    });
                }else{
                    await this.injectMysql.setConfirmEmail(Config.setconfirmation, [this.email], button);
                }
                
            }else{
                Swal.fire({
                    title: 'O Código está errado!',
                    text: 'Verifique bem a sua caixa de entrada do seu email pelo código fornecido!',
                    icon: 'error',
                    confirmButtonText: 'Ok'
                }).then((result) => {
                    
                });
            }
        } catch (error) {
            console.log(error);
        }
    }
}


