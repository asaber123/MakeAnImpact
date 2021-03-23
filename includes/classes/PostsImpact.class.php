<?php

// Made by Åsa Berglund 2021
class PostsImpact
{

    //properties
    private $db;
    private $title;
    private $content;

    //constructor
    function __construct()
    {
        $this->db = mysqli_connect(DBHOST, DBUSER, DBPASS, DBDATABASE); if ($this->db->connect_errno > 0) {
            die("Fel vid anlutning:" . $this->db->connect_error);
        }
    }

    //set title
    public function setTitle(string $title): bool
    {
        if (strlen($title) > 2) {
            $this->title = $title;
            return true;
        } else {
            return false;
        }
    }
    //set content
    public function setContent(string $content): bool
    {
        if (strlen($content) > 2) {
            $this->content = $content;
            return true;
        } else {
            return false;
        }
    }

    //get title
    public function getTitle(string $title): string
    {
        return $this->title;
    }
    //get content
    public function getContent(string $content): string
    {
        return $this->content;
    }

    //add posts
    public function addPost($title, $content, $filename, $category): bool{
        $postedBy = $_SESSION['username'];

        if (isset($this->title) && isset($this->content)) {
            $sql = "INSERT INTO PostsImpact(title, content, filename, postedBy, category)VALUES('$this->title','$this->content', '$filename', '$postedBy', '$category');";
            return mysqli_query($this->db, $sql);
        } else {
            return false;
        }
    }


    //Get usersPost
    public function getUsersPosts(){
        $postedBy = $_SESSION['username'];
        $sql = "SELECT * FROM PostsImpact WHERE postedBy = '$postedBy' GROUP BY post_id DESC;";
        $result = $this->db->query($sql);


        //return result as an array
        return mysqli_fetch_all($result, MYSQLI_ASSOC);

    }
    //Get usersPost
    public function getSelectedUserPosts($user){
        $sql = "SELECT * FROM PostsImpact WHERE postedBy = '$user' GROUP BY post_id DESC;";
        $result = $this->db->query($sql);


        //return result as an array
        return mysqli_fetch_all($result, MYSQLI_ASSOC);

    }
    public function getSelectedCategoryPosts($category){
        $sql = "SELECT * FROM PostsImpact WHERE category = '$category' GROUP BY post_id DESC;";
        $result = $this->db->query($sql);


        //return result as an array
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    //Get all Posts
    public function getAllPosts(){
        if(isset($_SESSION['username'])){
        $postedBy = $_SESSION['username'];}
        $sql = "SELECT * FROM PostsImpact GROUP BY post_id DESC;";
        $result = $this->db->query($sql);

        //return result as an array
        return mysqli_fetch_all($result, MYSQLI_ASSOC);

    }


    //uppdate post
    public function updatePost(int $id, string $title, string $content): bool
    {
        $sql = "UPDATE PostsImpact SET title= '$title', content= '$content' WHERE post_id= $id;";

        $result = mysqli_query($this->db, $sql);
        return $result;
    }

    //delete post
    public function deletePost(int $delete_id){ 
        $sql = "SELECT * FROM PostsImpact WHERE post_id=$delete_id ;";
        $result = mysqli_query($this->db, $sql);
        $row = mysqli_fetch_array($result);
        $filename = $row['filename'];
        $target = "./upload/" .$filename; 
        $target_thumb = "./upload/thumb_" .$filename; 

        if (!$filename == ""){
            unlink($target);
            unlink($target_thumb);
            $sql = "DELETE FROM PostsImpact WHERE post_id=$delete_id ;";
           $result = mysqli_query($this->db, $sql);
            return $result;
        }else {
            $sql = "DELETE FROM PostsImpact WHERE post_id=$delete_id ;";
            $result = mysqli_query($this->db, $sql);
            return $result;
        }      
    }
    //Functon to delete img in file upload. (this function is in progress/not working)
    public function deleteImg($filename){
        $target = "./upload/" .$filename; 
        $target_thumb = "./upload/thumb_" .$filename; 

        //$result = $this->db->query($sql);
        //$array = $result->fetch_array();
        if (!$filename == ""){
            unlink($target);
            unlink($target_thumb);
        }
    
    }

    //get specific post
    public function getPostById(int $id): array
    {
        $sql = "SELECT * FROM PostsImpact WHERE post_id=$id;";
        $result = mysqli_query($this->db, $sql);
        $row = $result->fetch_assoc();
        return $row;
    }

    //function for nav menu
    public function getUsersNavPosts(){
        $postedBy = $_SESSION['username'];

        $sql = "SELECT post_id, title FROM PostsImpact WHERE postedBy = '$postedBy';";
        $result = $this->db->query($sql);

         //return result as an array
         return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    //function for nav menu
    public function getGlobalNavPosts(){

        $sql = "SELECT post_id, title FROM PostsImpact GROUP BY post_id DESC;";
        $result = $this->db->query($sql);

            //return result as an array
            return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    


    //get first five posts
    public function getFirstFivePosts(): array
    {
        $sql = "SELECT * FROM PostsImpact GROUP BY post_id DESC LIMIT 5";
        $result = mysqli_query($this->db, $sql);
        
        //return result as an array
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }


    //function to upload pitures
    function uploadFile($file, $width, $height)
    {

        //Controling size and if the file is JPEG
        if ((($_FILES["file"]["type"] == "image/jpeg") || ($_FILES["file"]["type"] ==
            "image/pjpeg")) && ($_FILES["file"]["size"] < 200000)) {
            if ($_FILES["file"]["error"] > 0) {
                return "Felmeddelande: " . $_FILES["file"]["error"] . "<br />";
            } else {

                //Check so that file does not alreddy exist
                if (file_exists("upload/" . $_FILES["file"]["name"])) {
                    return $_FILES["file"]["name"] . " finns redan. Välj ett annat filnamn.";
                } else {

                    //move to right folder    
                    move_uploaded_file($_FILES["file"]["tmp_name"], "upload/" . $_FILES["file"]["name"]);

                    //save name on big and small files
                    $storedfile = $_FILES["file"]["name"];
                    $thumbnail = "thumb_" . $_FILES["file"]["name"];

                    //Maximun width and height
                    $width_thumbnail = 200;
                    $height_thumbnail = 200;


                    //save original size in width_orig, height_orig
                    list($width_thumbnail_orig, $height_thumbnail_orig) = getimagesize('upload/' . $storedfile);

                    //count proportion of width and height
                    $ratio_orig = $width_thumbnail_orig / $height_thumbnail_orig;

                    //count size on small pictures
                    if ($width_thumbnail / $height_thumbnail > $ratio_orig) {
                        $width_thumbnail = $height_thumbnail * $ratio_orig;
                        $height_thumbnail = $width_thumbnail / $ratio_orig;
                    } else {
                        $height_thumbnail = $width_thumbnail / $ratio_orig;
                        $width_thumbnail = $height_thumbnail * $ratio_orig;
                    }

                    //create small picture
                    $image_p = imagecreatetruecolor($width_thumbnail, $height_thumbnail);
                    $image = imagecreatefromjpeg('upload/' . $storedfile);
                    imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width_thumbnail, $height_thumbnail, $width_thumbnail_orig, $height_thumbnail_orig);

                    //save small picture
                    imagejpeg($image_p, 'upload/' . $thumbnail);

                    return "<h3>Image is uploaded</h3>\n";
                    return "<a href='upload/$storedfile' title='Open originonal file'><img src='upload/thumb_$storedfile' alt='$storedfile' /></a>\n";
                }
            }
        } else {
            // error message if picture is to big
            return "JPEG/Picture is to big, have to be smaller than 200kb.";
        }
    }
    //destructor
    function __destruct()
    {
        mysqli_close($this->db);
    }


}
