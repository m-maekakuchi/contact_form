<?php

  $patternList = 
  [
    '/^[0-9]{2,4}-[0-9]{2,4}-[0-9]{3,4}$/',          //telの正規表現パターン
    '/^[a-zA-Z0-9_.+-]+[@][a-zA-Z0-9.-]+$/'          //emailの正規表現パターン
  ];
    
  /**
   * 空文字チェックのメソッド
   *
   * @param string $para
   *
   * @return boolean
  */
  function checkEmpty($para) {
    //未入力ならtrueを返す
    return empty($para);
  }
    
  /**
   * パターンチェックのメソッド
   *
   * @param int $flg 配列$patternListのインデックス番号
   *        string $para
   *
   * @return boolean
  */
  function checkPattern($flg, $para)
  {
    $patternList = 
    [
      '/^[0-9]{2,4}-[0-9]{2,4}-[0-9]{3,4}$/',          //telの正規表現パターン
      '/^[a-zA-Z0-9_.+-]+[@][a-zA-Z0-9.-]+$/'          //emailの正規表現パターン
    ];
    //正規表現パターンに一致しない
    return !preg_match($patternList[$flg], $para);
  }

  /**
   * 全角文字チェックのメソッド
   *
   * @param string $para
   *
   * @return boolean
  */
  function checkStrWidth($para)
  {
    //全角文字が含まれている
    return mb_strlen($para) !== mb_strwidth($para);
  }

  function validateForm (
    $name,
    $kana,
    $tel,
    $gender,
    $email,
    $confirmEmail,
    $content
  )
  {
    $errorMsg = [];

    //名前のバリデーション
    if (checkEmpty($name)) {
      $errorMsg['name'] = Message::$VAL_NAME_EMPTY;
    } else {
      $inputData['name'] = $name;
    }

    //フリガナのバリデーション
    if (checkEmpty($kana)) {
      $errorMsg['kana'] = Message::$VAL_KANA_EMPTY;
    } else {
      $inputData['kana'] = $kana;
    }

    //電話番号のバリデーション
    if (checkEmpty($tel)) {
      $errorMsg['tel'] = Message::$VAL_TEL_EMPTY;
    } else if (checkStrWidth($tel)) {
      $errorMsg['tel'] = Message::$VAL_TEL_FULL_WIDTH;
    } else if (checkPattern(0, $tel)) {
      $errorMsg['tel'] = Message::$VAL_TEL_NOT_CORRECT;
    } else {
      $inputData['tel'] = $tel;
    }

    //性別のバリデーション
    if ($gender !== 1 || $gender !== 2) {
      $errorMsg['gender'] = Message::$VAL_GENDER_NOT_COLLECT;
    } else {
      $inputData['gender'] = $gender;
    }

    //メールアドレスのバリデーション
    if (checkEmpty($email) && checkEmpty($confirmEmail)) {
      $errorMsg['email'] = Message::$VAL_EMAIL_EMPTY;
      $errorMsg['confirmEmail'] = Message::$VAL_CONFIRM_EMAIL_EMPTY;
    } else if (checkEmpty($email)) {
      $errorMsg['email'] = Message::$VAL_EMAIL_EMPTY;
    } else if (checkEmpty($confirmEmail)) {
      $errorMsg['confirmEmail'] = Message::$VAL_CONFIRM_EMAIL_EMPTY;
    } else if (checkStrWidth($email) || checkStrWidth($confirmEmail)) {
      $errorMsg['confirmEmail'] = Message::$VAL_EMAIL_FULL_WIDTH;
    } else if (checkPattern(1, $email)) {
      $errorMsg['confirmEmail'] = Message::$VAL_EMAIL_NOT_CORRECT;
    } else if ($email !== $confirmEmail) {
      $errorMsg['confirmEmail'] = Message::$VAL_EMAIL_NOT_EQUAL;
    } else {
      $inputData['email'] = $email;
      $inputData['confirmEmail'] = $confirmEmail;
    }

    //お問い合わせ内容のバリデーション
    if (checkEmpty($content)) {
      $errorMsg['content'] = Message::$VAL_CONTENT_EMPTY;
    } else {
      $inputData['content'] = $content;
    }

    return $errorMsg;
  }