/*
------ Vina Treeview Menu ------------
Plugin URI:  http://VinaThemes.biz
Version: 1.0.0
Author: VinaThems
Author URI: http://VinaThems.biz
*/  
(function() {  
    tinymce.create('tinymce.plugins.treeviewbutton', {  
        init : function(ed, url) {  
            ed.addButton('button_treeview', {  
                title : 'Vina Treeview Menu',  
                image : url + '/treemenu.png',  
                onclick : function() {  
					ed.focus();
                    ed.selection.setContent('[treeview_widget id="SHORT_CODER_ID"]</br>');  
                }  
            });  
        },  
        createControl : function(n, cm) {  
            return null;  
        }  
    });  
    tinymce.PluginManager.add('button_treeview', tinymce.plugins.treeviewbutton);  
})(); 