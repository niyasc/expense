<?php

    // configuration
    require("../includes/config.php"); 
    if(!empty($_SESSION["uname"]))
    {
    	$start=query("select start from accounts where uname=?",$_SESSION["uname"]);
    	$end=query("select sysdate()");
    	$end=$end[0]["sysdate()"];
    	
    	//set current balance and bank balance in any case
    	
    	
    	$cb = query("select balance from accounts where uname=?",$_SESSION["uname"]);
    	$cbb = query("select bbalance from accounts where uname=?",$_SESSION["uname"]);
    	$cb = $cb[0]['balance'];
    	$cbb = $cbb[0]['bbalance'];
    	
    	
    	if($start[0]["start"]==NULL)
    	{
    		$start=query("select min(Day) from expense where User=(select id from accounts where uname=?)",$_SESSION["uname"]);
    		$start=$start[0]["min(Day)"];
    	}
    	else
    	{
    		$start=$start[0]["start"];
    	}
    		

    if(!empty($_POST["category"]))
    {
    	$id=query("select id from accounts where uname=?",$_SESSION["uname"]);
    	$id=$id[0]["id"];
    	query("insert into categories values(?,?)",$id,$_POST["category"]);
    	render("settings_form.php",["title"=>"Settings","message"=>"Category Added Successfully","start"=>$start,"end"=>$end,"cb"=>$cb,"cbb"=>$cbb]);
    }
    else if(!empty($_POST["passwd1"]))
    {
    	$p1=$_POST["passwd1"];
    	$p2=$_POST["passwd2"];
    	if($p1==$p2)
    	{
    		query("update accounts set password=password(?) where uname=?",$p1,$_SESSION["uname"]);
    		render("settings_form.php",["title"=>"Settings","message"=>"Password Changed Successfully","start"=>$start,"end"=>$end,"cb"=>$cb,"cbb"=>$cbb]);
    	}
    	else
    		render("settings_form.php",["title"=>"Settings","error"=>"Passwords should match","start"=>$start,"end"=>$end,"cb"=>$cb,"cbb"=>$cbb]);	
    }
    else if(!empty($_POST["date1"]))
    {
    	$date1=$_POST["date1"];
    	if(is_valid_date($date1))
    	{
    		query("update accounts set start=? where uname=?",$date1,$_SESSION["uname"]);
    		
    		render("settings_form.php",["title"=>"Settings","message"=>"Date Range Updated Successfully","start"=>$start,"end"=>$end,"cb"=>$cb,"cbb"=>$cbb]);
    	}
    	else
    	render("settings_form.php",["title"=>"Settings","error"=>"Invalid Date Format","start"=>$start,"end"=>$end,"cb"=>$cb,"cbb"=>$cbb]);
    		
    }
    else if(!empty($_POST['cb']))
    {
    	$cb=$_POST['cb'];
    	$cbb=$_POST['cbb'];
    	query("update accounts set balance=? and bbalance=? where uname=?",$_POST['cb'],$_POST['cbb'],$_SESSION['uname']);
    	render("settings_form.php",["title"=>"Settings","start"=>$start,"end"=>$end,"cb"=>$cb,"cbb"=>$cbb,"message"=>"Balance Updated Successfully"]);
    }
    else
    	render("settings_form.php",["title"=>"Settings","start"=>$start,"end"=>$end,"cb"=>$cb,"cbb"=>$cbb]);
    }
    else
    	redirect("members.php");
?>
