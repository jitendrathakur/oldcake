<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="de" lang="de">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=iso-8859-1"/>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		      

          
		<meta name="description" content=""/>
		<meta name="keywords" content=""/>
		<meta name="robots" content="index,follow"/>
		<meta name="author" content="CLIENT"/>
		<meta name="revisit-after" content="7 days"/>
		<meta name="title" content=""/>
		<meta name="content-language" content="de"/>
		 

		<title><?php echo isset($title_header)?$title_header:''?></title>
		
		<script type="text/javascript">
			function change_lang(lang) {
				document.getElementById("selected_lang").value = lang;
				document.getElementById("frm_change_lang").submit();
			}
			</script>
			<?php 
			if($_SESSION['APPNAME']  == 'Phone')
			{ 
				echo '<script type="text/javascript">';
				echo 'var base_url="' . Configure::read('base_url') . '"';
				echo '</script>';
			}
			else
			{
				echo '<script type="text/javascript">';
				echo 'var base_url="' . Configure::read('gate_url') . '"';
				echo '</script>';
			}
			?>
</script>
	<?php    if ($_SESSION['Config']['language'] != '')
                {
                        $page_lang = strtolower($_SESSION['Config']['language']);
                }
                else
                {
                        $page_lang = substr($_SERVER["HTTP_ACCEPT_LANGUAGE"],0,2);
                }

		//Style

	        echo $html->css('table'); #commented
	        //echo $html->css('prototable'); //for prototype
        	echo $html->css('phone');
        	echo $html->css('layout');
        	echo $html->css('form');
        	echo $html->css('formate');
			echo $html->css('jquery.fancybox');
			echo $html->css('station');
			echo $html->css('common');
			echo $html->css("custom");
			#echo $html->css("main"); // added colapsable
			echo $html->css("portal"); // for dashboard
			//echo $html->css('colorbox');
			
			//echo $html->css("jquery/jquery.ui.custom"); //commented
			echo $html->css("jquery.tablesorter.pager");  // added new
			echo $html->css("theme.bootstrap");  // added new
			echo $html->css("bootstrap.min");  // added new
			#echo $html->css("tablednd");  // added new
			echo $html->css("select2");
		
			echo $html->css("datepick"); //commented
			echo $html->css("jquery/jquery.ui.datepicker");
			echo $html->css("localization");  // added new

		//JAvascript
		//echo $javascript->link('/js/tooltip');
		echo $javascript->link('/js/jquery');
		
		echo $javascript->link('/js/webtoolkit.utf8');
		echo $javascript->link('/js/standard');
		echo $javascript->link('/js/table');
		echo $javascript->link('/js/station');
		
		echo $javascript->link('/js/jquery-1.10.1.min');
		
		#echo $javascript->link('/js/jquery.1-4-2.min'); 
		echo $javascript->link('/js/jquery_ui'); 
	
		echo $javascript->link('/js/'.$page_lang.'_language.js');
	
	  
        echo $javascript->link('/js/jquery.tablesorter'); //added new
		echo $javascript->link('/js/jquery.tablesorter.widgets');
		echo $javascript->link('/js/jquery.tablesorter.pager');
		echo $javascript->link('/js/jquery.tablednd');
		echo $javascript->link('/js/jquery-migrate-1.0.0.js');
		echo $javascript->link('/js/validation.js');
		echo $javascript->link('/js/select2.min.js');
		#echo $javascript->link('/js/jquery.mousewheel-3.0.6.pack');
	    #echo $javascript->link('/js/jquery.dataTables');
		#echo $javascript->link('/js/TableTools');	
		echo $javascript->link('/js/menu.js');
		
		echo $javascript->link('/js/modalPopLite1');
		echo $html->css('modalPopLite');

       		
	?>
</head>
<body>

<?php
# Use Tooltip Javascript
 echo $javascript->link('/js/wz_tooltip');
 echo $javascript->link('/js/tip_balloon');
?>

<script type="text/javascript">
 jQuery(document).ready(function(){
		jQuery.ajaxSetup({ cache: false });
			 
});
</script>


<?php


$mainPage = Router::url("/", true); 

#Check Customer Type
if(isset($SELECTED_CNN))
{
		$counts = array();
		$counts = $this->requestAction('customers/updatedcounts/' . $SELECTED_CNN);
}
?>
<script type="text/javascript">

var rootUrl = '<?php echo $mainPage; ?>';
</script>

<script type="text/javascript">
  $(function(){
buildMenu("<?php
if($_SESSION['APPNAME'] == 'Phone')
{

	echo $page_lang ?>","renderSelected","VoipPhoneSelfcare");
<?php
}
else
{
	echo $page_lang ?>","renderSelected","VoipGateSelfcare");
<?php
}
?>
});  

</script>


		<!--main page container starts here-->
		<div id="page">
		
			<!--header portion starts here-->
			<div id="header">

				<div id="logo">
					<a href="/portal/<?php echo $page_lang ?>/index.htm" title="<?php __('4-Sol Self-Care Interface') ?> "><?php echo $html->image('/images/assets/4sol_logo.png'); ?>
					</a>
				</div>

			
			<div id="title">Self-Care Console</div>
					<div id="logininfo">
						<p><?php __("Logged in as");?> <?php echo $_SESSION['USERFIRSTNAME']." ".$_SESSION['USERNAME'].", ".$_SESSION['ORGANIZATION'] ?>  | <a href="/?logout" title="<?php __("Logout");?>"><?php __("Logout");?></a></p>

					</div>
				<div id="language">
				<?php echo $form->create('localize',array('action'=>'change','id'=>'frm_change_lang')); ?>
					<input type="hidden" name="selected_lang" value="" id="selected_lang">
					<ul>
						<li><a href="javascript:void(null);" onclick="javascript:change_lang('de')" <?php echo  ($page_lang =='de')?'class="selected"':''?> title="Deutsch">DE</a></li>
                                                <li class="seperator">|</li>
                                                <li><a href="javascript:void(null);" onclick="javascript:change_lang('fr')" <?php echo  ($page_lang=='fr')?'class="selected"':''?> title="French">FR</a></li>
                                                <li class="seperator">|</li>
                                                <li><a href="javascript:void(null);" onclick="javascript:change_lang('it')"<?php echo  ($page_lang=='it')?'class="selected"':''?> title="Italien">IT</a></li>
                                                <li class="seperator">|</li>
                                                <li><a href="javascript:void(null);" onclick="javascript:change_lang('en')"<?php echo  ($page_lang=='en')?'class="selected"':''?> title="English">EN</a></li>
	
					</ul>
				<?php echo $form->end(); ?>
				</div>



			</div>
			

			<!--header portion starts here-->
			
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
				
				<div id="maintopContentBgLeft">
					<div id="maintopContentBgRight">
						<div id="maintopContent">
							<h1><?php __($title_for_layout);?></h1>
						</div>
					</div>
				</div>
		
				<div id="maintopRelatedContentBgRight" class="maintopRelatedContentBgRight">
					<div id="maintopRelatedContent">
						<h2>
							<a href="#" onclick="return toggleRelatedContent();" id="maintopContentButton" class="maintopRelatedContentButton">
								<?php __('Informationen') ?>
							</a>
						</h2>
					</div>
				</div>
				
			</div>
			<!--link  for minimize content /maximize ends here-->
			



			<!--body content start here-->
			<div id="main" class="main">
				<!--left menu starts from here-->
				<?php //echo "customer_id:". $SELECTED_CUSTOMER_NAME; ?>
				<div id="navigation" class="leftmenunav">
					
					
					<ul id="eServiceMenu">
										
					
					<?php #echo $this->element('left_menu',array('SELECT_CUSTOMER' => $SELECTED_CNN, 'APP' => $_SESSION['APPNAME'], 'PAGE_TITLE' =>  $title_for_layout)); ?>
					<?php 
					
					echo $this->element('left_menu',array('WORKFLOW' => $WORKFLOW, 'SELECT_CUSTOMER' => $SELECTED_CNN, 'counts' => $counts,'APP' => $_SESSION['APPNAME'], 'PAGE_TITLE' =>  $title_for_layout)); ?>
                                        </ul>	
				</div>
				
				<!--left menu ends here-->
			
				<!--content starts here-->
				<div id="content" >
				<?php
					if ($session->check('Message.flash')) {
					  	 $session->flash();
					}
				 	echo $content_for_layout;
				 ?>
				<!--content ends here-->	
			
			</div>
			<!--body content start here-->
			
			<!-- CBM Commented for test 201201105
			<div class="popup" id="static_page_div" style="top: 157px; left: 479px; display: none;"></div>
			<div class="black_overlay" style="height: 622px; width: 1366px; display: none;">
				<div id="black_overlay_loading">
				<img alt="" src="img/ajax-loader.gif">
				</div>
			</div>
			-->
			<!--right menu starts here-->
			<div id="related-content">&nbsp;</div>
			<!--right menu ends here-->
			
			<!--footer starts here-->
			<div id="footer">
				<p>&#169; <?php __('Copyright 4-Sol AG 2013 | All Rights Reserved') ?></p>
				<ul>
					<?php
					if ($page_lang == 'de')
					{ ?>
						<li><a href="javascript:void(0)" onclick="openPopUpPDF('')">Online Teilnahmebedingungen</a></li>
					<?php 
					}
					if ($page_lang == 'fr')
					{ ?>
						<li><a href="javascript:void(0)" onclick="openPopUpPDF('')">Conditions de participation</a></li>
					<?php 
					}
					if ($page_lang == 'en')
					{ ?>
						<li><a href="javascript:void(0)" onclick="openPopUpPDF('')">Conditions of use</a></li>
					<?php 
					}
					if ($page_lang == 'it')
					{ ?>
						<li><a href="javascript:void(0)" onclick="openPopUpPDF('')">Condizioni di partecipazione</a></li>
					<?php 
					} ?>

				

				</ul>
			</div>
			<!--footer ends here-->
			
		</div>
		<!--main page container ends here-->
		
		<?php echo $this->element('sql_dump'); ?> 
	</body>
</html>

