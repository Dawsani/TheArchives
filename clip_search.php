<?php
include 'db_connection.php'
?>

<html>

<head>
  <style>
    * {
      box-sizing: border-box;
    }

    .column {
      flex: 1;
      float: left;
      width: 20%;
      max-width: 250px;
      padding: 10px;
    }

    /* Clear floats after the columns */
    .row {
      content: "";
      display: flex;
      clear: both;
    }
  </style>
</head>

<body>
<header>
  <h1>Search Clips</h1>
  <button onclick="window.location.href = 'index.php'">Home</button>
</header>

<form action="clip_search_result.php" method="POST" enctype="multipart/form-data">
<div class="row">
  <div class="column" style="background-color:#aaa;">
    <!-- File Name --> 
    <b>File Name: </b>
    <input type="text" name="clip_title" id="clip_title">
    <br><br>

    <!-- Date --> 
    <b>Earliest Date:</b>
    <input type="date" name="earliest_date">
    <br>
    <b>Latest Date:</b>
    <input type="date" name="latest_date">
    <br>
  </div>
  <div class="column" style="background-color:#bbb;">
    <!-- Users --> 
    <b>Involved Users:</b> <br>
    <?php
    $sql = "SELECT id, name FROM person ORDER BY name";
    $result = $mysqli->query($sql);
    while ($row = mysqli_fetch_assoc($result)) {
      echo '<input type="checkbox" name="selected_users[]" value="' . $row['id'] . '">';
      echo $row['name'] . '<br>';
    }
    ?>
  </div>
  <div class="column" style="background-color:#aaa;">
    <!-- Games --> 
    <b>Games:</b> <br>
    <?php
    $sql = "SELECT id, name FROM game";
    $result = $mysqli->query($sql);
    while ($row = mysqli_fetch_assoc($result)) {
      echo '<input type="checkbox" name="selected_games[]" value="' . $row['id'] . '">';
      echo $row['name'] . '<br>';
    }
    ?>
  </div>
  <div class="column" style="background-color:#bbb;">
    <!-- Users --> 
    <b>Tags:</b> <br>
    <?php
    $sql = "SELECT id, name FROM tag";
    $result = $mysqli->query($sql);
    while ($row = mysqli_fetch_assoc($result)) {
      echo '<input type="checkbox" name="selected_tags[]" value="' . $row['id'] . '">';
      echo $row['name'] . '<br>';
    }
    ?>
  </div>
</div>
<!-- Submit Button -->
<button type="submit" name="submit_search">Search</button>
</form>

</body>

</html>