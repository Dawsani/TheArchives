<?php
include 'db_connection.php'
?>

<html>

<head>
</head>

<body>
<header>
  <h1>Share Clip</h1>
    <button onclick="window.location.href = 'index.php'">Home</button>
</header>

<?php
    // Display video clip
    if (isset($_GET['clip_id'])) {
        $clip_id = $_GET['clip_id'];

        // Fetch the video information based on the $clipId (You might need a database query here)
        $sql = "SELECT clip.title FROM clip WHERE clip.id = $clip_id;";
        $result = $mysqli->query($sql);

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
$mysqli->close();

?>

<br>
Just copy the link to this page to share the clip.

</body>

</html>