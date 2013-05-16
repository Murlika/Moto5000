<?php
$mailto='info@moto500.ru';
//$mailto='anzhela42@cheb-site.net';
$mail_types = array();
$mail_types['main'] = 'Заказ обратного звонка';
$mail_types['main2'] = 'Заказ каталога';

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

	$text .= sprintf("Имя: %s\n", $post['fio']);
	$text .= sprintf("Телефон: %s\n", $post['tel']);
        $text .= sprintf("Email: %s\n", $post['email']);
	$text .= sprintf("Информация о заказе: %s\n", $post['comment']);


	mail($mail, '=?utf-8?B?'.base64_encode($subject).'?=', $text, $headers);

        if ($_POST['type']=='main2') {

            mail($post['email'], '=?utf-8?B?'.base64_encode($subject).'?=', $text, $headers);
        }

        //mail($mail, $subject, $text);
}


/*

$to - адрес получателя письма

$from_mail - адрес отправителя письма

$from_name - имя отправителя письма

$subject - тема письма

$message - само сообщение в HTML-формате

$file_name - массив имен файлов, которые надо прикрепить к письму

$from_mail = "ivanov@mail.ru";

$from_name = "Иванов";

$to = "petrov@mail.ru";

$files = array("1.gif", "2.gif");



$subject = "Письмо с вложением";

$msg = "<h1>Это сообщение в формате HTML</h1>";



send_mail($to, $from_mail, $from_name, $subject, $msg, $files);
*/

function send_mail2($to, $from_mail, $from_name, $subject, $message, $file_name)

{

    $from_name = "=?koi8-r?B?".base64_encode(convert_cyr_string($from_name, "w","k"))."?=";

    $bound = "*****SendMail*****";

    $headers = "From: ".$from_name." <".$from_mail.">\\n";

    // $headers .= "To: $to\\n";

    $headers .= "Subject: $subject\\n";

    $headers .= "Mime-Version: 1.0\\n";

    $headers .= "Content-Type: multipart/mixed; boundary=\\"".$bound."\\"";

    $body = "\\n\\n--$bound\\n";

    $body .= "Content-type: text/html; charset=\"windows-1251\\"\\n";

    $body .= "Content-Transfer-Encoding: quoted-printable\\n\\n";

    $body .= $message;

    // Проверяем, есть ли файлы вложений

    if ( is_array($file_name) )

    {

        foreach ( $file_name as $value )

        {

            if($file = fopen($value,"rb"))

            {

                $body .= "\\n\\n--$bound\\n";

                $body .= "Content-Type: application/octet-stream; ";

                $body .= "name=\"".basename($value)."\\"\\n";

                $body .= "Content-Transfer-Encoding:base64\\n";

                $body .= "Content-Disposition:attachment\\n\\n";

                $body .= base64_encode(fread($file,filesize($value)));

            }

        }

    }

    $body .= "\\n\\n--$bound--\\n\\n";



    if( mail($to, $subject, $body, $headers) )

        return true;

    else

        return false;

};
?>