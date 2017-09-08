<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                @if ($key)
                  <div class="panel-body">
                    You Account has been verified
                </div>
                @else
                     <div class="panel-body">
                    You token has been expired
                </div>
                @endif
              
            </div>
        </div>
    </div>
</div>
