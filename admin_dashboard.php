<html>
<head>
	<title>Dashboard</title>
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
		<h4 id="page-title">Dashboard</h4><br><br>
		<div class="dashboard">
			<form action="admin_dashboard.php" method="POST">
				<input type="submit" value="Add Post" id="add" name="add"><br><br>
				<input type="submit" value="Manage Posts" id="manage" name="manage"><br><br>
				<input type="submit" value="Log Out" id="logout" name="logout">
			</form>
		</div>

		<?php
			if (isset($_POST['logout'])) {
				unset($_SESSION['username']);
				header("location: index.php");
			} elseif (isset($_POST['add'])) {
				header("location: add_post.php");
			} elseif (isset($_POST['manage'])) {
				header("location: manage_posts.php");
			}
		?>

	</div>

	<div class="container">
		<h1 id="title">Welcome Back, <?php echo$_SESSION['username']?></h1>
	</div>
</body>
</html>