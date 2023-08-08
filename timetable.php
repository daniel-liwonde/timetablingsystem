<?php
require('session.php');
require('header.php');
require('connect.php');
require('functions.php');
require('ttFunctions.php');
$year = date('Y');
$sem = checksem();
?>

<body onLoad="StartTimers(jjj);" onmousemove="ResetTimers(lll);">
    <div class="row-fluid">
        <div class="span12">
            <?php include('navbar.php'); ?>
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
                        <?php //require_once "ttMenu.php"; ?>
                    </div>
-->
                    <div class="span12" style="border:1px; width:107%; margin-top:20px">
                        <!--slider-->

                        <?php require_once('ttopMenu.php') ?>

                        <div class="hero-unit-3" style="margin-top:10px">

                            <div class="alert alert-info">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <strong><i class="icon-calendar icon-large"></i>&nbsp; Create a Teaching
                                    timetable</strong>
                            </div>

                            <br>

                            &nbsp;<a id="tGen" class="btn btn-outline rounded" href="#"><i class="fas fa-gear mod"></i>
                                &nbsp; Generate time table</a>
                            &nbsp; &nbsp;<a class="btn btn-outline rounded" href="ttEport.php"><i
                                    class="fas fa-file-export mod"></i> &nbsp;Export to Exel File
                            </a>&nbsp; &nbsp;

                            <a id="clearData" class="btn btn-outline rounded"
                                onclick="return confirm('This action will clear all timetable preferences and  data. Do you want to continue?')"
                                href="#"> <i class="fas fa-undo mod"></i> &nbsp;Reset data</a>&nbsp;&nbsp;
                            <a class="btn btn-outline rounded" href="ttconfig.php"> <i class="fas fa-gear mod"></i>
                                &nbsp;settings</a>
                            <br>
                            <br>
                            <div id="message" style="height:10px; display:none">
                            </div>

                            <script>
                                $(document).ready(function () {
                                    $("#clearData").click(function () {
                                        $("#message").css("padding-bottom", "20px");
                                        $("#message").css("display", "inline");

                                        $("#message").html("<i class='fa-solid  fa-spinner fa-spin fa-lg mod'></i>&nbsp;Reseting data...");
                                        $.getJSON("ttReset.php",
                                            function (data) {
                                                $("#message").html(data.res);
                                                setTimeout(function () {
                                                    $("#message").css("display", "none");
                                                }, 6000);

                                            });
                                    });
                                });
                                $(document).ready(function () {
                                    $("#tGen").click(function () {
                                        $("#message").css("display", "inline");
                                        $("#message").css("padding-bottom", "20px");
                                        $("#message").html("<i class='fa-solid fa-gear fa-spin fa-lg mod'></i>&nbsp;Generating timetable...");
                                        $.ajax({
                                            url: 'time.php',
                                            method: 'POST',
                                            success: function (response) {
                                                // Handle the response here
                                                $("#message").html(response);
                                            },
                                            error: function (jqXHR, textStatus, errorThrown) {
                                                $("#message").html("Request failed: " + textStatus + ", " + errorThrown);
                                            }
                                        });
                                    });
                                });

                                $(document).ready(function () {//start document ready
                                    // $("#ttView").click(function () {//start button click
                                    setInterval(function () {
                                        $.ajax({ //ajax start
                                            url: 'ttDisplayTeaching.php',
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


                    </div><!-- span12 main-->


                </div>

                <?php include('footer.php'); ?>
            </div>

        </div>
    </div>
</body>

</html>