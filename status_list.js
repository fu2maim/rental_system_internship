jQuery(function ($) {
    // セレクトボックスが変更されたら処理をする
    $('#button').click(function () {
    
        // 選択した値を取得
        var select_val = $('document.forms.id_filter_search.value').val();
        
        // tbodyのtr数回 処理をする
        $.each($("#list tbody tr"), function (index, element) {
        
            // 選択した値が空欄だったら、全ての行を表示する為の処理
            if (select_val == "") {
                $(element).css("display", "table-row");
                return true; // 次のtrへ
            }
            
            // 1行をテキストとして取り出し、セレクトボックスで選択した値があるかをチェック
            var row_text = $(element).text();
            
            if (row_text.indexOf(select_val) != -1) {
                // 見つかった場合は表示する
                $(element).css("display", "table-row");
            } else {
                // 見つからなかった場合は非表示に
                $(element).css("display", "none");
            }
 
        });
    });
});