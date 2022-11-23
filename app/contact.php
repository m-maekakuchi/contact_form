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
      <div class="form-items item-pair">
        <div class="item">
          <label class="label-item">名前&emsp;<span class="label-required">必須</span></label>
          <div class="item-column">
            <input
              type="text"
              name="name"
              id="name"
              size="30"
              value="<?= $inputData['name'] ?? "" ?>"
            />
            <?= isset($errorMsg['name']) ? "<span class ='error'>{$errorMsg['name']}</span>" : "" ?>
          </div>
        </div>
        <div class="item">
          <label class="label-item">フリガナ&emsp;<span class="label-required">必須</span></label>
          <div class="item-column">
            <input
              type="text"
              name="kana"
              id="kana"
              size="30"
              value="<?= $inputData['kana'] ?? "" ?>"
            />
            <?= isset($errorMsg['kana']) ? "<span class ='error'>{$errorMsg['kana']}</span>" : "" ?>
          </div>
        </div>
      </div>
      <div class="form-items item">
        <label class="label-item">電話番号&emsp;<span class="label-required">必須</span></label>
        <div class="item-column">
          <input 
            type="text"
            name="tel"
            id="tel"
            size="30"
            placeholder="000-0000-0000"
            value="<?= $inputData['tel'] ?? "" ?>"
          />
          <?= isset($errorMsg['tel']) ? "<span class ='error'>{$errorMsg['tel']}</span>" : "" ?>
        </div>
      </div>
      <div class="form-items item">
        <label class="label-item">性別&emsp;<span class="label-required">必須</span></label>
        <div class="item-column">
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
      </div>
      <div class="form-items item-pair">
        <div class="item">
          <label class="label-item">メールアドレス&emsp;<span class="label-required">必須</span></label>
          <div class="item-column">
            <input
              type="text"
              name="email"
              id="email"
              size="50"
              placeholder="example@gmail.com"
              value="<?= $inputData['email'] ?? "" ?>"
            />
            <?= isset($errorMsg['email']) ? "<span class ='error'>{$errorMsg['email']}</span>" : "" ?>
          </div>
        </div>
        <div class="item">
          <label class="label-item">メールアドレス確認用&emsp;<span class="label-required">必須</span></label>
          <div class="item-column">
            <input
              type="text"
              name="confirmEmail"
              id="confirmEmail"
              size="50"
              placeholder="example@gmail.com"
              value="<?= $inputData['confirmEmail'] ?? "" ?>"
            />
            <?= isset($errorMsg['confirmEmail']) ? "<span class ='error'>{$errorMsg['confirmEmail']}</span>" : "" ?>
          </div>
        </div>
      </div>
      <div class="form-items item">
        <label class="label-item">趣味</label>
        <div class="item-column">
          <div id="hobby">
            <?= isset($inputData['hobbys']) ? getHtmlHobby($inputData['hobbys']) : getHtmlHobby(array()); ?>
          </div>
          <?= isset($errorMsg['hobby']) ? "<span class ='error'>{$errorMsg['hobby']}</span>" : "" ?>
        </select>
        </div>
      </div>
      <div class="form-items item">
        <label class="label-item">お問い合わせ&emsp;<span class="label-required">必須</span></label>
        <div class="item-column">
          <textarea name="content" id="content" cols="50" rows="10"><?= $inputData['content'] ?? "" ?></textarea>
          <?= isset($errorMsg['content']) ? "<span class ='error'>{$errorMsg['content']}</span>" : "" ?>
        </div>
      </div>
      <div class="btn-wrapper">
        <button type="submit" class="btn">入力確認</button>
        <input type="hidden" name="btn" value="toConfirm">
      </div>
    </form>
  </div>
</body>
</html>