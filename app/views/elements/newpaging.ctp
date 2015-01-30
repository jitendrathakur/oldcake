<style>
.paging a:link {
    color: #11AAFF;
    padding: 4px;
    text-decoration: none;
}
</style>
<?php echo $this->element('pagination/newtop'); ?>
<div class="paging" style="padding:5px;">
<?php

$url = $this->params['url'];
unset($url['url']);
$get_var = http_build_query($url);

$arg1 = array(); $arg2 = array(); $arg3=array();
//take the named url
if(!empty($this->params['named']))
$arg1 = $this->params['named'];


if(!empty($this->params['pass']))
$arg2 = $this->params['pass'];
$args = array_merge($arg1,$arg2);
$args["?"] = $get_var;

//pr($args);
$paginator->options(array('url' => $args));
?>



<?php echo $paginator->prev();?>
<?php echo $paginator->numbers();?>
<?php echo $paginator->next();?>
</div>