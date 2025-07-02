<?php

return [
        /*
        |--------------------------------------------------------------------------
        | Validation Language Lines
        |--------------------------------------------------------------------------
        |
        | The following language lines contain the default error messages used by
        | the validator class. Some of these rules have multiple versions such
        | as the size rules. Feel free to tweak each of these messages here.
        |
        */

        'accepted' => ':attributeを承認してください。',
        'accepted_if' => ':otherが:valueの場合、:attributeを承認してください。',
        'active_url' => ':attributeは有効なURLではありません。',
        'after' => ':attributeは:dateより後の日付にしてください。',
        'after_or_equal' => ':attributeは:date以降の日付にしてください。',
        'alpha' => ':attributeはアルファベットのみにしてください。',
        'alpha_dash' => ':attributeはアルファベット、数字、ダッシュ、アンダースコアのみにしてください。',
        'alpha_num' => ':attributeはアルファベットと数字のみにしてください。',
        'array' => ':attributeは配列にしてください。',
        'ascii' => ':attributeはシングルバイトの英数字と記号のみにしてください。',
        'before' => ':attributeは:dateより前の日付にしてください。',
        'before_or_equal' => ':attributeは:date以前の日付にしてください。',
        'between' => [
            'array' => ':attributeは:min〜:max個の項目にしてください。',
            'file' => ':attributeは:min〜:maxキロバイトにしてください。',
            'numeric' => ':attributeは:min〜:maxの間にしてください。',
            'string' => ':attributeは:min〜:max文字にしてください。',
        ],
        'boolean' => ':attributeはtrueかfalseにしてください。',
        'can' => ':attributeに権限がありません。',
        'confirmed' => ':attributeの確認が一致しません。',
        'current_password' => 'パスワードが正しくありません。',
        'date' => ':attributeは有効な日付ではありません。',
        'date_equals' => ':attributeは:dateと同じ日付にしてください。',
        'date_format' => ':attributeは:format形式と一致しません。',
        'decimal' => ':attributeは小数点以下が:decimal桁である必要があります。',
        'declined' => ':attributeは拒否されなければなりません。',
        'declined_if' => ':otherが:valueの場合、:attributeは拒否されなければなりません。',
        'different' => ':attributeと:otherは異なるものにしてください。',
        'digits' => ':attributeは:digits桁にしてください。',
        'digits_between' => ':attributeは:min〜:max桁にしてください。',
        'dimensions' => ':attributeは無効な画像サイズです。',
        'distinct' => ':attributeは重複した値を持っています。',
        'doesnt_contain' => ':attributeには:valuesが含まれていてはいけません。',
        'doesnt_start_with' => ':attributeは次のいずれかで始まってはいけません。:values。',
        'email' => ':attributeは有効なメールアドレスにしてください。',
        'ends_with' => ':attributeは次のいずれかで終わる必要があります。:values。',
        'enum' => '選択された:attributeは無効です。',
        'exists' => '選択された:attributeは無効です。',
        'file' => ':attributeはファイルにしてください。',
        'filled' => ':attributeは必須です。',
        'gt' => [
            'array' => ':attributeは:value個より多くの項目を持つ必要があります。',
            'file' => ':attributeは:valueキロバイトより大きくしてください。',
            'numeric' => ':attributeは:valueより大きくしてください。',
            'string' => ':attributeは:value文字より長くしてください。',
        ],
        'gte' => [
            'array' => ':attributeは:value個以上の項目を持つ必要があります。',
            'file' => ':attributeは:valueキロバイト以上でなければなりません。',
            'numeric' => ':attributeは:value以上でなければなりません。',
            'string' => ':attributeは:value文字以上でなければなりません。',
        ],
        'image' => ':attributeは画像にしてください。',
        'in' => '選択された:attributeは無効です。',
        'in_array' => ':attributeは:otherに存在しません。',
        'integer' => ':attributeは整数にしてください。',
        'ip' => ':attributeは有効なIPアドレスにしてください。',
        'ipv4' => ':attributeは有効なIPv4アドレスにしてください。',
        'ipv6' => ':attributeは有効なIPv6アドレスにしてください。',
        'json' => ':attributeは有効なJSON文字列にしてください。',
        'lt' => [
            'array' => ':attributeは:value個より少ない項目を持つ必要があります。',
            'file' => ':attributeは:valueキロバイトより小さくしてください。',
            'numeric' => ':attributeは:valueより小さくしてください。',
            'string' => ':attributeは:value文字より短くしてください。',
        ],
        'lte' => [
            'array' => ':attributeは:value個以下の項目を持つ必要があります。',
            'file' => ':attributeは:valueキロバイト以下でなければなりません。',
            'numeric' => ':attributeは:value以下でなければなりません。',
            'string' => ':attributeは:value文字以下でなければなりません。',
        ],
        'mac_address' => ':attributeは有効なMACアドレスである必要があります。',
        'max' => [
            'array' => ':attributeは:max個より多くの項目を持つことはできません。',
            'file' => ':attributeは:maxキロバイトを超えてはいけません。',
            'numeric' => ':attributeは:maxを超えてはいけません。',
            'string' => ':attributeは:max文字を超えてはいけません。',
        ],
        'max_digits' => ':attributeは最大:max桁である必要があります。',
        'mimes' => ':attributeは次のタイプである必要があります。:values。',
        'mimetypes' => ':attributeは次のタイプである必要があります。:values。',
        'min' => [
            'array' => ':attributeは:min個以上の項目を持つ必要があります。',
            'file' => ':attributeは:minキロバイト以上でなければなりません。',
            'numeric' => ':attributeは:min以上でなければなりません。',
            'string' => ':attributeは:min文字以上でなければなりません。',
        ],
        'min_digits' => ':attributeは少なくとも:min桁である必要があります。',
        'missing' => ':attributeフィールドは存在してはいけません。',
        'missing_if' => ':otherが:valueの場合、:attributeフィールドは存在してはいけません。',
        'missing_unless' => ':otherが:valueでない限り、:attributeフィールドは存在してはいけません。',
        'missing_with' => ':valuesが存在する場合、:attributeフィールドは存在してはいけません。',
        'missing_with_all' => ':valuesが存在する場合、:attributeフィールドは存在してはいけません。',
        'not_in' => '選択された:attributeは無効です。',
        'not_regex' => ':attributeの形式は無効です。',
        'numeric' => ':attributeは数字にしてください。',
        'password' => 'パスワードが正しくありません。',
        'present' => ':attributeは存在している必要があります。',
        'prohibited' => ':attributeは禁止されています。',
        'prohibited_if' => ':otherが:valueの場合、:attributeは禁止されています。',
        'prohibited_unless' => ':otherが:valueでない限り、:attributeは禁止されています。',
        'prohibits' => ':attributeフィールドは:otherの存在を禁止します。',
        'regex' => ':attributeの形式は無効です。',
        'required' => ':attributeは必須です。',
        'required_array_keys' => ':attributeフィールドには、:valuesのエントリが含まれている必要があります。',
        'required_if' => ':otherが:valueの場合、:attributeは必須です。',
        'required_if_accepted' => ':otherが承認された場合、:attributeフィールドは必須です。',
        'required_unless' => ':otherが:valuesに含まれていない限り、:attributeは必須です。',
        'required_with' => ':valuesが存在する場合、:attributeは必須です。',
        'required_with_all' => ':valuesが全て存在する場合、:attributeは必須です。',
        'required_without' => ':valuesが存在しない場合、:attributeは必須です。',
        'required_without_all' => ':valuesが全て存在しない場合、:attributeは必須です。',
        'same' => ':attributeと:otherは一致する必要があります。',
        'size' => [
            'array' => ':attributeは:size個の項目にしてください。',
            'file' => ':attributeは:sizeキロバイトにしてください。',
            'numeric' => ':attributeは:sizeにしてください。',
            'string' => ':attributeは:size文字にしてください。',
        ],
        'starts_with' => ':attributeは次のいずれかで始まる必要があります。:values。',
        'string' => ':attributeは文字列にしてください。',
        'timezone' => ':attributeは有効なタイムゾーンにしてください。',
        'unique' => ':attributeは既に存在します。',
        'uploaded' => ':attributeのアップロードに失敗しました。',
        'url' => ':attributeは有効なURLにしてください。',
        'uuid' => ':attributeは有効なUUIDにしてください。',

        /*
        |--------------------------------------------------------------------------
        | Custom Validation Language Lines
        |--------------------------------------------------------------------------
        |
        | Here you may specify custom validation messages for attributes using the
        | convention "attribute.rule" to name the lines. This makes it quick to
        | specify a specific custom language line for a given rule attribute.
        |
        */

        'custom' => [
            'attribute-name' => [
                'rule-name' => 'custom-message',
            ],
        ],

        /*
        |--------------------------------------------------------------------------
        | Custom Validation Attributes
        |--------------------------------------------------------------------------
        |
        | The following language lines are used to swap our attribute placeholder
        | with something more reader friendly such as "E-Mail Address" instead
        | of "email". This simply helps us make our message more expressive.
        |
        */

        'attributes' => [
            'name' => '名前',
            'email' => 'メールアドレス',
            'password' => 'パスワード',
            'title' => 'タイトル', // ★追加
            'body' => '質問内容', // ★追加
            'current_password' => '現在のパスワード',
            'password_confirmation' => 'パスワードの確認',
        ],
    ];
    