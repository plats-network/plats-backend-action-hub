<div class="mb-3 row itemBoothDetail" id="itemBooth{{$indexImageItem}}">
    <label for="inputPassword" class="col-sm-2 col-form-label">Booth {{$getInc}}</label>
    <div class="col-sm-4">
        <input
            type="text"
            class="form-control"
            id="booths[detail][{{$indexImageItem}}][name]"
            name="booths[detail][{{$indexImageItem}}][name]"
            placeholder="Name {{$getInc}}"
            value="">
    </div>
    <div class="col-sm-4">
        <input
            type="text"
            class="form-control"
            id="booths[detail][{{$indexImageItem}}][description]"
            name="booths[detail][{{$indexImageItem}}][description]"
            placeholder="Description {{$getInc}}"
            value="">
    </div>
    <div class="col-sm-2">
        <div class="col-auto">
            <button type="button"
                data-id="{{$indexImageItem}}"
                onclick="deleteImageReform({{$indexImageItem}})"
                class="btn btn-danger mb-3 btnDeleteImageBooth">Xoá</button>
        </div>
    </div>
</div>
