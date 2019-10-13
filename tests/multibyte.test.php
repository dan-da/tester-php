<?php

namespace tester;

class multibyte extends test_base {

    public function runtests() {
        $this->test1();
    }
    
    protected function test1() {
        $str = 'あまど あまやかす あまり あみもの あめりか あやまる あゆむ あらいぐま';
        
        $this->eq( $str, 'あまど あまやかす あまり あみもの あめりか あやまる あゆむ あらいぐま', 'japanese' );
        $this->eq( $this->shorten($str, 10), 'あまど あまや...', 'multibyte shorten (mb_substr)' );
    }

}
