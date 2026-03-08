<?php

return [
    'custom_edit' => [
        'name' => [
            'required' => '名前は必須です。',
        ],
        'username' => [
            'required' => 'ユーザー名は必須です。',
            'unique' => 'そのユーザー名は既に使われています。',
        ],
        'email' => [
            'email' => '有効なメールアドレスを入力してください。',
            'unique' => 'そのメールアドレスは既に使われています。',
        ],
        'password' => [
            'required' => 'パスワードは必須です。',
            'min' => 'パスワードは6文字以上で入力してください。',
        ],
        'status' => [
            'required' => 'ステータスは必須です。',
        ],
        'current_password' => [
            'required' => '現在のパスワードは必須です。',
            'invalid' => '現在のパスワードが一致しません。',
        ],
        'password' => [
            'required' => '新しいパスワードは必須です。',
            'min' => '新しいパスワードは6文字以上で入力してください。',
            'confirmed' => '新しいパスワードの確認が一致しません。',
        ],
    ],

    'name.required' => '名前は必須です。',
    'code.required' => 'コードは必須です。',
    'code.unique' => 'そのコードは既に使われています。',

    //Status
    'status_name.required' => 'ステータス名は必須項目です',
    'status_name.unique' => 'このステータス名は既に使用されています',
    'status_status.required' => 'ステータスフィールドは必須項目です',
    'status_status.boolean' => 'ステータスフィールドは真偽値でなければなりません',

    //Category
    'category_name.required' => 'カテゴリー名は必須項目です',
    'category_name.unique' => 'このカテゴリー名は既に使用されています',
    'category_parent_id.exists' => '選択した親カテゴリーは存在しません',
    'category_parent_id.not_in' => 'カテゴリーを自分自身の親にすることはできません',
    'category_status.required' => 'カテゴリーのステータスは必須項目です',
    'category_status.in' => '選択したカテゴリーのステータスは無効です',

    //Department
    'department_name.required' => '部署名は必須項目です',
    'department_name.unique' => 'この部署名は既に使用されています',
    
    //Defects
    'defect_category_id.required' => 'カテゴリーは必須項目です',
    'defect_status_id.required' => 'ステータスは必須項目です',
    'defect_occurred_at.required' => '発生日時は必須項目です',
    'defect_status.in' => '選択したステータスは無効です',
    'defect_images.image' => '各ファイルは画像でなければなりません',
    'defect_images.max' => '各画像は許可された最大サイズを超えてはいけません',

    //Users
    'custom_edit.name.required' => '名前は必須項目です',
    'custom_edit.username.required' => 'ユーザー名は必須項目です',
    'custom_edit.username.unique' => 'このユーザー名は既に使用されています',
    'custom_edit.email.email' => '有効なメールアドレスを入力してください',
    'custom_edit.email.unique' => 'このメールアドレスは既に使用されています',
    'custom_edit.password.required' => 'パスワードは必須項目です',
    'custom_edit.password.min' => 'パスワードは:min文字以上である必要があります',
    'custom_edit.role_id.required' => '役割は必須項目です',
    'custom_edit.department_id.required' => '部署は必須項目です',

];