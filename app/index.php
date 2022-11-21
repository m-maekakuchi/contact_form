<?php
  session_start();

  require_once('utilities/Validation.php');
  require_once('utilities/Message.php');
  require_once('utilities/Database.php');
  require_once('utilities/ContactModel.php');
  require_once('utilities/functions.php');

  try {
    $btn = "";

    if (array_key_exists('btn', $_POST)) {
      $btn = $_POST['btn'];
    } else if (array_key_exists('btn', $_GET)) {
      $btn = $_GET['btn'];
    }

    //正しいパラメータ名で受け取れなかった場合はお問い合わせフォームにリダイレクト
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
          !isset($_POST['hobbys'])
          ||
          !isset($_POST['content'])
        ) {
          header('Location: contact.php');
          exit();
        }
        //入力データのエスケープ
        $name         = escape($_POST['name']);
        $kana         = escape($_POST['kana']);
        $tel          = escape($_POST['tel']);
        $email        = escape($_POST['email']);
        $confirmEmail = escape($_POST['confirmEmail']);
        $content      = escape($_POST['content']);
        $gender       = $_POST['gender'];
        $hobbys       = $_POST['hobbys'];

        //入力データのバリデーション
        $val = new Validation();
        $errorMsg = $val->validateForms($name, $kana, $tel, $gender, $email, $confirmEmail, $hobbys, $hobbyAry, $content);

        // $inputName         = !isset($errorMsg['name']) ? $name : "";
        // $inputKana         = !isset($errorMsg['kana']) ? $kana : "";
        // $inputTel          = !isset($errorMsg['tel']) ? $tel : "";
        // $inputGender       = !isset($errorMsg['gender']) ? $gender : "1";
        // $inputEmail        = !isset($errorMsg['email']) ? $email : "";
        // $inputConfirmEmail = !isset($errorMsg['confirmEmail']) ? $confirmEmail : "";
        // $inputContent      = !isset($errorMsg['content']) ? $content : "";
        // $model = new ContactModel($inputName, $inputKana, $inputTel, $inputGender, $inputEmail, $inputConfirmEmail, $inputContent);
        // $_SESSION['model'] = serialize($model);
        // echo $model->getName();

        $inputData['name']         = !isset($errorMsg['name']) ? $name : "";
        $inputData['kana']         = !isset($errorMsg['kana']) ? $kana : "";
        $inputData['tel']          = !isset($errorMsg['tel']) ? $tel : "";
        $inputData['gender']       = !isset($errorMsg['gender']) ? $gender : "";
        $inputData['email']        = !isset($errorMsg['email']) ? $email : "";
        $inputData['confirmEmail'] = !isset($errorMsg['confirmEmail']) ? $confirmEmail : "";
        $inputData['hobbys']       = !isset($errorMsg['hobby']) ? $hobbys : "";
        $inputData['content']      = !isset($errorMsg['content']) ? $content : "";
        
        $_SESSION['inputData']     = $inputData;
        $_SESSION['errorMsg']      = $errorMsg;

        if (count($errorMsg) === 0) {
          //改行コードを変換した文字列を変数に代入
          $_SESSION['confirmContent'] = str_replace("\n", "<br>", $inputData['content']);

          header('Location: confirm.php');
          exit();
        } else {
          header('Location: contact.php');
          exit();
        }
      } else if ($btn === "toComplete") {
        //POSTされたトークンを取得
        $postToken = isset($_POST['token']) ? $_POST["token"] : "";
        //セッション変数のトークンを取得
        $sessionToken = isset($_SESSION['token']) ? $_SESSION['token'] : "";
        //セッション変数のトークンを削除
        unset($_SESSION['token']);

        $inputData = $_SESSION['inputData'];
        if($postToken !== "" && $postToken === $sessionToken) {
          $db = new Database();
          $insertRow = $db->insertInputData($inputData);
        }

        header('Location: complete.php');
        exit();
      } else if ($btn === "back") {
        $_SESSION = array();
        session_destroy();

        header('Location: contact.php');
        exit();
      }
    } else {
      header('Location: contact.php');
      exit();
    }
  } catch (PDOException $e) {
    die ("データベースエラー:{$e->getMessage()}");
  } catch (Exception $e) {
    echo "例外発生", $e->getMessage();
  }
?>