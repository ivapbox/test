<?
	require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
	$APPLICATION->SetTitle("Восстановление пароля");

	$uid = $DB->ForSQL($_REQUEST['uid']);
	$checkWord = $DB->ForSQL($_REQUEST['checkWord']);

	if(is_numeric($uid)) {
		$sql = $DB->Query("select * from b_user where ID='$uid'");
		$res = $sql->Fetch();
		if($res['CHECKWORD'] == $checkWord) {
			$newPass = md5(time().'alskdjaslKDj93242');
			$newPassCheck = md5(time().'alSKDjaslKDj93242--');
			$newPass = substr($newPass,0,6);
			$DB->Query("UPDATE b_user SET CHECKWORD='$newPassCheck' WHERE ID=".$res['ID']);
			$user = new CUser;
			$fields = Array(
			  "PASSWORD"          => "$newPass",
			  "CONFIRM_PASSWORD"  => "$newPass",
			  );
			$user->Update($res['ID'], $fields);
			
			$msg = "Уважаемый пользователь сайта SPBDK.RU\n";
			$msg .= "Ваш пароль был изменен. Новый пароль: $newPass. Вы можете изменить его на более удобный в личном кабинете. \n";
			$msg .= "\n";
			$msg .= "Служба поддержки spbdk.ru";

			$mailStr = str_replace("«","",$msg);
			$mailStr = str_replace("»","",$msg);		
				   
			mail($res['EMAIL'],"Пароль изменен","$msg","From:andy@spbdk.ru");
			$USER->Authorize($res['ID']);
			LocalRedirect('/user/');			
		} else {
			print '<span class=" red alert-message block-message warning">Ошибка</span>';
		}
	} else {
		print '<span class=" red alert-message block-message warning">Ошибка</span>';
	}
	
	require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
?>