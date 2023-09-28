<?php
    // Connect to mySQL
    include 'db_connection.php';

    // Get uploaded file
    $target_dir = "clips/";
    $file_name = $_FILES["file_to_upload"]["name"];
    echo "Filename: " . $file_name . "<br>";
    $clip_title = str_replace(".mp4", "", $file_name);
    $target_file = $target_dir . basename($file_name);
    $upload_ok = 1;
    $image_file_type = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    // Check if file is of correct type
    if ($image_file_type == "mp4") {
        echo "File is a video. <br>";
        $upload_ok = 1;
    }
    else {
        echo "File is not a video. <br>";
        $upload_ok = 0;
        #header("Location: ../?upload=not_a_video_file");
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists. <br>";
        $upload_ok = 0;
        #header("Location: ../?upload=file_" . $target_file . "_already_exists");
    }

    // if everything is ok, try to upload file
    else {
        if (move_uploaded_file($_FILES["file_to_upload"]["tmp_name"], $target_file)) {
            echo "The file ". htmlspecialchars( basename( $_FILES["file_to_upload"]["name"])). " has been uploaded. <br>";
        }
        else {
            echo "Sorry, there was an error uploading your file.<br>";
            $upload_ok = 0;
            #header("Location: ../?upload=error_uploading");
        }
    }

    if ($upload_ok == 1) {
        // Get clip info
        $post_date = $_POST["date"];
        if ($post_date == '') {
            $post_date = 'NULL';
        }
        else {
            $post_date = "(DATE '" . $post_date . "')";
        }
        echo "post date: " . $post_date . "<br>";

        $game_id = $_POST['selected_game_id'];
        if ($game_id == '') {
            $game_id = 'NULL';
        }
        echo "game id: " . $game_id . "<br>";

        $original_poster_id = $_POST['original_poster_id'];
        if ($original_poster_id == '') {
            $original_poster_id = 'NULL';
        }
        echo "OP: " . $original_poster_id . "<br>";
        
        $selected_users = $_POST['selected_users'];
        if (isset($selected_users) && is_array($selected_users)) {
            echo "users: ";
            foreach ($selected_users as $selected_user_id) {
                echo $selected_user_id . " ";
            } echo "<br>";
        }
        else {
            echo "no selected users.<br>";
        }
        
        // Add the clip into the clip table
        // TODO: an an input for OP or remove column
        $sql = "INSERT INTO clip 
                VALUES (NULL, 
                        '$clip_title', 
                        $game_id, 
                        $original_poster_id,
                        $post_date, 
                        0);";
        $result = $mysqli->query($sql);
        if ($result === TRUE) {
            echo "New clip added sucessfully. The last inserted ID is: " . $mysqli->insert_id . "<br>";
        }
        else {
            echo "Error: " . $sql . "<br>" . $mysqli->error . "<br>";
        }

        function add_clip_user_entry($mysqli, $clip_title, $user_id) {
            $sql = "INSERT INTO clip_person VALUES (
                (SELECT clip.id FROM clip WHERE clip.title LIKE '$clip_title'),
                '$user_id'
            )";
            $result = $mysqli->query($sql);
            if ($result === TRUE) {
                echo "New clip user relation added sucessfully. The last inserted ID is: " . $mysqli->insert_id . "<br>";
            }
            else {
                echo "Error: " . $sql . "<br>" . $mysqli->error . "<br>";
            }
        }

        // Add a clip_user entry for every user involved
        if (isset($selected_users) && is_array($selected_users)) {
            foreach ($selected_users as $selected_user_id) {
                add_clip_user_entry($mysqli, $clip_title, $selected_user_id);
            }
        }
        //header("Location: ../?upload=success");
    }
?>

<button onclick="window.location.href = 'index.php'">Home</button>