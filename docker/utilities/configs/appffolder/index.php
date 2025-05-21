<!DOCTYPE html>
<html>
  <head>
    <title>Docker</title>
  </head>
  <style>
/* DivTable.com */
.divTable{
	display: table;
	width: 100%;
}
.divTableRow {
	display: table-row;
}
.divTableHeading {
	background-color: #EEE;
	display: table-header-group;
}
.divTableCell, .divTableHead {
	border: 1px solid #999999;
	display: table-cell;
	padding: 3px 10px;
}
.divTableHeading {
	background-color: #EEE;
	display: table-header-group;
	font-weight: bold;
}
.divTableFoot {
	background-color: #EEE;
	display: table-footer-group;
	font-weight: bold;
}
.divTableBody {
	display: table-row-group;
}

.DivAlignment {
	text-align: center;
	vertical-align: top;
  
}
div.item {
    vertical-align: top;
   // display: inline-block;
    text-align: center;
 //   width: 200px;
}
img {
    width: 200px;
  //  height: 100px;
}
.caption {
    display: block;
}
  </style>
<body>
<div class="divTable">
	<div class="divTableBody">
		<div class="divTableRow">
			<div class="divTableCell DivAlignment">&nbsp;
				<div class="item" onclick="location.href='<?php echo 'http://' . $_SERVER['HTTP_HOST'] . '/sugar'; ?>'" >
					<img src="sugarcrm-logo-blk.svg"/>
					<span class="caption">Sugarcrm</span>
				</div>
			</div>
			
			<div class="divTableCell DivAlignment">
				<div class="item" onclick="location.href='<?php echo 'http://' . $_SERVER['HTTP_HOST'] . ':8080'; ?>'" >
					<img src="PhpMyAdmin-Logo.svg"/>
					<span class="caption">PhpMyAdmin</span>
				</div>
			</div>
		</div>
		<div class="divTableRow">
			<div class="divTableCell DivAlignment">
				<div class="item" onclick="location.href='<?php echo 'http://' . $_SERVER['HTTP_HOST'] . ':8025'; ?>'" >
					<img src="Mailhog.png"/>
					<span class="caption">Mailhog</span>
				</div>
			</div>
				<div class="divTableCell DivAlignment">
				<div class="item" onclick="location.href='<?php echo 'http://' . $_SERVER['HTTP_HOST'] . ':8888'; ?>'" >
					<img src="elasticvu.png"/>
					<span class="caption">Elasticvue</span>
				</div>
			</div>
		
		</div>
		<div class="divTableRow">
			<div class="divTableCell DivAlignment">
				
			</div>
			<div class="divTableCell DivAlignment">
				<div class="item" onclick="location.href='<?php echo 'http://' . $_SERVER['HTTP_HOST'] . '/info.php'; ?>'" >
					<img src="php-logo.svg"/>
					<span class="caption">phpInfo</span>
				</div>
			</div>
		</div>
	</div>
</div>
</body>
</html>