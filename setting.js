function _sphca_submit()
{
	//if(document.sphca_form.sphca_title.value=="")
//	{
//		alert("Please enter the popup window title.")
//		document.sphca_form.sphca_title.focus();
//		return false;
//	}
	if((document.sphca_form.sphca_width.value=="") || isNaN(document.sphca_form.sphca_width.value))
	{
		alert("Please enter window width, only number.")
		document.sphca_form.sphca_width.focus();
		return false;
	}
	else if((document.sphca_form.sphca_height.value=="") || isNaN(document.sphca_form.sphca_height.value))
	{
		alert("Please enter window height, only number.")
		document.sphca_form.sphca_height.focus();
		return false;
	}
	else if(document.sphca_form.sphca_text.value=="")
	{
		alert("Please enter the message.")
		document.sphca_form.sphca_text.focus();
		return false;
	}

}

function _sphca_delete(id)
{
	if(confirm("Do you want to delete this record?"))
	{
		document.sphca_display.action="options-general.php?page=scroll-popup-html-content-ads/content-management.php&AC=DEL&DID="+id;
		document.sphca_display.submit();
	}
}	

function _sphca_redirect()
{
	window.location = "options-general.php?page=scroll-popup-html-content-ads/content-management.php";
}