<?php

require_once('Conf.php');

class Database {
  /**
   * PDOオブジェクト
   *
   * @var PDO
  */
  private $db;

  /**
   * データベースへ接続
  */
  function __construct() {
    $dsn = Conf::DSN;
    $user = Conf::USER;
    $password = Conf::PASSWORD;
    $this->db = new PDO($dsn, $user, $password);
    $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  }

  /**
   * データベースとの通信を切断するメソッド
   *
   * @return void
  */
  public function close() {
    $this->db = null;
  }

  /**
   * contact表に入力データを登録するメソッド
   *
   * @param array $data 入力されたデータ
   *
   * @return int 最新のid値
  */
  public function insertContent($data) {
    $sql = "INSERT INTO contact(name, kana, tel, gender, email, content)
            VALUES(?, ?, ?, ?, ?, ?);";
    $stt = $this->db->prepare($sql);
    $stt->bindValue(1, $data['name']);
		$stt->bindValue(2, $data['kana']);
		$stt->bindValue(3, $data['tel']);
		$stt->bindValue(4, $data['gender']);
		$stt->bindValue(5, $data['email']);
		$stt->bindValue(6, $data['content']);
    $stt->execute();
    return $this->db->lastInsertId();
  }

  /**
   * hobbys表に入力データを登録するメソッド
   *
   * @param array $str INSERT文の値の文字列
   *
   * @return int 登録されたレコード数
  */
  public function insertHobbys($str) {
    $sql = "INSERT INTO hobbys(hobby, contact_id)
            VALUES {$str};";
    $stt = $this->db->prepare($sql);
    $stt->execute();
    return $stt->rowCount();
  }
}