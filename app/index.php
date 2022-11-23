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

    //テキスト欄の正しいパラメータ名やラジオボタンの正しいvalue値を
    //受け取れなかった場合お問い合わせフォームにリダイレクト
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
          ||
          $_POST['gender'] !== '男' && $_POST['gender'] !== '女'
        ) {
          header('Location: contact.php');
          exit();
        }
        //チェックボックスが選択されていて、不正なvalue値を含んでいた場合
        if (count($_POST) === 9) {
          if (
            !isset($_POST['hobbys'])
            ||
            checkHobbysValues($_POST['hobbys'])
          ) {
            header('Location: contact.php');
            exit();
          }
        }

        //入力データのエスケープ
        $name         = escape($_POST['name']);
        $kana         = escape($_POST['kana']);
        $tel          = escape($_POST['tel']);
        $email        = escape($_POST['email']);
        $confirmEmail = escape($_POST['confirmEmail']);
        $content      = escape($_POST['content']);

        //入力データのバリデーション
        $val = new Validation();
        $errorMsg = $val->validateForms($name, $kana, $tel, $email, $confirmEmail, $content);

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
        $inputData['email']        = !isset($errorMsg['email']) ? $email : "";
        $inputData['confirmEmail'] = !isset($errorMsg['confirmEmail']) ? $confirmEmail : "";
        $inputData['content']      = !isset($errorMsg['content']) ? $content : "";
        $inputData['gender']       = $_POST['gender'];
        $inputData['hobbys']       = $_POST['hobbys'] ?? [];
        
        
        $_SESSION['inputData']     = $inputData;
        $_SESSION['errorMsg']      = $errorMsg;

        if (count($errorMsg) === 0) {
          //改行コードを変換した文字列を、セッションに登録
          $_SESSION['confirmContent'] = str_replace("\n", "<br>", $inputData['content']);
          //趣味の配列を、改行を含んだ文字列に変換してセッションに登録
          $_SESSION['confirmHobbys'] = count($inputData['hobbys']) > 0 ? getConfirmHobbys($inputData['hobbys']) : "";
          header('Location: confirm.php');
          exit();
        } else {
          header('Location: contact.php');
          exit();
        }
      } else if ($btn === "toComplete") {
        //POSTされたトークンを取得
        $postToken = $_POST['token'] ?? "";
        //セッション変数のトークンを取得
        $sessionToken = $_SESSION['token'] ?? "";
        //セッション変数のトークンを削除
        unset($_SESSION['token']);

        $inputData = $_SESSION['inputData'];

        if($postToken !== "" && $postToken === $sessionToken) {
          $database = new Database();
          $newId = $database->insertContent($inputData);
          //趣味が1つ以上選択された場合
          if (count($inputData['hobbys']) > 0) {
            //二次元配列の生成
            $idHobbysArray = getIdHobbysArray($newId, $inputData['hobbys']);
            //バルクインサートのvalueの文字列を生成
            $valueStr = getInsertValues($idHobbysArray);
            $insertRowNum = $database->insertHobbys($valueStr);
          }
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