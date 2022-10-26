function split(num, split, join)
{
	if(typeof split == "undefined")
	{
		split 	= '.';
		join 	= '';
	}

    return num.toString().split(split).join(join);
}

function number_format(number, decimals, dec_point, thousands_sep) 
{
	var n = number, prec = decimals;

	var toFixedFix = function (n,prec) {
		var k = Math.pow(10,prec);
		return (Math.round(n*k)/k).toString();
	};

	n = !isFinite(+n) ? 0 : +n;
	prec = !isFinite(+prec) ? 0 : Math.abs(prec);
	var sep = (typeof thousands_sep === 'undefined') ? '.' : thousands_sep;
	var dec = (typeof dec_point === 'undefined') ? ',' : dec_point;

	var s = (prec > 0) ? toFixedFix(n, prec) : toFixedFix(Math.round(n), prec); //fix for IE parseFloat(0.55).toFixed(0) = 0;

	var abs = toFixedFix(Math.abs(n), prec);
	var _, i;

	if (abs >= 1000) {
		_ = abs.split(/\D/);
		i = _[0].length % 3 || 3;

		_[0] = s.slice(0,i + (n < 0)) +
			  _[0].slice(i).replace(/(\d{3})/g, sep+'$1');
		s = _.join(dec);
	} else {
		s = s.replace(',', dec);
	}

	var decPos = s.indexOf(dec);
	if (prec >= 1 && decPos !== -1 && (s.length-decPos-1) < prec) {
		s += new Array(prec-(s.length-decPos-1)).join(0)+'0';
	}
	else if (prec >= 1 && decPos === -1) {
		s += dec+new Array(prec).join(0)+'0';
	}

	if(number<0){
    	s="("+s.replace("-","")+")";
    }
	return s; 
}

function currency()
{
	var keys = 0;
	$(document).on( 'keydown', '.currency', function (event) {
	//$(".currency").keydown(function(event) {
		keys = event.keyCode;
		// Allow: backspace, delete, tab, escape, and enter
        if (event.keyCode == 116 || event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 27 || event.keyCode == 13 || 
             // Allow: Ctrl+A
            (event.keyCode == 65 && event.ctrlKey === true) || 
            //  Allow: Ctrl+C
            (event.keyCode == 67 && event.ctrlKey === true) || 
            //  Allow: Ctrl+C
            (event.keyCode == 86 && event.ctrlKey === true) ||
             // Allow: home, end, left, right
            (event.keyCode >= 35 && event.keyCode <= 39) || event.keyCode == 190 || event.keyCode == 110|| event.keyCode == 188) {
                 // let it happen, don't do anything             	
				return;
        }
        else {
            // Ensure that it is a number and stop the keypress
            if (event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
                event.preventDefault(); 
            }   
        }
    });
	
	$(document).on( 'keyup', '.currency', function (event) {
	//$(".currency").keyup(function(event) {
		if(keys != 188 /*&& keys != 46*/){

			var val = split($(this).val(),'.','');
			var extra = '';
			if (val != null && val != '') {
		      if (val.indexOf(',') > 0) {
		      	var arr = val.split(',');
		      	val 	= arr[0];
		      	console.log(arr[1]);
		        //extra = (arr[1] == 0) ? ',' + arr[1] : '';
		        extra = ',' + arr[1];
		      }
		    } 
		
			console.log(val);
			$(this).val(to_curr_normal(val) + extra);
            $(this).val($(this).val())[0].dispatchEvent(new Event('input'));
		}
	});
}

function strrchr (haystack, needle) 
{
  var pos = 0;

  if (typeof needle !== 'string') {
    needle = String.fromCharCode(parseInt(needle, 10));
  }
  needle = needle.charAt(0);
  pos = haystack.lastIndexOf(needle);
  if (pos === -1) {
    return false;
  }

  return haystack.substr(pos);
}

function strpos (haystack, needle, offset) 
{
  var i = (haystack + '').indexOf(needle, (offset || 0));
  return i === -1 ? false : i;
}

function curr_antonim($number)
{
	if($number==null || $number == 0){
		return 0;
	}else{
		$string = strrchr($number, ",").toString().substr(1);
		$char = ".";
		$positions =new Array();
		$pos = -1;
		$x = 0;
		while (($pos = strpos($string, $char, $pos+1)) !== false) {
			$x++;
			$positions[$x] = $pos;
		}

		$result = $positions.join(", ");
		if($result == ""){
			$number = $number.split('.').join('ttk').split(',').join('.').split('ttk').join(',');
		}
		else
		{
			$number = $number.split(',').join('km').split('.').join(',').split('km').join('.');
		}

		return $number;
	}
}

function curr_to_netral($number) //hanya untuk format id 1.000.000,23
{
	return split(split($number, '.', ''),',','.');
}

function curr_jns($number)
{
	if($number == null) return 'us';
	$temp = $number.toString().split(",")[1];
	if(typeof $temp == 'undefined')
	{
		$temp = $number.toString().split(".")[1];
		if(typeof $temp == 'undefined')
		{
			status='us';
		}else if($temp.toString().split(".").length <2)
		{
		  status='us';
		}
		else
		{
			status='id';
		}
	}else if($temp.toString().split(".").length >1)
	{
	  status='us';
	}
	else
	{
		status= 'id';
	}
	
	return status;
}

function curr($number)
{
	return curr_jns($number) == 'id'? curr_to_id(curr_antonim($number)):curr_to_id($number)	;
}

function curr_to_id($number)
{
	return format( "#.##0,###", $number);	
}

function curr_to_id_2angka($number)
{
	return format( "#.##0,##", $number);	
}

function curr_to_idNew($number)
{
	return format( "#.###,###", $number);	
}

function to_curr_normal($number)
{
	var curr = curr_jns($number) != 'id'?curr_to_id($number):curr_to_id(curr_to_netral($number));

	return curr;
}

function to_curr($number)
{	
	var numbered = parseInt($number);

	var curr = curr_jns($number) != 'id'?curr_to_id($number):curr_to_id(curr_to_netral($number));

	var currSplit = curr.split(",");
	var str = "0";

	if(currSplit[1] != null){
		str = currSplit[1];
	}
	
    while (str.length < 2) {
        str = str + '0';
    }

    curr = currSplit[0]+","+str;

    
    if(numbered<0){
    	curr="("+curr.replace("-","")+")";
    }

	return curr;
}

function FormatCurrency(ctrl) 
{
    var val = ctrl.value;

    val = val.replace(/\./g, "")
    ctrl.value = "";
    val += '';
    x = val.split(',');
    x1 = x[0];
    x2 = x.length > 1 ? ',' + x[1] : '';

    var rgx = /(\d+)(\d{3})/;

    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + '.' + '$2');
    }

    ctrl.value = x1 + x2;
}

function parseToFloat(num) 
{
    if (num != null && num != '') {
      if (num.indexOf(',') > 0) {
        num   = num.replace(/,/g, '.');
      }
    } else {
      num = '0' ;
    }
    num = parseFloat(num).toFixed(2);
    return num;
}

function numeric($format)
{
	var keys = 0;
	$(".numeric").keydown(function(event) {
		keys = event.keyCode;
		// Allow: backspace, delete, tab, escape, and enter
        if (event.keyCode == 116 || event.keyCode == 46 || event.keyCode == 188 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 27 || event.keyCode == 13 || 
             // Allow: Ctrl+A
            (event.keyCode == 65 && event.ctrlKey === true) || 
             // Allow: home, end, left, right
            (event.keyCode >= 35 && event.keyCode <= 39) || event.keyCode == 190 || event.keyCode == 110|| event.keyCode == 188) {
                 // let it happen, don't do anything
				return;
        }
        else {
            // Ensure that it is a number and stop the keypress
            if (event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
                event.preventDefault(); 
            }   
        }
    });
}

function populateForm($form, data)
{
    //console.log("PopulateForm, All form data: " + JSON.stringify(data));

    $.each(data, function(key, value)   // all json fields ordered by name
    {
        //console.log("Data Element: " + key + " value: " + value );
        var $ctrls = $form.find('[name='+key+']');  //all form elements for a name. Multiple checkboxes can have the same name, but different values

        //console.log("Number found elements: " + $ctrls.length );

        if ($ctrls.is('select')) //special form types
        {
            $('option', $ctrls).each(function() {
                if (this.value == value)
                    this.selected = true;
            });
        } 
        else if ($ctrls.is('textarea')) 
        {
            $ctrls.val(value);
        } 
        else 
        {
            switch($ctrls.attr("type"))   //input type
            {
                case "text":
                case "hidden":
                    $ctrls.val(value);   
                    break;
                case "radio":
                    if ($ctrls.length >= 1) 
                    {   
                        //console.log("$ctrls.length: " + $ctrls.length + " value.length: " + value.length);
                        $.each($ctrls,function(index)
                        {  // every individual element
                            var elemValue = $(this).attr("value");
                            var elemValueInData = singleVal = value;
                            if(elemValue==value){
                                $(this).prop('checked', true);
                            }
                            else{
                                $(this).prop('checked', false);
                            }
                        });
                    }
                    break;
                case "checkbox":
                    if ($ctrls.length > 1) 
                    {   
                        //console.log("$ctrls.length: " + $ctrls.length + " value.length: " + value.length);
                        $.each($ctrls,function(index) // every individual element
                        {  
                            var elemValue = $(this).attr("value");
                            var elemValueInData = undefined;
                            var singleVal;
                            for (var i=0; i<value.length; i++){
                                singleVal = value[i];
                                console.log("singleVal : " + singleVal + " value[i][1]" +  value[i][1] );
                                if (singleVal == elemValue){elemValueInData = singleVal};
                            }

                            if(elemValueInData){
                                //console.log("TRUE elemValue: " + elemValue + " value: " + value);
                                $(this).prop('checked', true);
                                //$(this).prop('value', true);
                            }
                            else{
                                //console.log("FALSE elemValue: " + elemValue + " value: " + value);
                                $(this).prop('checked', false);
                                //$(this).prop('value', false);
                            }
                        });
                    }
                    else if($ctrls.length == 1)
                    {
                        $ctrl = $ctrls;
                        if(value) {$ctrl.prop('checked', true);}
                        else {$ctrl.prop('checked', false);}

                    }
                    break;
            }  //switch input type
        }
    }) // all json fields
}  // populate form

function printErrorMsg (msg, idForm = '') {
    var focus = '';
    $.each( msg, function( key, value ) {
      console.log(((idForm != '') ? idForm + ' ' : '') + '[name="'+key+'"]');
      var obj = $(((idForm != '') ? idForm + ' ' : '') + '[name="'+key+'"]');
      obj.removeClass();
      obj.addClass('form-control is-invalid');
      obj.siblings('.invalid-feedback').text(value);
      obj.removeClass('is-valid');

      if (focus == '') {
        focus = '1';
        $('[name="'+key+'"]').focus();
      }
    });
  }

$(document).ready(function() {
	numeric();
	currency();
});