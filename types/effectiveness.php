<?php
/**
 * fwurgwiki plugin, dot type
 *
 * @author  Brend Wanders <b.wanders@xs4all.nl>
 */

class plugin_strata_type_effectiveness extends plugin_strata_type {
	// The characters to display
    private $open =   '&#9744;';
    private $closed = '&#9746;';

    function normalize($value, $hint) {
        return (int)$value;
    }

    function render($mode, &$R, &$T, $value, $hint) {
        if($mode == 'xhtml') {
            $value = (int)$value;

            $track_0 = 1;
            $track_1 = 2;
            $track_incap = 3;

            if(preg_match('@([0-9]+)/([0-9]+)/([0-9]+)@',$hint,$m)) {
                $track_0 = (int)$m[1];
                $track_1 = (int)$m[2];
                $track_incap = (int)$m[3];
            }

            $track = $track_0 + $track_1 + $track_incap;
          
            $dots = str_repeat($this->closed, max(0,$track-$value));
            $dots .= str_repeat($this->open,max(0,$value));
            $dots = str_split($dots, 7);

            $result = '-0: ';
            for($x = 0;$x<$track_0;$x++) $result .= array_shift($dots);
            $result .= ', -1: ';
            for($x = 0;$x<$track_1;$x++) $result .= array_shift($dots);
            $result .= ', Incap.: ';
            for($x = 0;$x<$track_incap;$x++) $result .= array_shift($dots);

            $R->doc .= trim($result);
            return true;
        }

        return false;
    }

    function getInfo() {
        return array(
            'desc'=>'Shows a number as a track of effectiveness levels.',
            'tags'=>array('numeric'),
            'hint'=>'Optional distribution of levels (default \'1/2/3\')'
        );
    }
}
