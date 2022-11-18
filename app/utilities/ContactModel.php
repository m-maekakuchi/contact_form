<?php

class ContactModel {
  
  private $name;
  private $kana;
  private $tel;
  private $gender;
  private $email;
  private $confirmEmail;
  private $content;

  /**
   * プロパティの初期化
  */
  function __construct(
    $name,
    $kana,
    $tel,
    $gender,
    $email,
    $confirmEmail,
    $content
  )
  {
    $this->name = $name;
    $this->kana = $kana;
    $this->tel = $tel;
    $this->gender = $gender;
    $this->email = $email;
    $this->confirmEmail = $confirmEmail;
    $this->content = $content;
  }


  public function getName()
  {
    return $this->name;
  }

  public function getKana()
  {
    return $this->kana;
  }

  public function getTel()
  {
    return $this->tel;
  }

  public function getGender()
  {
    return $this->gender;
  }

  public function getEmail()
  {
    return $this->email;
  }

  public function getConfirmEmail()
  {
    return $this->confirmEmail;
  }

  public function getContent()
  {
    return $this->content;
  }

  public function setName($name)
  {
    $this->name = $name;
  }

  public function setKana($kana)
  {
    $this->kana = $kana;
  }

  public function setTel($tel)
  {
    $this->tel = $tel;
  }

  public function setGender($gender)
  {
    $this->gender = $gender;
  }

  public function seteEmail($email)
  {
    $this->email = $email;
  }

  public function setConfirmEmail($ConfirmEmail)
  {
    $this->ConfirmEmail = $ConfirmEmail;
  }

  public function setContent($content)
  {
    $this->content = $content;
  }
}