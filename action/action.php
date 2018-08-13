<?php
/**
 * DokuWiki Plugin katex (Action Component)
 *
 * @license GPL 2 http://www.gnu.org/licenses/gpl-2.0.html
 * @author  wuqi <wuqi198772@gmail.com>
 */

// must be run within Dokuwiki
if(!defined('DOKU_INC')) die();

class action_plugin_katex_action extends DokuWiki_Action_Plugin {

    /**
     * Registers a callback function for a given event
     *
     * @param Doku_Event_Handler $controller DokuWiki's event controller object
     * @return void
     */
    public function register(Doku_Event_Handler $controller) {

       $controller->register_hook('TPL_METAHEADER_OUTPUT', 'BEFORE', $this, 'handle_tpl_metaheader_output');
   
    }

    /**
     * [Custom event handler which performs action]
     *
     * @param Doku_Event $event  event object by reference
     * @param mixed      $param  [the parameters passed as fifth argument to register_hook() when this
     *                           handler was registered]
     * @return void
     */

    public function handle_tpl_metaheader_output(Doku_Event &$event, $param) {
        $event->data["link"][] = array (
          "type" => "text/css",
          "rel" => "stylesheet", 
          "href" => $this->getConf('csslink'),
        );
        $event->data['script'][] = array(
            'type'    => 'text/javascript',
            'charset' => 'utf-8',
            'src'     => $this->getConf('jslink'),
            '_data'   => '',
        );
        // Adding JavaScript Code
        $event->data["script"][] = array (
          "type" => "text/javascript",
          "charset" => "utf-8",
          "_data" => 'document.onreadystatechange=function(){if(document.readyState=="complete"){var elements=document.getElementsByClassName("math");for(var i=0,length=elements.length;i<length;i++){var content=elements[i].firstChild.innerHTML;try{katex.render(content,elements[i].firstChild)}catch(err){elements[i].firstChild.innerHTML="<span class=\"err\">"+err}}}}',
        );
    }

}

// vim:ts=4:sw=4:et:
