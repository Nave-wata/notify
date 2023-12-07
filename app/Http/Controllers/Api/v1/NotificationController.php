<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\NotificationMailRequest;
use App\Jobs\SendMail;
use Illuminate\Http\JsonResponse;

class NotificationController extends Controller
{
    /**
     * リクエストを受け取り，メール送信のジョブをキューに追加する
     *　メールの送信は非同期で行われる．
     * レスポンスは正しいリクエストを受け取ったことを示すものであり，メールの送信が完了したことを示すものではない
     *
     * @param NotificationMailRequest $request 検証済みリクエスト
     * @return JsonResponse レスポンス
     */
    public function mail(NotificationMailRequest $request): JsonResponse
    {
        SendMail::dispatch($request->input('to'), $request->input('body'));

        return response()->json([
            'message' => 'Request accepted.',
        ]);
    }
}
