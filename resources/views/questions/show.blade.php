<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $question->title }} - 質問詳細</title>
    <style>
        body { font-family: sans-serif; margin: 20px; line-height: 1.6; }
        .container { max-width: 800px; margin: 0 auto; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        h1 { color: #333; border-bottom: 2px solid #eee; padding-bottom: 10px; margin-bottom: 20px; }
        h2 { color: #555; }
        p { color: #666; }
        .meta-info { font-size: 0.9em; color: #888; margin-top: 10px; }
        .back-link { display: inline-block; margin-top: 20px; padding: 8px 15px; background-color: #007bff; color: white; text-decoration: none; border-radius: 5px; }
        .back-link:hover { background-color: #0056b3; }
    </style>
</head>
<body>
    <div class="container">
        <p><a href="{{ route('questions.index') }}" class="back-link">← 質問一覧に戻る</a></p>

        <h1>{{ $question->title }}</h1>

        <h2>質問内容:</h2>
        <p>{{ $question->content }}</p>

        <div class="meta-info">
            <p>投稿者: {{ $question->user->username ?? '不明' }}</p>
            <p>投稿日時: {{ $question->created_at->format('Y年m月d日 H:i') }}</p>
        </div>

        {{-- ここに回答やコメントの表示・投稿フォームなどを追加していく --}}
        <hr style="margin-top: 30px; margin-bottom: 30px;">
        <h3>回答</h3>
        @if ($question->answers->isEmpty())
        <p>まだ回答はありません。</p>
        @else
        <div class="answers-list">
            @foreach ($question->answers as $answer)
                <div class="answer" style="border: 1px solid #eee; padding: 15px; margin-bottom: 10px; border-radius: 5px; background: #f9f9f9;">
                    <p style="margin-bottom: 5px;">{{ $answer->content }}</p>
                    <div style="font-size: 0.85em; color: #777; text-align: right;">
                        投稿者: {{ $answer->user->username ?? '不明' }}
                        - {{ $answer->created_at->format('Y年m月d日 H:i') }}
                        @if ($answer->is_best_answer)
                            <span style="background-color: #28a745; color: white; padding: 3px 8px; border-radius: 3px; margin-left: 10px;">ベストアンサー</span>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif
    {{-- ★ここまで回答の表示部分 --}}
    </div>
</body>
</html>