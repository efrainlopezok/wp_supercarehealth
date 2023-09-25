/*  jQuery Nice Select - v1.0
    https://github.com/hernansartorio/jquery-nice-select
    Made by Hernán Sartorio  */
!function(e){e.fn.niceSelect=function(t){function s(t){t.after(e("<div></div>").addClass("nice-select").addClass(t.attr("class")||"").addClass(t.attr("disabled")?"disabled":"").attr("tabindex",t.attr("disabled")?null:"0").html('<span class="current"></span><ul class="list"></ul>'));var s=t.next(),n=t.find("option"),i=t.find("option:selected");s.find(".current").html(i.data("display")||i.text()),n.each(function(t){var n=e(this),i=n.data("display");s.find("ul").append(e("<li></li>").attr("data-value",n.val()).attr("data-display",i||null).addClass("option"+(n.is(":selected")?" selected":"")+(n.is(":disabled")?" disabled":"")).html(n.text()))})}if("string"==typeof t)return"update"==t?this.each(function(){var t=e(this),n=e(this).next(".nice-select"),i=n.hasClass("open");n.length&&(n.remove(),s(t),i&&t.next().trigger("click"))}):"destroy"==t?(this.each(function(){var t=e(this),s=e(this).next(".nice-select");s.length&&(s.remove(),t.css("display",""))}),0==e(".nice-select").length&&e(document).off(".nice_select")):console.log('Method "'+t+'" does not exist.'),this;this.hide(),this.each(function(){var t=e(this);t.next().hasClass("nice-select")||s(t)}),e(document).off(".nice_select"),e(document).on("click.nice_select",".nice-select",function(t){var s=e(this);e(".nice-select").not(s).removeClass("open"),s.toggleClass("open"),s.hasClass("open")?(s.find(".option"),s.find(".focus").removeClass("focus"),s.find(".selected").addClass("focus")):s.focus()}),e(document).on("click.nice_select",function(t){0===e(t.target).closest(".nice-select").length&&e(".nice-select").removeClass("open").find(".option")}),e(document).on("click.nice_select",".nice-select .option:not(.disabled)",function(t){var s=e(this),n=s.closest(".nice-select");n.find(".selected").removeClass("selected"),s.addClass("selected");var i=s.data("display")||s.text();n.find(".current").text(i),n.prev("select").val(s.data("value")).trigger("change")}),e(document).on("keydown.nice_select",".nice-select",function(t){var s=e(this),n=e(s.find(".focus")||s.find(".list .option.selected"));if(32==t.keyCode||13==t.keyCode)return s.hasClass("open")?n.trigger("click"):s.trigger("click"),!1;if(40==t.keyCode){if(s.hasClass("open")){var i=n.nextAll(".option:not(.disabled)").first();i.length>0&&(s.find(".focus").removeClass("focus"),i.addClass("focus"))}else s.trigger("click");return!1}if(38==t.keyCode){if(s.hasClass("open")){var l=n.prevAll(".option:not(.disabled)").first();l.length>0&&(s.find(".focus").removeClass("focus"),l.addClass("focus"))}else s.trigger("click");return!1}if(27==t.keyCode)s.hasClass("open")&&s.trigger("click");else if(9==t.keyCode&&s.hasClass("open"))return!1});var n=document.createElement("a").style;return n.cssText="pointer-events:auto","auto"!==n.pointerEvents&&e("html").addClass("no-csspointerevents"),this}}(jQuery);

jQuery(function(){
    jQuery('.btn-circle').on('click',function(){
      jQuery('.btn-circle.btn-info').removeClass('btn-info').addClass('btn-default');
      jQuery(this).addClass('btn-info').removeClass('btn-default').blur();
    });
   
    jQuery('.next-step, .prev-step').on('click', function (e){
      var $activeTab = jQuery('.tab-pane.active');
   
      jQuery('.btn-circle.btn-info').removeClass('btn-info').addClass('btn-default');
   
      if ( jQuery(e.target).hasClass('next-step') )
      {
         var nextTab = $activeTab.next('.tab-pane').attr('id');
         jQuery('[href="#'+ nextTab +'"]').addClass('btn-info').removeClass('btn-default');
         jQuery('[href="#'+ nextTab +'"]').tab('show');
      }
      else
      {
         var prevTab = $activeTab.prev('.tab-pane').attr('id');
         jQuery('[href="#'+ prevTab +'"]').addClass('btn-info').removeClass('btn-default');
         jQuery('[href="#'+ prevTab +'"]').tab('show');
      }
    });
    jQuery('.select-style select').niceSelect();
  var countt = 0;
  jQuery('.page-template-template-orders .gform_confirmation_wrapper .gform_confirmation_message ol li').each(function(){
    countt++;
    jQuery(this).attr('count',countt);
  });
  jQuery('.check-option .ginput_container_checkbox .gfield_checkbox li label').append('<span>No</span>');
  jQuery('.check-option .ginput_container_checkbox .gfield_checkbox li input').on('change', function(){
    if (jQuery(this).is(':checked')){
      jQuery('.check-option .ginput_container_checkbox .gfield_checkbox li label span').html('Yes');
    }else{
      jQuery('.check-option .ginput_container_checkbox .gfield_checkbox li label span').html('No');
    }
  });
});
jQuery(document).on('ready', function(){
  jQuery('.customopt .ginput_container_radio .gfield_radio li input').attr('checked',true);
  jQuery('.selectedproducts .ginput_container_checkbox .gfield_checkbox li input').attr('checked',true);
  var val_mask = jQuery('.customopt .ginput_container_radio .gfield_radio li input').attr('value');
  if(val_mask == 'Nasal (covers nose)'){
    jQuery('.customopt').addClass('nasal');
  }
  if(val_mask == 'Full Face (covers nose and mouth)'){
    jQuery('.customopt').addClass('full-face');
  }
  if(val_mask == 'Nasal Pillow (covers nostrils)'){
    jQuery('.customopt').addClass('nasal-pillow');
  }
	if(jQuery('#gform_confirmation_wrapper_28').html().length > 0){
		jQuery('.header-register').hide();
		window.setTimeout(function(){
			window.location.href = 'http://supercarehealth.staging.clientqa.co/isleep-resupply-orders/';
		}, 4000);
	}
});