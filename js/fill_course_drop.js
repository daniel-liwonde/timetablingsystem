          
      function getCourses(course)
      {
       // var cname=getCourseName(course);
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById('courses').innerHTML=this.responseText;
      }
    };
    xhttp.open("GET", "findCourses.php?code="+course, true);
    xhttp.send();
  }
