<?php
include 'db_connection.php'
?>

<!DOCTYPE html>
<html>
<head>
  <style>
    body {
      background-color: #333; /* Darker background color for the page */
      color: #fff; /* Light text color */
      font-family: Arial, sans-serif;
      text-align: center;
      padding: 20px;
    }

    header {
      background-color: #222; /* Darker header background color */
      padding: 10px;
    }

    h1 {
      color: #fff; /* Light text color for header */
    }

    .video-container {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
    }

    .video-card {
      margin: 20px;
      text-align: center;
      padding: 10px;
      background-color: #222;
      border-radius: 10px;
      border: 2px solid transparent; /* No colored border */
    }

    video {
      width: 100%;
      max-width: 640px;
      height: auto;
    }

    button {
      background-color: #FF4500; /* Fiery orange-red button background color */
      color: #fff; /* Light text color for buttons */
      padding: 5px 10px;
      border: none;
      cursor: pointer;
      margin: 5px;
    }
  </style>
</head>

<body>
<header>
  <h1>The Archives</h1>
  <button onclick="window.location.href = 'clip_submission_form.php'">Upload Clip</button>
  <button onclick="window.location.href = 'clip_search.php'">Search Clips</button>
</header>

<div class="video-container">
  <?php

  // Display all clips
  $sql = "SELECT clip.id as cid, title, post_date, name FROM clip JOIN game ON clip.game_id = game.id ORDER BY post_date DESC LIMIT 20;";
  $result = $mysqli->query($sql);

  if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
      echo "<div class='video-card'>
              <b>" . $row["title"] . "</b> " . $row["name"] . " " . $row["post_date"] . "<br>
              <video controls='controls' volume='0.5' id='" . $row["cid"] . "'>
              <source src='clips/" . $row["title"] . ".mp4' type='video/mp4' />
              </video> <br>
              <button onclick=\"window.location.href = 'edit_clip_data.php?clip_id=" . $row['cid'] . "';\">Add tag</button>
              <button onclick=\"window.location.href = 'share_clip.php?clip_id=" . $row['cid'] . "'\">Share</button><br><br>
            </div>";
    }
  }
  else {
    echo "0 results";
  }
  $mysqli->close();

  ?>
</div>

</body>
</html>
