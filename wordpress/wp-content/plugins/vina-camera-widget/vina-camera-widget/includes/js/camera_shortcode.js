(function() {  
    tinymce.create('tinymce.plugins.camerabutton', {  
        init : function(ed, url) {  
            ed.addButton('button_camera', {  
                title : 'Vina camera widget',  
                image : url + '/camera.png',  
                onclick : function() {  
					ed.focus();
                    ed.selection.setContent('[camera_widget id="SHORT_CODER_ID" category_ids="ARRAY_CATEGORY_ID"]</br>');  
                }  
            });  
        },  
        createControl : function(n, cm) {  
            return null;  
        }  
    });  
    tinymce.PluginManager.add('button_camera', tinymce.plugins.camerabutton);  
})(); 