			
			
			(function () {
				"use strict";
					
			
					
					
					
				/* ------------------------------------------------------------------------ 
				   OUR WORK 
				------------------------------------------------------------------------ */
				jQuery(".four-item-carousel").owlCarousel({
					items: 4,
					itemsDesktop: [1199, 4],
					itemsDesktopSmall: [979, 3],
					itemsTablet: [768, 2],
					itemsMobile: [479, 1],
					navigation: true
				});
				
				
				
				
				
				/* ------------------------------------------------------------------------ 
				   latest-blog-carousel 
				------------------------------------------------------------------------ */
				jQuery(".three-item-carousel").owlCarousel({
					items: 3,
					itemsDesktop: [1199, 3],
					itemsDesktopSmall: [979, 2],
					itemsTablet: [768, 2],
					itemsMobile: [580, 1],
					navigation: true
				});
				
				
				
				
				
				/* ------------------------------------------------------------------------ 
				   add-banner-slider
				------------------------------------------------------------------------ */
				jQuery(".add-banner-slider").owlCarousel({
					singleItem: true
				});
				
				
				
				
				
				/* ------------------------------------------------------------------------ 
				   PORTFOLIO WIDGET
				------------------------------------------------------------------------ */
				jQuery('#Container-featured-products').mixItUp({
					load: {
						filter: '.today'
					}
				});
				
				
				
				/* ------------------------------------------------------------------------ 
				   COUNTDOWN WIDGET
				------------------------------------------------------------------------ */
				var endDate = "June 7, 2087 15:03:25";
				jQuery('.countdown').countdown({
				  date: endDate,
				  render: function(data) {
					$(this.el).html("<div>"  + this.leadingZeros(data.days, 3) + " <span>days</span></div><div>" + this.leadingZeros(data.hours, 2) + " <span>hrs</span></div><div>" + this.leadingZeros(data.min, 2) + " <span>min</span></div><div>" + this.leadingZeros(data.sec, 2) + " <span>sec</span></div>");
				  }
				});
				
				
				
				/* ------------------------------------------------------------------------ 
				   CHECK OUT CUSTOM FUNCTION
				------------------------------------------------------------------------ */
				jQuery("#sort-widget-toggle-btn").on("click", function(){
					jQuery("#sort-widget-options").slideToggle();
					jQuery(this).find("i").toggleClass("fa-caret-down fa-caret-up");
					return false;
				});
				
				
				
				
				/* ------------------------------------------------------------------------ 
				   LANGUAGE SWITCHER
				------------------------------------------------------------------------ */
				jQuery('#polyglotLanguageSwitcher').polyglotLanguageSwitcher({
					effect: 'fade'
				});
				
					
					
					
				/* ------------------------------------------------------------------------ 
				   ITEM COUNTER CUSTOM SCRIPT
				------------------------------------------------------------------------ */
				var itemcount= 0;

				$('#pluss-item').on("click", function() { 
					itemcount++;
					$('#total-items').val(itemcount);
					return false;
				});

				$('#less-item').on("click", function() { 
					itemcount--;
					$('#total-items').val(itemcount);
					return false;
				});
				
				
				
				
				/* ------------------------------------------------------------------------ 
				   SMOOTH SCROLLING
				------------------------------------------------------------------------ */
				jQuery('.scroll').each( function() {
						var $this = jQuery(this), 
							target = this.hash;
							jQuery(this).click(function (e) { 
								e.preventDefault();
								if( $this.length > 0 ) {
									if($this.attr('href') == '#' ) {
										// Do nothing   
									} else {
									   jQuery('html, body').animate({ 
											scrollTop: (jQuery(target).offset().top) - -1
										}, 1000);
									}  
								}
							});
						});
				
				
				
				
				/* ------------------------------------------------------------------------ 
				   LOGIN REGISTER TABS
				------------------------------------------------------------------------ */
				jQuery('#login-register-tabs').easyResponsiveTabs({
					type: 'default', //Types: default, vertical, accordion           
					width: 'auto', //auto or any width like 600px
					fit: true,   // 100% fit in a container
					closed: 'accordion' // Start closed if in accordion view
				});
					
					
				/* ------------------------------------------------------------------------ 
				   CONTACT FORM
				------------------------------------------------------------------------ */
				jQuery("#contact_form").validationEngine('attach', {
					onValidationComplete: function(form, status){
					 //alert("The form status is: " +status+", it will never submit");
					 if(status == true){
					  var contact_form = $("#contact_form").serialize();
					  $.ajax({
					   type: "POST",
					   url: 'submit.php',
					   data: contact_form,
					   success: function(html)
					   { 
					   $("#contact_form").css('opacity', '0');
							$("#response").fadeIn();
							$("#response").html('<div class="success">' + html + '<div>');
							$('#contact_form')[0].reset();
					   
					   }
					  });
					 }
				
					}  
				   });
						
						
						
				/* ------------------------------------------------------------------------ 
				   NEWSLETTER FORM VALIDATION [use id to identify]
				------------------------------------------------------------------------ */
				jQuery("#email_form, #comment_form, #contact_form, #login_form, #login_form, #register_form").validationEngine();
				
				
				
				/* ------------------------------------------------------------------------ 
				   NEWSLETTER FORM
				------------------------------------------------------------------------ */
				jQuery("#email_form").validationEngine('attach', {
				onValidationComplete: function(form, status){
				 //alert("The form status is: " +status+", it will never submit");
				 if(status == true){
				  var email_form = $("#email_form").serialize();
				  $.ajax({
				   type: "POST",
				   url: 'submit.php',
				   data: email_form,
				   success: function(html)
				   {
				   $("#email_form").hide();
						$("#response2").show();
						$("#response2").html('<div class="success">' + html + '<div>');
						$('#email_form')[0].reset();
				   
				   }
				  });
				 }
			
				}  
			   });
					
					
					
				
					
			})(jQuery);