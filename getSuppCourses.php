<?php
require_once("connect.php");
$sql = mysqli_query($conn, "SELECT * FROM suppcourses ORDER BY id desc") or die(mysqli_error($conn));
?>
<thead>
    <tr>
        <th>Course Name</th>
        <th>Action</th>
    </tr>
</thead>
<tbody>
    <?php
    while ($row = mysqli_fetch_assoc($sql)) {
        $course_id = $row['subject_id'];
        ?>
        <tr>
            <td>
                <?php echo $row['subject_title'] ?>
            </td>
            <td>
                <a class="btn btn-danger" href="#" onclick='$("#msgd").html("Please wait..."),$.getJSON("do.php",
                                                    {
cid:<?php echo $course_id ?> } ,
function(data){
    $("#msgd").css("display", "block");
$("#msgd").html(data.res); 
setTimeout(function () {
$("#msgd").css("display", "none");
 }, 6000);
}
);'><i class="fas fa-trash"></i></a>
            </td>
        </tr>
        <?php
    }
    ?>
</tbody>