<?php

class Validation {

  private $patternList = 
  [
    '/^[0-9]{2,4}-[0-9]{2,4}-[0-9]{3,4}$/',          //telの正規表現パターン
    '/^[a-zA-Z0-9_.+-]+[@][a-zA-Z0-9.-]+$/'          //emailの正規表現パターン
  ];
    
  /**
   * パターンチェックのメソッド
   *
   * @param int $flg 配列$patternListのインデックス番号
   *        string $para
   *
   * @return boolean
  */
  public function checkPattern($flg, $para)
  {
    //正規表現パターンに一致しない
    return !preg_match($this->patternList[$flg], $para);
  }

  /**
   * 全角文字チェックのメソッド
   *
   * @param string $para
   *
   * @return boolean
  */
  public function checkStrWidth($para)
  {
    //全角文字が含まれている
    return mb_strlen($para) !== mb_strwidth($para);
  }


  /**
   * 全角文字チェックのメソッド
   *
   * @param string $name
   *        string $kana
   *        string $tel
   *        string $gender
   *        string $email
   *        string $confirmEmail
   *        string $content
   *
   * @return array エラーメッセージ
  */
  public function validateForms(
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
    if (empty($name)) {
      $errorMsg['name'] = Message::$VAL_NAME_EMPTY;
    }

    //フリガナのバリデーション
    if (empty($kana)) {
      $errorMsg['kana'] = Message::$VAL_KANA_EMPTY;
    }

    //電話番号のバリデーション
    if (empty($tel)) {
      $errorMsg['tel'] = Message::$VAL_TEL_EMPTY;
    } else if ($this->checkStrWidth($tel)) {
      $errorMsg['tel'] = Message::$VAL_TEL_FULL_WIDTH;
    } else if ($this->checkPattern(0, $tel)) {
      $errorMsg['tel'] = Message::$VAL_TEL_NOT_CORRECT;
    }

    //性別のバリデーション
    if ($gender !== "1" && $gender !== "2") {
      $errorMsg['gender'] = Message::$VAL_GENDER_NOT_COLLECT;
    }

    if (empty($email)) {
      $errorMsg['email'] = Message::$VAL_EMAIL_EMPTY;
    } else if (empty($confirmEmail)) {
      $errorMsg['confirmEmail'] = Message::$VAL_CONFIRM_EMAIL_EMPTY;
    } else if ($this->checkStrWidth($email)) {
      $errorMsg['email'] = "";
      $errorMsg['confirmEmail'] = Message::$VAL_EMAIL_FULL_WIDTH;
    } else if ($this->checkPattern(1, $email)) {
      $errorMsg['email'] = "";
      $errorMsg['confirmEmail'] = Message::$VAL_EMAIL_NOT_CORRECT;
    } else if ($email !== $confirmEmail) {
      $errorMsg['email'] = "";
      $errorMsg['confirmEmail'] = Message::$VAL_EMAIL_NOT_EQUAL;
    }

    //お問い合わせ内容のバリデーション
    if (empty($content)) {
      $errorMsg['content'] = Message::$VAL_CONTENT_EMPTY;
    }

    return $errorMsg;
  }
}