<?php
// Made by Åsa Berglund 2021

include("includes/config.php");
include("includes/header.php");
include("includes/sidebarGlobal.php");
$posts = new PostsImpact();
$page_title = "Posts";

?>

<main class="centered">
  <section class="select-tags">
    <h3 class="no-mobile">Sort posts:</h3>
    <form class="select-form" method="post" action="posts.php">
      <label for="users">View posts by user:</label>
      <br>
      <!-- Here is a select option where all users are shown -->
      <select class="select-option" name="users" id="users">
        <option disabled selected value> -- select an option -- </option>
        <?php
        $users = new UsersImpact();
        $userList = $users->getAllUsers();
        foreach ($userList as $user) {
          echo "<option value='" . $user['username'] . "'>" . $user['username'] . "</option>";
        }
        ?>
      </select>
      <input class="select-submit" type="submit" value="View">
    </form>
    <!-- Here is a select option to sort posts by category (not functioning yet)  -->
    <form class="select-form" method="post" action="posts.php">
      <label for="category">View posts by category:</label>

      <br>
      <select class="select-option" name="category" id="category">
        <option disabled selected value> -- select an option -- </option>
        <option value="Climate actions">Climate actions</option>
        <option value="Environmental actions">Environmental actions</option>
        <option value="Food and farming">Food and farming</option>
        <option value="Events">Events</option>
      </select>
      <input class="select-submit" type="submit" value="View">
    </form>
  </section>


  <section class="all-posts">

    <?php

    // checks if users have choosen a user or chatergory.(category is not functioning yet)
    if (isset($_POST['category'])) {
      $posts->getSelectedCategoryPosts($_POST['category']);

      if ($posts->getSelectedCategoryPosts($_POST['category'])) {
        $post_list = $posts->getSelectedCategoryPosts($_POST['category']);
      }
    }
    if (isset($_POST['users'])) {
      $posts->getSelectedUserPosts($_POST['users']);

      if ($posts->getSelectedUserPosts($_POST['users'])) {
        $post_list = $posts->getSelectedUserPosts($_POST['users']);
      }
    } else {
      $post_list = $posts->getAllPosts();
    }
    if (!empty($post_list)) {
      foreach ($post_list as $post) {
        echo "<div class='posts'><h4>" . $post['title'] . "</h4>" .
          "<p> posted by: <b>" . $post['postedBy'] .
          "</b></p><img class='all-post-pic' src='./upload/thumb_" . $post['filename'] .
          "' alt='" . $post['filename'] . "'>" .
          " <p class='content'>" .  substr($post['content'], 0, 450) . "..." .
          "<p>" .
          $post['postDate'] .
          " </p><a class='submit' href='single.php?id=" .
          $post['post_id'] .
          "'>Read post</a> </div>";
      }
    }
    ?>
  </section>

</main>


<?php
include("includes/footer.php");
?>