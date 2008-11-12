<?php
/**
 * Lister object. This object will work with any template containing tags <?items?> and <?item?>
 */
class sw_list extends sw_wrap { 
    function init(){
        parent::init();

        $i=$this->cloneRegion('item');
        if($this->template->is_set('separator')){
            $separator=$this->cloneRegion('separator')->render();
        }else{
            $separator=null;
        }
        $this->wrapping->del('items');

        $need_separator=false;
        // Now find all "item" inside the ref template
        foreach(array_keys($this->ref->template) as $tag){
            list($class,$junk)=split('#',$tag);
            if($class!='item')continue;
            $item_tpl=$this->ref->cloneRegion($tag);

            $this->grabTags($item_tpl);
            $i->set($this->data);

            $i->set('content',$item_tpl->render());

            if($need_separator && $separator){
                $this->wrapping->append('items',$separator);
            }
            $need_separator=true;

            //$this->tmpl['item']->set('text',$this->ref->get($tag));
            $this->wrapping->append('items',$this->tmpl['item']->render());
        }
    }
    function processRecursively(){
    }
}
