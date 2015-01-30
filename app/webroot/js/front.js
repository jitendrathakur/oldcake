;var host = window.location.host;
var proto = window.location.protocol;
var ajax_url = proto+"//"+host+"/voipgate/";
$.ajaxSetup ({cache: false});
jQuery(document).ready(function(){
	jQuery("a.ajax_page").click(function(){
		
	var type="create";
	if($(this).attr("id")){
		type="edit";
	}
	
	
	show_overlay();
	
	jQuery.ajax({
	    url:ajax_url+"scenarios/create_schedule/"+jQuery(this).attr("rel")+"/"+type+"/"+jQuery(this).attr("rel1")+"/"+$(this).attr("act"),
	    success:function(response){
		jQuery("div#static_page_div").html(response);
		showPopUp("static_page_div");
	    }
	    });
    });
});

function showPopUp(trgt)
{
	$("#"+trgt).css('top',($(window).height()/2)-$("#"+trgt).height()/2);
	$("#"+trgt).css('left',$(window).width()/2-$("#"+trgt).width()/2);
	$("#"+trgt).fadeIn("slow");

}

function show_overlay()
{
  if(jQuery(".black_overlay").length != '0')
  {
	
      if (window.innerHeight) 
      {// Firefox
	  if(window.scrollMaxY)
	  {
	      yWithScroll = window.innerHeight + window.scrollMaxY;
	      xWithScroll = window.innerWidth + window.scrollMaxX;
	  }
	  else
	  {
	      yWithScroll = window.innerHeight;
	      xWithScroll = window.innerWidth ;
	  }
      } 
      else if (document.body.scrollHeight > document.body.offsetHeight)
      { // all but Explorer Mac
	  yWithScroll = document.body.scrollHeight;
	  xWithScroll = document.body.scrollWidth;
      }
      else 
      { // works in Explorer 6 Strict, Mozilla (not FF) and Safari
	  yWithScroll = document.body.offsetHeight;
	  xWithScroll = document.body.offsetWidth;
      }
      
      jQuery(".black_overlay").css({'height':jQuery(document).height(),'width':jQuery(document).width()});
      jQuery(".black_overlay").show();
	  
  }
}

function hidePopUp(trgt)
{
	jQuery("#"+trgt).fadeOut("slow");
	jQuery(".black_overlay").hide();
}

function test_pop(scenario_id, type, customer_id, execution_id, act){
	//alert('hi');
	var dest_url = ajax_url+"scenarios/create_schedule/";
	if(scenario_id != '' && scenario_id !='undefined'){
	dest_url += scenario_id+"/";
	}
	if(type != ''){
	dest_url += type+"/";
	}
	if(customer_id != ''){
	dest_url += customer_id+"/";
	}
	
	if(execution_id != ''){
	dest_url += execution_id+"/";
	}
	if(act != ''){
	dest_url += act+"/";
	}
 	$.fn.colorbox({
				href:dest_url,
				transition:'fade',
				overlayClose:false, 
				speed:350,width:400,height:310,
				onClosed:$.fn.colorbox.init()})
				return false;
}
