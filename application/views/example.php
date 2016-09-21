<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php 
foreach($css_files as $file): ?>
	<link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
<?php endforeach; ?>
<?php foreach($js_files as $file): ?>
	<script src="<?php echo $file; ?>"></script>
<?php endforeach; ?>
<style type='text/css'>
body
{
	font-family: Arial;
	font-size: 14px;
}
a {
    color: #4169e1;
    text-decoration: none;
    font-size: 14px;
}
a:hover
{
    /*text-decoration: underline;*/
}
</style>
</head>
<body>
	<div>
		<br>
		<center><h2><img src="http://img00.deviantart.net/138b/i/2012/106/2/d/torii_by_kyoshyu-d4wg63t.png" alt="" style="height:18px;">
              Aikido Osaka Buikukai
            <img src="http://img00.deviantart.net/138b/i/2012/106/2/d/torii_by_kyoshyu-d4wg63t.png" alt="" style="height:18px;"></h2>

			<!--<img src="http://www.indexmundi.com/flags/pm-lgflag.gif" alt="" style="height:16px;">-->
			<a href='<?php echo site_url('main/miembros')?>'>Administración de Dojos</a><!-- -

			<img src="http://www.davidchiriqui.com/Bandera%20de%20Chiriqui.jpg" alt="" style="height:16px;">
			<a href='<?php echo site_url('main/dojo_chiriqui')?>'>Chiriquí, Provincia David</a> -

			<img src="http://www.banderas.pro/banderas/bandera-costa-rica-5.gif" alt="" style="height:16px;">
			<a href='<?php echo site_url('main/dojo_cartago')?>'>Cartago, Costa Rica</a>-->

		</center><!-- |
		<a href='<?php echo site_url('examples/customers_management')?>'>Customers</a> |
		<a href='<?php echo site_url('examples/orders_management')?>'>Orders</a> |
		<a href='<?php echo site_url('examples/products_management')?>'>Products</a> |
		<a href='<?php echo site_url('examples/offices_management')?>'>Offices</a> | 
		<a href='<?php echo site_url('examples/employees_management')?>'>Employees</a> |		 
		<a href='<?php echo site_url('examples/film_management')?>'>Films</a> |
		<a href='<?php echo site_url('examples/multigrids')?>'>Multigrid [BETA]</a>-->
		
	</div>
	<div style='height:20px;'></div>  
    <div>
		<?php echo $output; ?>
    </div>
</body>
</html>
