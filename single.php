<?php
// Made by Åsa Berglund 2021

if(isset($_GET['id'])){
    $id=intval($_GET['id']);
}else{
    header("Location: index.php");
}
include_once("includes/config.php");

include("includes/header.php");
// Check if user is logged in, if it is sidebarAdmin is used, otherwise sidebarGlobal is used. 
if(isset($_SESSION['username'])){
include("includes/sidebarAdmin.php");
}else{
    include("includes/sidebarGlobal.php"); 
}
$page_title = "post";

?>
<main class="centered">
    <section class="form">
<?php
$post =new PostsImpact();
//Gets the specific post. 
$post_list= $post->getPostById($id);
$origional = "./upload/". $post_list['filename'];
echo 
"<h1>" . $post_list['title'] . "</h1>" .
//Lightbox effect on img
"<div class='post-pic'><a data-lightbox='bild' data-title='bild' href='./upload/" .$post_list['filename'] . "' target='_blank' > <img src='./upload/" .$post_list['filename'] . "' alt='".$post_list['filename'] ."'></a> </div>". 
        " <p class='content'>" .  $post_list['content']  .
        "</p>" .
        "<p><b> Posted by: " . $post_list['postedBy'] ."</b></p><p>".
        $post_list['postDate'] .
        " </p>";
?>

<a class='submit' href="posts.php">Go Back</a>

</section>
</main>
<?php
include("includes/footer.php");
?>
