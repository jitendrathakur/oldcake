<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="de" lang="de">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=iso-8859-1"/>
		<meta name="description" content=""/>
		<meta name="keywords" content=""/>
		<meta name="robots" content="index,follow"/>
		<meta name="author" content="CLIENT"/>
		<meta name="revisit-after" content="7 days"/>
		<meta name="title" content=""/>
		<meta name="content-language" content="de"/>
		<title><?php echo $title_header?></title>
		
		<script type="text/javascript">
			function change_lang(lang) {
				document.getElementById("selected_lang").value = lang;
				document.getElementById("frm_change_lang").submit();
			}
		</script>
	</head>


	<?php 
		//echo $html->css('table');
		//echo $html->css('print');
		echo $html->css('layout');
		echo $html->css('formate');
		echo $html->css('phone');
		echo $html->css('station');
		echo $html->css('common');
		echo $html->css('colorbox');
		echo $javascript->link('/js/jquery');
		echo $javascript->link('/js/standard');
		echo $javascript->link('/js/table');
		echo $javascript->link('/js/station');
	?>

	<body>
		<!--main page container starts here-->
		<div id="page">
		
			<!--header portion starts here-->
			<div id="header">
				<div id="language">
				<form id="frm_change_lang" action="http://selfcare.rainconcert.in/localize/change" method="POST">
					<input type="hidden" name="selected_lang" value="" id="selected_lang">
					<ul>
						<li><a href="javascript:void(null);" onclick="javascript:change_lang('fr')" title="French">FR</a></li>
						<li class="seperator">|</li>
						<li><a href="javascript:void(null);" onclick="javascript:change_lang('en')" title="English">EN</a></li>
					</ul>
					</form>
				</div>
			</div>

			<!--header portion starts here-->
			
			<!--link  for minimize content /maximize starts here-->
			<div id="maintop">
				<div id="maintopNavigationBgLeft" class="maintopNavigationBgLeft">
					<div id="maintopNavigation">
						<h2>
							<a href="#" onclick="return toggleNavigation();" id="maintopNavigationButton" class="maintopNavigationButton">
								<?php __("navigation");?>
							</a>
						</h2>
					</div>
				</div>
			</div>
			<!--link  for minimize content /maximize ends here-->
		
			<!--body content start here-->
			<div id="main" class="main">
				<!--left menu starts from here-->
				<div id="navigation">
					<ul>
						<li><a href="#" class="top eservice">Business </a>
							<ul>
								<li><a href="#" class="normal eservice">Business1</a>
									<ul>
										<li><a href="#" class="selected eservice">Business1</a>
										<li><a href="#" class="normal eservice">Business 2</a>
									</ul>
		
								</li>
								<li><a href="#" class="normal eservice">Business</a></li>
								<li><a href="#" class="normal eservice">Business</a></li>
								<li><a href="#" class="normal eservice">Business</a></li>
								<li><a href="#" class="normal eservice">Business</a></li>
							</ul>
						</li>
		
						
					</ul>
				</div>
				<!--left menu ends here-->
			
				<!--content starts here-->
				<div id="content" ><?php echo $content_for_layout; ?></div>
				<!--content ends here-->	
			
			</div>
			<!--body content start here-->
			
			<!--right menu starts here-->
			<div id="related-content">&nbsp;</div>
			<!--right menu ends here-->
			
			<!--footer starts here-->
			<div id="mainfooter" class="mainfooter">
				<div id="footer"></div>
			</div>
			<!--footer ends here-->
			
		</div>
		<!--main page container ends here-->
	</body>
</html>
