<?php
  $db = mysqli_connect("localhost", "root", "root", "image_upload");

  $msg = "";

  if (isset($_POST['upload'])) {
    $image = $_FILES['image']['name'];
    $image_text = mysqli_real_escape_string($db, $_POST['image_text']);

    $target = "images/".basename($image);

    $sql = "INSERT INTO images (image, image_text) VALUES ('$image', '$image_text')";

    mysqli_query($db, $sql);

    if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
      $msg = "Uploaded successfully";
    } else {
      $msg = "Failed to upload";
    }
  }
  $result = mysqli_query($db, "SELECT * FROM images");
?>
<!DOCTYPE html>
<html>
<head>
  <title>Upload new image</title>
  <link rel="stylesheet" type="text/css" href="stylez.css">
</head>
<body class="background">
  <div id="content">
    <?php
      while ($row = mysqli_fetch_array($result)) {
        echo "<div id='img_div'>";
          echo "<img src='images/".$row['image']."' >";
          echo "<p>".$row['image_text']."</p>";
        echo "</div>";
      }
    ?>
    <form method="POST" action="index.php" enctype="multipart/form-data">
      <input type="hidden" name="size" value="1000000">
      <div>
        <input type="file" name="image">
      </div>
      <div>
        <textarea 
          id="text" 
          cols="40" 
          rows="4" 
          name="image_text" 
          placeholder="Say a few words :)"></textarea>
      </div>
      <div>
        <button type="submit" name="upload">Upload</button>
      </div>
    </form>
  </div>
</body>
</html>
