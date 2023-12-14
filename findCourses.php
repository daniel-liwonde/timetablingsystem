<?php
include('connect.php');
$code = $_GET['code'];
$courses = mysqli_query($conn, "SELECT *  FROM subject WHERE prog='$code'") or die(mysqli_error($conn));
if (mysqli_num_rows($courses) == 0)
    echo "No courses found";
else {

    echo '<option value="00">All courses in the program</option>';
    while ($data = mysqli_fetch_assoc($courses)) {
        $subid = $data['subject_id'];
        $name = $data['subject_title'];
        ?>
        <option value="<?php echo $subid ?>">
            <?php echo $name ?>
        </option>
        <?php
    }
}


?>