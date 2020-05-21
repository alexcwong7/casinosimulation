<?php
//ob_start();
	include 'DatabaseAdapter.php';
	session_start();

	$theDBA = new DatabaseAdaptor();
	
	// REGISTRATION
	unset($_SESSION['registerError'] );
	if(isset($_POST['usernameReg']) && isset($_POST['passwordReg'])
			&& isset($_POST['firstname']) && isset($_POST['lastname'])) {
		
		if(htmlspecialchars($_POST['usernameReg']) != $_POST['usernameReg'])
		return;
				
		// Grab username from database
		$userReg = [];
		$userReg = $theDBA->getUserCredentials(htmlspecialchars($_POST['usernameReg']));
		
		// Check if username exists in the database
		if(count($userReg) != 0) {
			$_SESSION['registerError'] = 'Failed: account name already exists.';
			header('Location: register.php');
		}
		// Otherwise insert new registration details into database
		else {
			$theDBA->registerUser(htmlspecialchars($_POST['usernameReg']),  htmlspecialchars(password_hash($_POST['passwordReg'], PASSWORD_DEFAULT)),
					htmlspecialchars($_POST['firstname']), htmlspecialchars($_POST['lastname']));
			$_SESSION['user'] = htmlspecialchars($_POST['usernameReg']);
			header('Location: index.php');
		}
	}
	
	// LOGIN
	unset($_SESSION['loginError']);
	if(isset($_POST['usernameLogin']) && isset($_POST['passwordLogin'])) {
		// Grab username and password from database
		$userLogin = [];
		$userLogin = $theDBA->getUserCredentials(htmlspecialchars($_POST['usernameLogin']));
		
		// Check if username exists in the database
		if(count($userLogin) != 0) {
			// Check if password matches
			if(strtolower($userLogin[0]['username']) == strtolower($_POST['usernameLogin']) && password_verify($_POST['passwordLogin'], $userLogin[0]['hash'])) {
				$_SESSION['user'] = htmlspecialchars($_POST['usernameLogin']);
				header('Location: index.php');
			}
			// Otherwise invalid login
			else {
				$_SESSION['loginError'] = 'FAILED: invalid credentials.';
				header('Location: login.php');
			}
		}
		// Otherwise invalid username
		else {
			$_SESSION['loginError'] = 'FAILED: invalid credentials.';
			header('Location: login.php');
		}
	}
	
	// HEADER ACCOUNT INFO
	if(isset($_GET['info'])) {
		$arr = $theDBA->getUserInfo(htmlspecialchars($_SESSION['user']));
		$_SESSION['balance'] = $arr[0]['balance'];
		echo json_encode($arr);
	}
	
	// LEADERBOARD
	if(isset($_GET['leaderboard'])) {
		$arr = $theDBA->getLeaderboard();
		echo json_encode($arr);
	}
	
	//PROFILE
	if(isset($_GET['profile']))
	{
		$profile = htmlspecialchars($_GET['profile']);
		$arr = $theDBA->getProfile($profile);
		$str = '<hr><br><h1 id="profileHeader">' . $arr[0]['username'] . '</h1><br><p id="name" class="profileinfo">Name: '
				. $arr[0]['firstname'] . ' ' . $arr[0]['lastname'] . '</p><br><hr>';
		
		echo $str;
	}
	
	//WALL
	if(isset($_GET['wall']))
	{
		$profile = htmlspecialchars($_GET['wall']);
		$arr = $theDBA->getWall($profile);
		$hasposts = false;
		
		if($arr != null)
		{
			$str = "<div class='wallPosts'>WALL POSTS:</div><br><hr><br>";
			
			for($i=0; $i<count($arr); $i++)
			{
				if($arr[$i]['flagged'] == 0)
				{
					$str = $str . '<div class="message">"' . $arr[$i]['text'] . '"</div>'
							. 'by: <a href="profile.php?profile=' . $arr[$i]['fromuser'] . '" class="profileLink">' . $arr[$i]['fromuser'] . '</a>' 
							. "<br>" . $arr[$i]['postdate'] . "<br>"
							. '<button type="button" class="votebutton" onclick="addOne(' . $arr[$i]['postid'] . ', \'' . $profile . '\')">+</button> '
							. $arr[$i]['rating'] . ' <button type="button" class="votebutton" onclick="subOne(' . $arr[$i]['postid'] . ', \'' . $profile . '\')">-</button><br>';
							
					if($_SESSION['user'] == $profile)
					{
						$str = $str . '<br><button type="button" onclick="flag(' . $arr[$i]['postid'] . ', \'' . $profile . '\')">Delete Comment</button></div><br>';
					}
							
					$str = $str	. "<br><hr><br>";
					$hasposts = true;
				}
			}
		}
		
		if ($hasposts == false) //All posts on profile were flagged or no posts exist for this user
		{
			$str = "<div class='wallPosts'>WALL POSTS:</div><hr><br>Nothing interesting here yet. Make a new post!<br><br><hr><br>";
			
			if($_SESSION['user'] == $profile)
			{
				$str = "<div class='wallPosts'>WALL POSTS:</div><hr><br>Nothing to see here. Get some friends to post on your wall!<br><br><hr><br>";
			}
		}
		
		$str = $str . PHP_EOL . '<form onsubmit="newpost(\'' . $profile . '\'); return false;">
			<div class="addComment">ADD A COMMENT:</div><br><textarea rows="4" cols="50" id="thepost" name="thepost" class="commentarea" required pattern=".{1,}"></textarea><br>
			<input type="submit" name="submission" id="submit" value="Post">
			</form><br>';
		
		echo $str;
	}
	
	//NEW POST
	if (isset($_GET["thepost"]))
	{
		$profile = htmlspecialchars($_GET['toUser']);
		$getUserID = new DatabaseAdaptor();
		$arr = $getUserID->getuserid($profile);
		$userid = $arr[0]['id'];
		
		$post = htmlspecialchars($_GET["thepost"]);
		$author = htmlspecialchars($_SESSION['user']);
		$theDBA = new DatabaseAdaptor();
		$theDBA->newpost($post, $author, $userid);
	}
	
	
	//POSTRATINGANDFLAGGING
	if(isset($_GET["arg"]))
	{
		$argument = $_GET["arg"];
		if ($argument === "rateUp")
		{
			$id = htmlspecialchars($_GET["id"]);
			$theDBA = new DatabaseAdaptor();
			echo json_encode($theDBA->addOne($id));
		}
		else if ($argument === "rateDown")
		{
			$id = htmlspecialchars($_GET["id"]);
			$theDBA = new DatabaseAdaptor();
			echo json_encode($theDBA->subOne($id));
		}
		else if ($argument === "flag")
		{
			$id = htmlspecialchars($_GET["id"]);
			$theDBA = new DatabaseAdaptor();
			echo json_encode($theDBA->flag($id));
		}
	}
	
	// LOGOUT
	if(isset($_POST['logout'])) {
		session_destroy();
		header('Location: register.php');
	}
	
	// ADD BALANCE
	if(isset($_GET['addBalance'])) {
		$theDBA->addBalance($_GET['addBalance'], $_SESSION['user']);
	}
	
	// SUBTRACT BALANCE
	if(isset($_GET['subtractBalance'])) {
		$theDBA->subtractBalance($_GET['subtractBalance'], $_SESSION['user']);
	}
	
	// RESET BALANCE
	if(isset($_GET['resetBalance'])) {
		$theDBA->resetBalance($_SESSION['user']);
	}
	
	// MEMBERS
	if(isset($_GET['members'])) {
		$arr = $theDBA->getMembers();
		echo json_encode($arr);
	}
	
	//FRIENDS
	if(isset($_GET['friendsof']))
	{
		$profile = htmlspecialchars($_GET['friendsof']);
		$arr = $theDBA->getFriends($profile);
		
		$str = "Friends List:<br><hr><br>";
		$alreadyfriend = false;
		
		if($arr != null)
		{
			
			
			for($i=0; $i<count($arr); $i++)
			{
				$arrfriendusername = $theDBA->getusername($arr[$i]['fromid']);
				$friendusername = $arrfriendusername[0]['username'];
				
				$str = $str . '<a class="profileLink" href="profile.php?profile=' . $friendusername. '">' . $friendusername . '</a>'
						. '<br>';
						
						if($_SESSION['user'] == $profile)
						{
							$str = $str . '<button type="button" class="friendBtn" onclick="removeFriendOnProfile(\'' . $friendusername . '\')">Remove Friend</button><br><br>';
						}
						else
						{
							$str = $str . '<br>';
						}
						
						if($_SESSION['user'] == $friendusername)
						{
							$alreadyfriend = true;
						}
						
			}
		}
		//if not on own profile and not already friend, display add friend button.
		if($_SESSION['user'] != $profile && !($alreadyfriend) && $profile != 'undefined') //someone with the username 'undefined' is going to be unhappy.
		{
			$str = $str . '<hr><br><button type="button" class="friendBtn" onclick="addFriend(\'' . $profile . '\')">Add Friend</button><br><br>';
		}
		if($alreadyfriend)
		{
			$str = $str . '<hr><br><button type="button" class="friendBtn" onclick="removeFriend(\'' . $profile . '\')">Unfriend ' . $profile . '</button><br><br>';
		}
		
		echo $str;
	}
	
	//ADD FRIEND
	if(isset($_GET['addfriend']))
	{
		$profile = htmlspecialchars($_GET['addfriend']);
		$arr1 = $theDBA->getuserid($profile);
		$f1id = $arr1[0]['id'];
		$arr2 = $theDBA->getuserid($_SESSION['user']);
		$f2id = $arr2[0]['id'];
		
		$theDBA->addFriend($f1id, $f2id);
		$theDBA->addFriend($f2id, $f1id);
		return;
	}
	//REMOVE FRIEND
	if(isset($_GET['removefriend']))
	{
		$profile = htmlspecialchars($_GET['removefriend']);
		$arr1 = $theDBA->getuserid($profile);
		$f1id = $arr1[0]['id'];
		$arr2 = $theDBA->getuserid($_SESSION['user']);
		$f2id = $arr2[0]['id'];
		
		$theDBA->removeFriend($f1id, $f2id);
		$theDBA->removeFriend($f2id, $f1id);
		return;
	}
	
	// CHAT
	if(isset($_POST['text'])) {
		$text = $_POST['text'];
		
		$fp = fopen("logs/chatlog.txt", 'a');
		fwrite($fp, "<div class='msgln'><b class='user'>".$_SESSION['user']."</b>: ".htmlspecialchars($text)."<br></div>\n");
		fclose($fp);
		
		$file="logs/chatlog.txt";
		$linecount = 0;
		$handle = fopen($file, "r");
		while(!feof($handle)){
			$line = fgets($handle);
			$linecount++;
		}
		
		fclose($handle);
		
		// Delete old lines when reach maximum limit
		if($linecount > 50) {
			$lines = file("logs/chatlog.txt");
			$str = "";
			$boo = false;
			foreach($lines as $line) {
				if($boo == false) {
					$boo = true;
				}
				else {
					$str .= $line;
				}
			}
			
			file_put_contents("logs/chatlog.txt", $str);
		}
		
	}
	
?>