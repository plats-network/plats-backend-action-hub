<div class="mb-3 row itemBoothDetail" id="itemBooth{{$indexImageItem}}">
    <hr>
    <label class="col-sm-12 col-form-label">
        Booth {{$getInc}}<span class="text-danger" style="font-size: 11px;">(Note: Fields marked with * are required)</span>
    </label>
    <div class="row">
        <div class="col-lg-4 mb-2">
            <label class="col-form-label">Travel game</label>
            <select class="form-select" name="booths[detail][{{$indexImageItem}}][travel_game_id]">
                @foreach($travelGames as $game)
                    <option value="{{$game->id}}">{{$game->name}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-sm-4">
        <label class="col-form-label">Name <span class="text-danger fs-11">(*)</span></label>
        <input
            type="text"
            class="form-control"
            id="booths[detail][{{$indexImageItem}}][name]"
            name="booths[detail][{{$indexImageItem}}][name]"
            placeholder="Name {{$getInc}}"
            value="">
    </div>
    <div class="col-sm-4">
        <label class="col-form-label">Description <span class="text-danger fs-11">(optional)</span></label>
        <input
            type="text"
            class="form-control"
            id="booths[detail][{{$indexImageItem}}][description]"
            name="booths[detail][{{$indexImageItem}}][description]"
            placeholder="Describe {{$getInc}}"
            value="">
    </div>

    <div class="col-sm-4 mt-5">
        <input type="hidden" name="booths[detail][{{$indexImageItem}}][is_question]" value="0">
        <input
            class="form-check-input"
            data-id="{{$indexImageItem}}"
            type="checkbox" value="1"
            name="booths[detail][{{$indexImageItem}}][is_required]"
            id="br_{{$getInc}}">
        <label class="form-check-label" for="br_{{$getInc}}">
            Vip <span class="text-danger fs-11">(Yes/No)</span>
        </label>
    </div>
    <div class="row">
{{--        <div class="col-sm-8">--}}
{{--            <label class="col-form-label">Link NFT <span class="text-danger fs-11">(optional)</span></label>--}}
{{--            <input class="form-control" type="" name="booths[detail][{{$indexImageItem}}][nft_link]">--}}
{{--        </div>--}}
        <div class="col-sm-4">
            <label class="col-form-label">&nbsp;</label>
            <div class="col-auto">
                <button type="button" data-id="{{$indexImageItem}}" class="btn btn-danger mb-3 bRemove">Remove</button>
            </div>
        </div>
    </div>

    {{-- <div class="col-sm-12 text-right">
        <label class="col-form-label">&nbsp;</label>
        <div class="col-auto">
            <button type="button" data-id="{{$indexImageItem}}" class="btn btn-danger mb-3 bRemove">Remove</button>
        </div>
    </div> --}}
</div>
