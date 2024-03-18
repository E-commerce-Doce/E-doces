function usuarios(){
    var xhttp =new XMLHttpRequest();
    xhttp.open("GET","http://localhost/crud_pi_template/app/controller/UsuarioController.php?action=listJson");
    xhttp.onload = function(){
        var json = xhttp.responseText;
        alert(json);
    }
    xhttp.send();
}