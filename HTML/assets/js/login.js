
  var usernamesTutor = ['a', 'b', 'c'];
  var passwordsTutor = ['a', 'b', 'c'];
  var usernames = ['A', 'B', 'C'];
  var passwords = ['A', 'B', 'C'];
  var userAdmin = "Verito";
  var passAdmin = "Legarda";
  var userTemp=document.getElementById("user").value;
  var pasTemp =document.getElementById("pass").value;
  
      function loadpage() {
      for (var i = 0; i < usernamesTutor.length; i++) {
        if (document.getElementById("user").value==usernamesTutor[i] && document.getElementById("pass").value== passwordsTutor[i]) {
          window.location= "tutor.html";
          i= usernamesTutor.length+1;
        } 
      }
      for (var a = 0; a < usernames.length; a++) {
        if (document.getElementById("user").value==usernames[a] && document.getElementById("pass").value== passwords[a]) {
          window.location= "register.html";
          i= usernames.length+1;
        } 
      }
      if(document.getElementById("user").value==userAdmin && document.getElementById("pass").value== passAdmin){
          window.location= "Administrador.html";
      } else if(a==usernames.length && i==usernamesTutor.length){
          alert('Contraseña o Usuario Incorrecto')
      }
      }
  
      function register1(){
        usernames[usernames.length]=document.getElementById("user").value;
        passwords[passwords.length]=document.getElementById("pass").value;
      }