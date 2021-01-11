/*
Copyright (c) 2003-2012, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.editorConfig = function( config )
{
	// Define changes to default configuration here. For example:
	 //config.language = 'pt-br';
	// config.uiColor = '#AADC6E';
	/*config.filebrowserBrowseUrl      = 'editor/ckfinder/ckfinder.html',
    config.filebrowserImageBrowseUrl = 'editor/ckfinder/ckfinder.html?type=Images',
    config.filebrowserFlashBrowseUrl = 'editor/ckfinder/ckfinder.html?type=Flash',
    config.filebrowserUploadUrl      = 'editor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
    config.filebrowserImageUploadUrl = 'editor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
    config.filebrowserFlashUploadUrl = 'editor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'*/
	
	
	// added code for ckfinder ------>
	config.basePath = 'editor/ckfinder/';
	config.filebrowserBrowseUrl = 'editor/ckfinder/ckfinder.html';
	config.filebrowserImageBrowseUrl = 'editor/ckfinder/ckfinder.html?type=Images';
	config.filebrowserFlashBrowseUrl = 'editor/ckfinder/ckfinder.html?type=Flash';
	config.filebrowserUploadUrl = 'editor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files&currentFolder=/upload/';
	config.filebrowserImageUploadUrl = 'editor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images&currentFolder=/upload/';
	config.filebrowserFlashUploadUrl = 'editor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash&currentFolder=/upload/'; 
	// end: code for ckfinder ------>
};