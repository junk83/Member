<?php

require "Member.php";

// members テーブルのデータを表します。
$member = new Member();

// メンバーのデータをセットします。
$member->set(array(
                    'name' => 'テスト名',
                    'age' => 30,
                    'email' => 'test@example.com',
                    )
            );

// $member->set() でセットしたデータを members テーブルに追加登録します。
// この時 created_at カラムに現在日時を自動的にセットするようにしてください。
// 登録が成功した場合は true 、失敗した場合は false を返します。
$result = $member->insert();
var_dump($result);

//2件目のデータを登録
$member->set(array(
                    'name' => 'テスト名2',
                    'age' => 31,
                    'email' => 'test2@example.com',
                    )
            );
$result = $member->insert();
var_dump($result);

//1件目と同じデータを登録
$member->set(array(
                    'name' => 'テスト名',
                    'age' => 30,
                    'email' => 'test@example.com',
                    )
            );
$result = $member->insert();
var_dump($result);

// 引数で指定されたメールアドレスのユーザーを members テーブルから探し、
// もし見つかった場合、そのデータを以下の形式で返します。
// array(
// 'id' => 'members テーブル の id カラムの値',
// 'name' => 'members テーブル の name カラムの値',
// 'age' => 'members テーブル の age カラムの値',
// 'email' => 'members テーブル の email カラムの値',
// 'created_at' => 'members テーブル の created_at カラムの値',
// );
// ユーザーが見つからなかった場合、false を返します。
$data = $member->findByEmail('test@example.com');
var_dump($data);

// 引数で指定された id を持つ members テーブルのレコードを削除します。
// 削除が成功した場合は true 、失敗した場合は false を返します。
$result = $member->delete($data['id']);
var_dump($result);

//削除後のデータを削除
$result = $member->delete($data['id']);
var_dump($result);

// ここでは false が返ってくるはずです。
$data = $member->findByEmail('test@example.co');
var_dump($data);
