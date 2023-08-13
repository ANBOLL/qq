
<?php
include_once("views/header.php");
class Pagination
{
    public static function Navigation($page, $numPage, $showCount, $link)
    {
        if ($numPage == 1) {
            return false;
        }
        $sperator = ' ';
        $begin = $page - intval($showCount / 2);
        $pagination = '';
        
        if (($begin >= 1) && ($numPage - $showCount >= 1)) {
            $pagination .= sprintf('<a class="pagination_list_1" href="%s1/"><div class="arrow_first_page"></div></a>', $link);
        }
        
        for ($j = 0; $j <= $showCount; $j++) {
            $i = $begin + $j;
            
            if ($i < 1) {
                continue;
            }
            
            if ($i > $numPage) {
                break;
            }
            
            if ($i == $page) {
                $pagination .= sprintf('<a class="pagination_list active"><b>%d</b></a>', $i);
            } else {
                $pagination .= sprintf('<a class="pagination_list" href="%s%d/">%d</a>', $link, $i, $i);
            }
        }
        
        if ($begin + $showCount <= $numPage) {
            $pagination .= sprintf('<a class="pagination_list_1" href="%s%d/"><div class="arrow_last_page"></div></a>', $link, $numPage);
        }
        
        return $pagination;
    }
}


$page = 1;
$numPage = 10;
$showCount = 2;
$link = '#';

$pagination = Pagination::Navigation($page, $numPage, $showCount, $link);
echo $pagination;
