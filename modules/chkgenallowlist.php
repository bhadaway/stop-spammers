<?php
/****************************
 * These are IP addresses that have sent me spam, but they are from residential ISPs and any spam is usually fixed in a day or so.
 * These IP ranges produce spam, so whitelisting them will allow spam into your site.
 * The upside is that you will never block a legitimate customer.
 * This is a trade off. I don't use this, but I have zero spam tolerance.
 *****************************/

if ( !defined( 'ABSPATH' ) ) {
	http_response_code( 404 );
	die();
}

class chkgenallowlist extends be_module {
	public $searchname = 'Generated Allow List';
	public $searchlist = array(
		array( '1.120.0.0', '1.127.255.255' ),
		// # Telstra AU
		array( '1.128.0.0', '1.159.255.255' ),
		// # 001136097032 Telstra AU
		array( '2.33.0.0', '2.33.255.255' ),
		// # IP addresses assigned to DSL cus... IT
		array( '2.34.0.0', '2.35.255.255' ),
		// # IP addresses assigned to VF DSL ... IT
		array( '2.36.0.0', '2.39.255.255' ),
		// # Statically IP addresses assigned... IT
		array( '2.40.0.0', '2.40.255.255' ),
		// # IP addresses assigned to DSL cus... IT
		array( '2.112.0.0', '2.113.255.255' ),
		// # Telecom Italia S.p.a. IT
		array( '2.118.0.0', '2.119.255.255' ),
		// # Telecom Italia SPA IT
		array( '2.192.0.0', '2.192.255.255' ),
		// # Telecom Italia Mobile IT
		array( '2.193.0.0', '2.193.255.255' ),
		// # Telecom Italia Mobile IT
		array( '2.194.0.0', '2.194.255.255' ),
		// # Telecom Italia Mobile IT
		array( '2.195.0.0', '2.195.255.255' ),
		// # Telecom Italia Mobile IT
		array( '2.196.0.0', '2.196.255.255' ),
		// # Telecom Italia Mobile IT
		array( '2.198.0.0', '2.198.255.255' ),
		// # Telecom Italia Mobile IT
		array( '2.200.0.0', '2.207.255.255' ),
		// # Vodafone D2 GmbH DE
		array( '2.224.0.0', '2.231.255.255' ),
		// # PAT/NAT IP addresses POP 2301 for IT
		array( '2.232.0.0', '2.239.255.255' ),
		// # PAT/NAT IP addresses POP 3901 for IT
		array( '2.248.0.0', '2.255.255.255' ),
		// # 002248011043 Telia Network Services SE
		array( '5.86.0.0', '5.86.255.255' ),
		// # H3G S.p.A. IT
		array( '5.88.0.0', '5.95.255.255' ),
		// # 005090002240 IP range assigned to VF-IT customers IT
		array( '5.96.0.0', '5.97.255.255' ),
		// # Telecom Italia S.p.a. IT
		array( '5.133.176.0', '5.133.183.255' ),
		// # 005133179243 Sphere LTD GB
		array( '5.141.216.0', '5.141.216.255' ),
		// # Dynamic distribution IP's for br... RU
		array( '5.168.0.0', '5.171.255.255' ),
		// # 005170169026 TIM IT
		array( '5.172.224.0', '5.172.255.255' ),
		// # 005172252248 Polkomtel sp. z o.o. PL
		array( '11.0.0.0', '11.255.255.255' ),
		// # DoD Network Information Center US
		array( '12.0.0.0', '12.255.255.255' ),
		// # AT&T Services, Inc. ATT (NET-12-... US
		array( '14.2.0.0', '14.2.255.255' ),
		// # iiNet Limited AU
		array( '14.200.0.0', '14.203.255.255' ),
		// # TPG Internet Pty Ltd. AU
		array( '17.0.0.0', '17.255.255.255' ),
		// # Apple Inc. US
		array( '18.0.0.0', '18.255.255.255' ),
		// # Massachusetts Institute of Techn... US
		array( '23.20.0.0', '23.23.255.255' ),
		// # Amazon.com, Inc. US
		array( '23.24.0.0', '23.25.255.255' ),
		// # Comcast Business Communications,... US
		array( '23.30.96.0', '23.30.127.255' ),
		// # Comcast Business Communications,... US
		array( '23.30.128.0', '23.30.191.255' ),
		// # Comcast Business Communications,... US
		array( '23.30.224.88', '23.30.224.95' ),
		// # YALE MECHANICAL YALEMECHANICAL (... US
		array( '23.31.0.0', '23.31.63.255' ),
		// # Comcast Business Communications,... US
		array( '23.31.112.0', '23.31.119.255' ),
		// # 023031114033 Comcast Business Communications, LLC CBC-ALBUQUERQUE-16 (NET-23-31-112-0-1) US
		array( '23.31.192.0', '23.31.223.255' ),
		// # Comcast Business Communications,... US
		array( '23.31.224.0', '23.31.239.255' ),
		// # Comcast Business Communications,... US
		array( '23.91.224.0', '23.91.255.255' ),
		// # DISTRIBUTEL COMMUNICATIONS LTD. ... US
		array( '23.96.0.0', '23.103.255.255' ),
		// # Microsoft Corporation US
		array( '23.112.0.0', '23.127.255.255' ),
		// # AT&T Internet Services US
		array( '23.233.0.0', '23.233.127.255' ),
		// # 023233065157 TekSavvy Solutions Inc. CA
		array( '23.233.128.0', '23.233.255.255' ),
		// # Le Groupe Videotron Ltee VL-31BL... US
		array( '23.236.48.0', '23.236.63.255' ),
		// # Google Inc. US
		array( '23.240.0.0', '23.243.255.255' ),
		// # Time Warner Cable Internet LLC US
		array( '23.251.128.0', '23.251.159.255' ),
		// # Google Inc. US
		array( '23.255.128.0', '23.255.255.255' ),
		// # Google Fiber Inc. GOOGLE-FIBER (... US
		array( '24.0.0.0', '24.15.255.255' ),
		// # Comcast Cable Communications, Inc. US
		array( '24.16.0.0', '24.19.255.255' ),
		// # Comcast Cable Communications WAS... US
		array( '24.20.0.0', '24.21.255.255' ),
		// # Comcast Cable Communications ORE... US
		array( '24.24.0.0', '24.27.255.255' ),
		// # Time Warner Cable Internet LLC US
		array( '24.28.0.0', '24.29.255.255' ),
		// # Time Warner Cable Internet LLC US
		array( '24.30.224.0', '24.30.255.255' ),
		// # Time Warner Cable Internet LLC US
		array( '24.34.0.0', '24.34.255.255' ),
		// # 024034080162 Comcast Cable Communications Holdings, Inc CCCH3-8 (NET-24-34-0-0-1) US
		array( '24.35.128.0', '24.35.255.255' ),
		// # Cobridge Communications LLC COBR... US
		array( '24.36.144.0', '24.36.159.255' ),
		// # 024036151195 Cogeco Cable Canada Inc. CGOC-HALA-CPE10 (NET-24-36-144-0-1) US
		array( '24.36.224.0', '24.36.239.255' ),
		// # Cogeco Cable Canada Inc. CGOC-HA... US
		array( '24.38.0.0', '24.38.127.255' ),
		// # Cablevision Systems Corp. CVNET-... US
		array( '24.38.192.0', '24.38.255.255' ),
		// # Optimum Online NETBLK-OOL-10BLK ... US
		array( '24.39.0.0', '24.39.255.255' ),
		// # Time Warner Cable Internet LLC US
		array( '24.43.0.0', '24.43.255.255' ),
		// # Time Warner Cable Internet LLC US
		array( '24.44.0.0', '24.47.255.255' ),
		// # Optimum Online NETBLK-OOL-3BLK (... US
		array( '24.44.128.0', '24.44.131.255' ),
		// # Optimum Online (Cablevision Syst... US
		array( '24.47.44.0', '24.47.47.255' ),
		// # Optimum Online (Cablevision Syst... US
		array( '24.49.224.0', '24.49.255.255' ),
		// # COGECO Cable Canada Inc. COQB-SG... US
		array( '24.50.64.0', '24.50.127.255' ),
		// # COGECO Cable Canada Inc. COQB (N... US
		array( '24.52.64.0', '24.52.127.255' ),
		// # 024052113198 Buckeye Cablevision, Inc. US
		array( '24.52.192.0', '24.52.255.255' ),
		// # 024052193072 TekSavvy Solutions Inc. CA
		array( '24.54.0.0', '24.54.31.255' ),
		// # COGECO Cable Canada Inc. COQB-MT... US
		array( '24.55.0.0', '24.55.63.255' ),
		// # 024055005220 Time Warner Cable Internet LLC US
		array( '24.56.0.0', '24.56.63.255' ),
		// # Cox Communications US
		array( '24.57.0.0', '24.57.255.255' ),
		// # Cogeco Cable Inc. CGOC-3BLK (NET... US
		array( '24.60.0.0', '24.63.255.255' ),
		// # Comcast Cable Communications Hol... US
		array( '24.64.0.0', '24.71.255.255' ),
		// # Shaw Communications Inc. CA
		array( '24.73.0.0', '24.73.255.255' ),
		// # Time Warner Cable Internet LLC US
		array( '24.74.0.0', '24.74.255.255' ),
		// # Time Warner Cable Internet LLC US
		array( '24.75.176.0', '24.75.191.255' ),
		// # 024075183077 COGECO Cable Canada Inc. COQB-AL01 (NET-24-75-176-0-2) US
		array( '24.76.0.0', '24.79.255.255' ),
		// # Shaw Communications Inc. CA
		array( '24.80.0.0', '24.87.255.255' ),
		// # Shaw Communications Inc. CA
		array( '24.90.0.0', '24.90.255.255' ),
		// # Time Warner Cable Internet LLC US
		array( '24.91.0.0', '24.91.255.255' ),
		// # 024091135038 Comcast Cable Communications Holdings, Inc RW2-NORTHEAST-2 (NET-24-91-0-0-1) US
		array( '24.92.160.0', '24.92.191.255' ),
		// # Time Warner Cable Internet LLC US
		array( '24.92.192.0', '24.92.255.255' ),
		// # Time Warner Cable Internet LLC US
		array( '24.93.0.0', '24.93.255.255' ),
		// # Time Warner Cable Internet LLC US
		array( '24.94.0.0', '24.95.255.255' ),
		// # Time Warner Cable Internet LLC US
		array( '24.98.0.0', '24.99.255.255' ),
		// # Comcast Cable Communications Hol... US
		array( '24.101.0.0', '24.101.255.255' ),
		// # Armstrong Cable Services ACS-INT... US
		array( '24.102.64.0', '24.102.127.255' ),
		// # Time Warner Cable Internet LLC US
		array( '24.103.0.0', '24.103.255.255' ),
		// # Time Warner Cable Internet LLC US
		array( '24.106.128.0', '24.106.255.255' ),
		// # 024106183110 Time Warner Cable Internet LLC US
		array( '24.107.0.0', '24.107.255.255' ),
		// # Charter Communications CHARTERST... US
		array( '24.108.0.0', '24.109.255.255' ),
		// # Shaw Communications Inc. CA
		array( '24.111.0.0', '24.111.255.255' ),
		// # Midcontinent Media, Inc. US
		array( '24.114.0.0', '24.114.127.255' ),
		// # 024114093034 Rogers Cable Communications Inc. CA
		array( '24.116.0.0', '24.117.255.255' ),
		// # CABLE ONE, INC. US
		array( '24.118.0.0', '24.118.255.255' ),
		// # Comcast Cable Communications Hol... US
		array( '24.119.0.0', '24.119.255.255' ),
		// # CABLE ONE, INC. US
		array( '24.120.0.0', '24.120.255.255' ),
		// # Cox Communications Inc. US
		array( '24.121.0.0', '24.121.255.255' ),
		// # Suddenlink Communications SUDDE-... US
		array( '24.122.128.0', '24.122.191.255' ),
		// # COGECO Cable Canada Inc. COQB-RI... US
		array( '24.123.0.0', '24.123.127.255' ),
		// # Time Warner Cable Internet LLC US
		array( '24.123.128.0', '24.123.255.255' ),
		// # Time Warner Cable Internet LLC US
		array( '24.125.0.0', '24.125.255.255' ),
		// # Comcast Cable Communications Hol... US
		array( '24.126.0.0', '24.127.255.255' ),
		// # Comcast Cable Communications Hol... US
		array( '24.129.0.0', '24.129.127.255' ),
		// # Comcast Cable Communications Hol... US
		array( '24.129.128.0', '24.129.191.255' ),
		// # Time Warner Cable Internet LLC US
		array( '24.130.0.0', '24.131.255.255' ),
		// # Comcast Cable Communications Hol... US
		array( '24.136.0.0', '24.136.31.255' ),
		// # RCN US
		array( '24.136.32.0', '24.136.63.255' ),
		// # 024136038135 Cox Communications Inc. US
		array( '24.136.64.0', '24.136.95.255' ),
		// # 024136069170 Earthlink, Inc. ERLK-CBL-TW-WEST (NET-24-136-64-0-1) US
		array( '24.137.64.0', '24.137.127.255' ),
		// # EastLink EASTLINK-BLK4 (NET-24-1... US
		array( '24.138.80.0', '24.138.95.255' ),
		// # COGECO Cable Canada Inc. COQB (N... US
		array( '24.139.128.0', '24.139.255.255' ),
		// # Liberty Cablevision of Puerto Ri... US
		array( '24.141.0.0', '24.141.255.255' ),
		// # Cable and Wireless Jamaica JM
		array( '24.142.128.0', '24.142.255.255' ),
		// # Time Warner Cable Internet LLC US
		array( '24.145.0.0', '24.145.127.255' ),
		// # Atlantic Broadband Finance, LLC ... US
		array( '24.146.128.0', '24.146.143.255' ),
		// # Optimum Online (Cablevision Syst... US
		array( '24.146.144.0', '24.146.151.255' ),
		// # Optimum Online (Cablevision Syst... US
		array( '24.147.0.0', '24.147.255.255' ),
		// # 024147007121 Comcast Cable Communications Holdings, Inc RW2-NORTHEAST-4 (NET-24-147-0-0-1) US
		array( '24.148.64.0', '24.148.95.255' ),
		// # RCN US
		array( '24.149.128.0', '24.149.255.255' ),
		// # Comcast Telecommunications, Inc. US
		array( '24.150.0.0', '24.150.255.255' ),
		// # Cogeco Cable Inc. CGOC-2BLK (NET... US
		array( '24.151.0.0', '24.151.255.255' ),
		// # Charter Communications CHARTER-N... US
		array( '24.152.128.0', '24.152.191.255' ),
		// # 024152154046 Earthlink, Inc. ERLK-CBL-TW-WEST (NET-24-152-128-0-1) US
		array( '24.153.128.0', '24.153.255.255' ),
		// # Time Warner Cable Internet LLC US
		array( '24.154.0.0', '24.154.255.255' ),
		// # Armstrong Cable Services ACS-INT... US
		array( '24.156.0.0', '24.156.127.255' ),
		// # Suddenlink Communications SUDDE-... US
		array( '24.157.32.0', '24.157.63.255' ),
		// # 024157039178 Cablevision Systems Corp. CVNET (NET-24-157-32-0-1) US
		array( '24.158.0.0', '24.158.255.255' ),
		// # Charter Communications CHARTER-N... US
		array( '24.158.144.0', '24.158.159.255' ),
		// # Charter Communications LBN-TN-24... US
		array( '24.159.224.0', '24.159.255.255' ),
		// # 024159235170 Charter Communications JNSVL-WI-24-159-224 (NET-24-159-224-0-1) US
		array( '24.160.0.0', '24.167.255.255' ),
		// # Time Warner Cable Internet LLC US
		array( '24.168.0.0', '24.169.255.255' ),
		// # Time Warner Cable Internet LLC US
		array( '24.170.0.0', '24.170.127.255' ),
		// # Time Warner Cable Internet LLC US
		array( '24.171.0.0', '24.171.127.255' ),
		// # Charter Communications CHARTERST... US
		array( '24.171.128.0', '24.171.159.255' ),
		// # 024171144170 Earthlink, Inc. ERLK-CBL-TW-WEST3 (NET-24-171-128-0-1) US
		array( '24.172.0.0', '24.172.255.255' ),
		// # Time Warner Cable Internet LLC US
		array( '24.173.0.0', '24.173.255.255' ),
		// # Time Warner Cable Internet LLC US
		array( '24.176.0.0', '24.183.255.255' ),
		// # Charter Communications NETBLK-CH... US
		array( '24.184.0.0', '24.187.255.255' ),
		// # Optimum Online OOL-2BLK (NET-24-... US
		array( '24.188.0.0', '24.191.255.255' ),
		// # Optimum Online NETBLK-OOL (NET-2... US
		array( '24.193.0.0', '24.193.255.255' ),
		// # Time Warner Cable Internet LLC US
		array( '24.196.0.0', '24.197.255.255' ),
		// # Charter Communications CHARTER-N... US
		array( '24.199.0.0', '24.199.63.255' ),
		// # 024199032102 Time Warner Cable Internet LLC US
		array( '24.199.128.0', '24.199.255.255' ),
		// # Time Warner Cable Internet LLC US
		array( '24.200.0.0', '24.203.255.255' ),
		// # Le Groupe Videotron Ltee VL-2BL ... US
		array( '24.205.0.0', '24.205.255.255' ),
		// # Charter Communications CHARWR (N... US
		array( '24.207.128.0', '24.207.255.255' ),
		// # Charter Communications CHARTERST... US
		array( '24.208.0.0', '24.211.255.255' ),
		// # Time Warner Cable Internet LLC US
		array( '24.212.0.0', '24.212.127.255' ),
		// # Cablevision du Nord de Quebec inc. CA
		array( '24.212.50.0', '24.212.55.255' ),
		// # Cablevision du Nord de Quebec CN... US
		array( '24.212.128.0', '24.212.255.255' ),
		// # TekSavvy Solutions Inc. CA
		array( '24.213.128.0', '24.213.255.255' ),
		// # Time Warner Cable Internet LLC US
		array( '24.215.64.0', '24.215.127.255' ),
		// # EastLink EASTLINK-BLK3 (NET-24-2... US
		array( '24.215.128.0', '24.215.191.255' ),
		// # EARTHLINK, INC. ERLK-TW-NYC14 (N... US
		array( '24.216.0.0', '24.216.255.255' ),
		// # Charter Communications CHTR-HSA-... US
		array( '24.217.0.0', '24.217.255.255' ),
		// # Charter Communications CHARTERST... US
		array( '24.218.0.0', '24.218.255.255' ),
		// # Comcast Cable Communications Hol... US
		array( '24.220.0.0', '24.220.255.255' ),
		// # Midcontinent Media, Inc. US
		array( '24.223.128.0', '24.223.255.255' ),
		// # Earthlink, Inc. ERLK-CBL-TW-CENT... US
		array( '24.224.128.0', '24.224.255.255' ),
		// # EastLink EASTLINK-BLK2 (NET-24-2... US
		array( '24.226.96.0', '24.226.111.255' ),
		// # 024226097212 Cogeco Cable Canada Inc. CGOC-BUSY-CPE6 (NET-24-226-96-0-1) US
		array( '24.226.128.0', '24.226.159.255' ),
		// # 024226137041 COGECO Cable Canada Inc. COQB-TR03 (NET-24-226-128-0-2) US
		array( '24.226.192.0', '24.226.223.255' ),
		// # 024226200168 COGECO Cable Canada Inc. COQB-HY01 (NET-24-226-192-0-1) US
		array( '24.227.32.0', '24.227.63.255' ),
		// # Time Warner Cable Internet LLC US
		array( '24.228.96.0', '24.228.111.255' ),
		// # 024228104135 Optimum Online (Cablevision Systems) OOL-CPE-NYX2NY-24-228-96-0-20 (NET-24-228-96-0-1) US
		array( '24.228.160.0', '24.228.167.255' ),
		// # Optimum Online (Cablevision Syst... US
		array( '24.228.188.0', '24.228.191.255' ),
		// # 024228189144 Optimum Online (Cablevision Systems) OOL-CPE-RMSYNJ-24-228-188-0-22 (NET-24-228-188-0-1) US
		array( '24.228.208.0', '24.228.211.255' ),
		// # 024228208152 Optimum Online (Cablevision Systems) OOL-CPE-NYK1NY-24-228-208-0-22 (NET-24-228-208-0-1) US
		array( '24.230.32.0', '24.230.63.255' ),
		// # Midcontinent Media, Inc. US
		array( '24.230.128.0', '24.230.191.255' ),
		// # Midcontinent Media, Inc. US
		array( '24.231.160.0', '24.231.175.255' ),
		// # Charter Communications BYC-MI-24... US
		array( '24.231.208.0', '24.231.223.255' ),
		// # Charter Communications BYC-MI-24... US
		array( '24.233.192.0', '24.233.255.255' ),
		// # MetroCast Cablevision of New Ham... US
		array( '24.234.0.0', '24.234.255.255' ),
		// # Cox Communications Inc. US
		array( '24.235.176.0', '24.235.191.255' ),
		// # 024235189225 Cogeco Cable Canada Inc. CGOC-PEGO-CPE4 (NET-24-235-176-0-1) US
		array( '24.235.224.0', '24.235.239.255' ),
		// # Cogeco Cable Canada Inc. CGOC-PE... US
		array( '24.238.144.0', '24.238.191.255' ),
		// # EARTHLINK, INC. ERLK-TW-HOUSTON1... US
		array( '24.240.0.0', '24.241.255.255' ),
		// # Charter Communications US
		array( '24.242.0.0', '24.243.255.255' ),
		// # Time Warner Cable Internet LLC US
		array( '24.244.0.0', '24.244.63.255' ),
		// # Shaw Communications Inc. CA
		array( '24.245.0.0', '24.245.63.255' ),
		// # Comcast Cable Communications Hol... US
		array( '24.246.0.0', '24.246.63.255' ),
		// # Time Warner Cable Internet LLC US
		array( '24.246.64.0', '24.246.95.255' ),
		// # 024246081177 TekSavvy Solutions Inc. CA
		array( '24.247.0.0', '24.247.255.255' ),
		// # Charter Communications CHARTER-M... US
		array( '24.247.232.0', '24.247.239.255' ),
		// # Charter Communications ALL-MI-24... US
		array( '24.248.0.0', '24.255.255.255' ),
		// # Cox Communications Inc. NETBLK-C... US
		array( '24.249.44.0', '24.249.47.255' ),
		// # Cox Communications NETBLK-WI-CBS... US
		array( '24.249.104.0', '24.249.111.255' ),
		// # Cox Communications NETBLK-WI-CBS... US
		array( '24.253.0.0', '24.253.127.255' ),
		// # Cox Communications NETBLK-LV-RDC... US
		array( '24.254.0.0', '24.254.31.255' ),
		// # Cox Communications NETBLK-HR-RDC... US
		array( '24.255.0.0', '24.255.63.255' ),
		// # Cox Communications NETBLK-PH-RDC... US
		array( '24.255.128.0', '24.255.255.255' ),
		// # Cox Communications NETBLK-WI-RDC... US
		array( '27.32.0.0', '27.33.255.255' ),
		// # TPG Internet Pty Ltd. AU
		array( '31.2.0.0', '31.2.127.255' ),
		// # 031002002189 Polkomtel sp. z o.o. PL
		array( '31.16.128.0', '31.16.255.255' ),
		// # 031016170246 KABEL-DEUTSCHLAND-CUSTOMER-SERVICES-24 DE
		array( '31.17.0.0', '31.17.127.255' ),
		// # 031017041006 KABEL-DEUTSCHLAND-CUSTOMER-SERVICES-24 DE
		array( '31.18.128.0', '31.18.255.255' ),
		// # 031018176210 KABEL-DEUTSCHLAND-CUSTOMER-SERVICES-24 DE
		array( '31.19.0.0', '31.19.127.255' ),
		// # KABEL-DEUTSCHLAND-CUSTOMER-SERVI... DE
		array( '31.27.112.0', '31.27.127.255' ),
		// # IP addresses allocated for VF-IT... IT
		array( '31.96.0.0', '31.127.255.255' ),
		// # T-Mobile (UK) Limited GB
		array( '31.187.0.0', '31.187.31.255' ),
		// # 031187017229 UPC Communications Ireland Limited IE
		array( '31.195.0.0', '31.195.255.255' ),
		// # Telecom Italia S.p.a. IT
		array( '31.196.0.0', '31.197.255.255' ),
		// # 031197145106 Telecom Italia SPA IT
		array( '31.198.0.0', '31.199.255.255' ),
		// # Telecom Italia S.p.a. IT
		array( '32.0.0.0', '32.255.255.255' ),
		// # AT&T Global Network Services, LL... US
		array( '33.0.0.0', '33.255.255.255' ),
		// # DoD Network Information Center US
		array( '37.5.128.0', '37.5.255.255' ),
		// # KABEL-DEUTSCHLAND-CUSTOMER-SERVI... DE
		array( '37.7.0.0', '37.7.255.255' ),
		// # 037007063086 Polkomtel sp. z o.o. PL
		array( '37.31.0.0', '37.31.255.255' ),
		// # 037031208179 blueconnect PL
		array( '37.60.64.0', '37.60.127.255' ),
		// # Wifinity Ltd GB
		array( '37.116.0.0', '37.116.255.255' ),
		// # 037116215094 IP addresses assigned to VDF customers IT
		array( '37.119.192.0', '37.119.255.255' ),
		// # IP addresses allocated for VF-IT... IT
		array( '37.128.0.0', '37.128.127.255' ),
		// # Biuro Podrozy RETMAN s.c. PL
		array( '37.152.16.0', '37.152.31.255' ),
		// # Cyfrowy Polsat MVNO mobile broad... PL
		array( '37.159.128.0', '37.159.255.255' ),
		// # IP range assigned for VDF-IT cus... IT
		array( '37.176.0.0', '37.183.255.255' ),
		// # IP range assigned to VDF-IT cust... IT
		array( '37.186.192.0', '37.186.255.255' ),
		// # ALFA BIT OMEGA public subnet IT
		array( '37.206.0.0', '37.206.255.255' ),
		// # Telecom Italia SPA IT
		array( '37.207.0.0', '37.207.255.255' ),
		// # Telecom Italia SPA IT
		array( '37.227.0.0', '37.227.255.255' ),
		// # UMTS company IT
		array( '37.248.0.0', '37.249.255.255' ),
		// # 037248254085 Cyfrowy Polsat MVNO mobile broadband services PL
		array( '40.128.0.0', '40.143.255.255' ),
		// # Windstream Communications Inc US
		array( '46.7.0.0', '46.7.127.255' ),
		// # Customers IE IE
		array( '46.137.216.0', '46.137.223.255' ),
		// # Amazon AWS Services - Cloudfront... DE
		array( '46.231.8.0', '46.231.15.255' ),
		// # Quickline Network GB
		array( '47.16.0.0', '47.19.255.255' ),
		// # Optimum WiFi NETBLK-WIFI-BLK6 (N... US
		array( '47.20.0.0', '47.23.255.255' ),
		// # Optimum Online NETBLK-OOL-11BLK ... US
		array( '47.58.0.0', '47.63.255.255' ),
		// # Vodafone Global Enterprise Inc. ... US
		array( '47.60.0.0', '47.63.255.255' ),
		// # Vodafone Spain VODAFONE-IP-SERVI... US
		array( '49.176.0.0', '49.191.255.255' ),
		// # Optus Internet Pty Ltd AU
		array( '49.192.0.0', '49.199.255.255' ),
		// # Optus Internet Pty Ltd AU
		array( '50.0.0.0', '50.1.255.255' ),
		// # 050001141109 SONIC.NET, INC. US
		array( '50.8.0.0', '50.15.255.255' ),
		// # CLEAR WIRELESS LLC US
		array( '50.16.0.0', '50.19.255.255' ),
		// # Amazon.com, Inc. US
		array( '50.32.0.0', '50.47.255.255' ),
		// # Frontier Communications of Ameri... US
		array( '50.48.0.0', '50.55.255.255' ),
		// # 050053101122 Frontier Communications of America, Inc. US
		array( '50.64.0.0', '50.71.255.255' ),
		// # Shaw Communications Inc. CA
		array( '50.72.0.0', '50.72.255.255' ),
		// # Shaw Communications Inc. CA
		array( '50.73.0.0', '50.73.255.255' ),
		// # Comcast Business Communications,... US
		array( '50.74.0.0', '50.75.255.255' ),
		// # Time Warner Cable Internet LLC US
		array( '50.76.0.0', '50.79.255.255' ),
		// # Comcast Business Communications, LLC US
		array( '50.80.0.0', '50.83.255.255' ),
		// # Mediacom Communications Corp US
		array( '50.84.0.0', '50.84.255.255' ),
		// # Time Warner Cable Internet LLC US
		array( '50.90.0.0', '50.90.255.255' ),
		// # BrightHouse Networks Indianapoli... US
		array( '50.96.0.0', '50.96.255.255' ),
		// # Windstream Communications Inc US
		array( '50.100.0.0', '50.101.255.255' ),
		// # Bell Canada BELLCANADA-21 (NET-5... US
		array( '50.102.0.0', '50.103.255.255' ),
		// # Frontier Communications of Ameri... US
		array( '50.104.0.0', '50.111.255.255' ),
		// # Frontier Communications of Ameri... US
		array( '50.112.0.0', '50.112.255.255' ),
		// # Amazon.com, Inc. US
		array( '50.113.0.0', '50.113.255.255' ),
		// # Time Warner Cable Internet LLC US
		array( '50.120.0.0', '50.127.255.255' ),
		// # Frontier Communications of Ameri... US
		array( '50.128.0.0', '50.255.255.255' ),
		// # Comcast Cable Communications Hol... US
		array( '52.0.0.0', '52.31.255.255' ),
		// # 052000086104 Amazon Technologies Inc. US
		array( '52.64.0.0', '52.95.255.255' ),
		// # 052074069081 Amazon Technologies Inc. US
		array( '54.64.0.0', '54.71.255.255' ),
		// # Amazon Technologies Inc. US
		array( '54.72.0.0', '54.79.255.255' ),
		// # Amazon Technologies Inc. US
		array( '54.80.0.0', '54.95.255.255' ),
		// # Amazon Technologies Inc. US
		array( '54.144.0.0', '54.159.255.255' ),
		// # Time Warner Cable US
		array( '54.160.0.0', '54.175.255.255' ),
		// # Amazon Technologies Inc. US
		array( '54.176.0.0', '54.191.255.255' ),
		// # Amazon Technologies Inc. US
		array( '54.192.0.0', '54.207.255.255' ),
		// # Amazon Technologies Inc. AMAZON-... US
		array( '54.208.0.0', '54.223.255.255' ),
		// # Amazon Technologies Inc. AMAZON-... US
		array( '54.224.0.0', '54.239.255.255' ),
		// # Amazon Technologies Inc. US
		array( '54.240.0.0', '54.255.255.255' ),
		// # Amazon Technologies Inc. AMAZON-... US
		array( '58.6.0.0', '58.7.255.255' ),
		// # iiNet Limited AU
		array( '58.104.0.0', '58.111.255.255' ),
		// # 058108203035 OPTUS INTERNET - RETAIL AU
		array( '58.160.0.0', '58.175.255.255' ),
		// # Telstra Internet AU
		array( '59.167.0.0', '59.167.255.255' ),
		// # iiNet Limited AU
		array( '60.224.0.0', '60.231.255.255' ),
		// # Telstra Internet AU
		array( '60.240.0.0', '60.241.255.255' ),
		// # TPG Internet Pty Ltd. AU
		array( '60.242.0.0', '60.242.255.255' ),
		// # TPG Internet Pty Ltd. AU
		array( '62.10.0.0', '62.11.255.255' ),
		// # 062010136060 Tiscali Italia SpA IT
		array( '62.20.0.0', '62.20.255.255' ),
		// # Telia Network Services SE
		array( '62.30.0.0', '62.31.255.255' ),
		// # 062031111234 Virgin Media Limited GB
		array( '62.30.112.0', '62.30.119.255' ),
		// # BIRMINGHAM GB
		array( '62.86.0.0', '62.86.255.255' ),
		// # 062086182166 Interbusiness infrastructural IT
		array( '62.110.0.0', '62.110.255.255' ),
		// # Telecom Italia S.p.a. IT
		array( '62.142.0.0', '62.142.255.255' ),
		// # 062142171024 Opiskelija-asunnot Oy Joensuun Elli FI
		array( '62.156.0.0', '62.159.255.255' ),
		// # Deutsche Telekom AG DE
		array( '62.197.32.0', '62.197.63.255' ),
		// # Loud-n-clear Un-Managed Colo Network GB
		array( '62.211.0.0', '62.211.255.255' ),
		// # Telecom Italia S.p.A. TIN EASY LITE IT
		array( '62.233.128.0', '62.233.255.255' ),
		// # Netia SA PL
		array( '62.252.0.0', '62.252.63.255' ),
		// # COMMUNICATE TECHNOLOGY PLC GB
		array( '62.253.0.0', '62.253.63.255' ),
		// # 062253027110 NTL Internet GB
		array( '62.254.64.0', '62.254.127.255' ),
		// # 062254064007 NTL Internet GB
		array( '62.255.0.0', '62.255.63.255' ),
		// # PRESSAC COMMUNICATIONS LTD GB
		array( '62.255.192.0', '62.255.255.255' ),
		// # University of Wales GB
		array( '63.64.0.0', '63.127.255.255' ),
		// # MCI Communications Services, Inc... US
		array( '63.144.0.0', '63.151.255.255' ),
		// # Qwest Communications Company, LLC US
		array( '63.152.0.0', '63.159.255.255' ),
		// # Qwest Communications Company, LLC US
		array( '63.160.0.0', '63.175.255.255' ),
		// # Sprint SPRN-BLKS (NET-63-160-0-0-1) US
		array( '63.176.0.0', '63.191.255.255' ),
		// # 063187032141 Sprint US
		array( '63.192.0.0', '63.207.255.255' ),
		// # AT&T Internet Services SBCIS-SIS... US
		array( '63.224.0.0', '63.231.255.255' ),
		// # Qwest Communications Company, LLC US
		array( '63.240.0.0', '63.243.255.255' ),
		// # CERFnet CERFNET-BLK-5 (NET-63-24... US
		array( '63.247.160.0', '63.247.191.255' ),
		// # 063247175187 Cablevision Systems Corp. CVNET (NET-63-247-160-0-1) US
		array( '64.15.160.0', '64.15.191.255' ),
		// # 064015186071 Savvis US
		array( '64.18.64.0', '64.18.95.255' ),
		// # MTO Telecom Inc. CA
		array( '64.108.0.0', '64.109.255.255' ),
		// # 064109122081 AT&T Internet Services US
		array( '64.119.128.0', '64.119.159.255' ),
		// # Towerstream I, Inc. TWRS (NET-64... US
		array( '64.121.0.0', '64.121.255.255' ),
		// # RCN US
		array( '64.130.96.0', '64.130.127.255' ),
		// # Troy Cablevision, Inc. TROYCABLE... US
		array( '64.142.0.0', '64.142.127.255' ),
		// # SONIC.NET, INC. US
		array( '64.147.0.0', '64.147.31.255' ),
		// # 064147000227 Cox Communications Inc. US
		array( '64.160.0.0', '64.175.255.255' ),
		// # AT&T Internet Services US
		array( '64.183.0.0', '64.183.127.255' ),
		// # Time Warner Cable Internet LLC US
		array( '64.183.160.0', '64.183.175.255' ),
		// # Time Warner Cable Internet LLC US
		array( '64.183.192.0', '64.183.255.255' ),
		// # 064183217142 Time Warner Cable Internet LLC US
		array( '64.196.0.0', '64.199.255.255' ),
		// # PaeTec Communications, Inc. US
		array( '64.222.128.0', '64.222.191.255' ),
		// # FAIRPOINT COMMUNICATIONS, INC. US
		array( '64.223.128.0', '64.223.191.255' ),
		// # FAIRPOINT COMMUNICATIONS, INC. US
		array( '64.228.96.0', '64.228.127.255' ),
		// # 064228109181 Sympatico SYMP20002-CA (NET-64-228-96-0-1) US
		array( '64.229.80.0', '64.229.83.255' ),
		// # 064229080153 Sympatico HSE HSEDYNAMIC201005123-CA (NET-64-229-80-0-1) US
		array( '64.229.180.0', '64.229.183.255' ),
		// # 064229180082 Sympatico HSE HSE10-DYNAMIC-20100427-CA (NET-64-229-180-0-1) US
		array( '64.229.204.0', '64.229.207.255' ),
		// # 064229204038 Sympatico HSE HSE11-DYNAMIC-20100427-CA (NET-64-229-204-0-1) US
		array( '64.229.248.0', '64.229.255.255' ),
		// # HSE HSE11921-CA (NET-64-229-248-0-1) US
		array( '64.233.160.0', '64.233.191.255' ),
		// # 064233173230 Google Inc. US
		array( '64.238.144.0', '64.238.159.255' ),
		// # CERVALIS LLC US
		array( '65.0.0.0', '65.15.255.255' ),
		// # BellSouth.net Inc. BELLSNET-BLK9... US
		array( '65.23.96.0', '65.23.127.255' ),
		// # Windstream Nuvox, Inc. US
		array( '65.24.0.0', '65.27.255.255' ),
		// # Time Warner Cable Internet LLC US
		array( '65.28.0.0', '65.31.255.255' ),
		// # Time Warner Cable Internet LLC US
		array( '65.32.0.0', '65.33.255.255' ),
		// # Time Warner Cable Internet LLC US
		array( '65.34.64.0', '65.34.127.255' ),
		// # 065034115017 Time Warner Cable Internet LLC US
		array( '65.35.0.0', '65.35.255.255' ),
		// # Time Warner Cable Internet LLC US
		array( '65.37.128.0', '65.37.191.255' ),
		// # Earthlink, Inc. US
		array( '65.40.0.0', '65.41.255.255' ),
		// # 065041155120 Embarq Corporation US
		array( '65.51.0.0', '65.51.255.255' ),
		// # Cablevision Systems Corp. CVNET-... US
		array( '65.52.0.0', '65.55.255.255' ),
		// # Microsoft Corporation US
		array( '65.78.0.0', '65.78.127.255' ),
		// # RCN US
		array( '65.87.128.0', '65.87.191.255' ),
		// # Earthlink, Inc. ERLK-CBL-TW-MSOU... US
		array( '65.92.0.0', '65.95.255.255' ),
		// # 065094100249 Bell Canada BELLNEXXIA-10 (NET-65-92-0-0-1) US
		array( '65.92.8.0', '65.92.15.255' ),
		// # Nexxia HSE NEXHSE2-CA (NET-65-92... US
		array( '65.100.0.0', '65.103.255.255' ),
		// # Qwest Communications Company, LLC US
		array( '65.128.0.0', '65.159.255.255' ),
		// # Qwest Communications Company, LLC US
		array( '65.160.0.0', '65.175.255.255' ),
		// # Sprint SPRINTLINK-2-BLKS (NET-65... US
		array( '65.184.0.0', '65.191.255.255' ),
		// # Time Warner Cable Internet LLC US
		array( '65.192.0.0', '65.223.255.255' ),
		// # 065203093008 MCI Communications Services, Inc. d/b/a Verizon Business UUNET65 (NET-65-192-0-0-1) US
		array( '65.197.19.0', '65.197.19.255' ),
		// # The Crawford Group/Enterprise Re... US
		array( '65.240.0.0', '65.255.255.255' ),
		// # MCI Communications Services, Inc... US
		array( '66.0.0.0', '66.0.255.255' ),
		// # Earthlink, Inc. NETBLCK-ITCD-3 (... US
		array( '66.1.0.0', '66.1.255.255' ),
		// # 066001122246 Sprint Nextel Corporation US
		array( '66.25.0.0', '66.25.255.255' ),
		// # Time Warner Cable Internet LLC US
		array( '66.26.0.0', '66.26.255.255' ),
		// # 066026115211 Time Warner Cable Internet LLC US
		array( '66.27.0.0', '66.27.255.255' ),
		// # Time Warner Cable Internet LLC US
		array( '66.30.0.0', '66.31.255.255' ),
		// # Comcast Cable Communications Hol... US
		array( '66.35.128.0', '66.35.191.255' ),
		// # Earthlink, Inc. ITCD-2 (NET-66-3... US
		array( '66.41.0.0', '66.41.255.255' ),
		// # Comcast Cable Communications Hol... US
		array( '66.42.128.0', '66.42.255.255' ),
		// # 066042167158 Fuse Internet Access US
		array( '66.49.0.0', '66.49.127.255' ),
		// # 066049051250 Windstream Nuvox, Inc. US
		array( '66.51.64.0', '66.51.95.255' ),
		// # Earthlink, Inc. ONECOM-66-51-64 ... US
		array( '66.56.0.0', '66.56.63.255' ),
		// # Comcast Cable Communications Hol... US
		array( '66.56.96.0', '66.56.127.255' ),
		// # Time Warner Cable Internet LLC US
		array( '66.56.128.0', '66.56.255.255' ),
		// # Time Warner Cable Internet LLC US
		array( '66.57.0.0', '66.57.255.255' ),
		// # Time Warner Cable Internet LLC US
		array( '66.64.128.0', '66.64.255.255' ),
		// # Windstream Nuvox, Inc. US
		array( '66.65.0.0', '66.65.255.255' ),
		// # Time Warner Cable Internet LLC US
		array( '66.66.0.0', '66.67.255.255' ),
		// # Time Warner Cable Internet LLC US
		array( '66.68.0.0', '66.69.255.255' ),
		// # Time Warner Cable Internet LLC US
		array( '66.74.0.0', '66.75.255.255' ),
		// # Time Warner Cable Internet LLC US
		array( '66.83.0.0', '66.83.255.255' ),
		// # Windstream Nuvox, Inc. US
		array( '66.87.0.0', '66.87.255.255' ),
		// # Sprint Nextel Corporation US
		array( '66.102.0.0', '66.102.15.255' ),
		// # Google Inc. US
		array( '66.103.32.0', '66.103.63.255' ),
		// # 066103054204 PERSONA COMMUNICATIONS INC. CA
		array( '66.130.0.0', '66.131.255.255' ),
		// # Le Groupe Videotron Ltee VL-9BL ... US
		array( '66.133.192.0', '66.133.255.255' ),
		// # 066133194151 Earthlink, Inc. ERLK-CBL-TW-WEST (NET-66-133-192-0-1) US
		array( '66.136.0.0', '66.143.255.255' ),
		// # AT&T Internet Services SBCIS-SIS... US
		array( '66.168.0.0', '66.169.255.255' ),
		// # Charter Communications CHARTER-N... US
		array( '66.171.80.0', '66.171.95.255' ),
		// # BRISTOL VIRGINIA UTILITIES BVU-2... US
		array( '66.172.192.0', '66.172.255.255' ),
		// # 066172203200 Long Lines Internet US
		array( '66.176.0.0', '66.177.255.255' ),
		// # Comcast Cable Communications Hol... US
		array( '66.184.128.0', '66.184.255.255' ),
		// # 066184181090 Earthlink, Inc. NETBLCK-ITCD-2 (NET-66-184-128-0-1) US
		array( '66.188.0.0', '66.191.255.255' ),
		// # Charter Communications CHARTER-N... US
		array( '66.190.240.0', '66.190.255.255' ),
		// # Charter Communications YKMA-WA-6... US
		array( '66.191.16.0', '66.191.31.255' ),
		// # Charter Communications YKMA-WA-6... US
		array( '66.210.0.0', '66.210.255.255' ),
		// # 066210101146 Cox Communications Inc. COX-NET-2BLK (NET-66-210-0-0-1) US
		array( '66.214.0.0', '66.215.255.255' ),
		// # Charter Communications CHARWR-02... US
		array( '66.214.48.0', '66.214.63.255' ),
		// # Charter Communications CH-HES-66... US
		array( '66.220.144.0', '66.220.159.255' ),
		// # Facebook, Inc. US
		array( '66.225.64.0', '66.225.127.255' ),
		// # 066225122003 Economic Computer Systems Inc. dba Mid Atlantic Broadband US
		array( '66.229.0.0', '66.229.255.255' ),
		// # 066229084003 Comcast Cable Communications Holdings, Inc CCCH3-32 (NET-66-229-0-0-1) US
		array( '66.245.128.0', '66.245.159.255' ),
		// # Earthlink, Inc. US
		array( '66.249.64.0', '66.249.95.255' ),
		// # Google Inc. US
		array( '67.0.0.0', '67.7.255.255' ),
		// # Qwest Communications Company, LLC US
		array( '67.8.0.0', '67.11.255.255' ),
		// # Time Warner Cable Internet LLC US
		array( '67.32.0.0', '67.35.255.255' ),
		// # BellSouth.net Inc. BELLSNET-BLK1... US
		array( '67.40.0.0', '67.41.255.255' ),
		// # Qwest Communications Company, LLC US
		array( '67.48.0.0', '67.49.255.255' ),
		// # Time Warner Cable Internet LLC US
		array( '67.52.0.0', '67.53.255.255' ),
		// # Time Warner Cable Internet LLC US
		array( '67.54.128.0', '67.54.255.255' ),
		// # Viasat Communications Inc. US
		array( '67.60.0.0', '67.61.255.255' ),
		// # CABLE ONE, INC. US
		array( '67.64.0.0', '67.67.255.255' ),
		// # AT&T Internet Services SBCIS-SIS... US
		array( '67.71.64.0', '67.71.67.255' ),
		// # 067071067109 Bell Sympatico BELQ1021-CA (NET-67-71-64-0-1) US
		array( '67.71.188.0', '67.71.191.255' ),
		// # 067071188009 Sympatico HSE SYM-DYNAMIC-20120612-CA (NET-67-71-188-0-1) US
		array( '67.78.0.0', '67.79.255.255' ),
		// # Time Warner Cable Internet LLC US
		array( '67.80.0.0', '67.87.255.255' ),
		// # Optimum Online NETBLK-OOL-4BLK (... US
		array( '67.112.0.0', '67.127.255.255' ),
		// # 067126084068 AT&T Internet Services SBCIS-SIS80 (NET-67-112-0-0-1) US
		array( '67.128.0.0', '67.135.255.255' ),
		// # Qwest Communications Company, LLC US
		array( '67.140.0.0', '67.141.255.255' ),
		// # Windstream Communications Inc WI... US
		array( '67.160.0.0', '67.191.255.255' ),
		// # Comcast Cable Communications, In... US
		array( '67.193.0.0', '67.193.255.255' ),
		// # Cogeco Cable Inc. CGOC-9BLK (NET... US
		array( '67.193.208.0', '67.193.223.255' ),
		// # Cogeco Cable Inc. CGOC-KICO-6 (N... US
		array( '67.202.0.0', '67.202.63.255' ),
		// # Amazon.com, Inc. US
		array( '67.217.4.0', '67.217.7.255' ),
		// # Midcontinent Media, Inc. US
		array( '67.230.160.0', '67.230.191.255' ),
		// # Carat Networks Inc CA
		array( '67.232.0.0', '67.239.255.255' ),
		// # Embarq Corporation US
		array( '67.240.0.0', '67.255.255.255' ),
		// # Time Warner Cable Internet LLC US
		array( '68.0.0.0', '68.15.255.255' ),
		// # Cox Communications Inc. COX-ATLA... US
		array( '68.16.0.0', '68.19.255.255' ),
		// # 068017060201 BellSouth.net Inc. BELLSNET-BLK13 (NET-68-16-0-0-1) US
		array( '68.32.0.0', '68.63.255.255' ),
		// # Comcast Cable Communications, In... US
		array( '68.32.208.0', '68.32.223.255' ),
		// # Comcast Cable Communications, In... US
		array( '68.33.0.0', '68.33.255.255' ),
		// # Comcast Cable Communications, In... US
		array( '68.35.128.0', '68.35.191.255' ),
		// # Comcast Cable Communications, In... US
		array( '68.36.0.0', '68.36.255.255' ),
		// # Comcast Cable Communications, In... US
		array( '68.44.0.0', '68.45.255.255' ),
		// # Comcast Cable Communications, In... US
		array( '68.47.0.0', '68.47.127.255' ),
		// # Comcast Cable Communications, In... US
		array( '68.48.0.0', '68.49.255.255' ),
		// # Comcast Cable Communications, In... US
		array( '68.50.0.0', '68.50.255.255' ),
		// # Comcast Cable Communications, In... US
		array( '68.57.32.0', '68.57.63.255' ),
		// # Comcast Cable Communications, In... US
		array( '68.59.144.0', '68.59.159.255' ),
		// # Comcast Cable Communications, In... US
		array( '68.68.64.0', '68.68.79.255' ),
		// # 068068079076 BRISTOL VIRGINIA UTILITIES BVU-2-BLK-4 (NET-68-68-64-0-1) US
		array( '68.80.0.0', '68.87.255.255' ),
		// # Comcast Cable Communications, In... US
		array( '68.88.0.0', '68.95.255.255' ),
		// # AT&T Internet Services SBCIS-SBI... US
		array( '68.96.0.0', '68.111.255.255' ),
		// # Cox Communications Inc. COX-ATLA... US
		array( '68.112.0.0', '68.119.255.255' ),
		// # Charter Communications CHARTER-N... US
		array( '68.120.0.0', '68.127.255.255' ),
		// # AT&T Internet Services SBCIS-SIS... US
		array( '68.120.54.0', '68.120.55.255' ),
		// # LSAN03 ADSL Rback7 PPPoX SBC0681... US
		array( '68.120.88.0', '68.120.91.255' ),
		// # PPPoX Pool Rbac2.irvnca SBC06812... US
		array( '68.143.0.0', '68.143.255.255' ),
		// # Windstream Nuvox, Inc. US
		array( '68.144.0.0', '68.151.255.255' ),
		// # Shaw Communications Inc. CA
		array( '68.152.0.0', '68.159.255.255' ),
		// # BellSouth.net Inc. US
		array( '68.172.0.0', '68.175.255.255' ),
		// # Time Warner Cable Internet LLC US
		array( '68.180.128.0', '68.180.255.255' ),
		// # Yahoo!Inc. US
		array( '68.184.0.0', '68.191.255.255' ),
		// # Charter Communications CHARTER-N... US
		array( '68.192.0.0', '68.199.255.255' ),
		// # Optimum Online NETBLK-OOL-5BLK (... US
		array( '68.200.0.0', '68.207.255.255' ),
		// # Time Warner Cable Internet LLC US
		array( '68.224.0.0', '68.231.255.255' ),
		// # Cox Communications Inc. NETBLK-C... US
		array( '68.238.128.0', '68.238.255.255' ),
		// # Verizon Online LLC US
		array( '68.248.0.0', '68.255.255.255' ),
		// # 068248241002 AT&T Internet Services SBCIS-SIS80 (NET-68-248-0-0-1) US
		array( '69.9.192.0', '69.9.255.255' ),
		// # Midcontinent Media, Inc. US
		array( '69.12.128.0', '69.12.255.255' ),
		// # SONIC.NET, INC. US
		array( '69.23.0.0', '69.23.255.255' ),
		// # Time Warner Cable Internet LLC US
		array( '69.27.224.0', '69.27.255.255' ),
		// # Cablevision Systems Corp. CVNET-... US
		array( '69.28.64.0', '69.28.95.255' ),
		// # Atlantic.net, Inc. ICC-ATLANTIC-... US
		array( '69.38.128.0', '69.38.255.255' ),
		// # Towerstream I, Inc. TWRS (NET-69... US
		array( '69.40.32.0', '69.40.63.255' ),
		// # 069040039097 ALLTEL Communications of North Carolina 69-40-32-0 (NET-69-40-32-0-1) US
		array( '69.48.0.0', '69.48.127.255' ),
		// # Earthlink, Inc. ONECOM-69-48 (NE... US
		array( '69.50.48.0', '69.50.63.255' ),
		// # PIVOT NET-69-50-48-0-1 (NET-69-5... US
		array( '69.63.114.0', '69.63.114.255' ),
		// # TAC COXNE-TAC-1 (NET-69-63-114-0-1) US
		array( '69.68.0.0', '69.69.255.255' ),
		// # 069068003059 Embarq Corporation US
		array( '69.74.46.64', '69.74.46.127' ),
		// # VERREX CVNET-454A2E40 (NET-69-74... US
		array( '69.76.0.0', '69.76.255.255' ),
		// # Time Warner Cable Internet LLC US
		array( '69.81.0.0', '69.81.255.255' ),
		// # 069081176038 Earthlink, Inc. ERLK-CBL-TW-CENTRAL (NET-69-81-0-0-1) US
		array( '69.84.192.0', '69.84.207.255' ),
		// # Arrival Communication, Inc ARRIV... US
		array( '69.92.0.0', '69.92.255.255' ),
		// # CABLE ONE, INC. US
		array( '69.104.0.0', '69.111.255.255' ),
		// # AT&T Internet Services SBCIS-SIS... US
		array( '69.112.0.0', '69.127.255.255' ),
		// # Optimum Online NETBLK-OOL-6BLK (... US
		array( '69.132.0.0', '69.135.255.255' ),
		// # Time Warner Cable Internet LLC US
		array( '69.136.0.0', '69.143.255.255' ),
		// # Comcast Cable Communications, In... US
		array( '69.144.0.0', '69.145.255.255' ),
		// # Charter Communications US
		array( '69.146.0.0', '69.146.255.255' ),
		// # Charter Communications US
		array( '69.148.0.0', '69.159.255.255' ),
		// # AT&T Internet Services SBCIS-SIS... US
		array( '69.152.192.0', '69.152.207.255' ),
		// # Rback3 PPPoX FYVLAR SBC069152192... US
		array( '69.156.0.0', '69.159.255.255' ),
		// # Bell Canada BELLNEXXIA-11 (NET-6... US
		array( '69.163.48.0', '69.163.63.255' ),
		// # Towerstream I, Inc. TWRS-LA (NET... US
		array( '69.166.160.0', '69.166.191.255' ),
		// # CLARKSVILLE DEPARTMENT OF ELECTR... US
		array( '69.171.224.0', '69.171.255.255' ),
		// # Facebook, Inc. US
		array( '69.179.0.0', '69.179.255.255' ),
		// # CenturyTel Internet Holdings, Inc. US
		array( '69.180.0.0', '69.181.255.255' ),
		// # Comcast Cable Communications Hol... US
		array( '69.193.0.0', '69.193.255.255' ),
		// # Time Warner Cable Internet LLC US
		array( '69.200.0.0', '69.207.255.255' ),
		// # Time Warner Cable Internet LLC US
		array( '69.208.0.0', '69.223.255.255' ),
		// # AT&T Internet Services SBCIS-SIS... US
		array( '69.212.124.0', '69.212.127.255' ),
		// # SFLDMI ADSL Rback2 PPPoX SBC0692... US
		array( '69.230.48.0', '69.230.63.255' ),
		// # rback20a.irvnca SBC0692300480002... US
		array( '69.230.96.0', '69.230.111.255' ),
		// # bras2.scrm01 SBC0692300960002005... US
		array( '69.240.0.0', '69.255.255.255' ),
		// # Comcast Cable Communications, In... US
		array( '70.8.0.0', '70.11.255.255' ),
		// # 070011119180 Sprint Nextel Corporation US
		array( '70.16.192.0', '70.16.223.255' ),
		// # FAIRPOINT COMMUNICATIONS, INC. US
		array( '70.24.0.0', '70.31.255.255' ),
		// # Bell Canada BELLCANADA-18 (NET-7... US
		array( '70.41.0.0', '70.41.255.255' ),
		// # Viasat Communications Inc. US
		array( '70.43.0.0', '70.43.255.255' ),
		// # 070043255005 Windstream Nuvox, Inc. US
		array( '70.48.0.0', '70.55.255.255' ),
		// # Bell Canada BELLNEXXIA-11 (NET-7... US
		array( '70.53.172.0', '70.53.191.255' ),
		// # Sympatico HSE SYMC20051020-CA (N... US
		array( '70.56.0.0', '70.59.255.255' ),
		// # Qwest Communications Company, LLC US
		array( '70.60.0.0', '70.63.255.255' ),
		// # Time Warner Cable Internet LLC US
		array( '70.64.0.0', '70.79.255.255' ),
		// # Shaw Communications Inc. CA
		array( '70.80.0.0', '70.83.255.255' ),
		// # Le Groupe Videotron Ltee VL-17BL... US
		array( '70.81.31.0', '70.81.31.255' ),
		// # Videotron Ltee VL-D-MP-46511F00 ... US
		array( '70.82.203.0', '70.82.203.255' ),
		// # Videotron Ltee VL-D-MW-4652CB00 ... US
		array( '70.82.242.0', '70.82.242.255' ),
		// # Videotron Ltee VL-D-MA-4652F200 ... US
		array( '70.88.0.0', '70.91.255.255' ),
		// # Comcast Business Communications,... US
		array( '70.92.0.0', '70.95.255.255' ),
		// # Time Warner Cable Internet LLC US
		array( '70.112.0.0', '70.127.255.255' ),
		// # Time Warner Cable Internet LLC US
		array( '70.128.0.0', '70.143.255.255' ),
		// # 070138160039 AT&T Internet Services US
		array( '70.144.0.0', '70.159.255.255' ),
		// # 070145009243 BellSouth.net Inc. US
		array( '70.160.0.0', '70.191.255.255' ),
		// # Cox Communications Inc. NETBLK-C... US
		array( '70.192.0.0', '70.223.255.255' ),
		// # Cellco Partnership DBA Verizon W... US
		array( '70.224.0.0', '70.239.255.255' ),
		// # AT&T Internet Services SBCIS-SIS... US
		array( '70.240.0.0', '70.255.255.255' ),
		// # AT&T Internet Services SBCIS-SIS... US
		array( '71.0.0.0', '71.3.255.255' ),
		// # Embarq Corporation US
		array( '71.7.128.0', '71.7.255.255' ),
		// # EastLink EASTLINK-BLK6 (NET-71-7... US
		array( '71.8.0.0', '71.15.255.255' ),
		// # Charter Communications CC04 (NET... US
		array( '71.16.0.0', '71.16.255.255' ),
		// # PaeTec Communications, Inc. US
		array( '71.20.0.0', '71.23.255.255' ),
		// # CLEAR WIRELESS LLC US
		array( '71.32.0.0', '71.39.255.255' ),
		// # Qwest Communications Company, LLC US
		array( '71.40.0.0', '71.43.255.255' ),
		// # Time Warner Cable Internet LLC US
		array( '71.44.0.0', '71.47.255.255' ),
		// # BRIGHT HOUSE NETWORKS, LLC MTA-5... US
		array( '71.48.0.0', '71.55.255.255' ),
		// # Embarq Corporation US
		array( '71.56.0.0', '71.63.255.255' ),
		// # Comcast Cable Communications Hol... US
		array( '71.64.0.0', '71.79.255.255' ),
		// # Time Warner Cable Internet LLC US
		array( '71.80.0.0', '71.95.255.255' ),
		// # Charter Communications NETBLK-CH... US
		array( '71.96.0.0', '71.127.255.255' ),
		// # Verizon Online LLC US
		array( '71.128.0.0', '71.159.255.255' ),
		// # AT&T Internet Services SBCIS-SIS... US
		array( '71.160.0.0', '71.160.255.255' ),
		// # Verizon Online LLC US
		array( '71.161.192.0', '71.161.223.255' ),
		// # FAIRPOINT COMMUNICATIONS, INC. US
		array( '71.161.224.0', '71.167.255.255' ),
		// # Verizon Online LLC VIS-BLOCK (NE... US
		array( '71.169.0.0', '71.169.127.255' ),
		// # 071169106012 Verizon Online LLC US
		array( '71.169.192.0', '71.169.255.255' ),
		// # 071170202051 Verizon Online LLC US
		array( '71.170.0.0', '71.171.255.255' ),
		// # 071170202051 Verizon Online LLC US
		array( '71.173.0.0', '71.173.63.255' ),
		// # Verizon Online LLC US
		array( '71.173.96.0', '71.173.127.255' ),
		// # Verizon Online LLC US
		array( '71.173.128.0', '71.173.255.255' ),
		// # Verizon Online LLC US
		array( '71.174.0.0', '71.175.255.255' ),
		// # Verizon US
		array( '71.176.0.0', '71.179.255.255' ),
		// # Verizon Online LLC US
		array( '71.180.0.0', '71.180.255.255' ),
		// # Verizon US
		array( '71.181.0.0', '71.181.127.255' ),
		// # FAIRPOINT COMMUNICATIONS, INC. US
		array( '71.182.0.0', '71.183.255.255' ),
		// # Verizon Online LLC US
		array( '71.184.0.0', '71.191.255.255' ),
		// # Verizon Online LLC US
		array( '71.185.213.136', '71.185.213.143' ),
		// # PERFORMANCE DEVELOPMENT FTTP (NE... US
		array( '71.192.0.0', '71.207.255.255' ),
		// # Comcast Cable Communications, In... US
		array( '71.208.0.0', '71.223.255.255' ),
		// # Qwest Communications Company, LLC US
		array( '71.224.0.0', '71.239.255.255' ),
		// # Comcast Cable Communications, In... US
		array( '71.241.224.0', '71.241.255.255' ),
		// # Verizon Online LLC US
		array( '71.242.0.0', '71.243.255.255' ),
		// # Verizon Online LLC US
		array( '71.244.0.0', '71.247.255.255' ),
		// # Verizon Online LLC US
		array( '71.248.0.0', '71.251.255.255' ),
		// # Verizon Online LLC US
		array( '71.252.0.0', '71.253.255.255' ),
		// # Verizon Online LLC US
		array( '71.254.112.0', '71.254.127.255' ),
		// # 071254122067 Verizon Online LLC US
		array( '71.255.0.0', '71.255.63.255' ),
		// # 071254122067 Verizon Online LLC US
		array( '72.4.0.0', '72.4.63.255' ),
		// # 072004049011 Cinergy Communications US
		array( '72.4.64.0', '72.4.95.255' ),
		// # 072004049011 Cinergy Communications US
		array( '72.11.160.0', '72.11.191.255' ),
		// # Cable Axion Digitel Inc. CA
		array( '72.21.192.0', '72.21.223.255' ),
		// # Amazon.com, Inc. US
		array( '72.25.0.0', '72.25.63.255' ),
		// # 072025000111 Windstream Communications Inc WINDSTREAM (NET-72-25-0-0-1) US
		array( '72.26.64.0', '72.26.95.255' ),
		// # CenturyTel Internet Holdings, Inc. US
		array( '72.27.0.0', '72.27.127.255' ),
		// # Cable and Wireless Jamaica JM
		array( '72.27.128.0', '72.27.191.255' ),
		// # Cable and Wireless Jamaica JM
		array( '72.27.192.0', '72.27.223.255' ),
		// # Cable and Wireless Jamaica JM
		array( '72.28.128.0', '72.28.255.255' ),
		// # 072028223176 Atlantic Broadband Finance, LLC ATLANTICBB-JOHNSTOWN (NET-72-28-128-0-1) US
		array( '72.38.0.0', '72.39.255.255' ),
		// # Cogeco Cable Inc. CGOC-7BLK (NET... US
		array( '72.43.0.0', '72.43.255.255' ),
		// # Time Warner Cable Internet LLC US
		array( '72.46.160.0', '72.46.175.255' ),
		// # 072046161178 Towerstream I, Inc. TWRS (NET-72-46-160-0-1) US
		array( '72.49.0.0', '72.49.255.255' ),
		// # 072049010002 Fuse Internet Access US
		array( '72.51.246.0', '72.51.247.255' ),
		// # 072051246133 Time Warner Cable Internet LLC TIME-WARNER-CABLE-INTERNET-LLC (NET-72-51-246-0-1) US
		array( '72.53.0.0', '72.53.255.255' ),
		// # DISTRIBUTEL COMMUNICATIONS LTD. ... US
		array( '72.64.32.0', '72.64.63.255' ),
		// # Verizon Online LLC US
		array( '72.64.64.0', '72.64.127.255' ),
		// # Verizon Online LLC US
		array( '72.65.128.0', '72.65.255.255' ),
		// # Verizon Online LLC US
		array( '72.66.0.0', '72.67.255.255' ),
		// # Verizon Online LLC US
		array( '72.68.0.0', '72.69.255.255' ),
		// # Verizon Online LLC US
		array( '72.70.0.0', '72.70.255.255' ),
		// # Verizon Online LLC US
		array( '72.71.0.0', '72.71.127.255' ),
		// # Verizon Online LLC US
		array( '72.71.128.0', '72.71.191.255' ),
		// # 072071181249 Verizon Online LLC US
		array( '72.74.0.0', '72.75.255.255' ),
		// # Verizon Online LLC US
		array( '72.76.0.0', '72.79.255.255' ),
		// # Verizon Online LLC US
		array( '72.80.0.0', '72.83.255.255' ),
		// # Verizon Online LLC US
		array( '72.84.0.0', '72.85.255.255' ),
		// # Verizon Online LLC US
		array( '72.86.0.0', '72.86.255.255' ),
		// # Verizon Online LLC US
		array( '72.87.64.0', '72.87.127.255' ),
		// # Verizon Online LLC US
		array( '72.87.128.0', '72.87.255.255' ),
		// # Verizon Online LLC US
		array( '72.88.0.0', '72.91.255.255' ),
		// # Verizon Online LLC US
		array( '72.92.0.0', '72.92.127.255' ),
		// # Verizon Online LLC US
		array( '72.92.160.0', '72.92.191.255' ),
		// # 072095021242 Verizon Online LLC US
		array( '72.92.192.0', '72.92.255.255' ),
		// # Verizon Online LLC US
		array( '72.93.0.0', '72.93.255.255' ),
		// # Verizon Online LLC US
		array( '72.94.0.0', '72.94.255.255' ),
		// # Verizon Online LLC US
		array( '72.95.64.0', '72.95.79.255' ),
		// # 072095021242 Verizon Online LLC US
		array( '72.96.0.0', '72.127.255.255' ),
		// # Cellco Partnership DBA Verizon W... US
		array( '72.128.0.0', '72.135.255.255' ),
		// # Time Warner Cable Internet LLC US
		array( '72.136.0.0', '72.143.255.255' ),
		// # Rogers Cable Communications Inc.... US
		array( '72.144.0.0', '72.159.255.255' ),
		// # BellSouth.net Inc. US
		array( '72.160.0.0', '72.161.255.255' ),
		// # CenturyTel Internet Holdings, Inc. US
		array( '72.172.0.0', '72.172.63.255' ),
		// # 072172060043 Windstream Communications Inc US
		array( '72.173.0.0', '72.173.255.255' ),
		// # Viasat Communications Inc. US
		array( '72.174.0.0', '72.175.255.255' ),
		// # Charter Communications US
		array( '72.176.0.0', '72.191.255.255' ),
		// # Time Warner Cable Internet LLC US
		array( '72.192.0.0', '72.192.63.255' ),
		// # Cox Communications NETBLK-RI-RDC... US
		array( '72.192.128.0', '72.192.191.255' ),
		// # Cox Communications NETBLK-SD-RDC... US
		array( '72.192.192.0', '72.192.255.255' ),
		// # Cox Communications NETBLK-NV-RDC... US
		array( '72.193.0.0', '72.193.255.255' ),
		// # Cox Communications NETBLK-LV-RDC... US
		array( '72.194.64.0', '72.194.127.255' ),
		// # Cox Communications NETBLK-OC-RDC... US
		array( '72.194.208.0', '72.194.223.255' ),
		// # Cox Communications NETBLK-SD-RDC... US
		array( '72.195.128.0', '72.195.159.255' ),
		// # 072195154045 Cox Communications NETBLK-RI-RDC-72-195-128-0 (NET-72-195-128-0-1) US
		array( '72.196.96.0', '72.196.127.255' ),
		// # Cox Communications NETBLK-AT-RDC... US
		array( '72.196.144.0', '72.196.159.255' ),
		// # Cox Communications NETBLK-RI-RDC... US
		array( '72.197.0.0', '72.197.255.255' ),
		// # Cox Communications NETBLK-SD-RDC... US
		array( '72.198.0.0', '72.198.127.255' ),
		// # 072198079238 Cox Communications NETBLK-OK-RDC-72-198-0-0 (NET-72-198-0-0-1) US
		array( '72.199.0.0', '72.199.255.255' ),
		// # Cox Communications NETBLK-SD-RDC... US
		array( '72.200.192.0', '72.200.223.255' ),
		// # Cox Communications NETBLK-OK-RDC... US
		array( '72.201.0.0', '72.201.255.255' ),
		// # Cox Communications NETBLK-PH-RDC... US
		array( '72.202.128.0', '72.202.159.255' ),
		// # 072202128149 Cox Communications NETBLK-WI-RDC-72-202-128-0 (NET-72-202-128-0-1) US
		array( '72.203.128.0', '72.203.159.255' ),
		// # Cox Communications NETBLK-BR-RDC... US
		array( '72.204.0.0', '72.204.127.255' ),
		// # Cox Communications NETBLK-WI-RDC... US
		array( '72.204.128.0', '72.204.191.255' ),
		// # 072204167213 Cox Communications NETBLK-NO-RDC-72-204-128-0 (NET-72-204-128-0-1) US
		array( '72.208.0.0', '72.208.255.255' ),
		// # Cox Communications NETBLK-PH-RDC... US
		array( '72.209.0.0', '72.209.63.255' ),
		// # Cox Communications NETBLK-RI-RDC... US
		array( '72.209.128.0', '72.209.191.255' ),
		// # Cox Communications NETBLK-WI-RDC... US
		array( '72.211.128.0', '72.211.191.255' ),
		// # 072211149029 Cox Communications NETBLK-PH-RDC-72-211-128-0 (NET-72-211-128-0-1) US
		array( '72.213.0.0', '72.213.63.255' ),
		// # Cox Communications NETBLK-OM-RDC... US
		array( '72.213.128.0', '72.213.191.255' ),
		// # Cox Communications NETBLK-OK-RDC... US
		array( '72.214.0.0', '72.214.31.255' ),
		// # 072214003083 Cox Communications NETBLK-SD-CBS-72-214-0-0 (NET-72-214-0-0-1) US
		array( '72.215.0.0', '72.215.31.255' ),
		// # Allegiance Communications, LLC N... US
		array( '72.215.48.0', '72.215.55.255' ),
		// # Cox Communications NETBLK-RI-CBS... US
		array( '72.216.0.0', '72.216.63.255' ),
		// # Cox Communications NETBLK-AT-RDC... US
		array( '72.218.0.0', '72.218.255.255' ),
		// # 072218172060 Cox Communications NETBLK-HR-RDC-72-218-0-0 (NET-72-218-0-0-1) US
		array( '72.220.0.0', '72.220.255.255' ),
		// # Cox Communications NETBLK-SD-RDC... US
		array( '72.222.128.0', '72.222.255.255' ),
		// # Cox Communications NETBLK-PH-RDC... US
		array( '72.223.0.0', '72.223.127.255' ),
		// # Cox Communications NETBLK-PH-RDC... US
		array( '72.224.0.0', '72.231.255.255' ),
		// # Time Warner Cable Internet LLC US
		array( '72.240.0.0', '72.241.255.255' ),
		// # Buckeye Cablevision, Inc. US
		array( '72.242.0.0', '72.243.255.255' ),
		// # Earthlink, Inc. US
		array( '73.0.0.0', '73.255.255.255' ),
		// # Comcast IP Services, L.L.C. US
		array( '73.53.0.0', '73.53.127.255' ),
		// # Comcast IP Services, L.L.C. SEAT... US
		array( '74.4.0.0', '74.5.255.255' ),
		// # Embarq Corporation US
		array( '74.12.0.0', '74.15.255.255' ),
		// # 074015019153 Bell Canada BELLNEXXIA-11 (NET-74-12-0-0-1) US
		array( '74.12.40.0', '74.12.63.255' ),
		// # 074012049146 Sympatico HSE SYMC20060314-CA (NET-74-12-40-0-1) US
		array( '74.32.0.0', '74.47.255.255' ),
		// # Frontier Communications of Ameri... US
		array( '74.56.0.0', '74.59.255.255' ),
		// # Le Groupe Videotron Ltee VL-19BL... US
		array( '74.60.0.0', '74.61.255.255' ),
		// # CLEAR WIRELESS LLC US
		array( '74.62.0.0', '74.62.255.255' ),
		// # Time Warner Cable Internet LLC US
		array( '74.64.0.0', '74.79.255.255' ),
		// # Time Warner Cable Internet LLC US
		array( '74.82.192.0', '74.82.223.255' ),
		// # Carat Networks Inc CA
		array( '74.88.0.0', '74.91.255.255' ),
		// # Optimum Online NETBLK-OOL-8BLK (... US
		array( '74.91.0.0', '74.91.15.255' ),
		// # Atlantic Metro Communications US
		array( '74.92.0.0', '74.95.255.255' ),
		// # Comcast Business Communications,... US
		array( '74.96.0.0', '74.111.255.255' ),
		// # Verizon Online LLC US
		array( '74.125.0.0', '74.125.255.255' ),
		// # Google Inc. US
		array( '74.128.0.0', '74.135.255.255' ),
		// # Time Warner Cable Internet LLC US
		array( '74.136.0.0', '74.139.255.255' ),
		// # Time Warner Cable Internet LLC US
		array( '74.140.0.0', '74.141.255.255' ),
		// # Time Warner Cable US
		array( '74.142.0.0', '74.143.255.255' ),
		// # Time Warner Cable Internet LLC US
		array( '74.160.0.0', '74.191.255.255' ),
		// # BellSouth.net Inc. BELLSNET-BLK1... US
		array( '74.198.0.0', '74.198.255.255' ),
		// # 074198228128 Rogers Wireless Inc. CA
		array( '74.209.16.0', '74.209.31.255' ),
		// # FAIRPOINT COMMUNICATIONS, INC. F... US
		array( '74.210.128.0', '74.210.159.255' ),
		// # COGECO Cable Canada Inc. COQB-SH... US
		array( '74.210.208.0', '74.210.223.255' ),
		// # COGECO Cable Canada Inc. COQB-AE... US
		array( '74.212.128.0', '74.212.191.255' ),
		// # 074212138178 Towerstream I, Inc. TWRS (NET-74-212-128-0-1) US
		array( '74.218.0.0', '74.219.255.255' ),
		// # Time Warner Cable Internet LLC US
		array( '74.224.0.0', '74.255.255.255' ),
		// # BellSouth.net Inc. BELLSNET-BLK1... US
		array( '74.226.64.0', '74.226.127.255' ),
		// # MEM ADSL CBB BLS-74-226-64-0-100... US
		array( '75.0.0.0', '75.63.255.255' ),
		// # AT&T Internet Services US
		array( '75.64.0.0', '75.79.255.255' ),
		// # Comcast Cable Communications Hol... US
		array( '75.80.0.0', '75.87.255.255' ),
		// # Time Warner Cable Internet LLC US
		array( '75.88.0.0', '75.91.255.255' ),
		// # Windstream Communications Inc US
		array( '75.92.0.0', '75.95.255.255' ),
		// # CLEAR WIRELESS LLC US
		array( '75.101.128.0', '75.101.255.255' ),
		// # Amazon.com, Inc. US
		array( '75.104.0.0', '75.107.255.255' ),
		// # Viasat Communications Inc. US
		array( '75.120.0.0', '75.121.255.255' ),
		// # 075121253177 CenturyTel Internet Holdings, Inc. US
		array( '75.128.0.0', '75.143.255.255' ),
		// # Charter Communications NETBLK-CH... US
		array( '75.128.80.0', '75.128.95.255' ),
		// # Charter Communications BYC-MI-75... US
		array( '75.130.48.0', '75.130.63.255' ),
		// # Charter Communications KNG-TN-75... US
		array( '75.134.128.0', '75.134.159.255' ),
		// # Charter Communications RCH-MN-75... US
		array( '75.137.128.0', '75.137.143.255' ),
		// # Charter Communications SLD-LA-75... US
		array( '75.139.80.0', '75.139.95.255' ),
		// # Charter Communications SPR-SC-75... US
		array( '75.139.96.0', '75.139.127.255' ),
		// # Charter Communications MNT-NC-75... US
		array( '75.139.192.0', '75.139.223.255' ),
		// # Charter Communications KNN-WA-75... US
		array( '75.141.0.0', '75.141.63.255' ),
		// # Charter Communications CBN-BGP-7... US
		array( '75.143.224.0', '75.143.255.255' ),
		// # Charter Communications GRN-SC-75... US
		array( '75.144.0.0', '75.151.255.255' ),
		// # Comcast Business Communications,... US
		array( '75.160.0.0', '75.175.255.255' ),
		// # Qwest Communications Company, LLC US
		array( '75.176.0.0', '75.191.255.255' ),
		// # Time Warner Cable Internet LLC US
		array( '75.192.0.0', '75.255.255.255' ),
		// # Cellco Partnership DBA Verizon W... US
		array( '76.0.0.0', '76.7.255.255' ),
		// # Embarq Corporation US
		array( '76.11.0.0', '76.11.127.255' ),
		// # EastLink EASTLINK-BLK7 (NET-76-1... US
		array( '76.16.0.0', '76.31.255.255' ),
		// # Comcast Cable Communications, In... US
		array( '76.64.0.0', '76.71.255.255' ),
		// # Bell Canada BELLCANADA-16 (NET-7... US
		array( '76.79.0.0', '76.79.255.255' ),
		// # Time Warner Cable Internet LLC US
		array( '76.80.0.0', '76.95.255.255' ),
		// # Time Warner Cable Internet LLC US
		array( '76.96.0.0', '76.127.255.255' ),
		// # Comcast Cable Communications, In... US
		array( '76.166.0.0', '76.167.255.255' ),
		// # Time Warner Cable Internet LLC US
		array( '76.168.0.0', '76.175.255.255' ),
		// # Time Warner Cable Internet LLC US
		array( '76.176.0.0', '76.176.255.255' ),
		// # Time Warner Cable Internet LLC US
		array( '76.177.0.0', '76.177.255.255' ),
		// # Time Warner Cable Internet LLC US
		array( '76.178.128.0', '76.178.191.255' ),
		// # 076178148151 Time Warner Cable Internet LLC US
		array( '76.178.192.0', '76.178.255.255' ),
		// # 076178199186 Time Warner Cable Internet LLC US
		array( '76.179.0.0', '76.179.255.255' ),
		// # Time Warner Cable Internet LLC US
		array( '76.180.0.0', '76.180.255.255' ),
		// # Time Warner Cable Internet LLC US
		array( '76.181.0.0', '76.181.255.255' ),
		// # 076181232006 Time Warner Cable Internet LLC US
		array( '76.182.192.0', '76.182.255.255' ),
		// # 076182223089 Time Warner Cable Internet LLC US
		array( '76.183.0.0', '76.183.255.255' ),
		// # 076183095027 Time Warner Cable Internet LLC US
		array( '76.184.0.0', '76.187.255.255' ),
		// # 076184011018 Time Warner Cable Internet LLC US
		array( '76.188.0.0', '76.189.255.255' ),
		// # Time Warner Cable Internet LLC US
		array( '76.190.0.0', '76.190.255.255' ),
		// # 076190129189 Time Warner Cable Internet LLC US
		array( '76.191.128.0', '76.191.255.255' ),
		// # 076191134034 SONIC.NET, INC. US
		array( '76.192.0.0', '76.255.255.255' ),
		// # AT&T Internet Services US
		array( '77.22.0.0', '77.22.127.255' ),
		// # 077022103065 Kabel Deutschland Breitband Customer 17 DE
		array( '77.96.0.0', '77.103.255.255' ),
		// # UDDINGSTON GB
		array( '77.112.0.0', '77.115.255.255' ),
		// # Polkomtel sp. z o.o. PL
		array( '78.4.0.0', '78.4.255.255' ),
		// # DIOGENE SRL IT
		array( '78.5.0.0', '78.5.255.255' ),
		// # NEW POGRAM S.A.S. DI PALLONE PAO... IT
		array( '78.6.0.0', '78.6.255.255' ),
		// # CORONA RUDY IT
		array( '78.7.0.0', '78.7.255.255' ),
		// # PISCITELLI EUSTACHIO IT
		array( '78.12.0.0', '78.15.255.255' ),
		// # Tiscalinet IT
		array( '78.64.0.0', '78.79.255.255' ),
		// # Telia Network Services SE
		array( '79.2.0.0', '79.3.255.255' ),
		// # Telecom Italia S.p.A. TIN EASY LITE IT
		array( '79.5.0.0', '79.5.255.255' ),
		// # Telecom Italia S.p.A. TIN EASY LITE IT
		array( '79.6.0.0', '79.7.255.255' ),
		// # Telecom Italia S.p.A. TIN EASY LITE IT
		array( '79.192.0.0', '79.255.255.255' ),
		// # Deutsche Telekom AG DE
		array( '80.0.0.0', '80.0.255.255' ),
		// # NTL Infrastructure - Oldham GB
		array( '80.1.0.0', '80.1.255.255' ),
		// # 080001145078 Virgin Media Limited GB
		array( '80.2.0.0', '80.2.255.255' ),
		// # NTL Infrastructure - Lewisham GB
		array( '80.3.0.0', '80.3.255.255' ),
		// # 080003158066 Infrastructure GB
		array( '80.4.0.0', '80.4.255.255' ),
		// # 080004138161 NTL Nottingham - CABLE HEADEND GB
		array( '80.5.0.0', '80.5.255.255' ),
		// # Peterborough GB
		array( '80.6.0.0', '80.6.255.255' ),
		// # 080006067217 NTL Infrastructure - Ashford GB
		array( '80.7.0.0', '80.7.255.255' ),
		// # Baguley GB
		array( '80.12.35.0', '80.12.35.255' ),
		// # Orange FR
		array( '80.18.0.0', '80.19.255.255' ),
		// # Telecom Italia SPA IT
		array( '80.40.0.0', '80.47.255.255' ),
		// # 080043225110 Pipex - Tiscali Migration Space GB
		array( '80.81.160.0', '80.81.191.255' ),
		// # Mpoli Oy FI
		array( '80.104.0.0', '80.104.255.255' ),
		// # Telecom Italia S.p.A. IT
		array( '80.111.0.0', '80.111.127.255' ),
		// # UPC Communications Ireland Limited IE
		array( '80.116.0.0', '80.116.255.255' ),
		// # Telecom Italia S.p.A. TIN EASY LITE IT
		array( '80.117.0.0', '80.117.255.255' ),
		// # Telecom Italia S.p.A. TIN EASY LITE IT
		array( '80.128.0.0', '80.143.255.255' ),
		// # Deutsche Telekom AG DE
		array( '80.144.0.0', '80.151.255.255' ),
		// # 080150190079 ELCON Systemtechnik GmbH DE
		array( '80.180.0.0', '80.180.255.255' ),
		// # Telecom Italia S.p.A. TIN EASY LITE IT
		array( '80.181.0.0', '80.181.255.255' ),
		// # Telecom Italia S.p.A. TIN EASY LITE IT
		array( '80.182.0.0', '80.182.255.255' ),
		// # Telecom Italia S.p.A. TIN EASY LITE IT
		array( '80.183.0.0', '80.183.255.255' ),
		// # Telecom Italia S.p.A. TIN EASY LITE IT
		array( '80.192.0.0', '80.195.255.255' ),
		// # Virgin Media Limited GB
		array( '80.220.0.0', '80.223.255.255' ),
		// # Broadband access pool FI
		array( '80.233.0.0', '80.233.63.255' ),
		// # Telefonica O2 Ireland Mobile Bro... IE
		array( '81.74.0.0', '81.74.255.255' ),
		// # 081074016207 Telecom Italia S.p.A. IT
		array( '81.96.0.0', '81.97.255.255' ),
		// # Virgin Media Limited GB
		array( '81.98.0.0', '81.99.255.255' ),
		// # NTL Infrastructure - Watford GB
		array( '81.100.0.0', '81.101.255.255' ),
		// # NTL Infrastructure - Acton GB
		array( '81.102.0.0', '81.103.255.255' ),
		// # 081103068087 NTL Infrastructure - Swansea GB
		array( '81.104.0.0', '81.107.255.255' ),
		// # NTL Infrastructure - Luton GB
		array( '81.106.0.0', '81.107.255.255' ),
		// # Virgin Media Limited GB
		array( '81.108.0.0', '81.109.255.255' ),
		// # Virgin Media Limited GB
		array( '81.110.0.0', '81.111.255.255' ),
		// # NTL Infrastructure - Watford BAM GB
		array( '81.119.0.0', '81.119.255.255' ),
		// # Telecom Italia S.p.A. IT
		array( '81.208.0.0', '81.208.63.255' ),
		// # 081208029117 Infrastructure for Fastweb's main location IT
		array( '81.210.0.0', '81.210.127.255' ),
		// # 081210024034 Netia Telekom SA PL
		array( '81.219.0.0', '81.219.255.255' ),
		// # Netia SA PL
		array( '81.224.0.0', '81.239.255.255' ),
		// # Telia Network Services SE
		array( '82.0.0.0', '82.3.255.255' ),
		// # DARESBURY SCIENCE AND INNOVATION... GB
		array( '82.4.0.0', '82.7.255.255' ),
		// # NTL Infrastructure - Northampton GB
		array( '82.8.0.0', '82.11.255.255' ),
		// # Virgin Media Limited GB
		array( '82.12.0.0', '82.15.255.255' ),
		// # NTL Infrastructure - Waltham Park GB
		array( '82.16.0.0', '82.19.255.255' ),
		// # NTL Infrastructure - Leicester GB
		array( '82.20.0.0', '82.23.255.255' ),
		// # NTL Infrastructure - Norwich GB
		array( '82.24.0.0', '82.27.255.255' ),
		// # Virgin Media Limited GB
		array( '82.28.0.0', '82.31.255.255' ),
		// # Virgin Media Limited GB
		array( '82.32.0.0', '82.47.255.255' ),
		// # KNOWSLEY GB
		array( '82.48.0.0', '82.48.255.255' ),
		// # Telecom Italia S.p.A. TIN EASY LITE IT
		array( '82.49.0.0', '82.49.255.255' ),
		// # Telecom Italia S.p.A. TIN EASY LITE IT
		array( '82.50.0.0', '82.50.255.255' ),
		// # Telecom Italia S.p.A. TIN EASY LITE IT
		array( '82.51.0.0', '82.51.255.255' ),
		// # Telecom Italia S.p.A. TIN EASY LITE IT
		array( '82.52.0.0', '82.52.127.255' ),
		// # Telecom Italia S.p.A. TIN EASY LITE IT
		array( '82.55.0.0', '82.55.127.255' ),
		// # Telecom Italia S.p.A. TIN EASY LITE IT
		array( '82.55.128.0', '82.55.255.255' ),
		// # Telecom Italia S.p.A. TIN EASY LITE IT
		array( '82.56.0.0', '82.56.255.255' ),
		// # 082056044227 Telecom Italia S.p.A. TIN EASY LITE IT
		array( '82.57.0.0', '82.57.255.255' ),
		// # 082057027112 Telecom Italia S.p.A. IT
		array( '82.58.0.0', '82.58.255.255' ),
		// # Telecom Italia S.p.A. TIN EASY LITE IT
		array( '82.59.0.0', '82.59.255.255' ),
		// # Telecom Italia S.p.A. TIN EASY LITE IT
		array( '82.60.0.0', '82.60.255.255' ),
		// # Telecom Italia S.p.A. IT
		array( '82.61.0.0', '82.61.255.255' ),
		// # Telecom Italia S.p.A. IT
		array( '82.84.0.0', '82.85.255.255' ),
		// # Larry Smith IT
		array( '82.88.0.0', '82.88.255.255' ),
		// # Telecom Italia S.p.A. IT
		array( '82.106.0.0', '82.106.127.255' ),
		// # Telecom Italia S.p.A. IT
		array( '82.181.0.0', '82.181.255.255' ),
		// # DNA Oy FI
		array( '82.190.0.0', '82.190.255.255' ),
		// # 082190023102 Telecom Italia SPA IT
		array( '83.103.0.0', '83.103.63.255' ),
		// # 083103007038 Infrastructure for Fastweb's main location IT
		array( '83.103.64.0', '83.103.127.255' ),
		// # 083103124158 Infrastructure for Fastweb's main location IT
		array( '83.144.96.0', '83.144.127.255' ),
		// # 083144106030 UPC Polska Sp. z o.o. PL
		array( '83.220.96.0', '83.220.111.255' ),
		// # 083220097235 Corporate Network & ISP backbone PL
		array( '83.238.0.0', '83.238.255.255' ),
		// # MGM Przedsiebiorstwo Handlowo Us... PL
		array( '83.248.0.0', '83.255.255.255' ),
		// # com hem AB SE
		array( '84.10.0.0', '84.10.127.255' ),
		// # 084010066063 UPC Polska Sp. z o.o. PL
		array( '84.10.128.0', '84.10.255.255' ),
		// # 084010187219 UPC Polska Sp. z o.o. PL
		array( '84.128.0.0', '84.191.255.255' ),
		// # Deutsche Telekom AG DE
		array( '84.220.0.0', '84.223.255.255' ),
		// # Tiscali Italia SpA IT
		array( '84.248.0.0', '84.251.255.255' ),
		// # Broadband access pool FI
		array( '84.252.192.0', '84.252.255.255' ),
		// # 084252194250 TalkTalk Communications Limited GB
		array( '85.18.0.0', '85.18.127.255' ),
		// # 085018006026 Infrastructure for Fastweb's main location IT
		array( '85.18.128.0', '85.18.255.255' ),
		// # 085018199020 Infrastructure for Fastweb's main location IT
		array( '85.20.0.0', '85.20.255.255' ),
		// # IMMOBILIARE FINOCCHIO EST SRL IT
		array( '85.38.0.0', '85.38.255.255' ),
		// # Telecom Italia SPA IT
		array( '85.76.0.0', '85.79.255.255' ),
		// # SL-CGN FI
		array( '85.255.224.0', '85.255.239.255' ),
		// # Vodafone Limited GB
		array( '86.0.0.0', '86.31.255.255' ),
		// # NTL Infrastructure - Cosham GB
		array( '86.115.0.0', '86.115.255.255' ),
		// # 086115000064 AinaCom Oy FI
		array( '86.128.0.0', '86.159.255.255' ),
		// # BT CENTRAL PLUS - OPERATIONAL SUPPORT GB
		array( '87.0.0.0', '87.0.255.255' ),
		// # Telecom Italia S.p.A. TIN EASY LITE IT
		array( '87.1.0.0', '87.1.255.255' ),
		// # 087001138079 Telecom Italia S.p.A. TIN EASY LITE IT
		array( '87.2.0.0', '87.2.255.255' ),
		// # Telecom Italia S.p.A. TIN EASY LITE IT
		array( '87.3.0.0', '87.3.255.255' ),
		// # Telecom Italia S.p.A. TIN EASY LITE IT
		array( '87.4.0.0', '87.5.255.255' ),
		// # Telecom Italia S.p.A. TIN EASY LITE IT
		array( '87.6.0.0', '87.7.255.255' ),
		// # Telecom Italia S.p.A. TIN EASY LITE IT
		array( '87.8.0.0', '87.9.255.255' ),
		// # Telecom Italia S.p.A. TIN EASY LITE IT
		array( '87.10.0.0', '87.11.255.255' ),
		// # Telecom Italia S.p.A. TIN EASY LITE IT
		array( '87.13.128.0', '87.13.255.255' ),
		// # Telecom Italia S.p.A. TIN EASY LITE IT
		array( '87.14.0.0', '87.15.255.255' ),
		// # Telecom Italia S.p.A. TIN EASY LITE IT
		array( '87.16.0.0', '87.17.255.255' ),
		// # Telecom Italia S.p.A. TIN EASY LITE IT
		array( '87.18.0.0', '87.19.255.255' ),
		// # Telecom Italia S.p.A. TIN EASY LITE IT
		array( '87.20.0.0', '87.20.255.255' ),
		// # Telecom Italia S.p.A. TIN EASY LITE IT
		array( '87.21.0.0', '87.21.255.255' ),
		// # Telecom Italia S.p.A. TIN EASY LITE IT
		array( '87.23.0.0', '87.23.127.255' ),
		// # Telecom Italia S.p.A. TIN EASY LITE IT
		array( '87.29.0.0', '87.29.255.255' ),
		// # Telecom Italia S.p.A. IT
		array( '87.128.0.0', '87.159.255.255' ),
		// # Deutsche Telekom AG DE
		array( '87.160.0.0', '87.191.255.255' ),
		// # Deutsche Telekom AG DE
		array( '87.207.0.0', '87.207.255.255' ),
		// # UPC Polska Sp. z o.o. PL
		array( '88.32.0.0', '88.32.255.255' ),
		// # 088032006146 Telecom Italia SPA IT
		array( '88.34.0.0', '88.34.255.255' ),
		// # 088034012130 Telecom Italia SPA IT
		array( '88.36.0.0', '88.37.255.255' ),
		// # 088036130142 Telecom Italia SPA IT
		array( '88.44.0.0', '88.45.255.255' ),
		// # 088045201166 Telecom Italia SPA IT
		array( '88.112.0.0', '88.115.255.255' ),
		// # Elisa Oyj FI
		array( '88.192.0.0', '88.195.255.255' ),
		// # Broadband access pool FI
		array( '89.27.0.0', '89.27.127.255' ),
		// # 089027055110 DNA Oy FI
		array( '89.76.0.0', '89.76.255.255' ),
		// # UPC Polska Sp. z o.o. PL
		array( '89.78.0.0', '89.78.255.255' ),
		// # UPC Polska Sp. z o.o. PL
		array( '89.79.0.0', '89.79.255.255' ),
		// # UPC Polska Sp. z o.o. PL
		array( '89.97.0.0', '89.97.255.255' ),
		// # UPC Polska Sp. z o.o. PL
		array( '89.101.0.0', '89.101.255.255' ),
		// # 089101227170 UPC Communications Ireland Limited IE
		array( '89.118.0.0', '89.118.255.255' ),
		// # MUSCIO DR. LUIGI IT
		array( '89.119.0.0', '89.119.255.255' ),
		// # AVITAS IT
		array( '89.171.0.0', '89.171.255.255' ),
		// # ALEJE JEROZOLIMSKIE 65 PL
		array( '90.224.0.0', '90.239.255.255' ),
		// # Telia Network Services SE
		array( '91.0.0.0', '91.63.255.255' ),
		// # Deutsche Telekom AG DE
		array( '91.64.128.0', '91.64.255.255' ),
		// # 091064193230 Kabel Deutschland Breitband Customer 12 DE
		array( '91.66.0.0', '91.66.127.255' ),
		// # 091066068247 Kabel Deutschland Breitband Customer 13 DE
		array( '91.67.0.0', '91.67.127.255' ),
		// # 091067038208 Kabel Deutschland Breitband Customer 14 DE
		array( '91.81.0.0', '91.81.127.255' ),
		// # IP addresses assigned to first D... IT
		array( '91.152.0.0', '91.159.255.255' ),
		// # Elisa Oyj FI
		array( '91.227.220.0', '91.227.223.255' ),
		// # VooServers Ltd GB
		array( '91.228.0.0', '91.228.3.255' ),
		// # Netco Solutions Ltd GB
		array( '91.238.214.0', '91.238.215.255' ),
		// # Privax Limited GB
		array( '91.252.0.0', '91.252.127.255' ),
		// # UMTS company IT
		array( '91.253.0.0', '91.253.255.255' ),
		// # UMTS company IT
		array( '92.0.0.0', '92.1.255.255' ),
		// # 092000043014 Carphone Warehouse Broadband Services GB
		array( '92.10.0.0', '92.11.255.255' ),
		// # 092010198217 Carphone Warehouse Broadband Services GB
		array( '92.22.0.0', '92.23.255.255' ),
		// # 092023135207 Carphone Warehouse Broadband Services GB
		array( '92.208.0.0', '92.211.255.255' ),
		// # Vodafone GmbH DE
		array( '92.232.0.0', '92.239.255.255' ),
		// # BRADFORD GB
		array( '93.32.0.0', '93.35.255.255' ),
		// # 093035081086 Infrastructure for Fastwebs main location IT
		array( '93.36.0.0', '93.39.255.255' ),
		// # 093037142167 Infrastructure for Fastwebs main location IT
		array( '93.48.0.0', '93.55.255.255' ),
		// # PLUG-IN public subnet IT
		array( '93.56.0.0', '93.59.255.255' ),
		// # PAT/NAT IP addresses POP 2701 for IT
		array( '93.64.0.0', '93.64.255.255' ),
		// # IP addresses reserved to DSL sub... IT
		array( '93.70.0.0', '93.70.255.255' ),
		// # IP pool assigned to VF DSL customers IT
		array( '93.106.0.0', '93.106.255.255' ),
		// # TeliaSonera Finland Oyj FI
		array( '93.107.0.0', '93.107.255.255' ),
		// # Vodafone ISP IE
		array( '93.146.0.0', '93.146.255.255' ),
		// # IP addresses allocated to DSL cu... IT
		array( '93.148.0.0', '93.148.255.255' ),
		// # IP addresses allocated to DSL cu... IT
		array( '93.149.0.0', '93.149.255.255' ),
		// # IP addresses allocated to DSL cu... IT
		array( '93.150.0.0', '93.150.255.255' ),
		// # IP addresses allocated to DSL cu... IT
		array( '93.151.0.0', '93.151.127.255' ),
		// # IP addresses allocated to DSL cu... IT
		array( '93.192.0.0', '93.255.255.255' ),
		// # Deutsche Telekom AG DE
		array( '94.32.0.0', '94.39.255.255' ),
		// # Tiscali Italia S.P.A. IT
		array( '94.80.0.0', '94.81.255.255' ),
		// # Telecom Italia S.p.a. IT
		array( '94.86.0.0', '94.87.255.255' ),
		// # Telecom Italia SPA IT
		array( '94.88.0.0', '94.89.255.255' ),
		// # Telecom Italia S.p.a. IT
		array( '94.90.0.0', '94.91.255.255' ),
		// # Telecom Italia SPA IT
		array( '94.138.160.0', '94.138.191.255' ),
		// # Sed di Palmiero & C. snc IT
		array( '94.160.0.0', '94.160.255.255' ),
		// # UMTS Company IT
		array( '94.163.0.0', '94.163.255.255' ),
		// # UMTS Company IT
		array( '94.164.0.0', '94.164.255.255' ),
		// # UMTS Company IT
		array( '94.167.0.0', '94.167.255.255' ),
		// # UMTS Company IT
		array( '94.168.0.0', '94.175.255.255' ),
		// # HAYES GB
		array( '95.224.0.0', '95.227.255.255' ),
		// # Telecom Italia S.p.A. IT
		array( '95.228.0.0', '95.229.255.255' ),
		// # Telecom Italia S.p.A. IT
		array( '95.232.0.0', '95.233.255.255' ),
		// # Telecom Italia S.p.A. IT
		array( '95.234.0.0', '95.235.255.255' ),
		// # Telecom Italia S.p.A. IT
		array( '95.236.0.0', '95.237.255.255' ),
		// # Telecom Italia S.p.A. IT
		array( '95.238.0.0', '95.239.255.255' ),
		// # Telecom Italia S.p.A. IT
		array( '95.240.0.0', '95.240.255.255' ),
		// # Telecom Italia S.p.A. IT
		array( '95.241.0.0', '95.241.255.255' ),
		// # Telecom Italia S.p.A. IT
		array( '95.242.0.0', '95.243.255.255' ),
		// # Telecom Italia S.p.A. IT
		array( '95.244.0.0', '95.244.255.255' ),
		// # Telecom Italia S.p.A. IT
		array( '95.245.0.0', '95.245.255.255' ),
		// # Telecom Italia S.p.A. IT
		array( '95.246.0.0', '95.246.255.255' ),
		// # Telecom Italia S.p.A. IT
		array( '95.247.0.0', '95.247.255.255' ),
		// # Telecom Italia S.p.A. IT
		array( '95.248.0.0', '95.249.255.255' ),
		// # Telecom Italia S.p.A. IT
		array( '95.250.0.0', '95.251.255.255' ),
		// # Telecom Italia Wireline Services IT
		array( '95.252.0.0', '95.252.127.255' ),
		// # Telecom Italia Wireline Services IT
		array( '95.252.128.0', '95.252.255.255' ),
		// # Telecom Italia Wireline Services IT
		array( '95.254.0.0', '95.254.255.255' ),
		// # Telecom Italia Wireline Services IT
		array( '96.2.0.0', '96.3.255.255' ),
		// # Midcontinent Media, Inc. US
		array( '96.10.0.0', '96.11.255.255' ),
		// # Time Warner Cable Internet LLC US
		array( '96.18.0.0', '96.19.255.255' ),
		// # CABLE ONE, INC. US
		array( '96.20.0.0', '96.23.255.255' ),
		// # Le Groupe Videotron Ltee VL-21BL... US
		array( '96.24.0.0', '96.25.255.255' ),
		// # CLEAR WIRELESS LLC US
		array( '96.26.0.0', '96.26.255.255' ),
		// # CLEAR WIRELESS LLC US
		array( '96.28.0.0', '96.29.255.255' ),
		// # Time Warner Cable Internet LLC US
		array( '96.32.0.0', '96.39.255.255' ),
		// # Charter Communications US
		array( '96.40.0.0', '96.41.255.255' ),
		// # Charter Communications US
		array( '96.42.0.0', '96.42.255.255' ),
		// # Charter Communications US
		array( '96.48.0.0', '96.55.255.255' ),
		// # Shaw Communications Inc. CA
		array( '96.64.0.0', '96.127.255.255' ),
		// # 096088050177 Comcast IP Services, L.L.C. CABLE-1 (NET-96-64-0-0-1) US
		array( '96.127.0.0', '96.127.127.255' ),
		// # 096127048249 Amazon.com, Inc. US
		array( '96.224.0.0', '96.255.255.255' ),
		// # Verizon Online LLC US
		array( '97.64.128.0', '97.64.255.255' ),
		// # Mediacom Communications Corporation US
		array( '97.66.0.0', '97.67.255.255' ),
		// # Earthlink, Inc. NETBLCK-ITCD-7 (... US
		array( '97.68.0.0', '97.71.255.255' ),
		// # 097071056080 BRIGHT HOUSE NETWORKS, LLC MTA-7 (NET-97-68-0-0-1) US
		array( '97.72.0.0', '97.73.255.255' ),
		// # Hughes Network Systems US
		array( '97.76.0.0', '97.79.255.255' ),
		// # Time Warner Cable Internet LLC US
		array( '97.80.0.0', '97.95.255.255' ),
		// # Charter Communications US
		array( '97.96.0.0', '97.103.255.255' ),
		// # Time Warner Cable Internet LLC US
		array( '97.104.0.0', '97.105.255.255' ),
		// # Time Warner Cable Internet LLC US
		array( '97.106.0.0', '97.106.255.255' ),
		// # Time Warner Cable Internet LLC US
		array( '97.112.0.0', '97.127.255.255' ),
		// # Qwest Communications Company, LLC US
		array( '97.128.0.0', '97.255.255.255' ),
		// # Cellco Partnership DBA Verizon W... US
		array( '98.0.0.0', '98.15.255.255' ),
		// # 098014074165 Time Warner Cable Internet LLC US
		array( '98.16.0.0', '98.23.255.255' ),
		// # Windstream Communications Inc US
		array( '98.24.0.0', '98.31.255.255' ),
		// # Time Warner Cable Internet LLC US
		array( '98.64.0.0', '98.95.255.255' ),
		// # BellSouth.net Inc. BELLSNET-BLK1... US
		array( '98.100.0.0', '98.103.255.255' ),
		// # Time Warner Cable Internet LLC US
		array( '98.108.0.0', '98.111.255.255' ),
		// # Verizon Online LLC US
		array( '98.112.0.0', '98.119.255.255' ),
		// # Verizon Online LLC US
		array( '98.120.0.0', '98.123.255.255' ),
		// # Time Warner Cable Internet LLC US
		array( '98.127.0.0', '98.127.255.255' ),
		// # Charter Communications US
		array( '98.144.0.0', '98.151.255.255' ),
		// # Time Warner Cable Internet LLC US
		array( '98.152.0.0', '98.155.255.255' ),
		// # Time Warner Cable Internet LLC US
		array( '98.156.0.0', '98.157.255.255' ),
		// # Time Warner Cable Internet LLC US
		array( '98.160.0.0', '98.191.255.255' ),
		// # Cox Communications Inc. CXA (NET... US
		array( '98.192.0.0', '98.255.255.255' ),
		// # Comcast Cable Communications, In... US
		array( '99.0.0.0', '99.127.255.255' ),
		// # AT&T Internet Services US
		array( '99.128.0.0', '99.191.255.255' ),
		// # AT&T Internet Services US
		array( '99.194.0.0', '99.195.255.255' ),
		// # CenturyTel Internet Holdings, Inc. US
		array( '99.196.0.0', '99.197.255.255' ),
		// # 099196062233 Viasat Communications Inc. US
		array( '99.198.64.0', '99.198.95.255' ),
		// # 099197219242 Viasat Communications Inc. US
		array( '99.224.0.0', '99.255.255.255' ),
		// # Rogers Cable Communications Inc.... US
		array( '100.0.0.0', '100.31.255.255' ),
		// # Verizon Online LLC US
		array( '100.32.0.0', '100.39.255.255' ),
		// # Verizon Online LLC US
		array( '100.40.0.0', '100.41.255.255' ),
		// # Verizon Online LLC US
		array( '100.42.240.0', '100.42.255.255' ),
		// # EastLink EASTLINK-BLK11 (NET-100... US
		array( '101.103.0.0', '101.103.255.255' ),
		// # Telstra AU
		array( '101.112.0.0', '101.119.255.255' ),
		// # 101114034096 VODAFONE AUSTRALIA PTY LIMITED AU
		array( '101.160.0.0', '101.191.255.255' ),
		// # Telstra AU
		array( '103.15.245.0', '103.15.245.255' ),
		// # Summit Communications Limited BD
		array( '103.31.4.0', '103.31.7.255' ),
		// # CLOUDFLARE SYDNEY, LLC AU
		array( '104.0.0.0', '104.15.255.255' ),
		// # AT&T Internet Services US
		array( '104.32.0.0', '104.35.255.255' ),
		// # Time Warner Cable Internet LLC US
		array( '104.37.200.0', '104.37.207.255' ),
		// # COGECO Cable Canada Inc. COQB (N... US
		array( '104.40.0.0', '104.47.255.255' ),
		// # Microsoft Corporation US
		array( '104.48.0.0', '104.63.255.255' ),
		// # AT&T Internet Services US
		array( '104.138.0.0', '104.139.255.255' ),
		// # Time Warner Cable Internet LLC US
		array( '104.148.128.0', '104.148.255.255' ),
		// # Optimum Online NETBLK-OOL-12BLK ... US
		array( '104.154.0.0', '104.155.255.255' ),
		// # Google Inc. US
		array( '104.159.128.0', '104.159.255.255' ),
		// # Charter Communications US
		array( '104.162.0.0', '104.162.255.255' ),
		// # Time Warner Cable Internet LLC US
		array( '104.169.0.0', '104.169.255.255' ),
		// # Frontier Communications of Ameri... US
		array( '104.172.0.0', '104.175.255.255' ),
		// # Time Warner Cable Internet LLC US
		array( '104.176.0.0', '104.191.255.255' ),
		// # AT&T Internet Services SIS-80-7-... US
		array( '104.192.116.0', '104.192.119.255' ),
		// # Cable Axion Digitel Inc. CA
		array( '104.196.0.0', '104.199.255.255' ),
		// # 104197002218 Google Inc. US
		array( '104.208.0.0', '104.215.255.255' ),
		// # 104209041198 Microsoft Corporation US
		array( '104.219.52.0', '104.219.55.255' ),
		// # 104219053022 Atlantic.net, Inc. ICC-ATLANTIC-4 (NET-104-219-52-0-1) US
		array( '104.221.0.0', '104.221.127.255' ),
		// # 104221120026 Le Groupe Videotron Ltee VL-34BL (NET-104-221-0-0-1) US
		array( '104.228.0.0', '104.229.255.255' ),
		// # Time Warner Cable Internet LLC US
		array( '104.230.0.0', '104.231.255.255' ),
		// # 104231007230 Time Warner Cable Internet LLC US
		array( '104.244.68.0', '104.244.71.255' ),
		// # 104244070104 Cable Axion Digitel Inc. CAXD-BLK14 (NET-104-244-68-0-1) US
		array( '104.245.152.0', '104.245.159.255' ),
		// # 104245156218 COGECO Cable Canada Inc. COQB (NET-104-245-152-0-1) US
		array( '106.68.0.0', '106.69.255.255' ),
		// # iiNet Limited AU
		array( '107.0.0.0', '107.3.255.255' ),
		// # Comcast Cable Communications, Inc. US
		array( '107.4.0.0', '107.4.127.255' ),
		// # 107004056197 Comcast Cable Communications, Inc. MICHIGAN-47 (NET-107-4-0-0-1) US
		array( '107.4.128.0', '107.4.255.255' ),
		// # Comcast Cable Communications, In... US
		array( '107.7.0.0', '107.7.255.255' ),
		// # Earthlink, Inc. NETBLCK-ITCD-7 (... US
		array( '107.8.0.0', '107.15.255.255' ),
		// # Time Warner Cable Internet LLC US
		array( '107.20.0.0', '107.23.255.255' ),
		// # Amazon.com, Inc. US
		array( '107.64.0.0', '107.127.255.255' ),
		// # AT&T Mobility LLC US
		array( '107.128.0.0', '107.143.255.255' ),
		// # AT&T Internet Services US
		array( '107.144.0.0', '107.147.255.255' ),
		// # BRIGHT HOUSE NETWORKS, LLC US
		array( '107.167.160.0', '107.167.191.255' ),
		// # Google Inc. US
		array( '107.171.128.0', '107.171.255.255' ),
		// # Le Groupe Videotron Ltee VL-32BL... US
		array( '107.178.192.0', '107.178.255.255' ),
		// # Google Inc. US
		array( '107.184.0.0', '107.185.255.255' ),
		// # Time Warner Cable Internet LLC US
		array( '107.188.0.0', '107.188.127.255' ),
		// # Optimum WiFi US
		array( '107.188.128.0', '107.188.255.255' ),
		// # Google Fiber Inc. GOOGLE-FIBER (... US
		array( '107.192.0.0', '107.223.255.255' ),
		// # AT&T Internet Services US
		array( '107.224.0.0', '107.255.255.255' ),
		// # 107227042019 AT&T Mobility LLC US
		array( '108.0.0.0', '108.31.255.255' ),
		// # Verizon Online LLC US
		array( '108.32.0.0', '108.47.255.255' ),
		// # Verizon Online LLC US
		array( '108.48.0.0', '108.55.255.255' ),
		// # Verizon Online LLC US
		array( '108.56.0.0', '108.57.255.255' ),
		// # 108056142148 Verizon Online LLC US
		array( '108.59.80.0', '108.59.95.255' ),
		// # Google Inc. US
		array( '108.59.240.0', '108.59.255.255' ),
		// # Earthlink, Inc. EARTHLINK-BUSINE... US
		array( '108.60.128.0', '108.60.159.255' ),
		// # Atlantic Metro Communications US
		array( '108.64.0.0', '108.95.255.255' ),
		// # AT&T Internet Services US
		array( '108.96.0.0', '108.127.255.255' ),
		// # Sprint Nextel Corporation US
		array( '108.131.0.0', '108.131.127.255' ),
		// # JAN ADSL CBB BLS-108-131-0-0-17-... US
		array( '108.132.0.0', '108.133.255.255' ),
		// # MIA ADSL CBB BLS-108-132-0-0-15-... US
		array( '108.162.64.0', '108.162.127.255' ),
		// # Cogeco Cable Inc. CGOC-14BLK (NE... US
		array( '108.162.128.0', '108.162.191.255' ),
		// # 108162144119 TekSavvy Solutions Inc. CA
		array( '108.162.192.0', '108.162.255.255' ),
		// # CloudFlare, Inc. US
		array( '108.169.0.0', '108.169.127.255' ),
		// # 108169008036 SONIC.NET, INC. US
		array( '108.176.0.0', '108.176.127.255' ),
		// # Time Warner Cable Internet LLC US
		array( '108.178.128.0', '108.178.191.255' ),
		// # Time Warner Cable Internet LLC US
		array( '108.182.0.0', '108.183.255.255' ),
		// # Time Warner Cable Internet LLC US
		array( '108.184.0.0', '108.185.255.255' ),
		// # Time Warner Cable Internet LLC US
		array( '108.192.0.0', '108.255.255.255' ),
		// # AT&T Internet Services US
		array( '109.40.0.0', '109.47.255.255' ),
		// # Vodafone D2 GmbH DE
		array( '109.52.0.0', '109.53.255.255' ),
		// # Telecom Italia Mobile IT
		array( '109.55.0.0', '109.55.255.255' ),
		// # Telecom Italia Mobile IT
		array( '109.76.0.0', '109.77.255.255' ),
		// # 109076177189 Vodafone ISP IE
		array( '109.78.0.0', '109.79.255.255' ),
		// # Vodafone ISP IE
		array( '109.84.0.0', '109.85.255.255' ),
		// # 109084000155 Vodafone D2 GmbH DE
		array( '109.119.0.0', '109.119.255.255' ),
		// # 109119007210 IP addresses allocated for VF-IT customers IT
		array( '109.168.0.0', '109.168.127.255' ),
		// # DISTLINE DI FAVARO ROBERTO &C SNC IT
		array( '109.238.16.0', '109.238.31.255' ),
		// # Digitel static IP addresses pool IT
		array( '109.240.0.0', '109.240.255.255' ),
		// # TeliaSonera Finland Oyj FI
		array( '110.20.0.0', '110.23.255.255' ),
		// # OPTUS INTERNET - RETAIL AU
		array( '110.32.0.0', '110.33.255.255' ),
		// # 110032076218 OPTUS INTERNET - RETAIL AU
		array( '110.142.0.0', '110.143.255.255' ),
		// # Telstra AU
		array( '110.144.0.0', '110.151.255.255' ),
		// # Telstra AU
		array( '110.174.0.0', '110.175.255.255' ),
		// # TPG Internet Pty Ltd. AU
		array( '118.208.0.0', '118.211.255.255' ),
		// # iiNet Limited AU
		array( '120.16.0.0', '120.23.255.255' ),
		// # 120017053077 VODAFONE AUSTRALIA PTY LIMITED AU
		array( '120.144.0.0', '120.159.255.255' ),
		// # Telstra AU
		array( '121.44.0.0', '121.45.255.255' ),
		// # iiNet Limited AU
		array( '121.208.0.0', '121.223.255.255' ),
		// # Telstra Internet AU
		array( '122.104.0.0', '122.111.255.255' ),
		// # OPTUS INTERNET - RETAIL AU
		array( '123.208.0.0', '123.211.255.255' ),
		// # Telstra Internet AU
		array( '123.243.0.0', '123.243.255.255' ),
		// # TPG Internet Pty Ltd. AU
		array( '124.148.0.0', '124.149.255.255' ),
		// # iiNet Limited AU
		array( '124.150.0.0', '124.150.127.255' ),
		// # iiNet Limited AU
		array( '124.168.0.0', '124.168.255.255' ),
		// # iiNet Limited AU
		array( '124.170.0.0', '124.171.255.255' ),
		// # iiNet Limited AU
		array( '124.176.0.0', '124.191.255.255' ),
		// # Telstra Internet AU
		array( '128.65.112.0', '128.65.127.255' ),
		// # REPARK SRL IT
		array( '128.143.0.0', '128.143.255.255' ),
		// # University of Virginia US
		array( '130.25.0.0', '130.25.255.255' ),
		// # IP addresses assigned for VF DSL... IT
		array( '130.211.0.0', '130.211.255.255' ),
		// # Google Inc. US
		array( '130.222.0.0', '130.222.255.255' ),
		// # 130222010194 Planning Research Corporation US
		array( '131.107.0.0', '131.107.255.255' ),
		// # Microsoft Corporation US
		array( '131.116.0.0', '131.116.255.255' ),
		// # TeliaSonera AB SE
		array( '134.228.0.0', '134.228.255.255' ),
		// # 134228095147 Buckeye Cablevision, Inc. US
		array( '135.23.0.0', '135.23.255.255' ),
		// # TekSavvy Solutions Inc. CA
		array( '137.116.0.0', '137.116.255.255' ),
		// # Microsoft Corp US
		array( '137.117.0.0', '137.117.255.255' ),
		// # Microsoft Corp US
		array( '137.135.0.0', '137.135.255.255' ),
		// # Microsoft Corp US
		array( '137.147.0.0', '137.147.255.255' ),
		// # Telstra Internet AU
		array( '137.175.128.0', '137.175.255.255' ),
		// # Le Groupe Videotron Ltee VL-30BL... US
		array( '138.91.0.0', '138.91.255.255' ),
		// # Microsoft Corp US
		array( '138.162.0.0', '138.162.255.255' ),
		// # 138162000041 Navy Network Information Center (NNIC) US
		array( '138.229.128.0', '138.229.255.255' ),
		// # Charter Communications US
		array( '139.130.0.0', '139.130.255.255' ),
		// # Telstra Internet AU
		array( '139.168.0.0', '139.168.255.255' ),
		// # Telstra Internet AU
		array( '141.101.70.0', '141.101.70.255' ),
		// # CloudFlare CDN network EU
		array( '141.101.80.0', '141.101.87.255' ),
		// # CloudFlare CDN network EU
		array( '141.101.88.0', '141.101.95.255' ),
		// # CloudFlare CDN network EU
		array( '141.101.96.0', '141.101.103.255' ),
		// # CloudFlare CDN network EU
		array( '141.101.104.0', '141.101.111.255' ),
		// # CloudFlare CDN network EU
		array( '142.105.0.0', '142.105.255.255' ),
		// # Time Warner Cable Internet LLC US
		array( '142.129.0.0', '142.129.255.255' ),
		// # Time Warner Cable Internet LLC US
		array( '142.255.0.0', '142.255.127.255' ),
		// # Time Warner Cable Internet LLC US
		array( '144.131.0.0', '144.131.255.255' ),
		// # Telstra Internet AU
		array( '144.132.0.0', '144.132.255.255' ),
		// # Telstra Internet AU
		array( '144.172.128.0', '144.172.255.255' ),
		// # 144172236206 Le Groupe Videotron Ltee VL-33BL (NET-144-172-128-0-1) US
		array( '146.60.0.0', '146.60.255.255' ),
		// # Vodafone D2 GmbH DE
		array( '146.115.0.0', '146.115.255.255' ),
		// # RCN US
		array( '146.148.0.0', '146.148.127.255' ),
		// # Google Inc. US
		array( '147.69.0.0', '147.69.255.255' ),
		// # Telstra Internet AU
		array( '149.135.0.0', '149.135.255.255' ),
		// # Telstra Internet AU
		array( '149.254.0.0', '149.254.255.255' ),
		// # T-Mobile(UK) PAT Barnsley GB
		array( '151.0.0.0', '151.255.255.255' ),
		// # RIPE Network Coordination Centre... US
		array( '151.21.0.0', '151.21.255.255' ),
		// # WIND Telecomunicazioni S.p.A IT
		array( '151.33.0.0', '151.33.255.255' ),
		// # IUNET IT
		array( '151.40.0.0', '151.40.255.255' ),
		// # IUNET IT
		array( '151.49.0.0', '151.49.255.255' ),
		// # WIND Telecomunicazioni S.p.A IT
		array( '151.51.0.0', '151.51.255.255' ),
		// # WIND Telecomunicazioni S.p.A IT
		array( '151.56.0.0', '151.56.255.255' ),
		// # IUnet IT
		array( '151.70.0.0', '151.70.255.255' ),
		// # WIND Telecomunicazioni S.p.A IT
		array( '151.74.0.0', '151.74.255.255' ),
		// # WIND Telecomunicazioni S.p.A IT
		array( '155.70.0.0', '155.70.255.255' ),
		// # Qwest Corporation US
		array( '155.143.0.0', '155.143.127.255' ),
		// # Telstra Internet AU
		array( '156.54.0.0', '156.54.255.255' ),
		// # 156054075113 Telecom Italia S.p.A. IT
		array( '157.54.0.0', '157.55.255.255' ),
		// # Microsoft Corporation US
		array( '157.60.0.0', '157.60.255.255' ),
		// # Microsoft Corporation US
		array( '158.106.64.0', '158.106.127.255' ),
		// # COGECODATA CDSI (NET-158-106-64-0-1) US
		array( '158.148.0.0', '158.148.255.255' ),
		// # Telecom Italia Mobile IT
		array( '159.118.0.0', '159.118.255.255' ),
		// # CABLE ONE, INC. US
		array( '159.205.0.0', '159.205.255.255' ),
		// # Netia SA PL
		array( '160.81.0.0', '160.81.255.255' ),
		// # Sprint US
		array( '162.17.0.0', '162.17.63.255' ),
		// # Comcast Business Communications,... US
		array( '162.17.128.0', '162.17.159.255' ),
		// # Comcast Business Communications,... US
		array( '162.17.192.0', '162.17.223.255' ),
		// # Comcast Business Communications,... US
		array( '162.17.224.0', '162.17.255.255' ),
		// # Comcast Business Communications,... US
		array( '162.39.0.0', '162.39.255.255' ),
		// # Windstream Communications Inc US
		array( '162.40.0.0', '162.40.255.255' ),
		// # Windstream Communications Inc US
		array( '162.72.0.0', '162.72.255.255' ),
		// # Viasat Communications Inc. US
		array( '162.104.0.0', '162.104.255.255' ),
		// # Embarq Corporation US
		array( '162.192.0.0', '162.207.255.255' ),
		// # AT&T Internet Services US
		array( '162.210.104.0', '162.210.111.255' ),
		// # Hot Spot Broadband, Inc. US
		array( '162.212.8.0', '162.212.11.255' ),
		// # 162212010167 Cable Axion Digitel Inc. CAXD-BLK8 (NET-162-212-8-0-1) US
		array( '162.222.176.0', '162.222.183.255' ),
		// # Google Inc. US
		array( '162.224.0.0', '162.239.255.255' ),
		// # AT&T Internet Services US
		array( '162.247.92.0', '162.247.95.255' ),
		// # 162247093036 Cable Axion Digitel Inc. CAXD-BLK11 (NET-162-247-92-0-1) US
		array( '164.109.0.0', '164.109.255.255' ),
		// # 164109048031 MCI Communications Services, Inc. d/b/a Verizon Business US
		array( '166.102.0.0', '166.102.255.255' ),
		// # Windstream Communications Inc US
		array( '167.206.0.0', '167.206.255.255' ),
		// # Cablevision Systems Corp. CVNET ... US
		array( '168.61.0.0', '168.61.255.255' ),
		// # Microsoft Corp US
		array( '168.62.0.0', '168.63.255.255' ),
		// # Microsoft Corp US
		array( '169.130.0.0', '169.130.255.255' ),
		// # PaeTec Communications, Inc. US
		array( '172.0.0.0', '172.15.255.255' ),
		// # AT&T Internet Services US
		array( '172.32.0.0', '172.63.255.255' ),
		// # T-Mobile USA, Inc. US
		array( '172.242.0.0', '172.243.255.255' ),
		// # Viasat Communications Inc. US
		array( '172.248.0.0', '172.251.255.255' ),
		// # Time Warner Cable Internet LLC US
		array( '172.254.0.0', '172.254.255.255' ),
		// # 172254047163 Time Warner Cable Internet LLC US
		array( '173.2.0.0', '173.3.255.255' ),
		// # Optimum Online CVISP (NET-173-2-... US
		array( '173.4.0.0', '173.7.255.255' ),
		// # Sprint Nextel Corporation US
		array( '173.8.0.0', '173.15.255.255' ),
		// # Comcast Business Communications,... US
		array( '173.16.0.0', '173.31.255.255' ),
		// # Mediacom Communications Corp US
		array( '173.32.0.0', '173.35.255.255' ),
		// # Rogers Cable Communications Inc. CA
		array( '173.34.76.0', '173.34.77.255' ),
		// # Rogers Cable Inc. HNSN HSI (NET-... US
		array( '173.44.64.0', '173.44.127.255' ),
		// # MetroCast Cablevision of New Ham... US
		array( '173.48.0.0', '173.63.255.255' ),
		// # Verizon Online LLC US
		array( '173.64.0.0', '173.79.255.255' ),
		// # Verizon Online LLC US
		array( '173.84.0.0', '173.87.255.255' ),
		// # Frontier Communications of Ameri... US
		array( '173.88.0.0', '173.95.255.255' ),
		// # Time Warner Cable Internet LLC US
		array( '173.128.0.0', '173.159.255.255' ),
		// # 173148139112 Sprint Nextel Corporation US
		array( '173.160.0.0', '173.167.255.255' ),
		// # Comcast Business Communications,... US
		array( '173.168.0.0', '173.175.255.255' ),
		// # Time Warner Cable Internet LLC US
		array( '173.176.0.0', '173.179.255.255' ),
		// # Le Groupe Videotron Ltee VL-23BL... US
		array( '173.184.0.0', '173.191.255.255' ),
		// # Windstream Communications Inc US
		array( '173.194.0.0', '173.194.255.255' ),
		// # Google Inc. US
		array( '173.196.0.0', '173.197.255.255' ),
		// # 173197089060 Time Warner Cable Internet LLC US
		array( '173.198.0.0', '173.198.127.255' ),
		// # Time Warner Cable Internet LLC US
		array( '173.198.128.0', '173.198.159.255' ),
		// # Time Warner Cable Internet LLC US
		array( '173.210.0.0', '173.210.127.255' ),
		// # Earthlink, Inc. ONECOM-173-210 (... US
		array( '173.221.0.0', '173.221.255.255' ),
		// # Windstream Nuvox, Inc. US
		array( '173.228.0.0', '173.228.127.255' ),
		// # SONIC.NET, INC. US
		array( '173.238.0.0', '173.238.255.255' ),
		// # Cogeco Cable Inc. CGOC-11BLK (NE... US
		array( '173.239.128.0', '173.239.191.255' ),
		// # Rogers Cable Communications Inc.... US
		array( '173.245.48.0', '173.245.63.255' ),
		// # CloudFlare, Inc. US
		array( '173.255.112.0', '173.255.127.255' ),
		// # 173255115054 Google Inc. US
		array( '174.0.0.0', '174.7.255.255' ),
		// # Shaw Communications Inc. CA
		array( '174.16.0.0', '174.31.255.255' ),
		// # Qwest Communications Company, LLC US
		array( '174.32.0.0', '174.33.255.255' ),
		// # 174032138254 Hughes Network Systems US
		array( '174.44.0.0', '174.44.255.255' ),
		// # Optimum Online NETBLK-OOL-1TBLK ... US
		array( '174.45.0.0', '174.45.255.255' ),
		// # Charter Communications US
		array( '174.48.0.0', '174.63.255.255' ),
		// # Comcast Cable Communications, In... US
		array( '174.64.0.0', '174.79.255.255' ),
		// # Cox Communications Inc. CXA (NET... US
		array( '174.88.0.0', '174.95.255.255' ),
		// # Bell Canada BELLCANADA-19 (NET-1... US
		array( '174.96.0.0', '174.111.255.255' ),
		// # Time Warner Cable Internet LLC US
		array( '174.112.0.0', '174.119.255.255' ),
		// # Rogers Cable Communications Inc. CA
		array( '174.124.0.0', '174.125.255.255' ),
		// # CenturyTel Internet Holdings, Inc. US
		array( '174.126.0.0', '174.126.255.255' ),
		// # CABLE ONE, INC. US
		array( '174.129.0.0', '174.129.255.255' ),
		// # Amazon.com, Inc. US
		array( '174.130.0.0', '174.131.255.255' ),
		// # Windstream Communications Inc US
		array( '174.134.0.0', '174.135.255.255' ),
		// # BRIGHT HOUSE NETWORKS, LLC MTA-1... US
		array( '174.138.192.0', '174.138.223.255' ),
		// # DISTRIBUTEL COMMUNICATIONS LTD. ... US
		array( '174.140.112.0', '174.140.127.255' ),
		// # 174140120189 Atlantic Broadband Finance, LLC JST-PA-174-140-112-0 (NET-174-140-112-0-1) US
		array( '174.144.0.0', '174.159.255.255' ),
		// # Sprint Nextel Corporation SPRINT... US
		array( '174.186.0.0', '174.186.255.255' ),
		// # Comcast Cable Communications, LL... US
		array( '174.192.0.0', '174.255.255.255' ),
		// # Cellco Partnership DBA Verizon W... US
		array( '175.32.0.0', '175.39.255.255' ),
		// # OPTUS INTERNET - RETAIL AU
		array( '176.34.0.0', '176.34.255.255' ),
		// # Amazon Data Services Ireland Ltd IE
		array( '176.61.64.0', '176.61.127.255' ),
		// # Customers IE IE
		array( '176.200.0.0', '176.200.255.255' ),
		// # Telecom Italia Mobile IT
		array( '176.244.0.0', '176.247.255.255' ),
		// # IP addresses assigned for VF cus... IT
		array( '178.0.0.0', '178.15.255.255' ),
		// # Vodafone D2 GmbH DE
		array( '178.24.0.0', '178.24.127.255' ),
		// # Kabel Deutschland Breitband Cust... DE
		array( '178.25.0.0', '178.25.127.255' ),
		// # 178025041234 Kabel Deutschland Breitband Customer 22 DE
		array( '178.36.0.0', '178.37.255.255' ),
		// # Netia SA PL
		array( '178.180.0.0', '178.181.255.255' ),
		// # 178181015073 blueconnect PL
		array( '178.182.0.0', '178.182.255.255' ),
		// # 178182112171 blueconnect PL
		array( '178.183.160.0', '178.183.191.255' ),
		// # 178183180129 BRAS user pool PL
		array( '180.200.128.0', '180.200.191.255' ),
		// # 180200153147 iiNet Limited AU
		array( '181.224.144.0', '181.224.151.255' ),
		// # SiteGround Inc. US
		array( '184.0.0.0', '184.7.255.255' ),
		// # Embarq Corporation US
		array( '184.8.0.0', '184.15.255.255' ),
		// # Frontier Communications of Ameri... US
		array( '184.16.0.0', '184.19.255.255' ),
		// # Frontier Communications of Ameri... US
		array( '184.20.0.0', '184.21.255.255' ),
		// # Viasat Communications Inc. US
		array( '184.32.0.0', '184.47.255.255' ),
		// # BellSouth.net Inc. BELLSNET-BLK2... US
		array( '184.56.0.0', '184.59.255.255' ),
		// # Time Warner Cable Internet LLC US
		array( '184.62.0.0', '184.63.255.255' ),
		// # Viasat Communications Inc. US
		array( '184.64.0.0', '184.71.255.255' ),
		// # Shaw Communications Inc. CA
		array( '184.72.0.0', '184.73.255.255' ),
		// # Amazon.com, Inc. US
		array( '184.76.0.0', '184.79.255.255' ),
		// # CLEAR WIRELESS LLC US
		array( '184.88.0.0', '184.91.255.255' ),
		// # Time Warner Cable Internet LLC US
		array( '184.96.0.0', '184.103.255.255' ),
		// # Qwest Communications Company, LLC US
		array( '184.144.0.0', '184.151.255.255' ),
		// # Bell Canada BELLCANADA-20 (NET-1... US
		array( '184.147.40.0', '184.147.43.255' ),
		// # Sympatico HSE HSE11-DYNAMIC-2011... US
		array( '184.151.0.0', '184.151.63.255' ),
		// # Bell Mobility, Inc. BEL12-02932-... US
		array( '184.152.0.0', '184.153.255.255' ),
		// # Time Warner Cable Internet LLC US
		array( '184.155.0.0', '184.155.255.255' ),
		// # CABLE ONE, INC. US
		array( '184.156.0.0', '184.159.255.255' ),
		// # 184156028214 CenturyTel Internet Holdings, Inc. US
		array( '184.160.0.0', '184.163.255.255' ),
		// # Le Groupe Videotron Ltee VL-23BL... US
		array( '184.166.0.0', '184.167.255.255' ),
		// # Charter Communications US
		array( '184.169.128.0', '184.169.255.255' ),
		// # Amazon.com, Inc. US
		array( '184.176.0.0', '184.191.255.255' ),
		// # Cox Communications Inc. NET-184-... US
		array( '184.192.0.0', '184.255.255.255' ),
		// # Sprint Nextel Corporation US
		array( '185.17.156.0', '185.17.159.255' ),
		// # Dedicated servers IT
		array( '187.185.112.0', '187.185.127.255' ),
		// # 187185126004 Cablemas Telecomunicaciones SA de CV MX
		array( '187.185.184.0', '187.185.191.255' ),
		// # Cablemas Telecomunicaciones SA de CV MX
		array( '187.252.64.0', '187.252.95.255' ),
		// # 187252070046 Cablemas Telecomunicaciones SA de CV MX
		array( '187.252.208.0', '187.252.223.255' ),
		// # 187252219011 Cablemas Telecomunicaciones SA de CV MX
		array( '187.254.0.0', '187.254.255.255' ),
		// # Cablevision Red, S.A de C.V. MX
		array( '188.14.0.0', '188.14.255.255' ),
		// # Telecom Italia S.p.A. IT
		array( '188.68.224.0', '188.68.239.255' ),
		// # 188068224077 "Sprint" S.A. PL
		array( '188.114.96.0', '188.114.103.255' ),
		// # CloudFlare CDN network EU
		array( '188.114.104.0', '188.114.111.255' ),
		// # CloudFlare CDN network EU
		array( '188.152.0.0', '188.152.127.255' ),
		// # IP addresses allocated to DSL cu... IT
		array( '188.153.0.0', '188.153.255.255' ),
		// # IP addresses allocated to DSL cu... IT
		array( '188.216.0.0', '188.217.255.255' ),
		// # IP addresses allocated to DSL su... IT
		array( '189.214.32.0', '189.214.39.255' ),
		// # 189214032199 Cablemas Telecomunicaciones SA de CV MX
		array( '189.214.112.0', '189.214.119.255' ),
		// # 189214114096 Cablemas Telecomunicaciones SA de CV MX
		array( '189.215.40.0', '189.215.47.255' ),
		// # 189215046155 Cablemas Telecomunicaciones SA de CV MX
		array( '189.215.116.0', '189.215.119.255' ),
		// # 189215119120 Cablemas Telecomunicaciones SA de CV MX
		array( '189.215.160.0', '189.215.175.255' ),
		// # 189215164218 Cablemas Telecomunicaciones SA de CV MX
		array( '189.215.240.0', '189.215.243.255' ),
		// # 189215241178 Cablemas Telecomunicaciones SA de CV MX
		array( '189.220.32.0', '189.220.63.255' ),
		// # 189220037062 Cablemas Telecomunicaciones SA de CV MX
		array( '189.220.64.0', '189.220.79.255' ),
		// # Cablemas Telecomunicaciones SA de CV MX
		array( '189.220.240.0', '189.220.247.255' ),
		// # 189220245046 Cablemas Telecomunicaciones SA de CV MX
		array( '192.0.128.0', '192.0.255.255' ),
		// # TekSavvy Solutions Inc. CA
		array( '192.84.128.0', '192.84.143.255' ),
		// # INFN (National Institute of Nucl... IT
		array( '192.89.0.0', '192.89.255.255' ),
		// # IHA-Lines Oy Helsinki Cruises FI
		array( '192.92.208.0', '192.92.211.255' ),
		// # 192092211037 CLARKSVILLE DEPARTMENT OF ELECTRICITY US
		array( '192.158.28.0', '192.158.31.255' ),
		// # 192158029091 Google Inc. US
		array( '192.182.0.0', '192.183.255.255' ),
		// # Frontier Communications of Ameri... US
		array( '192.198.224.0', '192.198.239.255' ),
		// # 192198232094 Cleartalk US
		array( '193.66.0.0', '193.66.255.255' ),
		// # 193066174253 OP-Pohjola Group Central Cooperative FI
		array( '193.128.0.0', '193.131.255.255' ),
		// # 193128033248 MCAFEE GB
		array( '194.25.0.0', '194.25.255.255' ),
		// # logistic people (Deutschland) DE
		array( '194.86.0.0', '194.86.255.255' ),
		// # 194086153167 City of Helsinki FI
		array( '194.89.0.0', '194.89.255.255' ),
		// # Sonera Yritys Internet FI
		array( '194.111.0.0', '194.111.255.255' ),
		// # TeliaSonera Finland Oyj FI
		array( '194.168.0.0', '194.168.255.255' ),
		// # 194168079234 Virgin Media Limited GB
		array( '194.236.0.0', '194.237.255.255' ),
		// # Telia Network Services SE
		array( '194.243.0.0', '194.243.255.255' ),
		// # 194243198234 Telecom Italia SPA IT
		array( '195.31.0.0', '195.31.255.255' ),
		// # Telecom Italia SPA IT
		array( '195.43.160.0', '195.43.191.255' ),
		// # KPNQwest Italia Point-to-Point IT
		array( '195.103.0.0', '195.103.255.255' ),
		// # 195103253082 Telecom Italia SPA IT
		array( '195.120.0.0', '195.120.255.255' ),
		// # 195120207078 Telecom Italia SPA IT
		array( '195.232.128.0', '195.232.255.255' ),
		// # 195232147119 Vodafone Group Services DE
		array( '198.0.0.0', '198.0.255.255' ),
		// # Comcast Business Communications,... US
		array( '198.41.128.0', '198.41.255.255' ),
		// # 198041232089 CloudFlare, Inc. US
		array( '198.45.128.0', '198.45.255.255' ),
		// # Viasat Communications Inc. US
		array( '198.48.128.0', '198.48.255.255' ),
		// # TekSavvy Solutions Inc. CA
		array( '198.72.128.0', '198.72.255.255' ),
		// # 198072192198 Time Warner Cable Internet LLC US
		array( '198.73.24.0', '198.73.27.255' ),
		// # 198073025228 Troy Cablevision, Inc. US
		array( '198.84.128.0', '198.84.255.255' ),
		// # 198084156019 TekSavvy Solutions Inc. CA
		array( '198.91.164.0', '198.91.165.255' ),
		// # 198091164078 DISTRIBUTEL COMMUNICATIONS LTD. DTEL-TORONTO-CMS-V4-04 (NET-198-91-164-0-1) US
		array( '198.91.168.0', '198.91.169.255' ),
		// # DISTRIBUTEL COMMUNICATIONS LTD. ... US
		array( '198.142.0.0', '198.142.255.255' ),
		// # 198142228008 imported inetnum object for OCPL AU
		array( '198.178.8.0', '198.178.15.255' ),
		// # Comcast Cable Communications US
		array( '198.179.64.0', '198.179.127.255' ),
		// # Time Warner Cable Internet LLC US
		array( '198.255.128.0', '198.255.255.255' ),
		// # 198255199245 Time Warner Cable Internet LLC US
		array( '199.27.128.0', '199.27.135.255' ),
		// # CloudFlare, Inc. US
		array( '199.30.16.0', '199.30.31.255' ),
		// # Microsoft Corp US
		array( '199.102.200.0', '199.102.207.255' ),
		// # Cable Axion Digitel Inc. CA
		array( '199.172.192.0', '199.172.255.255' ),
		// # Internet Bermuda Limited BERMUDA... US
		array( '199.188.76.0', '199.188.79.255' ),
		// # Stutler Technologies, Corp. US
		array( '199.255.88.0', '199.255.95.255' ),
		// # 199255095037 Frontier Telenet US
		array( '199.255.216.0', '199.255.223.255' ),
		// # EastLink EASTLINK-BLK13 (NET-199... US
		array( '201.141.128.0', '201.141.255.255' ),
		// # 201141156199 Cablevisión, S.A. de C.V. MX
		array( '201.160.224.0', '201.160.239.255' ),
		// # 201160236012 Cablemas Telecomunicaciones SA de CV MX
		array( '201.161.128.0', '201.161.191.255' ),
		// # 201161138018 Cablevision Red, S.A de C.V. MX
		array( '201.167.0.0', '201.167.127.255' ),
		// # 201167043030 Cablevision Red, S.A de C.V. MX
		array( '202.7.192.0', '202.7.223.255' ),
		// # TPG Internet Pty Ltd. AU
		array( '202.161.0.0', '202.161.31.255' ),
		// # 202161014220 iiNet Limited AU
		array( '202.173.128.0', '202.173.191.255' ),
		// # iiNet Limited AU
		array( '203.36.0.0', '203.39.255.255' ),
		// # 203037111122 Telstra Internet AU
		array( '203.40.0.0', '203.47.255.255' ),
		// # Telstra Internet AU
		array( '203.59.0.0', '203.59.255.255' ),
		// # 203059040250 iiNet Limited AU
		array( '203.87.0.0', '203.87.127.255' ),
		// # 203087012064 TPG Internet Pty Ltd. AU
		array( '203.113.192.0', '203.113.255.255' ),
		// # 203113201065 iiNet Limited AU
		array( '203.122.192.0', '203.122.255.255' ),
		// # iiNet Limited AU
		array( '203.191.192.0', '203.191.207.255' ),
		// # TPG Internet Pty Ltd. AU
		array( '203.206.0.0', '203.206.255.255' ),
		// # iiNet Limited AU
		array( '203.208.64.0', '203.208.127.255' ),
		// # 203208080044 iiNet Limited AU
		array( '203.213.0.0', '203.213.63.255' ),
		// # TPG Internet Pty Ltd. AU
		array( '203.214.0.0', '203.214.127.255' ),
		// # iiNet Limited AU
		array( '203.217.0.0', '203.217.31.255' ),
		// # iiNet Limited AU
		array( '203.217.32.0', '203.217.63.255' ),
		// # iiNet Limited AU
		array( '203.219.0.0', '203.219.255.255' ),
		// # 203219072015 TPG Internet Pty Ltd. AU
		array( '204.43.0.0', '204.43.255.255' ),
		// # WestNet, Inc. WESTNET-LRG1 (NET-... US
		array( '204.51.64.0', '204.51.127.255' ),
		// # 204051105204 TERRENAP DATA CENTERS, INC. TERRENAP-0-20 (NET-204-51-64-0-1) US
		array( '204.145.64.0', '204.145.95.255' ),
		// # Atlantic Metro Communications US
		array( '204.195.128.0', '204.195.143.255' ),
		// # 204195139006 Atlantic Broadband Finance, LLC JST-PA-204-195-128-0 (NET-204-195-128-0-2) US
		array( '204.210.0.0', '204.210.255.255' ),
		// # Time Warner Cable Internet LLC US
		array( '204.228.0.0', '204.229.255.255' ),
		// # WestNet, Inc. WESTNET-W4 (NET-20... US
		array( '204.236.128.0', '204.236.255.255' ),
		// # Amazon.com, Inc. US
		array( '205.178.0.0', '205.178.127.255' ),
		// # 205178076181 RCN US
		array( '205.240.0.0', '205.247.255.255' ),
		// # Sprint SPRINT-BLKF (NET-205-240-... US
		array( '205.251.192.0', '205.251.255.255' ),
		// # Amazon.com, Inc. US
		array( '206.47.0.0', '206.47.255.255' ),
		// # 206047113254 Bell Canada WORLDLINX03 (NET-206-47-0-0-1) US
		array( '206.71.224.0', '206.71.255.255' ),
		// # 206071245106 RCN US
		array( '206.206.0.0', '206.207.255.255' ),
		// # WestNet, Inc. WESTNET-W5 (NET-20... US
		array( '206.228.0.0', '206.231.255.255' ),
		// # 206229046052 Sprint SPRINTLINK-BLKQ (NET-206-228-0-0-1) US
		array( '207.8.128.0', '207.8.255.255' ),
		// # 207008234158 PaeTec Communications, Inc. US
		array( '207.10.0.0', '207.10.255.255' ),
		// # 207010206209 PaeTec Communications, Inc. PAETECCOMM (NET-207-10-0-0-1) US
		array( '207.30.0.0', '207.30.255.255' ),
		// # 207030129179 Embarq Corporation US
		array( '207.35.0.0', '207.35.255.255' ),
		// # Bell Canada GRICS01 (NET-207-35-... US
		array( '207.38.128.0', '207.38.255.255' ),
		// # RCN US
		array( '207.46.0.0', '207.46.255.255' ),
		// # Microsoft Corporation US
		array( '207.91.0.0', '207.91.63.255' ),
		// # Windstream Communications Inc US
		array( '207.96.128.0', '207.96.255.255' ),
		// # Videotron Telecom Ltee VTL-CIDR-... US
		array( '207.104.0.0', '207.105.255.255' ),
		// # AT&T Internet Services SBCIS-SIS... US
		array( '207.118.0.0', '207.119.255.255' ),
		// # CenturyTel Internet Holdings, Inc. US
		array( '207.172.0.0', '207.172.255.255' ),
		// # RCN US
		array( '207.181.192.0', '207.181.255.255' ),
		// # RCN US
		array( '207.191.0.0', '207.191.127.255' ),
		// # Xspedius Communications Co. US
		array( '207.224.0.0', '207.225.255.255' ),
		// # 207225198250 Qwest Communications Company, LLC US
		array( '207.236.0.0', '207.236.255.255' ),
		// # 207236155236 Bell Canada BELLGLOBAL-2 (NET-207-236-0-0-1) US
		array( '207.237.0.0', '207.237.255.255' ),
		// # RCN US
		array( '207.253.0.0', '207.253.255.255' ),
		// # Videotron Telecom Ltee VTL-CIDR-... US
		array( '207.255.0.0', '207.255.255.255' ),
		// # Atlantic Broadband Finance, LLC ... US
		array( '208.0.0.0', '208.63.255.255' ),
		// # Sprint SPRINTLINK-BLKS (NET-208-... US
		array( '208.54.0.0', '208.54.127.255' ),
		// # T-Mobile USA, Inc. US
		array( '208.58.0.0', '208.59.255.255' ),
		// # RCN US
		array( '208.70.24.0', '208.70.31.255' ),
		// # Internet Archive US
		array( '208.97.48.0', '208.97.63.255' ),
		// # 208097053253 Voonami, Inc. US
		array( '208.102.0.0', '208.102.255.255' ),
		// # Fuse Internet Access US
		array( '208.106.0.0', '208.106.127.255' ),
		// # SONIC.NET, INC. US
		array( '208.107.0.0', '208.107.255.255' ),
		// # Midcontinent Media, Inc. US
		array( '208.125.0.0', '208.125.255.255' ),
		// # Time Warner Cable Internet LLC US
		array( '208.192.0.0', '208.255.255.255' ),
		// # 208255153250 MCI Communications Services, Inc. d/b/a Verizon Business UUNET1996B (NET-208-192-0-0-1) US
		array( '209.6.0.0', '209.6.255.255' ),
		// # RCN US
		array( '209.17.128.0', '209.17.191.255' ),
		// # Bell Canada GT-PAC-BLK1 (NET-209... US
		array( '209.23.192.0', '209.23.255.255' ),
		// # Comcast Telecommunications, Inc.... US
		array( '209.36.0.0', '209.37.255.255' ),
		// # AT&T Services, Inc. WORLDNET-MIS... US
		array( '209.54.64.0', '209.54.79.255' ),
		// # 209054076016 COGECO Cable Canada Inc. COQB (NET-209-54-64-0-1) US
		array( '209.64.0.0', '209.65.255.255' ),
		// # AT&T Services, Inc. US
		array( '209.92.0.0', '209.92.255.255' ),
		// # PaeTec Communications, Inc. US
		array( '209.97.90.0', '209.97.91.255' ),
		// # 209097090075 New Wave Communications NEWWAVE-FAIRFIELD (NET-209-97-90-0-1) US
		array( '209.102.240.0', '209.102.255.255' ),
		// # Windstream Communications Inc US
		array( '209.139.208.0', '209.139.209.255' ),
		// # eSecureData GT-209-139-208-0-CX ... US
		array( '209.149.0.0', '209.149.255.255' ),
		// # BellSouth.net Inc. BELLSNET-BLK3... US
		array( '209.150.32.0', '209.150.63.255' ),
		// # RCN US
		array( '209.168.156.0', '209.168.159.255' ),
		// # Otelco ITCD-209-168-156-0 (NET-2... US
		array( '209.179.0.0', '209.179.255.255' ),
		// # 209179105067 Earthlink, Inc. EARTHLINK-RE-NET (NET-209-179-0-0-1) US
		array( '209.184.0.0', '209.184.255.255' ),
		// # AT&T Internet Services US
		array( '209.194.0.0', '209.194.255.255' ),
		// # Xspedius Communications Co. US
		array( '209.195.64.0', '209.195.127.255' ),
		// # 209195094069 DISTRIBUTEL COMMUNICATIONS LTD. NET-DTEL-V4-07 (NET-209-195-64-0-1) US
		array( '209.197.128.0', '209.197.191.255' ),
		// # DISTRIBUTEL COMMUNICATIONS LTD. ... US
		array( '209.203.192.0', '209.203.223.255' ),
		// # Atlantic Broadband Finance, LLC US
		array( '209.208.0.0', '209.208.127.255' ),
		// # Atlantic.net, Inc. ICC-1 (NET-20... US
		array( '209.242.128.0', '209.242.159.255' ),
		// # 209242141060 Cox Communications Inc. US
		array( '209.252.0.0', '209.255.255.255' ),
		// # PaeTec Communications, Inc. US
		array( '210.49.0.0', '210.49.255.255' ),
		// # 210049165239 OPTUS INTERNET - RETAIL AU
		array( '211.28.0.0', '211.31.255.255' ),
		// # OPTUS INTERNET - RETAIL AU
		array( '212.24.64.0', '212.24.95.255' ),
		// # Virgin Media Limited GB
		array( '212.82.96.0', '212.82.99.255' ),
		// # Yahoo!Europe GB
		array( '212.123.64.0', '212.123.95.255' ),
		// # Tiscali Italia SpA IT
		array( '212.131.0.0', '212.131.255.255' ),
		// # 212131000058 Telecom Italia S.p.a. IT
		array( '212.144.0.0', '212.144.255.255' ),
		// # 212144224058 Vodafone GmbH DE
		array( '212.183.128.0', '212.183.143.255' ),
		// # 212183140038 Vodafone Limited GB
		array( '212.184.0.0', '212.185.255.255' ),
		// # 212184137090 Deutsche Telekom AG DE
		array( '212.250.0.0', '212.250.255.255' ),
		// # 212250160178 OPTIC SERVERS LIMITED GB
		array( '213.17.128.0', '213.17.255.255' ),
		// # 213017182140 Przedsiebiorstwo Projektowo-Uslugowe BISPROL Sp. z o.o. PL
		array( '213.23.0.0', '213.23.255.255' ),
		// # Vodafone GmbH DE
		array( '213.26.0.0', '213.26.255.255' ),
		// # 213026038170 Telecom Italia SPA IT
		array( '213.48.128.0', '213.48.191.255' ),
		// # 213048137169 BIRMINGHAM GB
		array( '213.64.0.0', '213.67.255.255' ),
		// # Telia Network services SE
		array( '213.106.0.0', '213.106.127.255' ),
		// # Virgin Media Limited GB
		array( '213.106.128.0', '213.106.255.255' ),
		// # 213106205184 NTL BIA - Runcorn Cable Modem DHCP Pool GB
		array( '213.107.0.0', '213.107.127.255' ),
		// # Virgin Media Limited GB
		array( '213.107.128.0', '213.107.255.255' ),
		// # 213107190057 Virgin Media Limited GB
		array( '213.140.0.0', '213.140.15.255' ),
		// # 213140003158 Fastweb SpA IT
		array( '213.187.64.0', '213.187.95.255' ),
		// # loswebos.de DE
		array( '213.213.0.0', '213.213.63.255' ),
		// # MORANDI TAPPETI IT
		array( '213.217.128.0', '213.217.191.255' ),
		// # SABRINA ALESSIA GASPARINI IT
		array( '213.233.128.0', '213.233.159.255' ),
		// # Vodafone ISP Infrastructure IE
		array( '213.238.64.0', '213.238.127.255' ),
		// # ADSL BSA/LLU/EDA PL
		array( '213.241.0.0', '213.241.127.255' ),
		// # Webion Sp. z o.o. PL
		array( '213.255.0.0', '213.255.31.255' ),
		// # KIT PROJECT S.R.L. IT
		array( '213.255.64.0', '213.255.127.255' ),
		// # IMEPA SRL IT
		array( '215.0.0.0', '215.255.255.255' ),
		// # 215067002067 DoD Network Information Center US
		array( '216.15.0.0', '216.15.127.255' ),
		// # RCN US
		array( '216.18.0.0', '216.18.127.255' ),
		// # Bell Canada GT-NTL-BLK1 (NET-216... US
		array( '216.26.0.0', '216.26.63.255' ),
		// # 216026063014 Earthlink, Inc. US
		array( '216.26.64.0', '216.26.79.255' ),
		// # 216026063014 Earthlink, Inc. US
		array( '216.80.0.0', '216.80.127.255' ),
		// # RCN US
		array( '216.84.0.0', '216.85.255.255' ),
		// # 216084085245 Xspedius Communications Co. US
		array( '216.96.0.0', '216.96.127.255' ),
		// # Windstream Communications Inc WI... US
		array( '216.160.0.0', '216.161.255.255' ),
		// # 216160204153 Qwest Communications Company, LLC US
		array( '216.164.0.0', '216.164.255.255' ),
		// # RCN US
		array( '216.189.160.0', '216.189.191.255' ),
		// # Atlantic Broadband Finance, LLC ... US
		array( '216.224.128.0', '216.224.191.255' ),
		// # Earthlink, Inc. ELNK-CLOUD (NET-... US
		array( '216.228.208.0', '216.228.223.255' ),
		// # 216228222193 Cable Axion Digitel Inc. CA
		array( '216.235.64.0', '216.235.79.255' ),
		// # Netsonic US
		array( '216.246.224.0', '216.246.255.255' ),
		// # 216246235056 DISTRIBUTEL COMMUNICATIONS LTD. NET-DTEL-V4-02 (NET-216-246-224-0-1) US
		array( '216.255.96.0', '216.255.127.255' ),
		// # 216255126124 Cablevision Systems Corp. CVNET-2 (NET-216-255-96-0-1) US
		array( '217.0.0.0', '217.7.255.255' ),
		// # 217005170157 TSBS GmbH fuer Hako-Werke GmbH DE
		array( '217.73.208.0', '217.73.223.255' ),
		// # ISP IT
		array( '217.80.0.0', '217.95.255.255' ),
		// # Deutsche Telekom AG DE
		array( '217.133.0.0', '217.133.255.255' ),
		// # Tiscali Italia SpA IT
		array( '217.203.0.0', '217.203.255.255' ),
		// # Telecom Italia Mobile IT
		array( '217.204.0.0', '217.207.255.255' ),
		// # Daryl Wilcox Publishing GB
		array( '217.208.0.0', '217.215.255.255' ),
		// # Telia Network Services SE
		array( '217.220.0.0', '217.220.255.255' ),
		// # CIMA CABLAGGI SRL IT
		array( '217.221.0.0', '217.221.255.255' ),
		// # G.R. RICAMBI SRL IT
		array( '217.224.0.0', '217.255.255.255' ),
		// # Deutsche Telekom AG DE
		array( '219.90.128.0', '219.90.255.255' ),
		// # 219090163166 iiNet Limited AU
		array( '220.235.0.0', '220.235.255.255' ),
		// # 220235226061 iiNet Limited AU
		array( '220.236.0.0', '220.239.255.255' ),
		// # OPTUS INTERNET - RETAIL AU
		array( '220.244.0.0', '220.245.255.255' ),
		// # TPG Internet Pty Ltd. AU
		array( '220.253.0.0', '220.253.255.255' ),
		// # iiNet Limited AU
	);
}

?>