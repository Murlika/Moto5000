<?php
$mailto='info@moto500.ru';
//$mailto='murlika11@gmail.com';
$mail_types = array();
$mail_types['main'] = 'Заказ обратного звонка';
$mail_types['main2'] = 'Заказ каталога';


//$mail_types['callback'] = 'Заказ обратного звонка';
//$mail_types['project_us'] = 'inga34kkto@gmail.com';

if ($_POST['type']) {
	if (array_key_exists($_POST['type'], $mail_types)) {
	//echo var_dump( $_POST);
	send_mail($mailto,$mail_types[$_POST['type']], $_POST);
	//send_mail2($mailto,'info@'.$_SERVER['HTTP_HOST'],'Admin',$mail_types[$_POST['type']], $_POST['comment']);
	}
}


return true;

function send_mail($mailto, $subject, $post,$file_name=''){
    $bound = "*****SendMail*****";
	//echo var_dump($post);
	$headers = 'From: info@'.$_SERVER['HTTP_HOST'];
	$headers .= "\nContent-type: multipart/mixed;  boundary=\"".$bound."\"";

	$text = "\n\n--$bound\n";
	$text .= "Content-type: text/html; charset=\"UTF-8\"\n";

    $text .="\n\n<br>";
	$text .=sprintf($subject." на сайте ".$_SERVER['HTTP_HOST'].". <br>");
    $text .= sprintf("<br>Имя: %s", $post['fio']);
	$text .= sprintf("<br>Телефон: %s\n", $post['tel']);
    $text .= sprintf("<br>Email: %s\n", $post['email']);
	$text .= sprintf("<br>Информация о заказе: %s\n<br>", $post['comment']);

    $ret=mail($mailto, $subject, $text, $headers);


     // Проверяем, есть ли файлы вложений
    if ($ret && $_POST['type']=='main2' )
        {
        $text = "\n\n--$bound\n";
		$text .= "Content-type: text/html; charset=\"UTF-8\"\n";

	    $text .="\n\n<br>";
		$text .=sprintf($subject." на сайте ".$_SERVER['HTTP_HOST'].". <br>");

        $value = 'files/price.xls';

	  if ($value)
    	{
        $fp = fopen($value,"rb");
        $file = fread($fp, filesize($value));
        fclose($fp);
	    }

            {
                $text .= "\n\n--$bound\n";
                $text .= 'Content-Type: application/octet-stream; name="'.basename($value).'"'."\n";
                $text .= "Content-Transfer-Encoding:base64\n";
                $text .= "Content-Disposition:attachment; filename=\"".basename($value)."\"\n\n";
 				$text .=  chunk_split(base64_encode($file));
                $text .= "\n\n--$bound\n";

           }

       $ret=mail( $post['email'], $subject, $text, $headers);
         }

     return $ret;
//	mail($mail, '=?utf-8?B?'.base64_encode($subject).'?=', $text, $headers);
//
//        if ($_POST['type']=='main2') {
//
//            mail($post['email'], '=?utf-8?B?'.base64_encode($subject).'?=', $text, $headers);
//        }

        //mail($mail, $subject, $text);
}



?>