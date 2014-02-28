<?php
  	if(!$_SERVER['REMOTE_ADDR']){
		$_SERVER['REMOTE_ADDR'] = '';
  		define('DRUPAL_ROOT', '/var/www/webdev/drupal');
  		require_once (DRUPAL_ROOT.'/includes/bootstrap.inc');
  		drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);
  	}
?>

<div class="skip-link">
    <a href="#main-content" class="element-invisible element-focusable"><?php print t('Skip to main content'); ?></a>
</div>

<link rel="stylesheet" type="text/css" href="http://www.ncsu.edu/brand/utility-bar/iframe/css/utility_bar_iframe.css" media="screen" />
<iframe title="NC State Utility Links" name="ncsu_branding_bar" id="ncsu_branding_bar" frameborder="0" src="http://www.ncsu.edu/brand/utility-bar/iframe/index.php?color=red&amp;inurl=lib.ncsu.edu&amp;center=yes" scrolling="no">
	Your browser does not support inline frames or is currently configured  not to display inline frames.<br /> Visit <a href="http://ncsu.edu/">http://www.ncsu.edu</a>.
</iframe>


<header class="contain-to-grid">
	<nav class="top-bar">
		<ul class="title-area">
			<li class="name">
			  	<a href="//<?php echo $_SERVER['SERVER_NAME']; ?>" title="<?php print t('NCSU Library'); ?>" rel="home" id="logo">
					<img src="//<?php echo $_SERVER['SERVER_NAME']; ?>/sites/all/themes/ncsulib_foundation/images/ncsu-library-logo-white.png" alt="<?php print t('Home'); ?>" />
			  	</a>
			</li>
			<li id="nav-toggle" class="right-off-canvas-toggle">
				<a href="#"><i class="fa fa-bars"></i></a>
			</li>
			<li id="search-toggle">
				<a href="#"><i class="fa fa-search"></i></a>
			</li>
		</ul>

		<section class="top-bar-section primary-nav home">
			<?php include 'primary-nav.php'; ?>
		</section>
	</nav>

	<?php include 'mobile-nav.php'; ?>
</header>

<nav id="primary-nav-menus">
	<div id="menu-find" class="primary-menu-list" >
		<ul>
			<li><a href="//<?php echo $_SERVER['SERVER_NAME']; ?>/catalog">Books &amp; Media</a></li>
			<li><a href="//<?php echo $_SERVER['SERVER_NAME']; ?>/articles">Articles</a></li>
			<li><a href="//<?php echo $_SERVER['SERVER_NAME']; ?>/journals">Journal Titles</a></li>
			<li><a href="//<?php echo $_SERVER['SERVER_NAME']; ?>/databases">Databases</a></li>
			<li><a href="https://reserves.lib.ncsu.edu">Course Reserves</a></li>
		</ul>
		<ul>
			<li><a href="//<?php echo $_SERVER['SERVER_NAME']; ?>/data">Spatial &amp; Numerical Data</a></li>
			<li><a href="//<?php echo $_SERVER['SERVER_NAME']; ?>/specialcollections">Special Collections</a></li>
			<li><a href="//<?php echo $_SERVER['SERVER_NAME']; ?>/repository">NC State Publications</a></li>
			<li><a href="//<?php echo $_SERVER['SERVER_NAME']; ?>/repository">Theses &amp; Dissertations</a></li>
		</ul>
	</div>
	<div id="menu-help" class="primary-menu-list">
		<ul>
			<li><a href="//<?php echo $_SERVER['SERVER_NAME']; ?>/askus">Ask Us</a></li>
			<li><a href="//<?php echo $_SERVER['SERVER_NAME']; ?>/researchconsultation">Research Consultation</a></li>
			<li><a href="//<?php echo $_SERVER['SERVER_NAME']; ?>/digital-media-lab/techconsult">Technology Consultation</a></li>
			<li><a href="//<?php echo $_SERVER['SERVER_NAME']; ?>/researchworkshops">Research Workshops</a></li>
			<li><a href="//<?php echo $_SERVER['SERVER_NAME']; ?>/cdsc">Copyright Guidance</a></li>
		</ul>
		<ul>
			<li><a href="//<?php echo $_SERVER['SERVER_NAME']; ?>/course">Course Tools</a></li>
			<li><a href="//<?php echo $_SERVER['SERVER_NAME']; ?>/tools-citation">Citation</a></li>
			<li><a href="//<?php echo $_SERVER['SERVER_NAME']; ?>/reference-tools">Reference</a></li>
			<li><a href="//<?php echo $_SERVER['SERVER_NAME']; ?>/guides">Guides</a></li>
			<li><a href="//<?php echo $_SERVER['SERVER_NAME']; ?>/tutorials">Tutorials</a></li>
		</ul>
	</div>
	<div id="menu-services" class="primary-menu-list">
		<ul>
			<li><a href="//<?php echo $_SERVER['SERVER_NAME']; ?>/borrow">Borrow, Renew, Request</a></li>
			<li><a href="//<?php echo $_SERVER['SERVER_NAME']; ?>/computing">Computing</a></li>
			<li><a href="//<?php echo $_SERVER['SERVER_NAME']; ?>/digital-media-lab">Create Digital Media</a></li>
			<li><a href="//<?php echo $_SERVER['SERVER_NAME']; ?>/disabilityservices">Disability Services</a></li>
			<li><a href="//<?php echo $_SERVER['SERVER_NAME']; ?>/distance">Distance Learning</a></li>
			<li><a href="//<?php echo $_SERVER['SERVER_NAME']; ?>/faculty">Faculty/Instructor Support</a></li>
		</ul>
		<ul>
			<li><a href="//<?php echo $_SERVER['SERVER_NAME']; ?>/groupfinder">GroupFinder</a></li>
			<li><a href="//<?php echo $_SERVER['SERVER_NAME']; ?>/reservearoom">Reserve a Room</a></li>
			<li><a href="//<?php echo $_SERVER['SERVER_NAME']; ?>/printing">Print, Copy, Scan</a></li>
			<li><a href="//<?php echo $_SERVER['SERVER_NAME']; ?>/collections/suggestpurchase">Suggest a Purchase</a></li>
			<li><a href="//<?php echo $_SERVER['SERVER_NAME']; ?>/techlending">Technology Lending</a></li>
			<li><a href="//<?php echo $_SERVER['SERVER_NAME']; ?>/tripsaver">Tripsaver</a></li>
		</ul>
	</div>
	<div id="menu-libraries" class="primary-menu-list">
		<ul>
			<li><a href="//<?php echo $_SERVER['SERVER_NAME']; ?>/">D. H. Hill Library</a></li>
			<li><a href="//<?php echo $_SERVER['SERVER_NAME']; ?>/huntlibrary">James B. Hunt Jr. Library</a></li>
			<li><a href="//<?php echo $_SERVER['SERVER_NAME']; ?>/design">Design Library</a></li>
			<li><a href="//<?php echo $_SERVER['SERVER_NAME']; ?>/nrl">Natural Resources Library</a></li>
			<li><a href="//<?php echo $_SERVER['SERVER_NAME']; ?>/vetmed">Veterinary Medicine Library</a></li>
		</ul>
	</div>
	<div id="menu-about" class="primary-menu-list">
		<ul>
			<li><a href="//<?php echo $_SERVER['SERVER_NAME']; ?>/contact">Contact Us</a></li>
			<li><a href="//<?php echo $_SERVER['SERVER_NAME']; ?>/parking">Directions &amp; Parking</a></li>
			<li><a href="//<?php echo $_SERVER['SERVER_NAME']; ?>/hours">Hours</a></li>
			<li><a href="//<?php echo $_SERVER['SERVER_NAME']; ?>/jobs">Jobs</a></li>
		</ul>
		<ul>
			<li><a href="//<?php echo $_SERVER['SERVER_NAME']; ?>/staff">Staff</a></li>
			<li><a href="//<?php echo $_SERVER['SERVER_NAME']; ?>/directories">Directories</a></li>
			<li><a href="//<?php echo $_SERVER['SERVER_NAME']; ?>/giving/friends">Friends of the Library</a></li>
			<li><a href="//<?php echo $_SERVER['SERVER_NAME']; ?>/specialcollections">Special Collections</a></li>
		</ul>
	</div>
</nav>

<section id="utility">
	<div id="utility-bar">
		<?php if(drupal_is_front_page() && $_SERVER['REMOTE_ADDR']): ?>
		<div id="home-hours">
			<p id="hours-title"><a href="/hours">TODAY'S HOURS</a>:</p>
			<ul>
				<li><a href="//<?php echo $_SERVER['SERVER_NAME']; ?>/hours/hill/general"><span class="library">D. H. Hill:</span> &nbsp; <span class="hours">Open 24 Hours</span></a></li>
				<li><a href="//<?php echo $_SERVER['SERVER_NAME']; ?>/hours/hunt/general"><span class="library">James B. Hunt Jr.:</span> &nbsp; <span class="hours">Open 24 Hours</span></a></li>
			</ul>
		</div>
		<?php else: ?>
		<div id="utility-search">
			<form id="search-form" accept-charset="utf-8" method="get" action="/search/" tabindex="1">
				<input type="text" id="search-all" name="q" class="main-search-field search-header" placeholder="Search books, articles, journals, &amp; library website">
				<input type="submit" id="search-submit" value="SEARCH">
			</form>
		</div>
		<?php endif; ?>
		<?php include 'utility-links.php'; ?>
	</div>
</section>
