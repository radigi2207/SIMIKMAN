<!DOCTYPE html>
<html lang="en-us" >
	<head>
		<meta charset="utf-8">
		<!--<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">-->

		<title> <?php echo $page_title != "" ? $page_title." - " : SITE_TITLE; ?></title>
		<meta name="description" content="">
		<meta name="author" content="">

		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
		<link rel="shortcut icon" type="image/x-icon" href="<?=base_url('assets/img/logo.ico')?>" />		
		<!-- Basic Styles -->
		<link rel="stylesheet" type="text/css" media="screen" href="<?=base_url('assets/css/bootstrap.min.css')?>">
		<link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url('assets') ?>/css/font-awesome.min.css">

		<!-- SmartAdmin Styles : Caution! DO NOT change the order -->
		<link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url('assets') ?>/css/smartadmin-production-plugins.min.css">
		<link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url('assets') ?>/css/smartadmin-production.min.css">
		<link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url('assets') ?>/css/smartadmin-skins.min.css">

		<!-- SmartAdmin RTL Support is under construction-->
		<link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url('assets') ?>/css/smartadmin-rtl.min.css">
        
        <link rel="stylesheet" type="text/css" media="screen" href="<?=base_url('assets/css/your_style.css')?>">
		<!-- We recommend you use "your_style.css" to override SmartAdmin
		     specific styles this will also ensure you retrain your customization with each SmartAdmin update.
		<link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url('assets') ?>/css/your_style.css"> -->

		<!-- Demo purpose only: goes with demo.js, you can delete this css when designing your own WebApp -->
		<link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url('assets') ?>/css/demo.min.css">

		<!-- FAVICONS -->
		<link rel="shortcut icon" href="<?php echo base_url('assets') ?>/img/favicon/favicon.ico" type="image/x-icon">
		<link rel="icon" href="<?php echo base_url('assets') ?>/img/favicon/favicon.ico" type="image/x-icon">

		<!-- GOOGLE FONT -->
		<link rel="stylesheet" href="<?php echo base_url('assets') ?>/css/css.css?family=Open+Sans:400italic,700italic,300,400,700">
		<!-- Favicon icon -->
		<link rel="icon" src="<?=base_url()?>assets/images/favicon.ico" type="image/x-icon">
		<!-- Google font-->
		<link href="<?=base_url()?>assets/css/css.css" rel="stylesheet">

		<!-- themify icon -->
		<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/icon/themify-icons/themify-icons.css">
		<!-- Material Icon -->
		<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/icon/material-design/css/material-design-iconic-font.min.css">
		<!-- Font Awesome -->
		<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/icon/font-awesome/css/font-awesome.min.css">
		<!-- ico font -->
		<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/icon/icofont/css/icofont.css">
		<!-- flag icon framework css -->
		<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/icon/flag-icon/flag-icon.min.css">
		
		<!-- Specifying a Webpage Icon for Web Clip
			 Ref: https://developer.apple.com/library/ios/documentation/AppleApplications/Reference/SafariWebContent/ConfiguringWebApplications/ConfiguringWebApplications.html -->
		<link rel="apple-touch-icon" href="<?php echo base_url('assets') ?>/img/splash/sptouch-icon-iphone.png">
		<link rel="apple-touch-icon" sizes="76x76" href="<?php echo base_url('assets') ?>/img/splash/touch-icon-ipad.png">
		<link rel="apple-touch-icon" sizes="120x120" href="<?php echo base_url('assets') ?>/img/splash/touch-icon-iphone-retina.png">
		<link rel="apple-touch-icon" sizes="152x152" href="<?php echo base_url('assets') ?>/img/splash/touch-icon-ipad-retina.png">

		<!-- iOS web-app metas : hides Safari UI Components and Changes Status Bar Appearance -->
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">

		<!-- Startup image for web apps -->
		<link rel="apple-touch-startup-image" href="<?php echo base_url('assets') ?>/img/splash/ipad-landscape.png" media="screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:landscape)">
		<link rel="apple-touch-startup-image" href="<?php echo base_url('assets') ?>/img/splash/ipad-portrait.png" media="screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:portrait)">
		<link rel="apple-touch-startup-image" href="<?php echo base_url('assets') ?>/img/splash/iphone.png" media="screen and (max-device-width: 320px)">
	</head>