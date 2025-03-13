document.addEventListener("DOMContentLoaded", function () {//① ページが読み込まれたら処理を開始 (DOMContentLoaded)
    ////document,getElementById('lineChart')はhtmlで idでlinChartと指定していうものを取得している
    //getContext('2D')はグラフを描画するために必要。2Dで描画用
    const ctx = document.getElementById('lineChart').getContext('2d');
    new Chart(ctx, {//new Chart(ctx)はchart.jsをを使用してグラフを書くためのコード
        type: 'line',//グラフの種類を指定。
        data: {
            labels: labels,//グラフのX軸のラベル
            datasets: [{//グラフに指定するデータを指定する。
                label: '文字数',//グラフの凡例（どのデータかを説明）。
                data: dataValues,//グラフの Y軸（縦軸） の値（例: 売上データ）。
                borderColor: 'rgba(75, 192, 192, 1)',// 線の色
                backgroundColor: 'rgba(75, 192, 192, 0.2)',//線の下に塗る色（半透明）
                borderWidth: 2,//: 線の太さ。
                fill: true//: 背景色を塗るかどうか（true で塗る）。
            },
            ]
        },
        options: {//グラフのオプション
            responsive: true,//画面サイズに合わせてグラフの大きさを調整する
            scales: {// 軸（X軸・Y軸）の設定。
                y: { beginAtZero: true },//Y軸の値を 0 から始める（マイナス値を除く）
            },
            
            
        }
    });
});


