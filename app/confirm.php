<?php
  session_start();
  $inputData = $_SESSION['inputData'];
  unset($inputData['confirmEmail']);
  unset($inputData['hobbys']);

  // 二重送信防止用トークンの発行
  $token = uniqid('', true);
  $_SESSION['token'] = $token;
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
          <?= $inputData['name'] ?>
        </div>
        <div class="item">
          <label class="label-item">フリガナ&emsp;<span class="label-required">必須</span></label>
          <?= $inputData['kana'] ?>
        </div>
      </div>
      <div class="form-items item">
        <label class="label-item">電話番号&emsp;<span class="label-required">必須</span></label>
        <?= $inputData['tel'] ?>
      </div>
      <div class="form-items item">
        <label class="label-item">性別&emsp;<span class="label-required">必須</span></label>
        <?= $inputData['gender'] ?>
      </div>
      <div class="form-items item">
        <label class="label-item">メールアドレス&emsp;<span class="label-required">必須</span></label>
        <?= $inputData['email'] ?>
      </div>
      <div class="form-items item">
        <label class="label-item">趣味</label>
        <?= $_SESSION['confirmHobbys'] ?>
      </div>
      <div class="form-items item">
        <label class="label-item">お問い合わせ&emsp;<span class="label-required">必須</span></label>
        <?= $_SESSION['confirmContent'] ?>
      </div>
      <div class="btn-wrapper">
        <button type="submit" class="btn">送信</button>
        <input type="hidden" name="btn" value="toComplete">
        <input type="hidden" name="token" value="<?= $token ?>">
        <a href="index.php" class="btn">戻る</a>
      </div>
    </form>
  </div>
</body>
</html>