<?php
/**
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Brend Wanders <b.wanders@utwente.nl>
 */
// must be run within Dokuwiki
if(!defined('DOKU_INC')) die('Meh.');

/**
 * The modification aggregator.
 */
class plugin_strata_aggregate_modify extends plugin_strata_aggregate {
    function aggregate($values, $hint = null) {
		$result = array();
		foreach($values as $val) {
			$result[] = str_replace('{}', $val, $hint);
		}
		return $result;
    }

    function getInfo() {
        return array(
            'desc'=>'Modifies every element by replacing it with the hinted pattern.',
			'hint'=>'a replacement pattern, use {} as placeholder for the old value',
            'tags'=>array()
        );
    }
}
