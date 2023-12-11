<?php

if ( !defined( 'ABSPATH' ) ) {
	http_response_code( 404 );
	die();
}

class ss_get_options {
	public function process( $ip, &$stats = array(), &$options = array(), &$post = array() ) {
		include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		// Y/N options
		$options = get_option( 'ss_stop_sp_reg_options' );
		// Allow List Y/N options
		// not all Y/N options can be changed, but we need them for the load loops
		$defaultWL = array(
			'chkadminlog'	   	 => 'Y',
			'chkaws'		   	 => 'N',
			'chkcloudflare'	   	 => 'Y',
			'chkgcache'		   	 => 'Y',
			'chkgenallowlist'  	 => 'N',
			'chkgoogle'		   	 => 'Y',
			'chkmiscallowlist' 	 => 'Y',
			'chkpaypal'		   	 => 'Y',
			'chkform'		   	 => ( is_plugin_active( 'woocommerce/woocommerce.php' ) ) ? 'Y' : 'N',
			'ss_private_mode'  	 => 'N',
			'ss_keep_hidden_btn' => 'Y',
			'ss_hide_all_btn'    => 'Y',
			'chkscripts'	     => 'Y',
			'chkvalidip'	     => 'Y',
			'chkwlem'		     => 'Y',
			'chkwooform'         => 'N',
            'chkgvform'          => 'N',
			'chkwluserid'	     => 'N',
			'chkwlist'		     => 'Y',
			'chkwlistemail'	     => 'Y',
			'chkyahoomerchant'   => 'Y',
			'chkstripe'		     => 'Y',
			'chkauthorizenet'    => 'Y',
			'chkbraintree'	     => 'Y',
			'chkrecurly'	     => 'Y',
			'chksquare'			 => 'Y',
		    'new_user_notification_to_admin' => 'Y',
			'ss_new_user_notification_to_user'=> 'Y',
			'ss_password_change_notification_to_admin' => 'Y',
			'ss_send_password_forgotten_email' => 'Y',
			'ss_auto_core_update_send_email' => 'Y',
			'ss_auto_plugin_update_send_email' => 'Y',
		    'ss_auto_theme_update_send_email' => 'Y',
		    'ss_send_email_change_email' => 'Y',
			'ss_wp_notify_moderator' => 'Y',
			'ss_wp_notify_post_author' => 'Y',
	        'ss_password_change_notification_to_user' => 'Y'
		);
		// Block List Y/N settings
		$defaultBL = array(
			'chk404'		=> 'Y',
			'chkaccept'	    => 'Y',
			'chkadmin'	    => 'Y',
			'chkagent'	    => 'Y',
			'chkamazon'	    => 'N',
			'chkbcache'	    => 'Y',
			'chkblem'	    => 'Y',
			'chkbluserid'   => 'N',
			'chkblip'	    => 'Y',
			'chkbotscout'   => 'Y',
			'chkdisp'	    => 'Y',
			'chkdnsbl'	    => 'Y',
			'chkexploits'   => 'Y',
			'chkgooglesafe' => 'N',
			'chkhoney'	    => 'Y',
			'chkhosting'	=> 'Y',
			'chkinvalidip'  => 'Y',
			'chklong'	    => 'Y',
			'chkshort'	    => 'Y',
			'chkbbcode'	    => 'Y',
			'chkreferer'	=> 'Y',
			'chksession'	=> 'Y',
			'chksfs'		=> 'Y',
			'chkspamwords'  => 'Y',
			'chkurlshort'   => 'Y',
			'chkurls'       => 'Y',
			'chktld'		=> 'Y',
			'chkubiquity'   => 'Y',
			'chkakismet'	=> 'Y',
			'chkmulti'	    => 'Y',
			'chktor'	 	=> 'N',
			'chkperiods'	=> 'Y',
			'chkhyphens'	=> 'Y'
		);
		// control options that can be set - not checks
		$defaultsCTRL   = array(
			'chkemail'			  => 'Y',
			'chkip'			      => 'Y',
			'chkcomments'		  => 'Y',
			'chksignup'		      => 'Y',
			'chkxmlrpc'		      => 'Y',
			'chkwpmail'		      => 'Y',
			'addtoallowlist'	  => 'Y',
			'wlreqmail'		      => '',
			// email where the request go to
			'wlreq'			      => 'Y',
			// using this to see if we display the notify form
			'redir'			      => 'N',
			'chkcaptcha'		  => 'N',
			'chkxff'			  => 'N',
			'notify'			  => 'N',
			'emailrequest'	 	  => 'N',
			'chkspoof'			  => 'N',
			'filterregistrations' => 'Y'
			// filter registration attempts - even if not from post
		);
		$defaultARRAY = array(
			'badagents'  => array(
				"Abonti",
				"aggregator",
				"AhrefsBot",
				"asterias",
				"BDCbot",
				"BLEXBot",
				"BuiltBotTough",
				"Bullseye",
				"BunnySlippers",
				"ca-crawler",
				"CCBot",
				"Cegbfeieh",
				"CheeseBot",
				"CherryPicker",
				"CherryPickerElite",
				"CherryPickerSE",
				"CopyRightCheck",
				"cosmos",
				"Crescent Internet ToolPak",
				"Crescent",
				"discobot",
				"DittoSpyder",
				"DOC",
				"DotBot",
				"Download Ninja",
				"EasouSpider",
				"EmailCollector",
				"EmailSiphon",
				"EmailWolf",
				"EroCrawler",
				"Exabot",
				"ExtractorPro",
				"Fasterfox",
				"FeedBooster",
				"Foobot",
				"Genieo",
				"grub-client",
				"Harvest",
				"hloader",
				"httplib",
				"HTTrack",
				"humanlinks",
				"ieautodiscovery",
				"InfoNaviRobot",
				"IstellaBot",
				"Java/1.",
				"JennyBot",
				"k2spider",
				"Kenjin Spider",
				"Keyword Density/0.9",
				"larbin",
				"LexiBot",
				"libWeb",
				"libwww",
				"LinkextractorPro",
				"linko",
				"LinkScan/8.1a Unix",
				"LinkWalker",
				"LNSpiderguy",
				"lwp-trivial",
				"lwp-trivial",
				"magpie",
				"Mata Hari",
				'MaxPointCrawler',
				'MegaIndex',
				"Microsoft URL Control",
				"MIIxpc",
				"Mippin",
				"Missigua Locator",
				"Mister PiX",
				"MJ12bot",
				"moget",
				"MSIECrawler",
				"NetAnts",
				"NICErsPRO",
				"Niki-Bot",
				"NPBot",
				"Nutch",
				"Offline Explorer",
				"Openfind data gathere",
				"Openfind",
				'panscient.com',
				"PHP/5.{",
				"ProPowerBot/2.14",
				"ProWebWalker",
				"Python-urllib",
				"QueryN Metasearch",
				"RepoMonkey",
				"RepoMonkey",
				"RMA",
				'SemrushBot',
				"SeznamBot ",
				"SISTRIX",
				"sitecheck.Internetseer.com",
				"SiteSnagger",
				"SnapPreviewBot",
				"Sogou",
				"SpankBot",
				"spanner",
				"spbot",
				"Spinn3r",
				"suzuran",
				"Szukacz/1.4",
				"Teleport Pro/1.29",
				"Teleport",
				"TeleportPro",
				"Telesoft",
				"The Intraformant",
				"TheNomad",
				"TightTwatBot",
				"Titan",
				"toCrawl/UrlDispatcher",
				"True_Robot",
				"True_Robot/1.0",
				"turingos",
				"TurnitinBot",
				"UbiCrawler",
				"UnisterBot",
				"URLy Warning",
				"VCI WebViewer VCI WebViewer Win32",
				"VCI",
				"WBSearchBot",
				"Web Downloader/6.9",
				"Web Image Collector",
				"WebAuto",
				"WebBandit",
				"WebBandit/3.50",
				"WebCopier v4.0",
				"WebCopier",
				"WebEnhancer",
				"WebmasterWorldForumBot",
				"WebReaper",
				"WebSauger",
				"Website Quester",
				"Webster Pro",
				"WebStripper",
				"WebZip",
				"Wotbox",
				"wsr-agent",
				"WWW-Collector-E",
				"Xenu",
				"yandex",
				"Zao",
				"Zeus",
				"Zeus",
				"ZyBORG",
				'coccoc',
				'Incutio',
				'lmspider',
				'memoryBot',
				'SemrushBot',
				'serf',
				'Unknown',
				'uptime files'
			),
			'badTLDs'	  => array(),
			'blist'	      => array(),
			'payoptions'  => array(),
			'wlist'	      => array(),
			'wlist_email' => array(),
			'spamwords'   => array(
				'-online',
				'#1',
				'$$$',
				'100% free',
				'100% more',
				'100% satisfied',
				'4-u',
				'4u',
				'Accept credit cards',
				'Act now',
				'Ad',
				'Additional income',
				'additional-income',
				'adipex',
				'advicer',
				'air max',
				'All new',
				'allstate',
				'ambien',
				'Apply now',
				'As seen on',
				'baccarrat',
				'BackPage Ads Posting',
				'BackPage Posting',
				'barbour northumbria',
				'Bargain',
				'Be your own boss',
				'Become a member',
				'Beneficiary',
				'Best price',
				'Big bucks',
				'Billing',
				'bingo',
				'blackjack',
				'bllogspot',
				'Bonus',
				'booker',
				'Bulk email',
				'Buy direct',
				'byob',
				'Call now',
				'Cancel at any time',
				'car-rental-e-site',
				'car-rentals-e-site',
				'Cards accepted',
				'carisoprodol',
				'Cash bonus',
				'Cash',
				'casino',
				'Cents on the dollar',
				'Certified',
				'chatroom',
				'Cheap',
				'Check or money order',
				'cialis',
				'Claims',
				'Clearance',
				'Click below',
				'Click here',
				'Collect your prize',
				'Compare rates',
				'Confidentiality',
				'Congratulations',
				'Consolidate debt',
				'coolhu',
				'CraigsList Ads Posting',
				'Credit card offers',
				'credit-card-debt',
				'credit-report',
				'Cures baldness',
				'Cures',
				'cwas',
				'cyclen',
				'cyclobenzaprine',
				'dating-e-site',
				'day-trading',
				'Deal',
				'Dear friend',
				'Dear Friend',
				'debt-consolidation',
				'Debt',
				'Direct email',
				'Direct marketing',
				'Discount',
				'discreetordering',
				'Do it today',
				'Don’t delete',
				'Double your cash',
				'Double your income',
				'duty-free',
				'dutyfree',
				'Earn extra cash',
				'Earn money',
				'Easy date',
				'Eliminate bad credit',
				'Email harvest',
				'email-marketing',
				'equityloans',
				'Exclusive deal',
				'Expect to earn',
				'Extra cash',
				'Extra income',
				'extra-income',
				'Fantastic',
				'Fast cash',
				'fast-cash',
				'Financial freedom',
				'Financial Schemes',
				'fioricet',
				'flowers-leading-site',
				'Free access',
				'Free consultation',
				'Free gift card',
				'Free gift',
				'Free hosting',
				'Free info',
				'Free investment',
				'Free membership',
				'Free money',
				'Free preview',
				'Free quote',
				'Free trial',
				'freenet-shopping',
				'freenet',
				'Full refund',
				'gambling-',
				'Get it now',
				'Get out of debt',
				'Get paid',
				'Get started now',
				'Giveaway',
				'Guaranteed',
				'hair-loss',
				'health-insurancedeals',
				'Hidden charges',
				'holdem',
				'Home based business',
				'Home based',
				'home security systems',
				'home-based',
				'homebased',
				'homeequityloans',
				'homefinance',
				'Hot men',
				'Hot women',
				'hotel-dealse-site',
				'hotele-site',
				'hotelse-site',
				'Human growth hormone',
				'Important information regarding',
				'In accordance with laws',
				'incest',
				'Income from home',
				'Income',
				'Increase sales',
				'Increase sales',
				'Increase traffic',
				'Increase traffic',
				'Incredible deal',
				'Information you requested',
				'Instant',
				'insurance-quotes',
				'insurancedeals',
				'insurnce',
				'Internet marketing',
				'Investment',
				'Join millions',
				'jrcreations',
				'Lead generation',
				'levitra',
				'Lifetime',
				'Limited time',
				'Loans',
				'Lose weight',
				'Lower rates',
				'Lowest price',
				'Luxury',
				'macinstruct',
				'Make $',
				'Make money',
				'Marketing solution',
				'Marketing solutions',
				'Mass email',
				'Meet singles',
				'Message contains',
				'Million dollars',
				'Miracle',
				'Money back',
				'Month trial offer',
				'Mortgage rates',
				'Mortgage',
				'mortgagequotes',
				'Multi-level marketing',
				'Name brand',
				'New customers only',
				'nike',
				'No catch',
				'No cost',
				'No credit check',
				'No fees',
				'No gimmick',
				'No hidden costs',
				'No hidden fees',
				'No interest',
				'No investment',
				'No obligation',
				'No purchase necessary',
				'No questions asked',
				'No strings attached',
				'Not junk',
				'Notspam',
				'Obligation',
				'Offer',
				'Once in a lifetime',
				'One hundred percent free',
				'One time',
				'Online biz opportunity',
				'Online degree',
				'Online marketing',
				'Online pharmacy',
				'online-gambling',
				'onlinegambling',
				'Opportunity',
				'Opt in',
				'Order now',
				'ottawavalleyag',
				'ownsthis',
				'Passwords',
				'paxil',
				'penis',
				'Pennies a day',
				'Perform in bed',
				'pharmacy',
				'phentermine',
				'Please read',
				'poker-chip',
				'poker',
				'Potential earnings',
				'poze',
				'Pre-approved',
				'Prize',
				'Promise',
				'Pure profit',
				'pussy',
				'Quote',
				'Rates',
				'real money',
				'Refinance',
				'Removal',
				'Removes wrinkles',
				'rental-car-e-site',
				'Requires initial investment',
				'Reserves the right',
				'Reverses aging',
				'ringtones',
				'Risk-free',
				'roulette',
				'Satisfaction guaranteed',
				'Save big money',
				'Save up to',
				'Score tonight',
				'Score',
				'Search Engine Optimization',
				'Search engine',
				'See for yourself',
				'Sent in compliance',
				'seo-',
				'shemale',
				'Shox',
				'sibutramine',
				'Sign up free',
				'Sign-up free today',
				'slot-machine',
				'Social security number',
				'Social Security Number',
				'Special promotion',
				'Stock alert',
				'Stop snoring',
				'Subject to…',
				'Take action',
				'Terms and conditions',
				'This isn’t a scam',
				'This isn’t junk',
				'This isn’t spam',
				'This won’t last',
				'thorcarlson',
				'top-e-site',
				'top-site',
				'tramadol',
				'Trial',
				'trim-spa',
				'ultram',
				'Undisclosed',
				'University diplomas',
				'Unlimited',
				'Unsecured credit',
				'Unsecured debt',
				'Unsolicited',
				'Urgent proposal',
				'Urgent',
				'valeofglamorganconservatives',
				'Valium',
				'viagra',
				'Viagra',
				'Vicodin',
				'vioxx',
				'Warranty',
				'We hate spam',
				'Web traffic',
				'Weight loss',
				'weight-loss',
				'weightloss',
				'What are you waiting for?',
				'While supplies last',
				'Will not believe your eyes',
				'Winner',
				'Winning',
				'Work from home',
				'work-at-home',
				'workathome',
				'xanax',
				'Xanax',
				'You are a winner',
				'You have been selected',
				'You’re a winner',
				'zolus'
			),
			'blockurlshortners' => array(
				'0rz.tw',
				'1-url.net',
				'126.am',
				'1link.in',
				'1tk.us',
				'1un.fr',
				'1url.com',
				'1url.cz',
				'1wb2.net',
				'2.gp',
				'2.ht',
				'23o.net',
				'2ad.in',
				'2big.at',
				'2doc.net',
				'2fear.com',
				'2pl.us',
				'2tu.us',
				'2ty.in',
				'2u.xf.cz',
				'2ya.com',
				'3ra.be',
				'3x.si',
				'4i.ae',
				'4url.cc',
				'4view.me',
				'5em.cz',
				'5url.net',
				'5z8.info',
				'6fr.ru',
				'6g6.eu',
				'6url.com',
				'7.ly',
				'76.gd',
				'77.ai',
				'7fth.cc',
				'7li.in',
				'7vd.cn',
				'8u.cz',
				'944.la',
				'98.to',
				'AltURL.com',
				'BudURL.com',
				'Buff.ly',
				'BurnURL.com',
				'C-O.IN',
				'ClickMeter.com',
				'DecentURL.com',
				'DigBig.com',
				'Digg.com',
				'DwarfURL.com',
				'EasyURI.com',
				'EasyURL.net',
				'EsyURL.com',
				'Fhurl.com',
				'Fly2.ws',
				'GoWat.ch',
				'Hurl.it',
				'IsCool.net',
				'Just.as',
				'L9.fr',
				'Lvvk.com',
				'MyURL.in',
				'PiURL.com',
				'Profile.to',
				'QLNK.net',
				'Quip-Art.com',
				'RedirX.com',
				'Sharein.com',
				'ShortLinks.co.uk',
				'Shrinkify.com',
				'SimURL.com',
				'StartURL.com',
				'TightURL.com',
				'Tnij.org',
				'To8.cc',
				'TraceURL.com',
				'URL.ie',
				'URLHawk.com',
				'WapURL.co.uk',
				'XeeURL.com',
				'Yep.it',
				'a.co',
				'a.gg',
				'a.nf',
				'a0.fr',
				'a2a.me',
				'abbr.sk',
				'abbrr.com',
				'ad-med.cz',
				'ad5.eu',
				'ad7.biz',
				'adb.ug',
				'adf.ly',
				'adfa.st',
				'adfly.fr',
				'adfoc.us',
				'adjix.com',
				'adli.pw',
				'admy.link',
				'adv.li',
				'ajn.me',
				'aka.gr',
				'al.ly',
				'alil.in',
				'any.gs',
				'aqva.pl',
				'ares.tl',
				'asso.in',
				'atu.ca',
				'au.ms',
				'ayt.fr',
				'azali.fr',
				'b00.fr',
				'b23.ru',
				'b54.in',
				'bacn.me',
				'baid.us',
				'bc.vc',
				'bee4.biz',
				'bim.im',
				'bit.do',
				'bit.ly',
				'bitly.com',
				'bitw.in',
				'bkite.com',
				'blap.net',
				'ble.pl',
				'blip.tv',
				'bloat.me',
				'boi.re',
				'bote.me',
				'bougn.at',
				'br4.in',
				'brk.to',
				'brzu.net',
				'budurl.com',
				'buk.me',
				'bul.lu',
				'bxl.me',
				'bzh.me',
				'cachor.ro',
				'captur.in',
				'catchylink.com',
				'cbs.so',
				'cbug.cc',
				'cc.cc',
				'ccj.im',
				'cf.ly',
				'cf2.me',
				'cf6.co',
				'chilp.it',
				'cjb.net',
				'clck.ru',
				'cli.gs',
				'clikk.in',
				'cn86.org',
				'coinurl.com',
				'cort.as',
				'couic.fr',
				'cr.tl',
				'cudder.it',
				'cur.lv',
				'curl.im',
				'cut.pe',
				'cut.sk',
				'cutt.eu',
				'cutt.us',
				'cutu.me',
				'cuturl.com',
				'cybr.fr',
				'cyonix.to',
				'd75.eu',
				'daa.pl',
				'dai.ly',
				'dd.ma',
				'ddp.net',
				'decenturl.com',
				'dfl8.me',
				'dft.ba',
				'doiop.com',
				'dolp.cc',
				'dopice.sk',
				'droid.ws',
				'dv.gd',
				'dy.fi',
				'dyo.gs',
				'e37.eu',
				'ecra.se',
				'eepurl.com',
				'ely.re',
				'erax.cz',
				'erw.cz',
				'ewerl.com',
				'ex9.co',
				'ezurl.cc',
				'fa.b',
				'ff.im',
				'fff.re',
				'fff.to',
				'fff.wf',
				'filz.fr',
				'fire.to',
				'firsturl.de',
				'flic.kr',
				'fly2.ws',
				'fnk.es',
				'foe.hn',
				'folu.me',
				'fon.gs',
				'freze.it',
				'fur.ly',
				'fwd4.me',
				'g00.me',
				'gg.gg',
				'git.io',
				'gl.am',
				'go.9nl.com',
				'go2.me',
				'go2cut.com',
				'goo.gl',
				'goo.lu',
				'good.ly',
				'goshrink.com',
				'grem.io',
				'gri.ms',
				'guiama.is',
				'gurl.es',
				'hadej.co',
				'hec.su',
				'hellotxt.com',
				'hex.io',
				'hide.my',
				'hjkl.fr',
				'hops.me',
				'hover.com',
				'href.in',
				'href.li',
				'ht.ly',
				'htxt.it',
				'hugeurl.com',
				'hurl.me',
				'hurl.ws',
				'i-2.co',
				'i99.cz',
				'icanhaz.com',
				'icit.fr',
				'ick.li',
				'icks.ro',
				'idek.net',
				'iiiii.in',
				'iky.fr',
				'ilix.in',
				'info.ms',
				'inreply.to',
				'is.gd',
				'isra.li',
				'iterasi.net',
				'itm.im',
				'ity.im',
				'ix.sk',
				'j.gs',
				'j.mp',
				'jdem.cz',
				'jieb.be',
				'jijr.com',
				'jmp2.net',
				'jp22.net',
				'jqw.de',
				'kask.us',
				'kd2.org',
				'kfd.pl',
				'kissa.be',
				'kl.am',
				'klck.me',
				'korta.nu',
				'kr3w.de',
				'krat.si',
				'kratsi.cz',
				'krod.cz',
				'krunchd.com',
				'kuc.cz',
				'kxb.me',
				'l-k.be',
				'l.gg',
				'lc-s.co',
				'lc.cx',
				'lcut.in',
				'letop10.',
				'libero.it',
				'lick.my',
				'lien.li',
				'lien.pl',
				'liip.to',
				'liltext.com',
				'lin.cr',
				'lin.io',
				'linkbee.com',
				'linkbun.ch',
				'linkn.co',
				'liurl.cn',
				'llu.ch',
				'ln-s.net',
				'ln-s.ru',
				'lnk.co',
				'lnk.gd',
				'lnk.in',
				'lnk.ly',
				'lnk.sk',
				'lnked.in',
				'lnks.fr',
				'lnky.fr',
				'lnp.sn',
				'loopt.us',
				'lp25.fr',
				'lru.jp',
				'lt.tl',
				'lurl.no',
				'lynk.my',
				'm1p.fr',
				'm3mi.com',
				'make.my',
				'mcaf.ee',
				'mdl29.net',
				'metamark.net',
				'mic.fr',
				'migre.me',
				'minilien.com',
				'miniurl.com',
				'minu.me',
				'minurl.fr',
				'moourl.com',
				'more.sh',
				'mut.lu',
				'myurl.in',
				'ne1.net',
				'net.ms',
				'net46.net',
				'nicou.ch',
				'nig.gr',
				'njx.me',
				'nn.nf',
				'notlong.com',
				'nov.io',
				'nq.st',
				'nsfw.in',
				'nxy.in',
				'o-x.fr',
				'okok.fr',
				'om.ly',
				'ou.af',
				'ou.gd',
				'oua.be',
				'ouo.io',
				'ow.ly',
				'p.pw',
				'para.pt',
				'parky.tv',
				'past.is',
				'pd.am',
				'pdh.co',
				'ph.dog',
				'ph.ly',
				'pic.gd',
				'pich.in',
				'pin.st',
				'ping.fm',
				'plots.fr',
				'pm.wu.cz',
				'pnt.me',
				'po.st',
				'poprl.com',
				'post.ly',
				'posted.at',
				'ppfr.it',
				'ppst.me',
				'ppt.cc',
				'ppt.li',
				'prejit.cz',
				'ptab.it',
				'ptm.ro',
				'pw2.ro',
				'py6.ru',
				'q.gs',
				'qbn.ru',
				'qicute.com',
				'qqc.co',
				'qr.net',
				'qrtag.fr',
				'qxp.cz',
				'qxp.sk',
				'rb6.co',
				'rb6.me',
				'rcknr.io',
				'rdz.me',
				'redir.ec',
				'redir.fr',
				'redu.it',
				'ref.so',
				'reise.lc',
				'relink.fr',
				'ri.ms',
				'rickroll.it',
				'riz.cz',
				'riz.gd',
				'rod.gs',
				'roflc.at',
				'rsmonkey.com',
				'rt.se',
				'rt.tc',
				'ru.ly',
				'rubyurl.com',
				's-url.fr',
				's.id',
				's7y.us',
				'safe.mn',
				'sagyap.tk',
				'sdu.sk',
				'seeme.at',
				'segue.se',
				'sh.st',
				'shar.as',
				'sharetabs.com',
				'shorl.com',
				'short.cc',
				'short.ie',
				'short.nr',
				'short.pk',
				'short.to',
				'shorte.st',
				'shortna.me',
				'shorturl.com',
				'shoturl.us',
				'shrinkee.com',
				'shrinkster.com',
				'shrinkurl.in',
				'shrt.in',
				'shrt.st',
				'shrten.com',
				'shrunkin.com',
				'shw.me',
				'shy.si',
				'sicax.net',
				'sina.lt',
				'sk.gy',
				'skr.sk',
				'skroc.pl',
				'smll.co',
				'sn.im',
				'sn.vc',
				'snipr.com',
				'snipurl.com',
				'snsw.us',
				'snurl.com',
				'soo.gd',
				'sp2.ro',
				'spedr.com',
				'spn.sr',
				'sptfy.com',
				'sq6.ru',
				'sqrl.it',
				'ssl.gs',
				'sturly.com',
				'su.pr',
				'surl.me',
				'sux.cz',
				'sy.pe',
				't.cn',
				't.co',
				'ta.gd',
				'tabzi.com',
				'tau.pe',
				'tcrn.ch',
				'tdjt.cz',
				'thesa.us',
				'thinfi.com',
				'thrdl.es',
				'tin.li',
				'tini.cc',
				'tiny.cc',
				'tiny.lt',
				'tiny.ms',
				'tiny.pl',
				'tiny123.com',
				'tinyarro.ws',
				'tinytw.it',
				'tinyuri.ca',
				'tinyurl.com',
				'tinyurl.hu',
				'tinyvid.io',
				'tixsu.com',
				'tldr.sk',
				'tldrify.com',
				'tllg.net',
				'tnij.org',
				'tny.cz',
				'tny.im',
				'to.ly',
				'togoto.us',
				'tohle.de',
				'tpmr.com',
				'tr.im',
				'tr.my',
				'tr5.in',
				'trck.me',
				'trick.ly',
				'trkr.ws',
				'trunc.it',
				'turo.us',
				'tweetburner.com',
				'twet.fr',
				'twi.im',
				'twirl.at',
				'twit.ac',
				'twitterpan.com',
				'twitthis.com',
				'twiturl.de',
				'twlr.me',
				'twurl.cc',
				'twurl.nl',
				'u.mavrev.com',
				'u.nu',
				'u.to',
				'u6e.de',
				'ub0.cc',
				'uby.es',
				'ucam.me',
				'ug.cz',
				'ulmt.in',
				'unlc.us',
				'updating.me',
				'upzat.com',
				'ur1.ca',
				'url.co.uk',
				'url2.fr',
				'url4.eu',
				'url5.org',
				'urlao.com',
				'urlbrief.com',
				'urlcover.com',
				'urlcut.com',
				'urlenco.de',
				'urlin.it',
				'urlkiss.com',
				'urlkr.com',
				'urlot.com',
				'urlpire.com',
				'urls.fr',
				'urlx.ie',
				'urlx.org',
				'urlz.fr',
				'urlzen.com',
				'urub.us',
				'utfg.sk',
				'v.gd',
				'v.ht',
				'v5.gd',
				'vaaa.fr',
				'valv.im',
				'vaza.me',
				'vbly.us',
				'vd55.com',
				'verd.in',
				'vgn.me',
				'virl.com',
				'vl.am',
				'vov.li',
				'vsll.eu',
				'vt802.us',
				'vur.me',
				'vv.vg',
				'w1p.fr',
				'w3t.org',
				'waa.ai',
				'wb1.eu',
				'web99.eu',
				'wed.li',
				'wideo.fr',
				'wipi.es',
				'wp.me',
				'wtc.la',
				'wu.cz',
				'ww7.fr',
				'wwy.me',
				'x.co',
				'x.nu',
				'x.se',
				'x10.mx',
				'x2c.eu',
				'x2c.eumx',
				'xaddr.com',
				'xav.cc',
				'xgd.in',
				'xib.me',
				'xl8.eu',
				'xoe.cz',
				'xr.com',
				'xrl.in',
				'xrl.us',
				'xt3.me',
				'xua.me',
				'xub.me',
				'xurl.jp',
				'xurls.co',
				'xzb.cc',
				'y2u.be',
				'yagoa.fr',
				'yagoa.me',
				'yau.sh',
				'yeca.eu',
				'yect.com',
				'yep.it',
				'yfrog.com',
				'yogh.me',
				'yon.ir',
				'youfap.me',
				'ysear.ch',
				'yweb.com',
				'yyv.co',
				'z9.fr',
				'zSMS.net',
				'zapit.nu',
				'zeek.ir',
				'zi.ma',
				'zi.pe',
				'zip.net',
				'zipmyurl.com',
				'zkr.cz',
				'zkrat.me',
				'zkrt.cz',
				'zoodl.com',
				'zpag.es',
				'zti.me',
				'zxq.net',
				'zyva.org',
				'zz.gd',
				'zzb.bz'
			)
		);
		$defaultSVC = array(
			'apikey'				 => '',
			'honeyapi'			     => '',
			'botscoutapi'			 => '',
			'googleapi'			     => '',
			'recaptchaapisecret'	 => '',
			'recaptchaapisite'	     => '',
			'hcaptchaapisecret'		 => '',
			'hcaptchaapisite'	     => '',
			'solvmediaapivchallenge' => '',
			'solvmediaapiverify'	 => '',
			'blogseyekey'			 => '',
			'sesstime'			     => 4,
			'sfsfreq'				 => 0,
			'hnyage'				 => 9999,
			'botfreq'				 => 0,
			'sfsage'				 => 9999,
			'hnylevel'			     => 5,
			'botage'				 => 9999,
			'multicnt'			     => 5,
			'multitime'			     => 3
		);
		$force	  = true;
		$defaults = array(
			'version'		 => SS_VERSION,
			'ss_sp_cache'	 => 25,
			'ss_sp_hist'	 => 25,
			'ss_sp_good'	 => 2,
			'ss_sp_cache_em' => 4,
			'redirurl'	     => '',
			'logfilesize'	 => 0,
			'rejectmessage'  => "Access Blocked<br>"
		);
		$defaultCOUNTRY = array( // all yes - changed to no
			'chkAD' => 'N',
			'chkAE' => 'N',
			'chkAF' => 'N',
			'chkAL' => 'N',
			'chkAM' => 'N',
			'chkAR' => 'N',
			'chkAT' => 'N',
			'chkAU' => 'N',
			'chkAX' => 'N',
			'chkAZ' => 'N',
			'chkBA' => 'N',
			'chkBB' => 'N',
			'chkBD' => 'N',
			'chkBE' => 'N',
			'chkBG' => 'N',
			'chkBH' => 'N',
			'chkBN' => 'N',
			'chkBO' => 'N',
			'chkBR' => 'N',
			'chkBS' => 'N',
			'chkBY' => 'N',
			'chkBZ' => 'N',
			'chkCA' => 'N',
			'chkCD' => 'N',
			'chkCH' => 'N',
			'chkCL' => 'N',
			'chkCN' => 'N',
			'chkCO' => 'N',
			'chkCR' => 'N',
			'chkCU' => 'N',
			'chkCW' => 'N',
			'chkCY' => 'N',
			'chkCZ' => 'N',
			'chkDE' => 'N',
			'chkDK' => 'N',
			'chkDO' => 'N',
			'chkDZ' => 'N',
			'chkEC' => 'N',
			'chkEE' => 'N',
			'chkES' => 'N',
			'chkEU' => 'N',
			'chkFI' => 'N',
			'chkFJ' => 'N',
			'chkFR' => 'N',
			'chkGB' => 'N',
			'chkGE' => 'N',
			'chkGF' => 'N',
			'chkGI' => 'N',
			'chkGP' => 'N',
			'chkGR' => 'N',
			'chkGT' => 'N',
			'chkGU' => 'N',
			'chkGY' => 'N',
			'chkHK' => 'N',
			'chkHN' => 'N',
			'chkHR' => 'N',
			'chkHT' => 'N',
			'chkHU' => 'N',
			'chkID' => 'N',
			'chkIE' => 'N',
			'chkIL' => 'N',
			'chkIN' => 'N',
			'chkIQ' => 'N',
			'chkIR' => 'N',
			'chkIS' => 'N',
			'chkIT' => 'N',
			'chkJM' => 'N',
			'chkJO' => 'N',
			'chkJP' => 'N',
			'chkKE' => 'N',
			'chkKG' => 'N',
			'chkKH' => 'N',
			'chkKR' => 'N',
			'chkKW' => 'N',
			'chkKY' => 'N',
			'chkKZ' => 'N',
			'chkLA' => 'N',
			'chkLB' => 'N',
			'chkLK' => 'N',
			'chkLT' => 'N',
			'chkLU' => 'N',
			'chkLV' => 'N',
			'chkMD' => 'N',
			'chkME' => 'N',
			'chkMK' => 'N',
			'chkMM' => 'N',
			'chkMN' => 'N',
			'chkMO' => 'N',
			'chkMP' => 'N',
			'chkMQ' => 'N',
			'chkMT' => 'N',
			'chkMV' => 'N',
			'chkMX' => 'N',
			'chkMY' => 'N',
			'chkNC' => 'N',
			'chkNI' => 'N',
			'chkNL' => 'N',
			'chkNO' => 'N',
			'chkNP' => 'N',
			'chkNZ' => 'N',
			'chkOM' => 'N',
			'chkPA' => 'N',
			'chkPE' => 'N',
			'chkPG' => 'N',
			'chkPH' => 'N',
			'chkPK' => 'N',
			'chkPL' => 'N',
			'chkPR' => 'N',
			'chkPS' => 'N',
			'chkPT' => 'N',
			'chkPW' => 'N',
			'chkPY' => 'N',
			'chkQA' => 'N',
			'chkRO' => 'N',
			'chkRS' => 'N',
			'chkRU' => 'N',
			'chkSA' => 'N',
			'chkSC' => 'N',
			'chkSE' => 'N',
			'chkSG' => 'N',
			'chkSI' => 'N',
			'chkSK' => 'N',
			'chkSV' => 'N',
			'chkSX' => 'N',
			'chkSY' => 'N',
			'chkTH' => 'N',
			'chkTJ' => 'N',
			'chkTM' => 'N',
			'chkTR' => 'N',
			'chkTT' => 'N',
			'chkTW' => 'N',
			'chkUA' => 'N',
			'chkUK' => 'N',
			'chkUS' => 'N',
			'chkUY' => 'N',
			'chkUZ' => 'N',
			'chkVC' => 'N',
			'chkVE' => 'N',
			'chkVN' => 'N',
			'chkYE' => 'N'
		);
		$ansa = array_merge( $defaultWL, $defaultsCTRL, $defaultBL, $defaultARRAY, $defaultSVC, $defaultCOUNTRY, $defaults );
		// to keep from getting option creep we then set the options from opts back into the ansa
		// had to do this to get rid of obsolete or mistaken options
		if ( empty( $options ) || !is_array( $options ) ) {
			$options = array();
		}
		foreach ( $options as $key => $val ) {
			if ( array_key_exists( $key, $ansa ) ) {
				$ansa[$key] = $options[$key];
			} else {
			// sfs_debug_msg( "option $key missing from $options" );
			}
		}
		$ansa['version'] = SS_VERSION;
		// check the numeric varables for numericness - user can enter anything
		if ( !is_numeric( $ansa['botage'] ) ) {
			$ansa['botage'] = 9999;
		}
		if ( !is_numeric( $ansa['botfreq'] ) ) {
			$ansa['botfreq'] = 0;
		}
		if ( !is_numeric( $ansa['hnyage'] ) ) {
			$ansa['hnyage'] = 9999;
		}
		if ( !is_numeric( $ansa['hnylevel'] ) ) {
			$ansa['hnylevel'] = 5;
		}
		if ( !is_numeric( $ansa['ss_sp_cache'] ) ) {
			$ansa['ss_sp_cache'] = 25;
		}
		if ( !is_numeric( $ansa['ss_sp_cache_em'] ) ) {
			$ansa['ss_sp_cache_em'] = 10;
		}
		if ( !is_numeric( $ansa['ss_sp_good'] ) ) {
			$ansa['ss_sp_good'] = 2;
		}
		if ( !is_numeric( $ansa['ss_sp_hist'] ) ) {
			$ansa['ss_sp_hist'] = 25;
		}
		if ( !is_numeric( $ansa['sesstime'] ) ) {
			$ansa['sesstime'] = 4;
		}
		if ( !is_numeric( $ansa['sfsage'] ) ) {
			$ansa['sfsage'] = 9999;
		}
		if ( !is_numeric( $ansa['sfsfreq'] ) ) {
			$ansa['sfsfreq'] = 0;
		}
		if ( !is_numeric( $ansa['ss_sp_good'] ) ) {
			$ansa['ss_sp_good'] = 0;
		}
		if ( !is_numeric( trim( $ansa['logfilesize'] ) ) ) {
			$ansa['logfilesize'] = 0;
		}
		$ansa['chkcloudflare'] = 'Y'; // force it true for now
		ss_set_options( $ansa ); // new version, need to set the new options
		// sfs_debug_msg( "in get options\r\n" . print_r( $ansa, true ) );
		return $ansa;
	}
}

?>