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
 * @param array $ary 配列
 * 
 * @return string html
 */
function getHtmlHobbyValue($ary) {
  $str = "";
  for ($i = 0; $i < count($ary); $i++) {
    $str .= "<label><input type='checkbox' name='hobbys[]' value='${ary[$i]}'>${ary[$i]}</label>";
    if (($i+1) % 3 === 0) {
      $str .= "<br>";
    }
  }
  return $str;
}

/**
 * const表のidと選択された趣味で二次配列を作成
 * 
 * @param int $id const表の最新のid
 *        array $ary 配列
 * 
 * @return array 二次元配列
 */
function getIdHobbysAry($id, $array) {
  $newAry = [];
  for ($i = 0; $i < count($array); $i++) {
    $newAry[$i] = [$id, $array[$i]];
  }
  return $newAry;
}

/**
 * バルクインサートのvalue群を作成
 * 
 * @param array $ary 配列
 * 
 * @return string $valueStr
 */
function getInsertValues($array) {
  $values = "";
  $hobbysColumNum = 2;
  $aryLen = count($array);
  for ($i = 0; $i < $aryLen; $i++) {
    $values .= "({$array[$i][0]}, {$array[$i][1]})";
    if ($i !== $aryLen - 1) {
      $values .= ",";
    }
  }
}