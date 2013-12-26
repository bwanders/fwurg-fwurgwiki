<?php
/**
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Brend Wanders <b.wanders@utwente.nl>
 */
// must be run within Dokuwiki
if(!defined('DOKU_INC')) die('Meh.');

/**
 * The reference link type.
 */
class plugin_strata_type_faction extends plugin_strata_type_page {
    function render($mode, &$R, &$T, $value, $hint) {
        $heading = null;
				$util =& plugin_load('helper', 'strata_util');

        // only use heading if allowed by configuration
        if(useHeading('content')) {
            $titles = $T->fetchTriples($value, $util->getTitleKey());
            if($titles) {
                $heading = $titles[0]['object'];
            }
        }

        $size = 24;
        if($hint == 'icon') $size = 14;
        if($hint == 'large') $size = 48;

        if(is_numeric($hint)) $size = max(14, min((int)$hint, 256) );

        // render internal link
        // (':' is prepended to make sure we use an absolute pagename,
        // internallink resolves page names, but the name is already resolved.)
        $R->internallink(':'.$value, array(
            'type'=>'externalmedia',
            'src'=>"http://www.fwurg.net/images/special/logo/{$value}/{$size}x{$size}.png",
            'title'=>$heading,
            'align'=>null,
            'width'=>null,
            'height'=>null,
            'cache'=>'nocache',
            'linking'=>'nolink'
        ));
    }

    function getInfo() {
        return array(
            'desc'=>'Displays a factions blazonry as a link to the faction.',
            'hint'=>'\'normal\', \'icon\', \'large\' or a number between 14 and 256. Defaults to \'normal\'.'
        );
    }
}
