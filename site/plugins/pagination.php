<?php 

function pagination($results, $rows=10){
	$html = '';
	
	if ($results->pagination()->hasPages()){
        
        $html .= '<nav class="pagination">';
        if($results->pagination()->hasPrevPage()){
         	$html .= '<a class="prev" href="' . $results->pagination()->prevPageURL() . '">&lt;</a>';
        }

        if($results->pagination()->hasNextPage()){
            $html .= '<a class="next" href="' . $results->pagination()->nextPageURL() . '">&gt;</a>';
        }
        $html .= '</nav>';
    }
    return $html;
}

?>