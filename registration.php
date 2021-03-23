<?php
// Made by Åsa Berglund 2021

include("includes/config.php");
//if someone is alreddy logged in, go to admin page
if (isset($_SESSION['username'])) {
    header("Location: admin.php");
}

$page_title = "Register";

//instance of class
$users = new UsersImpact();
$messages = [];

// Makes variebales id submit button is clicked
if (isset($_POST['username'])) {
    $name = $_POST['name'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $password2 = $_POST['password2'];

    //check if username is taken
    if ($users->UsernameTaken($username)) {
        array_push($messages,  "<p class='errorMessage'>Username is taken</p>");
    }
    if (!$users->setName($name)) {
        array_push($messages, "<p class='errorMessage'>Your name have to contain more than 1 character</p>");
    }
    if (!$users->setUsername($username)) {
        array_push($messages, "<p class='errorMessage'>Your username have to contain more that 2 characters</p>");
    }
    if (!$users->setPassword($password, $password2)) {
        array_push($messages, "<p class='errorMessage'>Your password have to be longer than 7 characters</p>");
    } //If no messages, then add user to table
    else {
        if ($users->registerUser($name, $username, $password)) {
            $mess = "<p class='message'> Användare skapad gå nu till -> <a href='index.php'>logg in</a></p>";
        } else {
            $mess = "<p>" . ('Error description:' . mysqli_error($users->getdb())) . "</p>";
        }
    }
}
include("includes/startheader.php");
?>
<main class="start">
    <section class="start-posts">
    <a class='submit' href="index.php">Go Back</a> <br> <br>
        <form action="registration.php" method="post">
            <h4>Register</h4>
            <div>
            <!-- Checks if there are any messages, if there is then its written out -->
                <?php
                if (sizeof($messages) > 0) {
                    echo "<ul class='errorMessage'>";
                    foreach ($messages as $message) {
                        echo "<li> $message </li>";
                    }
                }
                if (isset($mess)) {
                    echo $mess;
                }
                ?>
            </div>
            <br>
            <label for="name">Name:</label>
            <br>
            <input type="text" name="name" id="name">
            <br>
            <label for="username">Username:</label>
            <br>
            <input type="text" name="username" id="username">
            <br>
            <label for="password">Password:</label>
            <br>
            <input type="password" name="password" id="password">
            <br>
            <label for="password">Type same password again:</label>
            <br>
            <input type="password" name="password2" id="password2">
            <br>
            <input class="submit" type="submit" value="Registrate">
            <br>
        </form>
    </section>
</main>
<?php
include("includes/footer.php");
?>