<?
	include_once("../include/dbinclude.php");
	$action = isset($_POST["action"]) ? $_POST['action'] : $_GET['action'] ;
	if($action == "get_city_code"){
		$list = Array();
		$search_city = substr($_POST["city_area"], 0 , 3 );
		$sql = "select * from city where city_rank = 2 and city_id like '".$search_city."%' order by city_id";
		$result = mysqli_query($sqli,$sql);
		for($i = 0 ;$row = mysqli_fetch_array($result);++$i)
			$list[$i] = $row ;
		echo json_encode($list);
	}
	else if($action == "get_qa"){
		$list = Array();
		$temp = Array();
		if($_POST["qa_state"]=='all')
			$sql = "select a.* , d.item_name , d.item_photo , b.user_nick  from qa a 
		    	inner join item d on d.item_id = a.item_id 
		    	left join user b on a.user_id = b.user_id 
		    	left join store c on c.store_id = d.store_id 
		    	where c.user_id = ".$_SESSION["user_id"]." and (a.q_creatdate between '".$_POST["start_date"]."' and '".$_POST["end_date"]."') order by a.q_creatdate desc";
		else if($_POST["qa_state"]=='reply_yet')
			$sql = "select a.* , d.item_name , d.item_photo , b.user_nick  from qa a 
		    	inner join item d on d.item_id = a.item_id 
		    	left join user b on a.user_id = b.user_id 
		    	left join store c on c.store_id = d.store_id 
		    	where c.user_id = ".$_SESSION["user_id"]." and (a.q_creatdate between '".$_POST["start_date"]."' and '".$_POST["end_date"]."') and a.a_creatdate = '0000-00-00 00:00:00' order by a.q_creatdate desc";
		else if($_POST["qa_state"]=='reply')
			$sql = "select a.* , d.item_name , d.item_photo , b.user_nick  from qa a 
		    	inner join item d on d.item_id = a.item_id 
		    	left join user b on a.user_id = b.user_id 
		    	left join store c on c.store_id = d.store_id 
		    	where c.user_id = ".$_SESSION["user_id"]." and (a.q_creatdate between '".$_POST["start_date"]."' and '".$_POST["end_date"]."') and a.a_creatdate != '0000-00-00 00:00:00' order by a.q_creatdate desc";
	  $rs_count = mysqli_query($sqli,$sql);
	  $total_count = mysqli_num_rows ( $rs_count );
	  $page_count = ceil($total_count / intval($_POST["limit_count"]));
		$result = mysqli_query($sqli,$sql." limit ".(intval($_POST["now_page"])-1)*intval($_POST["limit_count"]).",".$_POST["limit_count"]);
		for($i = 0 ;$row = mysqli_fetch_array($result);++$i)
			$temp[$i] = $row ;
		$list = Array( 'total_count' => $total_count , 'page_count' => $page_count , 'qa' => $temp);
		echo json_encode($list);
	}
?>