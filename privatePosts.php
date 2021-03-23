<?php
// Made by Åsa Berglund 2021

include("includes/config.php");
$page_title ="Hello";
include("includes/header.php");
include("includes/sidebarAdmin.php");

//delete post
$post = new PostsImpact();
$message= "";
if (isset($_GET['delete_id'])) {
  $delete_id = intval($_GET['delete_id']);
  if ($post->deletePost($delete_id)) {
    $message = "<p class='message'> Post is deleted </p>";
  } else {
    $message = "<p class='errorMessage'> It wasnt possible to delete the post, contact helpdesk!</p>";
  }
}
$page_title = "My posts";
?>
<main class="centered">
    <section class="all-posts">
<h2 class="space-top">My posts:</h2>
  <?php echo $message; ?>
    <br>
    <!-- Here shows logged in users posts -->
    <?php
    $posts = new PostsImpact();
    $post_list = $posts->getUsersPosts();
    foreach ($post_list as $post) {
    
      if(strlen($post['filename'])<0){
        $img = "<img src='./upload/" .$post['filename'] .
        "' alt='".$post['filename'] ."'>";
      }else{
        $img = "";
      }

      echo "<div class='posts'><h4>" . $post['title'] . "</h4>" .
      "<img class='all-post-pic' src='./upload/thumb_" .$post['filename'] .
      "' alt='".$post['filename'] ."'>" .
        "<p class='content'>" .  substr($post['content'], 0, 500) . "..." .
        "</p><p><b>" .
        $post['postDate'] .
        " </b></p><a class='submit' href='single.php?id=" .
        $post['post_id'] .
        "'>Read post</a></div>" .
        "<div><a href='privatePosts.php?delete_id=" . $post['post_id'] . "'>Delete</a>" . " - <a href='update.php?id=" . $post['post_id'] . "'>Update</a></div>";
      
      }
    ?>
  </section>

</main>
<?php
include("includes/footer.php");
?>