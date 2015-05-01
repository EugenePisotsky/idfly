<?php
$string = $argv[1];

function match($string)
{
    $symbols = [
        ['[', ']'],
        ['{', '}'],
        ['(', ')']
    ];

    $mainLength = mb_strlen($string, 'UTF-8');
    $subLength = 0;
    foreach ($symbols as $symb) {
        list ($s1, $s2) = $symb;

        $reg = '~(?= ( \\'.$s1.' (?: [^\\'.$s1.'\\'.$s2.']+ | (?1) )*+ \\'.$s2.' ) )~x';
        preg_match_all($reg, $string, $matches);

        foreach ($matches[1] as $m) {
            $l = mb_strlen($m, 'UTF-8');
            if ($subLength < $l)
                $subLength = $l;

            foreach ($symbols as $value) {
                if (substr_count($m, $value[0]) != substr_count($m, $value[1]))
                    return false;
            }
        }
    }

    if ($subLength < $mainLength)
        return false;

    return true;
}

if (match($string)) {
    exit("all right\n");
}

exit("fail\n");