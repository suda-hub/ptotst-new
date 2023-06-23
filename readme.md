# シンス株式会社のWordPressテーマ作成用ベースファイル

## 構成

外部ファイル化したPHPファイルはこちらのフォルダ内に格納する。
→ /templates/

functions.phpに外部ファイルとして読み込む場合はこちらに格納する
→ /functions/

### _idot-template.php
このファイルには制作時によく使う関数が入っている
テーマ作成の最初の段階では、コピペしていくだけで一通り表示が終えられるはず。

### header.php
タイトルやOGPの set_meta_~関数はfunctions.phpにて設定している
YoastSEOとの相性は要検証