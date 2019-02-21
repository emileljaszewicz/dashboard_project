<?php
$panels = [];
for($i = 0; $i < 50; $i++){
    $panels[] = ['divHtml' =>'<div class="animate-panel"><div id="panel_'.$i.'" class="panel-content"></div></div>', 'widthAfter' => 100, 'heightAfter' => 500];
}

echo json_encode($panels);