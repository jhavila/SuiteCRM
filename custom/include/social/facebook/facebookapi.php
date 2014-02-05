<?php
require_once("custom/include/social/facebook/facebook.class.php");

$facebook_helper = new facebook_helper();
//get current user logged in
$user = $facebook_helper->facebook->getUser();
//get requested user data.
$different_user = $facebook_helper->get_facebook_user($_REQUEST['username']);
//get the last XX posted.
$content = ($facebook_helper->get_other_newsfeed($_REQUEST['username'], "50"));

//check the user is logged in and generate the correct url if logged in or not.
if ($user) {
    $logoutUrl = $facebook_helper->get_logout_url();
} else {
    $loginUrl = $facebook_helper->get_login_url($_REQUEST['url']);
}

if ($user){
    $log = '<a href="' . $logoutUrl . '">Logout</a>';
}else{
    $log = '<a href="' . $loginUrl .'">Login with Facebook</a>';
}
$html .= "<link rel='stylesheet' type='text/css' href='custom/include/social/social.css'>";
$html .= "<tr><td style='padding:5px'><img src=https://graph.facebook.com/" . $different_user['username'] . "/picture>";
$html .= "<b style='margin-left:5px; font-size:20px;'>".$different_user['name'] ."</b></td></tr>";
$html .= "<div style='height:400px;overflow:scroll; padding-left: 35px;padding-top:10px;'><table width='100%'>";

$html .= "</table>";



foreach($content['data'] as $story){

    if(!empty($results)){
        $html . $results;
    }
}

foreach($content['data'] as $story){

    if($story['type'] != 'link' && $story['type'] != 'video' && $story['type'] != 'photo'){
        if(isset($story['story']) || isset($story['message'])){
        $results =  $facebook_helper->process_feed($story);
        }
    }
            $html .=  "<p>". $results."</p>";


}
echo $html;