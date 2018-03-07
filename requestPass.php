<?
	require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
	$APPLICATION->SetTitle("Восстановление пароля");
	
	$email = $DB->ForSQL($_REQUEST['email']);

	if(empty($email)) {
		print '<span class="red alert-message block-message warning">Не указан адрес E-mail</span>';
	} elseif(!check_email($email)) {
		print '<span class=" red alert-message block-message warning">Некорректный адрес E-mail</span>';
	} else {
		$sql = $DB->Query("select * from b_user where EMAIL='$email'");
		$res = $sql->Fetch();
		if($email != $res['EMAIL']) {
			print '<span class=" red alert-message block-message warning">Некорректный адрес E-mail</span>';
		} else {
			$link = 'http://spbdk.ru/user/resPass.php?uid='.$res['ID'].'&checkWord='.$res['CHECKWORD'];
			$msg = "Уважаемый пользователь сайта SPBDK.RU\n";
			$msg .= "Вы воспользовались сервисом восстановления пароля на нашем сайте. Для того, чтобы сбросить пароль и указать новый перейдите по ссылке и следуйте инструкции. \n";
			$msg .= "\n";
			$msg .= "$link \n";
			$msg .= "\n";
			$msg .= "Если Вы не собираетесь восстанавливать/менять пароль, проигнорируйте это письмо.\n";
			$msg .= "\n";
			$msg .= "Служба поддержки spbdk.ru";
			$mailStr = str_replace("«","",$msg);
			$mailStr = str_replace("»","",$msg);		
				   
			mail("$email","Восстановление пароля на spbdk.ru","$msg","From:andy@spbdk.ru");                              
			print '<br /><br />На указанный E-mail отправлено письмо с инструкциями по восстановлению пароля.';		
		}
	}

	require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
?>