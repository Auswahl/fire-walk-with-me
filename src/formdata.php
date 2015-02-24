<?php
	ini_set('display_errors', 1);
	error_reporting(E_ALL);

	error_reporting(E_ALL ^ E_NOTICE); // hide all basic notices from PHP

	if (!isset($_POST['name']) && !isset($_POST['phone']) && !isset($_POST['email'])) {
		header('HTTP/1.1 400 Bad Request', true, 400);
		exit;
	}

	// require a name from user
	$name = trim($_POST['name']);
	$phone = trim($_POST['phone']);
	$email = trim($_POST['email']);


	if (($phone === '') && ($email === '')) {
		header('HTTP/1.1 400 Bad Request', true, 400);
		exit;
	}

	if (isset($_POST['model'])) {
		if(!(trim($_POST['model']) === '')) {
			$model = trim($_POST['model']);
		}
	}

	// upon no failure errors let's email now!

	// $emailTo = 'mikhail.vnukov@gmail.com';
	$emailTo = 'horudspb@gmail.com';
	$subject = 'Новая заявка: '.$name;
	$body = "Имя: $name \r\nТелефон: $phone \r\nEmail: $email";

	if (isset($model)) {
		$body .= "\r\nМодель: ";
		switch ($model) {
			case 'OP-2':
				$body .= 'ОП-2 (з) автомобильный';
				break;
			case 'OU-2':
				$body .= 'ОУ-2 автомобильный';
				break;
			case 'OU-3':
				$body .= 'ОУ-3 офисы, музеи, лаборатории';
				break;
			case 'OP-4':
				$body .= 'ОП-4 (з) офисы, магазины';
				break;
			case 'OP-5':
				$body .= 'ОП-5 (з) офисы, магазины';
				break;
			case 'OU-5':
				$body .= 'ОУ-5 помещения с электрооборудованием';
				break;

		}
	}

	$headers = 'From: <postmaster@spbpoj.ru>' . "\r\n" . 'Reply-To: ' . $email .
			"\r\nMIME-Version: 1.0" . "\r\n" .
					"Content-type: text/plain; charset=UTF-8" . "\r\n";

	if(mail($emailTo, $subject, $body, $headers)) {
		echo $emailTo;
		echo $subject;
		echo $body;
		echo $headers;
	} else {
		echo "Error sending email";
		header('HTTP/1.1 400 Bad Request', true, 400);
	}
?>
