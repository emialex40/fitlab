<?php

define('SITE_EMAIL', 'info@fitlab-studio.ru');

// Настройки вывода ошибок.
error_reporting(E_ALL);
ini_set('display_errors', 1); 
ini_set('log_errors', 'On');

// Локаль.
setlocale(LC_ALL, 'ru_RU');
date_default_timezone_set('Europe/Moscow');
header('Content-type: text/html; charset=utf-8');

mb_internal_encoding('UTF-8');
mb_regex_encoding('UTF-8');
mb_http_output('UTF-8');
mb_language('uni');

session_start();

include dirname(__FILE__) . '/lib/input.php';

if (isset($_GET['send'])) {
	$form['name'] = input::getStr($_POST['name']);
//	$form['email'] = input::getStr($_POST['email']);
	$form['form_id'] = input::getStr($_POST['form_id']);
	$form['phone'] = input::getStr($_POST['phone']);
	
	if (empty($form['name'])) {
		$error['name'] = 1;
	}
	
//	if (empty($form['email'])) {
//		$error['email'] = 1;
//	}
	
	if (empty($form['phone'])) {
		$error['phone'] = 1;
	}

	if (empty($error)) {

		$email_headers = array(
			'form0' => 'ЛП fitlab-studio "Персональный тренинг"!', // Заголовок письма по умолчанию
			'form1' => 'Заголовок для формы с идентификатором form1',
			'form2' => 'Заголовок для формы с идентификатором form2',
			'form3' => 'Заголовок для формы с идентификатором form3',
			'form5' => 'Заголовок для формы с идентификатором form5',
			'form6' => 'Заголовок для формы с идентификатором form6',
			'form7' => 'Заголовок для формы с идентификатором form7',
			'form8' => 'Заголовок для формы с идентификатором form8',
			'form9' => 'Заголовок для формы с идентификатором form9',
			'form10' => 'Заголовок для формы с идентификатором form10',
			'form11' => 'Заголовок для формы с идентификатором form11',
			'form12' => 'Заголовок для формы с идентификатором form12',
			'form13' => 'Заголовок для формы с идентификатором form13',
			'form14' => 'Заголовок для формы с идентификатором form14',
			'form15' => 'Заголовок для формы с идентификатором form15'
		);
		
	$__smtp = array(
			"host" => 'smtp.yandex.ru', // SMTP сервер
			"debug" => 0, // Уровень логирования
			"auth" => true, // Авторизация на сервере SMTP. Если ее нет - false
			"port" => '465', // Порт SMTP сервера
			"username" => 'fitlabstudio2017@yandex.ru', // Логин запрашиваемый при авторизации на SMTP сервере
			"password" => '8904361655', // Пароль
			"addreply" => 'fitlabstudio2017@yandex.ru', // Почта для ответа
			"secure" => 'ssl', // Тип шифрования. Например ssl или tls
//			"mail_title" => 'ЛП fitlab-studio "Персональный тренинг"!', // Заголовок письма
			"mail_name" => 'fitlab-studio ' // Имя отправителя
	); 

		
	require dirname(__FILE__) . '/lib/PHPMailer/PHPMailerAutoload.php';
		
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
	$mail->AddAddress('aevcpa@yandex.ru', 'John Doe');  // Адресат почтового сообщения
    $mail->AddAddress('KKhizhniak@synergy.ru', 'John Doe');  // Адресат почтового сообщения
	$mail->AddAddress('sales@fitlab-studio.ru', 'John Doe');  // Адресат почтового сообщения
    $mail->AddReplyTo($__smtp['addreply'], 'First Last');  // Альтернативный адрес для ответа
    $mail->SetFrom($__smtp['username'], $__smtp['mail_title']);  // Адресант почтового сообщения
  

  
	$mail->Subject = 'Запись на персональную тренировку';
	
	$mail->Body = '
		<p>
				<strong>Дата:</strong> ' . date('d.m.Y H:i') . '
				<br><strong>Имя:</strong> ' . $form['name'] . '
				<br><strong>Телефон:</strong> ' . $form['phone'] . '
				<br><strong>E-mail:</strong> ' . $form['email'] . '
		</p>
	';
    
    $mail->send();
		echo 'true';	
	
	
	} else {
		echo 'false';
	}

	exit;
}

if (isset($_GET['full'])) {
	$_SESSION['full'] = true;
}	

if (empty($_SESSION['full'])) {
	require_once dirname(__FILE__) . '/lib/Mobile_Detect.php';
	$detect = new Mobile_Detect;
	if ($detect->isMobile()) {
		include dirname(__FILE__) . '/lib/mobile.tpl';
	} else {
		include dirname(__FILE__) . '/lib/main.tpl';
	}
}

exit;