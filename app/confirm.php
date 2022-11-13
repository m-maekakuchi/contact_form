<?php
  $inputData = $_SESSION['inputData'];
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
          <label class="label-item">名前<span class="label-required">*</span></label>
          <?php echo $inputData['name'] ?>
        </div>
        <div class="item">
          <label class="label-item">フリガナ<span class="label-required">*</span></label>
          <?php echo $inputData['kana'] ?>
        </div>
      </div>
      <div class="form-items item">
        <label class="label-item">電話番号<span class="label-required">*</span></label>
        <?php echo $inputData['tel'] ?>
      </div>
      <div class="form-items item">
        <label class="label-item">性別<span class="label-required">*</span></label>
        <?php echo $_SESSION['confirmGender'] ?>
      </div>
      <div class="form-items item">
        <label class="label-item">メールアドレス<span class="label-required">*</span></label>
        <?php echo $inputData['email'] ?>
      </div>
      <div class="form-items item">
        <label class="label-item">お問い合わせ<span class="label-required">*</span></label>
        <?php echo $_SESSION['confirmContent'] ?>
      </div>
      <div class="btn-wrapper">
        <button type="submit" class="btn">送信</button>
        <input type="hidden" name="btn" value="toComplete">
        <a href="index.php" class="btn">戻る</a>
      </div>
    </form>
  </div>
</body>
</html>