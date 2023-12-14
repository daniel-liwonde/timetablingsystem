<?php
$menu = $_GET['menu'];
?>

<span>
    <a href="timetable.php?menu=1 " <?php if (isset($menu))
        if ($menu == 1)
            echo 'class="btn btn-success"';
        else
            echo 'class="btn btn-info"'; ?>> <i class="fas fa-chalkboard-teacher"></i>
        &nbsp; Teaching Timetable

    </a>&nbsp;

    <a href="lecturerTT.php?menu=2" <?php if (isset($menu))
        if ($menu == 2)
            echo 'class="btn btn-success"';
        else
            echo 'class="btn btn-info"'; ?>><i class="fas fa-user"></i>
        &nbsp; Lecturer Timetable</a>&nbsp;
    <a href="examTT.php?menu=3" <?php if (isset($menu))
        if ($menu == 3)
            echo 'class="btn btn-success"';
        else
            echo 'class="btn btn-info"'; ?>> <i class="fas fa-edit"></i>
        &nbsp; Exam Timetable</a>
    <a href="ttdept.php?menu=4" <?php if (isset($menu))
        if ($menu == 4)
            echo 'class="btn btn-success"';
        else
            echo 'class="btn btn-info"'; ?>><i class="fas fa-building"></i>
        &nbsp;Departmental timetable</a>
    <span class="btn-group">

        <button 
        <?php if (isset($menu))
            if ($menu == 5)
                echo 'class="btn btn-success"';
            else
                echo 'class="btn btn-info"'; ?>
        ><i class="fas fa-list-check"></i>&nbsp;
            Special Timetable
        </button>
        <button class="btn dropdown-toggle" data-toggle="dropdown">
            <span class="caret"></span>
        </button>
        <ul class="dropdown-menu">
            <li><a href="examTTsup.php?menu=5"><i class="fas fa-edit"></i>&nbsp;Exam Timetable for selected courses
            </li>
            <li><a href="timetable_wend.php?menu=5"><i class="fas fa-chalkboard-teacher"></i>&nbsp;Teaching Timetable for
                    weekend</a>
            </li>
        </ul>

    </span>
    <a href="ttSetings.php?menu=6" 
    <?php if (isset($menu))
        if ($menu == 6)
            echo 'class="btn btn-success"';
        else
            echo 'class="btn btn-info"'; ?>
    
    ><i class="fas fa-gear"></i>
        &nbsp; Settings</a>
</span>