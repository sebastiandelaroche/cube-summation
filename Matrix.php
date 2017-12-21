<?php

class Matrix {

  private $matrix;
  private $n;
  private $message;

  public function getMessage() { return $this->message; }

  public function __construct($n) {
    $this->matrix = [];
    $this->n = $n;
    $this->message = "";
  }

  public function createsMatrix() {
    for($i = 0; $i <= $this->n; $i++) {
      $this->matrix[$i] = [];
      for($j = 0; $j <= $this->n; $j++) {
        $this->matrix[$i][$j] = [];
        for($k = 0; $k <= $this->n; $k++) {
          $this->matrix[$i][$j][$k] = 0;
        }
      }
    }
  }

  public function executeQuery($intructionLine) {
    $matches = preg_split("/[\s]+/", $intructionLine);
    switch($matches[0]) {
      case "UPDATE":
        list($type, $x, $y, $z, $value) = $matches;
        $this->update($x, $y, $z, $value);
        break;
      case "QUERY":
        list($type, $x1, $y1, $z1, $x2, $y2, $z2) = $matches;
        $result = $this->query($x1, $y1, $z1, $x2, $y2, $z2);
        $this->buildMessage($result);
        break;
    }
  }

  private function update($x, $y, $z, $value) {
    if ($x <= $this->n && $y <= $this->n && $z <= $this->n
      && -pow(10, 9) <= $value && $value <= pow(10, 9)) {
      $this->matrix[$x][$y][$z] += $value;
    }
  }

  private function query($x1, $y1, $z1, $x2, $y2, $z2) {
    if (!((1 <= $x1 && $x2 <= $this->n) && (1 <= $y1 && $y2 <= $this->n)
      && (1 <= $z1 && $z2 <= $this->n))) return 0;

    if (($x1 == $x2) && ($y1 == $y2) && ($z1 == $z2))
      return $this->extractValueByBlock($x1, $y1, $z1);

    $block1 = $this->extractValueByBlock($x1, $y1, $z1);
    $block2 = $this->extractValueByBlock($x2, $y2, $z2);

    if (($x1 + 1) == $x2 && ($y1 + 1) == $y2 && ($z1 + 1) == $z2) {
      return $block1 + $block2;
    } else {
      $block3 = $this->extractValueByBlock($x1 + 1, $y1 + 1, $z1 + 1);
      return $block1 + $block2 + $block3;
    }
  }

  private function extractValueByBlock($x, $y, $z) {
    return $this->matrix[$x][$y][$z];
  }

  private function buildMessage($result) {
    $this->message .= $result . "<br>";
  }

}
