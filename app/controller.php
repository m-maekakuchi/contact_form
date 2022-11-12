<?php
  session_start();

  require_once('utilities/Validation.php');
  require_once('utilities/Message.php');

  var_dump($_POST);
  $val = new Validation();
  $btn = "";
  if (array_key_exists('btn', $_POST)) {
    $btn = $_POST['btn'];
  }
  
  if (!empty($btn)) {
    if ($btn === "toConfirm") {
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

      if ($val->checkEmpty($name)) {
        $errorMsg['name'] = Message::$VAL_NAME_EMPTY;
        $errorCount++;
      } else {
        $_SESSION['name'] = $name;
      }

      if ($val->checkEmpty($kana)) {
        $errorMsg['kana'] = Message::$VAL_KANA_EMPTY;
        $errorCount++;
      } else {
        $_SESSION['kana'] = $kana;
      }

      if ($val->checkEmpty($tel)) {
        $errorMsg['tel'] = Message::$VAL_TEL_EMPTY;
      } else if ($val->checkStrWidth($tel)) {
        $errorMsg['tel'] = Message::$VAL_TEL_FULL_WIDTH;
      } else if ($val->checkPattern(0, $tel)) {
        $errorMsg['tel'] = Message::$VAL_TEL_NOT_CORRECT;
      } else {
        $_SESSION['tel'] = $tel;
      }

      if ($gender === 0) {
        $errorMsg['gender'] = Message::$VAL_GENDER_NOT_SELECT;
      } else {
        $_SESSION['gender'] = $gender;
      }

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
        $_SESSION['email'] = $email;
        $_SESSION['confirmEmail'] = $confirmEmail;
      }

      if ($val->checkEmpty($content)) {
        $errorMsg['content'] = Message::$VAL_CONTENT_EMPTY;
      } else {
        $_SESSION['content'] = $content;
      }

      if (count($errorMsg) === 0) {
        if ($_SESSION['gender'] === '1') {
          $_SESSION['confirmGender'] = '男性';
        } else {
          $_SESSION['confirmGender'] = '女性';
        }
        $_SESSION['content'] = str_replace("\n", "<br>", $_SESSION['content']);

        require_once('confirm.php');
      } else {
        require_once('index.php');
      }
    } else if ($btn === "toComplete") {
      require_once('complete.php');
    }
  } else {
    require_once('index.php');
  }
?>