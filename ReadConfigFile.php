<?php

class ReadConfigFile {
  public function __construct($filePath) {
    $this->filePath = $filePath;
  }

  public execute() {
    $file = $this->readFile();
  }

  private function readFile() {
    return fopen(__DIR__."/input.txt", "r");;
  }

}
