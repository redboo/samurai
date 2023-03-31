<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './PHPMailer/src/Exception.php';
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';

// Собираем текст сообщения
$message = 'Пользователь ' . $_POST['phone'] . " заказал расчет услуг.\n\n";
$type = [];
if (isset($_POST['cms'])) $type[] = 'Система управления сайтом';
if (isset($_POST['logo'])) $type[] = 'Разработка логотипа';
if (isset($_POST['catalog'])) $type[] = 'Каталог товаров';
if (isset($_POST['support'])) $type[] = 'Поддержка 1 год';
if (isset($_POST['landing'])) $type[] = 'Многостраничный лендинг';
if (isset($_POST['payment'])) $type[] = 'Оплата на сайте';
if (isset($_POST['analysis'])) $type[] = 'Конкурентный анализ';
if (isset($_POST['longread'])) $type[] = 'Лонгрид';
if (isset($_POST['writing'])) $type[] = 'Написение текстов';
if (isset($_POST['specification'])) $type[] = 'Помощь с техническим заданием';

if (!empty($type)) {
	$message .= "Выбранные услуги:\n<ul>";
	foreach ($type as $item) {
		$message .= '<li>' . $item . '</li>';
	}
	$message .= "</ul>";
}

$mail = new PHPMailer;

// Настраиваем SMTP соединение
$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->SMTPAuth = true;
$mail->Username = 'YourEmail@gmail.com';
// https://support.google.com/accounts/answer/185833?hl=ru получение пароля
$mail->Password = 'asdfasdfasdf';
$mail->SMTPSecure = 'ssl';
$mail->Port = 465;

// Устанавливаем параметры письма
$mail->CharSet = "utf-8";
$mail->setFrom('YourEmail@gmail.com', 'Самурай');
$mail->addAddress('to@mail.ru');
$mail->Subject = 'Заказ услуг';
$mail->Body = nl2br($message); // Заменяем переносы строк на <br> для корректного отображения в html-письме
$mail->isHTML(true); // Устанавливаем формат письма - html

if (!$mail->send()) {
	echo 'Message could not be sent.';
	echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
	echo 'Спасибо, что воспользовались нашими услугами. Скоро с Вами свяжутся наши специалисты.';
}
