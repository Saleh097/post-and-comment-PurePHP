<html>
<head>
    <title>Posts</title>
    <link rel="stylesheet" type="text/css" href="./css/style.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans|Montserrat:700" rel="stylesheet">

    <?php
    include './includes/connection.php';
    ?>

</head>
<body>

<div style="min-width: 1050px; margin: 0 auto;">
    <div class="container-content">
        <?php
        if (isset($_SESSION['username'])) {
            echo "Wellcome back ",$_SESSION['username'],".";
            echo '<form action="posts.php" method="POST"> 
                    <input type="submit" value="Log Out" id="logout2" name="logout">
                </form>';
        }
        else
            echo "<a href = index.php>Main page</a>"
        ?>

        <h1 id="title">Posts</h1>
        <div class="display-content">
            <?php
            $query = mysqli_query($connect, "SELECT * FROM posts");
            while ($fetch = mysqli_fetch_assoc($query)) {
                $title = $fetch['title'];
                $content = $fetch['content'];
                echo '<div class="display-content2">';
                echo ("<h2>$title</h2>");
                echo nl2br ("<br>$content");
                echo '</br></br></br>';
                $comments = mysqli_query($connect,"SELECT user,comments.content AS content FROM comments JOIN posts ON posts.id=pid
                                                              WHERE pid=".$fetch['id']);
                while ($cmt = mysqli_fetch_assoc($comments)) {
                    $user = $cmt['user'];
                    $comment_text = $cmt['content'];
                    echo "<div class=\"display-comment\">";
                    echo "$user : </br>";
                    echo "$comment_text";
                    echo "</div>";
                    echo "</br>";
                }
                echo "<form action=\"posts.php\" method=\"POST\" >
 			            <textarea id=\"content-text\" name=\"comment-text\" rows=\"10\" placeholder=\"your comment\"></textarea><br><br>
 			            <input type=\"hidden\" name=\"pid\" value=\"".$fetch['id']."\">
 			            <input type=\"submit\" name=\"post\" value=\"send comment\">
		            </form>";
                echo '</div class="display-content2">'.'<br><br>';
            }
            ?>
        </div>
    </div>

    <?php
    if (isset($_POST['logout'])) {
        unset($_SESSION['username']);
        header("Location: index.php");
    }

    if(isset($_POST['post']) && isset($_SESSION['username'])){
        $pid = $_POST['pid'];
        $usr = $_SESSION['username'];
        $comment = $_POST['comment-text'];
        if(strlen($comment)>60){
            echo"<span>Too Long Comment</span>";
        }
        else{
            $comment = secureInput($comment);
            $add = "INSERT INTO comments(pid,user,content) VALUES ($pid,'$usr','$comment')";
            mysqli_query($connect, $add);
        }
        header("Refresh:0");
    }
    ?>

    <?php
    function secureInput($unsafeInput){
        $safeInput = htmlspecialchars($unsafeInput, ENT_QUOTES, 'UTF-8');
        return $safeInput;
    }
    ?>
</body>
</html>