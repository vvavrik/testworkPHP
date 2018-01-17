<?php

namespace \views\elements;

class Table {

  use DataProcess;

  public $TH;
  public $TH_ROW;
  public $TD;
  public $TR;
  public $TF;

      public function th($content, $colspan, $rowspan) {
          $html = '<TH';
          if ((integer)$colspan > 0) {
            $html .= ' colspan='.((integer)$colspan);
          }
          if ((integer)$rowspan > 0) {
            $html .= ' rowspan='.((integer)$rowspan);
          }
          $html .= '>'.$this->clearString($content).'</TH>';
          $this->TH .= $html;
      }

      public function endTHRow() {
          $this->TH_ROW .= '<TR>'.$this->TH.'</TR>';
          $this->TH = '';
      }

      private function getHead() {
          if (strlen($this->TH_ROW) > 0) {                  # multirow header
              $html = '<THEAD>'.$this->TH_ROW.'</THEAD>';
          }
          else {
              if (strlen($this->TH) > 0) {
                  $html = '<THEAD><TR>'.$this->TH.'</TR></THEAD>';
              }
          }
          return $html;
      }

      public function td($content, $colspan, $rowspan) {
        $html = '<TD';
        if ((integer)$colspan > 0) {
          $html .= ' colspan='.((integer)$colspan);
        }

        if ((integer)$rowspan > 0) {
          $html .= ' rowspan='.((integer)$rowspan);
        }
        $html .= '>'.$content.'</TD>';
        $this->TD .= $html;
      }

      public function tdClass($content, $class, $colspan, $rowspan) {
        $html = '<TD class="'.$class.'"';
        if ((integer)$colspan > 0) {
          $html .= ' colspan='.((integer)$colspan);
        }

        if ((integer)$rowspan > 0) {
          $html .= ' rowspan='.((integer)$rowspan);
        }
        $html .= '>'.$content.'</TD>';
        $this->TD .= $html;
      }

      public function endRow() {
        $html = '<TR>'.$this->TD.'</TR>';
        $this->TR .= $html;
        $this->TD = '';
      }

    private function getBody() {
      if (strlen($this->TR) > 0) {
        $html = '<TBODY>'.$this->TR.'</TBODY>';
        return $html;
      }
    }

      public function tf($content, $colspan, $rowspan) {
        $html = '<TD';
        if ((integer)$colspan > 0) {
          $html .= ' colspan='.((integer)$colspan);
        }
        if ((integer)$rowspan > 0) {
          $html .= ' colspan='.((integer)$rowspan);
        }
        $html .= '>'.$this->clearString($content).'</TD>';
        $this->TF .= $html;
      }

    private function getFoot() {
      if (strlen($this->TF) > 0) {
        $html = '<TFOOT><TR>'.$this->TF.'</TR></TFOOT>';
        return $html;
      }
    }

  public function getTable() {
    $html = '<TABLE>';
    $html .= $this->getHead();
    $html .= $this->getBody();
    $html .= $this->getFoot();
    $html .= '</TABLE>';
    return $html;
  }
}
?>
