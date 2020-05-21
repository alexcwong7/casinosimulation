<?php
class DatabaseAdaptor {
	private $DB; // The instance variable used in every function
	public function __construct() {
		$db = 'mysql:dbname=csc337finalprojectdb; host=127.0.0.1; charset=utf8';
		$user = 'root';
		$password = ''; // an empty string
		try {
			$this->DB = new PDO ( $db, $user, $password );
			$this->DB->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
		} catch ( PDOException $e ) {
			echo ('Error establishing Connection');
			exit ();
		}
	}
	
	// Insert registration details
	public function registerUser($user, $hashedPass, $firstname, $lastname) {
		$stmt = $this->DB->prepare ( "INSERT INTO users (username,hash,firstname,lastname,date) VALUES (:theUser,:theHash,:theFirst,:theLast,NOW());" );
		$stmt->bindParam(':theUser', $user);
		$stmt->bindParam(':theHash', $hashedPass);
		$stmt->bindParam(':theFirst', $firstname);
		$stmt->bindParam(':theLast', $lastname);
		$stmt->execute();
	}
	
	// Return username and password
	public function getUserCredentials($user) {
		$stmt = $this->DB->prepare ( "SELECT username,hash FROM users WHERE username=:theUser;" );
		$stmt->bindParam(':theUser', $user);
		$stmt->execute();
		return $stmt->fetchAll ( PDO::FETCH_ASSOC );
	}
	
	// Return users balance
	public function getBalance($user) {
		$stmt = $this->DB->prepare ( "SELECT balance FROM users WHERE username=:theUser;" );
		$stmt->bindParam(':theUser', $user);
		$stmt->execute();
		return $stmt->fetchAll ( PDO::FETCH_ASSOC );
	}
	
	// Return users info
	public function getUserInfo($user) {
		$stmt = $this->DB->prepare ( "SELECT id,username,balance, "
								   . "FIND_IN_SET(balance,(SELECT GROUP_CONCAT(balance ORDER BY balance DESC) FROM users))"
								   . "AS rank FROM users WHERE username=:theUser;" );
		$stmt->bindParam(':theUser', $user);
		$stmt->execute();
		return $stmt->fetchAll ( PDO::FETCH_ASSOC );
	}
	
	// Return all users info
	public function getMembers() {
		$stmt = $this->DB->prepare ( "SELECT id,username,balance, "
								   . "FIND_IN_SET(balance,(SELECT GROUP_CONCAT(balance ORDER BY balance DESC) FROM users))"
								   . "AS rank FROM users" );
		$stmt->execute();
		return $stmt->fetchAll ( PDO::FETCH_ASSOC );
	}
	
	// Increase balance
	public function addBalance($value, $user) {
		$stmt = $this->DB->prepare ( "UPDATE users SET balance = balance + :theValue WHERE username=:theUser;" );
		$stmt->bindParam(':theValue', $value);
		$stmt->bindParam(':theUser', $user);
		$stmt->execute();
	}
	
	// Subtract balance
	public function subtractBalance($value, $user) {
		$stmt = $this->DB->prepare ( "UPDATE users SET balance = balance - :theValue WHERE username=:theUser;" );
		$stmt->bindParam(':theValue', $value);
		$stmt->bindParam(':theUser', $user);
		$stmt->execute();
	}
	
	// Reset balance
	public function resetBalance($user) {
		$stmt = $this->DB->prepare ( "UPDATE users SET balance = 0 WHERE username=:theUser;" );
		$stmt->bindParam(':theUser', $user);
		$stmt->execute();
	}
	
	// Return leaders
	public function getLeaderboard() {
		$stmt = $this->DB->prepare( "SELECT * FROM users ORDER BY balance DESC LIMIT 10;" );
		$stmt->execute();
		return $stmt->fetchAll ( PDO::FETCH_ASSOC );
	}
	
	// Get profile
	public function getProfile($profile) {
		$stmt = $this->DB->prepare( "SELECT username, firstname, lastname, date FROM users WHERE username = :theProfile;" );
		$stmt->bindParam(':theProfile', $profile);
		$stmt->execute();
		return $stmt->fetchAll ( PDO::FETCH_ASSOC );
	}
	
	// Get wall
	public function getWall($profile) {
		$stmt = $this->DB->prepare( "SELECT posts.text, posts.fromuser, posts.postdate, posts.flagged, posts.rating, posts.postid FROM users JOIN posts ON users.id = posts.toid WHERE username = :theProfile;" );
		$stmt->bindParam(':theProfile', $profile);
		$stmt->execute();
		return $stmt->fetchAll ( PDO::FETCH_ASSOC );
	}
	
	//Upvote a post
	public function addOne ($id) {
		$stmt = $this->DB->prepare( "UPDATE posts SET rating = rating + 1 WHERE postid = :theID;");
		$stmt->bindParam(':theID', $id);
		$stmt->execute ();
		return $stmt->fetchAll( PDO::FETCH_ASSOC );
	}
	//Downvite a post
	public function subOne ($id) {
		$stmt = $this->DB->prepare( "UPDATE posts SET rating = rating - 1 WHERE postid = :theID;");
		$stmt->bindParam(':theID', $id);
		$stmt->execute ();
		return $stmt->fetchAll( PDO::FETCH_ASSOC );
	}
	//Hide a post/Delete a post by flagging
	public function flag ($id) {
		$stmt = $this->DB->prepare( "UPDATE posts SET flagged = 1 WHERE postid = :theID;");
		$stmt->bindParam(':theID', $id);
		$stmt->execute ();
		return;
	}
	//New Post
	public function newpost($text, $author, $toid)
	{
		echo $toid;
		$stmt = $this->DB->prepare( "INSERT into posts (postdate, text, toid, flagged, rating, fromuser) values(NOW(), :theText, :theToID, 0, 0, :theAuthor);");
		$stmt->bindParam(':theText', $text);
		$stmt->bindParam(':theAuthor', $author);
		$stmt->bindParam(':theToID', $toid);
		$stmt->execute ();
		return;
	}
	
	//Get user id
	public function getuserid($username)
	{
		$stmt = $this->DB->prepare( "SELECT id FROM users WHERE username=:theUsername;");
		$stmt->bindParam(':theUsername', $username);
		$stmt->execute ();
		return $stmt->fetchAll( PDO::FETCH_ASSOC );
	}
	
	//Get username from id
	public function getusername($userid)
	{
		$stmt = $this->DB->prepare( "SELECT username FROM users WHERE id=:theUserId;");
		$stmt->bindParam(':theUserId', $userid);
		$stmt->execute ();
		return $stmt->fetchAll( PDO::FETCH_ASSOC );
	}
	//Get friends of username
	public function getFriends($username)
	{
		$stmt = $this->DB->prepare( "SELECT friends.fromid FROM users JOIN friends ON users.id = friends.toid WHERE username = :theUsername;" );
		$stmt->bindParam(':theUsername', $username);
		$stmt->execute();
		return $stmt->fetchAll ( PDO::FETCH_ASSOC );
	}
	//Add friend
	public function addFriend($profileid, $friendid)
	{
		$stmt = $this->DB->prepare( "INSERT INTO friends (toid, fromid, addDate) values(:theProfileId, :theFriendId, NOW());" );
		$stmt->bindParam(':theProfileId', $profileid);
		$stmt->bindParam(':theFriendId', $friendid);
		$stmt->execute();
		return;
	}
	//Remove friend
	public function removeFriend($profileid, $friendid)
	{
		$stmt = $this->DB->prepare( "DELETE FROM friends WHERE toid = :theProfileId AND fromid = :theFriendId;" );
		$stmt->bindParam(':theProfileId', $profileid);
		$stmt->bindParam(':theFriendId', $friendid);
		$stmt->execute();
		return;
	}

	
} // End class DatabaseAdaptor

/*
$theDBA = new DatabaseAdaptor ();
$profile = 'AlwaysAnswersAnson';
$getUserID = new DatabaseAdaptor();
$arr = $getUserID->getuserid($profile);
$userid = $arr[0]['id'];

echo $userid;
echo PHP_EOL . $profile . PHP_EOL;
print_r($arr);


$post = 'CLI TEST4';
$author = 'MikeySux2';
$theDBA = new DatabaseAdaptor();
$theDBA->newpost($post, $author, $userid);
*/

?>

