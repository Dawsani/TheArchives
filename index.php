<?php
include 'db_connection.php'
?>

<html>

<head>
</head>

<body>
<header>
  <h1>The Archives</h1>
  <button onclick="window.location.href = 'clip_submission_form.php'">Upload Clip</button>
  <button onclick="window.location.href = 'clip_search.php'">Search Clips</button>
</header>

<?php

// Display all clips
$sql = "SELECT clip.id as cid, title, post_date, name FROM clip JOIN game ON clip.game_id = game.id ORDER BY post_date DESC LIMIT 20;";
$result = $mysqli->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    echo "<b>" . $row["title"] . "</b> " . $row["name"] . " " . $row["post_date"] . "<br>
          <video width='640px' height='360px' controls='controls' volume='0.5' id='" . $row["cid"] . "'>
          <source src='clips/" . $row["title"] . ".mp4' type='video/mp4' />
          </video> <br>
          <button onclick=\"window.location.href = 'edit_clip_data.php?clip_id=" . $row['cid'] . "';\">Add tag</button>
          <button onclick=\"window.location.href = 'share_clip.php?clip_id=" . $row['cid'] . "'\">Share</button><br><br>";
    
  }
}
else {
  echo "0 results";
}
$mysqli->close();

?>

</body>

</html>