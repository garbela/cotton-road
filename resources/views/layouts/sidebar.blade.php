<div class="container-fluid" style="height: 90%">
    <div class="row h-100">
        <nav class="col-md-2 d-none d-md-block sidebar mt-3 border-right">
            <div class="sidebar-sticky">
                <ul class="nav flex-column">
                    @if (Auth::user()->type === 'admin')
                        <li class="nav-item">ユーザ系</li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/admin/user') }}">ユーザ情報</a>
                        </li>
                        <li>
                            <a class="nav-link" href="{{ url('/admin/user/operate') }}">ユーザ操作</a>
                        </li>
                        <li class="nav-item">商品系</li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/admin/products') }}">商品一覧</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/admin/sales') }}">売上一覧</a>
                        </li>
                        <li class="nav-item">発注・入庫系</li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/admin/orders/yet') }}">未発注一覧</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/admin/orders/wait') }}">入庫待ち一覧</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/admin/orders/done') }}">入庫済み一覧</a>
                        </li>
                        <li class="nav-item">出庫系</li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/admin/shipments/yet') }}">未出庫一覧</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/admin/shipments/done') }}">出庫済み一覧</a>
                        </li>
                    @elseif (Auth::user()->type === 'seller')
                        <li class="nav-item">ユーザ系</li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/seller/user') }}">ユーザ情報</a>
                        </li>
                        <li class="nav-item">商品系</li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/seller/products') }}">商品一覧</a>
                        </li>
                        <li class="nav-item">納品系</li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/seller/delivery/yet') }}">未納品一覧</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/seller/delivery/done') }}">納品済み一覧</a>
                        </li>
                    @elseif (Auth::user()->type === 'customer')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/customer/user') }}">ユーザ情報</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/customer/products') }}">商品一覧</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/customer/products/history') }}">購入履歴</a>
                        </li>
                    @endif
                </ul>
            </div>
        </nav>

        <main role="main" class="col-md-9 col-lg-10 pt-3 px-4">
            @yield('content')
        </main>
    </div>
</div>