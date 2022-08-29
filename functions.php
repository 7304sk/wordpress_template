<?php

/** 標準の言語設定 */
$page_lang = 'ja';

/** editor-style へのパス */
$editor_style = 'assets/stylesheet/editor-style.css';

/**
* 標準のテーマ設定は分割して functions/ ディレクトリ以下に格納
*/
foreach ( glob( get_template_directory() . '/functions/*.php' ) as $filename ) {
    require_once $filename;
}