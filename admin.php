<?php
include("includes/config.php");
//Made by Åsa Berglund2021
//check if someone logged in
if (isset($_SESSION['username'])) {
  $username = ($_SESSION['username']);
} else {
  header("Location: index.php?message=2");
}

// Page title
$page_title = "$username";
include("includes/header.php");
include("includes/sidebarAdmin.php");

?>
<?php
$post = new PostsImpact();
$errors = [];



//add post, adds variables if submit button is clicked. 
if (isset($_POST['title'])) {
  $title = ($_POST['title']);
  $content = ($_POST['content']);
  $category = ($_POST['category']);

  //upload picture
  if (isset($_FILES['file'])) {
    $post->uploadFile($_FILES['file'], 300, 300);
    $file = ($_FILES['file']);
    $filename = $_FILES['file']['name'];
  }//Check if title is ok
  if (!$post->setTitle($title)) {
    array_push($errors, "Your title have to be longer than 2 characters!");
  }//check if content is ok
  if (!$post->setContent($content)) {
    array_push($errors, "Your content have to be longer than 2 characters!");
  }//check if there is no errors
  if (sizeof($errors) == 0) {
    $post->addPost($title, $content, $filename, $category);
    $message = "<p class='message'> Your action is now posted! </p>";
  }
}

?>
<main class="centered">
  <section class="form">

    <form class="space-top" action="admin.php" method="post" enctype="multipart/form-data">

      <h2>Continue to inspire!</h2>
      <br>
      <div>
      <!-- Here shows error messages -->
        <?php
        if (sizeof($errors) > 0) {
          echo "<ul class='errorMessage'>";
          foreach ($errors as $error) {
            echo "<li> $error </li>";
          }
        }
        if (isset($message)) {
          echo $message;
        }

        ?>
      </div>
      <input type="hidden" name="MAX_FILE_SIZE" value="200000" /> <!-- 200K max size, controlls so that the file is not to big before uploading it  -->
      <label for="file"><strong>Upload a picture (jpeg):</strong></label>
      <br>
      <input type="file" name="file" id="file" />
      <br>
      <label for="title">Title:</label>      
      <br>
      <input class="input-title" type="text" name="title" id="title">
      <br><br>
        <label for="category">Choose a category:</label>
        <br>
        <select class="admin-select-option" name="category" id="category">
        <option disabled selected value> -- select an option -- </option>
          <option value="Climate actions">Climate actions</option>
          <option value="Environmental actions">Environmental actions</option>
          <option value="Food and farming">Food and farming</option>
          <option value="Events">Events</option>
        </select>

      <br>      <br>

      <textarea name="content" id="content"></textarea>

      <br>
      <input class="submit" name="submit" type="submit" value="Post">
      <br>
    </form>


  </section>
</main>

<!-- texteditor -->
<script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>

<script>
  CKEDITOR.replace('content');
</script>

<?php
include("includes/footer.php");
?>