$('.slideBanner .divButton input').click(function(e){
  $('.slideBanner .divButton input').removeClass('selected');
  $(this).addClass('selected');
  if($(this).hasClass('desktop')){
    $('.divGrid .mobile').css('display','none');
    $('.divGrid .desktop').css('display','table');
    $('.divImageViewer .formType').val('pc');
  }else{
    $('.divGrid .desktop').css('display','none');
    $('.divGrid .mobile').css('display','table');
    $('.divImageViewer .formType').val('m');
  }
});

var loadFile = function(event) {
  var output = document.getElementById('output');
  output.src = URL.createObjectURL(event.target.files[0]);
};

$('.divGrid .delete').click(function(e){
  var id = $(this).prev().prev().prev().prev().val();
  $('.divImageViewer .formID').val(id);
  if(!confirm('정말 삭제하시겠습니까?')){
    return false;
  }
  $.ajax({
        type:"POST",
        url:"/admin/slideBannerDelete",
        data : {
          id : id
        },
        dataType : "json",
        success: function(res){
          console.log(res);
          location.href="";
        },
        error: function(xhr, status, error) {
          console.log(error);
          alert('삭제 중 문제가 발생했습니다.\n계속 문제가 발생하면\n담당자에게 문의해주세요.');
          location.href="";
        }
    });

});

$('.divGrid .modify').click(function(e){
  var id = $(this).prev().val();
  $('.divImageViewer img').attr('src','');
  $('.divImageViewer input[type="file"]').val('');
  $('.divImageViewer .formID').val(id);
  $('.divImageViewer .formMode').val('modify');
  $('.divImageViewer').fadeIn();
  $('.divImageViewerBG').fadeIn();
});

$('.divGrid .add').click(function(e){
  $('.divImageViewer img').attr('src','');
  $('.divImageViewer input[type="file"]').val('');
  $('.divImageViewer .formID').val('');
  $('.divImageViewer .formMode').val('add');
  $('.divImageViewer').fadeIn();
  $('.divImageViewerBG').fadeIn();
});

$('.divImageViewerBG').click(function(e){
  $('.divImageViewer').fadeOut();
  $('.divImageViewerBG').fadeOut();
});

$('.divImageViewer input[type="submit"]').click(function(e){
  if($('.divImageViewer input[type="file"]').val() == ""){
    return false;
  }
});
