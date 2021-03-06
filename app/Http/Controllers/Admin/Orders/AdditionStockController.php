<?php

namespace App\Http\Controllers\Admin\Orders\Addition;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\StockAdditionStatusLog;
use DB;
use App\Http\Requests\Admin\Orders\Addition\ApproveRequest;
use App\Http\Requests\Admin\Orders\Addition\NoApproveRequest;
use App\Http\Requests\Admin\Orders\Addition\AddContainerRequest;
use App\Http\Requests\Admin\Orders\Addition\SendBackRequest;
use App\Http\Requests\Admin\Orders\Addition\WaitDisposalRequest;
use App\Http\Requests\Admin\Orders\Addition\DisposalRequest;
use App\Events\AdditionStockStatusMoved;

/**
 * 追加在庫一覧のコントローラー
 *
 * Class AdditionStockController
 * @package App\Http\Controllers\Admin\Orders\Addition
 */
class AdditionStockController extends Controller
{
    /**
     * 新規商品一覧画面
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $unapprovedStocks = Product::where('product_status_id', 3)->where('stock_addition_status_id', 2)->oldest('created_at')->paginate(10, ['*'], 'unapprovedPage');
        $waitContainerStocks = Product::where('product_status_id', 3)->where('stock_addition_status_id', 3)->oldest('created_at')->paginate(10, ['*'], 'waitContainerPage');
        $waitBackStocks = Product::where('product_status_id', 3)->where('stock_addition_status_id', 4)->oldest('created_at')->paginate(10, ['*'], 'waitBackPage');
        $waitDisposalStocks = Product::where('product_status_id', 3)->where('stock_addition_status_id', 5)->oldest('created_at')->paginate(10, ['*'], 'waitDisposalPage');

        return view('admin.orders.addition', [
            'unapprovedStocks' => $unapprovedStocks,
            'waitBackStocks' => $waitBackStocks,
            'waitContainerStocks' => $waitContainerStocks,
            'waitDisposalStocks' => $waitDisposalStocks,
        ]);
    }

    /**
     * 承認処理
     *
     * @param ApproveRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function approve(ApproveRequest $request)
    {
        DB::transaction(function () use ($request) {
            Product::where('id', $request->product_id)->update([
                'stock_addition_status_id' => 3,
            ]);

            StockAdditionStatusLog::create([
                'product_id' => $request->product_id,
                'stock_addition_status_id' => 3,
                'user_id' => $request->user_id,
            ]);

            event(new AdditionStockStatusMoved('approve', $request->user_id, $request->product_id));
        });

        return redirect('/admin/orders/addition');
    }

    /**
     * 否承認処理(返送待ち移動処理)
     *
     * @param NoApproveRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function noApprove(NoApproveRequest $request)
    {
        DB::transaction(function () use ($request) {
            Product::where('id', $request->product_id)->update([
                'stock_addition_status_id' => 4,
            ]);

            StockAdditionStatusLog::create([
                'product_id' => $request->product_id,
                'stock_addition_status_id' => 4,
                'user_id' => $request->user_id,
            ]);

            event(new AdditionStockStatusMoved('noApprove', $request->user_id, $request->product_id));
        });

        return redirect('/admin/orders/addition');
    }

    /**
     * コンテナ追加処理
     *
     * @param AddContainerRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function addContainer(AddContainerRequest $request)
    {
        $stock_additions = Product::select('stock_additions')->where('id', $request->product_id)->first()->stock_additions;

        DB::transaction(function () use ($request, $stock_additions) {
            Product::where('id', $request->product_id)->update([
                'stock_addition_status_id' => 1,
                'stock_additions' => 0,
                'stock_number' => DB::raw('stock_number + ' . $stock_additions),
            ]);

            StockAdditionStatusLog::create([
                'product_id' => $request->product_id,
                'stock_addition_status_id' => 6,
                'user_id' => $request->user_id,
            ]);

            event(new AdditionStockStatusMoved('addContainer', $request->user_id, $request->product_id));
        });

        return redirect('/admin/orders/addition');
    }

    /**
     * 返送待ち移動処理
     *
     * @param SendBackRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function sendBack(SendBackRequest $request)
    {
        DB::transaction(function () use ($request) {
            Product::where('id', $request->product_id)->update([
                'stock_addition_status_id' => 1,
            ]);

            StockAdditionStatusLog::create([
                'product_id' => $request->product_id,
                'stock_addition_status_id' => 7,
                'user_id' => $request->user_id,
            ]);

            event(new AdditionStockStatusMoved('sendBack', $request->user_id, $request->product_id));
        });

        return redirect('admin/orders/addition');
    }

    /**
     * 廃棄処分待ち移動処理
     *
     * @param WaitDisposalRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function waitDisposal(WaitDisposalRequest $request)
    {
        DB::transaction(function () use ($request) {
            Product::where('id', $request->product_id)->update([
                'stock_addition_status_id' => 5,
            ]);

            StockAdditionStatusLog::create([
                'product_id' => $request->product_id,
                'stock_addition_status_id' => 5,
                'user_id' => $request->user_id,
            ]);

            event(new AdditionStockStatusMoved('waitDisposal', $request->user_id, $request->product_id));
        });

        return redirect('/admin/orders/addition');
    }

    /**
     * 廃棄処理
     *
     * @param DisposalRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function disposal(DisposalRequest $request)
    {
        DB::transaction(function () use ($request) {
            Product::where('id', $request->product_id)->update([
                'stock_addition_status_id' => 1,
            ]);

            StockAdditionStatusLog::create([
                'product_id' => $request->product_id,
                'stock_addition_status_id' => 8,
                'user_id' => $request->user_id,
            ]);

            event(new AdditionStockStatusMoved('disposal', $request->user_id, $request->product_id));
        });

        return redirect('/admin/orders/addition');
    }
}
