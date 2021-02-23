
<?php 
//=========================== QUERY FUNCTIONS ===========================//
function p_statement($query_string = "", $type = "", $vars = []) {
    global $conn;

    $query = mysqli_prepare($conn, $query_string);
    //assign $type to first index of $vars
    array_unshift($vars, $type);

    //Turn all values into reference since call_user_func_array
    //expects arguments of bind_param to be references
    //@see mysqli::bind_param() manpage
    foreach ($vars as $key => $value) {
        $vars[$key] =& $vars[$key];
    }

    call_user_func_array(array($query, 'bind_param'), $vars);
    $query->execute();
    confirmQuery($query);
    
    // INSERT, SELECT, UPDATE and DELETE have each 6 chars, you can
    // validate it using substr() below for better and faster performance
    if (strtolower(substr($query_string, 0, 6)) == "select") {
        $result = $query->get_result();
    } else {
        $result = $query->affected_rows;
    }

    $query->close();
    return $result;
}

  function query($query){
    global $conn;
    $result = mysqli_query($conn, $query);
    confirmQuery($result);
    return $result;
 }

function confirmQuery($result){
    global $conn;
    if (!$result) {
    die("query failed" . mysqli_error($conn));
    }
 }

  function fetchRecords($result){
    return mysqli_fetch_array($result);
 }

  function numRows($result){
    return mysqli_num_rows($result);
 }


//=========================== Simple functions just to get the mysqli_num_rows, they are not needed(becuase the prepare statement returns the rows), but i left them ===========================//

 function recordCount($table){
    global $conn;
    $sql = "SELECT * FROM $table";
    $result = mysqli_query($conn , $sql);

    confirmQuery($result);

    return $result = mysqli_num_rows($result); // we can just return this row

 }

  function recordCountStatement($table, $columnName, $comparer){
    global $conn;

    $sql = "SELECT * FROM $table WHERE $columnName = '$comparer'";
    $result = mysqli_query($conn , $sql);

    confirmQuery($result);

    return $result = mysqli_num_rows($result); // we can just return this row

 }

   function recordCountStatementAnd($table, $columnName, $comparer, $columnName1){
    global $conn;

    $sql = "SELECT * FROM $table WHERE $columnName = '$comparer' AND $columnName1 = '".$_SESSION['username']."' ";
    $result = mysqli_query($conn , $sql);

    confirmQuery($result);

    return $result = mysqli_num_rows($result); 

 }

 function allPostsUserComments(){
     $result = query("SELECT * FROM tbl_posts INNER JOIN tbl_comments ON tbl_posts.id = tbl_comments.com_p_id WHERE com_author = '".$_SESSION['username']."' ");
     return mysqli_num_rows($result);
 }

//=========================== USER CONFIRMATION FUNCTIONS ===========================//
 function isAdmin(){
    if(isLoggedIn()){
        $u_id = $_SESSION['id'];
        $result = query("SELECT u_role FROM tbl_users WHERE id = '$u_id'");
        $row = fetchRecords($result);

        if(isset($row['u_role']) == 'admin'){
            return true;
        } else{
            return false;
        }
    }
    return false;
 }

  function currentUser(){
    if(isset($_SESSION['username'])){
        return $_SESSION['username'];
    }
    return false;
 }


 function getUserName(){
    return isset($_SESSION['username']) ? $_SESSION['username'] : null;
 }


 function usernameExists($username){
    global $conn;
    $sql = "SELECT u_username FROM tbl_users WHERE u_username = '$username'";
    $result = mysqli_query($conn , $sql);

    confirmQuery($result);

    if(mysqli_num_rows($result) > 0){ // We know we found something, this is how we check
        return true;
    } else {
        return false;
    }

 }

 function isLoggedIn(){
    if(isset($_SESSION['u_role'])){
        return true;
    }

    return false;
 }

  function emailExists($email){
    global $conn;
    $sql = "SELECT u_email FROM tbl_users WHERE u_email = '$email'";
    $result = mysqli_query($conn , $sql);

    confirmQuery($result);

    if(mysqli_num_rows($result) > 0){ // We know we found something, this is how we check
        return true;
    } else {
        return false;
    }

 }

  function checkIfUserIsLoggedInAndRedirect($redirectLocation = null){
    if(isLoggedIn()){
        redirect($redirectLocation);
    }
 }

//=========================== GENERAL HELPERS ===========================//

function imagePlaceholder($image=''){
    if(!$image){
        return 'post_image_1.jpg';
    } else {
        return $image;
    }
}

 function redirect($location){

    header("Location:" . $location);
    exit;

 }

 function ifItIsMethod($method=null){
    if ($_SERVER['REQUEST_METHOD'] == strtoupper($method)) {
        return true;
    }
    return false;
 }


 function userLikedPost($p_id = ''){
    $u_id = loggedInUserId();
    $result = query("SELECT * FROM tbl_likes WHERE u_id = $u_id AND p_id = $p_id");
    confirmQuery($result);
    return mysqli_num_rows($result) >= 1 ? true : false;
 }

 function getPostlikes($p_id){
    $result = query("SELECT * FROM tbl_likes WHERE p_id = $p_id");
    confirmQuery($result);
    return mysqli_num_rows($result);
 }

  function loggedInUserId(){
    if(isLoggedIn()){
        $u_username = $_SESSION['username']; // HOW TO PUT THAT IN ???????
        $result = query("SELECT * FROM tbl_users WHERE u_username = '$u_username'");
        confirmQuery($result);
        $user = mysqli_fetch_array($result);
        return mysqli_num_rows($result) >= 1 ? $user['id'] : false; 

    }
    return false;
 }


//=========================== USER RELATED FUNCTIONS ===========================//


 function registerUser($u_username, $u_email, $u_password){

        global $conn;

        $u_username = mysqli_real_escape_string($conn, $u_username);
        $u_email = mysqli_real_escape_string($conn, $u_email);
        $u_password = mysqli_real_escape_string($conn, $u_password);


        $u_password = password_hash($u_password, PASSWORD_BCRYPT, array('cost' => 12));

        $query = "INSERT INTO tbl_users (u_username,u_password, u_email, u_role) VALUES ('$u_username','$u_password', '$u_email' , 'subscriber')";

        $result = mysqli_query($conn , $query);

        confirmQuery($result);
    

 }

 function loginUser($u_username, $u_password){

        global $conn;

        $u_username = trim($u_username);
        $u_password = trim($u_password);


        $u_username = mysqli_real_escape_string($conn , $u_username);
        $u_password = mysqli_real_escape_string($conn , $u_password);

        $sql = "SELECT * FROM tbl_users WHERE u_username = '$u_username'";
        $query = $conn->query($sql);

        confirmQuery($query);

        while($row = $query->fetch_assoc()) {
            $username = $row['u_username']; // from the database:
            $id = $row['id'];
            $password = $row['u_password'];
            $f_name = $row['u_f_name'];
            $l_name = $row['u_l_name'];
            $role = $row['u_role'];
            $email = $row['u_email'];

            if (password_verify($u_password, $password)){
            

            $_SESSION['username'] = $username;
            $_SESSION['u_f_name'] = $f_name;
            $_SESSION['u_l_name'] = $l_name;
            $_SESSION['u_email'] = $email;
            $_SESSION['u_password'] = $password;
            $_SESSION['u_role'] = $role;
            $_SESSION['id'] = $id;

            redirect("/cms/admin/dashboard.php");

        } else{
            return false;
        }

    }

 }

function usersOnline(){

        if(isset($_GET['usersonline'])){

            // ONLINE USERS COUNTER
        
        // global $conn; // this connection is not going to work, because the db is not included in functions.php

        session_start(); // we don't even have a session, because again it is not here
        include("../includes/connection.php");

        $session = session_id(); // session for the persons ID
        $time = time(); // current time
        $time_out_in_seconds = 60; 
        $time_out = $time - $time_out_in_seconds; // gives us the timeout variable that we need
        // if 60 seconds pass after the user has been in that page he goes offline
        // the smaller the timer the faster it is

        $sql = "SELECT * FROM tbl_users_online WHERE u_session = '$session'";
        $result = mysqli_query($conn , $sql);

        if (!$result) {
        die("query failed" . mysqli_error());    
        }

        $count = mysqli_num_rows($result);


        if($count == NULL || $count == 0){
            mysqli_query($conn, "INSERT INTO tbl_users_online (u_session, u_time) VALUES ('$session','$time')");
            // If the user just logged in(we have his id), we insert his session and time in the table
            // New user
        } else{ 
            // IF the user in not new, if $count is anything else than NULL, the user has been there
            // We keep track of the user with time
            mysqli_query($conn, "UPDATE tbl_users_online SET u_time = '$time' WHERE u_session = '$session' ");
            // $session = the current user

        }

        // We display the user count based on how many seconds they have been on the site

        $users_online = mysqli_query($conn, "SELECT * FROM tbl_users_online WHERE u_time > '$time_out' ");
        // If the user is on the website and his time is bigger than $time_out he goes offline
        echo $u_count = mysqli_num_rows($users_online); // we remove the return, because we don't catch it anywhere

    } // get request js isset

}
usersOnline();



 ?>

