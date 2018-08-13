<?php
/**
 * DokuWiki Plugin katex (Syntax Component)
 *
 * @license GPL 2 http://www.gnu.org/licenses/gpl-2.0.html
 * @author  wuqi <wuqi198772@gmail.com>
 */

// must be run within Dokuwiki
if (!defined('DOKU_INC')) die();

class syntax_plugin_katex_syntax extends DokuWiki_Syntax_Plugin {
    /**
     * @return string Syntax mode type
     */
    public function getType(){ return 'formatting'; }
    public function getAllowedTypes() { return array('formatting', 'substition', 'disabled'); }   
    public function getSort(){ return 158; }
    public function connectTo($mode) { $this->Lexer->addEntryPattern('<math.*?>(?=.*?</math>)',$mode,'plugin_katex_syntax'); }
    public function postConnect() { $this->Lexer->addExitPattern('</math>','plugin_katex_syntax'); }
 
 
    /**
     * Handle the match
     */
    public function handle($match, $state, $pos, Doku_Handler &$handler){
        switch ($state) {
          case DOKU_LEXER_ENTER :
                //list($color, $background) = preg_split("/\//u", substr($match, 6, -1), 2);
                //if ($color = $this->_isValid($color)) $color = "color:$color;";
                //if ($background = $this->_isValid($background)) $background = "background-color:$background;";
                //return array($state, array($color, $background));
                $result = preg_split("/[\s,]+/", substr($match,1,-1));
                return array($state, $result);
          case DOKU_LEXER_UNMATCHED :  return array($state, $match);
          case DOKU_LEXER_EXIT :       return array($state, '');
        }
        return array();
    }
 
    /**
     * Create output
     */
    public function render($mode, &$renderer, $data) {
        // $data is what the function handle() return'ed.
        if($mode == 'xhtml'){
            /** @var Doku_Renderer_xhtml $renderer */
            list($state,$match) = $data;
            switch ($state) {
                case DOKU_LEXER_ENTER : 
                    list($math,$disp) = $match;  
                    $renderer->doc .= '<span class="math" ><div>'; 
                    break;
 
                case DOKU_LEXER_UNMATCHED :  
                    //$renderer->doc .= $renderer->_xmlEntities($match); 
                    $renderer->doc .= $match;
                    break;
                case DOKU_LEXER_EXIT :       
                    $renderer->doc .= "</div></span>"; 
                    break;
            }
            return true;
        }
        return false;
    }
}

// vim:ts=4:sw=4:et:
