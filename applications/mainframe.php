<?php

include('dbaseconnection.php');

?>
<head>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
	<script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM=" crossorigin="anonymous"></script>
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css">
	<link rel="icon" type="image/png" href="../images/logo-removebg-preview.png">
	<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.js"></script>
	<style> 
		@import url('https://fonts.googleapis.com/css2?family=Jost&display=swap');
		body{
			font-family: 'Jost', sans-serif;
		}

		.form-control{
			border-radius: 0px;
		}

		.navbar{
			width: 100%;
			display: flex;
			justify-content: space-between;
			align-items: center;
			padding: 15px 30px;
			background-color: #FCD5CE;
		}

		.navbar a {
			text-decoration: none;
			color: #000;
			font-family: 'Sura', serif;
			font-size: 17px;
		}

		.searchNav input[type=text]{
			padding: 8px;
			margin-top: 7px;
			font-size: 17px;
			border: #868686;
			color: #868686;
			border-radius: 12px;
		}

		.searchNav button{
			padding: 8px;
			margin-top: 7px;
			margin-right: 16px;
			background: white;
			font-size: 17px;
			border: none;
			cursor: pointer;
			border-radius: 12px;
		}

		.registerButton{
			margin-left: 20px;
			padding: 8px 20px;
			font-size: 17px;
			border-radius: 12px;
		}

		.bg-main{
			background-color: #FCD5CE;
		}

		.bg-lighter{
			background-color: #F3ECEB;
		}

		.subscribe-border{
			border-bottom-left-radius: 12px;
			border-bottom-right-radius: 2px;
			border-top-left-radius: 2px;
			border-top-right-radius: 12px;
		}

		.subscribe-btn{
			background-color: #B67B81;
			border: none;
		}

		.subscribe-input{
			border: none;
			background-color: #C9C9C9;
		}

		.product-container{
			display: flex;
			flex-direction: column;
			justify-content: center;
			align-items: center;
			padding: 10px;
			border: 1px solid #AEAEAE;
			border-radius: 25px;
		}
	</style>

</head>
