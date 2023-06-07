<div class="mb-3 row itemSessionDetail" id="itemImage{{$indexImageItem}}">

    <label for="inputPassword" class="col-sm-2 col-form-label">Session {{$getInc}}</label>
    <div class="col-sm-4">
        {{--name--}}
        <input type="text" class="form-control" id="sessions[detail][{{$indexImageItem}}][name]" name="sessions[detail][{{$indexImageItem}}][name]" value="">
    </div>
    <div class="col-sm-4">
        {{--description--}}
        <input type="text" class="form-control" id="sessions[detail][{{$indexImageItem}}][description]" name="sessions[detail][{{$indexImageItem}}][description]" value="">
    </div>
    <div class="col-sm-2">
        {{--Button delete--}}
        <div class="col-auto">
            <button type="button" data-id="{{$indexImageItem}}" onclick="deleteImageReform({{$indexImageItem}})"  class="btn btn-danger mb-3 btnDeleteImage">Xoá</button>
        </div>
    </div>
</div>
