<?php
  session_start();

  require_once('utilities/Validation.php');
  require_once('utilities/Message.php');
  require_once('utilities/ContactModel.php');

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
    
    if (!empty($btn)) {
      if ($btn === "toConfirm") {
        $val = new Validation();
        $inputData = [];
        $name         = htmlspecialchars($_POST['name'], ENT_QUOTES | ENT_HTML5, 'UTF-8', false);
        $kana         = htmlspecialchars($_POST['kana'], ENT_QUOTES | ENT_HTML5, 'UTF-8', false);
        $tel          = htmlspecialchars($_POST['tel'], ENT_QUOTES | ENT_HTML5, 'UTF-8', false);
        $gender       = 0;
        $email        = htmlspecialchars($_POST['email'], ENT_QUOTES | ENT_HTML5, 'UTF-8', false);
        $confirmEmail = htmlspecialchars($_POST['confirmEmail'], ENT_QUOTES | ENT_HTML5, 'UTF-8', false);
        $content      = htmlspecialchars($_POST['content'], ENT_QUOTES | ENT_HTML5, 'UTF-8', false);

        if (array_key_exists('gender', $_POST)) {
          $gender = $_POST['gender'];
        }

        $errorCount = 0;
        $errorMsg = [];

        //名前のバリデーション
        if ($val->checkEmpty($name)) {
          $errorMsg['name'] = Message::$VAL_NAME_EMPTY;
          $errorCount++;
        } else {
          $inputData['name'] = $name;
        }

        //フリガナのバリデーション
        if ($val->checkEmpty($kana)) {
          $errorMsg['kana'] = Message::$VAL_KANA_EMPTY;
          $errorCount++;
        } else {
          $inputData['kana'] = $kana;
        }

        //電話番号のバリデーション
        if ($val->checkEmpty($tel)) {
          $errorMsg['tel'] = Message::$VAL_TEL_EMPTY;
        } else if ($val->checkStrWidth($tel)) {
          $errorMsg['tel'] = Message::$VAL_TEL_FULL_WIDTH;
        } else if ($val->checkPattern(0, $tel)) {
          $errorMsg['tel'] = Message::$VAL_TEL_NOT_CORRECT;
        } else {
          $inputData['tel'] = $tel;
        }

        //性別のバリデーション
        if ($gender === 0) {
          $errorMsg['gender'] = Message::$VAL_GENDER_NOT_SELECT;
        } else {
          $inputData['gender'] = $gender;
        }

        //メールアドレスのバリデーション
        if ($val->checkEmpty($email)) {
          $errorMsg['email'] = Message::$VAL_EMAIL_EMPTY;
        } else if ($val->checkEmpty($confirmEmail)) {
          $errorMsg['email'] = Message::$VAL_CONFIRM_EMAIL_EMPTY;
        } else if ($val->checkStrWidth($email) || $val->checkStrWidth($confirmEmail)) {
          $errorMsg['email'] = Message::$VAL_EMAIL_FULL_WIDTH;
        } else if ($val->checkPattern(1, $email)) {
          $errorMsg['email'] = Message::$VAL_EMAIL_NOT_CORRECT;
        } else if ($email !== $confirmEmail) {
          $errorMsg['email'] = Message::$VAL_EMAIL_NOT_EQUAL;
        } else {
          $inputData['email'] = $email;
          $inputData['confirmEmail'] = $confirmEmail;
        }

        //お問い合わせ内容のバリデーション
        if ($val->checkEmpty($content)) {
          $errorMsg['content'] = Message::$VAL_CONTENT_EMPTY;
        } else {
          $inputData['content'] = $content;
        }

        //入力されたデータをセッションに登録
        $_SESSION['inputData'] = $inputData;

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
        //データベースに接続して入力データを登録
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