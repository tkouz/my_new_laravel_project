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

            'accepted'             => ':attributeを承認してください。',
            'accepted_if'          => ':otherが:valueの場合、:attributeを承認してください。',
            'active_url'           => ':attributeは有効なURLではありません。',
            'after'                => ':attributeは:dateより後の日付にしてください。',
            'after_or_equal'       => ':attributeは:date以降の日付にしてください。',
            'alpha'                => ':attributeは文字のみにしてください。',
            'alpha_dash'           => ':attributeは文字、数字、ダッシュ、アンダースコアのみにしてください。',
            'alpha_num'            => ':attributeは文字と数字のみにしてください。',
            'array'                => ':attributeは配列にしてください。',
            'ascii'                => ':attributeはシングルバイト英数字記号のみにしてください。',
            'before'               => ':attributeは:dateより前の日付にしてください。',
            'before_or_equal'      => ':attributeは:date以前の日付にしてください。',
            'between'              => [
                'array'   => ':attributeは:minから:max個の項目にしてください。',
                'file'    => ':attributeは:minから:maxキロバイトにしてください。',
                'numeric' => ':attributeは:minから:maxの間にしてください。',
                'string'  => ':attributeは:minから:max文字にしてください。',
            ],
            'boolean'              => ':attributeはtrueまたはfalseにしてください。',
            'can'                  => ':attributeには無許可の値が含まれています。',
            'confirmed'            => ':attributeの確認が一致しません。',
            'current_password'     => 'パスワードが正しくありません。',
            'date'                 => ':attributeは有効な日付ではありません。',
            'date_equals'          => ':attributeは:dateと同じ日付にしてください。',
            'date_format'          => ':attributeは:format形式と一致しません。',
            'decimal'              => ':attributeは:decimal桁の小数点以下が必要です。',
            'declined'             => ':attributeは拒否されなければなりません。',
            'declined_if'          => ':otherが:valueの場合、:attributeは拒否されなければなりません。',
            'different'            => ':attributeと:otherは異なる値にしてください。',
            'digits'               => ':attributeは:digits桁の数字にしてください。',
            'digits_between'       => ':attributeは:minから:max桁の間にしてください。',
            'dimensions'           => ':attributeの画像サイズが無効です。',
            'distinct'             => ':attributeフィールドに重複する値があります。',
            'doesnt_contain'       => ':attributeフィールドには:valuesのいずれかの値が含まれていてはいけません。',
            'doesnt_end_with'      => ':attributeは次のいずれかで終わってはいけません: :values。',
            'doesnt_start_with'    => ':attributeは次のいずれかで始まってはいけません: :values。',
            'email'                => ':attributeは有効なメールアドレスにしてください。',
            'ends_with'            => ':attributeは次のいずれかで終わってください: :values。',
            'enum'                 => '選択された:attributeは無効です。',
            'exists'               => '選択された:attributeは無効です。',
            'file'                 => ':attributeはファイルにしてください。',
            'filled'               => ':attributeフィールドは必須です。',
            'gt'                   => [
                'array'   => ':attributeは:value個より多くの項目が必要です。',
                'file'    => ':attributeは:valueキロバイトより大きくしてください。',
                'numeric' => ':attributeは:valueより大きくしてください。',
                'string'  => ':attributeは:value文字より大きくしてください。',
            ],
            'gte'                  => [
                'array'   => ':attributeは:value個以上の項目が必要です。',
                'file'    => ':attributeは:valueキロバイト以上でなければなりません。',
                'numeric' => ':attributeは:value以上でなければなりません。',
                'string'  => ':attributeは:value文字以上でなければなりません。',
            ],
            'image'                => ':attributeは画像にしてください。',
            'in'                   => '選択された:attributeは無効です。',
            'in_array'             => ':attributeフィールドは:otherに存在しません。',
            'integer'              => ':attributeは整数にしてください。',
            'ip'                   => ':attributeは有効なIPアドレスにしてください。',
            'ipv4'                 => ':attributeは有効なIPv4アドレスにしてください。',
            'ipv6'                 => ':attributeは有効なIPv6アドレスにしてください。',
            'json'                 => ':attributeは有効なJSON文字列にしてください。',
            'lowercase'            => ':attributeは小文字にしてください。',
            'lt'                   => [
                'array'   => ':attributeは:value個より少ない項目が必要です。',
                'file'    => ':attributeは:valueキロバイトより小さくしてください。',
                'numeric' => ':attributeは:valueより小さくしてください。',
                'string'  => ':attributeは:value文字より小さくしてください。',
            ],
            'lte'                  => [
                'array'   => ':attributeは:value個以下の項目にしてください。',
                'file'    => ':attributeは:valueキロバイト以下にしてください。',
                'numeric' => ':attributeは:value以下にしてください。',
                'string'  => ':attributeは:value文字以下にしてください。',
            ],
            'mac_address'          => ':attributeは有効なMACアドレスにしてください。',
            'max'                  => [
                'array'   => ':attributeは:max個以下の項目にしてください。',
                'file'    => ':attributeは:maxキロバイト以下にしてください。',
                'numeric' => ':attributeは:max以下にしてください。',
                'string'  => ':attributeは:max文字以下にしてください。',
            ],
            'max_digits'           => ':attributeは:max桁以下にしてください。',
            'mimes'                => ':attributeは次のファイルタイプにしてください: :values。',
            'mimetypes'            => ':attributeは次のファイルタイプにしてください: :values。',
            'min'                  => [
                'array'   => ':attributeは:min個以上の項目が必要です。',
                'file'    => ':attributeは:minキロバイト以上でなければなりません。',
                'numeric' => ':attributeは:min以上でなければなりません。',
                'string'  => ':attributeは:min文字以上でなければなりません。',
            ],
            'min_digits'           => ':attributeは:min桁以上でなければなりません。',
            'missing'              => ':attributeフィールドは存在してはいけません。',
            'missing_if'           => ':otherが:valueの場合、:attributeフィールドは存在してはいけません。',
            'missing_unless'       => ':otherが:valueでない限り、:attributeフィールドは存在してはいけません。',
            'missing_with'         => ':valuesが存在する場合、:attributeフィールドは存在してはいけません。',
            'missing_with_all'     => ':valuesがすべて存在する場合、:attributeフィールドは存在してはいけません。',
            'multiple_of'          => ':attributeは:valueの倍数でなければなりません。',
            'not_in'               => '選択された:attributeは無効です。',
            'not_regex'            => ':attributeの形式が無効です。',
            'numeric'              => ':attributeは数字にしてください。',
            'password'             => [
                'letters'       => ':attributeは少なくとも1つの文字を含まなければなりません。',
                'mixed'         => ':attributeは少なくとも1つの大文字と1つの小文字を含まなければなりません。',
                'numbers'       => ':attributeは少なくとも1つの数字を含まなければなりません。',
                'symbols'       => ':attributeは少なくとも1つの記号を含まなければなりません。',
                'uncompromised' => '指定された:attributeはデータ漏洩で出現しました。別の:attributeを選択してください。',
            ],
            'present'              => ':attributeフィールドは存在しなければなりません。',
            'prohibited'           => ':attributeフィールドは禁止されています。',
            'prohibited_if'        => ':otherが:valueの場合、:attributeフィールドは禁止されています。',
            'prohibited_unless'    => ':otherが:valueでない限り、:attributeフィールドは禁止されています。',
            'prohibits'            => ':attributeフィールドは:otherの存在を禁止します。',
            'regex'                => ':attributeの形式が無効です。',
            'required'             => ':attributeフィールドは必須です。',
            'required_array_keys'  => ':attributeフィールドには、:valuesのエントリが必要です。',
            'required_if'          => ':otherが:valueの場合、:attributeフィールドは必須です。',
            'required_if_accepted' => ':otherが承認された場合、:attributeフィールドは必須です。',
            'required_unless'      => ':otherが:valuesに含まれていない限り、:attributeフィールドは必須です。',
            'required_with'        => ':valuesが存在する場合、:attributeフィールドは必須です。',
            'required_with_all'    => ':valuesがすべて存在する場合、:attributeフィールドは必須です。',
            'required_without'     => ':valuesが存在しない場合、:attributeフィールドは必須です。',
            'required_without_all' => ':valuesがすべて存在しない場合、:attributeフィールドは必須です。',
            'same'                 => ':attributeと:otherは一致しなければなりません。',
            'size'                 => [
                'array'   => ':attributeは:size個の項目にしてください。',
                'file'    => ':attributeは:sizeキロバイトにしてください。',
                'numeric' => ':attributeは:sizeにしてください。',
                'string'  => ':attributeは:size文字にしてください。',
            ],
            'starts_with'          => ':attributeは次のいずれかで始まってください: :values。',
            'string'               => ':attributeは文字列にしてください。',
            'timezone'             => ':attributeは有効なタイムゾーンにしてください。',
            'unique'               => ':attributeはすでに存在します。',
            'uploaded'             => ':attributeのアップロードに失敗しました。',
            'uppercase'            => ':attributeは大文字にしてください。',
            'url'                  => ':attributeは有効なURLにしてください。',
            'ulid'                 => ':attributeは有効なULIDにしてください。',
            'uuid'                 => ':attributeは有効なUUIDにしてください。',

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
                'email'    => 'メールアドレス',
                'password' => 'パスワード',
                'name'     => 'ユーザー名', // 新規登録ページ用
                'title'    => 'タイトル',   // 質問投稿ページ用
                'body'     => '内容',     // 質問投稿ページ用
                'content'  => '回答本文', // 回答投稿ページ用
            ],
        ];
        