<!DOCTYPE html>
<html lang="en">
<head>
<title>Strain gauge theory Arduino scale tutorial HX711</title>
	
<meta name="description" content="We learn how a strain gauge works, how to pass from resistance changes to voltage values and read that with an ADC and then how to use these with a load cell and create a precision homemade scale.">
<meta charset="utf-8">
<meta property="fb:app_id"        content="249946393271" />
<meta property="og:url"           content="https://www.electronoobs.com/eng_arduino_tut115.php" />
<meta property="og:type"          content="article" />
<meta property="og:title"         content="Strain gauge theory Arduino scale tutorial HX711" />
<meta property="og:description"   content="We learn how a strain gauge works, how to pass from resistance changes to voltage values and read that with an ADC and then how to use these with a load cell and create a precision homemade scale. See more..." />
<meta property="og:image"         content="http://www.electronoobs.com/images/Arduino/tut_115/tut115.jpg" />
<meta name="viewport" content="width=device-width, initial-scale=1">
	
	
<link rel="shortcut icon" href="images/icon.ico"/>
<link rel="stylesheet" href="CSS/bootstrap.css">
<link rel="stylesheet" href="CSS/tutorial_arduino.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    




  <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
  <script>
  (adsbygoogle = window.adsbygoogle || []).push({
    google_ad_client: "ca-pub-7895687552151505",
    enable_page_level_ads: true,
    overlays: {bottom: true}
  });
  </script>
  


 
  
  
  <script src="https://apis.google.com/js/platform.js"></script>
  
  <script>window._epn = {campaign:5338106513};</script>
  
  <script src="https://epnt.ebay.com/static/epn-smart-tools.js"></script>
  
  <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
  
  
  
 
  
  
  
  
  <script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
    
      ga('create', 'UA-62541190-1', 'auto');
      ga('send', 'pageview');
    function MM_swapImgRestore() { //v3.0
      var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
    }
    function MM_preloadImages() { //v3.0
      var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
        var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
        if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
    }
    
    function MM_findObj(n, d) { //v4.01
      var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
        d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
      if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
      for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
      if(!x && d.getElementById) x=d.getElementById(n); return x;
    }
    
    function MM_swapImage() { //v3.0
      var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
       if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
    }
  </script>
  
  
  
  
<!--  
 <div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = 'https://connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v2.12&appId=249946393271&autoLogAppEvents=1';
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
   -->


<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = 'https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.0&appId=249946393271&autoLogAppEvents=1';
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
  


  
  
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
  
  
  
  
  
  
  
  
  
  <style>
	body {	  
	  font-size: 20px;	  
	}
	
	.h1 {
	font-size: 46px;
	
	}
	h2,
	.h2 {
	  font-size: 30px;
	}
	h3,
	.h3 {
	  font-size: 24px;
	}  
  
  	lightblue
	{
		font-size: 15px;
		color:#39F;
	}
	
	titleblue
	{
		font-size: 30px;
		color:#06F;
		text-align: center;
	}
  
    /* Remove the navbar's default rounded borders and increase the bottom margin */ 
    .navbar {
      margin-bottom: 180px;
      border-radius: 0;
	  background-color:#FFF;
	  color:#F90;
    }
	
    
    /* Remove the jumbotron's default bottom margin */ 
     .jumbotron {
      margin-bottom: 0;
    }
   
    /* Add a gray background color and some padding to the footer */
    footer {
      background-color: #CCC;
      padding: 25px;
    }
	
	video#bgvid {
	position: absolute;
	top: 145px;
	left: 50%;
	
	width: 99.5%;
	height: auto;
	z-index: -100;
	-webkit-transform: translateX(-50%) translateY(-50%);
	transform: translateX(-50%) translateY(-50%);
	
}

.photo_bg
{
	position: absolute;
	top: 145px;
	left: 50%;
	
	width: 99.5%;
	height: auto;
	z-index: -100;
	-webkit-transform: translateX(-50%) translateY(-50%);
	transform: translateX(-50%) translateY(-50%);
}



red
{
	color:#F30;
	font-size:18px;
}

p
{
	text-align: justify;	
}

orange
{
	color:#F90;
	
}

para_footer
{
	text-align: center;
	color:#967118;
	font-size:26px;
}

.centrar_bloque
{
	float: left;
	width: 100%;
	text-align: center;
	width: 100%;	
}

.busqueda
{
	left: 700px;
	float:right;
	
	
	
	position: fixed;
	margin-left: 10px;
	float: left;
	z-index: 300;
	left: 10px;
	bottom:30px;	
}


.para_code
{
	width: 100%;
	height: 300px;
	float: left;
	overflow: scroll;
	overflow-x: hidden;
	text-align: left;	
}











   .navbar {
      margin-bottom: 180px;
      border-radius: 0;
	  background-color:#FFF;
	  color:#F90;
    }
	
    
    /* Remove the jumbotron's default bottom margin */ 
     .jumbotron {
      margin-bottom: 0;
    }
   
    /* Add a gray background color and some padding to the footer */
    footer {
      background-color: #CCC;
      padding: 25px;
    }
	
	video#bgvid {
	position: absolute;
	top: 145px;
	left: 50%;
	
	width: 99.5%;
	height: auto;
	z-index: -100;
	-webkit-transform: translateX(-50%) translateY(-50%);
	transform: translateX(-50%) translateY(-50%);
	
}

.photo_bg
{
	position: absolute;
	top: 145px;
	left: 50%;
	
	width: 99.5%;
	height: auto;
	z-index: -100;
	-webkit-transform: translateX(-50%) translateY(-50%);
	transform: translateX(-50%) translateY(-50%);
}


.title_line
{
	background-color:#337ab7;
	height: 5px;
	
}


trending_title
{
	color:#F90;
	font-size:26px;
	background-color:#F0F0F0;
}
more_posts_title
{
	color:#F90;
	font-size:18px;
	background-color:#F0F0F0;
}
red
{
	color:#F30;
	font-size:18px;
}

p
{
	text-align: justify;	
}

orange
{
	color:#F90;
	font-size:26px;
}

small_text
{
	color:#003;
	font-size:13px;
}

mobile_title
{ 
	font-family: Impact, Charcoal, sans-serif;
	color: #FFF;
	font-size: 45px;
	text-transform: uppercase;
	
	background-color:#337ab7;	
	font-weight: bolder;
	text-align: center;
	
}
div.last_tut_left_title
{
	color: #FFF;
	font-size: 30px;
	text-align: left;
	background-color:#39C;	
}


div.last_tut_left_descrip
{
	font-size: 30px;
	text-align: left;
}


para_footer
{
	text-align: center;
	color:#967118;
	font-size:26px;
}

.centrar_bloque
{
	float: left;
	width: 100%;
	text-align: center;
	
}

.welcome_EN
{
	float: left;
	width: 100%;
	height: 40px;

}

.welcome_EN_1
{
	float: left;
	width: 100%;
	height: 10px;
	margin-top:0px;
	margin-bottom:10px;

}


.tut_title
{
	color: #000;
	background-color: transparent;
	font-size: 16px;
	padding-left: 10px;
	margin-bottom: 5px;
	text-transform: none;
	font-weight: bolder;
	float:left;
	width:100%;
}
	  
.tut_title_by{
	font-size: 11px;
	float: left;
	margin-bottom: 10px;
}
	  
.tut_title_share{
	width: 100%;
	float: left;
    text-align: right;	
}

.tut_title_line
{
	widht:100%;
	height:5px;
	background-color: #337ab7;	
	margin-bottom:3px;
	border-radius: 5px;
	}

.tut_line
{
	widht:100%;
	height:5px;
	background-color: #337ab7;	
	margin-top:5px;
	margin-bottom:25px;
}

link_reading
{
	background-color:rgba(51, 153, 204, .2);	
	padding-left:4px;
	padding-right:4px;
	font-size:26px;
	text-align:justify;
}


.tut_line_2
{
	widht:100%;
	height:10px;
	background-color:rgba(51, 153, 204, .2);	
	margin-top:5px;
	margin-bottom:25px;
}
.tut_text
{
	font-size:16px;
	text-align: justify;	
	line-height: initial;
	margin-top: 10px;
	height: 80px;
	overflow: hidden;
	text-overflow: ellipsis;
	background-image: linear-gradient(to top, white, transparent);
}
	  
	  
.tut_text_overflow
{
	width: 92%;
    bottom: 100px;
    height: 30px;
    position: absolute;
    background-image: linear-gradient(to top, #ffffff, transparent);    
}
	  
	  
	main_title
	  {
		  font-size: 35px !important;
    	  border-top: 5px solid #337ab7 !important;	 
		  color: #337ab7 !important;
	  }
	  
	  part_1{
		  font-size: 25px !important;
    	 border-top: 3px solid #337ab7 !important;	 
		  color: #337ab7 !important;
		  background-color: transparent !important;
	  }
	  
	  main_top_title_back{
		 font-size: 22px !important;	 
	  }	  
	  
	  main_top_title{
		font-size: 22px !important;	  
	  }



@media (max-width: 768px) {
	  	main_title
	  {
		  font-size: 20px !important;    		  
	  }
	 part_1{
		  font-size: 20px;
    	
	  }
	 main_top_title_back{
		 font-size: 16px !important;	 
	  }	  
	  
	  main_top_title{
		font-size: 16px !important;	  
	  }

}
	  
	  
fecha
{
	font-size: 14px;
	text-align: justify;
	color: #09F;
}

.blog_blocks_text
{
	padding-top:10px;
	float:left;
	width:100%;
	height:auto;
	font-size: 20px;
	font-weight: 300;
	text-align: justify;
	text-justify: inter-word;
	color: #000;
}


main_top_title
{
	font-size: 35px;
	background-color: #B7E8E7;
	font-weight: bolder;
}

  </style>




  
<style>
</style>  
</head>

<body>
<div class="photo_bg">
<img src="images/BG_GIF4.gif" width="100%" height="100%">
</div>


<style>
    /* Remove the navbar's default rounded borders and increase the bottom margin */ 
    .navbar {
		margin-bottom: 180px;
      	border-radius: 0;
	  	background-color:#337ab7;
	  	color:#FFF;
		position: fixed;
		float: left;
   		width: 100%;
    	z-index: 100;
		top: 0;
    }
	
	.navbar-inverse .navbar-toggle .icon-bar {
  background-color: #0066CC;
}

.navbar-inverse .navbar-toggle:hover,
.navbar-inverse .navbar-toggle:focus {
  background-color: #759dc0;
  
}

red
{
	color:#C03;
}

#li_menu_1{
	margin-top: 7px;
	padding-left: 10px;
	color: #337ab7;
	width: 100%;
	background-color: #fff;
	height: 38px;
	color: #b2b2b2;
	font-size: 12px;
	border: 0;
	padding: 0 10px;
	border-radius: 5px;
	margin-left: 15px;		
	}
    
</style>


<nav class="navbar navbar-inverse">
	<div class="container-fluid" style="max-width: 1600px; font-size: 14px;">	  
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar" style="border: 0;">
				<span class="icon-bar" style="background-color: #FFF;"></span>
				<span class="icon-bar" style="background-color: #FFF;"></span>
				<span class="icon-bar" style="background-color: #FFF;"></span>                        
			</button>
			<a class="navbar-brand" href="index.php">HOME</a>
		</div>
		
		<div class="collapse navbar-collapse" id="myNavbar">
		
			
			
	
					
			
		<ul class="nav navbar-nav navbar-left" style="width: 250px;"> 
			<li id="li_menu_1">
				<form action="/search" method="POST">
					<input style="border: 0; height: 38px; background-color: transparent; width: 80%;" type="text" name="search" placeholder="Search...">
					<button style="position: absolute; top: 0; right: 0; background-color: #efefef; width: 38px; color: #337ab7;
    				font-size: 15px; height: 100%; border: 0; border-radius: 5px;" type="submit"><i class="fas fa-search"></i></button>
				</form>
			</li>
			<!--<li><a href="eng_donate.php"> <span class="glyphicon glyphicon-piggy-bank"></span> Donate</a></li>
			<li><a href="eng_reviews.php"> <span class="glyphicon glyphicon-list-alt"></span> Reviews</a></li>
			<li><a href="eng_advertising.php"> <span class="glyphicon glyphicon-bookmark"></span> Advertising</a></li>-->
      	</ul>
			
			
	
			
			
			
			
			
			
		
      <ul class="nav navbar-nav navbar-right">
           
        <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#"><span class="glyphicon glyphicon-book"></span> TUTORIALS
        <span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a href="eng_tutoriales_arduino.php"><i class="fas fa-microchip"></i> Arduino</a></li>
          <li><a href="eng_tutoriales_circuitos.php"><i class="fas fa-project-diagram"></i> Circuits</a></li>
          <li><a href="eng_tutoriales_robotica.php"><i class="fas fa-robot"></i> Robotics</a></li>
        </ul>
      </li>
      
     
     
     
     <li><a href="blogs.php"> <span class="glyphicon glyphicon-th-list"></span> BLOG</a></li>
     
     
     
     <li><a target="_blank" href="https://electronoobs.io/forum"> <span class="glyphicon glyphicon-blackboard"></span>Forum</a></li>
     
  		
      
      
      
            
      <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#"><span class="glyphicon glyphicon-modal-window"></span> 3D PRINTING
        <span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a href="eng_impresoras.php">Printers</a></li>
          <li><a href="eng_materiales.php">Materials</a></li>
          <li><a href="eng_objetos.php">3D objects</a></li>
          <li><a href="eng_edit3D.php">3D edit</a></li>
        </ul>
      </li>
		  
		  
		<li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fas fa-piggy-bank"></i> SUPPORT
        <span class="caret"></span></a>
			<ul class="dropdown-menu">
			  <li><a href="eng_donate.php"> <span class="glyphicon glyphicon-piggy-bank"></span> Donate</a></li>
				<li><a href="eng_reviews.php"> <span class="glyphicon glyphicon-list-alt"></span> Reviews</a></li>
				<li><a href="eng_advertising.php"> <span class="glyphicon glyphicon-bookmark"></span> Advertising</a></li>

			</ul>
      	</li>
		  
		  
		<li><a target="_blank" href="https://electronoobs.io/shop/"> <i class="fas fa-shopping-cart"></i> SHOP</a></li>
      	
		  
		  
		  
					<li><a href="login.php"> <i class="fas fa-sign-in-alt"></i> LOGIN</a></li> 
		  
		  
		  
		 
		
		 
      
  
      </ul>
      
      
      
      
      
      
      
    </div>
  </div>
</nav> 
  
<div class="container-fluid text-center">    
<!--
<div class="busqueda">
    
    <div class="search_1">
	<div class="search_2">
	<form method="GET" action="https://www.google.com/search">
        <div class="search_3">
            <i class="search_4">
            </i>
        <input type="hidden" name="ie" value="UTF-8">
        <input type="hidden" name="oe" value="UTF-8">
        <input type="text" name="q" size="25" maxlength="255" value="" placeholder="Search for any project">
        <input type="submit" name="btnG" VALUE="search">
        <input type="hidden" name="domains" value="https://www.electronoobs.com">
        <input type="hidden" name="sitesearch" value="https://www.electronoobs.com">
        </div>
	</form> 
	</div>
	</div>
</div>   

<div class="youtubee">
<div class="g-ytsubscribe" data-channelid="UCjiVhIvGmRZixSzupD0sS9Q" data-layout="full" data-onytevent="onYtEvent"></div>
-->

  
<div class="row content">
  



  
<div class="col-sm-8 col-sm-push-2 text-left"> 
<main_title>Strain gauge + Arduino scale</main_title>  

<br>
<br>
<div class="centrar_bloque">
Help me by sharing this post<br>
<div class="fb-share-button" data-href="http://www.electronoobs.com/eng_arduino_tut115.php" data-layout="button_count" data-size="small" data-mobile-iframe="true"><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2Fwww.electronoobs.com%2Feng_arduino_tut115.php&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore">Share</a></div>

<br>
<br>


<main_top_title_back><a href="eng_arduino_tut114.php"><i class="far fa-hand-point-left"></i>PREVIOUS TUTORIAL</a></main_top_title_back>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<main_top_title><a href="eng_arduino_tut115_2.php">NEXT PART<i class="far fa-hand-point-right"></i></a></main_top_title>

<br>
<br>
</div>

<p>
In this tutorial we first learn what is a strain gauge and how it works. Then, sicne the gauge works with resistance variations, we learn how to pass from resistance changes to voltage values. Then, using a 24bit ADC, we read that voltage and in this way we can measure deforamation of certain materials. Using this deformation, with a lineal curve, we pass that to force and by taht to weight. So, like that we can build a simple precision scale uisng the Arduino taht will read the values from the 24bits ADC. Let's start.  </p>


<div class="centrar_bloque">
<iframe width="100%" height="650" src="https://www.youtube.com/embed/LRd3W_p8PJ4" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
</div>

<div class="clearfix"></div>
<br>

<div class="centrar_bloque">
<div class="capa_adsense">
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- Anuncio ELECTRONOOBS.com 2 Color -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-7895687552151505"
     data-ad-slot="2265826671"
     data-ad-format="auto"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>

</div></div>
<div class="clearfix"></div>
<br>
<br>


<part_1><black>PART 1 - </black>What we need</part_1>
<br>
<br>
<p>
Part list is very short. We need the Arduino that will process the data. Then we need a load cell, in my case I wanted a low weight precision scale so I've selected a 1Kg laod cell. In your case you could go with any other. Then we need the HX711 24bits ADC to read the voltage value, an LCD screen with i2c to print the weight and two push buttons.  We will also need some screws, a plywood for the base and the acrilic part for the top side of the scale. The rest are just wires. That's it. 


<div class="centrar_bloque"> 
<strong>We need:</strong><br>

<ul class="list-group list-group-flush">
	
<li class="list-group-item">
1 x Arduino NANO : <a href="https://www.ebay.com/itm/MINI-USB-Nano-V3-0-ATmega328P-CH340G-5V-16M-Micro-controller-board-for-Arduino/381374550571?hash=item58cbb1d22b:g:ci0AAOSwNSxVAB3c" target="_blank">LINK eBay</a><br/>
</li>

<li class="list-group-item">
1 x 1Kg load cell: <a href="https://www.ebay.com/itm/YZC-133-Mini-Scale-Electronic-Load-Cell-Weighing-Sensor-1-2-3-5-10-50Kg-NEW/172454812349?hash=item28271b9abd:m:mSHT2lL8rLNtxRwVw0GIhEA" target="_blank">LINK eBay</a><br/>
</li>
	
<li class="list-group-item">
1 x HX711 ADC: <a href="https://www.ebay.com/itm/Weighing-Sensor-AD-Module-Dual-channel-24-bit-A-D-Conversion-HX711-Shieding-CA/163808830806?hash=item2623c46556:g:G5MAAOSwxs9dS7yC" target="_blank">LINK eBay</a><br/>
</li>
	
<li class="list-group-item">
1 x i2c LCD: <a href="https://www.ebay.com/itm/IIC-I2C-TWI-SP-I-Serial-Interface1602-16X2-Character-LCD-Module-Display-Yellow/252513792517?hash=item3acafeb205:g:sUQAAOSwu4BVk1Gj" target="_blank">LINK eBay</a><br/>
</li>
	
<li class="list-group-item">
2 x Push button: <a href="https://www.ebay.com/itm/100pcs-Micro-switch-push-button-6-6-5-mm-new-good-quality/400985254448?hash=item5d5c956a30:g:TDsAAOSwcu5UNir1" target="_blank">LINK eBay</a><br/>
</li>
	
	
<li class="list-group-item">
1 x acrylic 3mm: <a href="https://www.ebay.com/itm/3mm-Clear-Plastic-Acrylic-Plexiglass-Perspex-Sheet-A5-Size-148mm-x-210mm/282029069286?epid=1041861391&hash=item41aa3e13e6:g:hCIAAOSwLs5XLDUJ" target="_blank">LINK eBay</a><br/>
</li>

<li class="list-group-item">
1 x plywood: <a href="https://www.ebay.com/itm/Midwest-Products-6-in-W-x-12-in-L-x-1-8-in-Plywood/383157335679?hash=item5935f4f67f:g:o-0AAOSw5FRdgCPW" target="_blank">LINK eBay</a><br/>
</li>

<li class="list-group-item">
Wires: <a href="https://www.ebay.com/itm/Black-1000ft-30AWG-Wrapping-Wire-Cable-Roll/261506825328?hash=item3ce3057c70:g:~nwAAOSwKfVXE3lo" target="_blank">LINK eBay</a><br/>
</li>


</ul>
</div>
	


<div class="centrar_bloque"> 
	
<img src="images/Arduino/tut_115/parts_1.jpg" alt="Arduino precision scale HX711 parts" width="100%" height="12%" />
</div>
<div class="clearfix"></div>

	
<br>
<br>
<br>
<br>
<br>












<part_1><black>PART 2 - </black>Schematic</part_1>
<br>
<br>

<p>
We can supply everything with 5V so don't worry. Connect GND and 5V to the LCD and the HX711 ADC. Connect one side of the push buttons to GND and the other side, one to D8 and the other button to D11 of the Arduino. Connect data and clock for the LCD to pins A4 and A5 and also data and clock from the ADC to pins D3 and D2. Connect the laod cell as below, and follow the color of the wires. 
 	
</p>  
<br>

<div class="centrar_bloque"> <a href="eng_arduino_tut115_sch1.php" target="_blank"><img src="images/Arduino/tut_115/sch_1.jpg" alt="Arduino schematic precision scale load cell HX711" width="100%" height="12%" /></a>
</div>

<div class="clearfix"></div>


<br>	
<div class="centrar_bloque">
<div class="capa_adsense">
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- Anuncio ELECTRONOOBS.com 2 Color -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-7895687552151505"
     data-ad-slot="2265826671"
     data-ad-format="auto"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>

</div></div>
<div class="clearfix"></div>
<br>

	
	
	
	
<part_1><black>PART 3.1 - </black>HX711 "raw" read example</part_1>
<br>
<br>
<p>
Ok, with the same setup in the schematic above, run the enxt code and see the raw value from the HX711 ADC. You will get values from 0 to 2 exponential 24 because is a 24 bits. So we will have decent precision. Also when the bridge is balanced, we will be in the middle value so we can go both positive and negative meaning positive or negative forces on the load cell. Intall the library and run the example code below then open the serial monitor. 
</p>   
<br>

<div class="tut_cod">
<div class="tut_cod_top">
</div>

<div class="arduino_code">
<pre><code class="arduino">#include &lt;Q2HX711.h>                              //Download it here: https://electronoobs.com/eng_arduino_hx711.php
const byte hx711_data_pin = 3;
const byte hx711_clock_pin = 2;
Q2HX711 hx711(hx711_data_pin, hx711_clock_pin);
void setup() {
  Serial.begin(9600);
}
void loop() {
  Serial.println(hx711.read()/100.0);
  delay(500);
}
</code></pre>
</div>
<div class="clearfloat">
</div>
<div class="tut_cod_bot">
</div>
</div>
<div class="clearfix"></div>
	
	
	
	
	
	
	
	
<br>
<br>
<br>
	
	
	
	
<part_1><black>PART 3.2 - </black>Scale Code</part_1>
<br>
<br>
<p>
The code is quite simple. You can go below and download it and you will also have links for the libraries for the LCD screen and the HX711 ADC. In the code we first wait for the ADC value to cahnge a lot. That means the calibration mass was placed on the scale. Then we create a loop and calibrate the scale based on that calibrated mass. Change the "y1" value to the value (in grams) of your calibrated mass. Then in the code, we just read the value and print it on the LCD or serial monitor. We also have interuptions for the two push buttons to detect when we press the mode or Tara buttons. The Tara will set the scale to 0, and the mode will change from g, to mm and to oz. Install the libraries, compile and upload to the Arduino. Remember to change the "y1" variable you can see below with the weight of your own calibrated mass. 
</p>   
<br>

<div class="centrar_bloque"> 
	<a href="eng_arduino_tut115_code1.php" target="_blank"><button type="button" style="color: #FFF;" class="btn btn-primary btn-lg">Download Scale Code <i class="fas fa-download"></i></button></a>	
</div>
<div class="clearfix"></div>	

	<br>
<br>

	


<link rel="stylesheet" href="CSS/arduino-light.css">
<link rel="stylesheet" href="CSS/default.css">
<script src="js/highlight.pack.js"></script>
<script>hljs.initHighlightingOnLoad();</script>



<div class="tut_cod">
<div class="tut_cod_top">
</div>

<div class="arduino_code">
<pre><code class="arduino">//Variables
/////////Change here with your calibrated mass////////////
float y1 = 2831.0; // calibrated mass to be added
//////////////////////////////////////////////////////////

long x1 = 0L;
long x0 = 0L;
float avg_size = 10.0; // amount of averages for each mass measurement
float tara = 0;
bool tara_pushed = false;
bool mode_pushed = false;
int mode = 0;
float oz_conversion = 0.035274;
//////////////////////////////////////////////////////////
</code></pre>
</div>
<div class="clearfloat">
</div>
<div class="tut_cod_bot">
</div>
</div>
<div class="clearfix"></div>



	
	
	
	
<br>	
<br>
<br>
<br>
	
	
	
	
	
<part_1><black>PART 4- </black>Mount the scale</part_1>
<br>
<br>
<p>
As you can see below, the setup is easy. First screw the load cell in palce. I add two screw nuts so it will have clearance from the ground so it will be able to flex. Then I screw that to the plywood and on top I add the acrylic. Connect the wires as in the scheamtic. Add the push buttons and I glue everything on the plywood board. Upload the code, after the "add calibrated mass" message add your mass, and the scale will be ready. I supply my setup with the USB cable. 
</p>   
<br>
	
<div class="centrar_bloque"> <img src="images/Arduino/tut_115/mount_1.jpg" alt="Arduino load cell precision scale tutorial" width="100%" height="12%" />
</div>

<div class="clearfix"></div>
	<br>
<br>
<br>

	





<div class="centrar_bloque">
<br>
<br>

<main_top_title_back><a href="eng_arduino_tut114.php"><i class="far fa-hand-point-left"></i>PREVIOUS TUTORIAL</a></main_top_title_back>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<main_top_title><a href="eng_arduino_tut115_2.php">NEXT PART<i class="far fa-hand-point-right"></i></a></main_top_title>

</div>





<div class="clearfix"></div>
<br>




<div class="centrar_bloque">
Help me by sharing this post<br>
<div class="fb-share-button" data-href="http://www.electronoobs.com/eng_arduino_tut115.php" data-layout="button_count" data-size="small" data-mobile-iframe="true"><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2Fwww.electronoobs.com%2Feng_arduino_tut115.php&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore">Share</a></div>




<br>
<br>
<div class="fb-comments" data-href="http://www.electronoobs.com/eng_arduino_tut115.php" data-width="100%" data-numposts="5"></div>
<br>
<br>



</div>
<div class="clearfix"></div>
<br>
<br>


<br>
<br>
<br>
<br>
<br>
<br>

</div>
 
 
 
 
 
<div class="col-sm-2 col-sm-pull-8 sidenav"> 
<style>
.barra_social_media_10{
	height: 60px;
	float: center;
	width: 100%;
	background-color:#FFF;
	}

.barra_social_media_2{
	margin:2%;
	height: 50px;
	float: left;
	width: 50px;
	
}
.barra_social_media_3{
	margin-right:2%;
	margin-bottom:2%;
	margin-top:2%;
	margin-left:4%;
	height: 50px;
	float: left;
	width: 50px;
	background-color: none;
}

.gearbest_side_1
{
  float:left;
  width:100%;
  height:600px;
  float: center;
  margin-bottom:10px;
  margin-top:10px;
}

.gearbest_horizontal_1
{
  float:center;
  width: 100%;
  height:90px;
  margin-bottom:10px;
  margin-top:10px;

}

.ad_line
{
  float:center;
  width: 100%;
  height:20px;
  border-bottom: 1px dotted #FC9;
  
 
}
</style>    
    
    
    
    
    
    
    
    
      <div class="barra_social_media_10">
      
      	<div class="barra_social_media_3">
        <a href="https://www.youtube.com/c/ELECTRONOOBS" target="_blank" onMouseOver="MM_swapImage('yt_link','','images/YouTube_2.png',1)" onMouseOut="MM_swapImgRestore()"><img id="yt_link" src="images/YouTube_1.png" width="50px" alt="yt_link"></a> 
        </div>
        
        <div class="barra_social_media_2">
        <a href="https://www.instagram.com/ELECTRONOOBS" target="_blank" onMouseOver="MM_swapImage('insta_link','','images/Insta_2.png',1)" onMouseOut="MM_swapImgRestore()"><img id="insta_link" src="images/Insta_1.png" width="50px" alt="insta_link"></a> 
        </div>
        
        <div class="barra_social_media_2">
        <a href="https://www.facebook.com/Electronoobs" target="_blank" onMouseOver="MM_swapImage('fb_link','','images/fb_2.png',1)" onMouseOut="MM_swapImgRestore()"><img id="fb_link" src="images/fb_1.png" width="50px" alt="fb_link"></a>
        </div>
        
        <div class="barra_social_media_2">
        <a href="https://twitter.com/ELECTRONOOBS" target="_blank" onMouseOver="MM_swapImage('twitter_link','','images/twitter_2.png',1)" onMouseOut="MM_swapImgRestore()"><img id="twitter_link" src="images/twitter_1.png" width="50px" alt="twitter_link"></a>
        </div>
    </div>
      
      
      
        
  
<h3><orange>Also see Wheatstone Bridge Theory
<br>


<iframe width="100%" height="210" src="https://www.youtube.com/embed/ZqAM_wQ35ow" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
	
<br>
<style>
.adsense_side_bloc_1
{
	width:100%;
	height:250px;
	
	margin-bottom:10px;
}

.adsense_side_bloc_1_280
{
	width:100%;
	height:280px;
	
	margin-bottom:10px;
}

.adsense_side_bloc_2
{
	width:100%;
	height:600px;
	
	margin-bottom:10px;
}

.adsense_side_bloc_3
{
	width:100%;
	height:600px;
	
	margin-bottom:10px;
}


.adsense_side_bloc_total
{
	
	float:center;
	
}



</style>


<div class="adsense_side_bloc_total">
<br />




<!--<div class="adsense_side_bloc_1">
<a href="http://bit.ly/2OZXUOa" target="_blank"><img src="images/Advertising/PCBWAY/Solo_banner.gif" width="100%" height="280" alt="PCBWAY PCB Manufacturing" /></a>
</div>


<br />



<div class="adsense_side_bloc_1">
<a href="http://bit.ly/2C13Rpp" target="_blank"><img src="images/Advertising/PCBWAY/PCBway_2019_1.gif" width="100%" height="280" alt="PCBWAY Christas PCB Manufacturing" /></a>
</div>


<br />


<div class="adsense_side_bloc_1_280">
<a href="http://bit.ly/2BdX0tU" target="_blank"><img src="images/Advertising/welpcb_ad_2.gif" width="100%" height="280" alt="Advanced PCB Manufacturing" /></a>
</div>


<div class="adsense_side_bloc_1_280">
<a href="http://bit.ly/2LeoDq1" target="_blank"><img src="images/Advertising/welpcb_ad_3.gif" width="100%" height="280" alt="Advanced PCB Manufacturing" /></a>
</div>-->




<div class="clearfix">
</div>






<div class="adsense_side_bloc_2">
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- Personalizado -->
<ins class="adsbygoogle"
     style="display:inline-block;width:247px;height:600px"
     data-ad-client="ca-pub-7895687552151505"
     data-ad-slot="4203471416"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
</div>



<div class="clearfix"></div>








</div>



<div class="clearfix"></div></div>
 
 
 
 
 
 
 
 
 
 
 
 
  
 
 
 
 
 
 
    
    
    <div class="col-sm-2 sidenav">
    
      <div class="well">
       <style>
	.right_well{
		float: left;		
		width: 100%;
		font-size: 14px;
		background-color: #fff;
		border-top: 5px solid #337ab7;
		border-left: 1px solid #e4e4e4;
		border-right: 1px solid #e4e4e4;
		border-bottom: 1px solid #e4e4e4;
		margin-bottom: 20px;
		-webkit-box-shadow: 1px 0px 2px rgba(0,0,0,0.24);
		-moz-box-shadow: 1px 0px 2px rgba(0,0,0,0.24);
		-ms-box-shadow: 1px 0px 2px rgba(0,0,0,0.24);
		-o-box-shadow: 1px 0px 2px rgba(0,0,0,0.24);
		box-shadow: 1px 0px 2px rgba(0,0,0,0.24);	
		color: #000;
	 }
	
	@media screen and (min-width:767px){
		.stickye_R {
			float: left;
			position: fixed;
			top: 65px;				
		}	
	}
	
	.right_bar
	{
		/*float: left;*/
		width: 100%;	
		padding-bottom: 20px;
		height: 100%;
		border-top: 5px solid #337ab7;
		padding-top: 5px;
		
		
	}
	
	#navebar_R
	{
		width: 100%;
	}
	
	
</style>
 
	
	
<script>
	
window.onscroll = function() {myFunction4();
							  myFunction3();
							 
							 
							 
							 };

function myFunction4(){
	var x_R = $('#right_bar').outerHeight() + 180;
	var sidebar_width_R = $('#right_bar').outerWidth() ;
	var sidebar_height_R = $( window ).outerHeight() * 0.9;

	
	if(window.pageYOffset >= x_R) {
		navebar_R.classList.add('stickye_R');
		navebar_R.style.width = (sidebar_width_R + "px");
		navebar_R.style.height = sidebar_height_R;
	}
	else{
		navebar_R.classList.remove('stickye_R');
	}
}
</script>


<div class="right_bar" id="right_bar" >
	<div class="adsense_side_bloc_1_280">
		<a href="http://bit.ly/36FgSDm" target="_blank"><img src="images/Advertising/PCBWAY/300x250_Anniversary.jpg" width="95%" height="100%" alt="PCBWAY PCB service" /></a>
	</div>
	<div class="clearfix"></div>
	<br>
	
	<div class="adsense_side_bloc_1_280">
		<a href="http://bit.ly/2sZR6Lu" target="_blank"><img src="images/Advertising/PCBWAY/336x280.jpg" width="95%" height="100%" alt="PCBWAY PCB service" /></a>
	</div>
	<div class="clearfix"></div>
	<br>
	
	<div class="adsense_side_bloc_1_280">
		<a href="https://bit.ly/2ZqxdLa" target="_blank"><img src="images/Advertising/PCBONLINE/500x500.gif" width="95%" height="100%" alt="PCBONLINE PCB service" /></a>
	</div>	
	<div class="clearfix"></div>
	<br>

	<div class="adsense_side_bloc_1_280">
		  <div id="ali-banner"></div>
			<style scoped>
				#ali-banner img{
					width: 100%;
				}
			</style>
		
            <script type="text/javascript">
            (function (d, w, p, q, i) {
              var s = d.createElement('script');
              var f = q.replace('#', '');
			  
				 		  
				
              s.src = '//' + p + '/s?d=' + i + '&f=' + f + '&r=' + new Date().getTime();			
              s.onload = function () {
                typeof w[f] === 'function' && w[f](p, q, d, i)
              };
				
			 
				
              d.body.appendChild(s);
            })(document, window, 'aliadvert.ru', '#ali-banner', 839)
            </script>

	</div>	
	<div class="clearfix"></div>
	<br>
		
	
	<div class="adsense_side_bloc_2">
		<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
		<!-- Left Sidebar block 1 -->
		<ins class="adsbygoogle"
			 style="display:block"
			 data-ad-client="ca-pub-7895687552151505"
			 data-ad-slot="3574796316"
			 data-ad-format="auto"
			 data-full-width-responsive="true"></ins>
		<script>
			 (adsbygoogle = window.adsbygoogle || []).push({});
		</script>	
	</div>
	<div class="clearfix"></div>
	<br>
	
	
	
	<div class="adsense_side_bloc_1_280">
		<a href="https://s.click.aliexpress.com/e/_dUqM4uX?bz=300*250" target="_parent"><img width="100%" height="250" src="//ae01.alicdn.com/kf/Had93e0a03ab54bca81b36c7da4a2bf44Y.gif"/></a>
	</div>	
	<div class="clearfix"></div>
	<br>
	
	<div class="adsense_side_bloc_1_280">
		<a href="https://s.click.aliexpress.com/e/_BfZ4HgEb?bz=190*240" target="_parent"><img width="100%" height="250" src="//ae01.alicdn.com/kf/H135d21cbaf0a4551ac0e4a5f08530654P.png"/></a>
	</div>	
	<div class="clearfix"></div>
	<br>
	
	
	
	
	
	<div class="adsense_side_bloc_2">
		<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
		<!-- Sidebar_cuadrado -->
		<ins class="adsbygoogle"
			 style="display:inline-block;width:247px;height:280px"
			 data-ad-client="ca-pub-7895687552151505"
			 data-ad-slot="2872239064"></ins>
		<script>
			 (adsbygoogle = window.adsbygoogle || []).push({});
		</script>	
	</div>
	<div class="clearfix"></div>
	<br>
	
	
	
	
	
	
	
	

</div> 		
	
<div id="navebar_R" class="" style="float: left;">
	<div class="right_well" >
		<div class="adsense_side_bloc_2">
		<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
		<!-- Left Sidebar block 1 -->
		<ins class="adsbygoogle"
			 style="display:block"
			 data-ad-client="ca-pub-7895687552151505"
			 data-ad-slot="3574796316"
			 data-ad-format="auto"
			 data-full-width-responsive="true"></ins>
		<script>
			 (adsbygoogle = window.adsbygoogle || []).push({});
		</script>	
		</div>
		<div class="clearfix">
		</div>
	</div>
</div>	












      </div>
      
      <div class="well">
       
<iframe width="100%" height="100%" src="https://www.youtube.com/embed/Vep09UZsuiQ" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>

<br>
<br>

<iframe width="100%" height="100%" src="https://www.youtube.com/embed/kMU8xiGCpd0" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>      </div>      
    </div>



  </div>
</div>











<footer class="container-fluid text-center">
  <para_footer>ELECTRONOOBS 2020
<br />

Keep up you guys!</para_footer>  
  
</footer>

</body>
</html>
