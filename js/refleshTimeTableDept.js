function displayTTDept(dept)
      {
       // var cname=getCourseName(course);
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("timeTable").innerHTML=this.responseText;
      }
    };
    xhttp.open("GET", "deptTT.php?lect="+dept, true);
    xhttp.send();
}