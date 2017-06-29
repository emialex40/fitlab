<?php
exit;

$__smtp = array(
    "host" => 'smtp.yandex.ru', // SMTP сервер
    "debug" => 2, // Уровень логирования
    "auth" => true, // Авторизация на сервере SMTP. Если ее нет - false
    "port" => '465', // Порт SMTP сервера
    "username" => 'fitlabstudio2017@yandex.ru', // Логин запрашиваемый при авторизации на SMTP сервере
    "password" => '8904361655', // Пароль
    "addreply" => 'fitlabstudio2017@yandex.ru', // Почта для ответа
    "secure" => 'ssl', // Тип шифрования. Например ssl или tls
    "mail_title" => 'ЛП fitlab-studio "Персональный тренинг"!', // Заголовок письма
    "mail_name" => 'fitlab-studio ' // Имя отправителя
); 




require  dirname(__FILE__) . '/lib/PHPMailer/PHPMailerAutoload.php';;
	
	


try{

    $mail = new PHPMailer(true); // Создаем экземпляр класса PHPMailer
	$mail->CharSet = 'UTF-8';
	$mail->isHTML(true);
    $mail->IsSMTP(); // Указываем режим работы с SMTP сервером
    $mail->Host       = $__smtp['host'];  // Host SMTP сервера: ip или доменное имя
    $mail->SMTPDebug  = $__smtp['debug'];  // Уровень журнализации работы SMTP клиента PHPMailer
    $mail->SMTPAuth   = $__smtp['auth'];  // Наличие авторизации на SMTP сервере
    $mail->Port       = $__smtp['port'];  // Порт SMTP сервера
    $mail->SMTPSecure = $__smtp['secure'];  // Тип шифрования. Например ssl или tls
    $mail->CharSet="UTF-8";  // Кодировка обмена сообщениями с SMTP сервером
    $mail->Username   = $__smtp['username'];  // Имя пользователя на SMTP сервере
    $mail->Password   = $__smtp['password'];  // Пароль от учетной записи на SMTP сервере
    $mail->AddAddress('sales@fitlab-studio.ru', 'John Doe');  // Адресат почтового сообщения
   
    $mail->AddReplyTo($__smtp['addreply'], 'First Last');  // Альтернативный адрес для ответа
    $mail->SetFrom($__smtp['username'], $__smtp['mail_title']);  // Адресант почтового сообщения
  

  
	$mail->Subject = 'Запись на персональную тренировку';
	
	$mail->Body = '
		<p>
				<strong>Дата:</strong> ' . date('d.m.Y H:i') . '
				<br><strong>Имя:</strong>  тест 				
				<br><strong>Телефон:</strong> тест 
				<br><strong>E-mail:</strong> тест'
		</p>
	';
    
    $mail->send();

    return 1;
	
	

  } catch (phpmailerException $e) {
	  
    return $e->errorMessage();
}

