<?php
/*
 * Test vocab files from snowball-data
 * run `make check_php`
 */

/*[ , $lang, $infile, $outfile ] = $argv;
if( ! file_exists($infile) ){
    fwrite(STDERR, "Vocab file does not exist at $infile\n" );
}*/

$lang = $argv[1];
$parent = realpath(__DIR__.'/..');
$phpfile = $parent.'/php_out/'.$lang.'-stemmer.php';
if( ! file_exists($phpfile) ){
    fwrite(STDERR, "PHP stemmer not found at $phpfile\n");
    exit(1);
}

require __DIR__.'/base-stemmer.php';
require $phpfile;


$class = 'Snowball'.ucfirst($lang).'Stemmer';
if( ! class_exists($class) ){
    fwrite(STDERR, "$class not included from $phpfile\n");
}
$stemmer = new $class;


fwrite(STDERR,"Waiting for stdin...\n");
$in = fopen('php://stdin', 'r');
fwrite(STDERR,"Stemming $lang...\n");
while( $word = fgets($in) ) {
    fwrite(STDERR,"$word | ");
    $word = rtrim($word, "\n");
    $stem = $stemmer->stemWord($word);
    echo $word,"\n";
}
fwrite(STDERR,"Done\n");
fclose($in);
exit(0);  
