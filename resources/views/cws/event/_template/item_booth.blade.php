<div class="mb-3 row itemBoothDetail" id="itemImage{{$indexImageItem}}">

    <label for="inputPassword" class="col-sm-2 col-form-label">Booth {{$getInc}}</label>
    <div class="col-sm-4">
        {{--name--}}
        <input type="text" class="form-control" id="booths[detail][{{$indexImageItem}}][name]" name="booths[detail][{{$indexImageItem}}][name]" value="">
    </div>
    <div class="col-sm-4">
        {{--description--}}
        <input type="text" class="form-control" id="booths[detail][{{$indexImageItem}}][description]" name="booths[detail][{{$indexImageItem}}][description]" value="">
    </div>
    <div class="col-sm-2">
        {{--Button delete--}}
        <div class="col-auto">
            <button type="button" data-id="{{$indexImageItem}}" onclick="deleteImageReform({{$indexImageItem}})"  class="btn btn-danger mb-3 btnDeleteImageBooth">Xoá</button>
        </div>
    </div>
</div>
