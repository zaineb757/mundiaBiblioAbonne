function checkDates() {
    var debut = document.getElementById("debut").value;
    var fin = document.getElementById("fin").value;
  
    if (new Date(fin).getTime() < new Date(debut).getTime()) {
        alert("Date fin doit être supérieure ou égale à Date début !");
    }
    else if (new Date(fin).getTime() > new Date(debut).getTime()+12096e5){
        alert("Veuillez ne pas dépasser 2 semaines dans votre prêt !");
    }
}