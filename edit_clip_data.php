<?php
include 'db_connection.php'
?>

<html>
<head>

</head>
<body>

<header>
    <h1>Add Tag</h1>
    <button onclick="window.location.href = 'index.php'">Home</button>
</header>

<?php
    // Display video clip
    if (isset($_GET['clip_id'])) {
        $clip_id = $_GET['clip_id'];

        // Fetch the video information based on the $clipId (You might need a database query here)
        $sql = "SELECT clip.title FROM clip WHERE clip.id = $clip_id;";
        $result = $mysqli->query($sql);
        
        if ($result === TRUE) {
            #echo "Search succeeded. <br>";
        }
        else {
            #echo "Error: " . $sql . "<br>" . $mysqli->error . "<br>";
        }

        // Display all searched clips
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                // Display the video
            echo "<video width='640px' height='360px' controls='controls'>
                <source src='clips/" . $row['title'] . ".mp4' type='video/mp4' />
                </video>";
            }
        } 
        else {
            echo "No results";
        }

        
    } else {
        echo "Clip ID not provided.";
    }
?>

<form action = "add_tag.php" method="post">
    <b>Create New Tag</b><br>
    <input type="hidden" name = "clip_id" value="<?php echo $clip_id ?>">
    <input type="text" name="new_tag_name" placeholder="new tag name"><br>
    <button>Create New Tag</button>
</form>

<form action = "submit_edited_clip_data.php" method="POST">
    <b>Select tags to apply</b><br>
    <input type="hidden" name = "clip_id" value="<?php echo $clip_id ?>">
    <?php
    // Display all tags
        $sql = "SELECT * FROM tag WHERE tag.id NOT IN (SELECT tag.id FROM tag JOIN clip_tag ON tag.id = tag_id WHERE clip_id = $clip_id);";
        $result = $mysqli->query($sql);
        if ($result->num_rows > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<input type="checkbox" name="selected_tags[]" value="' . $row['id'] . '"><label for="' . $row['id'] . '">' . $row['name'] . '<br></label>';
            }
            echo '<button type="submit" name="submit">Submit Changes</button>';
        }
        else {
            echo "All tags already added to this clip!<br>";
        }
        $mysqli->close();
    ?>

    
</form>

</body>
</html>