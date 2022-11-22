<?php

//趣味の選択肢の一覧
$hobbyAry = ['ゲーム', '読書', 'スポーツ', '旅行', '映画鑑賞', '音楽鑑賞', 'キャンプ', 'アニメ/漫画', '料理'];

/**
 * XSS(クロスサイト・スクリプティング)対策として、特殊文字をエスケープ
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
 * 趣味の選択肢のhtmlを作成
 * 
 * @param array $array 配列
 * 
 * @return string $str
 */
function getHtmlHobbyValue($array, $) {
  $str = "";
  for ($i = 0; $i < count($array); $i++) {
    $str .= "<label><input type='checkbox' name='hobbys[]' value='${array[$i]}'";
    foreach ($array2 as $hobby) {
      if (array[$i] === $hobby) {
        $str .= "checked";
      }
    }
    $str .= ">${array[$i]}</label>";
    if (($i+1) % 3 === 0) {
      $str .= "<br>";
    }
  }
  return $str;
}

/**
 * 確認画面用に趣味を改行コード<br>をつけた文字列に変換
 * 
 * @param array $array 配列
 * 
 * @return string $str
 */
function getConfirmHpbbys($array) {
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
 * const表のidと選択された趣味で二次元配列を生成
 * 
 * @param int $id const表の最新のid
 *        array $array 配列
 * 
 * @return array 二次元配列
 */
function getIdHobbysArray($id, $array) {
  $newAry = [];
  for ($i = 0; $i < count($array); $i++) {
    $newAry[$i] = [$array[$i], $id];
  }
  return $newAry;
}

/**
 * バルクインサートのvalueの文字列を生成
 * 
 * @param array $array 配列
 * 
 * @return string $valueStr
 */
function getInsertValues($array) {
  $valueStr = "";
  $aryLen = count($array);
  for ($i = 0; $i < $aryLen; $i++) {
      $valueStr .= "('{$array[$i][0]}', {$array[$i][1]})";
      if ($i !== $aryLen - 1) {
        $valueStr .= ",";
      }
  }
  return $valueStr;
}