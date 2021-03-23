<?php
// Made by Åsa Berglund 2021
include("includes/config.php");


//kollar om sessionsvariablen finns
if (!isset($_SESSION['username'])) {
  header("Location: login.php?message=2");
}
//controll if id is sent
if (isset($_GET['id'])) {
  $id = intval($_GET['id']);
} else {
  header("Location:admin.php");
}
$page_title = "Update";
include("includes/sidebarAdmin.php");
include("includes/header.php");
$page_title = "Update post";
?>
<?php
$post = new PostsImpact();
$details = $post->getPostById($id);
$filename =$details['filename'];

//uppdate post
if (isset($_POST['title'])) {
  $title = ($_POST['title']);
  $content = ($_POST['content']);


  //upload picture
  if (isset($_FILES['file'])) {
    //$post->deleteImg($details['filename']);
    //$post->uploadFile($_FILES['file'], 300, 300);
    //$file = ($_FILES['file']);
    //$filename = $_FILES['file']['name'];
  }
  //If table is updated, then write message.
  if ($post->updatePost($id, $title, $content, $filename)) {
    $message = "<p class='message'> Post is now updated! </p>";
  } else {
    $message = "<p class='errorMessage'> It wasnt possible to update the post, contact helpdesk</p>";
  }
}

?>
<main class="centered">
  <section class="form">

    <form action="update.php?id=<?= $id; ?>" method="post">
      <h3>Update your post:</h3>
      <br>
      <div>
        <?php
        if (isset($message)) {
          echo $message;
          echo$filename;
        }

        ?>
          <!-- Form for update post -->
        <!-- <input type="hidden" name="MAX_FILE_SIZE" value="200000" />  -->
        <!-- <label for="file"><strong>Filnamn:</strong></label>  -->
        <!-- <input type="file" name="file" id="file" />  -->
        <br>
      </div>
      <label for="title">Title:</label>
      <br>
      <input type="text" name="title" id="title" value="<?= $details['title']; ?>">
      <br>

      <br>
      <textarea name="content" id="content" <?= $details['content'];?>></textarea>
      <br>
      <input class="submit" type="submit" value="update">
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