<?php

  class Validation {
    private $patternList = [
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
    public function checkEmpty(string $para) {
      if (empty($para)) {
        //未入力
        return true;
      } else {
        //入力値あり
        return false;
      }
    }
    
  /**
   * パターンチェックのメソッド
   *
   * @param int $flg 配列$patternListのインデックス番号
   *        string $para
   *
   * @return boolean
  */
    public function checkPattern(int $flg, string $para) {
      if (!preg_match($this->patternList[$flg], $para)) {
        //パターンに一致しない
        return true;
      } else {
        //パターンに一致
        return false;
      }
    }

  /**
   * 全角文字チェックのメソッド
   *
   * @param string $para
   *
   * @return boolean
  */
    public function checkStrWidth(string $para) {
      if (mb_strlen($para) !== mb_strwidth($para)) {
        //全角文字が含まれている
        return true;
      } else {
        //全て半角文字
        return false;
      }
    }
  }