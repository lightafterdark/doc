<?php

function T_write($filename, $string) {
    $fp = fopen($filename, 'a');  // 追加方式打开
    if (flock($fp, LOCK_EX)) {   // 加写锁：独占锁
        fputs($fp, $string);   // 写文件
        flock($fp, LOCK_UN);   // 解锁
    }
    fclose($fp);
}