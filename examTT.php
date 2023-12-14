<?php
include('session.php');
include('header.php');
require_once('functions.php');
require_once('ttFunctions.php');
$year = date('Y');
$sem = checksem();
?>

<body>
    <div class="row-fluid">
        <div class="span12">
            <?php include 'navbar.php'; ?>
            <div class="container">

                <div class="row-fluid">
                    <!--
                    <div class="hero-unit-3" style="width:18.5%">
                        <div class="alert-index alert-success">
                            <i class="icon-calendar icon-large"></i>
                            <?php
                            $Today = date('y:m:d');
                            $new = date('l, F d, Y', strtotime($Today));
                            echo $new;
                            ?>
                        </div>
                    </div>
                    <div class="hero-unit-1" style="width:20%">
                        <?php //require_once('ttMenu.php') ?>
                    </div>
                    -->
                    <div class="span12" style="border:1px; width:107%;margin-top:20px; ">
                        <!--slider-->
                        <?php require_once('ttopMenu.php') ?>

                        <div class="hero-unit-3" style="margin-top:10px">
                            <div class="alert alert-info">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <strong><i class="icon-calendar icon-large mod"></i>&nbsp;Exam Time</strong>
                            </div>
                            <form class="form-inline">
                                Start date:<input type="date" id="start_date">
                                End Date:<input type="date" id="end_date">
                                <button id="tGen" class="btn btn-info" type="submit"><i class="fas fa-gear">
                                    </i>&nbsp;Generate</button>
                            </form>

                            <a class="btn btn-outline rounded" href="ttEportExam.php"><i
                                    class="fas fa-file-export mod"></i> &nbsp;Export
                                Timetable</a>&nbsp; &nbsp;
                            <a id="clearData" class="btn btn-outline rounded" href="#"> <i class="fas fa-undo mod"></i>
                                &nbsp;Reset data</a>&nbsp; &nbsp;
                            <a class="btn btn-outline rounded" href="examTTSettings.php?menu=3"> <i
                                    class="fas fa-gear mod"></i>
                                &nbsp;settings</a>

                            <br>
                            <div id="cs" style="margin-top:30px">

                            </div>
                            <br>
                            <div id="message">

                            </div>
                            <script>
                                $(document).ready(function () {
                                    $(" #clearData").click(function () {
                                        var conf = confirm("This action will clear your timetable data including preferences. Proceed?")
                                        if (conf) {
                                            $("#message").css("display", "inline");
                                            $("#message").html("<p> <i class='fa-solid fa-gear fa-spin fa-lg mod'></i> &nbsp;Reseting data...<p>");
                                            $.getJSON("ttResetExam.php", function (data) {
                                                $("#message").html(data.res); setTimeout(function () {
                                                    $("#message").css("display", "none");
                                                }, 3000);
                                            });
                                        }
                                    });
                                });
                                //===================
                                $(document).ready(function () {
                                    $("#tGen").click(function (e) {
                                        e.preventDefault();
                                        $("#message").css("display", "inline");
                                        $("#message").html("<p class='mod'> <i class='fa-solid fa-gear fa-spin fa-lg '></i> &nbsp;Generating....<p>");
                                        $.getJSON("timeExam.php", {
                                            start_date: $("#start_date").val(),
                                            end_date: $("#end_date").val()
                                        },
                                            function (data) {
                                                $("#message").html(data.res);

                                            });
                                    });
                                });
                                //=============
                                $(document).ready(function () {//start document ready
                                    // $("#ttView").click(function () {//start button click
                                    setInterval(function () {
                                        $.ajax({ //ajax start
                                            url: 'timeGen.php',
                                            method: 'POST',

                                            success: function (response) {
                                                $("#table").html(response);

                                            },
                                            error: function (jqXHR, textStatus, errorThrown) {//start error display
                                                setTimeout(function () {
                                                    $("#table").html("Request failed: " + textStatus + ", " + errorThrown);
                                                }, 13000
                                                )

                                            }//end error display
                                        });//ajax end
                                    }, 2000
                                    );
                                    //});//end button click
                                });//document ready

                            </script>

                            <div id="table">
                            </div>
                            <!-- end slider -->
                        </div>
                    </div>


                </div>

                <?php include('footer.php'); ?>
            </div>


        </div>

    </div>
</body>

</html>