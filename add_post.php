<html>
<head>
	<title>Add Post</title>
	<link rel="stylesheet" type="text/css" href="./css/style.css">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans|Montserrat:700" rel="stylesheet">

	<?php
		include './includes/connection.php';
	
		if (!isset($_SESSION['username'])) {
			header("location: index.php");
		}
	?>

</head>
<body>
<div style="min-width: 1050px; margin: 0 auto;">
	<div class="sidebar">
		<h4 id="page-title">Add Post</h4><br><br>
		<div class="dashboard">
			<form action="add_post.php" method="POST">
				<input type="submit" value="Return to Dashboard" id="return" name="return"><br><br>
				<input type="submit" value="Manage Posts" id="manage" name="manage"><br><br>
				<input type="submit" value="Log Out" id="logout" name="logout">
			</form>
		</div>

		<?php
			if (isset($_POST['logout'])) {
				unset($_SESSION['username']);
				header("location: index.php");
			} elseif (isset($_POST['return'])) {
				header("location: admin_dashboard.php");
			} elseif (isset($_POST['manage'])) { 
				header("location: manage_posts.php");
			}
		?>

	</div>

	<div class="container">
		<h1 id="title">Add New Post</h1>

		<?php
			if (isset($_POST['post'])) {
				$title = $_POST['content-title'];
				$content = $_POST['content-text'];
				$user = $_SESSION['username'];

				if (""==$title || ""==$content) {
					echo"<span>Please enter title and content</span>";
				} elseif(strlen($title)>20){
                    echo"<span>Too Long Title</span>";
                }elseif(strlen($content)>900){
                    echo"<span>Too Long Content</span>";
                }else {
					echo"Post has been added!";
					$title = secureInput($title);
					$content = secureInput($content);
					$add = "INSERT INTO posts(title,content) VALUES ('$title','$content')";
					mysqli_query($connect, $add);
				}
			}
		?>

		<form action="add_post.php" method="POST" enctype="multipart/form-data">
			<br>
			<label for="content-title">Title:</label>
 			<input type="text" id="content-title" name="content-title" autofocus><br><br>
 			<label for="content-title">Content:</label>
 			<textarea id="content-text" name="content-text" rows="10"></textarea><br><br>
 			<input type="submit" name="post" value="Add Post">
		</form>
	</div>

    <?php
    function secureInput($unsafeInput){
        $safeInput = htmlspecialchars($unsafeInput, ENT_QUOTES, 'UTF-8');
        return $safeInput;
    }
    ?>

</body>
</html>