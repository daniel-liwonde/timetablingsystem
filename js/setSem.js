function setCurrentSem(sem)
      {
       // var cname=getCourseName(course);
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        alert(this.responseText);
      }
    };
    xhttp.open("GET", "currentSEM.php?sem="+sem, true);
    xhttp.send();
}
