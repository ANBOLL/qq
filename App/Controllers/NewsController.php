<?php
namespace App\Controllers;
use App\Models\NewsModel;
class NewsController
{
    public $LIMIT = 4;

    public function actionList($page)
    {
        $number = ($page * $this->LIMIT) - $this->LIMIT;
        $total = NewsModel::getCount();
        $query = NewsModel::getList($number, $this->LIMIT);
        $resi = NewsModel::getList($number, 1);
        $numPage = ceil($total / $this->LIMIT);
        $link = "/news/page-";
        $showCount = 2;
        $begin = $page - intval($showCount / 2);
        $paginat= $this->Navigation($page, $numPage, 2, $link);
        $array = [
            'numPage' => $numPage,
            'query' => $query,
            'resi' => $resi,
            'page' => $page,
            'link' => $link,
            'begin' => $begin,
            'showCount' => $showCount,
            'paginat' => $paginat,
        ];
        
        $this->render('/news/list', $array);
    }

    public function actionDetail($id)
    {
        $row = NewsModel::getItem($id);
        $array = [
            'row' => $row,
        ];
        $this->render('/news/detail', $array);
    }

    public function render($file, $array)
    {
        extract($array);
        require('views/' . $file . '.php');
    }

    public function getPage($arr)
    {
        extract($arr);
        if (isset($_GET['page'])) {
            $page = $_GET['page'];
        } else {
            $page = 1;
        }
        $page = [
            'page' => $page,
        ];
    }

    public function Navigation($page, $numPage, $showCount, $link)
    {
        if ($numPage == 1) {
            return false;
        }
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