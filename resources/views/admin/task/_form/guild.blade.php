<h2 class="small-title mt-3">Guilds</h2>
<div class="btn-group check-all-container mt-n1 d-none">
    <div class="btn btn-sm btn-outline-primary btn-custom-control" id="checkAllforCheckboxTable" data-target="#checkboxTable">
      <span class="form-check mb-0 pe-1">
        <input type="checkbox" class="form-check-input" id="checkAll" />
      </span>
    </div>
</div>
<div class="col-md-12">
    <section class="scroll-section" id="checkboxes">
        <div class="card mb-2 bg-transparent no-shadow d-none d-md-block sh-3">
            <div class="card-body pt-0 pb-0 h-100">
                <div class="row g-0 h-100 align-content-center">
                    <div class="col-md-3 text-muted text-small text-uppercase text-center">
                        NAME
                    </div>
                    <div class="col-md-2 text-muted text-small text-uppercase">
                        Area & Language
                    </div>
                    <div class="col-md-2 text-muted text-small text-uppercase">
                        Leader
                    </div>
                    <div class="col-md-2 text-muted text-small text-uppercase">
                        Type
                    </div>
                    <div class="col-md-2 text-muted text-small text-uppercase">
                        Description
                    </div>
                </div>
            </div>
        </div>
        <div class="scroll-out">
            <div class="scroll-by-count" data-count="3" id="checkboxTable">
                @foreach($guilds as $guild)
                <div class="card mb-2">
                    <div class="card-body h-100 pt-2 pb-2">
                        <div class="row">
                            <div class="col-3 col-md-1 px-0 ">
                                <div class="sw-12 me-1 mb-1">
                                    <img src="{{ $guild['avatar'] }}" class="img-fluid rounded-md sh-7 sw-10"
                                         alt="thumb">
                                </div>
                            </div>
                            <div class="col-9 col-md-2 d-flex flex-column justify-content-center mb-3 mb-md-0">
                                <div class="text-muted text-small text-uppercase d-md-none">Name</div>
                                <h5>{{ $guild['name'] }}</h5>
                                <div class="text-muted text-small">{{ rand(100, 9999) }} Members</div>
                            </div>
                            <div class="col-6 col-md-2 d-flex flex-column justify-content-center">
                                <div class="text-muted text-small text-uppercase d-md-none">Area</div>
                                <div class="text-alternate ">
                                    {{ $guild['area'] }} - {{ $guild['language'] }}
                                </div>
                            </div>
                            {{--<div class="col-3 col-md-1 d-flex flex-column justify-content-center">
                                <div class="text-muted text-small text-uppercase d-md-none">Language</div>
                                <div class="text-alternate">
                                    {{ $guild['language'] }}
                                </div>
                            </div>--}}
                            <div class="col-6 col-md-2 d-flex flex-column justify-content-center">
                                <div class="text-muted text-small text-uppercase d-md-none">Leader</div>
                                <div class="fw-bold">{{ $guild['leader'] }}</div>
                            </div>
                            <div class="col-12 col-md-2 my-2 my-mb-0 d-flex flex-column justify-content-center">
                                <div class="text-muted text-small text-uppercase d-md-none">Type</div>
                                <div class="text-alternate">
                                    {{ $guild['type'] }}
                                </div>
                            </div>
                            <div class="col-12 col-md-2 d-flex flex-column justify-content-center">
                                <div class="text-muted text-small text-uppercase d-md-none">Description</div>
                                <div class="text-alternate">
                                    {{ $guild['description'] }}
                                </div>
                            </div>
                            <div class="col-1 d-flex flex-column justify-content-center">
                                <label class="form-check custom-icon mb-0">
                                    <input type="checkbox" class="form-check-input" name="guilds[]" value="1"/>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
</div>
