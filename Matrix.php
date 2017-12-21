<?php
/**
 * Matrix
 *
 * @author: sebastian.delaroche
 *
 * @description
 * class with business rule to operate the querys in a matrix
 * @nota: this class implement "fenwick tree alghoritm"
 */

class Matrix {

  // attributes

  /**
   * [$matrix 3d]
   * @var [array[n][n][n]]
   */
  private $matrix;
  /**
   * [$n]
   * @var [interger]
   */
  private $n;
  /**
   * [$message]
   * @var [string]
   */
  private $message;

  // properties

  /**
   * [getMessage gets messages by each test cases]
   * @return [string]
   */
  public function getMessage() { return $this->message; }

  /**
   * [__construct description]
   * @param [integer] $n [defines matrix]
   */
  public function __construct($n) {
    $this->matrix = [];
    $this->n = $n;
    $this->message = "";
  }

  /**
   * [createsMatrix creates matrix and initialize it]
   */
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

  /**
   * [executeQuery execute query by each line inside cases test]
   * @param  [string] $intructionLine [instructions]
   */
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

  /**
   * [update updates a position of the matrix]
   * @param  [integer] $x
   * @param  [integer] $y
   * @param  [integer] $z
   * @param  [integer] $value
   */
  private function update($x, $y, $z, $value) {
    if ($x <= $this->n && $y <= $this->n && $z <= $this->n
      && -pow(10, 9) <= $value && $value <= pow(10, 9)) {
      $this->matrix[$x][$y][$z] += $value;
    }
  }

  /**
   * [query finds the value in a specific position of the matrix]
   * @param  [type] $x1
   * @param  [type] $y1
   * @param  [type] $z1
   * @param  [type] $x2
   * @param  [type] $y2
   * @param  [type] $z2
   * @return [integer]
   */
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

  /**
   * [extractValueByBlock]
   * @param  [integer] $x
   * @param  [integer] $y
   * @param  [integer] $z
   */
  private function extractValueByBlock($x, $y, $z) {
    return $this->matrix[$x][$y][$z];
  }

  /**
   * [buildMessage builds message by each cases test]
   * @param  [type] $result
   */
  private function buildMessage($result) {
    $this->message .= $result . "<br>";
  }

}
