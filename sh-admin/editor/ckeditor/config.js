/*

Copyright (c) 2003-2011, CKSource - Frederico Knabben. All rights reserved.

For licensing, see LICENSE.html or http://ckeditor.com/license

*/

CKEDITOR.editorConfig = function( config )
{
    config.filebrowserBrowseUrl      = 'editor/ckfinder/ckfinder.html',
    config.filebrowserImageBrowseUrl = 'editor/ckfinder/ckfinder.html?type=Images',
    config.filebrowserFlashBrowseUrl = 'editor/ckfinder/ckfinder.html?type=Flash',
    config.filebrowserUploadUrl      = 'editor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
    config.filebrowserImageUploadUrl = 'editor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
    config.filebrowserFlashUploadUrl = 'editor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash',
	config.pasteFromWordPromptCleanup = true
};