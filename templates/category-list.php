<?php

$_block =  '<div class="grid">';
    // $_block .=  '<div class="row">';
        foreach($categories['children'] as $cat) {
            echo $cat['name'] . '<br/>';
        }
    // $_block .= '</div>';
$_block .=  '</div>';

echo $_block;