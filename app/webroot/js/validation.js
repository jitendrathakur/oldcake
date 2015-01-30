function inValidate(validation, eventType, selector, e) {
  
  exclude = false;
  if (eventType == 'keyup') {
    exclude = true;
  }
     
  //$("#"+index).addClass('error');
  //$('.help-inline span').closest('.control-group').removeClass('error'); 
  var invalid = false;
  if (typeof selector != "undefined") {
    var selectorId = $(selector).attr("id");   
    //console.log(selectorId);


    if ($(selector).closest(".fancybox-overlay").length) {
      $('.fancybox-overlay #overlay-error .error .message').text("");
      $('.fancybox-overlay #overlay-error').addClass('hide');
      $('.fancybox-overlay #overlay-error2 .error .message').text("");
      $('.fancybox-overlay #overlay-error2').addClass('hide');
    } else {
      $('#overlay-error .error .message').text("");
      $('#overlay-error').addClass('hide'); 
      $('#overlay-error2 .error .message').text("");
      $('#overlay-error2').addClass('hide'); 
    }

    //$("#"+index).addClass('error');
    $(selector).removeClass('error');
    if (typeof selectorId != "undefined") {
      if (typeof validation.rules[selectorId] != "undefined") {
        var operation = validation.rules[selectorId];
        invalid = preInvalidate(operation, selector, validation, e);
      }
    }    
  } else {   
    invalid = postInvalidate(validation);
  }  
 
  return invalid;
 
}//end inValidate()


function postInvalidate(validation) {
  invalid = false;

  $.each(validation.rules, function( index, value ) {
    
    var selector = "#"+index;

    if(!$(selector).is(":visible")) {
      
      $(selector).remove();

    }
    if ($(selector).hasClass('hide') || $(selector).is(":hidden")) {
      return;
    } 

    var thisVal = $(selector).val();
    if (typeof thisVal == 'undefined') {
      return;
    }
    $(selector).removeClass('error');
    if (typeof value === 'string') {
      if (value == 'required') {
        if ($(selector).val() == '') {          
          validationMsg(index, validation.messages[index]);          
          invalid = true;           
        }
      }  
    } else {      
      $.each(value, function( rule, expression ) {    
        if (exclude) {
          if (rule == 'min') {
            return;
          }
        }
        if($(selector).hasClass('hide')) {
          return;
        } 

        if ($(selector).length < 0) {
          return;
        }
        if (rule == 'required') {          
          if ($(selector).val() == '') {
            validationMsg(index, validation.messages[index][rule]);                      
            invalid = true;  
            return false;        
          }
        }  else if (rule == 'excludeStr') {
          var str = $(selector).val();             
          $.each(expression, function(key, value) {
            var excludeSymLength = value.length;
            var forStr = str.substring(0, excludeSymLength);           
            if (value == forStr) {

              validationMsg(index, validation.messages[index][rule]);          
              invalid = true;
              return false;            
            }
          });                              
        } else if (rule == 'min') {
          var strlength = $(selector).val().length;
          if ((strlength > 0) && (strlength < expression)) {
            validationMsg(index, validation.messages[index][rule]);             
            invalid = true;   
            return false;        
          }
        } else if (rule == 'max') { 

          if (typeof e != "undefined") {
            if (e.which == 8) {
              expression = expression + 1;
            }
            expression = expression - 1;
          }

          if ($(selector).val().length > expression) {
           
            validationMsg(index, validation.messages[index][rule]);              
            invalid = true; 
            if (typeof e != "undefined" && e.which != 8) {
              e.preventDefault();
            }  
            return false;        
          }          
      
        } else if (rule == 'leading') { 
        
          var str = $(selector).val();     
          var strLength = str.length;         
          if (strLength <= 0) {
            if (typeof e != "undefined") {              
              if (e.which != 96 && e.which != 48) {
                validationMsg(index, validation.messages[index][rule]);
                invalid = true;               
                if (e.which != 8) {
                  e.preventDefault();
                } 
                return false;  
              }
            }
          } else {
            var forStr = str.substring(0, 1);
        
            if (expression != forStr) {
              if (strLength > 1) {
                $(selector).val(str.substr(0, (strLength-2)));
              }
          
              validationMsg(index, validation.messages[index][rule]);
              invalid = true;
              return false;
            }         
          }                                              
                              
        } else if (rule == 'checkStr') {          
          var str = $(selector).val();
          if (str.indexOf("$") != -1) {
            invalid = true;        
            validationMsg(index, validation.messages[index][rule]);            
            return false;        
          }           
        } else if (rule == 'spclChar') {
          var str = $(selector).val();         
          if ((typeof str != 'undefined') && !isSplChar(str)) {
            validationMsg(index, validation.messages[index][rule]);
            invalid = true;            
            return false;        
          }
        } else if (rule == 'typeahead') {       
          if (($("#"+expression[1]).val() != '') && ($("#"+expression[0]).val() == '')) {
            //$("#"+expression[1]).closest('.input-append').removeClass('input-append');
            validationMsg(index, validation.messages[index][rule]);          
            invalid = true;
            return false;
          }                  
        } else if (rule == 'beforeCheck') {         
          if ((index == selector) && ("#"+index+":checked").length > 0 && $("#"+expression).val() == '') {            
            validationMsg(index, validation.messages[index][rule]);          
            invalid = true;
            return false;            
          }                  
        } else if (rule == 'isValue') {        
          if ($("#"+index+":checked").length > 0 && $("input[id*='"+expression+"']").val() == '') {            
            validationMsg(index, validation.messages[index][rule]);          
            invalid = true;
            return false;            
          }
        } else if (rule == 'notSpace') {      
          if (thisVal.indexOf(' ') >= 0) {
            validationMsg(index, validation.messages[index][rule]);          
            invalid = true;
            return false;  
          }         
        }
      });
    }  
   
  });

  return invalid;
}//end postInvalidate()


function preInvalidate(value, selector, validation, e) {
  invalid = false;   
  var index = $(selector).attr("id");
  if (typeof value === 'string') {
    if (value == 'required') {
      if ($(selector).val() == '') {          
        validationMsg(index, validation.messages[index]);          
        invalid = true;           
      }
    }  
  } else {      
    $.each(value, function( rule, expression ) {    
      if (exclude) {
        if (rule == 'min') {
          return;
        }
      }
      if($(selector).hasClass('hide')) {
        return;
      } 

      if ($(selector).length < 0) {
        return;
      }
      if (rule == 'excludeStr') {
        var str = $(selector).val();             
        $.each(expression, function(key, value) {
          var excludeSymLength = value.length;
          var forStr = str.substring(0, excludeSymLength);           
          if (value == forStr) {

            validationMsg(index, validation.messages[index][rule]);          
            invalid = true;
            return false;            
          }
        });                              
      } else if (rule == 'min') {
        if ($(selector).val().length < expression) {
          validationMsg(index, validation.messages[index][rule]);             
          invalid = true;   
          return false;        
        }
      } else if (rule == 'max') { 

        if (typeof e != "undefined") {
          if (e.which == 8) {
            expression = expression + 1;
          }
          expression = expression - 1;
        }

        if ($(selector).val().length > expression) {
         
          validationMsg(index, validation.messages[index][rule]);              
          invalid = true; 
          if (typeof e != "undefined" && e.which != 8) {
            e.preventDefault();
          }  
          return false;        
        }          
    
      } else if (rule == 'leading') {
 
        var str = $(selector).val();     
        var strLength = str.length;         
        if (strLength <= 0) {
          if (typeof e != "undefined") {              
            if (e.which != 96 && e.which != 48) {
              validationMsg(index, validation.messages[index][rule]);
              invalid = true;               
              if (e.which != 8) {
                e.preventDefault();
              } 
              return false;  
            }
          }
        } else {
          var forStr = str.substring(0, 1);
      
          if (expression != forStr) {
            if (strLength > 1) {
              $(selector).val(str.substr(0, (strLength-2)));
            }
        
            validationMsg(index, validation.messages[index][rule]);
            invalid = true;
            return false;
          }
        }                                              
                            
      } else if (rule == 'checkStr') {          
        var str = $(selector).val();
        if (str.indexOf("$") != -1) {
          invalid = true;        
          validationMsg(index, validation.messages[index][rule]);            
          return false;        
        }           
      } else if (rule == 'spclChar') {
        var str = $(selector).val();
        if (!isSplChar(str)) {
          validationMsg(index, validation.messages[index][rule]);
          invalid = true;            
          return false;        
        }
      } else if (rule == 'typeahead') {       
        if (($("#"+expression[1]).val() != '') && ($("#"+expression[0]).val() == '')) {
          //$("#"+expression[1]).closest('.input-append').removeClass('input-append');
          validationMsg(index, validation.messages[index][rule]);          
          invalid = true;
          return false;
        }                  
      } else if (rule == 'beforeCheck') {  

        if (("#"+index+":checked").length > 0 && $("#"+expression).val() == '') {            
          validationMsg(index, validation.messages[index][rule]);          
          invalid = true;
          return false;            
        }                  
      } else if (rule == 'notSpace') {   
        var thisVal = $(selector).val();        
        if (thisVal.indexOf(' ') >= 0) {
          validationMsg(index, validation.messages[index][rule]);          
          invalid = true;
          return false;  
        }
      }
    });
  }  
  return invalid;
}//end preInvalidate()



function classInValidate(classValidation, eventType, obj, e) { 
  //console.log(classValidation); 
  var exclude = false;
  if (eventType == 'keyup') {
    exclude = true;
  }

  $('#overlay-error .error .message').text('');
  $('#overlay-error').addClass('hide');

  var invalid = false   
  $.each(classValidation.rules, function( index, value ) {

   
   
    $("."+index).removeClass('error');

    //console.log(obj);

    if (typeof obj != 'undefined') {  
      if (!$(obj).hasClass(index)) {
        return false;
      }
      //console.log("if");

      invalid = classValidationRule(obj, index, value, classValidation, e, exclude, invalid);
    } else {     
      //console.log("else");

      if ($("input."+index).length > 0) {
        $("input."+index).each(function(x, curObj) {

          invalid = classValidationRule(curObj, index, value, classValidation, e, exclude, invalid)
              
        }); //end class each
      }//end if

    }//end obj if 
                  
  }); 
 
  return invalid;
 
}//end classInValidate()


function classValidationRule(curObj, index, value, classValidation, e, exclude, invalid) {
    
  if (typeof value === 'string') {
    if (value == 'required') {
      if ($(curObj).val() == '') {          
        ClassValidationMsg(curObj, index, classValidation.messages[index]);          
        invalid = true;           
      }
    }  
  } else {      
    $.each(value, function( rule, expression ) {  

      if (exclude) {
        if (rule == 'min') {
          return;
        }
      }  

      if($(curObj).hasClass('hide') || $(curObj).is(":hidden")) {
        return;
      } 
      if (rule == 'required') {          
        if ($(curObj).val() == '') {
          ClassValidationMsg(curObj, index, classValidation.messages[index][rule]);                      
          invalid = true;  
          return false;        
        }
      } else if (rule == 'leading') {     

        var str = $(curObj).val();     
        var strLength = str.length;         
        if (strLength <= 0) {
          if (typeof e != "undefined") {                  
            if (e.which != 96 && e.which != 48 && e.which!=17 && e.which!=86 && e.which!=67 && e.which!=88) {
              ClassValidationMsg(curObj, index, classValidation.messages[index][rule]);
              invalid = true;               
              if (e.which != 8) {
                e.preventDefault();
              } 
              return false;  
            }
          }

        } else {
          var forStr = str.substring(0, 1);
      
          if (expression != forStr) {
            if (strLength > 1) {
              $(curObj).val(str.substr(0, (strLength-2)));
            }
        
            ClassValidationMsg(curObj, index, classValidation.messages[index][rule]);
            invalid = true;
            return false;
          }         
        }           

                        
      } else if (rule == 'excludeStr') { 
          
          var str = $(curObj).val();
           
          $.each(expression, function(key, value) {
            var excludeSymLength = value.length;
            
            var forStr = str.substring(0, excludeSymLength);           
          
            if (value == forStr) {
          
              ClassValidationMsg(curObj, index, classValidation.messages[index][rule]);
              invalid = true;
              return false;            
            }
          });                                 
                        
      } else if (rule == 'min') {    
        var str = $(curObj).val();    
        if (str.length > 0) {          
          if (str.length < expression) {
            ClassValidationMsg(curObj, index, classValidation.messages[index][rule]);             
            invalid = true;   
            return false;        
          }
        }
      } else if (rule == 'max') {  
        if (typeof e != "undefined") {
          if (e.which == 8) {
            expression = expression + 1;
          }
        }             
        if ($(curObj).val().length > (expression - 1)) {
         
          ClassValidationMsg(curObj, index, classValidation.messages[index][rule]);              
          invalid = true; 
          if (typeof e != "undefined" && e.which != 8) {
            e.preventDefault();
          }  
          return false;        
        }
      }
    });
  }

  return invalid;

}//end classValidationRule()


function ClassValidationMsg(curObj, index, message) {
  $('#overlay-error .error .message').text(message);
  $('#overlay-error').removeClass('hide');
  //$('#overlay-sucess').addClass('hide');  
  $(curObj).removeClass('form-change');
  $(curObj).addClass('error');
}


/*Check for a special character'***/
function isSplChar(str)
{ 
  var spchar, getChar, SpecialChar; 
  spchar ="AaBbCcDdEeFfGgHhIiJjKkLlMmNnOoPpQqRrSsTtUuVvWwXxYyZz0123456789_ "; 
  getChar='Empty';
  SpecialChar='No';
  for(var i=0; i<str.length;i++)
  {
    for(var j=0; j<spchar.length;j++)
    {     
      if(str.charAt(i)== spchar.charAt(j))
      {     
          SpecialChar='No';
          break;
      }
      else
      {
        SpecialChar='Yes';
      }
    }   
    if (SpecialChar == 'Yes')
    {
      break;
    }
  }
  if (SpecialChar == 'Yes')
  {
    return false;
  }
  else if (SpecialChar == 'No')
  {
    return true;
  }
}//end isSplChar()


function validationMsg(index, message) {  
  if ($("#"+index).closest(".fancybox-overlay").length) {
    $('.fancybox-overlay #overlay-error .error .message').text(message);
    $('.fancybox-overlay #overlay-error').removeClass('hide');
  } else {
    $('#overlay-error .error .message').text(message);
    $('#overlay-error').removeClass('hide');
  }
 
  
  $('#overlay-error2 .error .message').text(message);
  $('#overlay-error2').removeClass('hide');
  
  $("#"+index).addClass('error');
  $("#"+index).removeClass('form-change');
}

$(document).ready(function() {

 /* $("body").on('keypress', '.numeric_check', function (e)  
  {
    //if the letter is not digit then display error and don't type anything
    if( 
      e.which!=8 && 
      e.which!=0 && 
      (e.which<48 || e.which>57) && 
      e.which!=118 &&
      e.which!=67
      )
    {
      //display error message
      //$("#errmsg").html("Digits Only").show().fadeOut("slow"); 
      return false;
    } 
  });


  function interceptKeys(evt) {
      evt = evt||window.event // IE support
      var c = evt.which;
      var ctrlDown = evt.ctrlKey||evt.metaKey // Mac support

      // Check for Alt+Gr (http://en.wikipedia.org/wiki/AltGr_key)
      if (ctrlDown && evt.altKey) return true

      // Check for ctrl+c, v and x
      //else if (ctrlDown && c==67) return false // c
      else if (ctrlDown && c==86) return false // v
      //else if (ctrlDown && c==88) return false // x

      // Otherwise allow
      return true
  }*/
  

  $("body").on('click', 'input[type="checkbox"]', function(e) {

    var flag = false;

    var readonly = $(this).attr('readonly');

    if (typeof readonly != 'undefined') {
      return false;
    }
   
    var form = $(this).parents('form:first');
    var invalidate = form.attr("invalidate");
    var chkId = $(this).attr('id');
   
    $.each(validation.rules, function(index, value) {
      if (chkId == index) {        
        $.each(value, function(rule, expression) {
          if (rule == 'beforeCheck') {
            flag = true;
          }

        });
      }      
     
    });
    if ((typeof invalidate != "undefined") && flag) {      
      //if (inValidate(validation)) {
      if($(this).is(':checked')) {          
        if (inValidate(validation, null, $(this), e)) {
          $(this).attr('checked', false);  
        } else {
          $(this).addClass('form-change');
        }          
      } else {
        $(this).addClass('form-change');
      }
      //}        
    }
    return true;
  });

  $("body").on('change', 'select', function() {
    var form = $(this).parents('form:first');
    var invalidate = form.attr("invalidate");
    if (typeof invalidate != "undefined") {
      $(this).addClass('form-change');
    } else {
      console.log("no validation");
    }
  });

  $("body").on('focus', 'input', function() {
    var form = $(this).parents('form:first');
    var invalidate = form.attr("invalidate");
    var oldVal = $(this).val();   
    if (oldVal == '') {
      oldVal="1";
    }
      
    $(this).attr('data-value', oldVal);      

  });

  $("body").on('keydown', 'input, textarea', function(e) {  
  
    var form = $(this).parents('form:first');
    var invalidate = form.attr("invalidate");    

    var oldVal = $(this).val();   
    
    var priorVal = $(this).attr('data-value'); 
    
    if (priorVal != '' && oldVal != priorVal) {
        $(this).addClass('form-change');
    }   

    if (typeof invalidate != "undefined") {
      
      //$("input, textarea").not('.numeric_check').keydown(function(e) {
              
        inValidate(validation, 'keyup', $(this), e);
       
      //});      
      
    } else {
      console.log("no validation");
    }
  });

});


