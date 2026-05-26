<?php
//bekende vars: $page, $total_pages, $page_url
// begin met div...
echo '<div class="pagination">';
//vorige pagina
if ($page>1) {
    $prev_page=$page-1;
    echo "<a href='{$page_url}?page={$prev_page}'>&laquo;</a>";
}
//alle pages in numbers
for ($i = 1; $i <= $total_pages; $i++) {
    echo "<a href='{$page_url}?page=" . $i . "'";
    if ($i == $page) echo " class='curPage'";
    echo ">" . $i . "</a>";
}
// laatste pagina
if($page<$total_pages){
    $next_page = $page + 1;
    echo "<a href='{$page_url}?page={$next_page}'>&raquo;</a>";
}
echo "</div>";


?>
