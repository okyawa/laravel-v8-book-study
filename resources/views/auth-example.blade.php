<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf8">
    <title>Bladeテンプレートによる認可処理</title>
</head>
<body>

<!-- リスト 6.5.3.1: 認可処理をBladeテンプレートに記述する例 -->
<!--
    ＠canや＠cannotなどのディレクティブが用意されている
    内部でコールされているメソッドは、Gateクラスのcheckメソッドやdeniesメソッド、anyメソッドなど
    基本的に、コントローラなどで行われる場合と全く同じ
-->
@can('edit', $content)
    <!-- コンテンツ編集のためのボタンなどを表示 -->
@elsecan('create', \App\Models\Content::class)
    <!-- コンテンツ作成のための描画が行われる -->
@endcan

<!-- リスト 6.5.3.2 Bladeテンプレート例 - BladeテンプレートとView Controller -->
<!--
    テンプレート描画でいくつかロジックが必要になる場合、View Controllerを利用することでロジックと描画を分離できる
    認可処理を組み合わせる例
    yeildディレクティブに対応する内容と認可処理を組み合わせる
-->
<div class="container">
    sample content
    @yield('authorized')
</div>

</body>
</html>
