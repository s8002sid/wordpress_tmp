(function() {  
    tinymce.create('tinymce.plugins.wooscrollerbutton', {  
        init : function(ed, url) {  
            ed.addButton('button_wooscroller', {  
                title : 'Vina Wooproducts Scroller',  
                image : url + '/woocroller.png',  
                onclick : function() {  
					ed.focus();
                    ed.selection.setContent('[wooscroller_widget id="SHORT_WOO_CODER_ID" category_name="CATEGORY_NAME"]</br>');  
                }  
            });  
        },  
        createControl : function(n, cm) {  
            return null;  
        }  
    });  
    tinymce.PluginManager.add('button_wooscroller', tinymce.plugins.wooscrollerbutton);  
})(); 