// JavaScript Document
function showUser(str) {
    if (str == "") {
        document.getElementById("txtHint").innerHTML = "";
        return;
    } else {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("example").innerHTML = xmlhttp.responseText;
            }
        };
        xmlhttp.open("GET","getuser.php?q="+str,true);
        xmlhttp.send();
    }
}
$("#btnPrint2").live("click", function () {
            var divContents = $("#dvContainer1").html();
            var printWindow = window.open('', '', 'height=500,width=1000');
            printWindow.document.write('<html><head><title></title>');
            printWindow.document.write('</head><body >');
            printWindow.document.write(divContents);
            printWindow.document.write('</body></html>');
            printWindow.document.close();
            printWindow.print();
});
        $("#btnPrint").live("click", function () {
            var divContents = $("#dvContainer").html();
            var printWindow = window.open('', '', 'height=500,width=1000');
            printWindow.document.write('<html><head><title></title>');
            printWindow.document.write('</head><body >');
            printWindow.document.write(divContents);
            printWindow.document.write('</body></html>');
            printWindow.document.close();
            printWindow.print();
        });
        function disable() {
        if (document.getElementById("y").checked) {
            document.getElementById("sel").style.visibility = "visible";
            document.getElementById("state").style.visibility = "hidden";
            document.getElementById("state2").style.visibility = "hidden";
            document.getElementById("semester").style.visibility = "visible";
        }
        else {
            document.getElementById("sel").style.visibility = "hidden";
            document.getElementById("state").style.visibility = "visible";
            document.getElementById("state2").style.visibility = "visible";
            document.getElementById("semester").style.visibility = "hidden";
        }
}
     $(document).ready(function () {
        $('.search-box input[type="text"]').on("keyup input", function () {
            /* Get input value on change */
            var inputVal = $(this).val();
            var resultDropdown = $(this).siblings(".result");
            if (inputVal.length) {
                $.get("searchs.php", { term: inputVal }).done(function (data) {
                    // Display the returned data in browser
                    resultDropdown.html(data);
                });
            } else {
                resultDropdown.empty();
            }
        });
        // Set search input value on click of result item
        $(document).on("click", ".result td", function () {
            $(this).parents(".search-box").find('input[type="text"]').val($(this).text());
            $(".result").empty();

        });
    });