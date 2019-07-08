<?php

namespace neneone\SnapeBot;

class VariablesMaker {
  public function __construct($update) {
    $this->update = $update;
    $this->buildVariables($update);
  }
  private function buildVariables($update, $pr = '') {
    foreach($update as $k => $v) {
      if(is_array($v)) {
        if($pr == '') $this->buildVariables($v, $pr . $this->beautifyStringFirst($k));
        else $this->buildVariables($v, $pr . $this->beautifyString($k));
      } else {
        if($pr == '') $vname = $pr . $this->beautifyStringFirst($k);
        else $vname = $pr . $this->beautifyString($k);
        $this->{$vname} = $v;
      }
    }
  }
  private function beautifyStringFirst($str) {
    $e = explode('_', $str);
    $r = $e[0];
    unset($e[0]);
    foreach($e as $p) {
      $r .= ucfirst($p);
    }
    return $r;
  }
  private function beautifyString($str) {
    $e = explode('_', $str);
    $r = '';
    foreach($e as $p) {
      $r .= ucfirst($p);
    }
    return $r;
  }
}

 ?>
