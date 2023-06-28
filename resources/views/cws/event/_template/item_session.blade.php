<div class="mb-3 row itemSessionDetail" id="itemImage{{$indexImageItem}}">
    <label for="inputPassword" class="col-sm-2 col-form-label">Session {{$getInc}}</label>
    <div class="col-sm-4">
        <input
            type="text"
            class="form-control"
            id="sessions[detail][{{$indexImageItem}}][name]"
            name="sessions[detail][{{$indexImageItem}}][name]"
            placeholder="Name {{$getInc}}"
            value="">
    </div>
    <div class="col-sm-4">
        <input
            type="text"
            class="form-control"
            id="sessions[detail][{{$indexImageItem}}][description]"
            name="sessions[detail][{{$indexImageItem}}][description]"
            placeholder="Description {{$getInc}}"
            value="">
    </div>
    <div class="col-sm-2">
        <div class="col-auto">
            <button
                type="button"
                data-id="{{$indexImageItem}}"
                onclick="deleteImageReform({{$indexImageItem}})"
                class="btn btn-danger mb-3 btnDeleteImage">Xoá</button>
        </div>
    </div>
</div>
