<?php
/**
 * DokuWiki Plugin fwurwiki (Action Component)
 *
 * @license GPL 2 http://www.gnu.org/licenses/gpl-2.0.html
 * @author  Brend Wanders <b.wanders@utwente.nl>
 */

// must be run within Dokuwiki
if (!defined('DOKU_INC')) die('Meh.');

class action_plugin_fwurgwiki extends DokuWiki_Action_Plugin {
    /**
     * Register function called by DokuWiki to allow us
     * to register events we're interested in.
     *
     * @param controller object the controller to register with
     */
    public function register(Doku_Event_Handler &$controller) {
        $controller->register_hook('COMMON_PAGETPL_LOAD', 'BEFORE', $this, '_template_load');
				$controller->register_hook('DOKUWIKI_STARTED', 'BEFORE', $this, '_postinit');
    }

    public function _template_load(&$event, $param) {
        if(!empty($_REQUEST['fwurg_wiki_template'])) {
            // fetch template string from request
            $template = $_REQUEST['fwurg_wiki_template'];

            // fix windows-based browser newlines
            $template = str_replace("\r\n", "\r", $template);

            // set template parameters
            $event->data['tpl'] = $template;
            $event->data['doreplace'] = false;
        }
    }

		public function _postinit(&$event, $param) {
        // reset the purge flag if scour is set
        // this counters the unset of (inc/init.php:176)
        if(isset($_REQUEST['scour'])) $_REQUEST['purge'] = true;
		}
}
