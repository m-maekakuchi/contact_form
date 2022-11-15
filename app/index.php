<?php
  session_start();

  require_once('utilities/Validation.php');
  require_once('utilities/Message.php');
  require_once('utilities/ContactModel.php');
  require_once('utilities/functions.php');

  try {
    $btn = "";
    $inputData;

    if (array_key_exists('btn', $_POST)) {
      $btn = $_POST['btn'];
    }

    //入力データがセッションに登録されていれば変数$inputdataに代入
    if (isset($_SESSION['inputData'])) {
      $inputData = $_SESSION['inputData'];
    } else {
      $inputData = [];
    }
    
    //正しいパラメータ名を受け取れなかった場合はお問い合わせフォームにリダイレクト
    if (!empty($btn)) {
      if ($btn === "toConfirm") {
        if (
          !isset($_POST['name'])
          ||
          !isset($_POST['kana'])
          || 
          !isset($_POST['tel'])
          ||
          !isset($_POST['gender'])
          ||
          !isset($_POST['email'])
          ||
          !isset($_POST['confirmEmail'])
          ||
          !isset($_POST['content'])
        ) {
          header('Location: contact.php');
          exit();
        }

        $name         = escape($_POST['name']);
        $kana         = escape($_POST['kana']);
        $tel          = escape($_POST['tel']);
        $email        = escape($_POST['email']);
        $confirmEmail = escape($_POST['confirmEmail']);
        $content      = escape($_POST['content']);
        $gender       = $_POST['gender'];

        $errorMsg = validateForm($name, $kana, $tel, $gender, $email, $confirmEmail, $content);

        if ($errorMsg['name'] !== "") $inputData['name'] = $name;
        if ($errorMsg['kana'] !== "") $inputData['kana'] = $kana;
        if ($errorMsg['tel'] !== "") $inputData['tel'] = $tel;
        if ($errorMsg['gender'] !== "") $inputData['gender'] = $gender;
        if ($errorMsg['email'] !== "") $inputData['email'] = $email;
        if ($errorMsg['confirmEmail'] !== "") $inputData['confirmEmail'] = $confirmEmail;
        if ($errorMsg['content'] !== "") $inputData['content'] = $content;


        // //名前のバリデーション
        // if (checkEmpty($name)) {
        //   $errorMsg['name'] = Message::$VAL_NAME_EMPTY;
        // } else {
        //   $inputData['name'] = $name;
        // }

        // //フリガナのバリデーション
        // if (checkEmpty($kana)) {
        //   $errorMsg['kana'] = Message::$VAL_KANA_EMPTY;
        // } else {
        //   $inputData['kana'] = $kana;
        // }

        // //電話番号のバリデーション
        // if (checkEmpty($tel)) {
        //   $errorMsg['tel'] = Message::$VAL_TEL_EMPTY;
        // } else if (checkStrWidth($tel)) {
        //   $errorMsg['tel'] = Message::$VAL_TEL_FULL_WIDTH;
        // } else if (checkPattern(0, $tel)) {
        //   $errorMsg['tel'] = Message::$VAL_TEL_NOT_CORRECT;
        // } else {
        //   $inputData['tel'] = $tel;
        // }

        // //性別のバリデーション
        // if ($gender !== 1 || $gender !== 2) {
        //   $errorMsg['gender'] = Message::$VAL_GENDER_NOT_COLLECT;
        // } else {
        //   $inputData['gender'] = $gender;
        // }

        // //メールアドレスのバリデーション
        // if (checkEmpty($email) && checkEmpty($confirmEmail)) {
        //   $errorMsg['email'] = Message::$VAL_EMAIL_EMPTY;
        //   $errorMsg['confirmEmail'] = Message::$VAL_CONFIRM_EMAIL_EMPTY;
        // } else if (checkEmpty($email)) {
        //   $errorMsg['email'] = Message::$VAL_EMAIL_EMPTY;
        // } else if (checkEmpty($confirmEmail)) {
        //   $errorMsg['confirmEmail'] = Message::$VAL_CONFIRM_EMAIL_EMPTY;
        // } else if (checkStrWidth($email) || checkStrWidth($confirmEmail)) {
        //   $errorMsg['confirmEmail'] = Message::$VAL_EMAIL_FULL_WIDTH;
        // } else if (checkPattern(1, $email)) {
        //   $errorMsg['confirmEmail'] = Message::$VAL_EMAIL_NOT_CORRECT;
        // } else if ($email !== $confirmEmail) {
        //   $errorMsg['confirmEmail'] = Message::$VAL_EMAIL_NOT_EQUAL;
        // } else {
        //   $inputData['email'] = $email;
        //   $inputData['confirmEmail'] = $confirmEmail;
        // }

        // //お問い合わせ内容のバリデーション
        // if (checkEmpty($content)) {
        //   $errorMsg['content'] = Message::$VAL_CONTENT_EMPTY;
        // } else {
        //   $inputData['content'] = $content;
        // }

        //入力されたデータをセッションに登録
        $_SESSION['inputData'] = $inputData;
        $_SESSION['errorMsg'] = $errorMsg;

        if (count($errorMsg) === 0) {
          //選択されたラジオボタンによって、確認画面で表示する文字を変数に代入
          if ($inputData['gender'] === '1') {
            $_SESSION['confirmGender'] = '男性';
          } else {
            $_SESSION['confirmGender'] = '女性';
          }
          //改行コードを変換した文字列を変数に代入
          $_SESSION['confirmContent'] = str_replace("\n", "<br>", $inputData['content']);

          require_once('confirm.php');
        } else {
          require_once('contact.php');
        }
      } else if ($btn === "toComplete") {
        $contactModel = new ContactModel();
        $insertRow = $contactModel->insertInputData($inputData);
        require_once('complete.php');
      }
    } else {
      require_once('contact.php');
    }
  } catch (PDOException $e) {
    die ("データベースエラー:{$e->getMessage()}");
  } catch (Exception $e) {
    echo "例外発生", $e->getMessage();
  }
?>