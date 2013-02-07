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
class plugin_strata_type_imagelink extends plugin_strata_type_page {
    function render($mode, &$R, &$T, $value, $hint) {
        $heading = null;

        // only use heading if allowed by configuration
        if(useHeading('content')) {
            $titles = $T->fetchTriples($value, $T->getTitleKey());
            if($titles) {
                $heading = $titles[0]['object'];
            }
        }

        $images = $T->fetchTriples($value, 'Image');
        if($images) {
            $image = $images[0]['object'];
        }

        $size = 48;
        if($hint == 'full') $size = null;
        if($hint == 'icon') $size = 16;

        if(is_numeric($hint)) $size = max(16, min((int)$hint, 300) );

        if(preg_match('#^(https?|ftp)#i', $image)) {
            $type = 'externalmedia';
        } else {
            $type = 'internalmedia';
        }

        // render internal link
        // (':' is prepended to make sure we use an absolute pagename,
        // internallink resolves page names, but the name is already resolved.)
        $R->internallink(':'.$value, array(
            'type'=>$type,
            'src'=>$image,
            'title'=>$heading,
            'align'=>null,
            'width'=>$size,
            'height'=>$size,
            'cache'=>'nocache',
            'linking'=>'nolink'
        ));
    }

    function getInfo() {
        return array(
            'desc'=>'Displays the \'Image\' field of the reference as a link.',
            'hint'=>'\'normal\', \'icon\', a number between 16 and 300, or \'full\'. Defaults to \'normal\'.'
        );
    }
}
