<!--$Rev:: 22            $:  Revision of last commit--> 

<?php if($status!=1){?>
<script>
var parDoc = window.parent.document;
parDoc.getElementById("upload_status").innerHTML = '<?php echo $msg; ?>';
parDoc.getElementById("file").value = '';
parDoc.getElementById("upload_button").style.display = 'block';
</script>
<?php }else{?>
<script>
	var parDoc = window.parent.document;
	parDoc.getElementById("upload_status").innerHTML = '<?php echo $msg; ?>';
	parDoc.getElementById("upload_button").style.display = 'block';
	parDoc.getElementById("file").value = '';
</script>
<?php }?>
