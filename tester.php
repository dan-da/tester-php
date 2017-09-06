#!/usr/bin/env php
<?php

namespace tester;

/*
 * This file implements a very basic test harness.
 */

// be safe and sane.  use strictmode if available via composer.
$autoload_file = __DIR__ . '/vendor/autoload.php';
if( file_exists( $autoload_file )) {
    require_once($autoload_file);
    \strictmode\initializer::init();
}

return exit(main($argv));

abstract class test_base {
    public $results = array();
    
    abstract public function runtests();
    
    private function backtrace() {
        ob_start();
        debug_print_backtrace();
        $trace = ob_get_contents();
        ob_end_clean();

        // Remove first item from backtrace as it's this function which
        // is redundant.
        $trace = preg_replace ('/^#0\s+' . __FUNCTION__ . "[^\n]*\n/", '', $trace, 1);

        return $trace;
    } 
    
    public function eq( $a, $b, $desc ) {
        $ok = $a == $b;
        $a = $a === null ? 'null' : $a;
        $b = $b === null ? 'null' : $b;
        $res = array( 'success' => $ok,
                      'desc' => $desc,
                      'assertion' => 'equality',
                      'result' => $ok ? "$a == $b" : "$a != $b",
                      'stack' => $this->backtrace() );
        $this->results[] = $res;
    }
    
    public function ne( $a, $b, $desc ) {
        $ok = $a != $b;
        $a = $a === null ? 'null' : $a;
        $b = $b === null ? 'null' : $b;
        $res = array( 'success' => $ok,
                      'desc' => $desc,
                      'assertion' => 'inequality',
                      'result' => $ok ? "$a != $b" : "$a == $b",
                      'stack' => $this->backtrace() );
        $this->results[] = $res;
    }

    public function gt( $a, $b, $desc ) {
        $ok = $a > $b;
        $a = $a === null ? 'null' : $a;
        $b = $b === null ? 'null' : $b;
        $res = array( 'success' => $ok,
                      'desc' => $desc,
                      'assertion' => 'greatherthan',
                      'result' => $ok ? "$a > $b" : "$a <= $b",
                      'stack' => $this->backtrace() );
        $this->results[] = $res;
    }

    public function lt( $a, $b, $desc ) {
        $ok = $a < $b;
        $a = $a === null ? 'null' : $a;
        $b = $b === null ? 'null' : $b;
        $res = array( 'success' => $ok,
                      'desc' => $desc,
                      'assertion' => 'greatherthan',
                      'result' => $ok ? "$a < $b" : "$a >= $b",
                      'stack' => $this->backtrace() );
        $this->results[] = $res;
    }
}

class test_printer {

    static public function print_status( $testname ) {
        echo "Running tests in $testname...\n";
    }
    
    static public function print_results( $results ) {
        $pass_cnt = 0;
        $fail_cnt = 0;
        foreach( $results as $r ) {
            if( $r['success'] ) {
                echo sprintf( "[pass] %s  |  %s\n", $r['result'], $r['desc'] );
                $pass_cnt ++;
            }
            else {
                echo sprintf( "[fail] %s  |  %s\n%s\n\n", $r['result'], $r['desc'], $r['stack'] );
                $fail_cnt ++;
            }
        }
    
        echo "\n\n";    
        echo sprintf( "%s tests passed.\n", $pass_cnt );
        echo sprintf( "%s tests failed.\n", $fail_cnt );
        echo "\n\n";    
    }
}

function run_test($filename) {

    require( $filename );
    $classname = basename( $filename, '.test.php' );

    test_printer::print_status( $classname );
    $fullclassname = __NAMESPACE__ . '\\' . $classname;
    $testobj = new $fullclassname();
    $testobj->runtests();
    return $testobj->results;
    
}

function main($argv) {

    $results = array();
    
    if( count($argv) > 1 ) {
        $results = run_test( $argv[1] );
    }
    else {
        $tests = glob('./*.test.php' );
        foreach( $tests as $test ) {
            $results = array_merge( $results, run_test( $test ) );
        }
    }
    
    test_printer::print_results( $results );
}


?>
