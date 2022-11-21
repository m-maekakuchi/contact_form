<?php

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