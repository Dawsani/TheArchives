<?php
include 'db_connection.php'
?>

<html>

<head>
</head>

<body>
<header>
  <h1>Clip Search Results</h1>
    <button onclick="window.location.href = 'index.php'">Home</button>
    <button onclick="window.location.href = 'clip_search.php'">Search Clips</button>
</header>

<?php

// Define initial SEARCH
$sql = "SELECT DISTINCT title, name, post_date, user_count, cid
        FROM (
            SELECT clip.title, clip.id AS cid, game.name, clip.post_date, COUNT(clip_person.person_id) AS user_count, original_poster_id";

$search_constraints = 0;

// Get clip info

// Selected tags
$tags_are_selected = 0;
if (isset($_POST['selected_tags'])) {
    $tags_are_selected = 1;
    $sql .= ", tag_id FROM clip join clip_person ON clip.id = clip_id JOIN game ON clip.game_id = game.id";
    
    $selected_tags_array = $_POST['selected_tags'];
    $selected_tags = implode(',', $selected_tags_array);
    
    $search_constraints++;
    if ($search_constraints == 1) {
        $sql .= " JOIN clip_tag ON clip.id = clip_tag.clip_id WHERE ";
    }
    $sql .= "tag_id IN ($selected_tags)";
}

if ($tags_are_selected == 0) {
    $sql .= " FROM clip join clip_person ON clip.id = clip_id JOIN game ON clip.game_id = game.id";
}

// Clip title
$clip_title = $_POST["clip_title"];
if ($clip_title != '') {
    $search_constraints++;
    if ($search_constraints == 1) {
        $sql .= " WHERE ";
    }
    else {
        $sql .= " AND ";
    }
    $sql .= "title LIKE '%$clip_title%'";
}

// Earliest date
$earliest_date = $_POST["earliest_date"];
if ($earliest_date != '') {
    $search_constraints++;
    if ($search_constraints == 1) {
        $sql .= " WHERE ";
    }
    else {
        $sql .= " AND ";
    }
    $sql .= "post_date >= '$earliest_date'";
}

// Latest date
$latest_date = $_POST["latest_date"];
if ($latest_date != '') {
    $search_constraints++;
    if ($search_constraints == 1) {
        $sql .= " WHERE ";
    }
    else {
        $sql .= " AND ";
    }
    $sql .= "post_date <= '$latest_date'";
}

// Selected games
if (isset($_POST['selected_games'])) {
    $selected_games = $_POST['selected_games'];
    $selected_games = implode(',', $selected_games);

    $search_constraints++;
    if ($search_constraints == 1) {
        $sql .= " WHERE ";
    }
    else {
        $sql .= " AND ";
    }
    $sql .= "game.id IN ($selected_games)";
}

// Selected users
$users_are_selected = 0;
if (isset($_POST['selected_users'])) {
    $selected_users_array = $_POST['selected_users'];
    $selected_users = implode(',', $selected_users_array);
    
    $users_are_selected = 1;
    $search_constraints++;
    if ($search_constraints == 1) {
        $sql .= " WHERE ";
    }
    else {
        $sql .= " AND ";
    }
    $sql .= "person_id IN ($selected_users)";
}

$sql .= " GROUP BY clip.id";

// if users are selected add the ORDER BY
if ($users_are_selected == 1) {
    $sql .= " ORDER BY user_count DESC, post_date";
}

// Add the last bit of the query
$sql .= ") AS subquery;";

$result = $mysqli->query($sql);
if ($result === TRUE) {
    #echo "Search succeeded. <br>";
}
else {
    echo "Error: " . $sql . "<br>" . $mysqli->error . "<br>";
}

$clip_contains_all_searched_users = 1;
// Display all searched clips
if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    if ($clip_contains_all_searched_users ==  1 && isset($_POST['selected_users']) && $row["user_count"] != count($selected_users_array)) {
        $clip_contains_all_searched_users = 0;
        echo "<br><h3>The following clips do not contain every selected user in your search.</h3><br><br>";
    }
    echo "<b>" . $row["title"] . "</b> " . $row["name"] . " " . $row["post_date"] . "<br>
          <video width='640px' height='360px' controls='controls' volume='0.5' id='" . $row["cid"] . "'>
          <source src='clips/" . $row["title"] . ".mp4' type='video/mp4' />
          </video> <br>
          <button onclick=\"window.location.href = 'edit_clip_data.php?clip_id=" . $row['cid'] . "';\">Add tag</button>
          <button onclick=\"window.location.href = 'share_clip.php?clip_id=" . $row['cid'] . "'\">Share</button><br><br>";
  }
} 
else {
  echo "No results";
}
$mysqli->close();

?>

</body>

</html>