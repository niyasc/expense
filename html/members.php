<?php

    // configuration
    require("../includes/config.php"); 

    // if form was submitted
    if(!empty($_SESSION["uname"]))
    {
    	if(empty($_GET["page"]) or ($_GET["page"]=="statistics"))
    	{	
    		$total=query("select sum(Expense) from expense where User=(select id from accounts where uname=?)",$_SESSION["uname"]);
    		$days=query("select datediff((select max(Day) from expense where User=(select id from accounts where uname=?)),(select min(Day) from expense where User=(select id from accounts where uname=?)))",$_SESSION["uname"],$_SESSION["uname"]);
    		//print_r($total);
    		//print_r($days);
    		$total=$total[0]["sum(Expense)"];
    		$days=$days[0]["datediff((select max(Day) from expense where User=(select id from accounts where uname=?)),(select min(Day) from expense where User=(select id from accounts where uname=?)))"];
    		if($days==0)
    		{
    			$average=$total;
    		}
    		else
    		{
    			$average=$total/$days;
    		}
    		//print $days;
    		//print $total;
    		render("statistics.php",["title"=>"Statistics","total"=>$total,"average"=>$average,"days"=>$days]);
    	}
    	else if($_GET["page"]=="add_record")
    	{
    		render("add_record.php",["title"=>"Add Record"]);
    	}
    	else if($_GET["page"]=="show_records")
    	{
    		$records=query("select Item,Day,Expense from expense where User=(select id from accounts where uname=?) order by Day asc",$_SESSION["uname"]);
    		render("show_records.php",["title"=>"Show Records","records"=>$records]);
    	}
    	else
    	{
    		render("statistics.php",["title"=>"Statistics"]);
    	}
    	
    }
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        // validate submission
        if (empty($_POST["uname"]))
        {
            render("login_form.php", ["title" => "Log In","error"=>"Please provide user name"]);
        }
        else if (empty($_POST["password"]))
        {
            render("login_form.php", ["title" => "Log In","error"=>"Please provide a password"]);
        }

        // query database for user
        $rows = query("SELECT * FROM accounts WHERE uname = ? and password=password(?)", $_POST["uname"],$_POST["password"]);

        // if we found user, check password
        if (count($rows) == 1)
        {
        	$_SESSION["uname"]=$_POST["uname"];
        	$total=query("select sum(Expense) from expense where User=(select id from accounts where uname=?)",$_SESSION["uname"]);
    		$days=query("select datediff((select max(Day) from expense where User=(select id from accounts where uname=?)),(select min(Day) from expense where User=(select id from accounts where uname=?)))",$_SESSION["uname"],$_SESSION["uname"]);
    		//print_r($total);
    		//print_r($days);
    		$total=$total[0]["sum(Expense)"];
    		$days=$days[0]["datediff((select max(Day) from expense where User=(select id from accounts where uname=?)),(select min(Day) from expense where User=(select id from accounts where uname=?)))"];
    		if($days==0)
    		{
    			$average=$total;
    		}
    		else
    		{
    			$average=$total/$days;
    		}
    		render("statistics.php",["title"=>"Statistics","total"=>$total,"average"=>$average,"days"=>$days]);
        }
        else
        {
        	render("login_form.php", ["title" => "Log In","error"=>"Invalid username or password"]);
        }
    }
    else
    {
        // else render form
        render("login_form.php", ["title" => "Log In"]);
    }

?>
