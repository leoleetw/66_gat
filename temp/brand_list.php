<?
  include_once("include/dbinclude.php");
  include_once("temp/nav.php");
?>
<div class="col-lg-9">
  
  <?
    if($_GET["now_page"]=="")
      $now_page = 1;
    else
      $now_page = intval($_GET["now_page"]);
    $limit_count = 1;
    $sql = "select brand_id , brand_name , brand_logo from brand ";
    $sql .= " order by brand_name desc";
    $rs_count = mysqli_num_rows(mysqli_query($sqli,$sql));
    $page_count = ceil($rs_count/$limit_count);
    $result = mysqli_query($sqli,$sql." limit ".(($now_page-1) * $limit_count).",".$limit_count);
    $page_list = floor($now_page / 5);
    $page_error = $now_page % 5;
  ?>
  <div class="numberButton">
    <ul>
      <li <? if($now_page == 1 ){echo "style='display:none;'";} ?>><a class='be4_numberButton' href="brand_list.php?now_page=1">&laquo;</a></li>
        <li <? if($now_page == 1 ){echo "style='display:none;'";} ?>><a class='be4_numberButton' href="brand_list.php?now_page=<? echo ($now_page-1); ?>">&#8249;</a></li>
      <?
        if($page_error != 0)
        $page = ($page_list*5)+1;
      else
        $page = (($page_list-1)*5)+1;
        for( $n = 0; $n < 5 && $page <= $page_count; ++$n , ++$page){

          echo "<li><a href='brand_list.php?now_page=".$page."' ";
          if($page == $now_page)
            echo "class='clicked_numberButton'";
          else
            echo "class='be4_numberButton'";
          echo ">".$page."</a></li>";

        }

      ?>
      <li <? if($page_count <= 1 || $page_count == $now_page){echo "style='display:none;'";} ?>><a class='be4_numberButton' href="brand_list.php?now_page=<? echo ($now_page+1); ?>">&#8250;</a></li>
      <li <? if($page_count == $now_page){echo "style='display:none;'";} ?>><a class='be4_numberButton' href="brand_list.php?now_page=<? echo $page_count; ?>">&raquo;</a></li>
    </ul>
  </div>
  <div class="brandList">
  <?
    $i = 1;
    while($row = mysqli_fetch_array($result)){
      if(($i % 4) == 1){
  ?>
      <div class="row">
  <?  } ?>
        <div class="col-xs-6 col-lg-3">
          <div class="merchandise_wrapper">
            <a href="brand_info.php?b_id=<? echo $row["brand_id"]; ?>" class="thumbnail">
              <div class="imgOverflow split_four"><img src="update/brand_s/<? echo $row["brand_logo"];?>" alt=""></div>
            </a>
        </div>
        </div>
    <?  if(($i % 4) == 0 || $i == page_count){ ?>
      </div>
    <?
      }
      $i++;
    }
  ?>
  </div>
  <div class="numberButton">
    <ul>
      <li <? if($now_page == 1 ){echo "style='display:none;'";} ?>><a class='be4_numberButton' href="brand_list.php?now_page=1">&laquo;</a></li>
        <li <? if($now_page == 1 ){echo "style='display:none;'";} ?>><a class='be4_numberButton' href="brand_list.php?now_page=<? echo ($now_page-1); ?>">&#8249;</a></li>
      <?
        if($page_error != 0)
        $page = ($page_list*5)+1;
      else
        $page = (($page_list-1)*5)+1;
        for( $n = 0; $n < 5 && $page <= $page_count; ++$n , ++$page){

          echo "<li><a href='brand_list.php?now_page=".$page."' ";
          if($page == $now_page)
            echo "class='clicked_numberButton'";
          else
            echo "class='be4_numberButton'";
          echo ">".$page."</a></li>";

        }

      ?>
      <li <? if($page_count <= 1 || $page_count == $now_page){echo "style='display:none;'";} ?>><a class='be4_numberButton' href="brand_list.php?now_page=<? echo ($now_page+1); ?>">&#8250;</a></li>
      <li <? if($page_count == $now_page){echo "style='display:none;'";} ?>><a class='be4_numberButton' href="brand_list.php?now_page=<? echo $page_count; ?>">&raquo;</a></li>
    </ul>
  </div>
</div>