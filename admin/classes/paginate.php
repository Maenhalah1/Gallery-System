<?php

class paginate{

    public $current_page;
    public $items_per_page;
    public $items_total_count;

    public function __construct($page=1,$items_page=4,$items_count=0){
        $this->current_page         = (int)$page;
        $this->items_per_page       = (int)$items_page;
        $this->items_total_count    = (int)$items_count;
    }

    public function next(){
        return (int)$this->current_page + 1;
    }

    public function previous(){
        return (int)$this->current_page - 1;
    }

    public function total_pages(){
        return (int)ceil($this->items_total_count / $this->items_per_page);
    }

    public function has_previous(){
        return $this->previous() >= 1 ? true : false;
    }

    public function has_next(){
        return $this->next() <= $this->total_pages() ? true : false;
    }
    //this function use to offset the number of element [use to sql statment ] based on number of page
    public function offset(){
        return ($this->current_page - 1) * $this->items_per_page;
    }

}



?>