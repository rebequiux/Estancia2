
function validacionusuario(){
    if(document.frm1.usuario.value.length==0){
        document.getElementById("usuario").focus();
        return false;
    }
    if(document.frm1.contrasena.value.length==0){
        document.getElementById("contrasena").focus();
        return false;
    }
    frm1.submit();
}

function validacionreg(){

    document.getElementById('form-registro').addEventListener('submit', function (event) {
        const nombre = document.getElementById('registro-nombre').value;
        const apellidoP = document.getElementById('registro-apellidoP').value;
        const apellidoM = document.getElementById('registro-apellidoM').value;
        const fechaNacimiento = document.getElementById('registro-fechaNacimiento').value;
        const correo = document.getElementById('registro-correo').value;
        const usuario = document.getElementById('registro-usuario').value;
        const password = document.getElementById('registro-password').value;
        const errorMsg = document.getElementById('registro-errorMsg');

        if (!nombre || !apellidoP || !apellidoM || !fechaNacimiento || !correo || !usuario || !password) {
            errorMsg.textContent = "Todos los campos son obligatorios.";
            event.preventDefault(); 
        } else {
            errorMsg.textContent = "";
        }
    })
}

function validacionproducto(){
    if(document.frm1.nombre.value.length==0){
        document.getElementById("nombre").focus();
        return false;
    }
    if(document.frm1.precio.value.length==0){
        document.getElementById("precio").focus();
        return false;
    }
    frm1.submit();
}

function validacioncliente(){
    if(document.frm1.nombre.value.length==0){
        document.getElementById("nombre").focus();
        return false;
    }
    if(document.frm1.apellido.value.length==0){
        document.getElementById("apellido").focus();
        return false;
    }
    if(document.frm1.telefono.value.length==0){
        document.getElementById("telefono").focus();
        return false;
    }
    if(document.frm1.email.value.length==0){
        document.getElementById("email").focus();
        return false;
    }
    frm1.submit();
}
