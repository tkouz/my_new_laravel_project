<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\Question; // Questionモデルをインポート
use App\Models\Answer;   // Answerモデルをインポート
use Illuminate\Support\Facades\Auth; // Authファサードをインポート

class QuestionController extends Controller
{
    /**
     * 質問の一覧を表示します。
     * キーワード検索、並び替え、ステータスフィルタリングの機能を含みます。
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request): View
    {
        // リクエストから検索キーワード、並び替え基準、ステータスフィルターを取得
        $keyword = $request->input('keyword');
        $sortBy = $request->input('sort_by', 'latest'); // デフォルトは「最新」
        $statusFilter = $request->input('status_filter', 'all'); // デフォルトは「全て」

        // Questionモデルのクエリビルダーを初期化
        $query = Question::query();

        // キーワード検索が指定されている場合
        if ($keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'LIKE', "%{$keyword}%") // タイトルにキーワードが含まれる
                  ->orWhere('content', 'LIKE', "%{$keyword}%"); // または質問内容にキーワードが含まれる
            });
        }

        // ステータスによる絞り込みが指定されている場合（'all'以外）
        if ($statusFilter !== 'all') {
            $query->where('status', $statusFilter); // 'open' (未解決) または 'resolved' (解決済み)
        }

        // 回答数をカウントするためにanswersリレーションをロード
        // paginateより前にwithCountを呼び出すことで、正しいカウントが取得される
        $query->withCount('answers');

        // 並び替えロジック
        switch ($sortBy) {
            case 'oldest': // 古い順
                $query->orderBy('created_at', 'asc');
                break;
            case 'most_answers': // 回答数が多い順
                $query->orderByDesc('answers_count');
                break;
            case 'latest': // 新しい順 (デフォルト)
            default:
                $query->orderByDesc('created_at');
                break;
        }

        // ユーザー情報をロードし、1ページあたり10件の質問を表示する
        $questions = $query->with('user')->paginate(10);

        // ビューにデータを渡して表示
        return view('questions.index', compact('questions', 'sortBy', 'statusFilter'));
    }

    /**
     * 特定の質問の詳細を表示します。
     * 回答、回答者、コメント、コメント投稿者も合わせてロードします。
     *
     * @param  \App\Models\Question  $question  表示する質問モデルのインスタンス
     * @return \Illuminate\View\View
     */
    public function show(Question $question): View
    {
        // 質問に紐付く回答、その回答に紐付くユーザー、そしてその回答に紐付くコメントとコメントの投稿者までをロード
        $question->load(['answers.user', 'answers.comments.user']);

        // ビューに質問データを渡して表示
        return view('questions.show', compact('question'));
    }

    /**
     * 新しい質問投稿フォームを表示します。
     *
     * @return \Illuminate\View\View
     */
    public function create(): View
    {
        return view('questions.create');
    }

    /**
     * 新しい質問をデータベースに保存します。
     * 投稿者ID、タイトル、内容、デフォルトステータスを設定します。
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        // リクエストデータのバリデーション
        $request->validate([
            'title' => 'required|string|max:255', // タイトルは必須、文字列、最大255文字
            'content' => 'required|string',       // 内容は必須、文字列
        ]);

        // 質問をデータベースに作成
        Question::create([
            'user_id' => auth()->id(),      // 認証済みユーザーのID
            'title' => $request->title,     // リクエストからタイトルを取得
            'content' => $request->content, // リクエストから内容を取得
            'status' => 'open',             // デフォルトステータスを「未解決」に設定
            'is_visible' => true,           // デフォルトで公開に設定
        ]);

        // 質問一覧ページへリダイレクトし、成功メッセージをセッションにフラッシュ
        return redirect()->route('questions.index')->with('status', '質問が投稿されました！');
    }

    /**
     * 既存の質問編集フォームを表示します。
     * 質問の投稿者のみがアクセスできます。
     *
     * @param  \App\Models\Question  $question  編集する質問モデルのインスタンス
     * @return \Illuminate\View\View
     */
    public function edit(Question $question): View
    {
        // 認証済みユーザーが質問の投稿者でない場合、403エラーを返す
        if (Auth::id() !== $question->user_id) {
            abort(403, 'Unauthorized action.'); // 認可されていないアクション
        }

        // ビューに質問データを渡して表示
        return view('questions.edit', compact('question'));
    }

    /**
     * 既存の質問をデータベースで更新します。
     * 質問の投稿者のみが操作できます。
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Question  $question  更新する質問モデルのインスタンス
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Question $question): RedirectResponse
    {
        // 認証済みユーザーが質問の投稿者でない場合、403エラーを返す
        if (Auth::id() !== $question->user_id) {
            abort(403, 'Unauthorized action.');
        }

        // リクエストデータのバリデーション
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        // 質問をデータベースで更新
        $question->update([
            'title' => $request->title,
            'content' => $request->content,
        ]);

        // 更新した質問の詳細ページへリダイレクトし、成功メッセージをセッションにフラッシュ
        return redirect()->route('questions.show', $question)->with('status', '質問が更新されました！');
    }

    /**
     * 既存の質問をデータベースから削除します。
     * 質問の投稿者のみが操作できます。
     *
     * @param  \App\Models\Question  $question  削除する質問モデルのインスタンス
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Question $question): RedirectResponse
    {
        // 認証済みユーザーが質問の投稿者でない場合、403エラーを返す
        if (Auth::id() !== $question->user_id) {
            abort(403, 'Unauthorized action.');
        }

        // 質問をデータベースから削除
        $question->delete();

        // 質問一覧ページへリダイレクトし、成功メッセージをセッションにフラッシュ
        return redirect()->route('questions.index')->with('status', '質問が削除されました。');
    }

    /**
     * 指定された回答をベストアンサーとしてマークし、質問を解決済みにします。
     * 質問の投稿者のみが操作できます。
     *
     * @param  \App\Models\Question  $question  対象の質問モデルのインスタンス
     * @param  \App\Models\Answer  $answer    ベストアンサーとしてマークする回答モデルのインスタンス
     * @return \Illuminate\Http\RedirectResponse
     */
    public function markAsBestAnswer(Question $question, Answer $answer): RedirectResponse
    {
        // 1. 認証済みユーザーが質問の投稿者であるか確認
        if (Auth::id() !== $question->user_id) {
            return redirect()->back()->with('error', 'この質問のベストアンサーを選定する権限がありません。');
        }

        // 2. その回答が対象の質問に属しているか確認
        if ($answer->question_id !== $question->id) {
            return redirect()->back()->with('error', '指定された回答はこの質問に属していません。');
        }

        // 3. 既に別のベストアンサーが選ばれている場合、既存のベストアンサーを解除
        $currentBestAnswer = $question->answers()->where('is_best_answer', true)->first();
        if ($currentBestAnswer && $currentBestAnswer->id !== $answer->id) {
            $currentBestAnswer->update(['is_best_answer' => false]);
        }

        // 4. 指定された回答をベストアンサーとしてマークする
        $answer->update(['is_best_answer' => true]);

        // 5. 質問のステータスを「解決済み」に更新する
        $question->update(['status' => 'resolved']);

        // 成功メッセージをセッションにフラッシュし、元のページへリダイレクト
        return redirect()->back()->with('status', 'ベストアンサーが選定され、質問が解決済みに変更されました！');
    }
}
