<?php 

function pagination($results, $rows=10){
	$html = '';
	
	if ($results->pagination()->hasPages()){
        
        $html .= '<nav class="pagination">';
        if($results->pagination()->hasPrevPage()){
         	$html .= '<a class="prev icon-arrow-left" href="' . $results->pagination()->prevPageURL() . '"><span>prev</span></a>';
        }

        if($results->pagination()->hasNextPage()){
            $html .= '<a class="next icon-arrow-right" href="' . $results->pagination()->nextPageURL() . '"><span>next</span></a>';
        }
        $html .= '</nav>';
    }
    return $html;
}

?>