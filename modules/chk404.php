<?php
// checks 404s to see if anyone is fishing for an exploit

if ( !defined( 'ABSPATH' ) ) {
	http_response_code( 404 );
	die();
}

class chk404 extends be_module {
	public function process( $ip, &$stats = array(), &$options = array(), &$post = array() ) {
		// following strings are possibly exploits - it may be a malicious robot is searching for an exploitable program
		$expl = array(
			'/administrator/',
			'/doc-ready/doc-ready',
			'/eventEmitter/EventEmitter',
			'/eventie/eventie',
			'/fck_about.html',
			'/magmi/plugins/xmlrpc.php',
			'/matches-selecto',
			'/outlayer/item',
			'/outlayer/outlayer',
			'/plus/download.php',
			'/uploadify.swf',
			'ewebeditor',
			'fck_about.html',
			'function.opendir',
			'info_sub.asp',
			'mytag_js.php',
			".asp",
			"1.rar",
			"11.rar",
			"111.rar" .
			"2.rar",
			"2013.rar",
			"3.rar",
			"ag.rar",
			"beifen.rar",
			"ceshi.rar",
			"com.rar",
			"db.rar",
			"flashfxp.rar",
			"htdocs.rar",
			"htdocs.zip",
			"news.rar",
			"old.rar",
			"scripts/setup.php",
			"shujuku.rar",
			"uploads.rar",
			"web.rar",
			"webcom.rar",
			"webcom.zip",
			"www.rar",
			"www2.rar",
			"wwwroot.rar",
			"wwwroot.zip",
			"\\xcd\\xf8\\xd5\\xbe.rar",
			'.cgi',
			'.pl', // bash exploits
			'/access/help',
			'action=rp&',
			'cip4-download.php',
			'download-manager/readme.txt',
			'edu.asp',
			'fckeditor',
			'gi-media-library/download.php',
			'hdflvplayer/download.php',
			'suspendedpage.cgi',
			'upload.asp',
			'uploadify/uploadify.php',
			'wp-config.php',
			'writeToFile.php',
			'wysija-newsletters/readme.txt',
			"administrator/",
			"auto-attachments/a-a.css",
			"category-grid-view-gallery/cat_grid.php",
			"cimy-user-extra-fields/README_OFFICIAL.txt",
			"ckeditor-for-wordpress/ckeditor.config.js",
			"connector.php",
			"contact-form-7/license.txt",
			"fcchat/default.png",
			"finder/browse.php",
			"font-uploader/font-uploader-free.php",
			"front-end-upload/destination.php",
			"gallery-plugin/gallery-plugin.php",
			"mac-dock-gallery/bugslist.txt",
			"magic-fields/MF_Constant.php",
			"newtype/",
			"nextgen-gallery/changelog.txt",
			"nmedia-user-file-uploader/readme.txt",
			"php/upload.php",
			"resume-submissions-job-postings/installer.php",
			"setup.exe",
			"uploader.ashx",
			"user-avatar/readme.txt",
			"user-meta/readme.txt",
			"user-photo/admin.css",
			"wp-e-commerce/license.txt",
			"wp-filemanager/fm.php",
			"wp-homepage-slideshow/functions.php",
			"wp-image-news-slider/functions.php",
			"wp-property/action_hooks.php",
			"wpmarketplace/readme.txt",
			"wpstorecart/lgpl.txt",
			"zingiri-web-shop/admin.css",
			'/system.php'
		);
		$sname = $this->getSname();
		// ss_cd_write_file( "debug.txt", "check 404 '$hit'" );
		foreach ( $expl as $bad ) {
			if ( stripos( $sname, $bad ) !== false ) {
				return __( '404 on Exploit Attempt: ' . $sname, $bad . '', 'stop-spammer-registrations-plugin' );
			} else {
			// echo "$sname, $bad<br>";
			}
		}
		return false;
	}
}

?>