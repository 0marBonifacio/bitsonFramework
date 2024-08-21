<!DOCTYPE HTML>
<html lang="es">
	<head>
		<meta charset="utf-8" />
		<title><?php if (isset($this->titulo)){echo $this->titulo;}?></title>

		<link type="text/css" rel="stylesheet" href="<?php echo $_layoutArgs['ruta_css']; ?>estilo.css" />

	</head>
	<body>
		<div id="main" class="">
			<div id="header" class="">
				<h1><?php echo APP_NAME; ?></h1>
			</div>
			<div id="top_menu" class="">
				<ul>
					<?php if(isset($_layoutArgs['menu'])): ?>
					<?php for ($i = 0; $i < count($_layoutArgs['menu']); $i++): ?>
					<li><a href="<?php echo $_layoutArgs['menu'][$i]['enlace']; ?>" ><?php echo $_layoutArgs['menu'][$i]['titulo']; ?></a></li>
					<?php endfor; ?>
					<?php endif; ?>
				</ul>
			</div>
