  setInterval(function() {
    // Use AJAX to fetch new content and update the div
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("myTable").innerHTML = this.responseText;
      }
    };
    xhttp.open("GET", "getSuppCourses.php", true);
    xhttp.send();
  }, 2000); // 5 seconds in milliseconds
 
