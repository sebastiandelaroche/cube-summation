<?php

require_once __DIR__."/Matrix.php";

$_fp = fopen(__DIR__."/input.txt", "r");

$T = fgets($_fp);

if (1 <= $T && $T <= 50) {
  $message = "";
  for($i = 0; $i < $T; $i++) {
    $configLine = fgets($_fp);
    $N = extractN($configLine);
    $M = extractM($configLine);

    if ((1 <= $N && $N <= 100) && (1 <= $M && $M <= 1000)) {
      $matrix = new Matrix($N);
      $matrix->createsMatrix();
      for($j = 0; $j < $M; $j++) {
        $line = fgets($_fp);
        $matrix->executeQuery($line);
      }
      $message .= $matrix->getMessage();
    }
  }
  echo $message;
}


function extractN($string) {
  $splitString = explode(" ", $string);
  return (int) $splitString[0];
}

function extractM($string) {
  $splitString = explode(" ", $string);
  return (int) $splitString[1];
}
