<?
  include_once("include/dbinclude.php");
?>
<div class="col-lg-12">
  <div class="brandBanner">品牌 BRANDS</div>
</div>
<?
  include_once("temp/nav.php");
?>
<div class="col-lg-9">
  <?
    $sql = "select * from brand where brand_id = '".$_GET["b_id"]."'";
    $result = mysqli_query($sqli,$sql);
    $row = mysqli_fetch_array($result);
  ?>
  <div class="row">
    <div class="col-lg-12">
      <div class="seller_info">
        <div class="store_logoWrapper">
          <img id="main_photo" src="update/brand_s/<? echo $row['brand_logo'];?>">
        </div>
        <div class="store_infoWrapper">
          <h4><font></font><? echo $row["brand_name"]; ?></h4>
          <p><font></font><? echo $row["brand_introduce"]; ?></p>
        </div>
      </div>
    </div>
  </div>
  <div class="storeBlock_Wrapper">
  <div class="col-lg-12">
    <div class="row">
      <div class="newStore">
        <div class="newStoreName">
          <img src="include/images/news_info_bar.png">
          <h4>最新入库New Store</h4>
          <img src="include/images/news_info_bar.png">
        </div>
        <?
          $sql_newitem = "select * from item where brand_id =".$_GET["b_id"]." order by shelves_date DESC limit 0,3";
          $result_newitem = mysqli_query($sqli,$sql_newitem);
          while($row_newitem = mysqli_fetch_array($result_newitem)){
            $photo_img = explode("|",$row_newitem["item_photo"]);
        ?>
        <div class="col-xs-6 col-lg-4">
          <div class="merchandise_wrapper">
              <a href="item_info.php?item_id=<? echo $row_newitem["item_id"]; ?>" class="thumbnail">
                <div class="imgOverflow split_three"><img src="update/item_s/<? echo $photo_img[0];?>" alt=""></div>
              </a>
              <div class="store_caption">
                   <button type="button" class="btn btn-primary" onclick="location.href='item_info.php?item_id=<? echo $row_newitem["item_id"]; ?>'" >查看详情</button>
                </div>
            </div>
          </div>
      <? }?>
      </div>
    </div>
  </div>
  <div id='seq_div' class="sorting02">排序︰
    <?
      $get_value = "&b_id=".$_GET["b_id"];
      if($_GET["seq"]=="")
        $seq = "name";
      else
        $seq = $_GET["seq"];
    ?>
    <button class="btn btn-<? if($seq=="name"){ echo "danger";}else{ echo "default";} ?>" onclick="location.href='brand_info.php?seq=name<? echo $get_value;?>'" >商品名称</button>
    <button class="btn btn-<? if($seq=="exp"){ echo "danger";}else{ echo "default";} ?>" onclick="location.href='brand_info.php?seq=exp<? echo $get_value;?>'" >价钱高低</button>
    <button class="btn btn-<? if($seq=="new"){ echo "danger";}else{ echo "default";} ?>" onclick="location.href='brand_info.php?seq=new<? echo $get_value;?>'" >最新上架</button>
  </div>
  <div class="numberButton">
    <ul>
    <?
      if($_GET["now_page"]=="")
        $now_page = 1;
      else
        $now_page = intval($_GET["now_page"]);
      $limit_count = 8;
      $sql_item = "select a.item_id , a.item_name , a.item_price , a.item_photo , b.store_id ,b.store_name from item a
      inner join store b on a.store_id = b.store_id
      where a.item_state = 1 and a.brand_id = ".$_GET["b_id"];
      $sql_item .= " order by ";
      if($seq == 'name')
        $sql_item .= "a.item_name";
      else if($seq == 'exp')
        $sql_item .= "a.item_price DESC";
      else if($seq == 'new')
        $sql_item .= "a.shelves_date DESC";
      $rs_count = mysqli_num_rows(mysqli_query($sqli,$sql_item));
      $page_count = ceil($rs_count/$limit_count);
      $result_item = mysqli_query($sqli,$sql_item." limit ".(($now_page-1) * $limit_count).",".$limit_count);

      $this_count = mysqli_num_rows($result_item);

      $page_list = floor($now_page / 5);
      $page_error = $now_page % 5;

      if($_GET["seq"]!='')
      $get_value .= "&seq=".$_GET["seq"];
    ?>
        <li <? if($now_page == 1 ){echo "style='display:none;'";} ?>><a class='be4_numberButton' href="brand_info.php?now_page=1<? echo $get_value; ?>">&laquo;</a></li>
        <li <? if($now_page == 1 ){echo "style='display:none;'";} ?>><a class='be4_numberButton' href="brand_info.php?now_page=<? echo ($now_page-1).$get_value; ?>">&#8249;</a></li>
      <?
        //$page_error != 0 ? $page = ($page_list*5)+1 : $page = (($page_list-1)*5)+1;
        if($page_error != 0)
          $page = ($page_list*5)+1;
        else
          $page = (($page_list-1)*5)+1;
          for( $n = 0; $n < 5 && $page <= $page_count; ++$n , ++$page){

            echo "<li><a href='brand_info.php?now_page=".$page.$get_value."' ";
            if($page == $now_page)
              echo "class='clicked_numberButton'";
            else
              echo "class='be4_numberButton'";
            echo ">".$page."</a></li>";

          }

      ?>
      <li <? if($page_count <= 1 || $page_count == $now_page){echo "style='display:none;'";} ?>><a class='be4_numberButton' href="brand_info.php?now_page=<? echo ($now_page+1).$get_value; ?>">&#8250;</a></li>
      <li <? if($page_count == $now_page){echo "style='display:none;'";} ?>><a class='be4_numberButton' href="brand_info.php?now_page=<? echo $page_count.$get_value; ?>">&raquo;</a></li>
    </ul>
  </div>
  <div id='item_div' class="row">
    <div class="storeProduct">
    <?
      $i = 1;
      while($row_item = mysqli_fetch_array($result_item)){
        $photo_img = explode("|",$row_item["item_photo"]);
    ?>
      <div class="col-xs-6 col-lg-3">
          <div class="merchandise_wrapper">
            <a href="item_info.php?item_id=<? echo $row_item["item_id"]; ?>" class="thumbnail">
              <div class="imgOverflow split_four"><img src="update/item_s/<? echo $photo_img[0];?>" alt=""></div>
            </a>
            <div class="caption">
            <h4><? echo $row_item["item_name"]; ?></h4>
            <p><font class="storeName"><? echo $row_item["store_name"]; ?></font></p>
            <img src="include/images/price.png"><h4><font class="item_price"><? echo $row_item["item_price"]; ?></font></h4>
            </div>
          </div>
      </div>
    <?
        $i++;
      }
    ?>
    </div>
  </div>
  <div class="numberButton">
    <ul>
        <li <? if($now_page == 1 ){echo "style='display:none;'";} ?>><a class='be4_numberButton' href="brand_info.php?now_page=1<? echo $get_value; ?>">&laquo;</a></li>
        <li <? if($now_page == 1 ){echo "style='display:none;'";} ?>><a class='be4_numberButton' href="brand_info.php?now_page=<? echo ($now_page-1).$get_value; ?>">&#8249;</a></li>
      <?
        if($page_error != 0)
        $page = ($page_list*5)+1;
      else
        $page = (($page_list-1)*5)+1;
        for( $n = 0; $n < 5 && $page <= $page_count; ++$n , ++$page){

          echo "<li><a href='brand_info.php?now_page=".$page.$get_value."' ";
          if($page == $now_page)
            echo "class='clicked_numberButton'";
          else
            echo "class='be4_numberButton'";
          echo ">".$page."</a></li>";
        }
      ?>
      <li <? if($page_count <= 1 || $page_count == $now_page){echo "style='display:none;'";} ?>><a class='be4_numberButton' href="brand_info.php?now_page=<? echo ($now_page+1).$get_value; ?>">&#8250;</a></li>
      <li <? if($page_count == $now_page){echo "style='display:none;'";} ?>><a class='be4_numberButton' href="brand_info.php?now_page=<? echo $page_count.$get_value; ?>">&raquo;</a></li>
    </ul>
  </div>
</div>

<script>
  $( document ).ready(function() { //jump to seat
      if("<? echo $_GET["seq"];?>" != "" || "<? echo $_GET["now_page"];?>" != ""){
        var scroll_offset = $("#seq_div").offset();
        $("body,html").animate({ 
        scrollTop:scroll_offset.top
        },0); 
      }
    });
</script>