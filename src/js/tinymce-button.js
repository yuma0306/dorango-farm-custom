(function() {
    tinymce.PluginManager.add('marker', function( editor, url ) {
        editor.addButton('marker', {
            title: 'マーカー',
			icon: 'mce-ico mce-i-underline',
            cmd: 'marker',
        });
		// マーカーを削除するボタン
        editor.addButton('removeMarker', {
            title: 'マーカー削除',
            icon: 'mce-ico mce-i-remove',
            cmd: 'removeMarker',
        });
        editor.addCommand('marker', function() {
            let selectedText = editor.selection.getContent({
                'format': 'html'
            });
            if (selectedText.length === 0) {
                return;
            }
            let openColumn = '<span style="background: linear-gradient(transparent 70%, #FFE600 70%);">';
            let closeColumn = '</span>';
            let returnText = '';
            returnText = openColumn + selectedText + closeColumn;
            editor.execCommand('mceReplaceContent', false, returnText);
            return;
        });
		 // マーカー削除
		editor.addCommand('removeMarker', function() {
            let selectedText = editor.selection.getContent({
                'format': 'html'
            });
            if (selectedText.length === 0) {
                return;
            }
            selectedText = selectedText.replace(/<span style="background: linear-gradient\(transparent 70%, #FFE600 70%\);">|<\/span>/g, '');
            editor.execCommand('mceReplaceContent', false, selectedText);
        });
    });
})();
