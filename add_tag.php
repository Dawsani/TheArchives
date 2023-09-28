<?php
    include 'db_connection.php';

    $clip_id = $_POST['clip_id'];
    echo "clip_id: " . $clip_id . "<br>";

    $new_tag_name = $_POST['new_tag_name'];
    echo "new_tag_name: " . $new_tag_name . "<br>";

    $sql = "INSERT INTO tag VALUES (NULL, '$new_tag_name');";
    $result = $mysqli->query($sql);
    if ($result === TRUE) {
        echo "New clip added sucessfully. The last inserted ID is: " . $mysqli->insert_id . "<br>";
    }
    else {
        echo "Error: " . $sql . "<br>" . $mysqli->error . "<br>";
    }

    header("Location: edit_clip_data.php?clip_id=" . $clip_id);
?>