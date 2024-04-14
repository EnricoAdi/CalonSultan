<?php

/** 
 * @param int $length Length of the String 
 * @return string the generated random string 
 */
function randomAlphaNumeric(int $length): string
{
  $result = "";

  for ($i = 0; $i < $length; $i++) {
    $z = rand(65, 122);
    if ($z < 97 && $z > 90) {
      $z = rand(65, 122);
    }
    $result .= chr($z);
  }

  return $result;
}
