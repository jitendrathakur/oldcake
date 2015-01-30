<!--$Rev:: 22            $:  Revision of last commit--> 

<h1 style="width: 456px; text-align: left"><?php  __("Modification Confirmation")?></h1>
<hr style="width: 540px;  text-align: left"" >


<div style="color:#888784;padding:10px 10px 10px 10px;height:15px; align:left;">
<!--        <div style="height:100px;">&nbsp;</div>-->
<img style="display:none;" id="spinner" src="<?php echo Configure::read('base_url').'img/spinner.gif'?>"></div>
        <?php
        if(isset($blfValidate) && !empty($blfValidate)){
                foreach($blfValidate as $validate){
                        echo $validate."<br>";
                }
        }

        elseif(isset($display)){
                foreach($display as $value){

                                echo $value."<br>";
                }?>

                <!--
		<div class="block hide_button">
                        <div class="button-left">
                                <a href="#"  onclick="javascript:validate_submit();" name="validate" value="validate" onmouseover="hoverButtonLeft(this)" onmouseout="outButtonLeft(this)"><?php __(Confirm);?></a>
                        </div>
                </div>
                <div class="block hide_button">
                        <div class="button-left">
                                <a href="#"  onclick="javascript:validate_cancel();" name="validate" value="validate" onmouseover="hoverButtonLeft(this)" onmouseout="outButtonLeft(this)"><?php __(Cancel);?></a>
                        </div>
                </div>
		-->
		<div class="block hide_button">
                        <div class="button-right">
                                <a href="#"  onclick="javascript:validate_submit();" name="validate" value="validate" onmouseover="hoverButtonRight(this)" onmouseout="outButtonRight(this)"><?php __(Confirm);?></a>
                        </div>
                </div>
                <div class="block hide_button">
                        <div class="button-right">
                                <a href="#"  onclick="javascript:validate_cancel();" name="validate" value="validate" onmouseover="hoverButtonRight(this)" onmouseout="outButtonRight(this)"><?php __(Cancel);?></a>
                        </div>
                </div>


        <?php }

        elseif(isset($singleAcess) && $singleAcess){
                echo '<span class="flash_class">Sorry this page in use by user :'.$userAcessDetail[0]['Userlog']['user_name'].'</span>';
        ?>
		<!--cbm
                <div class="block hide_button">
                        <div class="button-right">
                                <a href="#"  onclick="javascript:submi_reset('stations');" name="validate" value="validate" onmouseover="hoverButtonRight(this)" onmouseout="outButtonRight(this)"><?php __(Cancel);?></a>
                        </div>
                </div>
		-->
        <?php }

        else{

                echo __("Sorry you didnt made any change");

        }?>
	<!--
        <?php if(!isset($singleAcess)){?>
				<div class="block hide_button" >
                        <div class="button-right">
                                <a href="#"  onclick="javascript:validate_cancel();" name="validate" value="validate" onmouseover="hoverButtonRight(this)" onmouseout="outButtonRight(this)"><?php __(Cancel);?></a>
                        </div>
                </div>
        <?php }?>
	-->
</div>
                 
