<?php

    // configuration
    require("../includes/config.php"); 

    // if form was submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        // validate submission
        if (empty($_POST["uname"]))
        {
            render("register_form.php", ["title" => "Register","error"=>"Please provide a username"]);
        }
        else if (empty($_POST["password"]))
        {
            render("register_form.php", ["title" => "Register","error"=>"Please provide a password"]);
        }
	else if ($_POST["password"]!=$_POST["confirmation"])
        {
            render("register_form.php", ["title" => "Register","error"=>"Passwords donot match"]);
        }
        else{
        // query database for user
       $rows = query("SELECT * FROM accounts WHERE uname = ?", $_POST["uname"]);
       	if(count($rows)==1)
       	{
       		 render("register_form.php", ["title" => "Register","error"=>"Username already taken"]);
       	}
       	else
       	{
       	
       		query("insert into accounts(uname,password) values(?,password(?))",$_POST["uname"],$_POST["password"]);
        	redirect("members.php");
    	}
    	}
    }
    else
    {
        // else render form
        render("register_form.php", ["title" => "Log In"]);
    }

?>
