<?php
// ... (connection setup)

$subjectQuery = "SELECT * FROM subject";
$roomQuery = "SELECT * FROM rooms";

$subjects = $conn->query($subjectQuery);
$rooms = $conn->query($roomQuery);

if ($subjects->num_rows > 0 && $rooms->num_rows > 0) {
    // Fetch rooms into an array
    $roomsArray = [];
    while ($room = $rooms->fetch_assoc()) {
        $roomsArray[] = $room;
    }

    while ($subject = $subjects->fetch_assoc()) {
        $subjectId = $subject['subject_id'];
        $subjectTitle = $subject['subject_title'];
        $subjectStudentCount = $subject['studentcount'];

        $allocated = false;

        // Shuffle the rooms array to pick rooms at random
        shuffle($roomsArray);

        foreach ($roomsArray as &$room) {
            $roomId = $room['id'];
            $roomCapacity = $room['capacity'];

            if ($roomCapacity >= $subjectStudentCount) {
                // Allocate the subject to the room
                $allocationQuery = "INSERT INTO subject_room (room_id, subject_id) VALUES ('$roomId', '$subjectId')";
                if ($conn->query($allocationQuery) === TRUE) {
                    $allocated = true;
                    $roomCapacity -= $subjectStudentCount;
                    $room['capacity'] = $roomCapacity; // Update capacity in the array
                    break;
                }
            }
        }

        if (!$allocated) {
            // If no suitable room found, create a new allocation or perform additional logic
        }
    }
} else {
    echo "No subjects or rooms found.";
}

$conn->close();
?>