<div class="col-lg-3">
    <div class="card card-outline-info">
    <div class="card-header">
            <h4 class="m-b-0 text-white">Time: <div id="countdown"></div></h4>
        </div>
        <hr class="m-t-0 m-b-40">
       
        <div class="card-body">
            <div class="form-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group row">
                            <div class="col-md-12">
                                @for ($i = 1; $i <= $data['totoalques']; $i++)
                                    <div class="quesnumresult quesnum{{ $i }}" data-id="{{ $i }}">{{ $i }}</div>
                                @endfor
                        </div>
                        </div>
                    </div>
                    
                </div>
                <!--/row-->
            </div>
        </div>
    </div>
</div>