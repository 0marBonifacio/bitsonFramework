<!DOCTYPE html>
<html lang="es">
    <head>
		<title><?php if (isset($this->titulo)){echo $this->titulo;}?></title>
		<meta charset="utf-8">
		<meta name = "format-detection" content = "telephone=no" />
		
		<link rel="icon" href="<?php echo $_layoutArgs['ruta_img']; ?>favicon.ico">
		<link rel="shortcut icon" href="<?php echo $_layoutArgs['ruta_img']; ?>favicon.ico" />
		
		
		<link rel="stylesheet" type="text/css" href="<?php echo $_layoutArgs['ruta_css']; ?>component.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo $_layoutArgs['ruta_css']; ?>tooltipster.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo $_layoutArgs['ruta_css']; ?>style.css">
		
		<script src="<?php echo BASE_URL; ?>public/js/jquery.js"></script>
		<script src="<?php echo BASE_URL; ?>public/js/jquery.validate.js"></script>
		
		<?php if (isset($_layoutArgs['js']) && count($_layoutArgs['js'])): ?>
			<?php for ($i=0;$i<count($_layoutArgs['js']);$i++): ?>
		<script src="<?php echo $_layoutArgs['js'][$i]; ?>"></script>		
			<?php endfor ?>
		<?php endif; ?>
			     
		
		<script src="<?php echo $_layoutArgs['ruta_js']; ?>jquery-migrate-1.2.1.js"></script>
		<script src="<?php echo $_layoutArgs['ruta_js']; ?>script.js"></script> 
		<script src="<?php echo $_layoutArgs['ruta_js']; ?>superfish.js"></script>
		<script src="<?php echo $_layoutArgs['ruta_js']; ?>jquery.ui.totop.js"></script>
		<script src="<?php echo $_layoutArgs['ruta_js']; ?>jquery.equalheights.js"></script>
		<script src="<?php echo $_layoutArgs['ruta_js']; ?>jquery.mobilemenu.js"></script>
		<script src="<?php echo $_layoutArgs['ruta_js']; ?>jquery.easing.1.3.js"></script>
		<script src="<?php echo $_layoutArgs['ruta_js']; ?>jquery.tooltipster.js"></script>
				
		<!--[if (gt IE 9)|!(IE)]><!-->
		<script src="<?php echo $_layoutArgs['ruta_js']; ?>jquery.mobile.customized.min.js"></script>
		<!--<![endif]-->
		<script src="<?php echo $_layoutArgs['ruta_js']; ?>modernizr.custom.js"></script>
		

		<!--[if lt IE 9]>
			<div style=' clear: both; text-align:center; position: relative;'>
				<a href="http://windows.microsoft.com/en-US/internet-explorer/products/ie/home?ocid=ie6_countdown_bannercode">
				<img src="http://storage.ie6countdown.com/assets/100/images/banners/warning_bar_0000_us.jpg" border="0" height="42" width="820" alt="You are using an outdated browser. For a faster, safer browsing experience, upgrade for free today." />
				</a>
			</div>
			<script src="js/html5shiv.js"></script>
			<link rel="stylesheet" media="screen" href="css/ie.css">
		<![endif]-->
		
    </head>
     
    <body class="page1" id="top">
    
    <?php if(isset($this->_error)):?>
    <div id="error"><?php echo $this->_error; ?></div>    
    <?php endif; ?>
    
    <?php if(isset($this->_mensaje)):?>
    <div id="mensaje"><?php echo $this->_mensaje; ?></div>    
    <?php endif; ?>
    
    <noscript><p>Habilite Javascript en su navegador para el correcto funcionamiento del sistema</p></noscript>
     
	<!--==============================header=================================--> 
	<header>  
		<div class="container_12">
			<div class="grid_12">
				<a href="#"><h1 class="logo"><?php echo APP_NAME; ?></h1></a>
				<div class="menu_block ">
					<nav class="horizontal-nav full-width horizontalNav-notprocessed">						
						<ul class="sf-menu">
							<?php if(isset($_layoutArgs['menu'])): ?>
							<?php for ($i = 0; $i < count($_layoutArgs['menu']); $i++): ?>
							<?php
							if ($item && $_layoutArgs['menu'][$i]['id']==$item)
							{
								$_item_style = 'current';
							}
							else
							{
								$_item_style = '';
							}
							?>
							<li><a class='<?php echo $_item_style; ?>' href="<?php echo $_layoutArgs['menu'][$i]['enlace']; ?>" ><?php echo $_layoutArgs['menu'][$i]['titulo']; ?></a></li>
							<?php endfor; ?>
							<?php endif; ?>
						</ul>
					</nav>					
				</div>
			</div>
		</div>
	</header>
	<div id="main" class="content">				
