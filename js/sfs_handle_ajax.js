var sfs_ajax_who="";
function sfs_ajax_process(sip,contx,sfunc,url) {
sfs_ajax_who=contx;
var data= {
action: 'sfs_process',
ip:sip,
cont: contx, 
func: sfunc, 
ajax_url: url
}
jQuery.get(ajaxurl, data, sfs_ajax_return_process);
}
function sfs_ajax_return_process(response) {
var el="";
if (response=="OK") {
return false;
}
if (response.substring(0,3)=="err") {
alert(response);
return false;
}
if (response.substring(0,4)=="\r\n\r\n") {
alert(response);
return false;
}
if (sfs_ajax_who!="") {
var el=document.getElementById(sfs_ajax_who);
el.innerHTML=response;
}
return false;
}
function sfs_ajax_report_spam(t,id,blog,url) {
sfs_ajax_who=t;
var data= {
action: 'sfs_sub',
blog_id: blog,
comment_id: id,
ajax_url: url
}
jQuery.get(ajaxurl, data, sfs_ajax_return_spam);
}
function sfs_ajax_return_spam(response) {
sfs_ajax_who.innerHTML=" Spam Reported";
sfs_ajax_who.style.color="green";
sfs_ajax_who.style.fontWeight="bolder";
if (response.indexOf('data submitted successfully')>0) {
return false;
}
if (response.indexOf('recent duplicate entry')>0) {
sfs_ajax_who.innerHTML=" Spam Already Reported";
sfs_ajax_who.style.color="yellow";
sfs_ajax_who.style.fontWeight="bolder";
return false;
}
sfs_ajax_who.innerHTML=" Status: "+response;
sfs_ajax_who.style.color="black";
sfs_ajax_who.style.fontWeight="bolder";
alert(response);
return false;
}