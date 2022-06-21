function TDate() {
    var debut = document.getElementById("debut").value;
    var fin = document.getElementById("fin").value;
    if (new Date(fin).getTime() <= new Date(debut).getTime()) {
        alert("Date fin doit être supérieure ou égale à Date début !");
        return false;
   }
    return true;
}