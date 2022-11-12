<?php
  $data = [];
  if (isset($_POST)) {
    var_dump($_POST);
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
    <form action="index.php" method="post"></form>
      <div class="form-wrapper">
        <div class="item">
          <label class="label-item">名前<span class="label-required">*</span></label>
          <input type="text" name="name" id="name" size="30"/>
        </div>
        <div class="item">
          <label class="label-item">フリガナ<span class="label-required">*</span></label>
          <input type="text" name="kana" id="kana" size="30"/>
        </div>
        <div class="item">
          <label class="label-item">電話番号<span class="label-required">*</span></label>
          <input type="text" name="tel" id="tel" size="30"/>
        </div>
        <div class="item">
          <label class="label-item">性別<span class="label-required">*</span></label>
          <input type="radio" name="gender" value="0" id="man"><span class="gender">男</span>
          <input type="radio" name="gender" value="1" id="woman">女
        </div>
        <div class="item">
          <label class="label-item">メールアドレス<span class="label-required">*</span></label>
          <input type="text" name="email" id="email" size="50" />
        </div>
        <div class="item">
          <label class="label-item">メールアドレス確認用<span class="label-required">*</span></label>
          <input type="text" name="confirmEmail" id="confirmEmail" size="50" />
        </div>
        <div class="item">
          <label class="label-item">お問い合わせ<span class="label-required">*</span></label>
          <textarea name="content" id="content" cols="50" rows="10"></textarea>
        </div>
      </div>
      <div class="foot-wrapper">
        <button type="submit" class="btn">入力確認</button>
        <input type="hidden" name="btn" value="toConfirm">
      </div>
    </form>
  </div>
</body>
</html>