var sfs_ajax_who = "";

function sfs_ajax_process(sip, contx, sfunc, url, email = '') {
	sfs_ajax_who = contx;
	var data = {
		action: 'sfs_process',
		ip: sip,
		email: email,
		cont: contx,
		func: sfunc,
		ajax_url: url
	};
	jQuery.get(ajaxurl, data, sfs_ajax_return_process);
}

function sfs_ajax_return_process(response) {
	var el = "";
	if (response == "OK") {
		return false;
	}
	if (response.substring(0, 3) == "err") {
		alert(response);
		return false;
	}
	if (response.substring(0, 4) == "\r\n\r\n") {
		alert(response);
		return false;
	}
	if (sfs_ajax_who != "") {
		var el = document.getElementById(sfs_ajax_who);
		el.innerHTML = response;
	}
	return false;
}

function sfs_ajax_report_spam(t, id, blog, url, email, ip, user) {
	sfs_ajax_who = t;
	var data = {
		action: 'sfs_sub',
		blog_id: blog,
		comment_id: id,
		ajax_url: url,
		email: email,
		ip: ip,
		user: user
	};
	jQuery.get(ajaxurl, data, sfs_ajax_return_spam);
}

function sfs_ajax_return_spam(response) {
	sfs_ajax_who.innerHTML = " Spam Reported";
	sfs_ajax_who.style.color = "green";
	sfs_ajax_who.style.fontWeight = "bolder";
	if (response.indexOf('data submitted successfully') > 0) {
		return false;
	}
	if (response.indexOf('recent duplicate entry') > 0) {
		sfs_ajax_who.innerHTML = " Spam Already Reported";
		sfs_ajax_who.style.color = "yellow";
		sfs_ajax_who.style.fontWeight = "bolder";
		return false;
	}
	sfs_ajax_who.innerHTML = " Status: " + response;
	sfs_ajax_who.style.color = "black";
	sfs_ajax_who.style.fontWeight = "bolder";
	alert(response);
	return false;
}

jQuery(function($) {
	$('.ss-hide-notice').click(function() {
		if ($(this).data('target') == 'user') {
			$(this).parent().parent().hide();
			var data = {
				action: 'ss_update_notice_preference',
				notice_id: $(this).data('notice-id')
			};
			$.post(ajaxurl, data);
		}
	});
	$('#ss_disable_admin_emails').click(function() {
		if (this.checked) {
			$('.ss_disable_admin_emails_wraps').show()
		} else {
			$('.ss_disable_admin_emails_wraps').hide()
		}
	});
	$('#ss_hide_admin_notices').click(function() {
		if (this.checked) {
			$('.ss_reset_hidden_notice_wrap').hide()
		} else {
			$('.ss_reset_hidden_notice_wrap').show()
		}
	});
});