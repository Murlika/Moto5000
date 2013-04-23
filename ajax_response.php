<?php
$mailto='';
$mail_types = array();
$mail_types['main'] = 'Заказ ';

//$mail_types['callback'] = 'Заказ обратного звонка';
//$mail_types['project_us'] = 'inga34kkto@gmail.com';

if ($_POST['type']) {
	if (array_key_exists($_POST['type'], $mail_types)) {
	//echo var_dump( $_POST);
	send_mail($mailto,$mail_types[$_POST['type']], $_POST);
	}
}


return true;

function send_mail($mail, $subject, $post){

	//echo var_dump($post);
	$headers = 'From: info@'.$_SERVER['HTTP_HOST'];
	$headers .= "\nContent-type: text/plain; charset=UTF-8";

	$text = $subject." на сайте ".$_SERVER['HTTP_HOST'].". \n\n";

	$text .= sprintf("Имя: %s\n", $post['contact_name']);
	$text .= sprintf("Телефон: %s\n", $post['contact_tel']);
	$text .= sprintf("Информация о заказе: %s\n", $post['comment']);

	mail($mail, '=?utf-8?B?'.base64_encode($subject).'?=', $text, $headers);
	//mail($mail, $subject, $text);
}
?>