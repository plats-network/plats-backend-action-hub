@if(isset ($errors) && count($errors) > 0)
    <div class="items-center p-3.5 rounded text-danger bg-danger-light dark:bg-danger-dark-light" role="alert">
        @foreach($errors->all() as $error)
            <p class="ltr:pr-2 rtl:pl-2">{{$error}}</p>
        @endforeach
    </div>
@endif

@if(Session::get('success', false))
    <?php $data = Session::get('success'); ?>
    @if (is_array($data))
        @foreach ($data as $msg)
            <div class="alert alert-warning" role="alert">
                <i class="fa fa-check"></i>
                {{ $msg }}
            </div>
        @endforeach
    @else
        <div class="alert alert-warning" role="alert">
            <i class="fa fa-check"></i>
            {{ $data }}
        </div>
    @endif
@endif
