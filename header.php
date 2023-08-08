<!DOCTYPE html>
<html lang="en">

<head>
    <title>SIMS</title>
    <link href="img/tg.png" rel="icon" type="image">
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="screen">
    <link href="css/bootstrap-responsive.css" rel="stylesheet" type="text/css" media="screen">
    <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css" media="screen">
    <link href="css/fontawesome/font/css/fontawesome.min.css" rel="stylesheet" type="text/css" media="screen">
    <link rel="stylesheet" type="text/css" href="css/DT_bootstrap.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="font6/css/all.css">
    <script src="js/form.js" type="text/javascript"></script>
    <script src="js/form2.js" type="text/javascript"></script>
    <script src="js/timeout.js" type="text/javascript"></script>
    <script src="js/jquery.js" type="text/javascript"></script>
    <script src="js/bootstrap.js" type="text/javascript"></script>
    <script type="text/javascript" charset="utf-8" language="javascript" src="js/jquery.dataTables.js"></script>
    <script type="text/javascript" charset="utf-8" language="javascript" src="js/DT_bootstrap.js"></script>
    <script type="text/javascript" charset="utf-8" language="javascript" src="js/get_sup_courses1.js"></script>
    <script type="text/javascript" charset="utf-8" language="javascript" src="js/refreshTimetable.js"></script>
    <script type="text/javascript" charset="utf-8" language="javascript" src="js/refreshTimetableSup1.js"></script>
    <script type="text/javascript" charset="utf-8" language="javascript" src="js/get_courses1.js"></script>
    <script>
        $(document).ready(function () {
            $('.examples').dataTable({

                "sPaginationType": "bootstrap",
                "oLanguage": {

                }
            });
        });
    </script>
    <?php require_once('connect.php'); ?>
</head>