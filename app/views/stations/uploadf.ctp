<style type="text/css">
 
.button-right {
  background: url("../images/assets/btn-left-middle.gif") no-repeat scroll left center transparent;
  float: right;
  height: 22px;
  line-height: 18px;
  margin: 7px 2px 10px !important;
  padding: 0;
  vertical-align: middle;
  white-space: nowrap;
}
.button-right .submit {
  height: 18px;
  background: url(../images/assets/btn-right-arrow.gif) right no-repeat transparent !important;
  padding: 0px 20px 5px 10px!important;
  text-decoration: none;
  color: #555555;
  height: 18px;
  padding: 0 20px 0 10px;
}
 
.button-right:hover {
  height: 18px;
  float: right;
  background: url(../images/assets/btn-hov-left-middle.gif) left no-repeat transparent;
  padding: 0px;
  margin: 9px 2px 11px 2px;
  vertical-align: middle;
  line-height: 18px;
  white-space: nowrap;
}
 
.button-right .submit:hover {
  background: url("../images/assets/btn-hov-right-arrow.gif") no-repeat scroll right center transparent  !important;
  padding: 0px 20px 5px 10px!important;
  text-decoration: none;
  color: #fff;
  height: 18px;
  padding: 0 20px 0 10px;
  float: left !important;
}
 
</style>

 
<div class="row">
<div class="col-md-12">
<!-- Advanced Tables -->
<div class="panel panel-default">
<div class="panel-body">
 
 
<?php
 
echo $form->create('Station', array(
'action' => 'uploadf',
'type' => 'file'
));
 
echo $form->input('image_name', array('type'=>'file', 'label' => false));
?>
<div class="button-right">
<input class="submit" type="submit" value="submit" />
</div>
<?php
echo $form->end();
?>
</div>
<!--End Advanced Tables -->
</div>
</div><!-- /. ROW -->
</div><!-- /. page-inner -->