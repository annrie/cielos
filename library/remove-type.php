<?php
/**
 * ACF Option Pages
 *
 * PHP Version >=7.0
 *
 * @category unomoon
 * @package.json  unomoon
 * @author   annrie <blastspinner @gmail.com>
 * @license  MIT
 * @link     https://unomoon.cielos.com
 */

// プラグインが出す <script> / <style> / <link> の type="text/javascript|css" を消す（HTML5 では不要）。
// 消すのは開始タグの属性だけ。ページ全体の文字列を置換すると、インラインスクリプトの中の
// r.type="text/css" まで削れて構文エラーになる（unomoon で EnlighterJS が壊れていた）
add_action(
    'template_redirect',
    function () {
        ob_start(
            function ( $html ) {
                $out = preg_replace(
                    '#(<(?:script|style|link)\b[^>]*?)\s+type=([\'"])text/(?:javascript|css)\2#i',
                    '$1',
                    $html
                );
                // 失敗すると null が返り、そのまま返すとページが真っ白になる。元の HTML を返し、原因を残す
                if ($out === null) {
                    error_log('[cielos] remove-type.php: preg_replace failed: ' . preg_last_error_msg());
                    return $html;
                }
                return $out;
            }
        );
    }
);
