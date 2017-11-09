function passwordChanged() {
    var forca = document.getElementById("forca");
    var passforte = new RegExp("^(?=.{8,})(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[^a-zA-Z_]).*$", "g");
    var passMedia = new RegExp("^(?=.{7,})(((?=.*[A-Z])(?=.*[a-z]))|((?=.*[A-Z])(?=.*[0-9]))|((?=.*[a-z])(?=.*[0-9]))).*$", "g");
    var passFraca = new RegExp("(?=.{6,}).*", "g");
    var pwd = document.getElementById("password");
    if (pwd.value.length==0) {
        strength.innerHTML = '';
        forca.innerHTML = '';
    } else if (false == passFraca.test(pwd.value)) {
         strength.innerHTML = '';
        forca.innerHTML = '<span style="font-size:15px">Insira, pelo menos, 6 caracteres</span>';
    } else if (passforte.test(pwd.value)) {
        strength.innerHTML = '<img src="../../images/app/strong.png" class="passwordStrenght">';
        forca.innerHTML = '<span style="font-size:15px">Password Forte!</span>';
    } else if (passMedia.test(pwd.value)) {
        strength.innerHTML = '<img src="../../images/app/medium.png" class="passwordStrenght">';
        forca.innerHTML = '<span style="font-size:15px">Password Média!</span>';
    } else {
        strength.innerHTML = '<img src="../../images/app/weak.png" class="passwordStrenght">';
        forca.innerHTML = '<span style="font-size:15px">Password Fraca!</span>';
    }

}


function validatePassword(){
    var password = document.getElementById("password");
    var passwordRepeat = document.getElementById("passwordRepeat");
    var iguais = document.getElementById("iguais");
    var simbolo = document.getElementById("simbolo");
    if (passwordRepeat.value.length==0 || password.value.length==0) {
        iguais.innerHTML = '';
        simbolo.innerHTML = '';
    }
    else if(password.value != passwordRepeat.value) {
        simbolo.innerHTML = '<img src="../../images/app/notEqual.jpg" class="passwordConfirm">';
        iguais.innerHTML = '<span style="font-size:15px">  As passwords não são iguais!</span>';
        passwordRepeat.setCustomValidity("As passwords não são iguais");
    }
    else {
        simbolo.innerHTML = '<img src="../../images/app/equal.jpg" class="passwordConfirm">';
        iguais.innerHTML = '<span style="font-size:15px">  As passwords são iguais!</span>';
        passwordRepeat.setCustomValidity('');
    }
}
password.onchange = validatePassword();
passwordRepeat.onkeyup = validatePassword();
