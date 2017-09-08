
    <div class="modal fade" id="map_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <div class="modal_inner_content clearfix">
                    <div class="col-md-12 text-center pd-lr-20">
                        <div class="panel_heading">Location</div>
                    </div>
                    <div class="col-md-12 map_outer clearfix mr-b-35">
                        <div class="map_sec">
                            <input id="pac-input" class="form-control search_input" type="text" placeholder="Search">
                            <input type="hidden" name="modal_lat" id="modal_lat">
                            <input type="hidden" name="modal_lng" id="modal_lng">
                            <div id="map" style="height: 400px;"></div>
                        </div>
                    </div>
                    <div class="col-md-12 pd-lr-20">
                        <div class="col-md-12 pd-lr-20 text-center">
                            <a class="btn btn-default mr-b-35" id="set_location">Done</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    