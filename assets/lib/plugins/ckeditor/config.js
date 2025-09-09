CKEDITOR.editorConfig = function (config) {
    config.allowedContent = true;
    config.removeFormatAttributes = '';
    CKEDITOR.dtd.$removeEmpty['i'] = false;
    
//    config.extraPlugins = 'stylesheetparser';
//    config.contentsCss = 'http://localhost/ngocareer/assets/lib/ajax.css';
    CKEDITOR.stylesSet.add('my_styles', [
        // Block-level styles
        { name: 'Blue Title', element: 'h2', styles: { 'color': 'Blue' } },
        { name: 'Red Title', element: 'h3', styles: { 'color': 'Red' } },

        // Inline styles
        { name: 'CSS Style', element: 'span', attributes: { 'class': 'my_style' } },
        { name: 'Marker: Yellow', element: 'span', styles: { 'background-color': 'Yellow' } }
    ]);
    config.stylesSet = 'my_styles';

//    config.contentsCss = 'sample_CSS_file.css';
    config.contentsCss = [
        'http://localhost/ngocareer/assets/lib/ajax.css',
        'http://localhost/ngocareer/assets/lib/bootstrap4/css/bootstrap.css'
    ];

    config.filebrowserBrowseUrl 	= 'assets/lib/plugins/ckeditor/plugins/kcfinder/browse.php?type=files';
    config.filebrowserImageBrowseUrl 	= 'assets/lib/plugins/ckeditor/plugins/kcfinder/browse.php?type=images';
    config.filebrowserFlashBrowseUrl 	= 'assets/lib/plugins/plugins/ckeditor/plugins/kcfinder/browse.php?type=flash';
    config.filebrowserUploadUrl 	= 'assets/lib/plugins/ckeditor/plugins/kcfinder/upload.php?type=files';
    config.filebrowserImageUploadUrl 	= 'assets/lib/plugins/ckeditor/plugins/kcfinder/upload.php?type=images';
    config.filebrowserFlashUploadUrl 	= 'assets/lib/plugins/ckeditor/plugins/kcfinder/upload.php?type=flash';
};