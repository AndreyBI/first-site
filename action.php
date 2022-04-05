<?php
	require_once 'PHPMailer/PHPMailerAutoload.php';

	require_once "language_class.php";

    $language = $_POST['langs'];
	$lang = new Language($language);

	$mail = new PHPMailer;
	$mail->CharSet = 'UTF-8';

	// Настройки SMTP
	$mail->isSMTP();
	$mail->SMTPAuth = true;
	$mail->SMTPDebug = 0;
	$mail->Debugoutput = 'html';
	
	$mail->Host = 'smtp.mail.ru';
	$mail->SMTPSecure = 'ssl';
	$mail->Port = 465;
	$mail->Username = 'baykalov-andrey@mail.ru';
	$mail->Password = '****************';

	$msg_box = ""; // в этой переменной будем хранить сообщения формы
	$errors = array(); // контейнер для ошибок
	// проверяем корректность полей
	if($_POST['name'] == "") {
		$errors[] = $lang->get("NAME");
	}
		elseif (!preg_match("/^[a-яA-Яa-zA-z ]*$/",$_POST['name'])) {
			$errors[] = $lang->get("COR_NAME")."!";
		}
	if($_POST['phone'] == "") {	 
		$errors[] = $lang->get("TEL");
	}
		elseif (!preg_match("|^[0-9]{6,}|",$_POST['phone'])) {
			$length = strlen($_POST['phone']);
			if ($length < 6) {
				$errors[] = $lang->get("COR_TEL_LEN")."!";
			}
			else {
				$errors[] = $lang->get("COR_TEL")."!";
			}
		}
	if($_POST['email'] == "") { 
		$errors[] = $lang->get("EMAIL");
	}
	//!preg_match("|^[A-Za-zА-Яа-яЁё0-9_.-]{1,})@([A-Za-z]{1,}).([A-Za-z]{2,8}|",$_POST['email']) 
		elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
			$errors[] = $lang->get("COR_EMAIL")."!";
		}
	if($_POST['text'] == "") {   
		$errors[] = $lang->get("TEXT");
	}

	// если форма без ошибок
	if(empty($errors)){		


		// От кого
		$mail->setFrom('baykalov-andrey@mail.ru', 'Андрей Байкалов');

		// Кому делать ответ
		$mail->addReplyTo($_POST['email'], $_POST['name']);

		// Кому
		$mail->addAddress('baykalov.a.i.tt@gmail.com', 'Андрей Байкалов');

		// Тема письма
		$them = 'Разработка ПО';
		$mail->Subject = $them;

		// собираем данные из формы
		$message .= nl2br("ФИО заказчика: " . $_POST['name'] . "\r\n");
		$message .= nl2br("Телефон заказчика: +" . $_POST['code'] . " " . $_POST['phone'] . "\r\n");
		$message .= nl2br("E-mail заказчика: " . $_POST['email'] . "\r\n");
		$message .= nl2br("Описание проекта: " . $_POST['text']);		

		// Тело письма
		$mail->msgHTML($message);
		
		if ($mail->send()) {
			//Сообщение отправлено
			$msg_box = "<img src='img/cool.png' id='mes-img'> <br> <span style='color: #00ed95;' id='green'>" . $lang->get('SUCCESS') . "!</span>";
		} else {
			$msg_box = "<img src='img/bad.png' id='mes-img' autofocus><br><span id='red'>" . $mail->ErrorInfo ."<br>";
		}
	} else{
		// если были ошибки, то выводим их
		$msg_box = "<img src='img/bad.png' id='mes-img' autofocus> <br>";
		foreach($errors as $one_error){
			$msg_box .= "<span id='red'>$one_error</span><br/>";
		}
	}

	// делаем ответ на клиентскую часть в формате JSON
	echo json_encode(array(
		'result' => $msg_box
	));
?>
