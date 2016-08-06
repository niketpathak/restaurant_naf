<?php
/**
 * Created by PhpStorm.
 * User: niketpathak
 * Date: 31/07/16
 * Time: 23:04
 */

//decode json encoded post data
$params = json_decode(file_get_contents('php://input'),true);
//print_r($params);
$output = array("res"=>0, "msg"=>"Missing Input");     //output array

//check for empty post paramters
if(empty($params["name"]) || empty($params["email"]) || empty($params["sub"])) {
    exit(json_encode($output));
}

//Valide email
if (!filter_var($params["email"], FILTER_VALIDATE_EMAIL)) {
    $output["msg"] = "Invalid Email Address";
    exit(json_encode($output));
}

require_once 'wp-content/themes/angular-bootstrap/lib/PHPMailer/PHPMailerAutoload.php';
$message = file_get_contents("wp-content/themes/angular-bootstrap/lib/email_template/template.html");
$message = str_ireplace("{%sender_email%}", $params["email"],$message);
$message = str_ireplace("{%sender_subject%}", $params["sub"],$message);
$message = str_ireplace("{%sender_name%}", htmlspecialchars($params["name"]),$message);
$message = str_ireplace("{%sender_msgg%}", htmlspecialchars($params["msg"]),$message);

//echo $message;


$mailsubject = "EscaleIndienne:".$params["sub"];
$rec_email = 'niketpathak89@gmail.com';
$array_content=array("post_email" => $params["email"], "post_name" => $params["name"], "msg" => $message);
$res = send_a_mail($array_content, $rec_email, $mailsubject);

if ($res) {
    $output["res"] = "1";
    $output["msg"] = "Thank you for contacting us. We will revert to you ASAP.";
} else {
    $output["msg"] = "Error. Server Temporarily Unavailable";

}

exit(json_encode($output));








function send_a_mail($var_array, $destinationmail, $mailsubject) {
    $mail = new PHPMailer();
//	$mail->SMTPDebug = true;	    // uncomment to diagnose errors
    $mail->IsSMTP();
    $mail->Host 	= "localhost";   //  ssl://smtp.gmail.com
    $mail->From 	= ('' != $var_array["post_email"]) ? $var_array["post_email"] : "admin@escaleindienne.com";
    $mail->FromName = ('' != $var_array["post_name"]) ? $var_array["post_name"] : "EscaleIndienne Contant";
    $mail->CharSet = "UTF-8";
    $mail->AddAddress($destinationmail);	//recepient email comes here!
    $mail->IsHTML(true);
    $mail->Subject = $mailsubject;

    $mail->Body=$var_array["msg"];
    if ( ! $mail->Send())
    {
        $result = $mail->ErrorInfo;
    }
    else
    {
        $result = TRUE;
    }

    return $result;
}
