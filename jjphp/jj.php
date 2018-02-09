<?php
namespace jj\c;
class c {
    public function __construct() {
        if(method_exists($this,'_init'))
            $this->_init();
    }
}
?>