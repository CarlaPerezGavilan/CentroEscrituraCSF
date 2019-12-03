var temporalName;
var temporalTime;
var name = ["Alejandra Nissan", "Sebastián Juncos", "Rodrigo Gómez"]

document.getElementById("hola").innerHTML = localStorage.getItem("lastname");


function saveName(name){
    temporalName= name;
}

function saveTime(time){
    temporalTime= time;
}

function getName(){
    return temporalName;
}

function getTime(){
    return temporalTime;
}

function save()
{

var b = document.getElementById('name').value

document.getElementById('here').innerHTML = b;

}
function saving(){
    window.localStorage.setItem("lastname", "Smith");
  }