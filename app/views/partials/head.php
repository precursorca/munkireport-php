<!doctype html>
<html class="no-js" lang="en">

<head>
	<meta content="text/html; charset=utf-8" http-equiv="content-type" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title><?php echo conf('sitename'); ?></title>
	<link rel="stylesheet" href="<?php echo conf('subdirectory'); ?>assets/css/bootstrap.min.css" />
	<link rel="stylesheet" href="<?php echo conf('subdirectory'); ?>assets/css/style.css" />
	<link rel="stylesheet" href="<?php echo conf('subdirectory'); ?>assets/nvd3/nv.d3.min.css" />
	<link rel="stylesheet" media="screen" href="<?php echo conf('subdirectory'); ?>assets/css/datatables.min.css" />
	<link href="<?php echo conf('subdirectory'); ?>assets/css/font-awesome.min.css" rel="stylesheet">
	<link rel="apple-touch-icon" sizes="180x180" href="/assets/images/favicons/apple-touch-icon.png">
	<link rel="icon" type="image/png" href="/assets/images/favicons/favicon-32x32.png" sizes="32x32">
	<link rel="icon" type="image/png" href="/assets/images/favicons/favicon-16x16.png" sizes="16x16">
	<link rel="manifest" href="/assets/images/favicons/manifest.json">
	<link rel="mask-icon" href="/assets/images/favicons/safari-pinned-tab.svg" color="#5d5858">
	<link rel="shortcut icon" href="/assets/images/favicons/favicon.ico">
	<meta name="msapplication-config" content="/assets/images/favicons/browserconfig.xml">
	<meta name="theme-color" content="#5d5858">
	<?php if(conf('custom_css')): ?>
	<link rel="stylesheet" href="<?php echo conf('custom_css'); ?>" />
	<?php endif; ?>

	<?if(isset($stylesheets)):?>
	<?foreach($stylesheets as $stylesheet):?>
	<link rel="stylesheet" href="<?php echo conf('subdirectory'); ?>assets/css/<?php echo $stylesheet; ?>" />
	<?endforeach?>
	<?endif?>

	<script>
		var baseUrl = "<?php echo conf('subdirectory'); ?>",
			appUrl = baseUrl + 'index.php?',
			businessUnitsEnabled = <?php echo conf('enable_business_units') ? 'true' : 'false'; ?>;
			isAdmin = <?php echo $_SESSION['role'] == 'admin' ? 'true' : 'false'; ?>;
	</script>

	<script src="<?php echo conf('subdirectory'); ?>assets/js/jquery.js"></script>

<?php
	if (isset($scripts))
		foreach($scripts as $script): ?>
	<script src="<?php echo conf('subdirectory'); ?>assets/js/<?php echo $script; ?>" type="text/javascript"></script>
<?php endforeach; ?>
</head>

<body>

	<?php if( isset($_SESSION['user'])):?>

<header class="navbar navbar-inverse navbar-static-top bs-docs-nav" role="banner">
	<div class="container">
		<div class="navbar-header">
			<button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".bs-navbar-collapse">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="<?php echo url(''); ?>"><?php echo conf('sitename'); ?></a>
		</div>
		<nav class="collapse navbar-collapse bs-navbar-collapse" role="navigation">
			<ul class="nav navbar-nav">
				<?php $page = $GLOBALS[ 'engine' ]->get_uri_string(); ?>

				<li <?php echo $page==''?'class="active"':''; ?>>
					<a href="<?php echo url(); ?>">
						<i class="fa fa-th-large"></i>
						<span class="visible-lg-inline" data-i18n="nav.main.dashboard"></span>
					</a>
				</li>

				<?php $url = 'show/reports/'; ?>
				<li class="dropdown<?php echo strpos($page, $url)===0?' active':''; ?>">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<i class="fa fa-bar-chart-o"></i>
						<span data-i18n="nav.main.reports"></span>
						<b class="caret"></b>
					</a>
					<ul class="report dropdown-menu">

						<?php foreach(scandir(conf('view_path').'report') AS $list_url): ?>

							<?php if( strpos($list_url, 'php')): ?>
							<?php $page_url = $url.strtok($list_url, '.'); ?>

							<li<?php echo strpos($page, $page_url)===0?' class="active"':''; ?>>
								<a href="<?php echo url($page_url); ?>" data-i18n="nav.reports.<?php echo $name = strtok($list_url, '.'); ?>"><?php echo ucfirst($name); ?></a>
							</li>

							<?php endif; ?>

						<?php endforeach; ?>

					</ul>

				</li>

				<?php $url = 'show/listing/'; ?>
				<li class="dropdown<?php echo strpos($page, $url)===0?' active':''; ?>">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<i class="fa fa-list-alt"></i>
						<span data-i18n="nav.main.listings"></span>
						<b class="caret"></b>
					</a>
					<ul class="listing dropdown-menu">

						<?php foreach(scandir(conf('view_path').'listing') AS $list_url): ?>

							<?php if( strpos($list_url, 'php')): ?>
							<?php $page_url = $url.strtok($list_url, '.'); ?>

							<li<?php echo strpos($page, $page_url)===0?' class="active"':''; ?>>
								<a href="<?php echo url($url.strtok($list_url, '.')); ?>" data-i18n="nav.listings.<?php echo $name = strtok($list_url, '.'); ?>"></a>
							</li>

							<?php endif; ?>

						<?php endforeach; ?>

					</ul>

				</li>

				<?php if($_SESSION['role'] == 'admin'):?>
				<?php $url = 'admin/show/'; ?>
				<li class="dropdown<?php echo strpos($page, $url)===0?' active':''; ?>">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<i class="fa fa-list-alt"></i>
						<span data-i18n="nav.main.admin"></span>
						<b class="caret"></b>
					</a>
					<ul class="admin dropdown-menu">

						<?php foreach(scandir(conf('view_path').'admin') as $list_url): ?>

							<?php if( strpos($list_url, 'php')): ?>
							<?php $page_url = $url.strtok($list_url, '.'); ?>

							<li<?php echo strpos($page, $page_url)===0?' class="active"':''; ?>>
								<a href="<?php echo url($url.strtok($list_url, '.')); ?>" data-i18n="nav.admin.<?php echo $name = strtok($list_url, '.'); ?>"></a>
							</li>

							<?php endif; ?>

						<?php endforeach; ?>

					</ul>

				</li>
				<?php endif?>

				<li>
					<a href="#" class="filter-popup">
						<i class="fa fa-filter"></i>
					</a>
				</li>

			</ul><!-- nav navbar-nav -->

			<ul class="nav navbar-nav navbar-right">

				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<i class="fa fa-globe"></i>
					</a>
					<ul class="dropdown-menu locale">

							<?php foreach(scandir(APP_ROOT.'assets/locales') AS $list_url): ?>

								<?php if( strpos($list_url, 'json')):?>

								<?php $lang = strtok($list_url, '.'); ?>

								<li><a href="<?php echo url("$page&amp;setLng=$lang"); ?>" data-i18n="nav.lang.<?php echo $lang; ?>"><?php echo $lang; ?></a></li>

								<?php endif; ?>

							<?php endforeach; ?>

						</ul>
				</li>

				<?php if( ! array_key_exists('auth_noauth', conf('auth'))): // Hide logout button if auth_noauth?>

				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<i class="fa fa-user"></i> <?php echo $_SESSION['user']; ?>
						<b class="caret"></b>
					</a>
					<ul class="dropdown-menu">
						<li>
							<a href="<?php echo url('auth/logout'); ?>">
								<i class="fa fa-power-off"></i>
								<span data-i18n="nav.user.logout"></span>
							</a>
						</li>
					</ul>
				</li>

				<?php endif; ?>

			</ul>

		</nav>
	</div>
</header>



	<?php endif; ?>
