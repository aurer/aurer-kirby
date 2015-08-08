<?php

function pagination($results){
	$html = '';
    $pagination = $results->pagination();
    $range = $pagination->range(5);

	if ($pagination->hasPages()) {

        $html .= '<nav class="pagination">';
        if($pagination->hasPrevPage()){
         	$html .= '<a class="pagination-prev" href="' . $pagination->prevPageURL() . '">prev</a>';
        } else {
            $html .= '<span class="pagination-prev">prev</span>';
        }

        if ($pagination->rangeStart() > 1) {
            $html .= '<span class="pagination-range">...</span>';
        }

        foreach($range as $paging) {
            $active_class = $paging == $pagination->page() ? ' active' : '';
            $html .= '<a class="pagination-page' . $active_class . '" href="' . $pagination->pageURL($paging) . '">' . $paging . '</a>';
        }

        if ($pagination->rangeEnd() < $pagination->pages()) {
            $html .= '<span class="pagination-range">...</span>';
        }

        if($pagination->hasNextPage()){
            $html .= '<a class="pagination-next" href="' . $pagination->nextPageURL() . '">next</a>';
        } else {
            $html .= '<span class="pagination-next">next</span>';
        }
        $html .= '</nav>';
    }
    return $html;
}

?>
