<?php

	class counter 
	
		{
		
				function __construct(){
				
					include "db.php";
					$this->db = new db();
					
					
				}				
				
				function hitcounter(){
				
					/*
					$data = $this->checkmachinecounter();
					if($data->total > 0) 
					{
						
						print json_encode(false);
						exit;
					}
					*/
					
					$type = intval($_POST['type']);
					$sql ="
						INSERT INTO 
						axis_teaser_2012.teaser_data	(ipaddress,type,date,date_ts) 
						VALUES ('{$_SERVER['REMOTE_ADDR']}',{$type},NOW(),".time().") ";
						$this->db->query($sql);
						print json_encode(true);
					exit;
				}
				
				function getcounter(){

					$sql ="SELECT count(*)total,type FROM axis_teaser_2012.teaser_data GROUP BY type; ";
					$data = $this->db->fetch($sql,true);
					return $data;
				}
				
				function checkmachinecounter(){
				
					$sql ="SELECT count(*) total FROM axis_teaser_2012.teaser_data WHERE ipaddress = '{$_SERVER['REMOTE_ADDR']}'  ";
					$data = $this->db->fetch($sql);
					return $data;
				}
				
		}
		
	$arr['count0'] = 0;
	$arr['count1'] = 0;
	$teaser = new counter();
	if(array_key_exists('act',$_POST)){
		if($_POST['act']=='hitcounter'){
			$teaser->hitcounter();
			
		}
		
	}
		
	$dteaser = $teaser->getcounter();	
	if($dteaser){
		foreach($dteaser as $val){
			$arr["count".$val->type]=$val->total;
		}
	}

	include "teaser.php";
	
?>