<?php
  session_start();
  require_once('utilities/functions.php');

  if (isset($_SESSION['inputData'])) {
    $inputData = $_SESSION['inputData'];
  }
  if (isset($_SESSION['errorMsg'])) {
    $errorMsg = $_SESSION['errorMsg'];
  }
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>お問い合わせ</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <div class="container">
    <form action="index.php" method="post">
      <div class="form-items">
        <div class="item-column">
          <div class="item-name">
            名前&emsp;<span class="label-required">必須</span>
          </div>
          <input
            type="text"
            name="name"
            id="name"
            size="38"
            value="<?= isset($inputData['name']) ? $inputData['name'] : "" ?>"
          />
          <?= isset($errorMsg['name']) ? "<span class ='error'>{$errorMsg['name']}</span>" : "" ?>
        </div>
        <div class="item-column">
          <div class="item-name">
            フリガナ&emsp;<span class="label-required">必須</span>
          </div>
          <input
            type="text"
            name="kana"
            id="kana"
            size="38"
            value="<?= isset($inputData['kana']) ? $inputData['kana'] : "" ?>"
          />
          <?= isset($errorMsg['kana']) ? "<span class ='error'>{$errorMsg['kana']}</span>" : "" ?>
        </div>
      </div>
      <div class="form-items item-column">
        <div class="item-name">
          電話番号&emsp;<span class="label-required">必須</span>
        </div>
        <input 
          type="text"
          name="tel"
          id="tel"
          size="38"
          placeholder="000-0000-0000"
          value="<?= isset($inputData['tel']) ? $inputData['tel'] : "" ?>"
        />
        <?= isset($errorMsg['tel']) ? "<span class ='error'>{$errorMsg['tel']}</span>" : "" ?>
      </div>
      <div class="form-items item-column">
        <div class="item-name">
          性別&emsp;<span class="label-required">必須</span>
        </div>
        <div>
          <label>
            <input
              type="radio"
              name="gender"
              value="男"
              id="man"
              <?= !isset($inputData['gender']) ? "checked" : "" ?>
              <?= isset($inputData['gender']) && $inputData['gender'] !== '女' ? "checked" : "" ?>
            >
            <span class="gender">男性</span>
          </label>
          <label>
            <input
              type="radio"
              name="gender"
              value="女"
              id="woman"
              <?= isset($inputData['gender']) && $inputData['gender'] == '女' ? "checked" : "" ?>
            >
            女性
          </label>
        </div>
        <?= isset($errorMsg['gender']) ? "<span class ='error'>{$errorMsg['gender']}</span>" : "" ?>
      </div>
      <div class="form-items">
        <div class="item-column">
          <div class="item-name">
            メールアドレス&emsp;<span class="label-required">必須</span>
          </div>
          <input
            type="text"
            name="email"
            id="email"
            size="38"
            placeholder="example@gmail.com"
            value="<?= isset($inputData['email']) ? $inputData['email'] : "" ?>"
          />
          <?= isset($errorMsg['email']) ? "<span class ='error'>{$errorMsg['email']}</span>" : "" ?>
        </div>
        <div class="item-column">
          <div class="item-name">
            メールアドレス確認用&emsp;<span class="label-required">必須</span>
          </div>
          <input
            type="text"
            name="confirmEmail"
            id="confirmEmail"
            size="38"
            placeholder="example@gmail.com"
            value="<?= isset($inputData['confirmEmail']) ? $inputData['confirmEmail'] : "" ?>"
          />
          <?= isset($errorMsg['confirmEmail']) ? "<span class ='error'>{$errorMsg['confirmEmail']}</span>" : "" ?>
        </div>
      </div>
      <div class="form-items item-column">
        <div class="item-name">趣味</div>
        <div id="hobby">
          <?= isset($inputData['hobbys']) ? getHtmlHobby($inputData['hobbys']) : getHtmlHobby(array()); ?>
        </div>
        <?= isset($errorMsg['hobby']) ? "<span class ='error'>{$errorMsg['hobby']}</span>" : "" ?>
      </div>
      <div class="form-items item-column">
        <div class="item-name">
          お問い合わせ&emsp;<span class="label-required">必須</span>
        </div>
        <textarea name="content" id="content" cols="40" rows="10"><?= isset($inputData['content']) ? $inputData['content'] : "" ?></textarea>
        <?= isset($errorMsg['content']) ? "<span class ='error'>{$errorMsg['content']}</span>" : "" ?>
      </div>
      <div class="btn-wrapper">
        <button type="submit" class="btn">入力確認</button>
        <input type="hidden" name="btn" value="toConfirm">
      </div>
    </form>
  </div>
</body>
</html>