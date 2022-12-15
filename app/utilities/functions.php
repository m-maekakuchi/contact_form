<?php

//趣味の選択肢の一覧
$hobbyAry = ['ゲーム', '読書', 'スポーツ', '旅行', '映画鑑賞', '音楽鑑賞', 'キャンプ', 'アニメ/漫画', '料理'];

/**
 * XSS(クロスサイト・スクリプティング)対策として、特殊文字をエスケープするメソッド
 * 
 * @param string $str 文字列
 * 
 * @return string エスケープされた文字列
 */
function escape($str) 
{
  return htmlspecialchars($str, ENT_QUOTES | ENT_HTML5, 'UTF-8', false);
}

/**
 * チェックボックスのhobbysが不正な値を含んでいないか判定するメソッド
 * 
 * @param array $array 選択された趣味の配列
 * 
 * @return boolean
 */
function checkHobbysValues($array) 
{
  global $hobbyAry;
  if(count($array) > 0) {
    foreach ($array as $str) {
      $correctNum = 0;
      foreach ($hobbyAry as $hobby) {
        if ($str === $hobby) {
        $correctNum++; 
        }
      }
      //選択された趣味のvalue値がhobbyAry配列にない場合
      if($correctNum === 0) {
        return true;
      }
    }
    return false;
  } else {
    return false;
  }
}

/**
 * 趣味の選択肢のhtmlを作成
 * 
 * @param array $array 選択された趣味の配列
 * 
 * @return string $str
 */
function getHtmlHobby($array)
{
  $str = "";
  global $hobbyAry;
  $aryLen = count($hobbyAry);
  for ($i = 0; $i < $aryLen; $i++) {
    $str .= "<label><input type='checkbox' name='hobbys[]' value='${hobbyAry[$i]}'";
    //選択された趣味がある場合、checked属性を追加
    if (count($array) > 0) {
      foreach ($array as $hobby) {
        if ($hobbyAry[$i] === $hobby) {
          $str .= "checked";
        }
      }
    }
    $str .= ">${hobbyAry[$i]}</label>";
    if (($i+1) % 3 === 0) {
      $str .= "<br>";
    }
  }
  return $str;
}

/**
 * チェックボックスで選択された趣味の配列を
 * 改行の<br>をつけた文字列に変換
 * 
 * @param array $array 選択された趣味の配列
 * 
 * @return string $str
 */
function getConfirmHobbys($array)
{
  $aryLen = count($array);
  $str = "";
  for ($i = 0; $i < $aryLen; $i++) {
    $str .= "{$array[$i]}";
    if ($i !== $aryLen - 1) {
      $str .= "<br>";
    }
  }
  return $str;
}

/**
 * const表のidと選択された趣味で
 * 二次元配列を生成
 * 
 * @param string $id    const表の最新のid
 *        array  $array 選択された趣味の配列
 * 
 * @return array 二次元配列
 */
function getIdHobbysArray($id, $array)
{
  $newAry = [];
  for ($i = 0; $i < count($array); $i++) {
    $newAry[$i] = [$array[$i], $id];
  }
  return $newAry;
}

/**
 * バルクインサートのvalueの文字列を生成
 * 
 * @param array $array 選択された趣味の配列
 * 
 * @return string $str
 */
function getInsertValues($array)
{
  $str = "";
  $aryLen = count($array);
  for ($i = 0; $i < $aryLen; $i++) {
    $str .= "('{$array[$i][0]}', {$array[$i][1]})";
    if ($i !== $aryLen - 1) {
      $str .= ",";
    }
  }
  return $str;
}