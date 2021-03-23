<!-- Made by Åsa Berglund 2021 -->
<!-- Sidebar for all users -->
<div class="navigation">
    <ul>
        <?php
        if (!isset($_SESSION['username'])) {
            echo "<li>
            <a href='index.php'>
                <span class='icon'><img src='./img/sign-in.svg' alt='sign in'></span>
                <span class='title'> sign in</span>
            </a>
        </li>";
        } else {
            echo "<li>
            <a href='index.php'>
                <span class='icon'><img src='./img/user.svg' alt='my page'></span>
                <span class='title'> my admin </span>
            </a>
        </li>";
        }
        ?>
        <li>
            <a href="posts.php">
                <span class="icon"><img src="./img/global.svg" alt="global"></span>
                <span class="title">Global actions</span>
            </a>
        </li>
    </ul>
    <!-- This is a menu for all posts, if a specific users post is selected, then only those are viewed. -->
    <div class="all-post-list">
        <?php
        $posts = new PostsImpact();
        if (isset($_POST['users'])) {
            $posts->getSelectedUserPosts($_POST['users']);

            if ($posts->getSelectedUserPosts($_POST['users'])) {
                $nav_list = $posts->getSelectedUserPosts($_POST['users']);
            }
        } else {
            $nav_list = $posts->getGlobalNavPosts();
        }
        if (!empty($nav_list)) {
            foreach ($nav_list as $item) {
                echo "<p class='post-list'> <a href='single.php?id=" . $item['post_id'] . "'>" . $item['title'] . "</a></p>";
            }
        }
        ?>

    </div>
</div>
<div class="toggle" onclick="toggleMenu()"></div>