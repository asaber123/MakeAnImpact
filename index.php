<?php
//Made by Åsa Berglund 2021
include("includes/config.php");
//If user is not logged in-> index page
if (isset($_SESSION['username'])) {
    header("Location: admin.php");
}

//controll log in, sets variables if submit button is clicked
if (isset($_POST['username'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    //making a new instance of class
    $users = new UsersImpact();
    if ($users->loginUser($username, $password)) {        
        $_SESSION['username'] = $username;
        header("Location: admin.php");

    } else {
        $message = "<p class='errorMessage'> Wrong password/username </p>";
    }
}

$page_title = "Make an impact";
include("includes/startheader.php");
?>
<main class="start">
    <section class="login-start">
        <form class="form-login" action="index.php" method="post">
            <br>
            <label class="login" for="username">Username:</label>
            <br>
            <input class="login" type="text" name="username" id="username">
            <br>
            <label class="login" for="password">Password:</label>
            <br>
            <input class="login" type="password" name="password" id="password">
            <br>
            <input class="submit" id="start" type="submit" value="logg in">

        </form>
        <div>
                <?php
                if (isset($message)) {
                    echo $message;
                }
                ?>
            </div>

        <p>Not a user yet? Register <a href="registration.php">HERE</a></p>

    </section>
<!-- Here shows 5 recent posts -->
    <section class="start-posts">
        <h1> <a href="asaberglund.se/impact/posts.php"> Latests posts:</a></h1>
        <?php
        $posts = new PostsImpact();
        $post_list = $posts->getFirstFivePosts();
        foreach ($post_list as $post) {
            echo "<div class='posts'><h2>" . $post['title'] . "</h2>" .
                "<p> posted by: <b>" . $post['postedBy'] .
                "</b> <br> <br></p><img class='all-post-pic' src='./upload/thumb_" . $post['filename'] .
                "' alt='" . $post['filename'] . "'>" .
                " <p class='content'>" .  substr($post['content'], 0, 350) . "..." .
                "<p>" .
                $post['postDate'] .
                " </p><a class='submit' href='single.php?id=" .
                $post['post_id'] .
                "'>Read post</a> </div>";
        }
        ?>
        

    </section>
</main>



<?php
include("includes/footer.php");
?>