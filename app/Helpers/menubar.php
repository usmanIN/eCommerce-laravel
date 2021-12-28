<?php
use Illuminate\Support\Facades\DB;

function getMenuBar(){
    $categories = DB::table('categories')->get();

    $menu = [];
    foreach($categories as $row){
        $menu[$row->id]['city'] =  $row->categories_name;
        $menu[$row->id]['parent_id'] = $row->categories_parent;
    }

    return buildTreeView($menu,0);
    
}

$html = '';
function buildTreeView($arr,$parent, $level=0, $prelevel=-1){
    global $html;
    foreach($arr as $id => $data){
        if($parent == $data['parent_id']){
            if($level > $prelevel){
                $html.= ($html=='')?"<ul class='nav navbar-nav'>":"<ul class='dropdown-menu'>";
            }
            if($level==$prelevel){ $html.='</li>';}
            $html.='<li><a href="#">'.$data['city'].'<span class="caret"></span></a>';
            if($level > $prelevel) {$prelevel=$level;}
            $level++;
            buildTreeView($arr,$id,$level,$prelevel);
            $level--;
        }
    }
    if($level==$prelevel){ $html.='</li></ul>';}
    return $html;
}