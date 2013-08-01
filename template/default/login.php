<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />

<title>Architeka - the customer social network for architects</title>

<meta name="description" content="Architeka e' il nuovo social media per designers. Architetti, Geometri ed Ingegneri possono condividere i propri progetti con clienti migliorando e velocizzando il processo di interazione e costruzione."/>
<meta name="keywords" content="social media, architetto, architetti, geometra, ingegnere, costruzioni, edilizia, casa, ponte, design"/>
<meta name="copyright" content="simplenetworks - 2010"/>
<meta name="author" content="SimpleNetworks S.R.L"/>
<meta name="email" content="info@simplenetworks.it"/>
<meta name="Distribution" content="Global"/>
<meta name="Rating" content="General"/>
<meta name="Robots" content="INDEX,FOLLOW"/>
<meta name="Revisit-after" content="7 Days"/> 

<link rel="icon" href="template/default/images/favicon.ico" />
<link type="text/css" media="screen" rel="stylesheet" href="template/default/stylesheets/reset.css" />
<link type="text/css" media="screen" rel="stylesheet" href="template/default/stylesheets/main.css" />
<script src="template/javascript/jquery-1.4.min.js" type="text/javascript"></script>
<link href="template/javascript/ui_css/smoothness/jquery-ui-1.8.4.custom.css" rel="stylesheet" type="text/css" media="screen" />
<script src="template/javascript/anylinkmenu.js" type="text/javascript"></script>
<script type="text/javascript" src="template/javascript/jquery-ui-1.8.4.custom.min.js"></script>
<link type="text/css" href="template/javascript/bouncebox.css" rel="stylesheet" media="all" />
<script type="text/javascript">
jQuery.noConflict(); 
jQuery(document).ready(function($) {
	  /* Converting the #box div into a bounceBox: */
	  $('#bouncebox').slideToggle("slow");
	  //$('#bouncebox').show();
		$('#bouncebox').click(function(){
		$('#bouncebox').slideToggle("slow");
		});
});
</script>

<!-- UserVoice feedback -->
<script type="text/javascript">
  var uservoiceOptions = {
    key: 'architeka',
    host: 'architeka.uservoice.com', 
    forum: '73849',
    alignment: 'right',
    background_color:'#03ad09', 
    text_color: 'white',
    hover_color: '#03ad09',
    lang: '<?php echo PREFERRED_LANG;?>',
    showTab: true
  };
  function _loadUserVoice() {
    var s = document.createElement('script');
    s.src = ("https:" == document.location.protocol ? "https://" : "http://") + "uservoice.com/javascripts/widgets/tab.js";
    document.getElementsByTagName('head')[0].appendChild(s);
  }
  _loadSuper = window.onload;
  window.onload = (typeof window.onload != 'function') ? _loadUserVoice : function() { _loadSuper(); _loadUserVoice(); };
</script>

<!--  Google  -->
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-2998215-13']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
<script type="text/javascript">
/***********************************************
* AnyLink JS Drop Down Menu v2.0- © Dynamic Drive DHTML code library (www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit Project Page at http://www.dynamicdrive.com/dynamicindex1/dropmenuindex.htm for full source code
***********************************************/
var anylinkmenu1={divclass:'anylinkmenu', inlinestyle:'', linktarget:''}; //First menu variable. Make sure "anylinkmenu1" is a unique name!
anylinkmenu1.items=[
	["Italiano", "index.php?lang=it"],
	["English", "index.php?lang=en"] //no comma following last entry!
]
//anylinkmenu.init("menu_anchors_class") //Pass in the CSS class of anchor links (that contain a sub menu)
anylinkmenu.init("menuanchorclass");
</script>

</head>
<body>

<?php if(isset($error)) {
?>
<div id="bouncebox">
	<p><b><?php echo LANG_ERROR; ?></b><?php echo $error;?></p>
</div>
<?php 	
} else if(isset($message_logout)) {
?>
<div id="bouncebox">
	<p><b><?php echo LANG_NOTIFY; ?></b><?php echo $message_logout;?></p>
</div>	
<?php 
}
?>

<div id="header">
  <h1><a href="index.php">logo</a></h1>
  <ul>
    <li><a href="home.php" class="active"><?php echo LANG_HOME;?></a></li>
    <li><a class="menuanchorclass" rel="anylinkmenu1"><b><?php echo LANG_CHOOSE_LANG;?></b></a></li>
    <!--<li><a href="guide.php"><?php echo LANG_GUIDE;?></a></li>-->
    <li><a href="information.php"><?php echo LANG_INFORMATION;?></a></li>
    <li><a href="advertising.php"><?php echo LANG_ADV;?></a></li>
    <li><a href="contact.php"><?php echo LANG_CONTACTS;?></a></li>
  </ul>
    <fieldset>
    <p><?php echo LANG_FOLLOWUS;?></p>
     <a id="RSS" href="rss/news.xml">&nbsp;&nbsp;&nbsp;&nbsp;</a>
     <a id="twitter" href="#">&nbsp;&nbsp;&nbsp;&nbsp;</a>
     <a id="facebook" href="http://www.facebook.com/pages/Architeka/143504099007694" target="_blank">&nbsp;&nbsp;&nbsp;&nbsp;</a>
    </fieldset>
</div>
<!-- //#header -->

<div id="sub-header">
  <div id="sub-header-inner">

  	<h3 id="login">&nbsp;</h3>
      <form action="login.php" method="post">
        <fieldset>
        <ul>
          <li>
            <label>username</label>
            <input type="text" name="username" class="username" />
          </li>
          <li>
            <label>password</label>
            <input type="password" name="password" class="password" />
          </li>
          <li>
            <input type="submit" name="submit" value="login" class="button" />
          </li>
        </ul>
        </fieldset>
      </form>
      <p><a href="register.php"><?php echo LANG_LOGIN_REGISTER;?></a></p>
      <p><a href="reminder.php"><?php echo LANG_LOGIN_LOSTPASSWORD;?></a></p>
    </div>
</div>
<!-- //#sub-header -->

      <div class="video">
      <object width="400" height="250"><param name="movie" value="http://www.youtube.com/v/uiL9FxgK-_4?fs=1&amp;hl=it_IT&amp;rel=0"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/uiL9FxgK-_4?fs=1&amp;hl=it_IT&amp;rel=0" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="400" height="250"></embed></object>
      </div>
      

<div id="content" class="clearfix">
  <div id="content-inner">
    
    <div class="column login">
      <h3 id="about"></h3>
       <div style="text-align:center"><img src="template/default/images/home_icons/evoluzione.png" alt=""/></div>
    		<?php echo LANG_LOGIN_FIRST_DESCRIPTION;?>
          <p class="read-more"><a href="information.php"><?php echo LANG_READMORE; ?></a></p>
        </div>
    
    <div class="column login">
      <h3 id="services"></h3>
      <div style="text-align:center"><img src="template/default/images/home_icons/demo.png" alt=""/></div>
		<?php echo LANG_LOGIN_SECOND_DESCRIPTION;?>
      <p class="read-more"><a href="information.php"><?php echo LANG_READMORE; ?></a></p>
    </div>
    
    <div class="column login last">
      <h3 id="connect"></h3>
    <div style="text-align:center"><img src="template/default/images/home_icons/comunica.png" alt=""/></div>
		<?php echo LANG_LOGIN_THIRD_DESCRIPTION;?>
      <p class="read-more"><a href="contact.php"><?php echo LANG_READMORE; ?></a></p>
    </div>
    
  </div>
</div>
<!-- //#content -->


<div id="footer">

<p><a>architeka</a> <?php echo ARCHITEKA_VERSION?> is a <a href="http://www.simplenetworks.it" target="_blank">Simplenetworks srl</a> product</p>
  <ul>
    <li><a href="home.php" class="active"><?php echo LANG_HOME;?></a></li>
    <li><a href="information.php"><?php echo LANG_INFORMATION;?></a></li>
    <li><a href="advertising.php"><?php echo LANG_ADV;?></a></li>
    <li><a href="privacy.php"><?php echo LANG_PRIVACY_PAGE;?></a></li>
    <li><a href="terms.php"><?php echo LANG_TERMS_PAGE;?></a></li>
    <li><a href="credits.php"><?php echo LANG_CREDITS;?></a></li>
    <li><a href="contact.php"><?php echo LANG_CONTACTS;?></a></li>
  </ul>
  
</div>
<!-- //#footer -->
</body>
</html>