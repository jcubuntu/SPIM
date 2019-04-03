
	
	jQuery(document).ready(function($) {
	
		  jQuery("#default" ).click(function(){
			  jQuery("#color" ).attr("href", "css/color-default.css");
			  jQuery(".navbar-brand img" ).attr("src", "images/logo.png");
			  jQuery(".navbar-brand.logo-light img" ).attr("src", "images/logo-light-pink.png");
			  jQuery(".navbar-brand.with-bg img, .navbar-brand.simple img" ).attr("src", "images/logo-fallback-white.png");
			  return false;
		  });
		  
		  jQuery("#green" ).click(function(){
			  jQuery("#color" ).attr("href", "css/color-green.css");
			  jQuery(".navbar-brand img" ).attr("src", "images/logo-dark-blue.png");
			  jQuery(".navbar-brand.logo-light img" ).attr("src", "images/logo-light-blue.png");
			  jQuery(".navbar-brand.with-bg img, .navbar-brand.simple img" ).attr("src", "images/logo-fallback-white.png");
			  return false;
		  });
		  
		  jQuery("#yellow" ).click(function(){
			  jQuery("#color" ).attr("href", "css/color-yellow.css");
			  jQuery(".navbar-brand img" ).attr("src", "images/logo-dark-grey.png");
			  jQuery(".navbar-brand.logo-light img" ).attr("src", "images/logo-light-grey.png");
			  jQuery(".navbar-brand.with-bg img, .navbar-brand.simple img" ).attr("src", "images/logo-fallback-white.png");
			  return false;
		  });
		  
		  
		  jQuery("#blue" ).click(function(){
			  jQuery("#color" ).attr("href", "css/color-blue.css");
			  jQuery(".navbar-brand img" ).attr("src", "images/logo-dark-pink.png");
			  jQuery(".navbar-brand.logo-light img" ).attr("src", "images/logo-light-pink.png");
			  jQuery(".navbar-brand.with-bg img, .navbar-brand.simple img" ).attr("src", "images/logo-fallback-white.png");
			  return false;
		  });
		  
		  jQuery("#dark-blue" ).click(function(){
			  jQuery("#color" ).attr("href", "css/color-dark-blue.css");
			  jQuery(".navbar-brand img" ).attr("src", "images/logo-dark-green.png");
			  jQuery(".navbar-brand.logo-light img" ).attr("src", "images/logo-light-green.png");
			  jQuery(".navbar-brand.with-bg img, .navbar-brand.simple img" ).attr("src", "images/logo-fallback-white.png");
			  return false;
		  });
		  jQuery("#pur" ).click(function(){
			  jQuery("#color" ).attr("href", "css/color-pur.css");
			  jQuery(".navbar-brand img" ).attr("src", "images/logo-dark-yellow.png");
			  jQuery(".navbar-brand.logo-light img" ).attr("src", "images/logo-light-yellow.png");
			  jQuery(".navbar-brand.with-bg img, .navbar-brand.simple img" ).attr("src", "images/logo-fallback-white.png");
			  return false;
		  });
		  
		   jQuery("#red" ).click(function(){
			  jQuery("#color" ).attr("href", "css/color-red.css");
			  jQuery(".navbar-brand img" ).attr("src", "images/logo-dark-yellow.png");
			  jQuery(".navbar-brand.logo-light img" ).attr("src", "images/logo-light-yellow.png");
			  jQuery(".navbar-brand.with-bg img, .navbar-brand.simple img" ).attr("src", "images/logo-fallback-white.png");
			  return false;
		  });
		  
		   
		  jQuery(".switcher-dropdown a span").click(function(){
			  	//jQuery(".switcher-dropdown ul").slideUp();
				jQuery(this).parent().parent(".switcher-dropdown").find("ul").slideToggle();
				jQuery(this).parent().parent(".switcher-dropdown").siblings(".switcher-dropdown").find("ul").slideUp();
				
		  });
		  
		  
		 
		  
		  
		  
		  
		  
		  
		  // picker buttton
		  jQuery(".picker_close").click(function(){
			  
			  	jQuery("#choose_color").toggleClass("position");
			  
		   });
		   
		   
		  
	});