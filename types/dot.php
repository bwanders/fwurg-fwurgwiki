<?php
/**
 * fwurgwiki plugin, dot type
 *
 * @author  Brend Wanders <b.wanders@xs4all.nl>
 */

class plugin_strata_type_dot extends plugin_strata_type {
	// The characters to display
    private $open =   '&#9675;';
    private $closed = '&#9679;';

    function normalize($value, $hint) {
        return (int)$value;
    }

    function render($mode, &$R, &$T, $value, $hint) {
        if($mode == 'xhtml') {
            $value = (int)$value;
            $track = 1;

            // get the settings (if given)
            preg_match_all('/(t|g)([0-9]+)/S',$hint,$matches,PREG_SET_ORDER);
            foreach($matches as $m) {
                switch($m[1]) {
                    case 't': $track = (int)$m[2]; break;
                    case 'g': $grouping = (int)$m[2]; break;
                }
            }

            // create filled dots
            $dots =  str_repeat($this->closed,$value);

            // fill up to the required track length
            if(isset($track)) {
                $dots .= str_repeat($this->open,max(0,$track-$value));
            }

            // split into groups and add spaces
            if(isset($grouping)) {
                $dots = chunk_split($dots, 7*$grouping, ' ');
            }

            // render with big tags for good visuals
            $R->doc .= '<big>' . trim($dots)  .'</big>';
            return true;
        }

        return false;
    }

    function getInfo() {
        return array(
            'desc'=>'Shows numbers as a string of dots. The type hint is used to add a track size (as \'tN\') and group size (as \'gN\').',
            'tags'=>array('numeric'),
            'hint'=>'\'tN\', \'gN\', or both'
        );
    }
}
