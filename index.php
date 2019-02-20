<html>
<head>
	<title>Home</title>
	<link rel="stylesheet" type="text/css" href="./css/style.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans|Montserrat:700" rel="stylesheet">

	<?php
		include './includes/connection.php';  //for login as Admin : usename = admin && pasword = admin
	?>

</head>
<body>
<div style="min-width: 1050px; margin: 0 auto;">
	<div class="sidebar">
		<h1>Login</h1>
		<form id="log-in" action="index.php" method="POST">
			<input type="text" id="name" name="name" placeholder="Username"><br><br>
			<input type="password" id="password" name="password" placeholder="Password"><br><br>
			<input type="submit" value="Login" name="login" id="submit">
		</form>


		<?php
		 	if (isset($_POST['login'])) {
				$username = $_POST['name'];
				$password = $_POST['password'];

				if ("" == $username && ""== $password) {
					echo"<span>Please Enter Username and Password</span>";
				} elseif ("" == $username) {
					echo"<span>Please Enter Username</span>"; 
				} elseif ("" == $password) {
					echo"<span>Please Enter Password</span>";
				} elseif(strlen($username)>20){
				    echo"<span>User Not Found</span>";
                }else {
                    $username = secureInput($username);
                    $q = "SELECT * FROM login WHERE username = '$username'";
					$result = mysqli_query($connect,$q);
					$resultCheck = mysqli_num_rows($result);

					if ($resultCheck < 1) {
						echo "<span>Login Unsuccessful</span>";
					} else {
						if ($row = mysqli_fetch_assoc($result)) {
							$checkPassword = password_verify($password, $row['password']);

							if($row['username'] == $username && $checkPassword == true) {
								$_SESSION['username'] = $username;
								if($username=='admin')
                                    header("Location: admin_dashboard.php");
								else
								    header("Location: posts.php");

						 	} else {
						  		echo "<span>Login Unsuccessful</span>";
						 	}
						}
					}
				}
			}
		?>

	</div>

    </br></br>
    <div class="sidebar2">
        <a href="posts.php"><h1>View Posts</h1></a>
    </div>

	<div class="container">
		<h1 id="title">Sign up</h1>
		<?php
			if (isset($_POST['signup'])) {
				$user = $_POST['user'];
				$email = $_POST['email'];
				$pass = $_POST['pass'];
				$confirm = $_POST['confirm'];
				if(strlen($user)>20){
				    echo"<span>Too Long Username</span>";
                }elseif(strlen($email)>60){
                    echo"<span>Too Long Email</span>";
                }
                else{
                    $user = secureInput($user);
                    $que = "SELECT * FROM login WHERE username = '$user'";
                    $check = mysqli_query($connect,$que);
                    if (mysqli_num_rows($check)>=1){
                        echo "<span>Username Already Exists!</span>";
                    } elseif (""==$user || ""==$email || ""==$pass || ""==$confirm) {
                        echo "<span>All fields are required!</span>";
                    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)){
                        echo "<span>Invalid email format</span>";
                    }elseif ($pass == $confirm) {
                        $pass = password_hash($pass, PASSWORD_DEFAULT);
                        $email = secureInput($email);
                        $insert = "INSERT INTO login(username, email, password) VALUES ('$user', '$email', '$pass')";
                        mysqli_query($connect, $insert);
                        echo"Your account has been created. You may now login.";
                    } else {
                        echo"<span>Passwords do not match</span>";
                    }
                }
			}
		?>

		<form id="sign-up" action="index.php" method="POST">
			<label for="user">Username:</label>
			<input type="text" id="user" name="user"><br><br>
			<label for="user">E-Mail:</label>
			<input type="text" id="email" name="email"><br><br>
			<label for="user">Password:</label>
			<input type="password" id="pass" name="pass"><br><br>
			<label for="user">Confirm Password:</label>
			<input type="password" id="confirm" name="confirm"><br><br>
			<input type="submit" value="Sign Up" name="signup" id="signup">
		</form>
	</div>

    <?php
    function secureInput($unsafeInput){
        $safeInput = htmlspecialchars($unsafeInput, ENT_QUOTES, 'UTF-8');
        return $safeInput;
    }
    ?>

</div>
</body>
</html>