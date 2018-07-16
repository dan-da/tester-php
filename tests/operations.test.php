<?php

namespace tester;

class operations extends test_base {

    public function runtests() {
        $this->test1();
    }
    
    protected function test1() {
        
        $this->contains( "catch", 'atc', 'con' );
        $this->not_contains( "catch", 'batc', 'notcon' );
        $this->matches( "catch", '/.atc./', 'regex' );
        $this->starts_with( "abcdef", "abc", 'sw' );
        $this->ends_with( "abcdef", "def", 'def' );
        $this->has_key( [1,2,3], 1, 'key 1' );
        $this->has_key( ['clr' => 'red'], 'clr', 'key clr' );
        $this->count_eq( [1,2,3], 3, 'cnt 3' );
        $this->count_lt( [1,2,3], 5, 'cnt 5' );
        $this->count_gt( [1,2,3], 2, 'cnt 2' );
        $this->count_gte( [1,2,3], 3, 'cnt 3' );
        $this->count_lte( [1,2,3], 3, 'cnt 3' );
        $this->is_empty( "", 'em str' );
        $this->is_empty( [], 'em arr' );
        $this->is_empty( null, 'em' );
        $this->not_empty( 5, 'nem int' );
        $this->not_empty( "5", 'nem str' );
        $this->not_empty( ["5"], 'nem arr' );
        $this->is_null( null, 'null' );
        $this->not_null( "", 'str' );
        $this->not_null( 0, 'zero' );
        $this->not_null( [], 'zero' );
        $this->is_int( 5, 'five' );
        $this->is_float( 3.14, 'pi' );
        $this->is_hex( 'acDef', 'hex1' );
        $this->is_hex( '0xacDef', 'hex1 0x' );
        $this->is_string( '0xacDef', 'str' );
        $this->is_array( [], 'arr' );
        $this->is_object( new \stdClass(), 'obj' );
        
    }

}
