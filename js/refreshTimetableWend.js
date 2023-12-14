          
      function doDeleteWend(course,cid)
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
    xhttp.open("GET", "ttDelCoursesWend.php?cid="+cid, true);
    xhttp.send();
}
  }
