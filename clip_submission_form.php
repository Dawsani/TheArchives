<?php
include 'db_connection.php'
?>

<html>

<head>

<script>
    function validateForm(event) {
      var checkboxes = document.querySelectorAll('input[type="checkbox"]:checked');
      var opRadioButtons = document.querySelectorAll('input[type="radio"][name="original_poster_id"]:checked');
      var gameRadioButtons = document.querySelectorAll('input[type="radio"][name="selected_game_id"]:checked');
      var dateInput = document.getElementById('date');

      if (checkboxes.length === 0 || opRadioButtons.length === 0 || gameRadioButtons.length === 0 || dateInput.value === "") {
          // Custom confirmation dialog
          var userConfirmed = confirm("Your upload is missing important data. Do you want to submit anyway?");
          if (!userConfirmed) {
              event.preventDefault(); // Prevent form submission
          }
      }
  }
</script>

<style>
  #searchInput {
      width: 100%;
      padding: 5px;
      margin-bottom: 10px;
  }
  
  * {
    box-sizing: border-box;
  }

  .column {
    flex: 1;
    float: left;
    width: 25%;
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

<header>
<h1>Clip Submission Form</h1>
<button onclick="window.location.href = 'index.php'">Home</button>
</header>

<body>

<form action = "submit_clip.php" method="POST" onsubmit="validateForm(event)" enctype="multipart/form-data">
<div class="row">
  <div class="column" style="background-color:#aaa;">
    <!-- Video --> 
    <b>Select video to upload:</b>
    <br>
    <input type="file" name="file_to_upload" id="file_to_upload" accept=".mp4" required>
    <br>

    <!-- Date --> 
    <b>Date:</b>
    <br>
    <input type="date" name="date" placeholder="Date posted">
    <br>
  </div>
  <div class="column" style="background-color:#bbb;">
    <!-- Original Poster --> 
    <b>Original Poster:</b> <br>

    <?php
    $sql = "SELECT id, name FROM person ORDER BY name";
    $result = $mysqli->query($sql);
    while ($row = mysqli_fetch_assoc($result)) {
      echo '<input type="radio" name="original_poster_id" value="' . $row['id'] . '"><label for="' . $row['id'] . '">' . $row['name'] . '<br></label>';
    }
    ?>
  </div>
  <div class="column" style="background-color:#aaa;">
    <!-- Users --> 
    <b>Involved Users:</b> <br>

    <?php
    $sql = "SELECT id, name FROM person ORDER BY name";
    $result = $mysqli->query($sql);
    while ($row = mysqli_fetch_assoc($result)) {
      echo '<input type="checkbox" name="selected_users[]" value="' . $row['id'] . '"><label for="' . $row['id'] . '">' . $row['name'] . '<br></label>';
    }
    ?>
  </div>
  <div class="column" style="background-color:#bbb;">
    <!-- Game --> 
    <b>Game:</b> <br>
    <input type="text" id="game_search_input" placeholder="Search for a game">
    <br>

    <div id="game_radio_list">
      <?php
      $sql = "SELECT id, name FROM game";
      $result = $mysqli->query($sql);
      while ($row = mysqli_fetch_assoc($result)) {
        echo '<input type="radio" name="selected_game_id" value="' . $row['id'] . '"><label for="' . $row['id'] . '">' . $row['name'] . '<br>' . '</label>';
      }
      $mysqli->close();
      ?>
    </div>

    <script>
      document.addEventListener("DOMContentLoaded", function () {
        const searchInput = document.getElementById("game_search_input");
        const radioList = document.querySelector('#game_radio_list');
        const originalRadioList = radioList.innerHTML;
        
        searchInput.addEventListener("input", function () {
          const search = this.value.toLowerCase();
          
          // Reset to the original list
          radioList.innerHTML = originalRadioList;
          
          // Get all radio buttons in the updated list
          const radioButtons = radioList.querySelectorAll('input[type="radio"][name="selected_game_id"]');
          
          radioButtons.forEach(function (radioButton) {
            const label = radioButton.nextSibling;
            const labelText = label.textContent.toLowerCase();
            
            if (!labelText.includes(search)) {
              // Remove the radio button and its associated label
              radioButton.remove();
              label.remove();
            }
          });
        });
      });
    </script>
  </div>
</div>

<!-- Submit Button -->
<button type="submit" name="submit">Submit Clip</button>

</form>

</body>

</html>