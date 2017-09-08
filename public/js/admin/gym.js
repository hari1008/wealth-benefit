(function () {
  var cloneBeacon = function(){
    $(".beacon-group").append('<div class=beacon-grp><div class=row><div class=col-sm-4><div class=form-group2><input class=form-control name=website_link></div></div><div class=col-sm-4><div class=form-group2><input class=form-control name=website_link></div></div><div class=col-sm-4><div class=form-group2><input class=form-control name=website_link></div></div></div><div class="del-beacon">&times;</div></div>');
  }

  $('#add-beacon-btn').on('click', function() {
       cloneBeacon();
  });


  $('body').on('click', '.del-beacon', function() {
      $(this).parent('.beacon-grp ').remove();
  });


})();
