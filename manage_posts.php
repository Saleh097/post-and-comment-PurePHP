<html>
<head>
	<title>Mange Posts</title>
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
				echo "You are signed in as ",$_SESSION['username'],". &nbsp;&nbsp; <a href='admin_dashboard.php'>Return to Dashboard</a><br>";
			}
		?>
        <?php
        if($_SESSION['username']=='admin'){
            if(isset($_POST['removePost'])){
                $rem = "DELETE FROM posts WHERE id=".$_POST['pid'];
                mysqli_query($connect,$rem);
                header("Refresh:0");
            }
            if(isset($_POST['removeComment'])){
                $rem = "DELETE FROM comments WHERE id=".$_POST['cid'];
                mysqli_query($connect,$rem);
                header("Refresh:0");
            }
        }
        ?>
		<h1 id="title">Posts</h1>
		<div class="display-content">
            <?php
            $query = mysqli_query($connect, "SELECT * FROM posts");
            while ($fetch = mysqli_fetch_assoc($query)) {
                $title = $fetch['title'];
                $content = $fetch['content'];
                $pid = $fetch['id'];
                echo '<div class="display-content2">';
                echo ("<h2>$title</h2>");
                echo "<form action=\"manage_posts.php\" method=\"POST\"> 
                    <input type=\"hidden\" name=\"pid\" value=\"".$pid."\">
                    <input type=\"submit\" value=\"Remove\" id=\"logout2\" name=\"removePost\">         
                </form>";
                echo nl2br ("<br>$content");
                echo '</br></br></br>';
                $comments = mysqli_query($connect,"SELECT comments.id AS cid,user,comments.content AS content 
                                                              FROM comments JOIN posts ON posts.id=pid WHERE pid=".$fetch['id']);
                while ($cmt = mysqli_fetch_assoc($comments)) {
                    $user = $cmt['user'];
                    $comment_text = $cmt['content'];
                    $cmId = $cmt['cid'];
                    echo "<div class=\"display-comment\">";
                    echo "$user : </br>";
                    echo "<form action=\"manage_posts.php\" method=\"POST\">
                            <input type=\"hidden\" name=\"cid\" value=\"".$cmId."\">
                            <input type=\"submit\" value=\"Remove\" id=\"logout2\" name=\"removeComment\">
                        </form>";
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

</body>
</html>