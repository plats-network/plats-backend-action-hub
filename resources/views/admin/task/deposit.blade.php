@extends('admin.layout')
@section('content')
    <x-admin::top_page title="Deposit"/>
    <div class="row">
        <div class="col-12">
            <!-- Plugin not found -->
            <div class="alert alert-danger"  id="err_box" style="display: none">
                <h4 class="alert-heading js-error-title">Plugin not found</h4>
                <p class="js-error-message">
                    Hãy cài đặt plugin
                </p>
            </div>
            <!-- END Plugin not found -->
            <div class="card h-100 bg-gradient-light" id="deposit_process">
                <div class="card-body row g-0">
                    <div class="col-12">
                        <div class="cta-3 text-white">Deposit</div>
                        <div class="mb-3 cta-3 text-white">Start now!</div>
                        <div class="row gx-2">
                            <div class="col">
                                <div class="text-muted mb-3 mb-sm-0 pe-3 text-white">
                                    Hệ thống đang tiến hành kết nối ví thanh toán. Vui lòng không tắt trang đến khi thực hiện xong.<br/>
                                    Xin cảm ơn!
                                </div>
                            </div>
                            <div class="col-12 col-sm-auto d-flex align-items-center position-relative">
                                <button class="btn btn-warning mb-1" type="button" disabled="disabled">
                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                    Loading...
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        const CAMPAIGN_AMOUNT = '{{ $task->total_reward }}';
        const TASK_ID = '{{ $task->id }}';
        const REDIRECT_AFTER_DEPOSIT = '{{ route(TASK_LIST_ADMIN_ROUTER) }}';
    </script>
@endpush
