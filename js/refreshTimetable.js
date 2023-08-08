          
      function doDelete(course,cid)
      {
       // var cname=getCourseName(course);
    var xhttp = new XMLHttpRequest();
    var conf=confirm(course +" will be removed from the timetable.Proceed?");
    if(conf)
    {
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        alert(this.responseText);
      }
    };
    xhttp.open("GET", "ttDelCourses.php?cid="+cid, true);
    xhttp.send();
}
}
  function doDeleteTeaching(course,cid)
      {
       // var cname=getCourseName(course);
    var xhttp = new XMLHttpRequest();
    var conf=confirm(course +" will be removed from the timetable.Proceed?");
    if(conf)
    {
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        alert(this.responseText);
      }
    };
    xhttp.open("GET", "ttDelCoursesTeaching.php?cid="+cid, true);
    xhttp.send();
}
  }
  function displayTT(lect)
      {
       // var cname=getCourseName(course);
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("timeTable").innerHTML=this.responseText;
      }
    };
    xhttp.open("GET", "ttLect.php?lect="+lect, true);
    xhttp.send();
}
  
