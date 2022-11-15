<?php

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