<?php
/*
 *  * Class Database: interface to the movie database from PHP.
 *   *
 *    * You must:
 *     *
 *      * 1) Change the function userExists so the SQL query is appropriate for your tables.
 *       * 2) Write more functions.
 *        *
 *         */
class Database {
  private $host;
  private $userName;
  private $password;
  private $database;
  private $conn;

  /**
   *    * Constructs a database object for the specified user.
   *       */
  public function __construct($host, $userName, $password, $database) {
    $this->host = $host;
    $this->userName = $userName;
    $this->password = $password;
    $this->database = $database;
  }

  /** 
   *    * Opens a connection to the database, using the earlier specified user
   *       * name and password.
   *         *
   *           * @return true if the connection succeeded, false if the connection 
   *             * couldn't be opened or the supplied user name and password were not 
   *               * recognized.
   *                 */
  public function openConnection() {
    try {
      $this->conn = new PDO("mysql:host=$this->host;dbname=$this->database", 
        $this->userName,  $this->password,
        array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
      $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
      $error = "Connection error: " . $e->getMessage();
      print $error . "<p>";
      unset($this->conn);
      return false;
    }
    return true;
  }

  /**
   *    * Closes the connection to the database.
   *      */
  public function closeConnection() {
    $this->conn = null;
    unset($this->conn);
  }

  /**
   *    * Checks if the connection to the database has been established.
   *       *
   *         * @return true if the connection has been established
   *           */
  public function isConnected() {
    return isset($this->conn);
  }

  /**
   *    * Execute a database query (select).
   *       *
   *         * @param $query The query string (SQL), with ? placeholders for parameters
   *           * @param $param Array with parameters 
   *             * @return The result set
   *               */
  public function executeQuery($query, $param = null) {
    try {
      $stmt = $this->conn->prepare($query);
      $stmt->execute($param);
      $result = $stmt->fetchAll();
    } catch (PDOException $e) {
      $error = "*** Internal error: " . $e->getMessage() . "<p>" . $query;
      die($error);
    }
    return $result;
  }

  /**
   *    * Execute a database update (insert/delete/update).
   *       *
   *         * @param $query The query string (SQL), with ? placeholders for parameters
   *           * @param $param Array with parameters 
   *             * @return The number of affected rows
   *               */
  public function executeUpdate($query, $param = null) {
    try{
      $stmt = $this->conn->prepare($query);
      $stmt->execute($param);
      return $stmt->rowCount();
    } catch(PDOException $e) {
      $error = "*** Internal error: " . $e->getMessage() . "<p>" . $query;
      die($error);
    }
  }

  public function getLastId(){
    return $this->conn->lastInsertId();
  }

  /**
   *    * Check if a user with the specified user id exists in the database.
   *       * Queries the Users database table.
   *         *
   *           * @param userId The user id 
   *             * @return true if the user exists, false otherwise.
   *               */



  

  /*
  public function userExists($userId) {
    $sql = "select roomName from users where userName = ?";
    $result = $this->executeQuery($sql, array($userId));
    return count($result) == 1; 
  }
  
   public function userCheckLogin($userId, $userPw) {
    $sql = "select roomName from users where userName = ? AND userPassword = ?";
    $result = $this->executeQuery($sql, array($userId, $userPw));
    return count($result) == 1; 
  }
  
  public function getUserName($userId) {
    $sql = "select userName from users where userId = ?";
    $result = $this->executeQuery($sql, array($userId));
    return $result[0][0];
  }
  
  public function isAdmin($userId) {
    $sql = "select * from users where userName = ? AND userType = 'admin'";
    $result = $this->executeQuery($sql, array($userId));
    return count($result) == 1; 
  }
  
  public function getAdmins() {
    $sql = "select userName from users where userType = 'admin'";
    $result = $this->executeQuery($sql, array());
    return $result; 
  }
  
  public function getRoomsToReport($userId){
    $sql = "SELECT roomName FROM rooms WHERE roomType IN (select roomType from users natural join rooms where userName = ? ) AND private = 0 OR roomType = 'public' OR roomName = (select roomName from users where userName = ?);";
    $result = $this->executeQuery($sql, array($userId, $userId));
    return $result;   
  }
  
  public function getSeverities() {
  	$sql = "SELECT severityType FROM severity ORDER BY severityType DESC;";
    $result = $this->executeQuery($sql, array());
    return $result;   
  }
  
  public function getStatuses() {
  	$sql = "SELECT statusType FROM status;";
    $result = $this->executeQuery($sql, array());
    return $result;   
  }
  
  public function submitIssue($userId, $room, $title, $description, $severity){
  	$sql = "SELECT userId FROM users WHERE userName = ?;";
    $userrealid = $this->executeQuery($sql, array($userId));
	
  	$sql = "INSERT INTO issues (userId, title, description, severityType, roomName, issueDate) VALUES (?, ?, ?, ?, ?, CURDATE());";
    $result = $this->executeUpdate($sql, array($userrealid[0][0], $title, $description, $severity, $room));
    return count($result) == 1;  
  }
  
  public function getLatestIssueId(){
  	$sql = "SELECT issuesId FROM issues ORDER BY issuesId DESC LIMIT 1;";
	$result = $this->executeQuery($sql, array());
  	return $result[0][0];
  }
  
  public function updateIssue($issueId, $newSeverity, $newStatus, $newFixer, $newComments){
  	$sql = "UPDATE issues SET severityType=?, statusType=?, comments=?, fixerName=? WHERE issuesId=? AND active = 1;";
    $result = $this->executeUpdate($sql, array($newSeverity, $newStatus, $newFixer, $newComments, $issueId));
    return count($result) == 1;  
  }
  
  public function deleteIssue($issuesId){
  	$sql = "UPDATE issues SET active = 0 WHERE issuesId=?;";
    $result = $this->executeUpdate($sql, array($issuesId));
    return count($result) == 1;  
  }
  
  public function getIssues(){
    $sql = "SELECT issuesId, title, description, issues.roomName, userName, issueDate, severityType, statusType FROM users JOIN issues WHERE issues.userId = users.userId AND active = 1;";
    $result = $this->executeQuery($sql, array());
    return $result; 
  }
  
  public function getIssuesFromUser($userName){
  	$sql1 = "SELECT userId FROM users WHERE userName = ?;";
  	$result1 = $this->executeQuery($sql1, array($userName));
	$sql = "SELECT issuesId, title, description, issues.roomName, userName, issueDate, severityType, statusType FROM users JOIN issues WHERE issues.userId = ? AND userName = ? AND active = 1;";
    $result = $this->executeQuery($sql, array($result1[0][0], $userName));
    return $result; 
  }
  
  public function getIssue($issueId){
    $sql = "SELECT * FROM issues WHERE issuesId = ? and active = 1;";
    $result = $this->executeQuery($sql, array($issueId));
    return $result[0]; 
  }
  
  public function getUsers(){
    $sql = "select * from users";
    $result = $this->executeQuery($sql, array());
    return $result; 
  }
  
  public function getUser($userId){
    $sql = "SELECT * FROM users WHERE userId = ?;";
    $result = $this->executeQuery($sql, array($userId));
    return $result[0]; 
  }
  
  public function createUser($userName){
    $sql = "INSERT INTO users (userName) VALUES (?);";
    $result = $this->executeUpdate($sql, array($userName));
    return $result[0]; 
  }
  
  public function updateUser($userId, $newPassword, $newEmail, $newUserType, $newRoom){
  	$sql = "UPDATE users SET userPassword=?, userEmail=?, userType=?, roomName=? WHERE userId=?;";
    $result = $this->executeUpdate($sql, array($newPassword, $newEmail, $newUserType, $newRoom, $userId));
    return count($result) == 1;  
  }
  
  public function deleteUser($userId){
  	$sql = "DELETE FROM users WHERE userId=?;";
    $result = $this->executeUpdate($sql, array($userId));
    return count($result) == 1;  
  }
  
  public function getUserType(){
    $sql = "SELECT userType FROM usertype;";
    $result = $this->executeQuery($sql, array());
    return $result; 
  }
  
  public function getRooms(){
    $sql = "SELECT roomName FROM rooms ORDER BY roomName;";
    $result = $this->executeQuery($sql, array());
    return $result; 
  }
  
  
  public function getAllRooms(){
    $sql = "SELECT roomName, roomType, private FROM rooms ORDER BY roomName";
    $result = $this->executeQuery($sql, array());
    return $result; 
  }
  
  
  public function getRoom($roomName){
    $sql = "SELECT rooms.roomName, roomType, private, userId, userName FROM users, rooms WHERE rooms.roomName = ? ;";
    $result = $this->executeQuery($sql, array($roomName));
    return $result[0]; 
  }
  
  public function updateRoom($roomName, $newType, $newPrivate){
  	$sql = "UPDATE rooms SET roomType=?, private=? WHERE roomName=?;";
    $result = $this->executeUpdate($sql, array($newType, $newPrivate, $roomName));
    return count($result) == 1;  
  }
  
  public function deleteRoom($roomName){
  	$sql = "DELETE FROM rooms WHERE roomName=?;";
    $result = $this->executeUpdate($sql, array($roomName));
    return count($result) == 1;  
  }
  
  public function getRoomTypes(){
    $sql = "select * from roomtype";
    $result = $this->executeQuery($sql, array());
    return $result; 
  }
  
  public function createRoom($roomName, $roomType, $private){
    $sql = "INSERT INTO rooms (roomName, roomType, private) VALUES (?, ?, ?);";
    $result = $this->executeUpdate($sql, array($roomName, $roomType, $private));
    return count($result) == 1; 
  }
   
  

  public function getMovieNames() {
    $sql = "select title from movies";
    $result = $this->executeQuery($sql, array());

    $movies = array();
    foreach ($result as $res) {
      array_push($movies, $res[0]);
    }
    return $movies;
  }*/

  /**public function getPerformanceDates($movieTitle){
    $sql = "select pDate from performances where movieTitle=?";
    $result = $this->executeQuery($sql, array($movieTitle));

    $dates = array();
    foreach ($result as $res) {
      array_push($dates, $res[0]);
    }
    return $dates;  
  }*/

  /**public function getPerformance($movieTitle, $pDate){
    $sql = "select movieTitle, pDate, theaterName, availSeats from performances where movieTitle=? and pDate=? for update";
    $result = $this->executeQuery($sql, array($movieTitle, $pDate));

    $perf = array();
    for ($i = 0; $i < 4; $i++) {
      array_push($perf, $result[0][$i]);
    }
    return $perf; 

  }

  public function bookTicket($user, $performance){
    $this->conn->beginTransaction();
    $movieTitle = $performance[0];
    $pDate = $performance[1];
    $availSeats = $performance[3];
    $insert = "insert into Reservations(userName, movieTitle, pDate) values (?,?,?)";
    $update = "update performances set availSeats=? where movieTitle=? and pDate =?";
    $query = "select id from reservations order by id desc limit 1";
    $id = -1;
    if($availSeats >0){
      $nr1 = $this->executeUpdate($insert, array($user, $movieTitle, $pDate));
      if($nr1 == 1){
        $nr2 = $this->executeUpdate($update, array($availSeats-1, $movieTitle, $pDate));
        if($nr2 == 1){
          $idp = $this->executeQuery($query, array());
          $this->conn->commit();
          $id = (int)$idp[0][0];
        } else {
          $this->conn->rollback();
          return $id;
        }
      } else {
        $this->conn->rollback();
        return $id;
      }
    }
    return $id;
  }
*/

}
?>

