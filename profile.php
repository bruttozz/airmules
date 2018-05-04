<!DOCYPE HTML>

<style>
.error {color: #FF0000;}<br /></style>

<strong>
<p style="color: gray; font-size: 15px;">To add your travel information to seek for a sender or search for a traveler matching your needs, please fill the required information in your profile.</p>
</strong>


[insert_php]

//session_start();
// define variables
//$username = wp_get_current_user();
//$username = get_current_user();
global $current_user;
get_currentuserinfo();
$firstname = $lastname = $user_email = $wechat_num =$biographical_info = "";
$firstnameErr = $lastnameErr = $emailErr = $wechatErr = $bioErr = "";
$noErr = True;
//$noErr = 0;
//global $sql;
global $wpdb;

if($_SERVER["REQUEST_METHOD"] == "POST") {
    if (is_user_logged_in()) {
        // firstname test
        if (empty($_POST["firstname"])) {
            $firstnameErr = "Please enter your firstname.";
            $noErr = False;
        }
        else {
//            $firstname = $_POST["firstname"];
            $firstname = test_data($_POST["firstname"]);
        }
        //lastname test
        if (empty($_POST["lastname"])) {
            $lastnameErr = "Please enter your lastname.";
            $noErr = False;
        }
        else {
//            $lastname = $_POST["lastname"];
            $lastname = test_data($_POST["lastname"]);
        }
        //user email test
        if (empty($_POST["email"])) {
            $emailErr = "Please enter your email.";
            $noErr = False;
        }
        else {
//            $user_email = $_POST["email"];
            $user_email = test_data($_POST["email"]);
        }
        //wechat test
        if (empty($_POST["wechat_num"])) {
            $wechatErr = "Please enter your Wechat number.";
            $noErr = False;
        }
        else {
//            $wechat_num = $_POST["wechat_num"];
            $wechat_num = test_data($_POST["wechat_num"]);
        }
        //bio test
        if (empty($_POST["biographical_info"])) {
            $bioErr = "Please write something about yourself!";
            $noErr = False;
        }
        else {
//            $biographical_info = $_POST["biographical_info"];
            $biographical_info = test_data($_POST["biographical_info"]);
        }

    }else{
        echo '<span style="color: red; font-size: 20px;"><strong>Please log in first!</strong></span>';
    }
}

if (isset($_POST["submit"]) AND $noErr){
   $table = $wpdb->prefix."wp_user";
   $uid = get_current_user_id();
   $wpdb->update(
      'wp_users',
      array(
         'first_name' => $firstname,
         'last_name' => $lastname,
         'user_email' => $user_email,
         'wechat_#' => $wechat_num,
         'biographical_info' => $biographical_info
      ),
      array(
          'ID' => $uid
      ),
      array(
//         '%d',
         '%s',
         '%s',
         '%s',
         '%s',
         '%s'
      ),
      array(
         '%d'
      )
   );
   $wpdb->print_error();

   echo "Posting success!";
  // echo $noErr;
}


function test_data($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

[/insert_php]


<form id="usrform" method="post">
<strong><p style="font-size: 20px; color: black;">Name</p>
</strong>

<!-- username -->
<strong>USERNAME：</strong>[insert_php] echo $current_user->display_name;[/insert_php]

<p>Usernames cannot be changed</p>

<!-- firstname -->
<strong>FIRST NAME：</strong><input name="firstname" type="text" />
<span class="error">* [insert_php] echo $firstnameErr;[/insert_php] </span>

<!-- lastname -->
<strong>LAST NAME：</strong><input name="lastname" type="text" />
<span class="error">* [insert_php] echo $lastnameErr;[/insert_php] </span>

<strong><p style="font-size: 20px; color: black;">Contact Info</p></strong>

<!-- user_email -->
<strong>Email：</strong><input name="email" type="email" />
<span class="error">* [insert_php] echo $emailErr;[/insert_php] </span>

<!-- wechat_# -->
<strong>Wechat number：</strong><input name="wechat_num" type="text" />
<span class="error">* [insert_php] echo $wechatErr;[/insert_php] </span>

<!-- biographical_info -->
<strong>Biographical info：</strong><textarea cols="50" form="usrform" name="biographical_info" rows="4">
</textarea>
<span class="error">* [insert_php] echo $bioErr;[/insert_php] </span>

<p>Biographical info function is not supported by "Internet Explorer" browser. Please use other browsers(Chrome, Firefox etc.). Sorry for the inconvenience.</p>

<input name="submit" type="submit" value="Submit information above" />

</form>

<strong><p style="color: black; font-size: 20px;">Feel free to upload your own profile picture!</p></strong>
[avatar_upload /]
