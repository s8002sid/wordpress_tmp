var loading_button=function(){jQuery('#publishing-action input[type="submit"]').each(function(){var a=jQuery(this);a.hasClass("button-primary")?a.addClass("button-primary-disabled"):a.addClass("button-disabled");"publish"==jQuery(this).attr("id")?jQuery("#ajax-loading").css("visibility","visible"):jQuery("#draft-ajax-loading").css("visibility","visible")})}; jQuery(document).ready(function(a){var f=wpCookies.get("active_metabox_tab"),f=null==f?a("ul.settings-tabs li:first-child a").attr("href"):"#"+f;a(".settings-tabs a").click(function(){var b=a(this).attr("href");a(this).parent().addClass("tabs").siblings("li").removeClass("tabs");a(".tabs-panel").hide();a(b).show();return!1});a(".settings-tab .slide-settings").hide();a(a(".settings-tab .slides-wrapper:not(.extra-images) a.selected").attr("href")).show();a(document).on("click",".settings-tab .slides-wrapper:not(.extra-images) a", function(){a(".settings-tab .slides-wrapper:not(.extra-images) .edit").removeClass("edit");a(".settings-tab .slides-wrapper:not(.extra-images) .selected").removeClass("selected");a(this).addClass("selected");a("img",this).addClass("edit");a(".settings-tab .slide-settings").hide();a(a(this).attr("href")).show();return!1});var m=function(){loading_button();var b={action:"update_images_post_type",post_id:post_id,post_type:typenow};a("#add-items-ajax-loading").css("visibility","visible");a.post(ajaxurl, b,function(b){var h=a("#item-0").clone();a.each(b,function(b,c){if(0==a("#item-"+c).length){var e=h.clone(),l=parseInt(a('.slide-settings:last input[name$="[order]"]').val())+1;e.attr("id","item-"+c);a('input[name$="[order]"]',e).val(l);a("input, select, textarea, div, label",e).each(function(){var b=a(this).attr("name"),h=a(this).attr("id"),e=a(this).attr("for");void 0!=b&&a(this).attr("name",b.replace(0,c));void 0!=h&&a(this).attr("id",h.replace(0,c));void 0!=e&&a(this).attr("for",e.replace(0,c))}); e.appendTo("#images-post-type").hide()}});wpCookies.set("active_metabox_tab","item-edit");window.onbeforeunload=null;a("#post").submit()},"json")};a(document).on("click",".add-items",function(){tb_show("","media-upload.php?post_id="+post_id+"&TB_iframe=1&width=700");window.send_to_editor=function(a){m();tb_remove()};a("body").bind("tb_unload",m);return!1});a(".slides-wrapper:not(.extra-images).ui-sortable").sortable({axis:"x",stop:function(b,c){a(".slides-wrapper:not(.extra-images).ui-sortable li").each(function(b){var c= a("a",this).attr("href");a(c+" .order").attr("value",b)})}});a(document).on("click",".slide-settings .delete-item",function(){if(!confirm(cpt.delete_item))return!1;var b=a(this).attr("rel"),c={action:"delete_item_post_type",item_id:b,post_id:post_id};a("#delete-item-ajax-loading-"+b).css("visibility","visible");a.post(ajaxurl,c,function(c){a('.slides-wrapper:not(.extra-images) a[href="#item-'+b+'"]').parent().remove();a("#item-"+b).remove();c=a(".slides-wrapper:not(.extra-images) li:first-child a").addClass("selected").attr("href"); a(c).show();a("#delete-item-ajax-loading-"+b).css("visibility","hidden")});return!1});"undefined"!=typeof items_id&&a.each(items_id,function(b,c){a("#"+cpt_metabox_name+"_image_"+c).next().removeClass("upload_button").click(function(){var b=a(this).prev();tb_show("","media-upload.php?post_id=0&type=image&TB_iframe=true&width=700");window.send_to_editor=function(k){var f=a("a","<div>"+k+"</div>").attr("href"),e=a("img",k).attr("class").replace(/(.*?)wp-image-/,"");k={action:"update_image_post_type", from_item_id:c,post_id:post_id,to_item_id:e};b.val(f);$this_item=b.parents(".slide-settings");var l=$this_item.attr("id"),g=f.split(".").reverse(),g=f.replace("."+g[0],"")+"-140x100."+g[0];a('a[href="#'+$this_item.attr("id")+'"] img').attr("src",g);a("select, input, textarea",$this_item).each(function(){var b=a(this).attr("name"),f=a(this).attr("id");void 0!=b&&a(this).attr("name",b.replace(c,e));void 0!=f&&a(this).attr("id",f.replace(c,e))});a("label",$this_item).each(function(){var b=a(this).attr("for"); void 0!=b&&a(this).attr("for",b.replace(c,e))});void 0!=l&&$this_item.attr("id",l.replace(c,e));a('a[href="#item-'+c+'"]').attr("href","#"+$this_item.attr("id"));a.post(ajaxurl,k,function(b){d=new Date;a('a[href="#'+$this_item.attr("id")+'"] img').attr("src",g+"?"+d.getTime())});tb_remove()};return!1})});"post-php"==adminpage&&a(".tabs-panel:first select:first").change(function(){a(this).parents(".tabs-panel").find(".sep:first ~ div:not(#config-notice)").hide();0==a("#config-notice").length&&a(this).parents(".tabs-panel").append('<div id="config-notice" class="the-metabox simple-text clearfix"><p>'+ cpt.update_item+"</p></div>").show()});a("#post").submit(function(){var b=a(".settings-tabs li.tabs a").attr("href");wpCookies.set("active_metabox_tab",b.replace("#",""))});a(document).on("click",".remove_cat",function(){var b=a(this).parents("li"),c=a("input",b).val();a.post(ajaxurl,{action:"delete_category_post_type",post_id:post_id,cat_slug:c},function(b){a('input[value="'+c+'"]').each(function(){a(this).parents("li").remove()})});return!1});wpCookies.remove("active_metabox_tab")});